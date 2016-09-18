<?php

namespace Ptrml\Polynotice;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

/**
 * Created by PhpStorm.
 * User: pepo123
 * Date: 9/15/16
 * Time: 2:30 PM
 */
class Polynotice
{
    /**
     * Subscribe every user to event
     * @param $event
     */
    public static function subscribePublicTo($event)
    {
        DB::table('polynotice_subs')->insert([
            'event' => $event,
            'user_id' => null
        ]);
    }

    /**
     * Unsubscribe public from event
     * @param $event
     */
    public static function unsubscribePublicFrom($event)
    {
        DB::table('polynotice_subs')->where('user_id','=',null)->andWhere('polynotice_subs.event','=',$event)->delete();
    }

    /**
     * Subscribe a given user to event
     * @param $event
     * @param null $user_id if null subscribe self
     */
    public static function subscribeTo($event, $user_id = null)
    {
        if(is_null($user_id)) {
            $user_id = static::getLoggedInUserId();
        }

        DB::table('polynotice_subs')->insert([
            'event' => $event,
            'user_id' => $user_id
        ]);
        
    }

    /**
     * Unsubscribe public from event
     * @param $event
     */
    public static function unsubscribeFrom($event, $user_id = null)
    {
        if(is_null($user_id)) {
            $user_id = static::getLoggedInUserId();
        }

        DB::table('polynotice_subs')->where('user_id','=',$user_id)->andWhere('polynotice_subs.event','=',$event)->delete();
    }

    /**
     * Returns an array of events a user is subscribed to (strings)
     * @param null $user_id
     * @return array
     */
    public static function listPrivateSubscriptions($user_id = null)
    {
        if(is_null($user_id)) {
            $user_id = static::getLoggedInUserId();
        }

        $query = DB::table('polynotice_subs')->where('user_id','=',$user_id)->pluck('event')->toArray();
        //DB Query to polynotice table
                
        

        return $query;
    }

    /**
     * Returns an array of events the public is subscribed to
     * @return mixed
     */
    public static function listPublicSubscriptions()
    {
        $query = DB::table('polynotice_subs')->where('user_id','=',null)->pluck('event')->toArray();

        return $query;
    }

    /**
     * Returns users subscribed to said event
     * can return users subscribed to a parent event
     * example: Users subscribed to categories:tools are also subscribed to categories:tools:power_tools and also to categories:tools:power_tools:electric
     * So if a new categories:tools:power_tools:electric is inserted all of them will be notified
     *
     * @param $event
     * @param bool $subs_to_parents
     * @return mixed
     */
    public static function listSubscriberIds($event, $include_subs_to_parents=false)
    {

        //TODO config
        if($include_subs_to_parents)
            $events = static::getEventParents($event);
        else
            $events[]=$event;

        $query = DB::table('polynotice_subs');

        foreach ($events as $tmpevent)
        {
            $query = $query->orWhere('polynotice_subs.event','=',$tmpevent);
        }

        $results = array_unique($query->pluck('user_id')->toArray());

        if(in_array(null,$results))
            return ['*'];

        return $results;

    }

    public static function listSubscribers($event, $include_subs_to_parents=false)
    {
        $subids = static::listSubscriberIds($event, $include_subs_to_parents);

        if(in_array('*',$subids))
            return User::all();
        else
            return User::findMany($subids);
    }


    /**
     * Pushes message to redis
     * example: Users subscribed to categories:tools are also subscribed to categories:tools:power_tools and also to categories:tools:power_tools:electric
     * So if a new categories:tools:power_tools:electric is inserted all of them will be notified
     *
     * @param NoticeableInterface $notice
     */
    public static function publish($event,NoticeableInterface $notice)
    {
        //TODO config


        $tmp = new \stdClass();
        $tmp->event = $event;
        $tmp->recipients = static::listSubscriberIds($event,true);
        $tmp->data = $notice->toJson();

        Redis::publish("polynotice",json_encode($tmp));
    }

    /**
     * Fetch the logged in user id
     * @return integer
     */
    public static function getLoggedInUserId()
    {
        return auth()->id();
    }

    /**
     * Returns array of events parents
     *
     * @param $event
     * @return array
     */
    public static function getEventParents($event)
    {
        $events = array();

        $tmp_events = explode('::',$event);

        $events_size = count($tmp_events)-1;
        while($events_size >= 0  )
        {
            $events[] = implode('::',$tmp_events);

            array_pull($tmp_events,$events_size);

            $events_size-=1;
        }

        return $events;
    }

}
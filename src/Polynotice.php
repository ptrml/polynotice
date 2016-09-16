<?php

namespace Ptrml\Polynotice;
use Illuminate\Support\Facades\Redis;

/**
 * Created by PhpStorm.
 * User: pepo123
 * Date: 9/15/16
 * Time: 2:30 PM
 */
class Polynotice
{
    private $channel = "polynotice";

    /**
     * Subscribe every user to event
     * @param $event
     */
    public static function subscribePublicTo($event)
    {

    }

    /**
     * Subscribe a given user to event
     * @param $event
     * @param null $user_id if null subscribe self
     */
    public static function subscribeTo($event, $user_id = null)
    {
        $event = "categories:tools:power_tools";
        
        //
        
    }

    /**
     * @param null $user_id
     * @return array
     */
    public static function listSubscriptions($user_id = null)
    {
        if(is_null($user_id)) {
            $user_id = static::getLoggedInUserId();
        }
        
        
        //DB Query to polynotice table
                
        

        return array();
    }



    public static function publish(NoticeableInterface $notice)
    {
        Redis::publish($notice->getEvent(),$notice->toJson());
    }

    /**
     * Fetch the logged in user id
     * @return integer
     */
    public static function getLoggedInUserId()
    {
        return auth()->id();
    }
}
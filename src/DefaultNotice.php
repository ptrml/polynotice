<?php
/**
 * Created by PhpStorm.
 * User: pepo123
 * Date: 9/15/16
 * Time: 4:52 PM
 */

namespace Ptrml\Polynotice;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DefaultNotice extends Model implements NoticeableInterface
{

    protected $from_user_id;
    protected $type;
    protected $title;
    protected $content;
    protected $action;
    protected $icon;

    protected $table = 'polynotice_defaultnotice';
    /**
     * DefaultNotice constructor.
     * @param $event
     */
    public function __construct($title = null,$content = null)
    {
        $this->from_user_id = static::getLoggedInUserId();
        $this->title = $title;
        $this->content = $content;
        $this->type =  "message";
        $this->action = "http://google.com";
        $this->icon = "http://icons.iconarchive.com/icons/martz90/circle/128/chrome-icon.png";

        parent::__construct();
    }


    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    public static function getLoggedInUserId()
    {
        return auth()->id();
    }

    /**
     * Returns a json of the data to be sent
     * @return string
     */
    function jsonify()
    {

        $obj = new \stdClass();

        $obj->from_user_id = $this->from_user_id;
        $obj->type = $this->type;;
        $obj->title = $this->title;
        $obj->content = $this->content;
        $obj->action = $this->action;
        $obj->icon = $this->icon;

        return json_encode($obj);
    }


    /**
     * Save to database, empty if notification is temporary
     * @return null
     */
    function save_db($user_id)
    {
        //MAKING SURE THE JSON E THE DB ARE SAME
        $checker = json_decode($this->jsonify(),true);
        foreach ($checker as $key=>$value)
        {
            $this->__set($key,$value);
        }
        $this->__set("user_id",$user_id);
        $this->__set("seen",false);


        $this->save();
    }



}
<?php
/**
 * Created by PhpStorm.
 * User: pepo123
 * Date: 9/15/16
 * Time: 4:52 PM
 */

namespace Ptrml\Polynotice;


use Illuminate\Support\Facades\Auth;

class DefaultNotice implements NoticeableInterface
{
    private $event;
    private $user_id;
    private $title;
    private $message;

    /**
     * DefaultNotice constructor.
     * @param $event
     */
    public function __construct($event,$title = null,$message = null)
    {
        $this->event = $event;
        $this->user_id = auth()->id();
        $this->title = $title;
        $this->message = $message;
    }


    function getEvent()
    {
        return $this->event;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
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
    public function getMessage()
    {
        return $this->message;
    }


    /**
     * Form JSON string from your model
     * @return string
     */
    function toJson()
    {
        return json_encode(get_object_vars($this));
    }

    public function setEvent($event)
    {
        $this->event = $event;
    }
}
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

    private $user_id;
    private $title;
    private $message;

    /**
     * DefaultNotice constructor.
     * @param $event
     */
    public function __construct($title = null,$message = null)
    {
        $this->user_id = auth()->id();
        $this->title = $title;
        $this->message = $message;
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
     * Returns a json of the data to be sent
     * @return string
     */
    function toJson()
    {
        return json_encode(get_object_vars($this));
    }
}
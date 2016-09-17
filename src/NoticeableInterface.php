<?php
/**
 * Created by PhpStorm.
 * User: pepo123
 * Date: 9/15/16
 * Time: 4:46 PM
 */

namespace Ptrml\Polynotice;


interface NoticeableInterface
{

    function getEvent();

    /**
     * Form JSON string from your model
     * @return string
     */
    function toJson();

    public function setEvent($event);
}
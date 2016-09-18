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

    /**
     * Returns a json of the data to be sent
     * @return string
     */
    function toJson();

}
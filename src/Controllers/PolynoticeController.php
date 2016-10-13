<?php


namespace ptrml\polynotice\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ptrml\Polynotice\DefaultNotice;

/**
 * Created by PhpStorm.
 * User: pepo123
 * Date: 10/9/16
 * Time: 12:51 PM
 */
class PolynoticeController extends Controller
{


    public static function getUnseenNotices()
    {
        $user_id = static::getLoggedInUserId();

        $nots = DefaultNotice::where('user_id',$user_id)->get();
        return $nots;
    }

    public static function seeNotice(Request $request)
    {
        $notice_id = $request->input("id");
        $user_id = static::getLoggedInUserId();

        $notice = DefaultNotice::where('user_id',$user_id)->where('id',$notice_id)->first();

        $notice->seen = true;

        $notice->save();

        return ;
    }

    public static function getLoggedInUserId()
    {
        return auth()->id();
    }
}
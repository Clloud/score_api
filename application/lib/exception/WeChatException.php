<?php
/**
 * Created by PhpStorm.
 * User: Clloud
 * Date: 2018/6/7
 * Time: 19:07
 */

namespace app\lib\exception;


class WeChatException extends BaseException
{
    public $code = 400;
    public $msg = '微信服务器接口调用失败';
    public $errorCode = 999;
}
<?php
/**
 * Created by PhpStorm.
 * User: Clloud
 * Date: 2018/6/7
 * Time: 19:07
 */

namespace app\lib\exception;


class UserException extends BaseException
{
    public $code = 404;
    public $msg = '用户不存在';
    public $errorCode = 60000;
}
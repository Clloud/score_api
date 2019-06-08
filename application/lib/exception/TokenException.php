<?php
/**
 * Created by PhpStorm.
 * User: Clloud
 * Date: 2018/6/7
 * Time: 19:07
 */

namespace app\lib\exception;


class TokenException extends BaseException
{
    public $code = 401;
    public $msg = 'Token已过期或无效Token';
    public $errorCode = 10001;
}
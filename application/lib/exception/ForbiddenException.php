<?php
/**
 * Created by PhpStorm.
 * User: Clloud
 * Date: 2018/6/7
 * Time: 19:07
 */

namespace app\lib\exception;


class ForbiddenException extends BaseException
{
    public $code = 403;
    public $msg = '权限不够';
    public $errorCode = 10001;
}
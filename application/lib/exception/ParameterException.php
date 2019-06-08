<?php
/**
 * Created by PhpStorm.
 * User: Clloud
 * Date: 2018/6/7
 * Time: 19:07
 */

namespace app\lib\exception;


class ParameterException extends BaseException
{
    public $code = 400;
    public $msg = '参数错误';
    public $errorCode = 10000;
}
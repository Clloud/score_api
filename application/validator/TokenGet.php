<?php
/**
 * Created by PhpStorm.
 * User: Clloud
 * Date: 2019/6/8
 * Time: 8:53
 */

namespace app\validator;


class TokenGet extends BaseValidate
{
    protected $rule = [
        'code' => 'require|isNotEmpty'
    ];

    protected $message = [
        'code' => 'code错误或缺失'
    ];
}
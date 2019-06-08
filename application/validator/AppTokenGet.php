<?php
/**
 * Created by PhpStorm.
 * User: Clloud
 * Date: 2019/6/8
 * Time: 8:53
 */

namespace app\validator;


class AppTokenGet extends BaseValidate
{
    protected $rule = [
        'account' => 'require|isNotEmpty',
        'secret' => 'require|isNotEmpty'
    ];
}
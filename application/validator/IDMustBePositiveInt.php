<?php
/**
 * Created by PhpStorm.
 * User: Clloud
 * Date: 2019/6/8
 * Time: 8:53
 */

namespace app\validator;


class IDMustBePositiveInt extends BaseValidate
{
    protected $rule = [
        'id' => 'require|isPositiveInteger',
    ];


    protected $message=[
        'id' => 'id必须是正整数'
    ];
}
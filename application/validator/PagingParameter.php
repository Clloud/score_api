<?php
/**
 * Created by PhpStorm.
 * User: Clloud
 * Date: 2019/6/8
 * Time: 8:53
 */

namespace app\validator;


class PagingParameter extends BaseValidate
{
    protected $rule = [
        'page' => 'isPositiveInteger',
        'size' => 'isPositiveInteger'
    ];

    protected $message = [
        'page' => '分页参数必须是正整数',
        'size' => '分页参数必须是正整数'
    ];
}
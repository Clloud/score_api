<?php
/**
 * Created by PhpStorm.
 * User: Clloud
 * Date: 2019/6/8
 * Time: 8:53
 */

namespace app\validator;


use app\lib\exception\ParameterException;
use think\Request;
use think\Validate;

class BaseValidate extends Validate{
    public function goCheck()
    {
        // 获取http传入的参数
        $request = Request::instance();
        $params = $request->param();

        // 对这些参数做检验
        $result = $this->batch()->check($params);
        if (!$result) {
            $e = new ParameterException([
                'msg' => $this->error,
            ]);
            throw $e;
        }
        else {
            return true;
        }
    }

    /*校验规则：判断是否为正整数*/
    protected function isPositiveInteger($value)
    {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        }
        else {
            return false;
        }
    }

    /*校验规则：判断是否为空*/
    protected function isNotEmpty($value)
    {
        if (empty($value)) {
            return false;
        }
        else {
            return true;
        }
    }

    /*校验规则：判断手机号码是否合法*/
    protected function isMobile($value)
    {
        $rule = '^1(3|4|5|7|8)[0-9]\d{8}$^';
        $result = preg_match($rule, $value);
        if ($result) {
            return true;
        }
        else {
            return false;
        }
    }

    /*根据校验规则获取传递的值*/
    public function getDataByRule($arrays)
    {
        if (array_key_exists('user_id', $arrays) |
            array_key_exists('uid', $arrays)
        )
        {
            // 不允许包含user_id或者uid，防止恶意覆盖user_id外键
            throw new ParameterException(
                [
                    'msg' => '参数中包含有非法的参数名user_id或者uid'
                ]);
        }

        $newArray = [];

        foreach ($this->rule as $key => $value) {
            $newArray[$key] = $arrays[$key];
        }
        return $newArray;
    }
}
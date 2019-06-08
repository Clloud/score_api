<?php
/**
 * Created by PhpStorm.
 * User: Clloud
 * Date: 2019/6/7
 * Time: 17:57
 */

namespace app\model;


use app\model\BaseModel;

class User extends BaseModel
{
    /*根据openid获取指定用户*/
    public static function getByOpenID($openid){
        $user = self::where('openid', '=', $openid)
            ->find();
        return $user;
    }
}
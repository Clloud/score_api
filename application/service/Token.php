<?php
/**
 * Created by PhpStorm.
 * User: Clloud
 * Date: 2019/6/7
 * Time: 19:01
 */

namespace app\service;


use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
use app\lib\exception\TokenException;
use think\Cache;
use think\Exception;
use think\Request;

/* 基类，用于存放操作Token的公共方法 */
class Token
{
    /* 生成令牌 */
    public static function generateToken()
    {
        //32个字符组成一组随机字符串
        $randChars = getRandChar(32);
        //用三组字符串，进行md5加密
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        //salt 盐
        $salt = config('secure.token_salt');

        return md5($randChars . $timestamp . $salt);
    }

    /* 获取指定key的token值 */
    public static function getCurrentTokenVar($key){
        $token = Request::instance()->header('token');
        $vars = Cache::get($token);
        if (!$vars) {
            throw new TokenException();
        }
        else {
            if (!is_array($vars)){
                $vars = json_decode($vars, true);
            }
            if (array_key_exists($key, $vars)) {
                return $vars[$key];
            }
            else {
                throw new Exception('尝试获取的Token变量不存在');
            }
        }
    }

    /*从缓存中获取用户uid*/
    public static function getCurrentUid(){
        $uid = self::getCurrentTokenVar('uid');
        return $uid;
    }

    /*校验令牌有效性*/
    public static function verifyToken($token)
    {
        $exist = Cache::get($token);
        if($exist){
            return true;
        }
        else{
            return false;
        }
    }


    /*用户和管理员都可以访问的权限*/
    public static function needPrimaryScope() {
        $scope = self::getCurrentTokenVar('scope');
        if ($scope) {
            if ($scope >= ScopeEnum::User) {
                return true;
            }
            else {
                throw new ForbiddenException();
            }
        }
        else {
            throw new TokenException();
        }
    }

    /*只有用户才能访问的接口权限*/
    public static function needExclusiveScope()
    {
        $scope = self::getCurrentTokenVar('scope');
        if ($scope) {
            if ($scope == ScopeEnum::User) {
                return true;
            }
            else {
                throw new ForbiddenException();
            }
        }
        else {
            throw new TokenException();
        }
    }


    /*只有管理员可以访问的权限*/
    public static function needAdminScope()
    {
        $scope = self::getCurrentTokenVar('scope');
        if ($scope) {
            if ($scope == ScopeEnum::Super) {
                return true;
            }
            else {
                throw new ForbiddenException();
            }
        }
        else {
            throw new TokenException();
        }
    }

    /**
     * 对外接口：检验当前操作与用户身份是否匹配
     * @throws Exception
     */
    public static function isValidOperate($checkedUID){
        if (!$checkedUID) {
            throw new Exception('检查UID时必须传入UID');
        }
        $currentOperateUID = self::getCurrentUid();
        if ($currentOperateUID == $checkedUID) {
            return true;
        }
        return false;
    }
}
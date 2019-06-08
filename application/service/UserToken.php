<?php
/**
 * Created by PhpStorm.
 * User: Clloud
 * Date: 2019/6/7
 * Time: 19:03
 */

namespace app\service;


use app\model\User as UserModel;
use app\lib\enum\ScopeEnum;
use app\lib\exception\WeChatException;

class UserToken extends Token
{
    protected $code;
    protected $wxAppID;
    protected $wxAppSecret;
    protected $wxLoginUrl;

    function __construct($code)
    {
        $this->code = $code;
        $this->wxAppID = config('wx.app_id');
        $this->wxAppSecret = config('wx.app_secret');
        $this->wxLoginUrl = sprintf(
            config('wx.login_url'),
            $this->wxAppID, $this->wxAppSecret, $this->code);
    }


    /*发送wx.login请求，获取返回信息，生成令牌*/
    public function get(){
        $result = curl_get($this->wxLoginUrl);
        $wxResult = json_decode($result, true);

        if (empty($wxResult))
        {
            throw new Exception('获取session_key及openID时异常，微信内部错误');
        }
        else
        {
            $loginFail = array_key_exists('errcode', $wxResult);
            if ($loginFail)
            {
                $this->processLoginError($wxResult);
            }
            else
            {
                return $this->grantToken($wxResult);
            }
        }
    }

    /**
     *处理未成功获取openid的情况
     * @throws WeChatException
     */
    private function processLoginError($wxResult){
        throw new WeChatException([
            'msg' => $wxResult['errmsg'],
            'errorCode' => $wxResult['errcode']
        ]);
    }


    /*生成令牌*/
    private function grantToken($wxResult){
        /* 处理流程
         * 拿到openid
         * 查询数据库，这个openid是不是已经存在
         * 如果存在 则不处理，如果不存在那么新增一条user记录
         * 生成令牌，准备缓存数据，写入缓存
         * 把令牌返回到客户端
         * 缓存-key: 令牌
         *  value: wxResult，uid, scope
         */
        $openid = $wxResult['openid'];
        $user = UserModel::getByOpenID($openid);
        if ($user){
            $uid = $user->id;
        }
        else{
            $uid = $this->newUser($openid);
        }
        $cachedValue = $this->prepareCacheValue($wxResult, $uid);
        $token = $this->saveToCache($cachedValue);
        return $token;
    }

    /* 创建新用户*/
    private function newUser($openid){
        $user = UserModel::create([
            'openid' => $openid
        ]);
        return $user->id;
    }

    /* 准备缓存数据 */
    private function prepareCacheValue($wxResult, $uid){
        $cachedValue = $wxResult;
        $cachedValue['uid'] = $uid;
        $cachedValue['scope'] = ScopeEnum::User;
        return $cachedValue;
    }

    /* 存入缓存，返回缓存键值（token）*/
    private function saveToCache($cacheValue){
        $key = self::generateToken();
        $value = json_encode($cacheValue);
        $expire_in = config('setting.token_expire_in');

        $request = cache($key, $value, $expire_in); //写入缓存
        if(!$request){
            throw new TokenException([
                'msg' => '服务器缓存异常',
                'errorCode' => 10005
            ]);
        }
        return $key;
    }

}
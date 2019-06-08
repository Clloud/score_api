<?php
/**
 * Created by PhpStorm.
 * User: Clloud
 * Date: 2019/6/7
 * Time: 19:49
 */

namespace app\api\controller\v1;

use app\validator\TokenGet;
use app\service\UserToken;
use app\lib\exception\ParameterException;
use app\service\Token as TokenService;

class Token
{
    /**
     * 根据小程序发送的code获取token
     * @url /token/user
     * @http POST
     * @params code 用户身份码
     * @throws
     */
    public function getToken($code=''){
        (new TokenGet())->goCheck();
        $userToken = new UserToken($code);
        $token = $userToken->get();
        return [
            'token' => $token
        ];
    }

    /**
     * 检验token有效性
     * @url /token/verify
     * @http POST
     * @params token 用户令牌
     * @throws
     */
    public function verifyToken($token='')
    {
        if(!$token){
            throw new ParameterException([
                'token不允许为空'
            ]);
        }
        $valid = TokenService::verifyToken($token);
        return [
            'isValid' => $valid
        ];
    }

}
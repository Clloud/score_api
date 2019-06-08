<?php
/**
 * Created by PhpStorm.
 * User: Clloud
 * Date: 2019/6/8
 * Time: 13:01
 */

namespace app\api\controller\v1;

use app\model\User as UserModel;
use app\lib\exception\SuccessMessage;
use app\service\Token as TokenService;


class User
{
    /**
     * 获取已登录用户信息
     * @url /user
     * @http GET
     * @throws
     */
    public function getUser(){
        $uid = TokenService::getCurrentUid();
        $user = UserModel::get($uid);
        return [
            'id' => $user['id'],
            'nickName' => $user['nickname'],
            'avatar_url' => $user['avatar_url'],
        ];
    }

    /**
     * 新增用户/保存用户信息
     * @url /user
     * @http POST
     * @throws
     */
    public function addOrUpdateUser(){
        $uid = TokenService::getCurrentUid();
        $user = UserModel::get($uid);

        $params = input('post.');
        $user->nickname = $params['nickName'];
        $user->avatar_url = $params['avatarUrl'];

        $user->save();

        return json(new SuccessMessage(),201);
    }
}
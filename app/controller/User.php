<?php
/**
 * Created by PhpStorm.
 * User: TEM
 * Date: 2019/4/19
 * Time: 14:59
 */

namespace app\controller;


use app\model\UserModel;

class User extends Base
{
public function get_user_information($user){
    $user_model = new UserModel();
    $user_model->get_user_information($user);
}
public function user(){

}
}
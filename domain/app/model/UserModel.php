<?php
/**
 * Created by PhpStorm.
 * User: TEM
 * Date: 2019/4/19
 * Time: 14:54
 */

namespace app\model;

use fast_php\base\Model;
use fast_php\db\Db;
use PDOException;
use PDO;


class UserModel extends Model
{
    protected $table = 'user';

//查询个人信息
    public function get_user_information($user_name)
    {
        $sql = "select user_id,user_name,status,email,resume,phone_num,register_time,login_time,login_ip,all_domain from user where user_name = :user_name;";
        $stmt = Db::pdo()->prepare($sql);      //注入sql预读
        $stmt->bindParam(':user_name', $user_name, PDO::PARAM_STR, 24);  //绑定
        $stmt->execute();//执行
        return $stmt->fetch();
    }

//注册
    public function add_user($user)
    {
        $sql = "insert into user(user_name,user_password,status,email,phone_num,register_time) values(?,?,?,?,?,?);";
        $status = 1;
        $date = date('Y:m:d h:i:s');
        $stmt = Db::pdo()->prepare($sql);
        $stmt->bindParam(1, $user['user_name']);
        $stmt->bindParam(2, $user['user_password']);
        $stmt->bindParam(3, $status);
        $stmt->bindParam(4, $user['email']);
        $stmt->bindParam(5, $user['phone_num']);
        $stmt->bindParam(6, $date);
        $result = $stmt->execute();
        return $result;
    }

//删除
    public function delete()
    {

    }

//登陆
    public function login($user_name, $user_password)
    {
        $sql = "select user_name,user_id from user where user_name = :user_name and user_password = :user_password";
        $stmt = Db::pdo()->prepare($sql);
        $stmt->bindParam(':user_name', $user_name, PDO::PARAM_STR, 25);
        $stmt->bindParam(':user_password', $user_password, PDO::PARAM_STR, 25);
        $stmt->execute();
        return $stmt->fetch();
    }

//修改资料
    public function update($user)
    {
        $sql = "update user set user_name = :user_name ,email = :email,phone_num = :phone_num where user_id = :user_id";
        $stmt = Db::pdo()->prepare($sql);
        $stmt->bindParam(':user_id', $user['user_id'], PDO::PARAM_STR, 25);
        $stmt->bindParam(':user_name', $user['user_name'], PDO::PARAM_STR, 50);
        $stmt->bindParam(':email', $user['email'], PDO::PARAM_STR, 25);
        $stmt->bindParam(':phone_num', user['phone_num'], PDO::PARAM_STR, 25);
        $stmt->execute();
        return true;
    }

//登陆记录
    public function set_login_log($ip, $user_id)
    {
        $date = date("Y-m-d h:i:s");
//    $sql = 'update user set login_ip = \''. $ip . '\' and login_time =  $date  where user_name = $user_name';
        $sql = "update user set login_ip = '{$ip}' , login_time = '{$date}'  where user_id = '{$user_id}'";
        $result = Db::pdo()->exec($sql);
        return $result;
    }

//添加域名id
    public function add_domain_id($id, $user_id)
    {
        $sql = "select all_domain from user where user_id =:user_id";
        $stmt = Db::pdo()->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $result = $stmt->fetch();
        $array = explode(',', $result['all_domain']);
        array_push($array, $id);
        $all_id = implode(',',$array);
        $sql = "update user set all_domain = '{$all_id}'where user_id = '{$user_id}'";
        $result = Db::pdo()->exec($sql);
        return $result;
    }
}
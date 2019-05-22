<?php
/**
 * Created by PhpStorm.
 * User: TEM
 * Date: 2019/5/14
 * Time: 8:54
 */

namespace app\model;


use fast_php\db\Db;

class AccountModel
{
    protected $table = "account";

//查找账号的子账号
    public function get_user_accounts($user_id)
    {
        $sql = "select * from account where u_id = ?;";
        $stmt = Db::pdo()->prepare($sql);
        $stmt->bindParam(1, $user_id);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

//根据子账号查子账号id
    public function get_id_account($account_name)
    {
        $sql = "select id from account where account_name = '{$account_name}';";
        $stmt = Db::pdo()->query($sql);
        $result = $stmt->fetch();
        return $result;
    }

//添加子账号
    public function add_account($account, $u_id)
    {
        $sql = "insert into account(account_name,account_type,u_id) value('{$account['account_name']}','{$account['account_type']}','{$u_id}');";
        $stmt = Db::pdo()->exec($sql);
        return $stmt;
    }

//删除子账号
    public function del_account($id)
    {
        $sql = "delete from account where id = '{$id}';";
        $stmt = Db::pdo()->exec($sql);
        return $stmt;
    }

//更改子账号
    public function update_account($account)
    {
        $sql = "update account set account_name = '{$account['account_name']}',account_type = '{$account['account_type']}' where id = '{$account['id']}'";
        $stmt = Db::pdo()->exec($sql);
        return $stmt;
    }

//更改账号状态
    public function update_status($status, $id)
    {
        $sql = "update account set status = '{$status}' where id = '{$id}';";
        $stmt = Db::pdo()->exec($sql);
        return $stmt;
    }
}
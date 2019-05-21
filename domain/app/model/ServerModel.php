<?php
/**
 * Created by PhpStorm.
 * User: TEM
 * Date: 2019/4/22
 * Time: 14:39
 */

namespace app\model;


use fast_php\base\Model;
use fast_php\db\Db;

class ServerModel extends Model
{
    protected $table = 'server';

// 根据id查询主机
    public function get_user_server($a_id)
    {
        $sql = "SELECT a.id,a.server_name,a.server_ip,a.status,a.remark,b.account_name,b.account_type,a.place FROM server as a left join account as b on a.a_id = b.id where a.a_id = '{$a_id}';";
        $stmt = Db::pdo()->query($sql);
        $result = $stmt->fetchAll();
        return $result;
    }

//    根据id查询主机不加左连接
    public function get_user_server_small($a_id)
    {
        $sql = "select * from server where a_id = '{$a_id}';";
        $stmt = Db::pdo()->query($sql);
        $result = $stmt->fetchAll();
        return $result;

    }

//    根据主机名
    public function get_by_name($server_name)
    {
        $sql = "select * from server where server_name = '{$server_name}';";
        $stmt = Db::pdo()->query($sql);
        $result = $stmt->fetch();
        return $result;
    }

//    根据IP地址
    public function get_by_ip($server_ip)
    {
        $sql = "select * from server where server_ip = '{$server_ip}';";
        $stmt = Db::pdo()->query($sql);
        $result = $stmt->fetch();
        return $result;
    }

//    根据a_id得到IP地址
    public function get_server_ip($a_id)
    {
        $sql = "select * from server where a_id = '{$a_id}';";
        $stmt = Db::pdo()->query($sql);
        $result = $stmt->fetchAll();
        return $result;
    }

//   添加主机
    public function add_server($server)
    {
        $sql = "insert into server(server_name,server_ip,status,remark,a_id) values('{$server['server_name']}','{$server['server_ip']}','1','{$server['remark']}','{$server['a_id']}')";
        $stmt = Db::pdo()->exec($sql);
        return $stmt;
    }

//    删除主机
    public function del_server($id)
    {
        $sql = "delete from server where id = '{$id}'";
        $result = Db::pdo()->exec($sql);
        return $result;
    }

//    更改状态
    public function change_status($id, $status)
    {
        $sql = "update server set status = '{$status}' where id = '{$id}'";
        $result = Db::pdo()->exec($sql);
        return $result;
    }

//    更改主机信息
    public function update_server($server)
    {
        $sql = "update server set server_name = '{$server['name']}',a_id = '{$server['a_id']}',remark = '{$server['remark']}';";
        Db::pdo()->exec($sql);
        return true;
    }
}
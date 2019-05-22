<?php
/**
 * Created by PhpStorm.
 * User: TEM
 * Date: 2019/4/22
 * Time: 14:38
 */

namespace app\model;


use fast_php\base\Model;
use fast_php\db\Db;

class RecordModel extends Model
{
    protected $table = "record";

//  根据d_id查询
    public function get_record_d_id($d_id, $pageVal, $pageSize)
    {
        $sql = "select * from record where d_id = ? limit {$pageVal},{$pageSize};";
        $stmt = Db::pdo()->prepare($sql);
        $stmt->bindParam(1, $d_id);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

//  根据r_name查询
    public function get_record_by_name($r_name)
    {
        $sql = "select * from record where r_name = '{$r_name}';";
        $stmt = Db::pdo()->query($sql);
        $result = $stmt->fetch();
        return $result;
    }

//   添加二级域名
    public function add_record($record)
    {
        $sql = "insert into record(r_name,r_ip,status,remark,r_time,d_id) values(?,?,?,?,?,?)";
        $stmt = Db::pdo()->prepare($sql);
        $status = 1;
        $date = date('Y-m-d,h:i:s');
        $stmt->bindParam(1, $record['r_name']);
        $stmt->bindParam(2, $record['r_ip']);
        $stmt->bindParam(3, $status);
        $stmt->bindParam(4, $record['remark']);
        $stmt->bindParam(5, $date);
        $stmt->bindParam(6, $record['d_id']);
        $result = $stmt->execute();
        return $result;
    }

//   更新二级域名
    public function update_record($record)
    {
        $sql = "update record set r_name = ?, r_ip = ?, remark = ? ,option_time = ? where id = ?";
        $stmt = Db::pdo()->prepare($sql);
        $stmt->bindParam(1, $record['r_name']);
        $stmt->bindParam(2, $record['r_ip']);
        $stmt->bindParam(3, $record['remark']);
        $stmt->bindParam(4, $record['option_time']);
        $stmt->bindParam(5, $record['id']);
        $result = $stmt->execute();
        return $result;
    }

//    批量更改IP
    public function update_record2($record)
    {
        $sql = "update record set r_ip = ? ,option_time = ? where id = ?";
        $stmt = Db::pdo()->prepare($sql);
        $stmt->bindParam(1, $record['r_ip']);
        $stmt->bindParam(2, $record['option_time']);
        $stmt->bindParam(3, $record['id']);
        $result = $stmt->execute();
        return $result;
    }

//    删除二级域名
    public function del_record($id)
    {
        $sql = "delete from record where id = '{$id}'";
        $result = Db::pdo()->exec($sql);
        return $result;
    }

//    //    删除二级域名
    public function del_record_all($d_id)
    {
        $sql = "delete from record where d_id = '{$d_id}';";
        $result = Db::pdo()->exec($sql);
        return $result;
    }

//    更改二级域名状态
    public function set_status($id, $status)
    {
        $date = date('Y-m-d,h-i-s');
        $sql = "update record set status = '{$status}',option_time = '{$date}' where id = '{$id}';";
        $result = Db::pdo()->exec($sql);
        return $result;
    }

//    查询数量
    public function get_count($d_id)
    {
        $sql = "select * from record where d_id = '{$d_id}';";
        $stmt = Db::pdo()->query($sql);
        $count = $stmt->rowCount();
        return $count;
    }

//    根据ip地址查询
    public function get_ip_record($ip)
    {
        $sql = "select * from record where r_ip = '{$ip}';";
        $stmt = Db::pdo()->query($sql);
        $result = $stmt->fetchAll();
        return $result;
    }

    //    将IP地址置为空
    public function set_ip_not($ip)
    {
        $not = null;
        $sql = "update record set r_ip = '{$not}' where r_ip = '{$ip}';";
        $stmt = Db::pdo()->exec($sql);
        return $stmt;
    }
}
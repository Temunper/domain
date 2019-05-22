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
use mysql_xdevapi\Result;
use PDO;

class DomainModel extends Model
{
    protected $table = 'domain';

//    查找所有个人的域名
//    public function get_user_domain($account_id)
//    {
//        $sql = "select all_domain from user where user_id =:user_id";
//        $stmt = Db::pdo()->prepare($sql);
//        $stmt->bindParam(':user_id', $user_id);
//        $stmt->execute();
//        $result = $stmt->fetch();
//
//        $array = explode(',', $result['all_domain']);
//        $domain_list = array();
//
//        foreach ($array as $value) {
//            $sql = "select a.status,a.id, a.d_name,b.r_name,a.d_time,b.option_time from domain as a left join record as b on a.id = b.d_id  where a.id = '{$value}' order by a.id asc ";
//            $stmt = Db::pdo()->query($sql);
//            $data = $stmt->fetchAll();
//            foreach ($data as $list) {
//                $domain_list[] = $list;
//            }
//        }
//        return $domain_list;
//    }

//  查找子账号的域名
    public function get_account_domain($id)
    {
        $sql = "SELECT a.id,a.d_name,a.d_type,a.d_owner,a.d_identify,a.status,a.d_ip,a.d_dns_active,a.d_dns_standby,a.remark,a.d_time,a.option_time,b.account_name,b.account_type 
            FROM domain as a left join account as b on a.a_id = b.id where a.a_id = '{$id}';";
        $stmt = Db::pdo()->query($sql);
        $result = $stmt->fetchAll();
        return $result;
    }

//    根据域名查询域名
    public function get_domain_by_name($d_name)
    {
        $sql = "select * from domain where d_name = '{$d_name}'";
        $stmt = Db::pdo()->query($sql);
        $result = $stmt->fetch();
        return $result;
    }

//    根据id查找
    public function get_domain_by_id($id)
    {
        $sql = "select a.id,a.d_name,a.d_book,a.d_type,a.d_owner,a.d_identify,a.status,a.d_ip,a.d_dns_active,a.d_dns_standby,a.remark,a.d_time,a.option_time,b.account_name,b.account_type,b.u_id from domain as a left join account as b on a.a_id = b.id where a.id = '{$id}'";
        $stmt = Db::pdo()->query($sql);
        $result = $stmt->fetch();
        return $result;
    }

//    添加域名
    public function add_domain($domain, $a_id)
    {
        $sql = 'insert into domain(d_name,d_type,d_owner,d_identify,d_ip,d_dns_active,d_dns_standby,remark,d_time,status,option_time,a_id) values(?,?,?,?,?,?,?,?,?,?,?,?)';
        $stmt = Db::pdo()->prepare($sql);
        $date = date("Y-m-d h:i:s");
        $date2 = date("Y-m-d h:i:s", strtotime('+' . $domain['d_time'] . ' month'));
        $status = 1;
        $stmt->bindParam(1, $domain['d_name']);
        $stmt->bindParam(2, $domain['d_type']);
        $stmt->bindParam(3, $domain['d_owner']);
        $stmt->bindParam(4, $domain['d_identify']);
        $stmt->bindParam(5, $domain['d_ip']);
        $stmt->bindParam(6, $domain['d_dns_active']);
        $stmt->bindParam(7, $domain['d_dns_standby']);
        $stmt->bindParam(8, $domain['remark']);
        $stmt->bindParam(9, $date2);
        $stmt->bindParam(10, $status, PDO::PARAM_INT);
        $stmt->bindParam(11, $date);
        $stmt->bindParam(12, $a_id);
        $result = $stmt->execute();
        return $result;
    }

//   更改域名信息
    public function update_domain($domain, $a_id)
    {
        $sql = "update domain set a_id= ? , d_ip = ?,d_dns_active = ?,d_dns_standby = ?,remark = ?,option_time = ? where d_name = ?";
        $stmt = Db::pdo()->prepare($sql);
        $date = date("Y-m-d ,h:i:s");
        $stmt->bindParam(1, $a_id);
        $stmt->bindParam(2, $domain['d_ip']);
        $stmt->bindParam(3, $domain['d_dns_active']);
        $stmt->bindParam(4, $domain['d_dns_standby']);
        $stmt->bindParam(5, $domain['remark']);
        $stmt->bindParam(6, $date);
        $stmt->bindParam(7, $domain['d_name']);
        $result = $stmt->execute();
        return $result;
    }

//    批量更改IP地址
    public function update_domain2($domain)
    {
        $sql = "update domain set d_ip = ? where id = ?";
        $stmt = Db::pdo()->prepare($sql);
        $stmt->bindParam(1, $domain['d_ip']);
        $stmt->bindParam(2, $domain['id']);
        $result = $stmt->execute();
        return $result;
    }

//    更改域名状态
    public function update_domain_status($d_id, $status)
    {
        $sql = "update domain set status = '{$status}' where id = '{$d_id}';";
        $result = Db::pdo()->exec($sql);
        return $result;
    }

//   删除域名
    public function delete_domain($d_name)
    {
        $sql = "delete from domain where d_name = '{$d_name}';";
        $result = Db::pdo()->exec($sql);
        return $result;
    }

//    根据主机IP查找
    public function get_domain_by_ip($ip)
    {
        $sql = "select * from domain where d_ip = '{$ip}'";
        $stmt = Db::pdo()->query($sql);
        $result = $stmt->fetchAll();
        return $result;
    }

//    将IP地址置为空
    public function set_ip_not($ip)
    {
        $not = null;
        $sql = "update domain set d_ip = '{$not}' where d_ip = '{$ip}';";
        $stmt = Db::pdo()->exec($sql);
        return $stmt;
    }

//     查找id
    public function get_id_domain($name)
    {
        $sql = "select id from domain where d_name = '{$name}';";
        $stmt = Db::pdo()->query($sql);
        $result = $stmt->fetch();
        return $result;
    }

//    添加到期事件
    public function set_event($domain, $id)
    {
        $date = date('Y-m-d h:i:s');
        $event = "CREATE EVENT d_time_timeout" . $id . " ON SCHEDULE at '{$date}' + INTERVAL " . $domain['d_time'] . " month ON COMPLETION  PRESERVE DO update domain set status = 0 where id = '{$id}' ;";
        $stmt = Db::pdo()->exec($event);
        return $stmt;
    }

//    添加续期事件
    public function update_event($domain)
    {

        $date = date('Y-m-d h:i:s');
        if ($domain['d_time'] < $date) {
            $d_time = date("Y-m-d h:i:s", strtotime('+' . $domain['e_date'] . ' month'));
            $event = "create event d_time_timeout" . $domain['id'] . " 
                     ON SCHEDULE at TIMESTAMP'{$date}' + INTERVAL " . $domain['e_date'] . " month
                     ON COMPLETION not PRESERVE
                     enable
                     DO update domain set status = 0 where id ='{$domain['id']}' ;";

            $sql = "update domain set d_time = '{$d_time}', status = 1 where id = '{$domain['id']}';";
            $stmt = Db::pdo()->exec($event);
//                        print_r($sql);die;
            $stmt = Db::pdo()->exec($sql);
            return $stmt;
        } else {
            $d_time = date("Y-m-d h:i:s", strtotime('+' . $domain['e_date'] . ' month', strtotime($domain['d_time'])));
            $event = "alter event d_time_timeout" . $domain['id'] . "
                     ON SCHEDULE at TIMESTAMP'{$domain['d_time']}' + INTERVAL " . $domain['e_date'] . " month
                     ON COMPLETION not PRESERVE
                     enable
                     DO update domain set status = 0 where id = '{$domain['id']}' ;";
            $sql = "update domain set d_time = '{$d_time}' where id = '{$domain['id']}';";
            $stmt = Db::pdo()->exec($event);
            $stmt = Db::pdo()->exec($sql);
            return $stmt;
        }
    }



//    计算用户的顶级域名数量
//    public function get_domain_count($user_id)
//    {
//        $sql = "select all_domain from user where user_id =:user_id";
//        $stmt = Db::pdo()->prepare($sql);
//        $stmt->bindParam(':user_id', $user_id);
//        $stmt->execute();
//        $result = $stmt->fetch();
//
//        $array = explode(',', $result['all_domain']);
//        return count($array);
//    }

//     查询将在30内过期域名数量
    public function less_thirty_day($a_id)
    {
        $sql = "SELECT count(*) as less_count FROM domain_db.domain where datediff(d_time,now())>0 and datediff(d_time,now())<30 and a_id = '{$a_id}';";
        $stmt = Db::pdo()->query($sql);
        $result = $stmt->fetch();
        return $result;
    }

//    查询将在30内过期域名
    public function less_domain($a_id)
    {
        $sql = "SELECT a.id,a.d_name,a.d_type,a.d_owner,a.d_identify,a.status,a.d_ip,a.d_dns_active,a.d_dns_standby,a.remark,a.d_time,a.option_time,b.account_name,b.account_type 
            FROM domain as a left join account as b on a.a_id = b.id where a.a_id = '{$a_id}' and  datediff(d_time,now())>0 and datediff(d_time,now())<30;";
        $stmt = Db::pdo()->query($sql);
        $result = $stmt->fetchAll();
        return $result;
    }

//    查询已过期的域名
    public function overdue_domain($a_id)
    {
        $sql = "SELECT a.id,a.d_name,a.d_type,a.d_owner,a.d_identify,a.status,a.d_ip,a.d_dns_active,a.d_dns_standby,a.remark,a.d_time,a.option_time,b.account_name,b.account_type 
            FROM domain as a left join account as b on a.a_id = b.id where a.a_id = {$a_id} and  timediff(d_time,now())<0;";
        $stmt = Db::pdo()->query($sql);
        $result = $stmt->fetchAll();
        return $result;
    }

//    按类型查询
    public function search_account_type($account_type,$a_id){
        $sql = "SELECT a.id,a.d_name,a.d_type,a.d_owner,a.d_identify,a.status,a.d_ip,a.d_dns_active,a.d_dns_standby,a.remark,a.d_time,a.option_time,b.account_name,b.account_type 
            FROM domain as a left join account as b on a.a_id = b.id where b.account_type = '{$account_type}' and  a.a_id = '{$a_id}';";
        $stmt = Db::pdo()->query($sql);
        $result = $stmt->fetchAll();
        return $result;
    }
//    按账号查询
    public function search_account_id($a_id,$d_ip){
        $sql = "SELECT a.id,a.d_name,a.d_type,a.d_owner,a.d_identify,a.status,a.d_ip,a.d_dns_active,a.d_dns_standby,a.remark,a.d_time,a.option_time,b.account_name,b.account_type 
            FROM domain as a left join account as b on a.a_id = b.id where a.a_id = '{$a_id}' and a.d_ip = '{$d_ip}';";
        $stmt = Db::pdo()->query($sql);
        $result = $stmt->fetchAll();
        return $result;
    }

//    按照IP地址查找
public function search_d_ip($ip,$a_id){
    $sql = "SELECT a.id,a.d_name,a.d_type,a.d_owner,a.d_identify,a.status,a.d_ip,a.d_dns_active,a.d_dns_standby,a.remark,a.d_time,a.option_time,b.account_name,b.account_type 
            FROM domain as a left join account as b on a.a_id = b.id where a.d_ip = ? and a_id = '{$a_id}';";
    $stmt = Db::pdo()->prepare($sql);
    $stmt->bindParam(1,$ip);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}
//     模糊查询
public function search_obscure($d_name,$a_id){
    $sql = "SELECT a.id,a.d_name,a.d_type,a.d_owner,a.d_identify,a.status,a.d_ip,a.d_dns_active,a.d_dns_standby,a.remark,a.d_time,a.option_time,b.account_name,b.account_type 
            FROM domain as a left join account as b on a.a_id = b.id where a.d_name like ? and a.a_id = '{$a_id}';";
    $stmt = Db::pdo()->prepare($sql);
    $stmt->bindValue(1,'%'.$d_name .'%');
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}
//     精确查询
    public function search_exact($d_name,$a_id){
        $sql = "SELECT a.id,a.d_name,a.d_type,a.d_owner,a.d_identify,a.status,a.d_ip,a.d_dns_active,a.d_dns_standby,a.remark,a.d_time,a.option_time,b.account_name,b.account_type 
            FROM domain as a left join account as b on a.a_id = b.id where a.d_name = ? and a.a_id = '{$a_id}';";
        $stmt = Db::pdo()->prepare($sql);
        $stmt->bindValue(1,$d_name);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }
}
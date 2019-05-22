<?php
/**
 * Created by PhpStorm.
 * User: TEM
 * Date: 2019/4/19
 * Time: 13:52
 */
namespace fast_php\db;
use \PDOStatement;
class Sql
{
    //类似于tp5的->where()条件
//protected $table;
//protected $primary = 'id';
//private  $filter = '';
//private $param = array();
//public function where($where = array(),$param = array()){
//    if ($where){
//        $this->filter = 'WHERE';
//        $this->filter = implode(' ',$where);
//       $this->param = $param;
//    }
//    return $this;
//}
////order()条件
//public function order($order = array()){
//    if ($order){
//        $this->filter = 'ORDER BY';
//        $this->filter = implode(',',$order);
//    }
//    return $this;
//}
//
////查询所有
//public function select(){
//    $sql = sprintf("select * from '%s' %s",$this->table,$this->filter);
//     $sth = Db::pdo()->prepare($sql);
//     $sth = $this->formatParam($sth,$this->param);
//     $sth->excute();
//
//     return $sth->select();
//}
////查询一个
//public  function find(){
//    $sql = sprintf("select * from '%s' %s", $this->table,$this->filter);
//    $sth  = Db::pdo()->prepare($sql);
//    $sth = $this->formatParam($sth,$this->param);
//    $sth->execute();
//
//    return $sth->find();
//}
////根据条件删除
//public function delete($id){
//    $sql = sprintf("delete from '%s' where '%s' = :%s",$this->table,$this->primary,$this->primary);
//    $sth = Db::pdo()->prepare($sql);
//    $sth = $this->formatParam($sth,[$this->primary=>$id]);
//    $sth->execute();
//
//    return $sth->rowCount();
//}
////新增数据
//public function insert($data){
//    $sql = sprintf("insert into `%s` %s", $this->table, $this->formatInsert($data));
//    $sth = Db::pdo()->prepare($sql);
//    $sth = $this->formatParam($sth, $data);
//    $sth = $this->formatParam($sth, $this->param);
//    $sth->execute();
//
//    return $sth->rowCount();
//}
//    // 修改数据
//    public function update($data)
//    {
//        $sql = sprintf("update `%s` set %s %s", $this->table, $this->formatUpdate($data), $this->filter);
//        $sth = Db::pdo()->prepare($sql);
//        $sth = $this->formatParam($sth, $data);
//        $sth = $this->formatParam($sth, $this->param);
//        $sth->execute();
//
//        return $sth->rowCount();
//    }
//
//
//    public function formatParam(PDOStatement $sth, $params = array())
//    {
//        foreach ($params as $param => &$value) {
//            $param = is_int($param) ? $param + 1 : ':' . ltrim($param, ':');
//            $sth->bindParam($param, $value);
//        }
//
//        return $sth;
//    }
//
//    // 将数组转换成插入格式的sql语句
//    private function formatInsert($data)
//    {
//        $fields = array();
//        $names = array();
//        foreach ($data as $key => $value) {
//            $fields[] = sprintf("`%s`", $key);
//            $names[] = sprintf(":%s", $key);
//        }
//
//        $field = implode(',', $fields);
//        $name = implode(',', $names);
//
//        return sprintf("(%s) values (%s)", $field, $name);
//    }
//
//    // 将数组转换成更新格式的sql语句
//    private function formatUpdate($data)
//    {
//        $fields = array();
//        foreach ($data as $key => $value) {
//            $fields[] = sprintf("`%s` = :%s", $key, $key);
//        }
//
//        return implode(',', $fields);
//    }
    public function getArray($data = null){

    }
}
<?php
/**
 * Created by PhpStorm.
 * User: TEM
 * Date: 2019/4/22
 * Time: 14:36
 */

namespace app\controller;


use app\model\AccountModel;
use app\model\DomainModel;
use app\model\RecordModel;
use app\model\ServerModel;
use http\Env\Request;

class Record extends Base
{
    protected $pageSize = 3;
//    protected $page_val = 0;
//    protected $_init = 1;

//    主页面
    public function record()
    {
        parent::_initialize();
        $d_id = $_GET['d_id'];
        $account_name = $_GET['account_name'];
        if (isset($_GET['init'])) {
            $_SESSION['page_val'] = 1;
            header('Location: http://local.domain.cn/Record/record?d_id=' . $d_id . '&account_name=' . $account_name);
        } else {
            $page_val = $_SESSION['page_val'];
            $pageVal = ($page_val - 1) * $this->pageSize;
            $record_model = new RecordModel();
            $domain_model = new DomainModel();
            $server_model = new ServerModel();
            $account_model = new AccountModel();
            $count = $record_model->get_count($d_id);
            $all_page = ceil($count / $this->pageSize);
            $domain = $domain_model->get_domain_by_id($d_id);
            $data = $record_model->get_record_d_id($d_id, $pageVal, $this->pageSize);
            $a_id = $account_model->get_id_account($account_name)['id'];
            $all_server = $server_model->get_user_server_small($a_id);
            $this->smarty()->assign("all_server", $all_server);
            $this->smarty()->assign("all_account", $a_id);
            $this->smarty()->assign("count", $all_page);
            $this->smarty()->assign("domain", $domain);
            $this->smarty()->assign("record", $data);
            $this->smarty()->assign("page_val", $page_val);
            $this->smarty()->display("record/record.html");
        }
    }

//    页面
    public function set_page()
    {
        session_start();
        $d_id = $_GET['d_id'];
        $account_name = $_GET['account_name'];
        if (isset($_GET['page_val'])) {
            $page_val = $_GET['page_val'];
        } elseif (isset($_SESSION['page_val'])) {
            $page_val = $_SESSION['page_val'];
        } else {
            $page_val = 1;
        }
        $pageVal = ($page_val - 1) * $this->pageSize;
        $record_model = new RecordModel();
        $domain_model = new DomainModel();
        $server_model = new ServerModel();
        $account_model = new AccountModel();
        $count = $record_model->get_count($d_id);
        $all_page = ceil($count / $this->pageSize);
        $domain = $domain_model->get_domain_by_id($d_id);
        $data = $record_model->get_record_d_id($d_id, $pageVal, $this->pageSize);
        $a_id = $account_model->get_id_account($account_name);
        $server = $server_model->get_user_server_small($a_id);
        $this->smarty()->assign("count", $count);
        $this->smarty()->assign("server", $server);
        $this->smarty()->assign("domain", $domain);
        $this->smarty()->assign("record", $data);
        $_SESSION['page_val'] = $page_val;
        $json = ["code" => 200,
            "all_count" => $count,  //所有条目数
            "count" => $all_page, //最大页数
            "record" => $data,   //数据
            "pageSize" => $this->pageSize, //单页最大条目数
            "page_val" => $page_val]; //当前页数
        print_r(json_encode($json));
    }

//    添加二级域名
    public function add_record()
    {
        $record = $_POST['record'];
        $record_model = new RecordModel();
        $result = $record_model->get_record_by_name($record['r_name']);
        if (!empty($result)) {
            $data = ["code" => 202,
                "data" => "域名已存在"];
            print_r(json_encode($data));
        } else {
            $bool = $this->record_check($record);
            if ($bool == "true") {
                $record_model->add_record($record);
                $data = ['code' => 200,
                    'data' => '添加成功'];
                print_r(json_encode($data));
            } else {
                print_r(json_encode($bool));
            }
        }
    }

//   检测二级域名格式
    public function record_check($record)
    {
        $name_check = "/[0-9a-zA-Z]{4,23}/";
        $ip_check = '/(25[0-5]|2[0-4]\d|[0-1]\d{2}|[1-9]?\d)\.(25[0-5]|2[0-4]\d|[0-1]\d{2}|[1-9]?\d)\.(25[0-5]|2[0-4]\d|[0-1]\d{2}|[1-9]?\d)\.(25[0-5]|2[0-4]\d|[0-1]\d{2}|[1-9]?\d)/';
        $bool = null;
        if ($record['r_name'] != null) {
            if (!preg_match($name_check, $record['r_name'])) {
                $data = ["code" => 202, 'data' => "二级域名格式不正确"];
                return $data;
            } else {
                $bool = "true";
            }
        } else {
            $data = ["code" => 202, 'data' => "二级域名为空"];
            return $data;
        }
        if ($record['r_ip'] != null) {
            if (!preg_match($ip_check, $record['r_ip'])) {
                $data = ["code" => 202, 'data' => "ip格式不正确"];
                return $data;
            } else {
                $bool = "true";
            }
        } else {
            $data = ["code" => 202, 'data' => "ip不为空"];
            return $data;
        }
        return $bool;
    }

//  更改二级域名
    public function update_record()
    {
        $date = date('Y-m-d,h:i:s');
        $data = [
            'id' => $_POST['id'],
            'r_name' => $_POST['r_name'],
            'r_ip' => $_POST['r_ip'],
            'remark' => $_POST['remark'],
            'option_time' => $date
        ];
        $result = $this->record_check($data);
        if ($result == "true") {
            $record_model = new RecordModel();
            $record_model->update_record($data);
            $data = ['code' => 200,
                'data' => '更改成功'];
            print_r(json_encode($data));
        } else {
            print_r(json_encode($result));
        }

    }

//    删除二级域名
    public function del_record()
    {
        $id = $_POST['id'];
        $record_model = new RecordModel();
        $result = $record_model->del_record($id);
        if ($result) {
            $data = ['code' => 200,
                'data' => '删除成功'];
            print_r(json_encode($data));
        } else {
            $data = ['code' => 202,
                'data' => '删除失败'];
            print_r(json_encode($data));
        }
    }

//    状态更改
    public function set_status()
    {
        $id = $_POST['id'];
        $status = $_POST['status'];
        $record_model = new RecordModel();
        if ($status == 1) {
            $record_model->set_status($id, 0);
            $data = ['code' => 200,
                'data' => '已禁用'];
            print_r(json_encode($data));
        } else {
            $record_model->set_status($id, 1);
            $data = ['code' => 200,
                'data' => '已启用'];
            print_r(json_encode($data));
        }

    }

//    批量修改
    public function update_record2()
    {
        $date = date('Y-m-d,h:i:s');
        $data = [
            'id' => $_POST['id'],
//            'r_name' => $_POST['r_name'],
            'r_ip' => $_POST['r_ip'],
//            'remark' => $_POST['remark'],
            'option_time' => $date
        ];
            $record_model = new RecordModel();
            $result = $record_model->update_record2($data);
            if ($result){
            $data = ['code' => 200,
                'data' => '更改成功'];
            print_r(json_encode($data));
        } else {
            print_r(json_encode($result));
        }

    }

}
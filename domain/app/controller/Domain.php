<?php
/**
 * Created by PhpStorm.
 * User: TEM
 * Date: 2019/4/22
 * Time: 14:37
 */

namespace app\controller;


use app\model\AccountModel;
use app\model\DomainModel;
use app\model\RecordModel;
use app\model\ServerModel;
use app\model\UserModel;


class Domain extends Base
{
//    返回主页面
    public function domain()
    {
        parent::_initialize();
        $domain_model = new DomainModel();
        $server_model = new ServerModel();
        $account_model = new AccountModel();
        $all_account = $account_model->get_user_accounts($_SESSION['user_id']);
        $all_domain = array();
        $less_count = 0;
        if (isset($_GET['less_thirty'])) {                //查询小于30天的
            if ($_GET['less_thirty'] == 1) {
                foreach ($all_account as $value) {
                    $domain = $domain_model->less_domain($value['id']);
                    $number = $domain_model->less_thirty_day($value['id'])['less_count'];
                    $less_count = $less_count + $number;
                    foreach ($domain as $ap) {
                        $all_domain[] = $ap;
                    }
                }
            }
        } elseif (isset($_GET['over_due'])) {            //已经过期的
            if ($_GET['over_due'] == 1) {
                foreach ($all_account as $value) {
                    $domain = $domain_model->overdue_domain($value['id']);
                    $number = $domain_model->less_thirty_day($value['id'])['less_count'];
                    $less_count = $less_count + $number;
                    foreach ($domain as $ap) {
                        $all_domain[] = $ap;
                    }
                }
            }
        } elseif (isset($_GET['search_account_type'])) {      //按类型查找
            if ($_GET['search_account_type'] == 1) {
                foreach ($all_account as $value) {
                    $domain = $domain_model->search_account_type($_GET['account_type'],$value['id']);
                    $number = $domain_model->less_thirty_day($value['id'])['less_count'];
                    $less_count = $less_count + $number;
                    foreach ($domain as $ap) {
                        $all_domain[] = $ap;
                    }
                }
            }
        }elseif (isset($_GET['search_account_id'])){         //按账号查找
            if ($_GET['search_account_id']==1){
                foreach ($all_account as $value) {
                    $domain = $domain_model->search_account_id($_GET['a_id'],$_GET['d_ip']);
                    $number = $domain_model->less_thirty_day($value['id'])['less_count'];
                    $less_count = $less_count + $number;
                    foreach ($domain as $ap) {
                        $all_domain[] = $ap;
                    }
                }
            }
        }elseif (isset($_GET['search_d_ip'])){            //按IP地址查找
            if ($_GET['search_d_ip']==1){
                foreach ($all_account as $value) {
                    $domain = $domain_model->search_d_ip($_GET['d_ip'],$value['id']);
                    $number = $domain_model->less_thirty_day($value['id'])['less_count'];
                    $less_count = $less_count + $number;
                    foreach ($domain as $ap) {
                        $all_domain[] = $ap;
                    }
                }
            }
        }elseif (isset($_GET['search_obscure'])){        //模糊查询
            if ($_GET['search_obscure']==1){
                foreach ($all_account as $value) {
                    $domain = $domain_model->search_obscure($_GET['d_name'],$value['id']);
                    $number = $domain_model->less_thirty_day($value['id'])['less_count'];
                    $less_count = $less_count + $number;
                    foreach ($domain as $ap) {
                        $all_domain[] = $ap;
                    }
                }
            }
        }elseif (isset($_GET['search_exact'])){        //精确查询
            if ($_GET['search_exact']==1) {
                foreach ($all_account as $value) {
                    $domain = $domain_model->search_exact($_GET['d_name'],$value['id']);
                    $number = $domain_model->less_thirty_day($value['id'])['less_count'];
                    $less_count = $less_count + $number;
                    foreach ($domain as $ap) {
                        $all_domain[] = $ap;
                    }
                }
            }
        }else{
            foreach ($all_account as $value) {          //所有域名
                $domain = $domain_model->get_account_domain($value['id']);
                $number = $domain_model->less_thirty_day($value['id'])['less_count'];
                $less_count = $less_count + $number;
                foreach ($domain as $ap) {
                    $all_domain[] = $ap;
                }
            }
        }
        $all_server = array();
        foreach ($all_account as $value) {
            $server = $server_model->get_user_server($value['id']);
            foreach ($server as $ap) {
                $all_server[] = $ap;
            }
        }
        $server = $server_model->get_user_server($_SESSION['user_id']);

//        $count = $domain_model->get_domain_count($_SESSION['user_id']);
        $this->assign('less_count', $less_count);
        $this->assign('all_server', $all_server);
        $this->assign('all_domain', $all_domain);
        $this->assign('all_account', $all_account);
        return $this->render();
    }

//    添加域名
    public function add_domain()
    {
        $domain = $_POST['data'];
        $result = $this->check_domain($domain);
        if ($result == "true") {
            if ($this->check_d_name($domain['d_name'])) {
                $domain_model = new DomainModel();
                $account_model = new AccountModel();
                $a_id = $account_model->get_id_account($domain['a_id'])['id'];
                $bool = $domain_model->add_domain($domain, $a_id);
                $id = $domain_model->get_id_domain($domain['d_name'])['id'];
                $domain_model->set_event($domain, $id);
                if ($bool) {
                    $data = [
                        'code' => 200,
                        'data' => '添加成功'
                    ];
                    print_r(json_encode($data));
                } else {
                    $data = [
                        'code' => 202,
                        'data' => '失败'
                    ];
                    print_r(json_encode($data));
                }
            } else {
                $data = [
                    'code' => 202,
                    'data' => '域名已存在'
                ];
                print_r(json_encode($data));
            }
        } else {
            print_r(json_encode($result));
        }

    }

//    检测域名的正确性
    public function check_domain($domain)
    {
        $d_name_check = '/^[a-zA-Z0-9][-a-zA-Z0-9]{0,62}(\.[a-zA-Z0-9][-a-zA-Z0-9]{0,62})+(:\d+)*(\/\w+\.\w+)*$/';
        $ip_check = '/(25[0-5]|2[0-4]\d|[0-1]\d{2}|[1-9]?\d)\.(25[0-5]|2[0-4]\d|[0-1]\d{2}|[1-9]?\d)\.(25[0-5]|2[0-4]\d|[0-1]\d{2}|[1-9]?\d)\.(25[0-5]|2[0-4]\d|[0-1]\d{2}|[1-9]?\d)/';
        $type_check = '(公司|个人)';
        $owner_check = '/^[\x80-\xff]{6,30}$/';
        $identify_check = '/(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/';
        if (array_key_exists('d_name', $domain) &&
            array_key_exists('d_type', $domain) &&
            array_key_exists('d_ip', $domain) &&
            array_key_exists('d_identify', $domain) &&
            array_key_exists('d_owner', $domain) &&
            array_key_exists('d_dns_active', $domain) &&
            array_key_exists('d_dns_standby', $domain) &&
            array_key_exists('remark', $domain)
        ) {
            if (
                $domain['d_name'] != null &&
                $domain['d_owner'] != null &&
                $domain['d_type'] != null &&
                $domain['d_identify'] != null &&
                $domain['d_ip'] != null &&
                $domain['d_dns_active'] != null
            ) {
                if (!preg_match($d_name_check, $domain['d_name'])) {
                    $data = ['code' => 202,
                        'data' => '域名格式错误'];
                    return $data;
                } elseif (!preg_match($ip_check, $domain['d_ip'])) {
                    $data = ['code' => 202,
                        'data' => 'IP地址格式错误'];
                    return $data;
                } elseif (!preg_match($ip_check, $domain['d_dns_active'])) {
                    $data = ['code' => 202,
                        'data' => 'DNS地址格式错误'];
                    return $data;
                } elseif (!preg_match($ip_check, $domain['d_ip'])) {
                    $data = ['code' => 202,
                        'data' => '备用DNS地址格式错误'];
                    return $data;
                } elseif (!preg_match($type_check, $domain['d_type'])) {
                    $data = ['code' => 202,
                        'data' => '类型格式错误'];
                    return $data;
                } elseif (!preg_match($identify_check, $domain['d_identify'])) {
                    $data = ['code' => 202,
                        'data' => '身份证格式错误'];
                    return $data;
                } elseif (!preg_match($owner_check, $domain['d_owner'])) {
                    $data = ['code' => 202,
                        'data' => '持有人姓名格式错误'];
                    return $data;
                } else {
                    return "true";
                }
            } else {
                $data = ['code' => 202,
                    'data' => '需填项有空值'];
                return $data;
            }
        } else {
            $data = ['code' => 202,
                'data' => '键值不存在'];
            return $data;
        }

    }

//     响应页面的域名检测
    public function check_domain_button()
    {
        $d_name = $_POST['d_name'];
        $result = $this->check_d_name($d_name);
        if ($result && $d_name != null) {
            $data = ['code' => 200,
                'data' => "域名可用"];
            print_r(json_encode($data));
        } else {
            $data = ['code' => 202,
                'data' => "域名已存在"];
            print_r(json_encode($data));
        }
    }

//    检测域名是否已存在
    public function check_d_name($d_name)
    {
        $domain_model = new DomainModel();
        $result = $domain_model->get_domain_by_name($d_name);
        if (empty($result)) {
            return true;
        } else {
            return false;
        }
    }

//    根据id查找域名
    public function get_id_domain()
    {

        $id = $_POST['d_id'];
        $domain_model = new DomainModel();
        $result = $domain_model->get_domain_by_id($id);
        $data = [
            "code" => 200,
            "domain_result" => $result,
        ];
        print_r(json_encode($data));
    }

//    更改域名信息
    public function update_domain()
    {
        $domain = $_POST['data'];
        $ip_check = '/(25[0-5]|2[0-4]\d|[0-1]\d{2}|[1-9]?\d)\.(25[0-5]|2[0-4]\d|[0-1]\d{2}|[1-9]?\d)\.(25[0-5]|2[0-4]\d|[0-1]\d{2}|[1-9]?\d)\.(25[0-5]|2[0-4]\d|[0-1]\d{2}|[1-9]?\d)/';
        if (preg_match($ip_check, $domain['d_dns_active'])) {
            $domain_model = new DomainModel();
            $account_model = new AccountModel();
            $a_id = $account_model->get_id_account($domain['a_id'])['id'];
            $update = $domain_model->update_domain($domain, $a_id);
            if ($update) {
                $data = [
                    "code" => 200,
                    "data" => "更改完成"
                ];
                print_r(json_encode($data));
            } else {
                $data = [
                    "code" => 202,
                    "data" => "更改失败"
                ];
                print_r(json_encode($data));
            }

        } else {
            $data = [
                "code" => 202,
                "data" => "IP地址格式错误"
            ];
            print_r(json_encode($data));
        }
    }

//    更改域名状态
    public function update_domain_status()
    {
        $id = $_POST['id'];
        $status = $_POST['status'];
        $domain_model = new DomainModel();
        if ($status == 0 || $status == 1) {
            $domain_model->update_domain_status($id, $status);
            $data = ['code' => 200,
                'data' => "更改成功"];
            print_r(json_encode($data));
        } else {
            $data = ['code' => 202,
                'data' => "更改错误"];
            print_r(json_encode($data));
        }
    }

//    删除域名
    public function delete_domain()
    {
        $d_name = $_POST["d_name"];
        $domain_model = new DomainModel();
        $record_model = new RecordModel();
        $result = $domain_model->delete_domain($d_name);
        $d_id = $domain_model->get_id_domain($d_name)['id'];
        $result = $record_model->del_record_all($d_id);
        if ($result) {
            $data = [
                'code' => 200,
                'data' => "删除成功"
            ];
            print_r(json_encode($data));
        } else {
            $data = [
                'code' => 202,
                'data' => "删除失败"
            ];
            print_r(json_encode($data));
        }
    }

//    域名续期
    public function extend_domain()
    {
        $domain = $_POST['domain'];
        $domain_model = new DomainModel();
        $result = $domain_model->update_event($domain);
        if ($result) {
            $data = [
                'code' => 200,
                'data' => "续期成功成功"
            ];
            print_r(json_encode($data));
        } else {
            $data = [
                'code' => 202,
                'data' => "续期失败失败"
            ];
            print_r(json_encode($data));
        }
    }

//    批量更改
    public function update_domain2()
    {
        $domain = $_POST['domain'];
        $domain_model = new DomainModel();
        $update = $domain_model->update_domain2($domain);
        if ($update) {
            $data = [
                "code" => 200,
                "data" => "更改完成"
            ];
            print_r(json_encode($data));
        } else {
            $data = [
                "code" => 202,
                "data" => "更改失败"
            ];
            print_r(json_encode($data));
        }

    }

}
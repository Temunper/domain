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

class Server extends Base
{
//    用户主机页面
    public function server()
    {
        parent::_initialize();
        $server_model = new ServerModel();
        $account_model = new AccountModel();
        $result = $account_model->get_user_accounts($_SESSION['user_id']);
        $all_server = array();
        foreach ($result as $value) {
            $data = $server_model->get_user_server($value['id']);
            foreach ($data as $ap) {
                $all_server[] = $ap;
            }
        }
        $this->smarty()->assign('user_account', $result);
        $this->smarty()->assign('user_server', $all_server);
        $this->smarty()->display('server/server');
    }

//     添加主机
    public function add_server()
    {
        $ip_check = '/(25[0-5]|2[0-4]\d|[0-1]\d{2}|[1-9]?\d)\.(25[0-5]|2[0-4]\d|[0-1]\d{2}|[1-9]?\d)\.(25[0-5]|2[0-4]\d|[0-1]\d{2}|[1-9]?\d)\.(25[0-5]|2[0-4]\d|[0-1]\d{2}|[1-9]?\d)/';
        $server_model = new ServerModel();
        $data = $_POST['data'];
        if (isset($data['server_ip']) && isset($data['server_name'])) {
            $ip = $server_model->get_by_ip($data['server_ip']);
            $name = $server_model->get_by_name($data['server_name']);
            if (empty($ip) && empty($name)) {
                if (preg_match($ip_check, $data['server_ip'])) {
                    $result = $server_model->add_server($data);
                    if ($result) {
                        $data = ['code' => 200,
                            'data' => '添加成功'];
                        print_r(json_encode($data));
                    } else {
                        $data = ['code' => 202,
                            'data' => '添加失败'];
                        print_r(json_encode($data));
                    }
                } else {
                    $data = ['code' => 202,
                        'data' => 'IP地址格式不正确'];
                    print_r(json_encode($data));
                }
            } else {
                $data = ['code' => 202,
                    'data' => '主机名已存在'];
                print_r(json_encode($data));
            }
        } else {
            $data = ['code' => 202,
                'data' => 'IP地址或主机名为空'];
            print_r(json_encode($data));
        }
    }

//     删除主机
    public function delete_server()
    {
        $server_model = new ServerModel();
        $domain_model = new DomainModel();
        $record_model = new RecordModel();
        $ip = $_POST['ip'];
        $id = $_POST['id'];
        $result1 = $domain_model->get_domain_by_ip($ip);
        $result2 = $record_model->get_ip_record($ip);
        if (empty($result1) && empty($result2)) {
            $result = $server_model->del_server($id);
            if ($result) {
                $data = ['code' => 200,
                    'data' => '删除成功'];
                print_r(json_encode($data));
            } else {
                $data = ['code' => 202,
                    'data' => '删除失败'];
                print_r(json_encode($data));
            }
        } else {
            $data = ['code' => 202,
                'data' => '主机IP已绑定域名，若强制删除域名将无主机可用'];
            print_r(json_encode($data));
        }
    }

//     强制删除
    public function force_delete()
    {
        $server_model = new ServerModel();
        $domain_model = new DomainModel();
        $record_model = new RecordModel();
        $ip = $_POST['ip'];
        $id = $_POST['id'];
        $result = $server_model->del_server($id);
        $result = $domain_model->set_ip_not($ip);
        $result = $record_model->set_ip_not($ip);
        if ($result) {
            $data = ['code' => 200,
                'data' => '删除成功,可通过搜索空IP地址的域名重新添加主机IP'];
            print_r(json_encode($data));
        } else {
            $data = ['code' => 202,
                'data' => '删除失败'];
            print_r(json_encode($data));
        }
    }

//     更改主机状态
    public function showdown_server()
    {
        $status = $_POST['status'];
        $id = $_POST['id'];
        if ($status == 0) {
            $status = 1;
        } else {
            $status = 0;
        }
        $server_model = new ServerModel();
        $result = $server_model->change_status($id, $status);
        if ($result) {
            $data = ['code' => 200,
                'data' => '更改成功'];
            print_r(json_encode($data));
        } else {
            $data = ['code' => 202,
                'data' => '更改失败'];
            print_r(json_encode($data));
        }
    }

//     根据账号得到主机IP
    public function get_server_ip()
    {
        $a_name = $_POST['a_name'];
        $server_model = new ServerModel();
        $account_model = new AccountModel();
        $a_id = $account_model->get_id_account($a_name)['id'];
        $server = $server_model->get_server_ip($a_id);
        $data = ['code' => 200,
            'data' => $server
        ];
        print_r(json_encode($data));
    }

//    更新主机
    public function update_server()
    {
        $account_model = new AccountModel();
        $a_id = $account_model->get_id_account($_POST['a_name'])['id'];
        $server = [
          'id'=>$_POST['id'],
          'name'=>$_POST['name'],
            'a_id'=>$a_id,
            'remark'=>$_POST['remark']
        ];
        $server_model = new ServerModel();
        $result = $server_model->update_server($server);
        if ($result){
            $data = ['code' => 200,
                'data' => '更新成功'];
            print_r(json_encode($data));
        } else {
            $data = ['code' => 202,
                'data' => '更新失败'];
            print_r(json_encode($data));
        }
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: TEM
 * Date: 2019/5/14
 * Time: 15:10
 */

namespace app\controller;


use app\model\AccountModel;


class Account extends Base
{
//    账号页
    public function account()
    {
        parent::_initialize();
        $account_model = new AccountModel();
        $result = $account_model->get_user_accounts($_SESSION['user_id']);
        $this->assign('all_account', $result);
        return $this->render();
    }

//    添加账号
    public function add_account()
    {
        session_start();
        $account_model = new AccountModel();
        $account = $_POST['account'];
        $bool = $this->account_check($account);
        if ($bool == "true") {
            $result = $account_model->add_account($account, $_SESSION['user_id']);
            if ($result) {
                $data = ['code' => 200,
                    'data' => "添加成功"];
                print_r(json_encode($data));
            } else {
                $data = ['code' => 202,
                    'data' => "添加失败"];
                print_r(json_encode($data));
            }
        } else {
            print_r(json_encode($bool));
        }

    }

//    账号格式检测
    public function account_check($account)
    {
        $name_check = "/^[a-zA-Z0-9_-]{4,16}$/";
        if (isset($account['account_name'])) {
            if (!preg_match($name_check, $account['account_name'])) {
                $data = ['code' => 202,
                    'data' => '账号名格式不正确'];
                return $data;
            } elseif (!isset($account['account_type'])) {
                $data = ['code' => 202,
                    'data' => '账号类型为空'];
                return $data;
            } else {
                return "true";
            }
        } else {
            $data = ['code' => 202,
                'data' => '账号名为空'];
            return $data;
        }
    }

//    更新账号
    public function update_account()
    {
        $account = ["account_name" => $_POST['account_name'],
            "account_type" => $_POST['account_type'],
            "id" => $_POST['id']];
        $account_model = new AccountModel();
        $result = $account_model->update_account($account);
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

//   更改状态
    public function update_status()
    {
        $status = $_POST['status'];
        $id = $_POST['id'];
        if ($status == 0) {
            $status = 1;
        } else {
            $status = 0;
        }
        $account_model = new AccountModel();
        $result = $account_model->update_status($status, $id);
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

//    账号注销
    public function del_account()
    {
        $id = $_POST['id'];
        $account_model = new AccountModel();
        $result = $account_model->del_account($id);
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
}
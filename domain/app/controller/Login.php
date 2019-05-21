<?php
/**
 * Created by PhpStorm.
 * User: TEM
 * Date: 2019/4/19
 * Time: 15:42
 */

namespace app\controller;


use app\model\UserModel;
use fast_php\base\Controller;

class Login extends Controller
{
//    进入登陆页面
    public function login()
    {
        if (isset($_GET['second'])){
            $this->assign('second','请先登陆');
        }
        return $this->render();
    }

//    登陆
    public function login_check()
    {
        header('Access-Control-Allow-Origin:*');
        if (!empty($_POST['user_name']) && !empty($_POST['user_password'])) {
            $user_name = $_POST['user_name'];
            $user_password = $_POST['user_password'];
            $user_model = new UserModel();
            $result = $user_model->login($user_name, $user_password);
            if (!empty($result)) {                                             //登陆成功
                $ip = $_SERVER['REMOTE_ADDR'];
                $user_model->set_login_log($ip, $result['user_id']);          //更新用户日志
                session_start();                                               //session会话开始
                $_SESSION['user_name'] = $result['user_name'];                           //session保存用户名
                $_SESSION['user_id'] = $result['user_id'];                               //session保存用户id
                $data = ['code' => '200',
                    'data' => '登陆成功'
                ];
                echo json_encode($data);
            } else {
                $data = ['code' => '202',
                    'data' => '用户名或密码错误'
                ];
                echo json_encode($data);
            }
        } else {
            $data = ['code' => '202',
                'data' => '用户名或密码为空'
            ];
            print_r(json_encode($data));
        }
    }

//    注销登陆
    public function logout()
    {
        session_start();
        session_destroy();
        header("Location: http://local.domain.cn/Login/login");
    }

//    注册
    public function add_user()
    {
        if (isset($_POST['user'])) {
            $user = $_POST['user'];
            if (array_key_exists('user_name', $user)
                && array_key_exists('user_password', $user)
                && array_key_exists('confirm_password', $user)
                && array_key_exists('email', $user)
                && array_key_exists('phone_num', $user)) {
                $bool = $this->check_user($user);
                if ($bool == 'true') {
                    if (empty($this->find_user($user['user_name']))) {
                        $user_model = new UserModel();
                        $result = $user_model->add_user($user);
                        if ($result) {
                            $data = ['code' => '200',
                                'data' => '注册成功'
                            ];
                            print_r(json_encode($data));
                        }else{
                            $data = ['code' => '202',
                                'data' => '注册失败'
                            ];
                            print_r(json_encode($data));
                        }

                    } else {
                        $data = ['code' => '202',
                            'data' => '用户名已存在'
                        ];
                        print_r(json_encode($data));
                    }
                } else {
                    print_r(json_encode($bool));
                }
            } else {
                $data = ['code' => '202',
                    'data' => '注册数据缺少键值'
                ];
                print_r(json_encode($data));
            }
        } else {
            $data = ['code' => '202',
                'data' => '注册数据不存在'
            ];
            print_r(json_encode($data));
        }
    }

//   检测注册格式
    public function check_user($user)
    {
        $name_check = "/^[a-zA-Z][a-zA-Z0-9]{3,15}$/";  //用户名
        $password_check = "/^[\w_-]{6,16}$/"; //密码
        $email_check = "/^\w+@\w+(\.[a-zA-Z]{2,3}){1,2}$/";
        if (!$user['user_name'] == null &&
            !$user['user_password']==null &&
            !$user['confirm_password']==null &&
            !$user['email']==null &&
            !$user['phone_num']==null) {
            if (!preg_match($name_check, $user['user_name'])) {
                $data = ['code' => 202,
                    'data' => '用户名由3-15位大小写字母和数字组成组成'
                ];
                return $data;
            } elseif (!preg_match($password_check, $user['user_password'])) {
                $data = ['code' => 202,
                    'data' => '密码由6-16位大小写字母、数字后和下划线组成'
                ];
                return $data;
            } elseif (!preg_match($email_check, $user['email'])) {
                $data = ['code' => 202,
                    'data' => '邮件格式不正确'
                ];
                return $data;
            } elseif ($user['user_password'] != $user['confirm_password']) {
                $data = ['code' => 202,
                    'data' => '确认密码不统一'
                ];
                return $data;
            } else {
                return "true";
            }
        } else {
            $data = ['code' => 202,
                'data' => '填写值不能为空'
            ];
            return $data;
        }

    }

//    根据用户名查找用户
    public function find_user($user_name)
    {
        $user_model = new UserModel();
        $user = $user_model->get_user_information($user_name);
        return $user;
    }
}
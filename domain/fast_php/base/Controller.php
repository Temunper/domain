<?php
/**
 * Created by PhpStorm.
 * User: TEM
 * Date: 2019/4/19
 * Time: 13:41
 */

namespace fast_php\base;


use Couchbase\ViewQuery;

class Controller
{
    protected $_controller;
    protected $_action;
    protected $_view;

//     构造函数初始化
    public function __construct($controller, $action)
    {
        $this->_controller = $controller;
        $this->_action = $action;
        $this->_view = new View($controller, $action);
    }

//分配变量
    public function assign($name, $value)
    {
        $this->_view->assign($name, $value);
    }

//视图渲染
    public function render()
    {
        $this->_view->render();
    }
    protected function _initialize()
    {
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: TEM
 * Date: 2019/4/19
 * Time: 13:41
 */

namespace fast_php\base;


use Couchbase\ViewQuery;
use Smarty;

class Controller
{
    protected $_controller;
    protected $_action;
    protected $_view;

//    smarty类
     protected static $smarty = null;


//     构造函数初始化
    public function __construct($controller, $action)
    {
        $this->_controller = $controller;
        $this->_action = $action;
        $this->_view = new View($controller, $action);
        if (self::$smarty == null || !(self::$smarty instanceof Smarty)){
            self::$smarty = new Smarty();
        }
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

//    使用smarty
 public function smarty(){
        self::$smarty->setTemplateDir('app/view/');
        self::$smarty->setCompileDir('app/templates_c/');
        self::$smarty->setConfigDir('app/configs/');
        self::$smarty->setCacheDir('app/cache/');
//        self::smarty()->left_delimiter = '<{';
//        self::smarty()->right_delimiter = '}>';
        return self::$smarty;
 }
}
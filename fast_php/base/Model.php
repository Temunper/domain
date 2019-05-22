<?php
/**
 * Created by PhpStorm.
 * User: TEM
 * Date: 2019/4/19
 * Time: 13:52
 */

namespace fast_php\base;
use fast_php\db\Sql;


class Model extends Sql
{
    protected $model;

    public function __construct()
    {
//    检验模型名称
        if ($this->table) {
            $this->model = get_class($this);
            $this->model = substr($this->model, 0, -5);
            $this->table = strtolower($this->model);
        }
    }
}
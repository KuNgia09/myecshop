<?php

/**
 * @author fengyue <email@email.com>
 */
namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\response\Json;
use think\Session;

class Base extends Controller
{
    public function ajaxReturn($data, $type = 'json')
    {
        header('Content-Type:application/json; charset=utf-8');
        exit(json_encode($data));
    }

    protected function joinSql($sql, $params)
    {
        $length=$params['length'];
        $offset=$params['offset'];
        $sort=$params['sort'];
        $order=$params['order'];
        if (!empty($sort)) {
            $sql=$sql." order by $sort";
            if (!empty($order)) {
                $sql=$sql." $order";
            }
        }
        if (!empty($length)) {
            $sql=$sql." limit $length offset $offset";
        }
        return $sql;
    }
}

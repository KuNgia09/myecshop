<?php
namespace app\home\controller;

use think\Controller;
use think\DB;

class Goods extends Controller
{
    // 显示商品列表
    public function showList()
    {
        // 显示商品列表
        $data=Db::table('ecs_goods')->select();
        $this->assign('data', $data);
        return $this->fetch('show_list');
    }

    // 商品详情
    public function detail()
    {
    }
}

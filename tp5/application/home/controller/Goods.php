<?php
namespace app\home\controller;

use think\Controller;
use think\View;
use think\DB;
use app\admin\logic\GoodsLogic;

class Goods extends Controller
{
    // 显示商品列表
    public function showList()
    {
        // 显示商品列表
        $data=Db::name('goods')->select();
        $this->assign('data', $data);
        return $this->fetch('show_list');
    }

    // 商品详情
    public function goodsDetail($id)
    {
        // 判断是不是整数
        if (!is_numeric($id)) {
            return;
        }

        $goods=Db::name('goods')->where('goods_id', $id)->find();
        
        $goods_name=$goods['goods_name'];
       
        $GoodsLogic=new GoodsLogic();
        // 查询商品的属性
        $goods_attrs=$GoodsLogic->getAttrInfo($id);

        // 查询商品的规格
        $goods_spec_info=$GoodsLogic->getSpecInfo($id);

        $goods_images=$GoodsLogic->getImagesInfo($id);
        
        // 商品通用信息
        $this->assign('data', $goods);
        // 商品规格信息
        $this->assign('specData', $goods_spec_info['goods_spec']);
        $this->assign('spec_key', $goods_spec_info['current_spec_key']);
        $this->assign('attrs', $goods_attrs);
        $this->assign('images', $goods_images);
        return $this->fetch('detail');
        
    }
}

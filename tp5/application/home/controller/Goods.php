<?php
namespace app\home\controller;

use think\Controller;
use think\View;
use think\DB;
use app\admin\logic\GoodsLogic;

class Goods extends Base
{
    // 显示商品列表
    public function showList()
    {
        // 显示商品列表
        $data=Db::name('goods')->select();
        $this->assign('data', $data);
        return $this->fetch('show_list');
    }

    /**
     * 商品信息
     *
     * @param [type] $id
     * @return void
     */
    public function goodsInfo($id)
    {
        // 判断是不是整数
        if (!is_numeric($id)) {
            return;
        }

        $goods=Db::name('goods')->where('goods_id', $id)->find();
        $goods['brand_name']=Db::name('brand')->where('brand_id',$goods['brand_id'])->value('brand_name');
        $goods_name=$goods['goods_name'];
       
        $GoodsLogic=new GoodsLogic();
        // 查询商品的属性
        $goods_attrs=$GoodsLogic->getAttrInfo($id);

        // 面包屑
        $breadcrumb=model('GoodsCategory')->getTitleByClassId($goods['cat_id'],'span');


        // 查询商品的规格
        /*
        goods_spec:array(2)
        0:array(6)
        id:3
        type_id:4
        name:"颜色"
        sort:4
        is_show:1
        children:array(2)
        0:array(3)
        id:19
        spec_id:3
        item:"白色"
        1:array(3)
        id:20
        spec_id:3
        item:"黑色"
        */
        $goods_spec_info=$GoodsLogic->getSpecInfo($id);

        $goods_images=$GoodsLogic->getImagesInfo($id);
        



        // 商品通用信息
        $this->assign('result', $goods);
        // 商品每种规格价格  库存 对应spec_goods_price表
        $this->assign('spec_goods_price', $goods_spec_info['spec_goods_price']);
        // 商品的规格名 规格项
        $this->assign('spec_data', $goods_spec_info['goods_spec']);
        $this->assign('spec_key', $goods_spec_info['current_spec_key']);
        $this->assign('goods_attrs', $goods_attrs);
        $this->assign('goods_images', $goods_images);
        
        $giftHtml='';
        $countHtml='';
        $gift_id=[];
        
        $this->assign('giftHtml', $giftHtml);
        $this->assign('countHtml', $countHtml);
        $this->assign('gift_id', implode(',', $gift_id));
        $this->assign('requstURL', url('Settlement/shopping'));
        $this->assign('breadcrumb',$breadcrumb);
        return $this->fetch('goods_info');
        
    }
}

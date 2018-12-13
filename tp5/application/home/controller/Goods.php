<?php
namespace app\home\controller;

use think\Controller;
use think\View;
use think\DB;

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
       

        // 查询商品的属性
        $goods_attrs=[];
        $goods_attrs=Db::name('goods_attr')->field('attr_id,attr_value')->where('goods_id', $id)->select();
        foreach ($goods_attrs as $key=>$attr) {
            $attr_id=$attr['attr_id'];
            $attribute=Db::name('attribute')->where('attr_id', $attr_id)->find();
            // 获取属性名
            $attr_name=$attribute['attr_name'];
            $goods_attrs[$key]['attr_name']=$attr_name;
        }

     
        $goods_spec=[];
        $current_spec_key=[];
        // $p_id为0表示这是父级商品
   
        // 查询多规格商品的key 价格 库存等信息
        $sql="SELECT * FROM ecs_spec_goods_price WHERE (goods_id=$id)";
        $spec_goods_price=Db::query($sql);

        // 规格名和规格项数据
        $goods_spec=[];
        // 当前激活的规格项key
        $current_spec_key=[];

        if (!empty($spec_goods_price)) {
            $res=[];
            
            // 获取这种形式的key 20_24_26
            // 将key的每个unit单元提取出来
            foreach ($spec_goods_price as $key=>$value) {
                $spec_key=$value['key'];
                // 获取当前商品的key值
                // 提取第一项作为激活的规格项组合
                if (empty($current_spec_key)) {
                    $current_spec_key=explode('_', $spec_key);
                }
                
                $res[]=str_replace('_', ",", $spec_key);
            }
            // 将所有的规格项id组合起来
            $id_string=implode(',', $res);

            // 从规格项表中查询所有的规格值 如黑色 白色
            $sql="SELECT * FROM ecs_goods_spec_item WHERE (id in ($id_string))";
            $goods_spec_item=Db::query($sql);

            $id_string='';
            foreach ($goods_spec_item as $key=>$value) {
                $id_string.=$value['spec_id'];
                if ($key <count($goods_spec_item)-1) {
                    $id_string.=',';
                }
            }

            // 获取规格名称 如颜色 尺寸
            $sql="SELECT * FROM ecs_goods_spec WHERE (id in ($id_string))";
            $goods_spec=Db::query($sql);
          

            // 将规格名和对应的规格项联合起来
            // 形成如下的结构：
            // 颜色： 黑色 白色
            // 尺寸：5寸 6寸
            // 单位：件 包
            foreach ($goods_spec as $key=>$spec) {
                $spec_id=$spec['id'];
                // 遍历规格项
                foreach ($goods_spec_item as $spec_item) {
                    if ($spec_id==$spec_item['spec_id']) {
                        $goods_spec[$key]['children'][]=$spec_item;
                    }
                }
            }
            //array(6)
            // id:1
            // type_id:4
            // name:"颜色"
            // sort:20
            // is_show:1
            // children:array(2)
            // 0:array(3)
            // id:1
            // spec_id:1
            // item:"白色"
            // 1:array(3)
            // id:2
            // spec_id:1
            // item:"黑色"
        
      
            // 商品通用信息
            $this->assign('data', $goods);
            // 商品规格信息
            $this->assign('specData', $goods_spec);
            $this->assign('spec_key', $current_spec_key);
            $this->assign('attrs', $goods_attrs);
            return $this->fetch('detail');
        }
    }
}

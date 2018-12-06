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
        $data=Db::table('ecs_goods')->select();
        $this->assign('data', $data);
        return $this->fetch('show_list');
    }

    // 商品详情
    public function goodsDetail()
    {
        // 判断是不是整数
        $id=135;
        $goods=Db::table('ecs_goods')->where('goods_id',$id)->find();
        
        $goods_name=$goods['goods_name'];
        $view = new View();
        $view->name = $goods['goods_desc'];

        // 查询商品的属性
        $goods_attrs=Db::table('ecs_goods_attr')->field('attr_id,attr_value')->where('goods_id',$id)->select();
        foreach($goods_attrs as $key=>$attr){
          $attr_id=$attr['attr_id'];
          $attribute=Db::table('ecs_attribute')->where('attr_id',$attr_id)->find();
          // 获取属性名
          $attr_name=$attribute['attr_name'];
          $goods_attrs[$key]['attr_name']=$attr_name;
        }

        //查询多规格商品
        // 首先获取父级商品的信息
        $p_id=$goods['p_id'];
        // $p_id为0表示这是父级商品
        if($p_id!=0){
          // 查询多规格子商品信息
          $spec_goods=Db::table('ecs_goods')->field('goods_id,goods_name,brand_id,p_id,goods_desc,goods_price')->where('p_id',$p_id)->select();
          // 将多规格商品的id连接起来
          $str='';
          foreach($spec_goods as $key=>$value){
            $str.=$value['goods_id'];
            if($key<count($spec_goods)-1){
              $str.=',';
            }
          }

          // 查询多规格商品的key 价格 库存等信息
          $sql="SELECT * FROM ecs_spec_goods_price WHERE (goods_id in ($str))";
          $spec_goods_price=Db::query($sql);
          
          $res=[];
          // 获取这种形式的key 20_24_26 
          // 将key的每个unit单元提取出来
          foreach($spec_goods_price as $key=>$value){
            $spec_key=$value['key'];
            $res[]=str_replace('_',",",$spec_key);
          }
          // 将所有的规格项id组合起来
          $id_string=implode(',',$res);

          // 从规格项表中查询所有的规格值 如黑色 白色
          $sql="SELECT * FROM ecs_goods_spec_item WHERE (id in ($id_string))";
          $goods_spec_item=Db::query($sql);

          $id_string='';
          foreach($goods_spec_item as $key=>$value){
            $id_string.=$value['spec_id'];
            if($key <count($goods_spec_item)-1){
              $id_string.=',';
            }
          }

          // 获取规格名称 如颜色
          $sql="SELECT * FROM ecs_goods_spec WHERE (id in ($id_string))";
          $goods_spec=Db::query($sql);

          // 将规格名和对应的规格项联合起来
          foreach($goods_spec as $key=>$spec){
            $spec_id=$spec['id'];
            // 遍历规格项
            foreach($goods_spec_item as $spec_item){
              if($spec_id==$spec_item['spec_id']){
                $goods_spec[$key]['children'][]=$spec_item;
              }
            }
          }
          

        

          

        }

        // 商品通用信息
        $this->assign('data',$goods);
        // 商品规格信息
        $this->assign('attrs',$goods_attrs);
        return $this->fetch('detail');
    }
}

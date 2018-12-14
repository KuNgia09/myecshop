<?php
/**
 * @author fengyue <email@email.com>
 */
namespace app\admin\logic;

use think\Model;
use think\db;

/**
 *
 */
class GoodsLogic extends Model
{
    /**
     * 后置操作方法
     * 自定义的一个函数 用于数据保存后做的相应处理操作, 使用时手动调用
     * @param int $goods_id 商品id
     */
    public function afterSave($goods_id)
    {
        // 更新商品SN号
        $goods_sn = "ECS".str_pad($goods_id, 7, "0", STR_PAD_LEFT);
        Db::name('goods')->where("goods_id = $goods_id and goods_sn = ''")
          ->update(array("goods_sn"=>$goods_sn)); // 根据条件更新记录

        //商品相册
        $goods_images = input('goods_images/a');
        if (count($goods_images)>1) {
            array_pop($goods_images); // 弹出最后一个
            $goodsImagesArr=[];
            // 添加图片
            foreach ($goods_images as $key => $val) {
                if ($val == null) {
                    continue;
                }
                if (!in_array($val, $goodsImagesArr)) {
                    $data = array('goods_id' => $goods_id,'image_url' => $val);
                    // Db::name('goods_images')->insert($data);
                    Db::name('goods_images')->insert($data);
                }
            }
        }

        //商品规格的处理
        $goods_spec=input('item/a');
        if ($goods_spec) {
            $keyArr = '';//规格key数组
            foreach ($goods_spec as $k=>$v) {
                $keyArr .= $k.',';
                $v['price'] = trim($v['price']);
                $v['store_count'] = trim($v['store_count']); // 记录商品总库存
                $v['sku'] = trim($v['sku']);
                $v['preferential']=trim($v['preferential']);
                $data = [
                    'goods_id' => $goods_id,
                    'key' => $k,
                    'key_name' => $v['key_name'],
                    'price' => $v['price'],
                    'store_count' => $v['store_count'],
                    'sku' => $v['sku'],
                    'preferential' => $v['preferential'],
                    // 'cost_price'=>$v['cost_price'],
                    // 'commission'=>$v['commission'],
                ];
                Db::name('spec_goods_price')->insert($data);
            }
            // 删除不属于当前规格key的记录
            if ($keyArr) {
                Db::name('spec_goods_price')->where('goods_id', $goods_id)->whereNotIn('key', $keyArr)->delete();
            }
        }

        // 商品属性的处理
        if (isset($_POST['attr_id_list'])) {
            // 遍历所有的属性id
            $attr_id_list=$_POST['attr_id_list'];
            $attr_value_list=$_POST['attr_value_list'];
            $attr_value_list_trim=[];
            foreach ($attr_value_list as $key=>$attr_value) {
                // 如果属性值为空或者为0 移除当前属性
                if (empty($attr_value)) {
                    // 使用unset不会改变索引
                    unset($attr_id_list[$key]);
                }
            }
            $data_attr=[];
    
            foreach ($attr_id_list as $key=>$attr_id) {
                $res=['goods_id'=>$goods_id,'attr_id'=>$attr_id,'attr_value'=>$attr_value_list[$key]];
                $data_attr[]=$res;
            }
   
            //  插入多维数组 将商品属性值保存到商品属性表中
            Db::name('goods_attr')->insertAll($data_attr);
        }
    }

    /**
     * 根据id查询商品的属性信息
     *
     * @param [type] $id
     * @return void
     */
    public function getAttrInfo($id)
    {
        $goods_attrs=[];
        $goods_attrs=Db::name('goods_attr')->field('attr_id,attr_value')->where('goods_id', $id)->select();
        foreach ($goods_attrs as $key=>$attr) {
            $attr_id=$attr['attr_id'];
            $attribute=Db::name('attribute')->where('attr_id', $attr_id)->find();
            // 获取属性名
            $attr_name=$attribute['attr_name'];
            $goods_attrs[$key]['attr_name']=$attr_name;
        }
        return $goods_attrs;
    }

    /**
     * 根据商品id获取规格信息
     *
     * @param [type] $id
     * @return void
     */
    public function getSpecInfo($id)
    {
        // 查询多规格商品的key 价格 库存等信息
        $sql="SELECT * FROM ecs_spec_goods_price WHERE (goods_id=$id)";
        $spec_goods_price=Db::query($sql);
        if (empty($spec_goods_price)) {
            return [];
        }
        // 规格名和规格项数据
        $goods_spec=[];
        // 当前激活的规格项key
        $current_spec_key=[];

      
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

        // 形成如下的结构
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
        foreach ($goods_spec as $key=>$spec) {
            $spec_id=$spec['id'];
            // 遍历规格项
            foreach ($goods_spec_item as $spec_item) {
                if ($spec_id==$spec_item['spec_id']) {
                    $goods_spec[$key]['children'][]=$spec_item;
                }
            }
        }
        return ['current_spec_key'=>$current_spec_key,'goods_spec'=>$goods_spec];
    }

    /**
     * 根据商品id获取相册
     *
     * @param [type] $id
     * @return void
     */
    public function getImagesInfo($id){
        $images=Db::name('goods_images')->where('goods_id',$id)->select();
        return $images;
    }
}

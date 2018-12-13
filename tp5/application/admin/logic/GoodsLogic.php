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
}

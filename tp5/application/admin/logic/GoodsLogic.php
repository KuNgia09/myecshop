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
      $goods_sn = "ECS".str_pad($goods_id,7,"0",STR_PAD_LEFT);
      Db::name('goods')->where("goods_id = $goods_id and goods_sn = ''")
          ->update(array("goods_sn"=>$goods_sn)); // 根据条件更新记录

      //商品相册
      $goods_images = input('goods_images/a');
      if(count($goods_images)>1){
        array_pop($goods_images); // 弹出最后一个
        $goodsImagesArr=[];
        // 添加图片
        foreach($goods_images as $key => $val)
        {
            if($val == null)  continue;
            if(!in_array($val, $goodsImagesArr))
            {
                $data = array('goods_id' => $goods_id,'image_url' => $val);
                // Db::name('goods_images')->insert($data); 
                Db::table('ecs_goods_images')->insert($data); 
            }
        }

        //
      }
    }
}
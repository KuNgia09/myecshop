<?php
/**
 * @author fengyue <email@email.com>
 */


namespace app\common\model;

use think\Db;
use think\Model;

/**
 * 商品模型
 */
class Goods extends Model
{
    // 主键id
    protected $pk = 'goods_id';

  
    /**
     *对模型设置的数据对象值进行处理
     *
     * @param [type] $value  cat_id的字段值
     * @param [type] $data   传入的字段值数组
     * @return void
     */
    public function setCatIdAttr($value, $data)
    {
        if ($data['cat_id_3']) {
            return $data['cat_id_3'];
        }
        if ($data['cat_id_2']) {
            return $data['cat_id_2'];
        }
        return $value;
    }
}

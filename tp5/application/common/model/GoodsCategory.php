<?php
namespace app\common\model;

use think\Model;
use think\Db;

class GoodsCategory extends Model
{
    // 设置表名
    protected $table = 'ecs_category';

    protected $pk = 'cat_id';
  /**
     * 获取所有数据
     *
     * @return mixed
     */
    public function getList()
    {

        $parentField = 'cat_id,cat_name,parent_id';

        $parent = $this->field( $parentField )
            ->where( 'shoutui=1  and is_show_nav=1' )
            ->order( 'sort_order desc' )
            ->select();

        return $parent;
    }
}
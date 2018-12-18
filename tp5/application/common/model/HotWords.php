<?php
// +----------------------------------------------------------------------
// | OnlineRetailers [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2003-2023 www.yisu.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed 亿速网络（http://www.yisu.cn）
// +----------------------------------------------------------------------
// | Author: 王强 <opjklu@126.com>
// +----------------------------------------------------------------------

namespace app\common\model;

use think\Model;

/**
<<<<<<< HEAD
 * 关键词模型
=======
 * 关键词模型 
>>>>>>> e5b37835f76dcc04fcd66ebfa9dfdb818ae619b9
 */
class HotWords extends Model
{
    protected $table="db_hot_words";

    private static $obj;
    
    /**
     * 查询 单个 关键词数据
     */
    public function getHotWord($options = array(), Model $model)
    {
<<<<<<< HEAD
        if (empty($options) || !is_array($options) || !($model instanceof Model)) {
=======
        if (empty($options) || !is_array($options) || !($model instanceof Model))
        {
>>>>>>> e5b37835f76dcc04fcd66ebfa9dfdb818ae619b9
            return array();
        }
        
        $data = parent::find($options);
        
<<<<<<< HEAD
        if (!empty($data)) {
            $data['children'] = $model->field($model->getPk())->where('fid = "'.$data['goods_class_id'].'"')->select();
        }
        
        return $data;
    }
    
    /**
     * 处理多级数
=======
        if (!empty($data))
        {
            $data['children'] = $model->field( $model->getPk() )->where('fid = "'.$data['goods_class_id'].'"')->select();
        }
        
        return $data;
       
    }
    
    /**
     * 处理多级数 
>>>>>>> e5b37835f76dcc04fcd66ebfa9dfdb818ae619b9
     */
    public function parseData($options=array(), Model $model)
    {
        $data = $this->getHotWord($options, $model);
        
        $data = \Common\Tool\Tool::join($data);
       
        return $data;
    }
    
    // public static function getInitnation()
    // {
    //    return  self::$obj = !(self::$obj instanceof HotWordsModel) ? new self() : self::$obj;
    // }
    
    /**
<<<<<<< HEAD
     * 获取关键词
     */
    public function getKeyWord()
=======
     * 获取关键词 
     */
    public function getKeyWord ()
>>>>>>> e5b37835f76dcc04fcd66ebfa9dfdb818ae619b9
    {
        if (! $hotWords = cache('hot_words')) {
            $hotWords = $this->field("id,hot_words")
            ->where([
                'is_hide' => '0'
            ])
            ->order('create_time desc')
            ->limit(10)
            ->select();
            cache('hot_words', $hotWords, 600);
        }
        
        return $hotWords;
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> e5b37835f76dcc04fcd66ebfa9dfdb818ae619b9

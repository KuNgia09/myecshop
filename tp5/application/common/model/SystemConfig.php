<?php
namespace app\common\model;

use think\Model;

class SystemConfig extends Model
{

    protected $table="db_system_config";
  /**
     * @desc 依据某个键 获取 子集
     * @param string $key  父级键名
     * @return array
     */
    public function getDataByKey($key = null)
    {
        $cacheKey = md5($key).'_'.$key;
    
        $data = cache($cacheKey);
    
        if (empty($data)) {
            
            $field = 'class_id,config_value';
            
            // 缓存设置为3600秒
            $data = $this->where('parent_key',$key)->column($field);
      
            if (empty($data)) {
                return array();
            }
        
            foreach ($data as $key => & $value)
            {
                $value = unserialize($value);
            }
            cache($cacheKey ,$data,3600);
           
       }
       return $data;
    }
}
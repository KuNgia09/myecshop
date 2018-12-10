<?php
namespace app\admin\controller;

/**
 * Note:
 * Importing rules are per file basis, meaning included files will NOT inherit the parent file's importing rules.
 */
require_once './vendor/autoload.php';

use think\Controller;
use think\DB;
// use Gregwar\Captcha\CaptchaBuilder;
use think\Session;
use Kint\Kint;

class GoodsAttr extends Controller
{
    // 显示属性列表模板
    public function showAttribute()
    {
        $type_id=$_GET['typeId'];
        dump($_GET);
        dump('type_id:'.$type_id);
        $this->assign('type_id', $type_id);
        // 获取所有的商品类型
        $goods_type=Db::name('ecs_goods_type')->field('type_id,type_name')->select();
       
        $this->assign('list_type', $goods_type);
        ob_clean();
        return $this->fetch('show_attribute');
    }

    // ajax获取属性列表
    public function getAttributeList()
    {
        $field='type_id';
        $typeId=$_GET['typeId']+0;
        dump($typeId);
        // typeId为0表示是所有的商品类型
        if ($typeId==0) {
            $attr_list=queryList('ecs_attribute');
            $count=Db::table('ecs_attribute')->count();
        } else {
            $attr_list=queryListCondition('ecs_attribute', $field, $typeId);
            $count=Db::table('ecs_attribute')->where($field, $typeId)->count();
        }

        // 查询商品类型名称
        foreach ($attr_list as $key=>$value) {
            // 获取每种属性的类型id
            $cat_id_item=$value[$field];
            // find只获取一行数据
            $type_name=Db::table('ecs_goods_type')->field('type_name')->where('type_id', $cat_id_item)->find();
            $attr_list[$key]['type_name']=$type_name['type_name'];
        }
     
        ob_clean();
        $list=array('count'=>$count,'data'=>$attr_list);

        return $list;
    }
}

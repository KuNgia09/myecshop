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

class GoodsType extends Controller
{
    // 显示商品类型表单
    public function showType()
    {
        return $this->fetch('show_type');
    }

    public function getTypeList()
    {
        // 商品类型
        $goods_type=queryList('ecs_goods_type');
        // dump($goods_type);
        foreach ($goods_type as $key=>$type) {
            // 计算每种商品类型的属性个数
            $count=Db::name('ecs_attribute')->where('type_id', $type['type_id'])->count();
            $goods_type[$key]['attr_count']=$count;
        }
        // dump($goods_type);
        // 获取商品类型的数目
        $count=Db::table('ecs_goods_type')->count();
       
        
        $list=array('count'=>$count,'data'=>$goods_type);
        // ajax请求可以直接返回$list 默认是json格式
        // 普通请求返回$list会报错variable type error： array
        // 在app.php的设置如下:
        // 默认输出类型
        //'default_return_type'    => 'html',
        // 默认AJAX 数据返回格式,可选json xml ...
        //'default_ajax_return'    => 'json',
        return $list;
    }
}

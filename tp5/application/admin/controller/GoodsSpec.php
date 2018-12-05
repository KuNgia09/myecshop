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

// 商品规格
class GoodsSpec extends Controller
{
    // 显示商品规格
    public function showSpec()
    {
        return $this->fetch();
    }

    public function getSpecList()
    {
        // 使用内连结查询
        $sql="select id as spec_id,name as spec_name,is_show,type_name from ecs_goods_spec INNER JOIN ecs_goods_type on ecs_goods_spec.type_id=ecs_goods_type.type_id";
        // 查询出规格id 规格所属的分类
        $spec_info=Db::query($sql);
        dump($spec_info);
        foreach ($spec_info as $key=>$value) {
            $spec_items=Db::table('ecs_goods_spec_item')->where('spec_id', $value['spec_id'])->select();
            if (!empty($spec_items)) {
                $str='';
                foreach ($spec_items as $i=>$value_item) {
                    $str.=$value_item['item'];
                    if ($i!=count($spec_items)-1) {
                        $str.=',';
                    }
                }
                $spec_info[$key]['spec_content']=$str;
            } else {
                $spec_info[$key]['spec_content']='';
            }
            dump($spec_items);
        }
        dump($spec_info);
        ob_clean();

        $count=Db::table('ecs_goods_spec')->count();
        $list=array('count'=>$count,'data'=>$spec_info);
        return $list;
    }

    // 添加商品规格表单
    public function add()
    {
        $type=Db::table('ecs_goods_type')->field('type_id,type_name')->select();
        $this->assign('type', $type);
        return $this->fetch();
    }

    //保存商品规格
    public function addOk()
    {
        $data=[];
        $data['name']=$_POST['name'];
        $data['type_id']=$_POST['type_id'];
        $data['sort']=$_POST['type_id'];
        $data['is_show']=$_POST['is_show'];
      
        Db::table('ecs_goods_spec')->insert($data);
        $insert_id=Db::table('ecs_goods_spec')->getLastInsID();
        // 规格内容每项是一行一行地写入
        $items=$_POST['items'];
        $opts=explode(PHP_EOL, $items);

        $spec_content['spec_id']=$insert_id;
        // 一项规格内容作为一行数据插入
        foreach ($opts as $key=>$value) {
            $spec_content['item']=$value;
            Db::table('ecs_goods_spec_item')->insert($spec_content);
        }
        dump($opts);
    }
}

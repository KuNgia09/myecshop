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

class GoodsCategory extends Controller
{
    // 以如下形式拼接字符串
    private function joinId($data)
    {
        $cat_id_str='(';
        foreach ($data as $key=>$value) {
            if ($key==count($data)-1) {
                $cat_id_str.='"'.$value['cat_id'].'"';
            } else {
                $cat_id_str.='"'.$value['cat_id'].'",';
            }
        }
        $cat_id_str.=')';
        return $cat_id_str;
    }
    // 显示商品分类
    public function showCategory()
    {
        return $this->fetch('show_category');
    }

    // 显示添加商品分类模板
    public function addCategory()
    {
        //获取商品分类
        $cats=Db::table('ecs_category')->field('cat_id,parent_id,cat_name')->select();
        // 默认递归深度是2层
        $list_cats=child($cats, 0);
        
        $this->assign('list_cats', $list_cats);
        return $this->fetch('add_category');
    }

    public function addCategoryOK()
    {
        dump($_POST);
        // 添加商品分类
        $data=[];
        $data['cat_name']=$_POST['cat_name'];
        $data['parent_id']=$_POST['parent_id'];
        $data['cat_desc']=$_POST['cat_desc'];
        $data['is_show']=$_POST['is_show'];
        // 关于cat_name为'' 可以插入的情况 参考如下的文章
        // mysql中查询字段为null或者不为null:https://blog.csdn.net/u010442302/article/details/52335401
        // 一千个不用 Null 的理由 https://my.oschina.net/leejun2005/blog/1342985
        Db::table('ecs_category')->insert($data);
        // 重定向到商品分类列表
        $this->success('添加分类成功', 'goodsCategory/showCategory');
        die;
    }
    // ajax获取分类列表
    public function getCategoryList()
    {
        $one_category=[];
        $two_category=[];
        $three_category=[];

        // 获取所有的分类 不需要过滤
        $limit=isset($_GET['limit'])?$_GET['limit']:4;
        $offset=isset($_GET['offset'])?$_GET['offset']:0;

        // 以一级分类作为分页参数
        dump($_GET);
        $sql="SELECT COUNT(*) as count from ecs_category where parent_id=0 LIMIT 1";
        // 获取一级分类的个数
      
        $one_cat_count=Db::query($sql)[0]['count'];
        dump($one_cat_count);
        // 先获取一级分类
        $sql="SELECT * FROM ecs_category where parent_id=0 LIMIT $limit OFFSET $offset";
        $one_category=DB::query($sql);
      
        dump($one_category);
        if (!empty($one_category)) {
            // 获取一级分类下的id
            $cat_id_str=$this->joinId($one_category);
            $sql="SELECT * FROM ecs_category where (parent_id in $cat_id_str)";
            // 二级分类
            $two_category=Db::query($sql);
            if (!empty($two_category)) {
                $cat_id_str=$this->joinId($two_category);
                $sql="SELECT * FROM ecs_category where (parent_id in $cat_id_str)";
                $three_category=Db::query($sql);
            }
        }
      
        // 将一级分类 二级 三级分类合并
        $goods_category=array_merge($one_category, $two_category, $three_category);
        $args=['cat_id','parent_id','cat_name'];
        $list_cats=tree($goods_category, 0, 0, $args);
        dump($list_cats);

      
        ob_clean();
        // 转换为json
        $list=array('count'=>$one_cat_count,'data'=>$list_cats);
        return $list;
    }
}

<?php
namespace app\common\model;

use think\Model;
use think\Db;

class Article extends Model
{
    // 设置表名
    protected $table = 'db_article';

    // protected $pk = 'cat_id';


    //获取文章分类列表
<<<<<<< HEAD
    public function getList()
    {
        $article_categories = Db::table('db_article_category')->where(['status'=>1])->order("sort")->limit(5)->column('id,name');
        $result = [];
        if (empty($article_categories)) {
            return array();
        }
      
        foreach ($article_categories as $key=>$value) {
            $articles = $this->field('id,name')
=======
    public function getList(){
      
     
      $article_categories = Db::table('db_article_category')->where(['status'=>1])->order("sort")->limit(5)->column('id,name');
      $result = [];
      if (empty($article_categories)) {
          return array();
      }
      
      foreach($article_categories as $key=>$value){
          $articles = $this->field('id,name')
>>>>>>> e5b37835f76dcc04fcd66ebfa9dfdb818ae619b9
                    ->where(['status'=>1,'article_category_id'=>$key])
                    ->order('create_time')
                    ->limit(6)
                    ->select();
<<<<<<< HEAD
            $result[$value] = $articles;
        }
        return $result;
    }
}
=======
          $result[$value] = $articles;
      }
    return $result;
}
}
>>>>>>> e5b37835f76dcc04fcd66ebfa9dfdb818ae619b9

<?php

namespace app\home\controller;

use think\Controller;
// use think\Cache;
use think\Db;
use app\common\traitClass\SmsVerification;
use app\common\traitClass\InternetTopTrait;

class Base extends Controller
{

  use SmsVerification;
  use InternetTopTrait;

  public function initialize()
  {
      // //检测平台
      // $isPass =  Tool::isMobile();
      
      // if ($isPass) {
      //     header('Location:/mobile/index.html');
      // }
      
      // 网站是否维护
      // $isOpen = $this->getConfig('is_open');
      // if ($isOpen == 1) {
      //     echo file_get_contents('./ErrorFiles/index.html');
      //     die();
      // }
      
      // 公用数据（带测试查不多，在打开缓存后，在删除下面的测试公用数据）
      // 商品分类
     
      $goods_category_model = new \app\common\model\GoodsCategory();

      $goods_categories = $goods_category_model->getList('id,cat_name,parent_id');
      
     
      
      // 底部文章分类
      $article_model = model('Article');
      $article_lists=$article_model->getList();
      
      $str = 'ShopsN全网开源<a style="padding: 0px" href="http://www.shopsn.net">商城系统</a>&nbsp';
      
      // 导航
      $nav_data = cache('nav_data');
      
      if (! $nav_data) {
          $nav_data = Db::table("db_nav")->field("id,nav_titile,link,type")
              ->where([
              'status' => 1
          ])
              ->order('sort')
              ->limit(11)
              ->select();
          cache('nav_data', $nav_data, 600);
      }
      
      // 购物车数量
      $cartCount = 0;
      
      // 未使用代金券数量
      $UsableCoupon = 0;
      
      // 已使用代金券数量
      $UsedCoupon = 0;
      
      // 已过期代金券
      $OverdueCoupon = 0;
      
      $carts = [];
      
      
      // 代金券总数
      $z_count = $UsedCoupon + $OverdueCoupon + $UsableCoupon;
      
     
      
     
      // 判断是否需要展示商品分类,首页展示,其它页面折叠
      if (request()->controller() == 'Index') {
          $show_categroy = true;
      } else {
          $show_categroy = false;
      }
      // 获取组配置
      
      $information = $this->getSiteInformation();
      // 底部公司名称
      $company_name = $this->get_intnetConfig()['company_name'];
      
      $this->assign("goods_categories", $goods_categories);
      
      $this->assign('z_count', $z_count);
      
      $this->assign('OverdueCoupon', $OverdueCoupon);
      
      $urls = "/index.php/home/" . request()->controller() . "/" . request()->action() ;
      
      $this->assign('UsableCoupon', $UsableCoupon);
      
      $this->assign('UsedCoupon', $UsedCoupon);
      
      $this->assign('nowurl', $urls);
      
      $this->assign('carts', $carts);
      
      $this->assign('show_category', $show_categroy);
      
      $ip=request()->ip();
      $this->assign('areaLocation', $ip);
      
      $this->assign("nav_data", $nav_data);
      
      $this->assign("article_lists", $article_lists);
      
      $this->assign($information); // 网站设置
      
      $this->assign('company_name', $company_name);
      
      $this->assign('str', $str);
      
      // trait里的static函数 使用self::
      $this->assign('hot_words', self::keyWord());
      
     
      
      $this->assign('cartCount', $cartCount);
      
      $this->assign('cart_goods', '');
      
      $this->assign('intnetTitle', $information['intnet_title']);
  }
 }
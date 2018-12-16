<?php

namespace app\home\controller;

use think\Controller;
// use think\Cache;
use think\Db;
use app\common\traitClass\SmsVerification;

class Base extends Controller
{
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
      
      // $str = $this->getFamily();
      
      // 导航
      $navigatData = cache('navigatData');
      
      if (! $navigatData) {
          $navigatData = Db::table("db_nav")->field("id,nav_titile,link,type")
              ->where([
              'status' => 1
          ])
              ->order('sort')
              ->limit(11)
              ->select();
          cache('navigatData', $navigatData, 15);
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
      // 判断是否有session值
      if (! empty($_SESSION['user_id'])) {
          
          $this->assign('userId', [
              'user_name' => $_SESSION['user_name']
          ]);
          $where = [];
          // 查询购物车条数以及相关信息
          $where['a.user_id'] = $_SESSION['user_id'];
          $where['a.is_del'] = 0;
          $where['b.status'] = array(
              'lt',
              3
          );
          $cartCount = M('goods_cart as a')->field('a.id,a.goods_num,a.price_new,b.title,a.goods_id,a.buy_type,b.p_id')
              ->join('db_goods as b ON a.goods_id=b.id')
              ->where($where)
              ->count();
          
          // dump($cartCount);exit;
          $carts = M('goods_cart as a')->field('a.id,a.goods_num,a.price_new,b.title,a.goods_id,a.buy_type,b.p_id')
              ->join('db_goods as b ON a.goods_id=b.id')
              ->where($where)
              ->order('a.buy_type ASC')
              ->limit(5)
              ->select();
          $a = GoodsModel::getInitnation();
          $carts = $a->goods_image($carts);
          // dump($carts);exit;
          // 查询可用优惠券数量
          $Usable['user_id'] = $_SESSION['user_id'];
          $Usable['use_time'] = '';
          $Usable['use_end_time'] = array(
              'GT',
              time()
          );
          $UsableCoupon = M('coupon_list as a')->join('left join db_coupon as b on a.c_id=b.id')
              ->where($Usable)
              ->count();
          // 查询已用优惠券数量
          $Used['user_id'] = $_SESSION['user_id'];
          $Used['use_time'] = array(
              'neq',
              0
          );
          $UsedCoupon = M('coupon_list')->where($Used)->count();
          // 查询已过期优惠券数量
          $Over['user_id'] = $_SESSION['user_id'];
          $Over['use_time'] = '';
          $Over['use_end_time'] = array(
              'LT',
              time()
          );
          $OverdueCoupon = M('coupon_list as a')->join('left join db_coupon as b on a.c_id=b.id')
              ->where($Over)
              ->count();
          
          $member_status = $_SESSION['member_status'];
          $this->assign('member_status', $member_status);
          $mes['user_id'] = $_SESSION['user_id'];
          $mes['status'] = 0;
          $this->mes_count = M('order_logistics_message')->where($mes)->count();
      }
      
      // 代金券总数
      $z_count = $UsedCoupon + $OverdueCoupon + $UsableCoupon;
      
     
      
     
      // 判断是否需要展示商品分类,首页展示,其它页面折叠
      if (request()->controller() == 'Index') {
          $show_categroy = true;
      } else {
          $show_categroy = false;
      }
      // 获取组配置
      
      $information = $this->getIntnetInformation();
      // 底部公司名称
      $company_name = $this->get_intnetConfig()['company_name'];
      
      $this->assign("goods_categories", $goods_categories);
      
      $this->assign('z_count', $z_count);
      
      $this->assign('OverdueCoupon', $OverdueCoupon);
      
      $urls = "/index.php/Home/" . CONTROLLER_NAME . "/" . ACTION_NAME;
      
      $this->assign('UsableCoupon', $UsableCoupon);
      
      $this->assign('UsedCoupon', $UsedCoupon);
      
      $this->assign('nowurl', $urls);
      
      $this->assign('carts', $carts);
      
      $this->assign('show_category', $show_categroy);
      
      $this->assign('areaLocation', $this->getLocationArea());
      
      $this->assign("navs", $navigatData);
      
      $this->assign("article_lists", $article_lists);
      
      $this->assign($information); // 网站设置
      
      $this->assign('company_name', $company_name);
      
      $this->assign('str', $str);
      
      $this->assign('hot_words', self::keyWord());
      
      $this->assign('navs', $nav_data);
      
      $this->assign('cartCount', $cartCount);
      
      $this->assign('cart_goods', S('cart_goods'));
      
      $this->assign('intnetTitle', $information['intnet_title']);
  }
 }
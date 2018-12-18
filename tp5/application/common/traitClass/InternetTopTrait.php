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

namespace app\common\traitClass;

<<<<<<< HEAD
/**
 * 头部trait
 */
trait InternetTopTrait
{
    private static function userDataExits()
=======


/**
 * 头部trait 
 */
trait InternetTopTrait 
{
    private static function userDataExits ()
>>>>>>> e5b37835f76dcc04fcd66ebfa9dfdb818ae619b9
    {
        // 获取购物车&用户信息
        return $name = M('user')->field('user_name')->where(['id' => $_SESSION['user_id']])->find();
    }
    
    /***/
    public function showMeYourShe()
    {
        Hook::listen(ASDKLJHKJHJKHKUH);
    }

    /**
     * 关键词搜索
     */
    protected static function keyWord()
    {
        // 获取关键词 及其分类
        $data = model('HotWords')->getKeyWord();
        return $data;
    }
    
    protected function isLogin($isPjax = false)
    {
<<<<<<< HEAD
        if (empty($_SESSION['user_id']) && !$isPjax) {
            $this->redirect('Public/login');
        } elseif (empty($_SESSION['user_id']) && $isPjax) {
=======
        if(empty($_SESSION['user_id']) && !$isPjax) {
            $this->redirect('Public/login');
        } else if (empty($_SESSION['user_id']) && $isPjax) {
>>>>>>> e5b37835f76dcc04fcd66ebfa9dfdb818ae619b9
            $this->ajaxReturnData(null, 0, '请登录');
        }
    }
    
    /**
<<<<<<< HEAD
     * 分站点
=======
     * 分站点 
>>>>>>> e5b37835f76dcc04fcd66ebfa9dfdb818ae619b9
     */
    public function getSite()
    {
        $model = BaseModel::getInstance(SiteModel::class);
        
        $data = $model->getData();
        
        $regionModel = BaseModel::getInstance(RegionModel::class);
       
        Tool::connect('parseString');
        
        $data = $regionModel->getAreaName($data, SiteModel::$areaId_d);
        
        $data  = $model->geographical($data);
        
        $def = $model->getDefault();
      
        $def  = $regionModel->getDataDefault($def, SiteModel::$areaId_d);
    
        $this->defaultData = $def;
        
        $this->regModel = RegionModel::class;
        
        $this->siteData = $data;
        
        $this->siteModel = SiteModel::class;
    }
    
    /**
<<<<<<< HEAD
     * 根据当前ip地址 获取所在区域
=======
     * 根据当前ip地址 获取所在区域 
>>>>>>> e5b37835f76dcc04fcd66ebfa9dfdb818ae619b9
     */
    public function getLocationArea($name='country')
    {
        $ipLocationObj = new IpLocation();
        $area = $ipLocationObj->getlocation();
        return empty($area[$name]) ? $area : $area[$name];
    }
    
    public function getList()
    {
        $this->getSite();//分站点
        $this->areaConfig = C('AreaList');
        $this->display('public/areaList');
    }
    
<<<<<<< HEAD
    public function getFamily()
=======
    public function getFamily ()
>>>>>>> e5b37835f76dcc04fcd66ebfa9dfdb818ae619b9
    {
        $str = S('str');
        
        if (empty($str)) {
            Hook::listen('reade', $str);
        } else {
            return $str;
        }
        
        if (empty($str)) {
            return null;
        }
        S('str', $str, 30);
        
        return $str;
    }
    
    /**
     * 文章分类页
     */
<<<<<<< HEAD
    public function arctile()
=======
    public function arctile ()
>>>>>>> e5b37835f76dcc04fcd66ebfa9dfdb818ae619b9
    {
        $article_category_model = D('Article');
        if (! $article_lists = S('article_lists')) {
            // 准备商品分类数据
            $article_lists = $article_category_model->getList();
            S('article_lists', $article_lists, 30);
        }
        return $article_lists;
    }
<<<<<<< HEAD
}
=======
    
}
>>>>>>> e5b37835f76dcc04fcd66ebfa9dfdb818ae619b9

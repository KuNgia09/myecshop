<?php

namespace app\admin\controller;

/**
 * Note:
 * Importing rules are per file basis, meaning included files will NOT inherit the parent file's importing rules.
 */
require_once './vendor/autoload.php';

use think\Controller;
use think\DB;
use app\admin\common\tool\ArrayChildren;
use think\Session;
use Kint\Kint;

// 引入工具类



class Goods extends Controller
{
    // 显示商品列表页面
    public function showList()
    {
      
        //获取商品分类
        $cats=Db::table('ecs_category')->field('cat_id,parent_id,cat_name')->select();
        
        $list_cats=child($cats, 0);
        // Kint::dump($list_cats);

        // 获取品牌列表
        $brands=Db::table('ecs_brand')->field('brand_id,brand_name')->select();
        // Kint::dump($brands);
        
        $this->assign('list_cats', $list_cats);
        $this->assign('list_brands', $brands);

        return $this ->fetch('showList');
    }

    //显示添加商品页面
    public function add()
    {
        // 先获取一级分类
        $list_one_cats=Db::table('ecs_category')->field('cat_id,cat_name,parent_id')->where('parent_id',0)->select();

        //获取商品的品牌
        $goods_brand=Db::table('ecs_brand')->field('brand_id,brand_name')->select();

        // 获取供应商信息
        $suppliers=Db::table('ecs_suppliers')->field('suppliers_id,suppliers_name')->select();
        // 获取商品类型
        $goods_type=Db::table('ecs_goods_type')->field('type_id,type_name')->select();

        $this->assign('list_one_cats', $list_one_cats);
        $this->assign('list_brand', $goods_brand);
        $this->assign('list_suppliers', $suppliers);
        $this->assign('list_goodstype', $goods_type);
        // return $this ->fetch('add');
        return $this ->fetch('add');
    }

    

    // 获取添加新商品的信息
    public function addOK()
    {
        $data=[];
        $data['goods_name']=$_POST['goods_name'];
        $data['goods_sn']=$_POST['goods_sn'];
        // 商品三级分类
        $data['cat_id']=$_POST['three_cat'];
        $data['goods_sn']=$_POST['goods_sn'];
        $data['brand_id']=$_POST['brand_id'];
        $data['suppliers_id']=$_POST['suppliers_id'];
        // 市场价
        $data['shop_price']=$_POST['shop_price'];
        // 促销价
        $data['promote_price']=$_POST['promote_price'];
        // 促销日期
        $data['promote_start_date']=$_POST['promote_start_date'];
        $data['promote_end_date']=$_POST['promote_end_date'];

        // 富文本编辑器 商品描述
        $data['goods_desc']=$_POST['goods_desc'];

        //对商品描述进行过滤
        // 商品重量=质量*单位
        $data['goods_weight']=$_POST['goods_weight']*$_POST['weight_unit'];
        
        $data['goods_number']=$_POST['goods_number'];
        $data['warn_number']=$_POST['warn_number'];

        // 商品关键词
        $data['keywords']=$_POST['keywords'];
        // 商品简洁
        $data['goods_brief']=$_POST['goods_brief'];
        // 商品备注
        $data['seller_note']=$_POST['seller_note'];

        // 插入商品的基本信息
        Db::table('ecs_goods')->insert($data);
        // 获取插入新商品的id
        $goodsId = Db::table('ecs_goods')->getLastInsID();
        
        // 商品属性存在的话 代表选择了属性
        if (isset($_POST['attr_id_list'])) {
            // 遍历所有的属性id
            $attr_id_list=$_POST['attr_id_list'];
            $attr_value_list=$_POST['attr_value_list'];
            $attr_value_list_trim=[];
            foreach ($attr_value_list as $key=>$attr_value) {
                // 如果属性值为空或者为0 移除当前属性
                if (empty($attr_value)) {
                    // 使用unset不会改变索引
                    unset($attr_id_list[$key]);
                }
            }
            $data_attr=[];
            
            foreach ($attr_id_list as $key=>$attr_id) {
                $res=['goods_id'=>$goodsId,'attr_id'=>$attr_id,'attr_value'=>$attr_value_list[$key]];
                $data_attr[]=$res;
            }
           
            //  插入多维数组 将商品属性值保存到商品属性表中
            Db::table('ecs_goods_attr')->insertAll($data_attr);
        }
        // 遍历商品规格
        if(isset($_POST['item'])){
          $items=$_POST['item'];
          // 获取商品有多少种规格
          $spec_cont=count($items);
        }

    }

  

    // ajax获取商品列表
    public function getGoodsList()
    {
        // 获取商品列表
        $goods=queryList('ecs_goods');
        $count=Db::table('ecs_goods')->count();
        // Kint::dump('商品数量:'.$goods);
        $list=array('count'=>$count,'data'=>$goods);
        return $list;
    }

    //搜索过滤获取商品列表
    public function getGoodsListBySearch()
    {
        $data=Db::query("select * from ecs_goods where goods_id >50");
        $list=array('count'=>count($data),'data'=>$data);
        return $list;
    }

    // 根据商品类型获取对应的商品属性 并返回DOM结构
    public function getGoodsAttr()
    {
        
        // var_dump($_POST);
        // 获取商品类型的id
        $id=isset($_POST['id'])?$_POST['id']:0;
        if ($id==0) {
            return 0;
        }
        // 根据商品类型获取属性表
        $attribute=Db::table('ecs_attribute')->where('type_id', $id)->select();
        $str='<div id="attr_wrapper">';

        
            
        foreach ($attribute as $value) {
            $temp='';
            $temp.='<div class="form-group">';
            $temp.='<label class="col-sm-2 control-label">'.$value['attr_name'].'</label>';
            // 判断单个属性的类型
            switch ($value['attr_input_type']) {
                // 文本框
                case 0:
                     // 属性的id全部保存在attr_id_list数组，属性的值全部保存在attr_value_list数组
                    $temp.='<div class="col-sm-2">';
                    $temp.='<input type="hidden" name="attr_id_list[]" value="'.$value['attr_id'].'">';
                    $temp.='<input type="text" name="attr_value_list[]" class="form-control">';
                    $temp.='</div>';
                    break;
                // 下拉框
                case 1:
                    $temp .= '<div class="col-sm-2">';
                    $temp.='<input type="hidden" name="attr_id_list[]" value="'.$value['attr_id'].'">';
                    $temp .= '<select class="form-control" name="attr_value_list[]">';
                    $temp .= "<option value='0'>请选择...</option>";
                    // 以换行符为分隔符来获取下拉框的值列表
                    $opts = explode(PHP_EOL, $value['attr_values']);
                    foreach ($opts as $opt) {
                        $temp .="<option>$opt</option>";
                    }
                    $temp .='</select>';
                    $temp.='</div>';
                    break;

            }
            $temp.='</div>';
            $str.=$temp;
        }
        $str=$str.'</div>';
        return $str;
    }
    

    // 根据商品类型获取对应的商品规格 并返回DOM结构
    public function getGoodsSpec()
    {
        $type_id=isset($_POST['id'])?$_POST['id']:4;

        // 当前商品类型下的规格 例如 颜色 尺寸等
        $specs=Db::table('ecs_goods_spec')->where('type_id', $type_id)->select();
        dump($specs);
        if (empty($specs)) {
            return 0;
        }
        $html='<table class="table table-bordered" id="goods_spec_table">';
        $html.='<tr> <td colspan="2"><b>商品规格:</b></td></tr>';

        foreach ($specs as $spec) {
            // 获取规格id
            $spec_id=$spec['id'];
        
            // 根据规格id获取规格项的内容
            $spec_items=Db::table('ecs_goods_spec_item')->where('spec_id', $spec_id)->select();

            // 如果当前规格没有内容 直接跳过
            if (!empty($spec_items)) {
                $html.='<tr>';
                $html.='<td>'.$spec['name'].'</td>';
                $html.='<td>';
                foreach ($spec_items as $item) {
                    $html.='<button type="button" ';
                    $html.='onclick="addSpecItem(this)"';
                    $html.='data-spec_id="'.$spec_id.'" ';
                    $html.='data-item_id="'.$item['id'].'" ';
                    $html.='class="my-btn btn btn-default" >';
                    $html.=$item['item'];
                    $html.='</button>';
                }
                $html.='</td>';
                $html.='</tr>';
            }
        }
        $html.='</table>';
        $html.='<div id="goods_spec_table2"></div>';
        dump($html);
        ob_clean();
        return $html;
    }

    // 根据选中的规格项获取笛卡儿积的表格
    public function getAddContentBySpec()
    {
        // $array_children=new \app\admin\common\tool\ArrayChildren($_POST);
        $array_children=new ArrayChildren($_POST);
        // 获取笛卡尔积
        $data=$array_children->parseSpecific($_POST['spc']);
        // 查询某一列的值用column
        $spec=Db::table('ecs_goods_spec')->column('id,name');
        $spec_item=Db::table('ecs_goods_spec_item')->column('id,spec_id,item');

        $cloName = $data['arrayKeys'];
        $str = "<table class='table table-bordered' id='spec_input_tab'>";
        $str .="<tr>";
        // 显示第一行的数据
        foreach ($cloName as $k => $v) {
            // 获取规格项的名称 例如颜色尺寸
            $str .=" <td><b>{$spec[$v]}</b></td>";
        }
        $str .="<td><b>价格</b></td>
               <td><b>会员价格</b></td>
                <td><b>库存</b></td>
                <td><b>商品编码</b></td>
             </tr>";
        // 遍历笛卡尔积的每项
        foreach ($data['cartesianProduct'] as $key => $value) {
            $str .="<tr>";
            $itemKeyName = array();
            $flag = 0;
            foreach ($value as $k2 => $v2) {
                $str .="<td>{$spec_item[$v2]['item']}</td>";
                $itemKeyName[$v2] = $spec[$spec_item[$v2]['spec_id']].':'.$spec_item[$v2]['item'];
            }
            // 根据键名排序
            ksort($itemKeyName);
            // 将规格项以_连接
            $itemKey = implode('_', array_keys($itemKeyName));
            $str .="<td><input type='text' name='item[$itemKey][".'price'."]'  onkeyup='this.value=this.value.replace(/[^\d.]/g,\"\")' onpaste='this.value=this.value.replace(/[^\d.]/g,\"\")' /></td>";
              
            $str .="<td><input type='text' name='item[$itemKey][".'preferential'."]'  onkeyup='this.value=this.value.replace(/[^\d.]/g,\"\")' onpaste='this.value=this.value.replace(/[^\d.]/g,\"\")' /></td>";
                    
            $str .="<td><input type='text' name='item[$itemKey][".'storeCount'."]'  onkeyup='this.value=this.value.replace(/[^\d.]/g,\"\")' onpaste='this.value=this.value.replace(/[^\d.]/g,\"\")' /></td>";
                   
            $str .="<td><input type='text' name='item[$itemKey][".'sku'."]' /></td>";
            $str .='</tr>';
        }
       
    
    
        $str .='</table>';

        return $str;
    }

    
    //获取子分类
    public function getSubCats()
    {
      // 获取当前分类id
      $cat_id=$_POST['id'];
      $sub_cats=Db::table('ecs_category')->field('cat_id,cat_name,parent_id')->where('parent_id',$cat_id)->select();
      $html='';
      foreach($sub_cats as $cat){
        $html.="<option value={$cat['cat_id']}>{$cat['cat_name']}</option>";
      }
      return $html;


    }
}
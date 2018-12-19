<?php

namespace app\admin\controller;

/**
 * Note:
 * Importing rules are per file basis, meaning included files will NOT inherit the parent file's importing rules.
 */
require_once './vendor/autoload.php';

use think\Controller;
use think\DB;
use think\Session;
use Kint\Kint;
use app\common\tool\DbUtil;
use app\common\tool\ArrayChildren;
use think\Validate;
use app\admin\validate\Goods as GoodsValidate;
use app\admin\logic\GoodsLogic;

class Goods extends Base
{
    // 显示商品列表页面
    public function showList()
    {
        //获取商品分类
        $cats=Db::name('goods_category')->field('id as cat_id,parent_id,cat_name')->select();
        
        $list_cats=DbUtil::child($cats, 0);
        // Kint::dump($list_cats);

        // 获取品牌列表
        $brands=Db::name('brand')->field('brand_id,brand_name')->select();
        // Kint::dump($brands);
        
        $this->assign('list_cats', $list_cats);
        $this->assign('list_brands', $brands);

        return $this ->fetch('showList');
    }

    //显示添加商品页面
    public function add()
    {
        // 先获取一级分类
        $list_one_cats=Db::name('category')->field('cat_id,cat_name,parent_id')->where('parent_id', 0)->select();

        //获取商品的品牌
        $goods_brand=Db::name('brand')->field('brand_id,brand_name')->select();

        // 获取供应商信息
        $suppliers=Db::name('suppliers')->field('suppliers_id,suppliers_name')->select();
        // 获取商品类型
        $goods_type=Db::name('goods_type')->field('type_id,type_name')->select();

        $this->assign('list_one_cats', $list_one_cats);
        $this->assign('list_brand', $goods_brand);
        $this->assign('list_suppliers', $suppliers);
        $this->assign('list_goodstype', $goods_type);
        // return $this ->fetch('add');
        return $this ->fetch('add');
    }

    /**
     * 保存商品
     *
     * @return void
     */
    public function save()
    {
        $data=input('post.');
        // 商品规格
        $spec_item = input('item/a');
        $validate = new GoodsValidate();// 数据验证
        // 批量验证
        if (!$validate->batch()->check($data)) {
            $error = $validate->getError();
            $error_msg = array_values($error);
            $return_arr = ['status' => 0, 'msg' => $error_msg[0], 'result' => $error];
            $this->ajaxReturn($return_arr);
        }

      

        // 启动事务
        Db::startTrans();
        try {
            $goods = new \app\common\model\Goods();
            // 第二个字段要设置为true 触发模型的修改器
            $goods->data($data, true);
            $goods->last_update = time();
            $goods->save();
            $goods_id=$goods->goods_id;
            $GoodsLogic = new GoodsLogic();
            $GoodsLogic->afterSave($goods_id);

            // 提交事务
            Db::commit();
            $return_arr = ['status' => 1, 'msg' =>'操作成功'];
            $this->ajaxReturn($return_arr);
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            $return_arr = ['status' => 0, 'msg' =>'操作失败'];
            $this->ajaxReturn($return_arr);
        }
    }

    
    
    /**
     * 弹出iframe框 获取子商品
     *
     * @return void
     */
    public function lookGoods($id)
    {
        if (!is_numeric($id)) {
            return ;
        }
        //查看当前id下的子商品信息
        $goods=Db::name('goods')->where('p_id', $id)->select();
        $this->assign('data_goods', $goods);
        return $this->fetch('look_goods');
    }

    

    // ajax获取商品列表
    public function getGoodsList()
    {
        // 检查分页查询参数
        $length=isset($_GET['limit'])?$_GET['limit']:"";
        $offset=isset($_GET['offset'])?$_GET['offset']:"";
        $sort=isset($_GET['sort'])?$_GET['sort']:"";
        $order=isset($_GET['order'])?$_GET['order']:"";
        $params=[];
        $params['length']=$length;
        $params['offset']=$offset;
        $params['sort']=$sort;
        $params['order']=$order;
        
        $sql="select goods_id,goods_name,shop_price,is_shelves,is_recommend,stock from ecs_goods ";
        $sql=$this->joinSql($sql, $params);
            
        $goods=Db::query($sql);

        $count=Db::name('goods')->count();
       
        $list=array('count'=>$count,'data'=>$goods);
        return $this->ajaxReturn($list);
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
        $attribute=Db::name('attribute')->where('type_id', $id)->select();
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
        $specs=Db::name('goods_spec')->where('type_id', $type_id)->select();
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
            $spec_items=Db::name('goods_spec_item')->where('spec_id', $spec_id)->select();

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
        // 选中颜色:白色 黑色
        // 尺寸:5寸 6寸
        // 会生成如下的结构
        // spc:array(2)
        // 3:array(2)
        // 0:"20"
        // 1:"21"
        // 4:array(2)
        // 0:"23"
        // 1:"24"
        $array_children=new ArrayChildren($_POST);
        // 获取笛卡尔积

        // 生成的笛卡儿积
        // artesianProduct:array(4)
        // 0:array(2)
        // 0:"21"
        // 1:"24"
        // 1:array(2)
        // 0:"21"
        // 1:"23"
        // 2:array(2)
        // 0:"20"
        // 1:"24"
        // 3:array(2)
        // 0:"20"
        // 1:"23"
        $data=$array_children->parseSpecific($_POST['spc']);
        // 查询某一列的值用column
        // 查询规格名
        // array(5)
        // 2:"ddd"
        // 3:"颜色"
        // 4:"尺寸"
        // 5:"单位"
        // 6:"等分"
        $spec=Db::name('goods_spec')->column('id,name');

        $spec_item=Db::name('goods_spec_item')->column('id,spec_id,item');

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
                // 具体规格项值 如白色
                $str .="<td>{$spec_item[$v2]['item']}</td>";
                // $spec[$spec_item[$v2]['spec_id']]:规格项名
                // $spec_item[$v2]['item']:规格项值
                // $itemKeyName[$v2]=规格名:规格项值 例如如下:颜色:白色
                $itemKeyName[$v2] = $spec[$spec_item[$v2]['spec_id']].':'.$spec_item[$v2]['item'];
            }
            // 获取key_name
            $key_name='';
            foreach ($itemKeyName as $value) {
                $key_name.=$value.'  ';
            }
            // 根据键名排序
            ksort($itemKeyName);
            // 将规格项以_连接
            $itemKey = implode('_', array_keys($itemKeyName));
            $str .="<td><input type='text' name='item[$itemKey][".'price'."]'  onkeyup='this.value=this.value.replace(/[^\d.]/g,\"\")' onpaste='this.value=this.value.replace(/[^\d.]/g,\"\")' /></td>";
              
            $str .="<td><input type='text' name='item[$itemKey][".'preferential'."]'  onkeyup='this.value=this.value.replace(/[^\d.]/g,\"\")' onpaste='this.value=this.value.replace(/[^\d.]/g,\"\")' /></td>";
                    
            $str .="<td><input type='text' name='item[$itemKey][".'store_count'."]'  onkeyup='this.value=this.value.replace(/[^\d.]/g,\"\")' onpaste='this.value=this.value.replace(/[^\d.]/g,\"\")' /></td>";
                   
            $str .="<td><input type='text' name='item[$itemKey][".'sku'."]' />
                        <input type='hidden' name='item[$itemKey][".'key_name'."]' value='$key_name' />
                    </td>";
           
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
        $level=$_POST['level'];
        $sub_cats=Db::name('category')->field('cat_id,cat_name,parent_id')->where('parent_id', $cat_id)->select();
        
        if ($level==2) {
            $html='<option value="0">请选择二级分类</option>';
        } elseif ($level==3) {
            $html='<option value="0">请选择三级分类</option>';
        } else {
            $html='<option value="0">请选择分类</option>';
        }
        foreach ($sub_cats as $cat) {
            $html.="<option value={$cat['cat_id']}>{$cat['cat_name']}</option>";
        }
        return $html;
    }
}

<?php


// 获取层级列表
function tree($arr, $pid=0, $level=0, $args)
{
    static $res=array();
    $id_name=$args[0];
    $pid_name=$args[1];
    // 要分类名称的表字段名称
    $cat_name=$args[2];

    foreach ($arr as $value) {
        //如果找到父类id
        if ($value[$pid_name]==$pid) {
            $value['level']=$level;
            // $value[$cat_name]=str_repeat(' ',$level).$value[$cat_name];
            $res[]=$value;
            

            tree($arr, $value[$id_name], $level+1, $args);
        }
    }
    
    return $res;
}

//将平行的二维数组，转成包含关系的多维数组 默认深度是2层
function child($arr, $pid = 0, $level=0, $deep=2)
{
    if ($level>=$deep) {
        return [];
    }
    $res = array();
    foreach ($arr as $v) {
        if ($v['parent_id'] == $pid) {
            //找到了，继续查找其后代节点
            //$temp = $this->child($arr,$v['cat_id']);
            //将找到的结果作为当前数组的一个元素来保存，其下标是child
            //$v['child'] = $temp;
            $v['child'] = child($arr, $v['cat_id'], $level+1);
            $res[] = $v;
        }
    }
    return $res;
}
function queryListCondition($table_name, $field_name, $field_value)
{
    // 获取每页的商品数量
    $length=isset($_GET['limit'])?$_GET['limit']:"";
    $offset=isset($_GET['offset'])?$_GET['offset']:"";
    $sort=isset($_GET['sort'])?$_GET['sort']:"";
    $order=isset($_GET['order'])?$_GET['order']:"";

    $sql="select * from $table_name where $field_name=$field_value";
    if (!empty($sort)) {
        $sql=$sql." order by $sort";
        if (!empty($order)) {
            $sql=$sql." $order";
        }
    }
       
    if (!empty($length)) {
        $sql=$sql." limit $length offset $offset";
    }
        
    $data=Db::query($sql);
    return $data;
}

function queryList($table_name)
{
    // 获取每页的商品数量
    $length=isset($_GET['limit'])?$_GET['limit']:"";
    $offset=isset($_GET['offset'])?$_GET['offset']:"";
    $sort=isset($_GET['sort'])?$_GET['sort']:"";
    $order=isset($_GET['order'])?$_GET['order']:"";

    $sql="select * from $table_name";
    if (!empty($sort)) {
        $sql=$sql." order by $sort";
        if (!empty($order)) {
            $sql=$sql." $order";
        }
    }
       
    if (!empty($length)) {
        $sql=$sql." limit $length offset $offset";
    }
        
    $data=Db::query($sql);
    return $data;
}

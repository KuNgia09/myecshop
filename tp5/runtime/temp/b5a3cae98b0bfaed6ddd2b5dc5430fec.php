<?php /*a:1:{s:57:"D:\www\myecshop\tp5\application\admin\view\goods\add.html";i:1543914124;}*/ ?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <title>myecshop商城管理系统</title>

  <link href="/static/admin/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/static/admin/plugins/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="/static/admin/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/static/admin/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect. -->
  <link rel="stylesheet" href="/static/admin/css/skins/skin-blue.min.css">
  <link rel="stylesheet" href="/static/admin/css/mystyle.css">
  <link href="/static/admin/js/plugins/umeditor/themes/default/css/umeditor.css" type="text/css" rel="stylesheet" />
  <!-- <link href="/static/admin/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet"> -->

  <link href="/static/admin/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <style>
    .nav-second-level li a {
      padding-left: 30px;
    }

    .my-btn{
      margin: 0 10px; 
    }

    
  </style>
</head>

<body class="skin-blue">
  <section class="content-header">
    <h1>
      添加新商品

    </h1>

    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#">Forms</a></li>
      <li class="active">General Elements</li>
    </ol>
    <button class="btn btn-primary btn-success action-btn">商品列表</button>
  </section>

  <section class="content">
    <div class="row">
      <div class="nav-tabs-custom">

        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab_1" data-toggle="tab">通用信息</a></li>
          <li><a href="#tab_2" data-toggle="tab">详细描述</a></li>
          <li><a href="#tab_3" data-toggle="tab">其他信息</a></li>
          <li><a href="#tab_4" data-toggle="tab">商品规格</a></li>
          <li><a href="#tab_5" data-toggle="tab">商品属性</a></li>
        </ul>

        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Horizontal Form</h3>
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <form class="form-horizontal" id="myform" method="POST" action="<?php echo url('goods/addOK'); ?>">
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <!-- 商品名称 -->
                <div class="form-group">
                  <label class="col-sm-2 control-label">商品名称</label>
                  <div class="col-sm-2">
                    <input type="text" name="goods_name" class="form-control">
                  </div>
                </div>

                <!-- 商品货号 -->
                <div class="form-group">
                  <label class="col-sm-2 control-label">商品货号</label>
                  <div class="col-sm-2">
                    <input type="text" name="goods_sn" class="form-control"></div>
                </div>

                <!-- 商品分类 -->
                <div class="form-group">
                  <label class="col-sm-2 control-label">商品分类:</label>
                  <div class="col-sm-2">
                    <select class="form-control " name="one_cat" onchange="getSubCat(this,'two_cat');">
                      <option value="0">请选择一级分类</option>
                      <?php if(is_array($list_one_cats) || $list_one_cats instanceof \think\Collection || $list_one_cats instanceof \think\Paginator): $i = 0; $__LIST__ = $list_one_cats;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                      <option value=<?php echo htmlentities($vo['cat_id']); ?>><?php echo htmlentities($vo['cat_name']); ?></option>
                      <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                  </div>
                  <div class="col-sm-2">
                    <select class="form-control" name="two_cat" onchange="getSubCat(this,'three_cat');">

                    </select>
                  </div>


                  <div class="col-sm-2">
                    <select class="form-control" name="three_cat" id='three_cat'>

                    </select>
                  </div>

                </div>

                <!-- 商品品牌 -->
                <div class="form-group">
                  <label class="col-sm-2 control-label">商品品牌:</label>
                  <div class="col-sm-2">
                    <select class="form-control " name="brand_id">
                      <option value="0">请选择..</option>
                      <?php if(is_array($list_brand) || $list_brand instanceof \think\Collection || $list_brand instanceof \think\Paginator): $i = 0; $__LIST__ = $list_brand;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                      <option value=<?php echo htmlentities($vo['brand_id']); ?>><?php echo htmlentities($vo['brand_name']); ?></option>
                      <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>

                  </div>
                </div>

                <!-- 选择供应商 -->
                <div class="form-group">
                  <label class="col-sm-2 control-label">选择供应商:</label>
                  <div class="col-sm-2">
                    <select class="form-control " name="suppliers_id">
                      <option value="0">不指定供应商属于本店商品</option>
                      <?php if(is_array($list_suppliers) || $list_suppliers instanceof \think\Collection || $list_suppliers instanceof \think\Paginator): $i = 0; $__LIST__ = $list_suppliers;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                      <option value=<?php echo htmlentities($vo['suppliers_id']); ?>><?php echo htmlentities($vo['suppliers_name']); ?></option>
                      <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>

                  </div>
                </div>

                <!-- 本店售价 -->
                <div class="form-group">
                  <label class="col-sm-2 control-label">本店售价:</label>
                  <div class="col-sm-1"><input type="text" class="form-control" value="0" name="shop_price"></div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label">会员价格:</label>
                  <div class="col-sm-10">
                    <span>注册用户</span>
                    <input style="width: 10%;display:inline-block;" type="text" class="form-control" name="user_price[]"
                      value="-1">
                    <span>代销用户</span>
                    <input style="width: 10%;display:inline-block;" type="text" class="form-control" name="user_price[]"
                      value="-1">
                    <span>vip</span>
                    <input style="width: 10%;display:inline-block;" type="text" class="form-control" name="user_price[]"
                      value="-1">
                  </div>

                </div>

                <div class="form-group">
                  <div class="col-sm-2 control-label">
                    <input type="checkbox">
                    <label class="">促销价:</label>
                  </div>
                  <div class="col-sm-1"><input type="text" class="form-control" name="promote_price"></div>
                </div>

                <div class="form-group">

                  <label class="col-sm-2 control-label">促销日期:</label>

                  <div class="col-sm-10">
                    <div class="pull-left date" style="width: 200px;" data-provide="datepicker">
                      <input type="text" name="promote_start_date" class="form-control date" style="width: 120px;display: inline-block">
                      <!-- 如果你的按钮不是用于向服务器提交数据，请确保这些按钮的 type 属性设置成 button。
                              否则它们被按下后将会向服务器发送数据并加载（可能并不存在的）响应内容，
                              因而可能会破坏当前文档的状态。 -->
                      <button type="button" class="btn btn-xs btn-success date">
                        <span><i class="iconfont icon-kalendar"></i></span>
                        选择
                      </button>
                      <span style="font-size:20px">-</span>
                    </div>

                    <div class="pull-left date" style="width: 200px;margin-left: -5px" data-provide="datepicker">
                      <input type="text" name="promote_end_date" class="form-control" style="width: 120px;display: inline-block">
                      <!-- 如果你的按钮不是用于向服务器提交数据，请确保这些按钮的 type 属性设置成 button。
                                                                                      否则它们被按下后将会向服务器发送数据并加载（可能并不存在的）响应内容，因而可能会破坏当前文档的状态。 -->
                      <button type="button" class="btn btn-xs btn-success date">
                        <span><i class="iconfont icon-kalendar"></i></span>
                        选择
                      </button>
                    </div>
                  </div>

                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label">上传商品图片:</label>

                  <div class="col-sm-5">
                    <input type="file" name="goods_img">
                    <br>
                    <input type="text" name="goods_img_url" class="form-control" value="商品图片外部URL">
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label">上传商品缩略图:</label>

                  <div class="col-sm-5">
                    <input type="file" name="goods_thumb">
                    <br>
                    <input type="text" name="goods_thumb_url" class="form-control">
                    <input type="checkbox">自动生成商品缩略图
                  </div>
                </div>
              </div>
              <!-- /.tab-pane -->
              <!-- 商品描述 -->
              <div class="tab-pane" id="tab_2">
                <div id="tab-2" class="tab-pane" style="margin-top:10px;margin-left: 10px;">
                  <!-- 编辑器 -->
                  <script id="detail-content" name="goods_desc" type="text/plain" style="width:800px;height:600px">

                  </script>
                </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_3">
                <!-- 商品重量 -->
                <div class="form-group">
                  <label class="col-sm-2 control-label">商品重量:</label>
                  <div class="col-sm-3">
                    <input type="text" class="form-control" name="goods_weight" onkeyup="this.value=this.value.replace(/[^\d.]/g,'')" onpaste="this.value=this.value.replace(/[^\d.]/g,'')"></div>
                  <div style="display:inline-block;">
                    <select class="form-control " name="weight_unit">
                      <option value="1">克</option>
                      <option value="0.001">千克</option>
                    </select>

                  </div>
                </div>

                <!-- 库存数量 -->
                <div class="form-group">
                  <label class="col-sm-2 control-label">商品库存数量:</label>
                  <div class="col-sm-4">
                    <input type="text" name="goods_number" class="form-control" onkeyup="this.value=this.value.replace(/[^\d.]/g,'')" onpaste="this.value=this.value.replace(/[^\d.]/g,'')" style="width:50%;">
                    <span class="help-block m-b-none text-navy">
                      库存在商品为虚货或商品存在货品时为不可编辑状态，库存数值取决于其虚货数量或货品数量
                    </span>
                  </div>

                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label">库存警告数量:</label>
                  <div class="col-sm-2">
                    <input type="text" name="warn_number" class="form-control">
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label">加入推荐:</label>
                  <div class="col-sm-4">
                    <div class="pull-left" style="padding-right: 10px">
                      <input type="checkbox" name="is_best" value="0" onclick="this.value=this.checked?1:0">
                      <label for="">精品</label>
                    </div>
                    <div class="pull-left" style="padding-right: 10px">
                      <input type="checkbox" name="is_new" value="0" onclick="this.value=this.checked?1:0">
                      <label for="">新品</label>
                    </div>
                    <div class="pull-left" style="padding-right: 10px">
                      <input type="checkbox" name="is_hot" value="0" onclick="this.value=this.checked?1:0">
                      <label for="">销售</label>
                    </div>



                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label">上架:</label>
                  <div class="col-sm-6">
                    <input type="checkbox" name="is_on_sale" checked="checked" value="1" onclick="this.value=this.checked?1:0"><label
                      for="">打勾表示允许销售，否则不允许销售。</label>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label">能作为普通商品销售：</label>
                  <div class="col-sm-6">
                    <input type="checkbox" name="is_alone_sale" checked="checked" value="1" onclick="this.value=this.checked?1:0"><label
                      for="">打勾表示能作为普通商品销售，否则只能作为配件或赠品销售。</label>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label">是否为免运费商品</label>
                  <div class="col-sm-6">
                    <input type="checkbox" name="is_shipping" value="0" onclick="this.value=this.checked?1:0"><label
                      for="">打勾表示此商品不会产生运费花销，否则按照正常运费计算。</label>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label">商品关键词:</label>
                  <div class="col-sm-4">
                    <input type="text" name="keywords" class="form-control" style="width:50%;display: inline-block;">
                    <label class="text-navy" for="">用空格分隔</label>
                  </div>

                </div>

                <!-- 商品简单描述 -->
                <div class="form-group">
                  <label class="col-sm-2 control-label">商品简单描述:</label>
                  <div class="col-sm-4">
                    <textarea name="goods_brief" id="" cols="50" rows="8"></textarea>
                  </div>

                </div>

                <!-- 商家备注-->
                <div class="form-group">
                  <label class="col-sm-2 control-label">商品备注:</label>
                  <div class="col-sm-4">
                    <textarea name="seller_note" id="" cols="50" rows="8"></textarea>
                    <br>
                    <label for="">仅供商家自己看的信息</label>
                  </div>

                </div>
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="tab_4">
                <div id="goods_type1" class="form-group">
                  <label class="col-sm-2 control-label">商品类型:</label>

                  <div class="col-sm-4">
                    <select class="form-control " name="goods_type" style="width:60%" onchange="getSpecList(this)">
                      <option value="0">请选择商品的类型</option>

                      <?php if(is_array($list_goodstype) || $list_goodstype instanceof \think\Collection || $list_goodstype instanceof \think\Paginator): $i = 0; $__LIST__ = $list_goodstype;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                      <option value=<?php echo htmlentities($vo['type_id']); ?>><?php echo htmlentities($vo['type_name']); ?></option>
                      <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                    <label for="" class="control-label">请选择商品的所属类型，进而完善此商品的属性</label>
                  </div>
                </div>
              </div>

              <div class="tab-pane" id="tab_5">
                <div id="goods_type2" class="form-group">
                  <label class="col-sm-2 control-label">商品类型:</label>

                  <div class="col-sm-4">
                    <select class="form-control " name="goods_type" style="width:60%" onchange="getAttrList(this)">
                      <option value="0">请选择商品的类型</option>

                      <?php if(is_array($list_goodstype) || $list_goodstype instanceof \think\Collection || $list_goodstype instanceof \think\Paginator): $i = 0; $__LIST__ = $list_goodstype;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                      <option value=<?php echo htmlentities($vo['type_id']); ?>><?php echo htmlentities($vo['type_name']); ?></option>
                      <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                    <label for="" class="control-label text-navy">请选择商品的所属类型，进而完善此商品的属性</label>
                  </div>
                </div>
              </div>

              <!-- 提交 -->
              <div class="form-group" style="margin-top: 20px;">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-2">
                  <button class="btn btn-success" id="submit_form">提交</button>
                </div>
              </div>
          </form>
        </div>
      </div>
    </div>

  </section>

  <script src="/static/admin/js/jquery-3.1.1.min.js"></script>
  <script src="/static/admin/js/bootstrap.min.js"></script>

  <script src="/static/admin/js/adminlte.min.js"></script>

  <script src="/static/admin/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
 
  <script type="text/javascript" src="/static/admin/js/plugins/umeditor/umeditor.config.js"></script>

  <script type="text/javascript" src="/static/admin/js/plugins/umeditor/umeditor.min.js"></script>
  <script src="/static/admin/js/jquery.form.js"></script>
  <script src="/static/common/plugins/layer/layer.js"></script>
  <script type="text/javascript">
    var um = UM.getEditor('detail-content');
  </script>
  <script>

    $('#submit_form').click(function(){
      // 检查三级分类
      if(!$('#three_cat').val()){
        layer.msg('请选择三级分类');
        return false;
      }
      var data=$('#myform').formToArray();

      $.ajax({
        url: '/index.php/admin/Goods/addOk',
        type: 'POST',
        data: data,
        success: function (data) {
          
        }
      });


    })
    function getSubCat(obj, name) {
      var catId = obj.value;
      if (catId == 0) {
        return;
      }

      var params = {
        id: catId
      };
      // 获取子分类列表
      $.ajax({
        url: '/index.php/admin/Goods/getSubCats',
        type: 'POST',
        data: params,

        success: function (data) {
          var tag = "select[name='" + name + "']";
          console.log('获取子分类tag:' + tag);
          $(tag).html('');
          $(tag).append(data);
        }
      });



    }
    // 根据商品类型获取属性列表
    function getAttrList() {
      console.log('根据商品类型获取属性:' + obj.value);
      // 使用ajax获取选中的商品类型属性
      var params = {
        id: obj.value,
        title: 'jack'
      };
      // processData不能为false
      // 默认情况下，使用GET HTTP方法发送Ajax请求。
      // 如果需要POST方法，可以通过设置type选项的值来指定方法。此选项会影响选项内容如何data发送到服务器。根据W3C XMLHTTPRequest标准，POST数据将始终使用UTF-8字符集传输到服务器。
      // 该data选项可以包含表单的查询字符串key1=value1&key2=value2
      // 或表单的对象{key1: 'value1', key2: 'value2'}。
      // 如果使用后一种形式，jQuery.param()则在发送之前使用数据将其转换为查询字符串。
      // 可以通过设置processData来避免此处理false。
      $.ajax({
        url: '/index.php/admin/Goods/getGoodsAttr',
        type: 'POST',
        data: params,
        // processData:false,
        success: function (data) {
          console.log('goods attr：' + data);
          $('#attr_wrapper').remove();
          $(data).insertAfter('#goods_type2');
        }
      });
    }

    // 根据商品类型动态生成规格名 例如颜色 尺寸
    function getSpecList(obj) {
      console.log('获取商品类型为:' + obj.value + '的规格');

      var params = {
        id: obj.value
      };
      $.ajax({
        url: '/index.php/admin/Goods/getGoodsSpec',
        type: 'POST',
        data: params,

        success: function (data) {

          console.log('goods spec:' + data);
          $('#spec_table').remove();
          $(data).insertAfter('#goods_type1');
        }
      });

    }

    // 切换按钮样式
    function buttonTab(tag) {
      if ($(tag).hasClass('btn-success')) {
        $(tag).removeClass('btn-success');
        $(tag).addClass('btn-default');
      } else {
        $(tag).removeClass('btn-default');
        $(tag).addClass('btn-success');
      }
    }

    /**
     * 合并单元格
     */

    var mergeCell = function (id) {
      var tab = document.getElementById(id); //要合并的tableID
      var maxCol = 2,
        val, count, start; //maxCol：合并单元格作用到多少列
      if (tab != null) {
        for (var col = maxCol - 1; col >= 0; col--) {
          count = 1;
          val = "";
          for (var i = 0; i < tab.rows.length; i++) {
            if (val == tab.rows[i].cells[col].innerHTML) {
              count++;
            } else {
              if (count > 1) { //合并
                start = i - count;
                tab.rows[start].cells[col].rowSpan = count;
                for (var j = start + 1; j < i; j++) {
                  tab.rows[j].cells[col].style.display = "none";
                }
                count = 1;
              }
              val = tab.rows[i].cells[col].innerHTML;
            }
          }
          if (count > 1) { //合并，最后几行相同的情况下
            start = i - count;
            tab.rows[start].cells[col].rowSpan = count;
            for (var j = start + 1; j < i; j++) {
              tab.rows[j].cells[col].style.display = "none";
            }
          }
        }
      }
    }

    // 点击表格的添加规格项按钮 发送ajax请求 动态获取规格项
    function addSpecItem(obj) {
      console.log('点击添加规格按钮');
      buttonTab(obj);
      // 遍历表格中所有有btn-success样式的按钮
      var spcArr = {};
      var tag = '#goods_spec_table button';
      $(tag).each(function () {
        if ($(this).hasClass('btn-success')) {
          var spec_id = $(this).data('spec_id');
          var item_id = $(this).data('item_id');
          if (!spcArr.hasOwnProperty(spec_id))
            spcArr[spec_id] = [];
          spcArr[spec_id].push(item_id);
        }
      });

      var params = {
        spc: spcArr
      };
      console.log(params);

      $.ajax({
        url: '/index.php/admin/Goods/getAddContentBySpec',
        type: 'POST',
        data: params,

        success: function (data) {
          console.log('根据规格获取表格成功');
          $("#goods_spec_table2").html('')
          $("#goods_spec_table2").append(data);
          mergeCell('spec_input_tab');
        }
      });



    }
  </script>

</body>

</html>
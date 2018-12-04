<?php /*a:1:{s:59:"D:\www\myecshop\tp5\application\admin\view\index\index.html";i:1543671743;}*/ ?>
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
 
  <link rel="stylesheet" href="/static/admin/css/skins/_all-skins.min.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  

  <style>
    .nav-second-level li a{
      padding-left:30px;
    }
  </style>
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

      <!-- Logo -->
      <a href="index2.html" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>A</b>LT</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Admin</b>LTE</span>
      </a>

      <!-- Header Navbar -->
      <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>

        <ul id="tab-nav" class="nav navbar-nav">
          <li><a href="#" data-id="1">平台</a></li>
          <li><a href="#" data-id="2">商城</a></li>
          <li><a href="#" data-id="3">运营</a></li>
        </ul>

        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- Messages: style can be found in dropdown.less-->
            <li class="dropdown messages-menu">
              <!-- Menu toggle button -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-envelope-o"></i>
                <span class="label label-success">4</span>
              </a>
              <ul class="dropdown-menu">
                <li class="header">You have 4 messages</li>
                <li>
                  <!-- inner menu: contains the messages -->
                  <ul class="menu">
                    <li>
                      <!-- start message -->
                      <a href="#">
                        <div class="pull-left">
                          <!-- User Image -->
                          <img src="/static/admin/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                        </div>
                        <!-- Message title and timestamp -->
                        <h4>
                          Support Team
                          <small><i class="fa fa-clock-o"></i> 5 mins</small>
                        </h4>
                        <!-- The message -->
                        <p>Why not buy a new awesome theme?</p>
                      </a>
                    </li>
                    <!-- end message -->
                  </ul>
                  <!-- /.menu -->
                </li>
                <li class="footer"><a href="#">See All Messages</a></li>
              </ul>
            </li>

            <!-- 换肤 -->
            <li class="dropdown" id="skin-theme">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">主题 <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#" data-src="skin-blue">Blue</a></li>
                <li><a href="#" data-src="skin-green">Green</a></li>
                <li><a href="#" data-src="skin-red">Red</a></li>
                <li><a href="#" data-src="skin-purple">Red</a></li>
                <li class="divider"></li>
                <li><a href="#" data-src="skin-blue-light">Blue-light</a></li>

              </ul>
            </li>
            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
              <!-- Menu Toggle Button -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <!-- The user image in the navbar-->
                <img src="/static/admin/img/user2-160x160.jpg" class="user-image" alt="User Image">
                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                <span class="hidden-xs">Alexander Pierce</span>
              </a>
              <ul class="dropdown-menu">
                <!-- The user image in the menu -->
                <li class="user-header">
                  <img src="/static/admin/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                  <p>
                    Alexander Pierce - Web Developer
                    <small>Member since Nov. 2012</small>
                  </p>
                </li>
                <!-- Menu Body -->
                <li class="user-body">
                  <div class="row">
                    <div class="col-xs-4 text-center">
                      <a href="#">Followers</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">Sales</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">Friends</a>
                    </div>
                  </div>
                  <!-- /.row -->
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-left">
                    <a href="#" class="btn btn-default btn-flat">Profile</a>
                  </div>
                  <div class="pull-right">
                    <a href="#" class="btn btn-default btn-flat">Sign out</a>
                  </div>
                </li>
              </ul>
            </li>
            <!-- Control Sidebar Toggle Button -->
            <li>
              <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
            </li>
          </ul>
        </div>
      </nav>
    </header>


    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">

      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="/static/admin/img/user2-160x160.jpg" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p>Alexander Pierce</p>
            <!-- Status -->
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
          <li class="header">HEADER</li>
          <!-- Optionally, you can add icons to the links -->
          <li class="treeview active menu2">
            <a href="#"><i class="fa fa-link"></i> <span>商城管理</span></a>
            <ul class="treeview-menu nav-second-level">
              <li><a href="#" data-src="<?php echo url('goods/showList'); ?>">商品列表</a></li>
              <li><a href="#" data-src="<?php echo url('goods/add'); ?>">添加新商品</a></li>
              <li><a href="#" data-src="<?php echo url('goodsCategory/showCategory'); ?>">商品分类</a></li>
              <li><a href="#" data-src="<?php echo url('goodsType/showType'); ?>">商品类型</a></li>
              <li><a href="#" data-src="<?php echo url('goodsSpec/showSpec'); ?>">商品规格</a></li>
            </ul>
          </li>

          <li class="active treeview menu1" style="display:none" data-widget="tree">
            <a href="index.html">
              <i class="fa fa-th-large"></i> <span class="nav-label">职员管理</span>
            </a>
            <ul class="treeview-menu nav-second-level ">
              <li><a href="<?php echo url('goods/showList'); ?>">职员管理</a></li>
              <li><a href="<?php echo url('goods/add'); ?>">角色</a></li>
            </ul>
          </li>

          <li class="treeview menu1" style="display:none">
            <a href="index.html"><i class="fa fa-th-large"></i> <span class="nav-label">日志管理</span></a>
            <ul class="treeview-menu nav-second-level ">
              <li><a href="<?php echo url('goods/showList'); ?>">登录日志</a></li>
              <li><a href="<?php echo url('goods/add'); ?>">操作日志</a></li>
            </ul>
          </li>


        </ul>
        <!-- /.sidebar-menu -->
      </section>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" id="frame_wrapper">
      <!-- iframe内容区 -->
      <iframe id="myframe" class="J_iframe" name="iframe0" width="100%" height="100%" src="<?php echo url('index/index_v1'); ?>"
      frameborder="0" data-id="index_v1.html" seamless></iframe>
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
      <!-- To the right -->
      <div class="pull-right hidden-xs">
        Anything you want
      </div>
      <!-- Default to the left -->
      <strong>Copyright &copy; 2016 <a href="#">Company</a>.</strong> All rights reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Create the tabs -->
      <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
        <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
      </ul>
      <!-- Tab panes -->
      <div class="tab-content">
        <!-- Home tab content -->
        <div class="tab-pane active" id="control-sidebar-home-tab">
          <h3 class="control-sidebar-heading">Recent Activity</h3>
          <ul class="control-sidebar-menu">
            <li>
              <a href="javascript:;">
                <i class="menu-icon fa fa-birthday-cake bg-red"></i>

                <div class="menu-info">
                  <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                  <p>Will be 23 on April 24th</p>
                </div>
              </a>
            </li>
          </ul>
          <!-- /.control-sidebar-menu -->

          <h3 class="control-sidebar-heading">Tasks Progress</h3>
          <ul class="control-sidebar-menu">
            <li>
              <a href="javascript:;">
                <h4 class="control-sidebar-subheading">
                  Custom Template Design
                  <span class="pull-right-container">
                    <span class="label label-danger pull-right">70%</span>
                  </span>
                </h4>

                <div class="progress progress-xxs">
                  <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                </div>
              </a>
            </li>
          </ul>
          <!-- /.control-sidebar-menu -->

        </div>
        <!-- /.tab-pane -->
        <!-- Stats tab content -->
        <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
        <!-- /.tab-pane -->
        <!-- Settings tab content -->
        <div class="tab-pane" id="control-sidebar-settings-tab">
          <form method="post">
            <h3 class="control-sidebar-heading">General Settings</h3>

            <div class="form-group">
              <label class="control-sidebar-subheading">
                Report panel usage
                <input type="checkbox" class="pull-right" checked>
              </label>

              <p>
                Some information about this general settings option
              </p>
            </div>
            <!-- /.form-group -->
          </form>
        </div>
        <!-- /.tab-pane -->
      </div>
    </aside>
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
  immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED JS SCRIPTS -->

  <!-- Mainly scripts -->
  <script src="/static/admin/js/jquery-3.1.1.min.js"></script>

  <script src="/static/admin/js/bootstrap.min.js"></script>
  <!-- AdminLTE App -->
  <script src="/static/admin/js/adminlte.min.js"></script>

  <!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->


  <script>
    // 
    $('#tab-nav li a').on('click', function () {
      console.log('nav-header tab is clicked');
      // 默认是字符串 转换为整型
      var dataId = parseInt($(this).attr('data-id'));
      if (dataId == undefined) {
        return;
      }
      var treeview = $('.sidebar-menu .treeview');
      treeview.css('display', 'none');

      switch (dataId) {
        // 显示平台菜单
        case 1:
          $('.sidebar-menu .menu1').css('display', 'block');
          break;
        case 2:
          $('.sidebar-menu .menu2').css('display', 'block');
          break;
      }

    });

    //  点击左侧菜单栏
    $('.sidebar-menu .treeview-menu').on('click', 'a', function () {
      console.log('点击左侧菜单栏');
      // 获取要跳转到的地址
      var url = $(this).attr('data-src')
      if (url != undefined) {
        console.log('iframe要跳转到的地址:' + url);
        $('#myframe').attr('src', url);
        var frameHeight = $(window).height() - $(".main-header").height() - $(".main-footer").height();
        // console.log('window 高度:' + $(window).height());
        // console.log('top-nav 高度:' + $("#top-nav").height());
        // // 只是内容的高度
        // console.log('footer 高度:' + $("#page-wrapper .footer").height());
        // //包含padding的高度
        // console.log('footer 高度2:' + $("#page-wrapper .footer").css('height'));

      }
      return false;
    })

    function changeIFrameHeight() {

      // 获取footer的高度 包含padding 带单位px 需要转换为int
      footerH = parseInt($(".main-footer").css('height'));
      var h = $(window).height() - $(".main-header").height() - footerH;
      console.log('changeIframeHeight,iframe高度:' + h);
      $("#frame_wrapper").height(h);


    }
    $(window).resize(function (e) {
      changeIFrameHeight()
    })

    window.onload = function () {
      changeIFrameHeight();
    }

    // 换肤
    $('#skin-theme ul>li>a').on('click', function () {
      var skins = ['skin-blue', 'skin-green', 'skin-red', 'skin-purple', 'skin-light'];
      var skin = $(this).attr('data-src');
      console.log('skin 皮肤:' + skin);
      for(var i=0;i<skins.length;i++){
        if($(document.body).hasClass(skins[i])){
          $(document.body).removeClass(skins[i]);
          break;
        }
      }
      $(document.body).addClass(skin);

    })
  </script>
</body>

</html>
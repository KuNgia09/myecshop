<?php

namespace app\admin\controller;


require_once './vendor/autoload.php';

use think\Controller;
use think\DB;
use think\Session;
use Kint\Kint;

/**
 * 文件上传
 */
class Uploadify extends Controller{
  public function upload(){
    var_dump($_GET);
  }
}
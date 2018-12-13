<?php

/**
 * @author fengyue <email@email.com>
 */
namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\response\Json;
use think\Session;


class Base extends Controller{

    public function ajaxReturn($data,$type = 'json'){                        
      exit(json_encode($data));
  }
}
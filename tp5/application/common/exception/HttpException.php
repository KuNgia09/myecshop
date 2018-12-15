<?php
namespace app\common\exception;

use think\exception\Handle;

/**
 * 异常处理回调函数
 */
class HttpException extends Handle
{
  public function render(\Exception $e)
  {
    if(config('app_debug')){
      return parent::render($e);
    }
    else{
      
      header("Location:".url('home/error/index'));
    }
    
  }
}
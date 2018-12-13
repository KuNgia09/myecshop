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
class Uploadify extends Controller
{
    public function upload()
    {
        // 助手函数获取path参数
        // 回调函数
        $func = input('func');
        $path=input('path', 'temp');
        $file_type=input('fileType', 'Images');
        $image_upload_limit_size = config('image_upload_limit_size');
        if ($file_type == 'Flash') {
            $upload = url('admin/Ueditor/videoUp', array('savepath'=>$path,'pictitle'=>'banner','dir'=>'video'));
            $type = 'mp4,3gp,flv,avi,wmv';
        } else {
            $upload = url('Admin/Ueditor/imageUp', array('savepath'=>$path,'pictitle'=>'banner','dir'=>'images'));
            $type = 'jpg,png,gif,jpeg';
        }

        $info = [
          'num'=> input('num/d'),
          'fileType'=> $file_type,
          'title' => '',
          'upload' =>$upload,
          'fileList'=>url('admin/Uploadify/fileList', array('path'=>$path)),
          'size' => $image_upload_limit_size/(1024 * 1024).'M',
          'type' =>$type,
          'input' => input('input'),
          'func' => empty($func) ? 'undefined' : $func
        ];
         
     
        $this->assign('info', $info);
        return $this->fetch();
    }

    /**
     * 删除上传的图片,视频
     */
    public function delUpload()
    {
        $action = input('action', 'del');
        $filename= input('filename');
        $filename= empty($filename) ? input('url') : $filename;
        $filename= str_replace('../', '', $filename);
        $filename= trim($filename, '.');
        $filename= trim($filename, '/');


        if ($action=='del' && !empty($filename) && file_exists($filename)) {
            $filetype = strtolower(strstr($filename, '.'));
            $phpfile = strtolower(strstr($filename, '.php'));  //排除PHP文件
          $erasable_type = config('erasable_type');  //可删除文件
          if (!in_array($filetype, $erasable_type) || $phpfile) {
              exit;
          }
            if (unlink($filename)) {
                // $this->deleteWechatImage(I('url'));
                echo 1;
            } else {
                echo 0;
            }
            exit;
        }
    }
  
    /**
     * 获取文件列表
     *
     * @return void
     */
    public function fileList()
    {
        /* 判断类型 */
        $type = I('type', 'Images');
        switch ($type) {
      /* 列出图片 */
      case 'Images': $allowFiles = 'png|jpg|jpeg|gif|bmp';break;
    
      case 'Flash': $allowFiles = 'mp4|3gp|flv|avi|wmv|flash|swf';break;
    
      /* 列出文件 */
      default: $allowFiles = '.+';
    }

        $path = UPLOAD_PATH.I('path', 'temp');
        //echo file_exists($path);echo $path;echo '--';echo $allowFiles;echo '--';echo $key;exit;
        $listSize = 100000;
    
        $key = empty($_GET['key']) ? '' : $_GET['key'];
    
        /* 获取参数 */
        $size = isset($_GET['size']) ? htmlspecialchars($_GET['size']) : $listSize;
        $start = isset($_GET['start']) ? htmlspecialchars($_GET['start']) : 0;
        $end = $start + $size;
    
        /* 获取文件列表 */
        $files = $this->getfiles($path, $allowFiles, $key, ['public/upload/goods/thumb']);
        if (!count($files)) {
            echo json_encode(array(
          "state" => "没有相关文件",
          "list" => array(),
          "start" => $start,
          "total" => count($files)
      ));
            exit;
        }
    
        /* 获取指定范围的列表 */
        $len = count($files);
        for ($i = min($end, $len) - 1, $list = array(); $i < $len && $i >= 0 && $i >= $start; $i--) {
            $list[] = $files[$i];
        }
    
        /* 返回数据 */
        $result = json_encode(array(
        "state" => "SUCCESS",
        "list" => $list,
        "start" => $start,
        "total" => count($files)
    ));
    
        echo $result;
    }


    /**
     * 图片上传
     *
     * @return void
     */
    public function imageUp()
    {
    }

    /**
     * 视频上传
     *
     * @return void
     */
    public function videoUp()
    {
    }
}

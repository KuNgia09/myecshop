<?php

namespace app\admin\controller;

require_once './vendor/autoload.php';

use think\Controller;
use think\DB;
use app\common\logic\EditorLogic;

/**
 * 上传工具类
 */
class Ueditor extends Controller
{
    private $sub_name = array('date', 'Y/m-d');
    private $savePath = 'temp/';


    public function __construct()
    {
        parent::__construct();
        
        //header('Access-Control-Allow-Origin: http://www.baidu.com'); //设置http://www.baidu.com允许跨域访问
        //header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With'); //设置允许的跨域header
        
        date_default_timezone_set("Asia/Shanghai");

        $savePath = input('savepath') ?: input('savePath');
        $this->savePath = $savePath ? $savePath . '/' : 'temp/';

        error_reporting(E_ERROR | E_WARNING);
        
        header("Content-Type: text/html; charset=utf-8");
    }


    /**
     * 保存上传的图片
     *
     * @return void
     */
    public function imageUp()
    {       
        // 上传图片框中的描述表单名称，
        $pictitle = input('pictitle');
        $dir = input('dir');
        $title = htmlspecialchars($pictitle , ENT_QUOTES);        
        $path = htmlspecialchars($dir, ENT_QUOTES);
        //$input_file ['upfile'] = $info['Filedata'];  一个是上传插件里面来的, 另外一个是 文章编辑器里面来的
        // 获取表单上传文件
        $file = request()->file('file');
        $return_url = '';
        $editor = new EditorLogic;

        if (empty($file)) {
            $file = request()->file('upfile');
        }
        $result = $this->validate(
            ['file' => $file],
            ['file'=>'image|fileSize:40000000|fileExt:jpg,jpeg,gif,png'],
            ['file.image' => '上传文件必须为图片','file.fileSize' => '上传文件过大','file.fileExt'=>'上传文件后缀名必须为jpg,jpeg,gif,png']
           );
        
        $upload_max_filesize = @ini_get('file_uploads') ? ini_get('upload_max_filesize') :'unknown';
        if (true !== $result || !$file) {
            $state = "ERROR 图片过大, 最大不能超过: $upload_max_filesize";
        } else {
            $return = $editor->saveUploadImage($file, $this->savePath);
            $state = $return['state'];
            $return_data['url'] = $return['url'];
        }

        $return_data['title'] = $title;
        $return_data['original'] = ''; // 这里好像没啥用 暂时注释起来
        $return_data['state'] = $state;
        $return_data['path'] = $path;

        return json_encode($return_data);
    }
}

<?php

namespace think;

// 定义应用目录
// @session_start();
define('APP_PATH', __DIR__ . '/application/');
define('DS',DIRECTORY_SEPARATOR);
define('layout_on',false);
// 默认的模块
define('BIND_MODULE','home');
define('UPLOAD_PATH','upload/'); // 编辑器图片上传路径
// 加载基础文件
require __DIR__ . '/thinkphp/base.php';
// 执行应用并响应
Container::get('app')->path(APP_PATH)->run()->send();




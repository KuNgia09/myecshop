<?php
namespace app\admin\controller;

require './vendor/autoload.php';

use think\Controller;
use think\DB;
use think\Session;

use Kint\Kint;

class Index extends Controller
{
    public function index()
    {
        
        return $this->fetch('index');
    }

    public function index_v1()
    {
        // echo 'aaaa';
        return $this->fetch('index_v1');
    }

    public function top()
    {
        return $this->fetch();
    }

    public function main()
    {
        return $this->fetch();
    }

    public function left()
    {
        return $this->fetch();
    }

    public function login()
    {
    }

    // 验证码
    public function verify()
    {
    }

    public function logout()
    {
    }
}

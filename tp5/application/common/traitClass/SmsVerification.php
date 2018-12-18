<?php
// +----------------------------------------------------------------------
// | OnlineRetailers [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2003-2023 www.yisu.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed 亿速网络（http://www.yisu.cn）
// +----------------------------------------------------------------------
// | Author: 王强 <opjklu@126.com>
// +----------------------------------------------------------------------

namespace app\common\traitClass;

use app\common\tool\ArrayParse;

<<<<<<< HEAD
=======

>>>>>>> e5b37835f76dcc04fcd66ebfa9dfdb818ae619b9
/**
 * 短信验证 及其 系统配置
 */
trait SmsVerification
{
    public $error = '';
   
    protected $key = null;
    
    public function SmsVerification(array $smsConfig, $mobile)
    {
<<<<<<< HEAD
        if (empty($smsConfig) || !is_array($smsConfig) || !Tool::connect('ParttenTool')->validateData($mobile, 'mobile')) {
=======
        if (empty($smsConfig) || !is_array($smsConfig) || !Tool::connect('ParttenTool')->validateData($mobile, 'mobile'))
        {
>>>>>>> e5b37835f76dcc04fcd66ebfa9dfdb818ae619b9
            $this->error = '暂无短信配置 或 手机格式不正确';

            return false;
        }
        $verfity = Tool::connect('PassMiMi')->getSmsCode();


        $argv = array(
            'Account' => $smsConfig['account'],     //必填参数。用户账号
            'Password'=>  $smsConfig['sms_pwd'],     //必填参数。（web平台：基本资料中的接口密码）
<<<<<<< HEAD
            'Content' => mb_convert_encoding(str_replace('[xxx]', $verfity, $smsConfig['sms_content']), "GB2312", "UTF-8"),  //必填参数。发送内容（1-500 个汉字）UTF-8编码
=======
            'Content' => mb_convert_encoding(str_replace('[xxx]', $verfity, $smsConfig['sms_content']), "GB2312","UTF-8"),  //必填参数。发送内容（1-500 个汉字）UTF-8编码
>>>>>>> e5b37835f76dcc04fcd66ebfa9dfdb818ae619b9
            'Phones'  => $mobile,   //必填参数。手机号码。多个以英文逗号隔开
            //'stime'=>'',   //可选参数。发送时间，填写时已填写的时间发送，不填时为当前时间发送
            'Channel' => 1, //'【'.mb_substr( strrchr($smsConfig['sms_content'], '，'), 1, 4, 'UTF-8').'】',    //必填参数。用户签名。
            // 'extno'=>''    //可选参数，扩展码，用户定义扩展码，只能为数字
        );
        $flag = 0;
        $params = null;
        foreach ($argv as $key=>$value) {
            if ($flag != 0) {
                $params .= "&";
                $flag = 1;
            }
<<<<<<< HEAD
            $params.= $key."=";
            $params.= urlencode($value);// urlencode($value);
=======
            $params.= $key."="; $params.= urlencode($value);// urlencode($value);
>>>>>>> e5b37835f76dcc04fcd66ebfa9dfdb818ae619b9
            $flag = 1;
        }
        //连接短信工具

<<<<<<< HEAD
        $smsInformation = Tool::connect('Mosaic')->requestPostSms($smsConfig['sms_intnet'], $params);

        if ($smsInformation) {
=======
        $smsInformation = Tool::connect('Mosaic')->requestPostSms( $smsConfig['sms_intnet'], $params);

        if ($smsInformation)
        {
>>>>>>> e5b37835f76dcc04fcd66ebfa9dfdb818ae619b9
            //设置sms_code 保存时间
            S('reg_tel_code', $verfity, 120);
        }
        return $smsInformation ? $verfity : false;
    }
    
    /**
     * 获取系统配置
     */
    public function getConfig($key = null)
    {
        $arrayData = S('system_config');
<<<<<<< HEAD
        if (empty($arrayData)) {
=======
        if (empty($arrayData))
        {
>>>>>>> e5b37835f76dcc04fcd66ebfa9dfdb818ae619b9
            $arrayData = $this->getNoCacheConfig();
            S('system_config', $arrayData, 60);
        }
        return $key === null ? $arrayData : $arrayData[$key];
    }
    
    /**
     * 获取无缓存配置
     * @return array
     */
<<<<<<< HEAD
    protected function getNoCacheConfig($key = null)
=======
    protected  function getNoCacheConfig ($key = null)
>>>>>>> e5b37835f76dcc04fcd66ebfa9dfdb818ae619b9
    {
        //获取字表数据
        $children    = ConfigChildrenModel::getInitnation()->getAllConfig();
        //获取配置值
        $configValue = SystemConfigModel::getInitnation()->getAllConfig();
        //组合数据
        Tool::connect('ArrayParse', array('children' => $children, 'configValue'=> $configValue));
        $arrayData = array();
        $data = Tool::buildConfig()->parseConfig()->oneArray($arrayData);
        
        return $key === null ? $data : $data[$key];
    }
    
    /**
     * 获取组数据 配置
     */
<<<<<<< HEAD
    public function getGroupConfig()
=======
    public function getGroupConfig ()
>>>>>>> e5b37835f76dcc04fcd66ebfa9dfdb818ae619b9
    {
        if (empty($this->key)) {
            return array();
        }
        $groupConfig = model('SystemConfig')->getDataByKey($this->key);
        $receiveArray = array();
        (new ArrayParse($receiveArray))->oneArray($receiveArray, $groupConfig);
        
        return $receiveArray;
    }
    
    /**
     * 获取网站信息
     */
    public function getSiteInformation()
    {
        //获取组配置
        $this->key = 'information_by_intnet';
        
        $information = $this->getGroupConfig();
        
        return $information;
    }

    public function get_intnetConfig()
    {
        //获取组配置
        $this->key = 'intnetConfig';

        $information = $this->getGroupConfig();

        return $information;
    }
<<<<<<< HEAD
}
=======
    
}
>>>>>>> e5b37835f76dcc04fcd66ebfa9dfdb818ae619b9

<?php
namespace App\Tools;

use Flc\Alidayu\Client;
use Flc\Alidayu\App;
use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;
use Flc\Alidayu\Requests\IRequest;


class SendSms
{


    static $acsClient = null;

    /**
     * 取得AcsClient
     *
     * @return DefaultAcsClient
     */
    public static function getAcsClient() {


        //配置信息
        $config = [
            'app_key'    => 'LTAINTa3oWT19mqd',
            'app_secret' => 'KM3svoRBxP1F47rZrLTaDGaEGozSwa',
            'sandbox'    => false,  // 是否为沙箱环境，默认false
        ];


        if(static::$acsClient == null) {

            // 初始化AcsClient用于发起请求
            static::$acsClient = new Client(new App($config));
        }
        return static::$acsClient;
    }

    /**
     * 发送短信
     * @return stdClass
     */
    public static function sendSms($phone,$msg,$moban_code) {


        $req  = new AlibabaAliqinFcSmsNumSend;

        $req->setRecNum($phone)
            ->setSmsParam([
                'number' => $msg
            ])
            ->setSmsFreeSignName('太阳城')
            ->setSmsTemplateCode($moban_code);

        $resp = static::getAcsClient()->execute($req);

        return $resp;

    }


}

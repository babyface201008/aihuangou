<?php
namespace App\Tools\swiftpass;
class Config{
    private $cfg = array(
		//�ӿ������ַ���̶����䣬�����޸�
        'url'=>'https://pay.swiftpass.cn/pay/gateway',
		//�����̻��ţ��̻����Ϊ�Լ���
        'mchId'=>'7551000001',
		//������Կ���̻����Ϊ�Լ���
        'key'=>'9d101c97133837e13dde2d32a5054abb',
		//�汾��Ĭ��Ϊ2.0
        'version'=>'2.0'
       );
    
    public function C($cfgName){
        return $this->cfg[$cfgName];
    }
}
?>
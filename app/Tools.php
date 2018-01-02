<?php
namespace App;
/**
 * Common secure function
 **/
use Session;

use App\Tools\AliSMS;
use App\Tools\XM;
use App\Tools\SFZ;
use App\Tools\RobotMaker;
use App\Tools\Swiftpass;
use App\Tools\UtilUUID;
use App\Tools\HttpsResponse;
class Tools
{
  /**
   * 密码加密方式
   * @AiHuanGou
   * @DateTime      2017-04-15T15:36:25+0800
   * @param         $password    
   * @return        $password
   */
  public static function encrypt($password)
  {
    $password = sha1("welkin_".$password);
    return $password;
  }

  /**
   * 检查是否本人或者第一位用户
   * @AiHuanGou
   * @DateTime      2017-04-15T15:39:09+0800
   * @param         [type]                   $key     [description]
   * @param         [type]                   $user_id [description]
   * @return        [type]                            [description]
   */
  public static function checkUser($key,$user_id)
  {
    if($user_id == Session::get($key) || Session::get($key) == 1)
    {
      return !false;
    }else{
      return false;
    }
  }

  /**
   * 对象转数组
   * @AiHuanGou
   * @DateTime      2017-04-15T16:23:50+0800
   * @param         $obj
   * @return        $arr
   */
  public static function object_to_array($obj)
  {  
    if(is_array($obj)){  
      return $obj;  
    }  
    $_arr = is_object($obj)? get_object_vars($obj) :$obj;  
    foreach ($_arr as $key => $val){  
      $val=(is_array($val)) || is_object($val) ? self::object_to_array($val) :$val;  
      $arr[$key] = $val;  
    }  
    return $arr;  
  }  

  /**
   * 对象转JSON
   * @AiHuanGou
   * @DateTime      2017-04-15T16:24:29+0800
   * @param         $obj
   * @return        $json
   */
  public static function object_to_json($obj)
  {  
    $arr2=self::object_to_array($obj);//先把对象转化为数组  
    return json_encode($arr2);  
  }  

  /**
   * 生成随机字符串
   * @AiHuanGou
   * @DateTime      2017-04-15T16:25:10+0800
   * @param         integer $type   1=>所有,2=>数字,3=>数字加小写,默认1
   * @param         integer $count  生成的数字长度
   * @return        $string
   */
  public static function makeStr($type=1,$count=16) 
  {

    switch ($type) {
      case 1:
      $codeSet = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      break;
      case 2:
      $codeSet = '1234567890';
      break;
      case 3:
      $codeSet = '1234567890abcdefghijklmnopqrstuvwxyz';
      break;
      default:
      $codeSet = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      break;
    }
    for ($i = 0; $i<$count; $i++) {
      $codes[$i] = $codeSet[mt_rand(0, strlen($codeSet)-1)];
    }
    $nonceStr = implode($codes);
    
    return $nonceStr;
  }

  /**
   * 随机生成国人名字
   * @AiHuanGou
   * @DateTime      2017-04-15T16:28:18+0800
   * @return        $name
   */
  public static function getRandomName()
  {
    $xm = new XM;
    return $xm->getName();
  }

  /**
   * 随机生成国内电话号码
   * @AiHuanGou
   * @DateTime      2017-04-15T16:28:59+0800
   * @return        $mobile
   */
  public static function getRandomMobile()
  {
    $arr = array(
      130,131,132,133,134,135,136,137,138,139,
      144,147,
      150,151,152,153,155,156,157,158,159,
      176,177,178,
      180,181,182,183,184,185,186,187,188,189,
      );
    return $arr[array_rand($arr)].mt_rand(1000,9999).mt_rand(1000,9999);
  }

  /**
   * 随机生成国内ip
   * @AiHuanGou
   * @DateTime      2017-04-15T16:29:28+0800
   * @return        $ip
   */
  public static function getRandomIP()
  {
    // $arr_1 = array("218","218","66","66","218","218","60","60","202","204","66","66","66","59","61","60","222","221","66","59","60","60","66","218","218","62","63","64","66","66","122","211");
    $arr_1 = array("14","27","58","61","113","59","116","119","120","125","123","183","218","219","223","221","163");
    $randarr = mt_rand(0,count($arr_1) - 1);
    $ip1id = $arr_1[$randarr];
    $ip2id =  round(rand(600000,  2550000)  /  10000);
    $ip3id =  round(rand(600000,  2550000)  /  10000);
    $ip4id =  round(rand(600000,  2550000)  /  10000);
    return  $ip1id . "." . $ip2id . "." . $ip3id . "." . $ip4id;
  }
  public static function  getCity($ip = '')
  {
    if($ip == ''){
      $url = "http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json";
      $ip=json_decode(file_get_contents($url),true);
      $data = $ip;
      $d = array();
      if (@$data['ret'] == 1)
      {
        $d['region'] = $data['province'].'省';
        $d['city'] = $data['city'].'市';
      }else{}
    }else{
      $url="http://ip.taobao.com/service/getIpInfo.php?ip=".$ip;
      $ip=json_decode(file_get_contents($url));   
      if((string)$ip->code=='1'){
       return '';
      }
     $d = (array)$ip->data;
   }
  
   return $d;   
  }
  public static function getRandomStr($count = 16)
  {
    return self::makeStr('1',$count);
  }

  /**
   * 随机生成邮箱
   * @AiHuanGou
   * @DateTime      2017-04-15T16:30:30+0800
   * @return        $email
   */
  public static function getRandomEmail()
  {
    $arr = array("126","139","qq","sohu","ali","taobao","cn","kuurin","firesky","hssfxy","yahoo","136",);
    $email = self::makeStr('3',mt_rand(4,12)).'@'.$arr[array_rand($arr)].'.com';
    return $email;
  }


  public static function getRandomNumber($count = 6)
  {
    return self::makeStr('2',$count);
  }

  /**
   * 生成验证码
   * @AiHuanGou
   * @DateTime      2017-04-15T16:34:09+0800
   * @param         $mobile
   * @return        $ymzcode
   */
  public static function yzm($mobile)
  {
    return AliSMS::yzm($mobile);
  }

  /**
   * 随机生成身份证
   * @AiHuanGou
   * @DateTime      2017-04-15T16:36:38+0800
   * @function      getSex() => 0,1
   * @function      getAge() => $num
   * @function      getDate() => $data
   * @function      validateCard() => true,false
   * @return        $idcard
   */
  public static function getRandomSFZ($birth="",$area_code='')
  {
    return SFZ::getSFZ($birth,$area_code);
  }
  public static function getSex($cid)
  {
    return SFZ::getGenderByIdCard($cid);
  }

  public static function getAge($cid)
  {
    return SFZ::getAgeByIdCard($cid);
  }
  public static function getDate($cid)
  {
    return SFZ::getDate($cid);
  }
  public static function validateCard($cid)
  {
    return SFZ::validateCard($cid);
  }

  /**
   * 创建文件夹
   * @AiHuanGou
   * @DateTime      2017-04-15T16:38:16+0800
   * @param        $dir,路径
   * @param        $mode,权限格式
   * @return       true,false
   */
  public static function mkdir($dir,$mode= 0777)
  {
   if (is_dir($dir) || @mkdir($dir, $mode)) return TRUE;
   if (!mkdirs(dirname($dir), $mode)) return FALSE;
   return @mkdir($dir, $mode);
  }
  /**
   * 生成国际统一编码
   * @AiHuanGou
   * @DateTime      2017-04-15T16:39:24+0800
   * @return        $uuid
   */
  public static function UUID()
  {
    return UtilUUID::stdUuid();
  }

  /**
   * post请求
   * @AiHuanGou
   * @DateTime      2017-04-15T16:39:24+0800
   * @param object $post_data  
   * @return object $data
   */
  public static function post($url,$header=null,$post_data)
  {
    return HttpsResponse::post($url,$header,$post_data);
  }

  public static function get($url,$header=null,$data = null)
  {
    return HttpsResponse::get($url,$header,$data);
  }

  public static function DataEncode($str,$assoc="utf-8")
  {
    $str = str_replace("\n","\\n",$str);
    $str = str_replace("\r","",$str);
    $str = preg_replace('/([{,]+)(\s*)([^"]+?)\s*:/','$1"$3":',$str);
    $str = preg_replace('/(,)\s*}$/','}',$str);
    return json_encode(json_decode($str,$assoc));
  }
  public static function Swiftpass($money,$payinfo)
  {
    $swiftpass = new Swiftpass;
    return $swiftpass->index($money,$payinfo);
  }


    /*
   * 判断是否为微信浏览器
   */
    public static function isWeixin(){
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        if (strpos($user_agent, 'MicroMessenger') === false) {
            // 非微信浏览器禁止浏览
            // echo "HTTP/1.1 401 Unauthorized";
            return false;
        } else {
            // 微信浏览器，允许访问
            // echo "MicroMessenger";
            // 获取版本号
            // preg_match('/.*?(MicroMessenger\/([0-9.]+))\s*/', $user_agent, $matches);
            // echo '<br>Version:'.$matches[2];
            return true;
        }
    }

    public static function is_mobile($mobile) {
        if (!is_numeric($mobile)) {
            return false;
        }
        return preg_match('#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,1,3,6,7,8]{1}\d{8}$|^18[\d]{9}$#', $mobile) ? true : false;
    }

    /**
     * 整理表单验证错误信息格式
     */
    public static function getErrorMsg($validator){

        $message = '';
        foreach ($validator as $val){
            $message.='<li>'.$val.'</li>';
        }
        return $message;
    }

    /**
     * 生成token
     */
    public static function  genToken( $len = 32, $md5 = true ) {
       # Seed random number generator
          # Only needed for PHP versions prior to 4.2
          mt_srand( (double)microtime()*1000000 );
          # Array of characters, adjust as desired
          $chars = array(
              'Q', '@', '8', 'y', '%', '^', '5', 'Z', '(', 'G', '_', 'O', '`',
              'S', '-', 'N', '<', 'D', '{', '}', '[', ']', 'h', ';', 'W', '.',
              '/', '|', ':', '1', 'E', 'L', '4', '&', '6', '7', '#', '9', 'a',
              'A', 'b', 'B', '~', 'C', 'd', '>', 'e', '2', 'f', 'P', 'g', ')',
              '?', 'H', 'i', 'X', 'U', 'J', 'k', 'r', 'l', '3', 't', 'M', 'n',
              '=', 'o', '+', 'p', 'F', 'q', '!', 'K', 'R', 's', 'c', 'm', 'T',
              'v', 'j', 'u', 'V', 'w', ',', 'x', 'I', '$', 'Y', 'z', '*'
          );
          # Array indice friendly number of chars;
          $numChars = count($chars) - 1; $token = '';
          # Create random token at the specified length
          for ( $i=0; $i<$len; $i++ )
              $token .= $chars[ mt_rand(0, $numChars) ];
          # Should token be run through md5?
          if ( $md5 ) {
              # Number of 32 char chunks
              $chunks = ceil( strlen($token) / 32 ); $md5token = '';
              # Run each chunk through md5
              for ( $i=1; $i<=$chunks; $i++ )
                  $md5token .= md5( substr($token, $i * 32 - 32, 32) );
              # Trim the token
              $token = substr($md5token, 0, $len);
          } return $token;
    }

  /**
   * 弹窗信息提示
   * @param $msg 提示信息
   * @param $url 跳转URL
   */
  public static function showMessage($msg,$url,$num=0){
    echo "<script>alert('".$msg."');</script>";
    // echo '<meta http-equiv="refresh" content="'.$num.';'.$url.'">';
    echo '<meta http-equiv="refresh" content="'.$num.';'.$url.'">';
    exit;
  }


    /**调用接口函数
     * @param
     * @param
     * @return
     */
    public static function Api_Request($url,$data,$method="GET",$opt="")
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_URL,$url);

        $method = strtoupper($method);
        if( $method == "POST" )
        {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        $content = curl_exec($ch);

        curl_close($ch);
        return $content;
    }

    /**
     * 保留两位小数但不四舍五入
     * @param $money
     */
    public static function formatMoney($num){
        return floor($num*100)/100;
    }

}
?>

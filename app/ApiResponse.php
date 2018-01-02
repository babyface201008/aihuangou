<?php
namespace App;
/**
 * Response class to api return 
 **/
use App\Model\Welkin\AiHuanGouUser;
use App\Model\Welkin\WelkinShop;
use App\Model\Welkin\WelkinSite;
use App\Model\Welkin\WelkinTpl;
use App\Model\Welkin\WelkinPlugin;
use App\Model\Plugin\PluginProduct as PluginProduct;
use App\Tools;
use App\Response;
use Validate;

use Session;
// $response->reply(0,'ok');
// $response->reply(1,'reponse error');
// $response->reply(2,'write sql error');
// $response->reply(3,'cloudn't find the data');
// $response->reply(4,'Limit privileges');
// $response->reply(5,'other error');
// $response->reply(6,'会话过期，请重新登录');
class ApiResponse
{   
    public $msg ;
    public $ret ;
    public $info;
    public $obj;

    public function __constuct()
    {

    }

    public function toJson()
    {
        return json_encode($this,JSON_UNESCAPED_UNICODE);
    }

    public function reply($ret,$msg,$info='')
    {
        $this->msg = $msg;
        $this->ret = $ret;
        $this->info = $info;
        return json_encode($this,JSON_UNESCAPED_UNICODE);
    }

    public function result()
    {
        return json_encode($this,JSON_UNESCAPED_UNICODE);
    }

    public function create($model,$data,$rule="",$rulemessage="")
    {
        if ($rule !== "")
        {
            $validator = Validator::make($data,$rule,$rulemessage);
            if ($validator->fails())
            {
                return $this->reply(1,"数据校验失败");
            }else{
                // 校验成功
            }
        }else{
            // 不需要校验
            $c = new $model;
            foreach($data as $k => $v)
            {
                $c->$k = $v;
            }
            if (@!($c->save()))
            {
                return $this->reply(2,'网络繁忙');
            }else{
                $this->obj = $c;
                return $this->reply(0,'添加成功');
            }
        }
    }

    public function update($model,$search,$data,$rule="",$rulemessage="")
    {
        if ($rule !== "")
        {
            $validator = Validator::make($data,$rule,$rulemessage);
            if ($validator->fails())
            {
                return $this->reply(1,"数据校验失败");
            }else{
                // 校验成功
            }
        }else{
            // 不需要校验
            $c = $model::where($search)->first();
            if ($c)
            {
                foreach($data as $k => $v)
                {
                    $c->$k = $v;
                }
                if ($c->save())
                {
                    $this->obj  = $c;
                    return $this->reply(0,'修改成功');
                }else{
                    return $this->reply(2,'网络繁忙');
                }
            }else{
                return $this->reply(3,'没有权限或者对象跑了');
            }
            
        }
    }

    public function delete($model,$data,$privileges="")
    {
        $d = $model::where($data)->first();
        if ($d)
        {
            $this->obj = $d;
            $d->is_delete = 1;
            if ($d->save())
            {
                return $this->reply(0,'删除成功');
            }else{
                return $this->reply(2,'网络繁忙');
            }
        }else{
            return $this->reply(3,'没有权限或者对象跑了');
        }
    }

    public function getInfo($model,$search,$rule="",$rulemessage="")
    {
        if ($rule !== "")
        {
            $validator = Validator::make($search,$rule,$rulemessage);
            if ($validator->fails())
            {
                $this->data = "数据校验失败";
                return $this->reply(1,$this->data);
            }else{
                // 校验成功
            }
        }else{
            // 不需要校验
            $c = $model::where($search)->first();
            if ($c)
            {
                $this->data = $c;
                return $this->reply(0,'ok');
            }else{
                $this->data = "没有权限或者对象跑了";
                return $this->reply(3,$this->data);
            }
            
        }
    }


    public function updateStatus($model,$data,$privileges="")
    {
        $response = new Response;
    }

}
?>


<?php 
namespace App\Tools\wechat;
/**
* This is the Wechat message class
*/

use App\Models\Message;
use App\Tools\MyLog\WechatLog;
use App\Tools\wechat\Http;
use App\Models\Dialog;
use App\Models\User;
class WechatMSg
{
	public static function replay($xml)
	{
		WechatLog::info($xml);
		if (!empty($xml)) {
			libxml_disable_entity_loader(true);
			$data = simplexml_load_string($xml);
			WechatLog::info($data->MsgTYpe);
			switch ($data->MsgType) {
				case 'text':
					//If the user didn't login user table;
					if (User::where('openid',$data->FromUserName)->count() == 0 ) {
							$user = new User;
							$user->openid = $data->FromUserName;
							$user->save();
					}
					$user_id = User::where('openid',$data->FromUserName)->first()->user_id;
					
					self::check_delete($data);

					#self::check_change();

					//check if not in a 
					if (Dialog::where('a',$user_id)->count() == 0) {
						//check if not in b
						if (Dialog::where('b',$user_id)->count() == 0 ) {
							$dialog = new Dialog;
							$dialog->a = $user_id;
							$dialog->a_openid = $data->FromUserName;
							$dialog->a_content= $data->Content;
							$dialog->last_send = $user_id;
							$dialog->save();
							//send the tuling to dialog
							$resp = self::tuling($data);
							break;
						}else{
							// the user_id in b
							$dialog = Dialog::where('b',$user_id)->first();
							$dialog->b_content = $data->Content;
							$dialog->last_send = $user_id;
							
							$data->ToUserName = $dialog->a_openid;
							$data->RContent = $data->Content;

							$dialog->save();
							$resp = self::xml_replay($data);
							break;
						}
						
					}else{
						//the user_id in a 
						$dialog = Dialog::where('a',$user_id)->first();
						//If the B is null tuling dialog
						if ($dialog->b == '') { $resp = self::tuling($data); break;}
						//If the B is tuling Find the Same condition of it and delete the dialog and build new one
						if ($dialog->b == 0 ) { 
							//Find if have the same condition
							if (Dialog::where('b',0)->where('a','<>',$user_id)->count() > 0 ) 
							{
								$delete_dialog = Dialog::where('b',0)->where('a','<>',$user_id)->first();
								$dialog->b = $delete_dailog->a;
								$dialog->b_openid =$delete_dialog->a_openid;
								$dialog->b_content = $delete_dialog->a_content;
								$dialog->last_send = $dialog->a;

								$data->ToUserName = $dialog->b_openid;
								$data->RContent   = $data->Content;
								
								$resp = self::xml_replay($data);
								break;
							}else{
								$resp = self::tuling();
								break;
							}
						}else{
							$dialog->b_content = $data->Content;
							$dialog->last_send = $data->FromUserName;
							$data->ToUserName = $dialog->a_openid;
							$data->RContent  = $data->Content;
							$dialog->save();
							$resp = self::xml_replay($data);
							break;
						}	

					}
					break;
				case 'event':
					WechatLog::info("event go");
					WechatLog::info($data->Event);
					switch ($data->Event) {
						case 'subscribe':

							$data->RContent = "小苍机器人.........你懂得";
							$resp = self::xml_replay($data);
							break;
						case 'unsubscribe':
							$data->Content =  $data->Content."unsubscribe";
							break;
						case 'SCAN':
							$data->Content =  $data->Content."SCAN".$data->Ticket.$data->EventKey;
							if ($data->Ticket !== null)
							{
								$data->Content = "welkin"."$data->EvnetKey";
								if ($data->EventKey == "welkin123"){
									$data->Content = $data->Content."welkin scan is good";
								}
							}
							WechatLog::info($data->Ticket);
							WechatLog::info($data->EventKey);
							break;
						case 'welkin':
							$data->Content =  $data->Content."welkin1231";
							break;
						default:
							$data->Content =  $data->Content."event default";
							break;
					}
					break;
				default:
					$data->Content =  $data->Content."welkin si gooo";
					break;
			}
			WechatLog::info($data->MsgType);
			$resp = self::xml_replay($data);
			return $resp;
		}else{
			WechatLog::info('xml is empty');
			return "xml is empty";
		}
	}

	public static function check_delete($data)
	{
		$check_time = date("Y-m-d H:i:s",(time() - 60) );
		Dialog::where('b',0)->where('updated_at','<',$check_time)->delete();
	}

	public static function check_change($data)
	{
		$check_time = date('Y-m-d H:i:s',(time() - 3*60 ));
		$dialog = Dialog::where("updated_at",'<',$check_time)->first();
		$last_send = $dialog->last_send;
		if ($dialog->a == $last_send)
		{
			$dialog->b = 0;
		}
		if ($dialog->b == $last_send)
		{
			$dialog->a = $dialog->b;
			$dialog->a_content = $dialog->b_content;
			$dialog->last_send = $dialog->a;
		}
		$dialog->save();
	}
	public static function tuling($data)
	{
		$user_id = User::where('openid',$data->FromUserName)->first()->user_id;

		$array = [];
		$array['key'] = 'fb2e6e85d2c74ad899750e53c1a5df97';
		$array['info'] = "$data->Content";
		$url = "http://www.tuling123.com/openapi/api";
		$resp_data = Http::origin_post($url,json_encode($array));
		$resp_data = json_decode($resp_data);
		if ($resp_data->code !== 100000)
		{
			$data->RContent = "本大爷休息了,一边玩去!";
		}else{

			$data->RContent = $resp_data->text;
		}
		$dialog = Dialog::where('a',$user_id)->first();
		$dialog->b = 0;
		$dialog->b_content = $data->RContent;
		$dialog->last_send  = 0;
		$dialog->save();
		$resp = self::xml_replay($data);
	}
	public static function xml_replay($data)
	{
			$openid = $data->FromUserName;
			$create_time = $data->CreateTime;
			$content = $data->content;
			$msgid   = $data->MsgId;
			$msgtype = $data->MsgType;
			$content = $data->Content;
			$rcontent = $data->RContent;
			$msg = new Message;
			$msg->openid = $openid;
			$msg->create_time = $create_time;
			$msg->msgtype = $msgtype;
			$msg->content = $content;
			$msg->msgid   = $msgid;
			$msg->replay_content =$rcontent;
			$msg->replay_time = $create_time;
			if ($msg->save())
			{
				$fromUsername = $data->FromUserName;
				$toUsername   = $data->ToUserName;
				$replay_message = $rcontent;
				$time = time();
				$textTpl = "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[%s]]></MsgType>
					<Content><![CDATA[%s]]></Content>
					<FuncFlag>0</FuncFlag>
					</xml>";             
				$msgType = "text";
				$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $replay_message);
				// $msg->replay_time = $time;
				// $msg->replay_content = $replay_message;
				// $msg->save();
				echo $resultStr;
			}else{
				$fromUsername = $data->FromUserName;
				$toUsername   = $data->ToUserName;
				$replay_message = "save msg fialed";
				$time = time();
				$textTpl = "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[%s]]></MsgType>
					<Content><![CDATA[%s]]></Content>
					<FuncFlag>0</FuncFlag>
					</xml>";             
				$msgType = "text";
				$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $replay_message);
				echo $resultStr;
			} 
	}

}
 ?>

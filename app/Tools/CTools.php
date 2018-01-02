<?php 
namespace App\Tools;
/**
* This is the Common Tools for test
*/
class CTools
{
	static function isIdCard($id_card)
	{
		if (strlen($id_card) !== 18)
			{
				return FALSE;
			}
		if($id_card)
		//加权因子
		$w = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);

		//校验码
		$v = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');

		$s = 0;

		for ($i=0; $i < 17; $i++) { 
			//提取17位中的一位数字
			$b = (int)$id_card{$i};
			$wi = $w[$i];
			$s += $b*$wi;
		}
		//取模计算
		$y = $s % 11;
		//检验
		$c = $v[$y];
		if ($id_card{17} == $c)
		{
			return TRUE;
		} else{
			return FALSE;
		}
	}

	function isChineseName($name)
	{

		if (preg_match('/^([\xe4-\xe9][\x80-\xbf]{2}){2,4}$/', $name)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
 ?>
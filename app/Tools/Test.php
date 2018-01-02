<?php 
namespace App\Tools;
use Illuminate\Http\Request;
class Test
{
	public function __construct(Request $request)
	{
		$test = $request->test;
	}
}
?>

<?php namespace App\Tools;

use Log;
use stdClass;
use Session;

class FileUtil {
	
	/**
	 * @brief 创建文件并写入文件
	 * @param $parent_path 父级路径 c:
	 * @param $file_path 文件路径 json/123456
	 * @param $file 文件 例 : access_token.json
	 * @param $data 数据
	 */
	public static function createMkdirToFile ($parent_path, $file_path, $file, $data) {
		
		$file_array = explode("/", $file_path);
		
		$tmp_path;
		
		foreach ( $file_array as $f ) {
			
			$tmp_path .= '/'.$f;
			
			if (is_readable($parent_path.$tmp_path) == FALSE) {
				mkdir($parent_path.$tmp_path);
			}
		} 
		
		$fp = fopen($parent_path.$file_path.$file, "w");
		fwrite($fp, json_encode($data));
		fclose($fp);
		
	}
	
	/**
	 * @brief 创建文件夹
	 * @param $parent_path 父级路径 c:
	 * @param $mkdir_path 创建路径 json/123456
	 */
	public static function createMkdir ($parent_path, $mkdir_path) {
		
		$mkdir_array = explode("/", $mkdir_path);
		
		$tmp_path = '';
		
		foreach ( $mkdir_array as $m ) {
			
			$tmp_path .= '/'.$m;
			
			if (is_readable($parent_path.$tmp_path) == FALSE) {
				mkdir($parent_path.$tmp_path);
			}
		} 
		
	}
	
	/**
	 * @brief 判断文件是否存在
	 * @param $file_path 文件路径 json/123456
	 */
	public static function isFile ($file_path) {
		
		if ( is_readable($file_path) ) {
			
			return TRUE;
			
		}
		
		return FALSE;
		
	} 
	
	
	/**
	 * @brief 读取文件数据
	 * @param $file_path 文件路径 json/123456
	 */
	public static function fileGetContents ($file_path) {
		
		$data = file_get_contents($file_path);
		
		return $data;
		
	} 
	
	/**
	 * @brief 写入文件以json数据的形势
	 * @param $file_path 文件路径 json/123456
	 * @param $data 保存数据
	 */
	public static function fileWirteToJson ($file_path, $data) {
		
		$fp = fopen($file_path, "w");
		fwrite($fp, json_encode($data));
		fclose($fp);
		
	} 
	
}

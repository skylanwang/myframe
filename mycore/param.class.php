<?php
defined('IN_SYSTEM') or exit('error：Illegal visit！错误：非法访问');
//我的core框架  模型 控制器 方法 参数处理类
/*
@copyright			(C) 2018-2019 skylan
@license				
@lastmodify			2019-2-20
*/
class param {

	//路由配置
	private $route_config = '';
	
	public function __construct()
	{
		if(!get_magic_quotes_gpc())
		{
			$_POST = new_addslashes($_POST);
			$_GET = new_addslashes($_GET);
		//	$_REQUEST = new_addslashes($_REQUEST);
			//$_COOKIE = new_addslashes($_COOKIE);
		}
		return true;
	}

	/**
	 * 获取模型(应用)
	 */
	public function route_m() {
		$m = isset($_GET['m']) && !empty($_GET['m']) ? $_GET['m'] :  '';
		$m = $this->safe_deal($m);
		if (empty($m)) {
			return 'index';//默认前端控制器php文件夹
		} else {
			if(is_string($m)) return $m;
		}
	}

	/**
	 * 获取控制器（类或文件）
	 */
	public function route_c() {
		$c = isset($_GET['c']) && !empty($_GET['c']) ? $_GET['c'] : '';
		$c = $this->safe_deal($c);
		if (empty($c)) {
			return 'Index';//默认前端页面首页文件/类的名
		} else {
			if(is_string($c)) return $c;
		}
	}

	/**
	 * 获取事件（方法函数）
	 */
	public function route_a() {
		$a = isset($_GET['a']) && !empty($_GET['a']) ? $_GET['a'] :  '';
		$a = $this->safe_deal($a);
		if (empty($a)) {
			return 'index';//默认前端页面初始化方法
		} else {
			if(is_string($a)) return $a;
		}
	}

	/**
	 * 安全处理函数
	 * 处理m,a,c
	 */
	private function safe_deal($str) {
		return str_replace(array('/', '.'), '', $str);
	}

}
?>
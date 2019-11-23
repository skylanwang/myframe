<?php
namespace mycore;

require __DIR__ . '/../mycore/base.php';

//定义常量,表示是在系统中,从正常入口进入本系统
define('IN_SYSTEM', true);
//定义当前应用系统的core目录路径,以备后边加载系统文件等定义路径使用
define('CORE_PATH', __DIR__ .DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'mycore'.DIRECTORY_SEPARATOR);
//定义当前应用系统的应用目录路径,以备后边加载应用类或文件等定义路径使用
define('MYAPP_PATH', __DIR__ .DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'myapp'.DIRECTORY_SEPARATOR);
//定义当前应用系统的配置文件所在目录
define('CONFIG_PATH', __DIR__ .DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR);
//加载公用函数库
start_core::load_sys_func('system');
start_core::load_sys_func('help');
class start_core
{
	/**
	 * 类库别名
	 * @var array
	 */
	protected static $classmap = [];
	/**
	 * 初始化应用程序
	 */
	public function __construct() {
		$param = start_core::load_sys_class('param');//调用参数处理获取模块文件夹模块及方法
		define('ROUTE_M', $param->route_m());
		define('ROUTE_C', $param->route_c());
		define('ROUTE_A', $param->route_a());
		$this->init();

	}

	/**
	 * 调用初始化
	 */
	private function init() {
		$controller_class = $this->load_controller();//调用应用模块类并返回该类
		if (method_exists($controller_class, ROUTE_A)) {
			if (preg_match('/^[_]/i', ROUTE_A)) {
				exit('You are visiting the action is to protect the private action');
			} else {
				call_user_func(array($controller_class, ROUTE_A));//调用返回的模块类的函数方法
			}
		} else {
			exit('Action does not exist.');
		}
	}

	/**
	 * 加载控制器
	 * @param string $filename
	 * @param string $m
	 * @return obj
	 */
	private function load_controller($filename = '', $m = '') {
		//echo 'c:',ROUTE_C,'----m:',ROUTE_M,'----a:',ROUTE_A,"<br>";
		$filename = ROUTE_C;
		$m = ROUTE_M;
		$filepath = MYAPP_PATH.DIRECTORY_SEPARATOR.$m.DIRECTORY_SEPARATOR.'controller'.DIRECTORY_SEPARATOR.$filename.'.php';
		if (file_exists($filepath)) {
			$classname = $filename;
			include $filepath;//载入模块类文件
			if(class_exists('myapp'.DIRECTORY_SEPARATOR.$m.DIRECTORY_SEPARATOR.'controller'.DIRECTORY_SEPARATOR.$classname,false))
			{//判断模块类在调用的文件中是否存在,文件名与类名相同,
				//echo "app".DIRECTORY_SEPARATOR.$m.DIRECTORY_SEPARATOR.'controller'.DIRECTORY_SEPARATOR.$classname,"<br>";
				$new_class_str = "myapp".DIRECTORY_SEPARATOR.$m.DIRECTORY_SEPARATOR."controller".DIRECTORY_SEPARATOR.$classname;
				return new $new_class_str;//返回新实例化的模块类
				//return new $classname;
			}else{
				exit('Controller does not exist1.');
 			}
		} else {
			exit('Controller does not exist2.');
		}
	}
	
	/**
	 * 加载系统类方法
	 * @param string $classname 类名
	 * @param string $path 扩展地址
	 * @param intger $initialize 是否初始化
	 */
	public static function load_sys_class($classname, $path = '', $initialize = 1) {
			return self::_load_class($classname, $path, $initialize);
	}


	/**
	 * 加载类文件函数
	 * @param string $classname 类名
	 * @param string $path 扩展地址
	 * @param intger $initialize 是否初始化
	 */
	private static function _load_class($classname, $path = '', $initialize = 1) {
		static $classes = array();//静态化类
		if (empty($path))
		{
			$path = CORE_PATH.$classname.'.class.php';
		}
		$key = md5($path.$classname);//每个静态化载入系统类的实例化类的数组代码
		if (isset($classes[$key])) {//载入的系统class是否已经实例化,是就直接返回已经实例化的类
			if (!empty($classes[$key])) {
				return $classes[$key];
			} else {
				return true;
			}
		}
		if (file_exists($path))
		{
			include $path;
			$name = $classname;
			if ($initialize) {
				$classes[$key] = new $name;
			} else {
				$classes[$key] = true;
			}
			return $classes[$key];
		} else {
			return false;
		}
	}
	
	/**
	 * 加载系统的函数库
	 * @param string $func 函数库名
	 */
	public static function load_sys_func($func) {
		return self::_load_func($func);
	}
	
	
	/**
	 * 加载函数库
	 * @param string $func 函数库名
	 * @param string $path 地址
	 */
	private static function _load_func($func, $path = '') {
		static $funcs = array();
		if (empty($path)) $path = CORE_PATH.'/function';
		$path .= DIRECTORY_SEPARATOR.$func.'.function.php';
		include $path;
		return true;
	}

	/**
	 * 加载配置文件
	 * @param string $file 配置文件
	 * @param string $key  要获取的配置荐
	 * @param string $default  默认配置。当获取配置项目失败时该值发生作用。
	 * @param boolean $reload 强制重新加载。
	 */
	public static function load_config($file, $key = '') {
		static $configs = array();
		$path = SKYLAND_PATH.'/config/config_system.php';
		$configs[$file] = include $path;
		if (empty($key)) {
			return $configs[$file];
		} elseif (isset($configs[$file][$key])) {
			return $configs[$file][$key];
		} else {
			return $default;
		}
	}
}
/**
 * 作用范围隔离
 *
 * @param $file
 * @return mixed
 */
function __include_file($file)
{
    return include $file;
}

function __require_file($file)
{
    return require $file;
}

$start_core_class = new start_core;
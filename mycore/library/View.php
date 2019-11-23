<?php
namespace mycore\library;
//require_once( getRootPath().'third'.DIRECTORY_SEPARATOR.'smarty'.DIRECTORY_SEPARATOR.'libs'.DIRECTORY_SEPARATOR.'Smarty.php');
class View
{
	protected  $smarty;
	public function __construct()
	{
		$this->smarty = new \Smarty();
        $this->smarty->compile_dir = './templates_c/';
        $this->smarty->setTemplateDir(getRootPath()."myapp".DIRECTORY_SEPARATOR.ROUTE_M.DIRECTORY_SEPARATOR.'view'.DIRECTORY_SEPARATOR);
        //echo $this->smarty->getTemplateDir(0);
	}
    public function fetch($template)
    {
        $this->smarty->display($template);
    }
    public function assign($name,$val)
    {
        $this->smarty->assign($name,$val);
    }
}
//获取应用根目录
function getRootPath()
{
    if ('cli' == PHP_SAPI) {
        $scriptName = realpath($_SERVER['argv'][0]);
    } else {
        $scriptName = $_SERVER['SCRIPT_FILENAME'];
    }

    $path = realpath(dirname($scriptName));

    if (!is_file($path . DIRECTORY_SEPARATOR . 'core')) {
        $path = dirname($path);
    }

    return $path . DIRECTORY_SEPARATOR;
}
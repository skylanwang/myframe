<?php
namespace mycore;

include "..".DIRECTORY_SEPARATOR."third".DIRECTORY_SEPARATOR."smarty".DIRECTORY_SEPARATOR."libs".DIRECTORY_SEPARATOR."Smarty.class.php";

//自动加载
//spl_autoload_register('Loader::autoload'); // 注册自动加载
spl_autoload_register(function ($class_name) {
    $class_name = str_replace('\\',DIRECTORY_SEPARATOR, $class_name); //将 use语句中的’\’替换成’ 当前系统文件夹分隔符‘，避免造成转移字符导致require_once时会报错
    // if(strpos($class_name,'Smarty_Internal_Template')>-1)
    // {
    //     require_once getRootPath().'third'.DIRECTORY_SEPARATOR.'smarty'.DIRECTORY_SEPARATOR.'libs'.DIRECTORY_SEPARATOR.'Smarty_Internal_Template.php';
    // }
    // //echo getRootPath().$class_name . '.php';
    // else
    // {
    //     require_once getRootPath().$class_name . '.php';        //文件的后缀名是 .php//
    // }
    // if(strpos($class_name,'Smarty')>-1)
    // {
        //echo "--class:",$class_name,"<br>";
    // }
    require_once getRootPath().$class_name . '.php';        //文件的后缀名是 .php//
});

// 获取应用根目录
function getRootPath()
{
    if ('cli' == PHP_SAPI) {
        $scriptName = realpath($_SERVER['argv'][0]);
    } else {
        $scriptName = $_SERVER['SCRIPT_FILENAME'];
    }

    $path = realpath(dirname($scriptName));

    if (!is_file($path . DIRECTORY_SEPARATOR . 'mycore')) {
        $path = dirname($path);
    }

    return $path . DIRECTORY_SEPARATOR;
}
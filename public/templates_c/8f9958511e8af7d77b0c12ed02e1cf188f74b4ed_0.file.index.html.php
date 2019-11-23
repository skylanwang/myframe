<?php
/* Smarty version 3.1.33, created on 2019-03-03 04:32:13
  from 'D:\phpStudy\PHPTutorial\www.mytest.com\myapp\index\view\index.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5c7ae84d05fa91_16938558',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8f9958511e8af7d77b0c12ed02e1cf188f74b4ed' => 
    array (
      0 => 'D:\\phpStudy\\PHPTutorial\\www.mytest.com\\myapp\\index\\view\\index.html',
      1 => 1551558722,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5c7ae84d05fa91_16938558 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8">
  	<title>mycore框架 PHP 和 Smarty</title>
</head>
<body>
<?php echo $_smarty_tpl->tpl_vars['abc']->value;?>
<br>
php 写的 mycore 微框架， 结合smarty模板引擎3.1.33
<br><br>
<a href="/?m=index&c=Index&a=test&mm=1111">测试input 各项功能</a>
<br><br>
<a href="/?m=index&c=Index&a=mysqlTest">测试mysql 原生查询及JSON数据接口</a>
<br><br>
<a href="/?m=index&c=Index&a=mysqlTestErr">测试mysql 错误信息</a>
</body>
</html><?php }
}

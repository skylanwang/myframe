<?php
namespace myapp\index\controller;

use mycore\mysqlt\MysqlTool;
use mycore\library\View;
use myapp\common\controller\CommonTool;
class Index
{
	private $db;
	public function __construct()
	{
		// echo "MYAPP __construct<br>";
	}
	public function index()
	{
		$jjjj = new_addslashes("new_addslashes(string84692\|99`=)");
		$smarty = new View();
		$smarty->assign("abc",$jjjj);
		$smarty->fetch("index.html");
	}

	public function test()
	{
		// echo "MYAPP index<br>";
		
		// $mysql_tools = new MysqlTool();
		// $mysql_tools->index();
		// MysqlTool::indexStatic();
		// $common_tool = new CommonTool;

		echo "get变量mm：",input('get.mm'),"<br>";
		//echo input('post.mm'),"<br>";//因为不存在post mm 会报错
		echo "get变量mm是否存在：";
		if(input('?get.mm')){echo '存在',"<br>";}else{echo '不存在',"<br>";}

		echo "get变量mm是否符合验证规则，email,否则返回false：";
		if(input('get.mm','email')){echo input('get.mm'),"<br><br>";}else{echo '不正确参数',"<br><br>";}

		echo "get变量mm是否符合验证规则，alphaDash,判断字符串是否是字母数字下划线组成,否则返回false：";
		if(input('get.mm','alphaDash')){echo input('get.mm'),"<br><br>";}else{echo '不正确参数',"<br><br>";}

		echo "get变量mm是否符合验证规则，alphaNum,判断字符串是否是字母数字组成,否则返回false：";
		if(input('get.mm','alphaNum')){echo input('get.mm'),"<br><br>";}else{echo '不正确参数',"<br><br>";}

		echo "get变量mm是否符合验证规则，alpha,判断字符串是否是字母组成,否则返回false：";
		if(input('get.mm','alpha')){echo input('get.mm'),"<br><br>";}else{echo '不正确参数',"<br><br>";}

		echo "get变量mm是否符合验证规则，num,判断字符串是否是只有数字组成的整数,否则返回false：";
		if(input('get.mm','num')){echo input('get.mm'),"<br><br>";}else{echo '不正确参数',"<br><br>";}

		echo "get变量mm是否符合验证规则，int,判断字符串是否是整数,否则返回false：";
		if(input('get.mm','int')){echo input('get.mm'),"<br><br>";}else{echo '不正确参数',"<br><br>";}

		echo "get变量mm是否符合验证规则，float,判断字符串是否是浮点数,否则返回false：";
		if(input('get.mm','float')){echo input('get.mm'),"<br><br>";}else{echo '不正确参数',"<br><br>";}

		echo "get变量mm是否符合验证规则，phone,判断字符串是否是手机号,否则返回false：";
		if(input('get.mm','phone')){echo input('get.mm'),"<br><br>";}else{echo '不正确参数',"<br><br>";}

		echo "get变量mm是否符合验证规则，date,判断字符串是否是日期,否则返回false：";
		if(input('get.mm','date')){echo input('get.mm'),"<br><br>";}else{echo '不正确参数',"<br><br>";}

		echo "get变量mm是否符合验证规则，time,判断字符串是否是时间,否则返回false：";
		if(input('get.mm','time')){echo input('get.mm'),"<br><br>";}else{echo '不正确参数',"<br><br>";}
		//还需要： 日期，时间，日期和时间，中文，中文字母，中文数字，中文字母数字，中文字母数字下划线
		//        身份证，座机，银行卡号，qq号码，微信号码，是否有特殊字符，文件验证
		//		  IPV4，IPV6，mac地址，字符串长度，不在指定字符串内，在指定字符串内，数字不在某个范围内，数字在某个范围内
		//        参数必须提交验证，错误返回信息设置，正则验证
	}
	public function mysqlTest()
	{
		$db = new MysqlTool();
		$user = $db->query("select * from user where id=1 limit 1");
		returnjson('1','查询成功',$user);
	}
	public function mysqlTestErr()
	{
		$db = new MysqlTool();
		$user = $db->query("select * from user where user_id=1 limit 1");
		returnjson('1','查询成功',$user);
	}
}
<?php
/*
mysql查询类库
*/
namespace mycore\mysqlt;

class MysqlTool
{
	protected $mysql_host;
	protected $mysql_db;
	protected $mysql_user;
	protected $mysql_pwd;
	protected $mysql_port;
	protected $mysql_charset;
	private $statement = null;
	protected $_sql = false; //最后一条sql语句
	// protected mysql_config = array(
	// 	'host'=>config('config','hostname'),
	// 	'dbName'=>config('config','database'),
	// 	'user'=>config('config','username'),
	// 	'password'=>config('config','password'),
	// 	'port'=>config('config','hostport'),
	// 	'charSet'=>config('config','charset')
	// );
	protected static $mysql_conn;
	public function __construct()
	{
		$this->mysql_host = config('config','hostname');
		$this->mysql_db = config('config','database');
		$this->mysql_user = config('config','username');
		$this->mysql_pwd = config('config','password');
		$this->mysql_port = config('config','hostport');
		$this->mysql_charset = config('config','charset');
        //连接数据库
        if ( is_null(self::$mysql_conn) )
        {
            self::$mysql_conn = new \PDO('mysql:host='.$this->mysql_host.';dbname='.$this->mysql_db.';port='.$this->mysql_port.';charset='.$this->mysql_charset,$this->mysql_user,$this->mysql_pwd);
        }
	}

    /** 
    * 执行语句 针对 INSERT, UPDATE 以及DELETE,exec结果返回受影响的行数
    * @param string $sql sql指令 
    * @return integer 
    */
    protected function _doExec($sql='')
    {
        $this->_sql = $sql;
        return self::$mysql_conn->exec($this->_sql);
    }

    /** 
    * 执行sql语句，自动判断进行查询或者执行操作 
    * @param string $sql SQL指令 
    * @return mixed 
    */
    public function query($sql='')
    {
        $queryIps = 'INSERT|UPDATE|DELETE|REPLACE|CREATE|DROP|LOAD DATA|SELECT .* INTO|COPY|ALTER|GRANT|REVOKE|LOCK|UNLOCK'; 
        if (preg_match('/^\s*"?(' . $queryIps . ')\s+/i', $sql)) { 
            return $this->_doExec($sql);
        }
        else {
            //查询操作
            return $this->_doQuery($sql);
        }
    }
    /**
    * 执行查询 主要针对 SELECT, SHOW 等指令
    * @param string $sql sql指令 
    * @return mixed 
    */
    protected function _doQuery($sql='')
    {
        $this->_sql = $sql;
        $pdostmt = self::$mysql_conn->prepare($this->_sql); //prepare或者query 返回一个PDOStatement
        try{
        	$pdostmt->execute();
            $code=$pdostmt->errorCode();
        	$result = $pdostmt->fetchAll(self::$mysql_conn::FETCH_ASSOC);
        	if($code != "00000")
        	{
        		$this->getError($sql,$pdostmt);
        	}
        	return $result;
    	}
		catch (PDOException $e)
		{
		    echo 'Query failed: ' . $e->getMessage();
		}
    }

    protected function getError($sql,$pdostmt)
    {
    	if(config('config','app_debug'))
    	{
			$errMS = $pdostmt->errorInfo();
			echo '[Sql]: ',$sql;
			echo '错误码：'.$errMS[0].'<br/>'.'错误编号：'.$errMS[1].'<br/>'.'错误信息：'.$errMS[2].'<br/>';
			exit();

			echo "数据库错误：<br>";
			echo 'SQL Query:'.$query;
			echo '<pre>';
			var_dump($pdostmt->errorInfo());
			exit();
		}
		else
		{
			echo "发生致命错误，请检查数据库相关代码！";
			exit();
		}
    }
}
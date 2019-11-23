<?php
/*
mysql查询类库
*/
namespace mycore\mysqlt;

class MysqlTool
{
    private $sth;
    private $dbh;//数据库连接

    public $lastSQL = '';//最后一条sql语句

    protected $mysql_host;
    protected $mysql_db;
    protected $mysql_user;
    protected $mysql_pwd;
    protected $mysql_port;
    protected $mysql_charset;
    private $statement = null;

    public function __construct()
    {
        $this->mysql_host = config('config','hostname');
        $this->mysql_db = config('config','database');
        $this->mysql_user = config('config','username');
        $this->mysql_pwd = config('config','password');
        $this->mysql_port = config('config','hostport');
        $this->mysql_charset = config('config','charset');
        //连接数据库
        if (!$this->dbh)
        {
            $this->dbh = new \PDO('mysql:host='.$this->mysql_host.';dbname='.$this->mysql_db.';port='.$this->mysql_port.';charset='.$this->mysql_charset,$this->mysql_user,$this->mysql_pwd);
        }
    }
    public function beginTransaction()
    {
        return $this->dbh->beginTransaction();
    }

    public function inTransaction()
    {
        return $this->dbh->inTransaction();
    }

    public function rollBack()
    {
        return $this->dbh->rollBack();
    }

    public function commit()
    {
        return $this->dbh->commit();
    }

    function watchException($execute_state)
    {
        if(!$execute_state){
            $this->getError($this->lastSQL);
        }
    }

    public function fetchAll($sql, $parameters=[])
    {
        $result = [];
        $this->lastSQL = $sql;
        $this->sth = $this->dbh->prepare($sql);
        $this->watchException($this->sth->execute($parameters));
        while($result[] = $this->sth->fetch(\PDO::FETCH_ASSOC)){ }
        array_pop($result);
        return $result;
    }

    public function fetchColumnAll($sql, $parameters=[], $position=0)
    {
        $result = [];
        $this->lastSQL = $sql;
        $this->sth = $this->dbh->prepare($sql);
        $this->watchException($this->sth->execute($parameters));
        while($result[] = $this->sth->fetch(\PDO::FETCH_COLUMN, $position)){ }
        array_pop($result);
        return $result;
    }

    public function exists($sql, $parameters=[])
    {
        $this->lastSQL = $sql;
        $data = $this->fetch($sql, $parameters);
        return !empty($data);
    }

    public function query($sql, $parameters=[])
    {
        $this->lastSQL = $sql;
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->watchException($this->sth->execute($parameters));
        $result = $this->sth->fetchAll($this->dbh::FETCH_ASSOC);
        return $result;
    }

    public function fetch($sql, $parameters=[], $type=\PDO::FETCH_ASSOC)
    {
        $this->lastSQL = $sql; 
        $this->sth = $this->dbh->prepare($sql);
        $this->watchException($this->sth->execute($parameters));
        return $this->sth->fetch($type);
    }

    public function fetchColumn($sql, $parameters=[], $position=0)
    {
        $this->lastSQL = $sql;
        $this->sth = $this->dbh->prepare($sql);
        $this->watchException($this->sth->execute($parameters));
        return $this->sth->fetch(\PDO::FETCH_COLUMN, $position);
    }

    public function update($table, $parameters=[], $condition=[])
    {
        $table = $this->format_table_name($table);
        $sql = "UPDATE $table SET ";
        $fields = [];
        $pdo_parameters = [];
        foreach ( $parameters as $field=>$value){
            $fields[] = '`'.$field.'`=:field_'.$field;
            $pdo_parameters['field_'.$field] = $value;
        }
        $sql .= implode(',', $fields);
        $fields = [];
        $where = '';
        if(is_string($condition)) {
            $where = $condition;
        } else if(is_array($condition)) {
            foreach($condition as $field=>$value){
                $parameters[$field] = $value;
                $fields[] = '`'.$field.'`=:condition_'.$field;
                $pdo_parameters['condition_'.$field] = $value;
            }
            $where = implode(' AND ', $fields);
        }
        if(!empty($where)) {
            $sql .= ' WHERE '.$where;
        }
        return $this->query($sql, $pdo_parameters);
    }

    public function insert($table, $parameters=[])
    {
        $table = $this->format_table_name($table);
        $sql = "INSERT INTO $table";
        $fields = [];
        $placeholder = [];
        foreach ( $parameters as $field=>$value){
            $placeholder[] = ':'.$field;
            $fields[] = '`'.$field.'`';
        }
        $sql .= '('.implode(",", $fields).') VALUES ('.implode(",", $placeholder).')';

        $this->lastSQL = $sql;
        $this->sth = $this->dbh->prepare($sql);
        $this->watchException($this->sth->execute($parameters));
        $id = $this->dbh->lastInsertId();
        if(empty($id)) {
            return $this->sth->rowCount();
        } else {
            return $id;
        }
    }
    protected function getError($sql)
    {
        if(config('config','app_debug'))
        {
            $errMS = $this->sth->errorInfo();
            echo '[Sql]: ',$sql.'<br/>';
            echo '错误码：'.$errMS[0].'<br/>'.'错误编号：'.$errMS[1].'<br/>';
            echo '错误信息：'.$errMS[2].'<br/>';
            exit();
        }
        else
        {
            echo "发生致命错误，请检查数据库相关代码！";
            exit();
        }
    }
    public function errorInfo()
    {
        return $this->sth->errorInfo();
    }

    protected function format_table_name($table)
    {
        $parts = explode(".", $table, 2);

        if(count($parts) > 1) {
            $table = $parts[0].".`{$parts[1]}`";
        } else {
            $table = "`$table`";
        }
        return $table;
    }

    function errorCode()
    {
        return $this->sth->errorCode();
    }
}

//class MySQLException extends \Exception { }

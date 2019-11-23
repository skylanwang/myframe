<?php
//快捷助手函数，
if (!function_exists('input')) {
    /**
     * 获取输入数据 支持默认值和过滤
     * @param string    $key 获取的变量名
     * @param mixed     $default 默认值
     * @param string    $filter 过滤方法
     * @return mixed
     */
    function input($key = '', $filter = '', $preg = '')
    {
        if (0 === strpos($key, '?'))
        {
            $has = true;
            $key = str_replace('?', '', $key);
        }

        if ($pos = strpos($key, '.'))
        {
            // 指定参数来源
            $method = substr($key, 0, $pos);
            if (in_array($method, ['get', 'post', 'session', 'cookie', 'file']))
            {
                $key_array = $method;
                $variable = substr($key,(strpos($key, '.')+1));
            } else {
                return false;
            }
        }
        else {
            // 默认为自动判断
            return false;
        }

        if (isset($has))
        {
            return requestHas($key_array,$variable);
        }
        else
        {
            //获取提交变量
            return requestValue($key_array,$variable,$filter,$preg);
        }
    }

    function requestHas($act,$key)
    {
        $act_array = ["get"=>'$_GET', "post"=>'$_POST', "session"=>'$_SESSION', "cookie"=>'$_COOKIE', "file"=>'$_FILE'];
        switch ($act_array[$act])
        {
            case '$_GET':
                $return_data=isset($_GET[$key]);
                break;
            case '$_POST':
                $return_data=isset($_POST[$key]);
                break;
            case '$_SESSION':
                $return_data=isset($_SESSION[$key]);
                break;
            case '$_COOKIE':
                $return_data=isset($_COOKIE[$key]);
                break;
        }
        return $return_data;
    }
    function requestValue($act,$key, $filter = '', $preg = '')
    {
        $act_array = ["get"=>'$_GET', "post"=>'$_POST', "session"=>'$_SESSION', "cookie"=>'$_COOKIE', "file"=>'$_FILE'];
        switch ($act_array[$act])
        {
            case '$_GET':
                $return_data=$_GET[$key];
                break;
            case '$_POST':
                $return_data=$_POST[$key];
                break;
            case '$_SESSION':
                $return_data=$_SESSION[$key];
                break;
            case '$_COOKIE':
                $return_data=$_COOKIE[$key];
                break;
        }
        if($filter!='')
        {
            switch($filter)
            {
                case 'email':
                    if(!is_email($return_data))
                    {
                        $return_data = false;
                    }
                    break;
                case 'alphaDash'://判断字符串是否是字母数字下划线组成
                    if(!is_alphaDash($return_data))
                    {
                        $return_data = false;
                    }
                    break;
                case 'alphaNum'://判断字符串是否是字母数字组成
                    if(!is_alphaNum($return_data))
                    {
                        $return_data = false;
                    }
                    break;
                case 'alpha'://判断字符串是否是字母组成
                    if(!is_alpha($return_data))
                    {
                        $return_data = false;
                    }
                    break;
                case 'num'://判断字符串是否是只有数字组成的整数
                    if(!is_num($return_data))
                    {
                        $return_data = false;
                    }
                    break;
                case 'int'://判断字符串是否是只有数字组成的整数
                    if(!is_int($return_data))
                    {
                        $return_data = false;
                    }
                    break;
                case 'float'://判断字符串是否是浮点数
                    if(!is_floatfun($return_data))
                    {
                        $return_data = false;
                    }
                    break;
                case 'phone'://判断字符串是否是手机号
                    if(!is_phone($return_data))
                    {
                        $return_data = false;
                    }
                    break;
                case 'date'://判断字符串是否是日期
                     if(!isDateValid($return_data))
                     {
                        $return_data = false;
                     }
                    break;
                case 'time'://判断字符串是否是日期
                     if(!isTimeValid($return_data))
                     {
                        $return_data = false;
                     }
                    break;
            }
        }
        return $return_data;
    }


    function type()
    {
        $accept = $this->server('HTTP_ACCEPT');

        if (empty($accept)) {
            return false;
        }

        foreach ($this->mimeType as $key => $val) {
            $array = explode(',', $val);
            foreach ($array as $k => $v) {
                if (stristr($accept, $v)) {
                    return $key;
                }
            }
        }

        return false;
    }
}
//返回json数据的接口助手函数
if (!function_exists('returnjson'))
{
    function returnjson($code, $msg = '', $data = '')
    {
        $temp_str = json_encode($data,JSON_UNESCAPED_UNICODE);
        //$return_str = 
        header('Content-Type:application/json');
        echo  '{"code":"'.$code.'","msg":"'.$msg.'","data":'.$temp_str.'}';
        exit();
    }

}
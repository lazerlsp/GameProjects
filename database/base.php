<?php

//Подключение БД
function db($config=false){
    global $db;
    if(!$db){
        $db = mysqli_connect ($config['server'],$config['user'],$config['pass']) or  die('Нет подключения к БД');
        mysqli_select_db($db,$config['db']) or  die('Нет подключения к БД');
    }
    return $db;
}

//Просмотр данных авторизация из БД
function first(){
    $arr = func_get_args();
    $res = call_user_func_array('query',$arr);
    return mysqli_fetch_assoc($res);
}

//Функция для обновления БД
function update($table,$query,$where){
    global $db;
    $arr=array();
    foreach($query as $k=>$v) {
        $arr[] = sprintf('`%s`="%s"',$k,mysqli_escape_string($db,trim($v)));
    }
    return query('UPDATE '.$table.' SET '.implode(',',$arr).' WHERE '.$where);
}

function query($s){
    global $db;
    global $last_sql_log;
    if(func_num_args()>1){
        $arr = func_get_args();
        $s = call_user_func_array('sprintf',escapeArr($arr));
    }else if(is_array($s)){
        $s = call_user_func_array('sprintf',escapeArr($s));
    }
    $res = mysqli_query($db,$s);
    if($error = mysqli_error($db)) {
        $last_sql_log = '<div>Query: '.$s.'</div><div style="color:red">Error: '.$error.'</div>';
        print $last_sql_log;
        die();
    }
    return $res;
}

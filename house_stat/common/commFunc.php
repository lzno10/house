<?php
/**
 * 获取服务器所在机房
 */

function get_my_idc(){
    $uname = posix_uname();;
    $nodename = $uname['nodename'];
    $tmparr = explode(".",$nodename);
    $idc=$tmparr[2];
    return $idc;
}

/**
 * 依据配置获取redis连接句柄
 */
function get_redis($config){
    $redis = new Redis();
    $redis->connect(trim($config['host']),(int)$config['port']);
    if(isset($config['password'])){
        $redis->auth($config['password']);
    }
    if(isset($config['db'])){
        $redis->select((int)$config['db']);
    }
    return $redis;
}

/**
 * 测试redis连接句柄的连通性，不连通，重连
 */
function test_reconnect($r,$config){
   $ret = $r->ping();
   //var_dump($ret);
   //fwrite(STDOUT,"ret:$ret\n");
   if($ret=="+PONG"){
      return $r;
   }else{
      //fwrite(STDOUT,"lost r\n");
      $r = get_redis($config);
      return $r;
   }
}

function get_mongo_db($name,$dbconfig){
   $idc=NULL;
   if(isset($dbconfig['idc'])){
	   $idc=$dbconfig['idc'];
	   unset($dbconfig['idc']);
   }
   $config = get_mongo_qconf($name,$idc);
   //print_r($config);
   if(count($config)>0){
	    $options=NULL;
	    if(isset($config['options'])){
			$options = $config['options'];
			unset($config['options']);
	     }
         $config = array_merge($config,$dbconfig);
		 $mydb = new MyMongoDB($config,$options);
		 return $mydb; 
   }else{
       return NULL;
   }
}

function url_get_data($url,$params){
    $ret=NULL;
    $result = file_get_contents($url . http_build_query($params));
    if($result!=NULL){
        $ret=json_decode($result,true);
    }
    return $ret;
}
?>

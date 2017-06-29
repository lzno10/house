<?php
/*
 * Summary:绘图平台入口程序，由此调用后台获取数据的函数
 * Date: 2016-04-22 18:12
 * Author:felix-king
 * Filename:draw_pic.php
 */

error_reporting(E_ALL);
define('ROOT_PATH', dirname(__FILE__));
include(ROOT_PATH."/"."main.php");
include(MODULE_PATH."/"."get_data_func.php");

define("CONFIG_FILE",CONFIG_PATH."/"."report_conf.ini");
date_default_timezone_set("PRC");

$pid = isset($_GET['pid'])?$_GET['pid']:"";
$xiaoqu = isset($_GET['xiaoqu'])?$_GET['xiaoqu']:"";
$get_xiaoqu = isset($_GET['get_xiaoqu'])?$_GET['get_xiaoqu']:"";
if ($get_xiaoqu == "1") {
    $xiaoqu_list = get_xiaoqu_list();
    echo json_encode($xiaoqu_list);
    return;
}
elseif ($xiaoqu) {
    $xiaoqu_dict = explode(",", $xiaoqu);
}
else {
    $xiaoqu_dict = NULL;
}

$items=array();

$offset=0;

$ret=array();
if($pid!=""){
    $ret = call_get_data($pid,$config);
    if($ret['error']==0){
        $ret['items']=$items;
    }
}else{
    $ret = array("error"=>"-1001","err_msg"=>"lack pid");
}
echo json_encode($ret);

function call_get_data($pid,$config){
    global $items;
    global $report_day;
    $ret=array('error'=>0);
    $types=explode(",","line");
    $titles=explode(",","total_price");
    $functions = array();
    $params = array();
    if(count($types)==count($titles)){
        foreach($types as $index => $type){
            $item=array();
            $item['type']=$type;
            $item['title']=$titles[$index];
            $item['params']=isset($params[$index])?get_params($params[$index]):array();
            if(isset($functions[$index]) && $functions[$index]!="-"){
                $func=$functions[$index];
                if(function_exists($func)){
                    //$ret = $func($pid,$config);
                    $item = $func($pid,$config,$item);
                }else{
                    $ret=array('error'=>'-1003','err_msg'=>"deal-functions has no $func");
                }
            }else{
                $func = "get_".$type."_data";
                if(function_exists($func)){
                    //$ret = $func($ret,$config);
                    $item = $func($pid,$config,$item);
                }else{
                    $ret=array('error'=>'-1003','err_msg'=>"deal-functions has no $func");
                }
            }

            if($ret['error']==0){
                $kw=$pid."-".$index;
                $items[$kw]=$item;
            }
        }
    }else{
        $ret=array('error'=>'-1002','err_msg'=>"config $pid: title number != type number");
    }
    return $ret;
}

function get_xiaoqu_list(){
    $xiaoqu_list = array();
    $house_file = fopen("house.data", "r");
    while(!feof($house_file)) {
        $line = trim(fgets($house_file));
        $items = explode("\t", $line);
        $xiaoqu_name = $items[0];
        if ($xiaoqu_name) {
            $xiaoqu_list[] = $xiaoqu_name;
        }
    }
    fclose($house_file);
    return $xiaoqu_list;
}

function get_line_data($pid,$config,$item){
    global $xiaoqu_dict;
    $ret=array('error'=>0);
    $series = array();
    $house_file = fopen("house.data", "r");
    while(!feof($house_file)) {
        $data = array();
        $line = trim(fgets($house_file));
        $items = explode("\t", $line);
        $xiaoqu_name = $items[0];
        $info = $items[1];
        $info = json_decode($items[1], true);
        $info_item = $info[$pid];
        $output_flag = true;
        if ($xiaoqu_dict && !in_array($xiaoqu_name, $xiaoqu_dict)) {
            $output_flag = false;
        }
        if ($output_flag && $xiaoqu_name) {
            $data["name"] = $xiaoqu_name;
            $data["data"] = $info_item;
            $series[] = $data;
        }
    }
    fclose($house_file);
    $item['series']=$series;
    $item['title']=$pid;
    $item['y_title']=$pid;
    return $item;
}

?>

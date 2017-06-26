<?php
/*
 * Summary:获取各种统计数据的方法
 * Date: 2016-04-25 18:47
 * Author:felix-king
 * Filename:draw_pic.php
 */

/**
 * @summary:统计poi总量前30的城市
 */
function onl_city_top($pid,$config,$item){
    $tmpdata = onl_city_data($pid,$config,$item); 
    $data = $tmpdata['city'];
    $xkeys = array_keys($data);
    //$yvalues = array_values($data);
    $ydata = array_values($data);
    //print_r($ydata);
    
    $yvalues=array('online'=>array(),'depth'=>array());
    $xvalues=array();
    $cnum=0;
    foreach($ydata as $tmparr){
        if($cnum<30){
           $xvalues[]=$xkeys[$cnum];
           $depth=isset($tmparr[1])?$tmparr[1]:0;
           $yvalues['online'][]=$tmparr[0]-$depth;
           $yvalues['depth'][]=$depth;   
        }else{
           break;
        }
        $cnum++; 
    }

    $item['data']=$yvalues;
    $item['x_categories']=$xvalues;
    $item['y_title']=isset($config['y_title'])?$config['y_title']:"y_title";
    return $item;    
}

function onl_city_error($pid,$config,$item){
    $tmpdata = onl_city_data($pid,$config,$item);
    $data = $tmpdata['error'];
    asort($data);
    $xkeys = array_keys($data);
    $ydata = array_values($data);
    $yvalues=array('online'=>array(),'depth'=>array());
    $cnum=0;
    $xvalues=array();
    foreach($ydata as $tmparr){
         $xvalues[]=$xkeys[$cnum];
         $yvalues['online'][]=$tmparr[0];
         $cnum++;
    }
    $item['data']=$yvalues;
    $item['x_categories']=$xvalues;
    $item['y_title']=isset($config['y_title'])?$config['y_title']:"y_title";
    return $item;    
}

/**
 * 统计poi总量小于前30，且大于1.5w的城市
 */
function onl_city_middle($pid,$config,$item){
    $tmpdata = onl_city_data($pid,$config,$item); 
    $data=$tmpdata['city'];
    $xkeys = array_keys($data);
    $ydata = array_values($data);
    $yvalues=array('online'=>array(),'depth'=>array());
    $cnum=0;
    $xvalues=array();
    foreach($ydata as $tmparr){
        //$tmparr = explode(",",$unit);
        if($cnum>29){
           if($tmparr[0]>15000){
                   $xvalues[]=$xkeys[$cnum];
                   $depth=isset($tmparr[1])?$tmparr[1]:0;
                   $yvalues['online'][]=$tmparr[0]-$depth;
                   $yvalues['depth'][]=$depth;   
           }else{
               break;
           }
       }
       $cnum++;
    }
    $item['data']=$yvalues;
    $item['x_categories']=$xvalues;
    $item['y_title']=isset($config['y_title'])?$config['y_title']:"y_title";
    return $item;    
}

/**
 * 统计poi总量<=1.5w的城市
 */
function onl_city_small($pid,$config,$item){
    $tmpdata = onl_city_data($pid,$config,$item);
    $data = $tmpdata['city'];
    asort($data);
    $xkeys = array_keys($data);
    $ydata = array_values($data);
    $yvalues=array('online'=>array(),'depth'=>array());
    $cnum=0;
    $xvalues=array();
    foreach($ydata as $tmparr){
        if($tmparr[0]<=15000){
               $xvalues[]=$xkeys[$cnum];
               $yvalues['online'][]=$tmparr[0];
        }else{
            break;
        }
        $cnum++;
    }
    $item['data']=$yvalues;
    $item['x_categories']=$xvalues;
    $item['y_title']=isset($config['y_title'])?$config['y_title']:"y_title";
    return $item;    
}

function onl_city_data($pid,$config,$item){
    $redis_data = get_redis_data($pid); 
    $field = isset($item['params']['key'])?$item['params']['key']:"";
    $data = $redis_data; 
    if($field!=""){
       $data = isset($redis_data[$field])?$redis_data[$field]:array();
    }
    arsort($data);
    $result=array('city'=>array(),'error'=>array());
    foreach($data as $field => $value){
        if((preg_match("/区$/",$field,$matches)==1) && (preg_match("/自治区$/",$field,$matches)!=1) || preg_match("/省$/",$field,$matches)==1){
              $result['error'][$field]=$value;
              unset($data[$field]);
        }
    }    
    foreach(array("省直辖县","自治区直辖县") as $field){
       $result['error'][$field]=$data[$field];
       unset($data[$field]);
       
    }
    $result['city']=$data;
    return $result; 
}

function onl_mcat_depth($pid,$config,$item){
    $redis_data = get_redis_data($pid);
    unset($redis_data['online_poi']);
    $xkeys = array_keys($redis_data);
    $yvalues = array_values($redis_data);
    $result = array();
    foreach($yvalues as $values){
        foreach($values as $k => $v){
            if(!isset($result[$k])){
                 $result[$k]=array();
            }
            $result[$k][]=$v;
        }
    }   
 
    $item['data']=$result;
    $item['x_categories']=$xkeys;
    $item['y_title']=isset($config['y_title'])?$config['y_title']:"y_title";
    return $item;
}

function area_count($pid,$config,$item){
    $data = array(
       "update"=>array(2073200,798,386,176,114,151), 
       "error"=>array(33102,33110,33101,33100,33032)
    );
    $item['data']=$data;
    $item['x_categories']=array('2016-08-25','2016-09-01','2016-09-08','2016-09-15','2016-09-22','2016-09-22');
    $item['y_title']=isset($config['y_title'])?$config['y_title']:"y_title";
    return $item;    
}

function addr_count($pid,$config,$item){
    $data = array(
       "update"=>array(30391722,693528,1669,753,696,463982), 
       "error"=>array(193043,193027,190343,190360,190370,190375) 
    );
    $item['data']=$data;
    $item['x_categories']=array('2016-11-02','2016-11-08','2016-11-16','2016-11-23','2016-11-30','2016-12-07');
    $item['y_title']=isset($config['y_title'])?$config['y_title']:"y_title";
    return $item;    
}

function bd_check_count($pid,$config,$item){
   $data = array(
      "query"=>array(67008,85075,92473,95516,108556,103882,99002,109593,113692,107264),
      "right"=>array(64770,82679,90075,92961,105733,101066,96305,106673,110389,103867),
      "error"=>array(2238,2396,2398,2555,2823,2816,2697,2920,3303,3397),
      "bd_poi"=>array(92528,118438,129325,131401,150652,144049,137326,151720,157939,149069),
      "match"=>array(20941,26868,29178,29742,33822,32055,30749,33893,35905,33654),
      "unmatch"=>array(41110,52345,57376,58655,67343,64998,61547,68418,69945,65433)
   );
   $item['data']=$data;
   $item['x_categories']=array("04-21","04-22","04-23","04-24","04-25","04-26","04-27","04-28","04-29","04-30");
   $item['y_title']=isset($config['y_title'])?$config['y_title']:"y_title";
   return $item;
}

?>

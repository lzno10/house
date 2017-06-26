<?php
/*
 * Summary: 获取mongo的数据
 * Date: 2015-11-11 18:15
 * Author:felix-king
 */
require_once('/home/q/php/Qconf/Qconf.php');
class DituMongoData{
    private $hostName=NULL;
    private $qConf=array();
    private $_conn=NULL;
    public $db=NULL;
    public $clt=NULL;
    public $cltName=NULL;
    private $mongoConfig=array();

    /**
     * @summary:DituMongoData构造函数
     */  
    function __construct(){
       $this->set_mongo_config();
    }

    function close(){
       $this->_conn->close(); 
    }

    //
    private function set_mongo_obj($hostname,$config=array()){
        $this->qConf =$this->get_mongo_qconf($hostname);
        $mongo = new MyMongoDB($this->qConf,$this->qConf['options']);
        $this->_conn = $mongo->_conn;
        if(count($config)>0){
            if(isset($config['db'])){
                $this->db=$this->_conn->$config['db'];
                if(isset($config['clt'])){
                    $this->set_mongo_clt($config['clt']);
                }
            }
        }
    }

    function set_mongo_clt($clt,$db=NULL){
        if($db!=NULL){
           $this->db=$this->_conn->selectDB($db);
        }

        if($this->db!=NULL){
                $this->clt=$this->db->$clt;
                $this->cltName=$clt;
        }
    }

    public function set_depth_obj($clt=NULL){
        $config=array('db'=>'data_depth');
        if($clt!=NULL){
           $config['clt']=$clt;
        }
        $this->set_mongo_obj('depth',$config);
    }

    public function set_online_obj(){
        $config=array('db'=>'data_poi','clt'=>'data_poi');
        $this->set_mongo_obj('online',$config);
    }

    public function set_obj($name,$clt=NULL,$db=NULL){
         $config=array();
         
         switch($name){
            case "online":
                $config['db']="data_poi";
                $config['clt']="data_poi";
                break;
            case "depth":
                $config['db']="data_depth";
                break;
            case "base":
                $config['db']="data_poi";
                $config['clt']="data_poi";
                break;
            default:
                break;
         }
         
         if($db!=NULL){
             $config['db']=$db;
         }

         if($clt!=NULL){
             $config['clt']=$clt;
         }

         if(count($config)>0){
             $this->set_mongo_obj($name,$config);
         }
         
    }

    private function set_mongo_config(){
        $mongo_poi=array(
                'appname'=>'md_7445',
                'user'=>'mongo',
                'password'=>'708bfb3264349222'
                );

        $mongo_opertaion=array(
                'appname'=>'md_7252',
                'user'=>'mongo',
                'password'=>'7192b086653ebd0b'
                );

        $mongo_tuso=array(
                //'host'=>'10.119.162.138:7357',
                'appname'=>'md_7357',
                'user'=>'mongo',
                'password'=>'71fc60b867e74353'
                );

        $mongo_online=array(
                'appname'=>'md_7283',
                'user'=>'mongo',
                'password'=>'7193309a65404e92'
                );

        $MongoQconfList = array(
                'base'=>$mongo_poi,
                'operation'=>$mongo_opertaion,
                'depth'=>$mongo_tuso,
                'online'=>$mongo_online
                );
        $this->mongoConfig=$MongoQconfList;
    }

    private function get_mongo_qconf($name,$idc=null){
        $MongoQconfList = $this->mongoConfig;
        $configure=array();
        if(isset($MongoQconfList[$name])){
            $config = $MongoQconfList[$name];
            if(isset($config['appname'])){
                $appname = $config['appname'];
                //print("$appname\n");
                list($type, $replicaSet ) = explode('_', $appname);
                $record = sprintf("dba/mdb/%s,idc:%s\n",$appname,$idc);
                //print($record);
                $servers = Qconf::getAllHost("dba/mdb/". $appname,$idc);

                // Combind Servers String
                $mongo_servers = "mongodb://". implode(',', $servers);

                // Database && user name && password
                $username = $config['user'];
                $password = $config['password'];

                $options = array(
                        'replicaSet' => $replicaSet,
                        'username' => $username,
                        'password' => $password,
                        'readPreference'=>MongoClient::RP_SECONDARY_PREFERRED
                        );

                $configure = array(
                        'host'=>$mongo_servers,
                        'options'=>$options
                        );
            }else{
                $user = $config['user'];
                $password = $config['password'];
                $host=$config['host'];
                $configstr = "mongodb://$user:$password@$host";
                $configure['host']=$configstr;
            }
        }
        //print_r($config);
        return $configure;
    }
}

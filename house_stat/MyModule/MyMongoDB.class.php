<?php
/**
 * @function:the class is used to operate mongodb.
 * @author:fanchou
 * @create_time:2014-09-29
 * @modify_time:no
 */
 
 class MyMongoDB {
    private $_conn;
    public $_db;
    public $_clt;

    function __construct($configure){
       $this->_conn =  new MongoClient($configure['host']);
       $this->_db = $this->_conn->$configure['db'];
       if(isset($configure['clt'])){
           $this->_clt = $this->_db->$configure['clt'];
       }
    }

    /*获取集合的名称*/
    function get_collection_name(){
       return $this->_clt->getName();
    }

    /*插入操作*/
    function insert($value){
        $this->_clt->insert($value);
    }

    /*返回集合中的文档数*/
    function count($cond=array()){
        if(count($cond)==0){
            return $this->_clt->count();
        }else{
            return $this->_clt->count($cond);
        }
    }

    /**
     * 查找操作
     * @param：array,$cond,查找条件
     */
    function find($cond=array(),$show=array()){
       if(count($cond)==0){
          return $this->_clt->find();
       } 
       if(count($show)==0){             
                return $this->_clt->find($cond);
       }else{
                return $this->_clt->find($cond,$show);
       }
    }
    
    function limitfind($cond=array(),$limit,$skip){
    	if(count($cond)==0){
          return	$this->_clt->find()->limit($limit)->skip($skip);
    	}else{
    		 return	$this->_clt->find($cond)->limit($limit)->skip($skip);
    	}
     }

    /**
     * 查找单条记录
     * @param:array,$conf,查找条件
     * @return：array,查找结果
     */
    function findOne($cond,$fields=null){
        if($fields!=null){
            return $this->_clt->findOne($cond,$fields);
        }else{
            return $this->_clt->findOne($cond);
        }
    }

    /*更新操作*/
    function update($where,$values,$option=array()){
       if(count($option)==0){
           $this->_clt->update($where,$values);
       }else{
          $this->_clt->update($where,$values,$option);
       }
    }   

    /*删除记录*/
    function remove($cond=array()){
        if(count($cond)==0){
           $this->_clt->remove();
        }else{
           $this->_clt->remove($cond);
        }
    }

    /*删除集合*/
    function dropCollection(){
       $this->_clt->drop();
    }

    /*选择集合*/
    function selectCollection($cltName){
       $this->_clt = $this->_db->$cltName;
    }

    /*创建索引*/
    function createIndex($key,$options=array()){
       if(count($options)==0){
           $this->_clt->ensureIndex($key);
       }else{
           $this->_clt->ensureIndex($key,$options);
       }
    }
    
    /*关闭mongodb的连接*/
    function close(){
      $this->_conn->close();
    }
    
 }

?>

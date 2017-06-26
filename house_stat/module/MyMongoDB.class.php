<?php
/**
 * @function:the class is used to operate mongodb.
 * @author:fanchou
 * @create_time:2014-09-29
 * @modify_time:no
 */
 
 class MyMongoDB {
    public $_conn=NULL;
    public $_db=NULL;
    public $_clt=NULL;

    function __construct($configure,$options=NULL){
       if($options!=NULL){
           $this->_conn =  new MongoClient($configure['host'],$options);
       }else{
           $this->_conn =  new MongoClient($configure['host']);
       }
       if(isset($config['db'])){
           $this->_db = $this->_conn->$configure['db'];
       }
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

    function get_all_collection(){
       return $this->_db->getCollectionNames();
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

   
   /**
    * 查找固定个数的记录
    * @param:array,$cond,查找条件
    * @param:int,$limit,查看条数限制
    * @param:int,$skip,忽略几行
    * @return：array,查找结果
    */  
    function limitfind($cond=array(),$limit=5,$skip=0){
        if(count($cond)==0){
          return  $this->_clt->find()->limit($limit)->skip($skip);
        }else{
          return $this->_clt->find($cond)->limit($limit)->skip($skip);
        }
     }

    /**
     * 查找单条记录
     * @param:array,$cond,查找条件
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

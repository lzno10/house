<!DOCTYPE html>

<script src="./myjs/Calendar5.js" type="text/javascript"></script>
	<script type="text/javascript">
	  var c = new Calendar("c");
	  document.write(c);
</script>

<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="./bootstrap/docs/favicon.ico">

<title>house stat</title>

<!-- Bootstrap core CSS -->
<link href="./bootstrap/docs/dist/css/bootstrap.min.css"
	rel="stylesheet">

<!-- Custom styles for this template -->
<link href="./MyCSS/dashboard.css" rel="stylesheet">
<link href="./MyCSS/navbar.css" rel="stylesheet">

<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
<script src="./bootstrap/docs/assets/js/ie-emulation-modes-warning.js"></script>

<script type="text/javascript" src="./jquery/jquery-1.11.2.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
   $("#issue").click(function(){
       xiaoqu=$("#xiaoqu")[0].value
       args = get_select_data()
       if(args!=""){
           url = "caller.php?args="+args;
           url = url+"&xiaoqu="+xiaoqu;
           //alert(url);
           window.open(url); 
       }else{
           alert("请选择需统计的选项");
       }
   });

   function get_select_data(){
       var mydata = new Array();
       $("input[name='checkname']").each(function(){
             if(this.checked==true){
                  var data = this.id;
                  mydata.push(data)
             }
       });
       return mydata.toString();
   }

});
</script>

</head>

<body>
   <form method="post" action=""> 
   <?php include_once("header.php")?>
<div class="container">
  <div id='dateselect'>
    小区：<input style="width: 150px;height:36px" ype="text" name="xiaoqu" id="xiaoqu" />
    <button type="button" name="issue" id="issue" class="btn btn-danger">提交</button>
  </div>
    <div class="page-header">
        <h3>小区统计</h3>
    </div>
    <div class="row">
        <div class="col-sm-4">
          <div class="list-group">
            <a class="list-group-item list-group-item-success">
              <h4 class="list-group-item-heading"><input type='checkbox' name='checkname' id='total_price' value='total_price'>&nbsp;&nbsp;&nbsp;总价统计</h4>
              <p class="list-group-item-text">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;统计总价趋势</p>
            </a>
          </div>
        </div><!-- /.col-sm-4 -->
        <div class="col-sm-4">
          <div class="list-group">
            <a class="list-group-item list-group-item-info">
              <h4 class="list-group-item-heading"><input type='checkbox' name='checkname' id='unit_price' value='unit_price'>&nbsp;&nbsp;&nbsp;均价统计</h4>
              <p class="list-group-item-text">统计均价趋势</p>
            </a>
          </div>
        </div><!-- /.col-sm-4 -->
        <div class="col-sm-4">
          <div class="list-group">
            <a class="list-group-item list-group-item-warning">
              <h4 class="list-group-item-heading"><input type='checkbox' name='checkname' id='diff_price' value='diff_price'>&nbsp;&nbsp;&nbsp;砍价统计</h4>
              <p class="list-group-item-text">统计砍价趋势</p>
            </a>
          </div>
        </div><!-- /.col-sm-4 -->
      </div><!-- /.row -->
</div>
		<!-- Bootstrap core JavaScript
    ================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> -->
		<script src="./bootstrap/docs/dist/js/bootstrap.min.js"></script>
		<script src="./bootstrap/docs/assets/js/docs.min.js"></script>
		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
		<script
			src="./bootstrap/docs/assets/js/ie10-viewport-bug-workaround.js">
               </script>
</form>
</body>
</html>

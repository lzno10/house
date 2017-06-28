<?php
if($_GET['args']){
    $args=isset($_GET['args'])?$_GET['args']:"";
    $xiaoqu=isset($_GET['xiaoqu'])?$_GET['xiaoqu']:"";
}
?>
<!DOCTYPE html>
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

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<script src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script type="text/javascript" src="./highcharts/js/modules/exporting.js"></script>
<script type="text/javascript" src="./myjs/common.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    var funlist = new Array();
    args = "<?php echo $args?>";
    xiaoqu= "<?php echo $xiaoqu?>";
    //alert(xiaoqu)
    funlist = args.split(",")
        for(i=0;i<funlist.length;i++){
            var pid = funlist[i];
            call_dealfunc(pid,xiaoqu);
        }

    function call_dealfunc(pid,xiaoqu){
        func="draw_pic.php?pid="+pid+"&xiaoqu="+xiaoqu
            //alert(func)
            $.ajax({
            url: func,
            datatype: "json",
            success: function(data) {
                //alert(data)
                var ret = eval( '(' + data + ')' )
                    var items = ret['items']
                    for(mypid in items){
                        var item = items[mypid]
                        createElement(mypid)
                        //alert(item)
                        draw_pic(mypid,item)
                    }
            },
            cache: false
    });
    }

    function draw_pic(pid,item){
        var type=item['type']
        //alert("draw_pic: "+pid+" type: "+type)
        var options = {
            chart: {
                renderTo: pid,
                zoomType: 'xy',
                type: "line",
                //type: "spline",
                //inverted: true,
            },
            title: {
                text: item['title']
            },
            tooltip: {
                headerFormat: '<span style="color:{series.color};"></span><span>{point.key}</span>',
                pointFormat: '<table>'+
                '<tr><td style="color:{series.color};">{series.name}:</td>' +
                '<td><b>{point.y:.0f}</b></td></tr>',
                footerFormat:'</table>',
                shared: true,
                useHTML: true,
                xDateFormat:'%Y.%m.%d'
            },
            xAxis: {
                type:"datetime",
                dateTimeLabelFormats: {
                millisecond: '%Y.%m.%d',
                    second: '%Y.%m.%d',
                    minute: '%Y.%m.%d',
                    hour: '%Y.%m.%d',
                    day: '%Y.%m.%d',
                    month: '%Y.%m.%d',
                    year: '%Y.%m.%d'
                }

            },
            yAxis: {
                title: {
                    text: 'y_value'
                },
            },
            series:item["series"]
        };
        //alert(JSON.stringify(item))

        var mystyle = {
            'width':"1100px",
            'height':"420px",
        };

        var chart = new Highcharts.Chart(options);
    }

    function set_line_options(options,item){
        var y_values=item['data']
        for(name in y_values){
            var series = {
                data: []
            };
            values = y_values[name]
            series.name=name
            for(j in values){
                series.data.push(values[j]);
            }
            options.series.push(series)
        }

        return options
    }

    function createElement(myid){
        parent = document.getElementById("load_picture");
        var cdiv=document.createElement("div");
        cdiv.id=myid;
        cdiv.innerHTML="create: "+cdiv.id;
        parent.appendChild(cdiv);
        return cdiv.id
    }
});
</script>
</head>
<body>
   <form method="post" action="">
   <?php include_once("header.php")?>
<div class="container">
   <div id="load_picture" class="span7 text-center">
   <?php //echo $args ?>
   </div>
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

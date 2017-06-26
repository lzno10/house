//设置曲线图参数
function set_line_options(options,item){
   alert("set_line_options")
   //options.yAxis.title.text="Y-Value" 
   /*
   var x_cateories=item['x_cateories']
   
   for(i=0;i<x_cateories.length;i++){
        alert(x_cateories[i])
        options.xAxis.categories.push(x_cateories[i])
   }
   
   var y_values=item['name']
   for(name in y_values){
        var series = {
              data: []
        };
        values = y_values[name]
        for(j in values)
        series.data.push(values[j]);
        options.series.push(series)
   }

   options.yAxis.title.text="Y-Value"
   */
   return options
}

//设置饼状图参数
function set_pie_options(options,item){


   return options
}

//设置横向柱状图
function set_bar_options(options,item){


   return options
}

//设置纵向柱状图参数
function set_column_options(options,item){
   return options
}

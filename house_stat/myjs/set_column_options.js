/**
 * @summary:设置柱状图参数
 * @author:felix-king
 */
function set_column_options(options,item){
   //alert("set_column_options.js") 
   options.chart['type']='column' 
   var x_categories=item['x_categories'] 
   for(i in x_categories){
        options.xAxis.categories.push(x_categories[i])
   }
  
   options.yAxis['min']=0
   options.yAxis.title.text=item['y_title']
   var legend = {
            shadow: false

    }

   options['legend']=legend

   var tooltip = {
            headerFormat: '<b>{point.x}</b><br/>',
            pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
   }

   options['tooltip']=tooltip

   var y_values=item['data']
   for(name in y_values){
        var series = {
              data: []
        };
        values = y_values[name]
        series.name=name 
        for(j in values){
           //alert(name+": "+values[j])
           series.data.push(values[j]);
        }
        options.series.push(series)
   }
   
   var plotOptions = {
         column: {
            stacking: 'normal',
                dataLabels: {
                    enabled: true,
                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                    style: {
                        textShadow: '0 0 3px black'
                    }
                }
         }
   }   
   options.plotOptions=plotOptions
   return options
}

/**
 * @summary:设置堆叠柱状图参数
 * @author:felix-king
 */
function set_stackedcolumn_options(options,item){
   //alert("set_statcedcolumn_options.js") 
   options = set_column_options(options,item) 
   var stackLabels = {
         enabled: true,
         style: {
                fontWeight: 'bold',
                color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
          }
   }
   options.yAxis['stackLabels']=stackLabels
   return options
}

/**
 * @summary:设置fixed-columns的柱状图参数
 * @author:felix-king
 */
function set_fixedcolumn_options(options,item){
   //alert("set_fixedcolumn_options.js") 
   options.chart['type']='column'
   var x_categories=item['x_categories'] 
   for(i in x_categories){
        options.xAxis.categories.push(x_categories[i])
   }
 
 
   options.yAxis['min']=0
   options.yAxis.title.text=item['y_title']
   options.yAxis.opposite=true
   
   var legend = {
        shadow: false
    }

   options['legend']=legend

   var tooltip = {
         shared:true
   }

   options['tooltip']=tooltip

   var y_values=item['data']
   var i=0
   for(name in y_values){
        var series = {
              data: []
        };
        values = y_values[name]
        series.name=name 
        if(i%2==0){
           series.color='rgba(186,60,61,.9)'
           //series.pointPadding=0.47
           series.pointPadding=0.35
        }else{
           //series.color='rgba(248,161,63,1)'
           series.color='rgba(165,170,217,1)'
           //series.pointPadding=0.49
           series.pointPadding=0.42
        }
        series.pointPlacement=-0.2
        for(j in values){
           //alert(name+": "+values[j])
           series.data.push(values[j]);
        }
        i++
        options.series.push(series)
   }
   
   var plotOptions = {
         column: {
                grouping: false,
                shadow: false,
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                    style: {
                        textShadow: '0 0 3px black'
                    }
                }
         }
   }   
   options.plotOptions=plotOptions
   return options
}

/**
 * @summary:设置条状图的参数
 * @author:felix-king
 */ 
function set_bar_options(options,item){
   //alert("set_bar_options.js") 
   options.chart['type']="bar"
   var x_categories=item['x_categories'] 
   for(i in x_categories){
        options.xAxis.categories.push(x_categories[i])
   }
  
   options.yAxis['min']=0
   options.yAxis.title.text=item['y_title']
   var labels = {
        overflow:'justify'
   }
   
   var legend = {
       reversed: true
   }

   options['legend']=legend
   var credits= {
         enabled: false
   }
   options['credits']=credits

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
         bar: {
            stacking: 'normal',
                dataLabels: {
                    enabled: true,
                }
         }
   }   
     
   options.plotOptions=plotOptions
   return options
}

/**
 * @summary:设置堆叠条状图的参数
 * @author:felix-king
 */ 
function set_stackedbar_options(options,item){
   //alert("set_stackedbar_options.js") 
   var stackLabels = {
         enabled: true,
         style: {
                fontWeight: 'bold',
                color: (Highcharts.theme && Highcharts.theme.textColor) || 'blue'
          }
   }
   options.yAxis['stackLabels']=stackLabels
   options = set_bar_options(options,item)
   return options
}

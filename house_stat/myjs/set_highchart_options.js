/**
 * @summary:设置曲线图参数
 * @author:felix-king
 */
function set_line_options(options,item){
   alert("set_line_options.js") 
   options.yAxis.title.text=item['y_title']
   var x_categories=item['x_categories'] 
   for(i in x_categories){
        options.xAxis.categories.push(x_categories[i])
   }
   
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
   
   var plotOptions = {
       line:{
           dataLabels:{
              enabled:true
           },
           enableMouseTracking: false
       }
   }
    
   options.plotOptions=plotOptions
   return options
}

/**
 * @summary:设置饼图参数
 * @author:felix-king
 */
/*
function set_pie_options(options,item){
   alert("set_pie_options.js") 

   options.chart['plotBackgroundColor']=null
   options.chart['plotBorderWidth']=null
   options.chart['plotShadow']=false

   var series = {
      name:'Brands',
      colorByPoint:true,
      data:[] 
   } 
   var data = item['data']

  
   var m = {
       v:0,
       j:0
   }
   var index = 0
   for(i in data){
       //alert(i+": "+data[i])
       var item={name:null,y:0}
       item.name=i
       item.y=data[i]
       if(m.v<item.y){
         m.v=item.y
         m.j=index
       }
       series.data.push(item);
       index++;
   }
   
   index=m.j
   //alert(series.data[index].y)
   series.data[index]['sliced']=true
   series.data[index]['selected']=true
   options.series.push(series)

   var plotOptions = {
         pie: {
             allowPointSelect: true,
             cursor: 'pointer',
             dataLabels: {
                 //enabled: true,
                 //format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                 //format: '<b>{point.name}</b>: point.y',
             }
         }
   }   
   //options.plotOptions=plotOptions
   return options
}
*/

/**
 * @summary:设置柱状图参数
 * @author:felix-king
 */
function set_column_options(options,item){
   alert("set_column_options.js") 
   
   var x_categories=item['x_categories'] 
   for(i in x_categories){
        options.xAxis.categories.push(x_categories[i])
   }
  
   options.yAxis['min']=0
   options.yAxis.title.text=item['y_title']
   var stackLabels = {
         enabled: true,
         style: {
                fontWeight: 'bold',
                color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
          }
   }
   options.yAxis['stackLabels']=stackLabels
   
   var legend = {
            align: 'right',
            x: -30,
            verticalAlign: 'top',
            y: 25,
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
            borderColor: '#CCC',
            borderWidth: 1,
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

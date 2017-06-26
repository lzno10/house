/**
 * @summary:设置饼图参数
 * @author:felix-king
 */
function set_pie_options(options,item){
   //alert("set_pie_options.js") 

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
                 enabled: true,
                 format: '<b>{point.name}</b>: {point.percentage:.1f} % ({point.y})',
             }
         }
   }   
   options.plotOptions=plotOptions
   return options
}

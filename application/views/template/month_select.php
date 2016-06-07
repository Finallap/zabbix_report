@ page language="java" import="java.util.*" pageEncoding="UTF-8"%> 
<%@ taglib uri="/struts-tags"  prefix="s"%> 
<script type="text/javascript" src="<%=path%>/js/jquery-1.9.0.js"> 
<script type="text/javascript"> 
    $(function(){ 
      
         selectMonth(); 
    }) 
//年月选择 star 
        function selectMonth(){ 
     var myDate =  new Date(); 
     var year = myDate.getUTCFullYear(); 
     var month = myDate.getUTCMonth (); 
     var dateList = new Array(); 
     var endDay; 
     for(var i=0;i<=12;i++){ 
        var m = month+i; 
        endDay = maxDay(m,year-1); 
        if(m<12) 
        dateList.push((year-1)+"-"+(m+1)+"~"+endDay); 
        else 
        dateList.push(year+"-"+(m-11)+"~"+endDay); 
     } 
     dateList.reverse(); 
    $.each(dateList,function(idx,item){ 
        var ym = item.split("~"); 
            var mon = ym[0].split("-"); 
            if(mon[1]==(month+1) && mon[0] == year) 
            $("#dateList").append("<option value="+myDate.getDate()+">"+"本月"+"</option>"); 
            else 
            $("#dateList").append("<option value="+ym[1]+">"+ym[0]+"</option>"); 
            }) 
  
  
   getEndTime(); 
  
  
} 
  
  
function maxDay(month,year){//获得某年某月最大天数 
var d= new Date(); 
d.setUTCFullYear(year,month); 
return new Date(d.getFullYear(), d.getMonth()+1,0).getDate(); 
} 
  
  
function getEndTime(){ //动态生成 月初日期 和 月末日期 
    var list = $("#dateList option:selected"); 
    var selMonth = $("#dateList option:selected").html() 
    if( selMonth == "本月"){ 
     var d = new Date(); 
        $("#starTime").val(d.getUTCFullYear()+"-"+(d.getUTCMonth()+1)+"-1"); 
        $("#endTime").val(d.getUTCFullYear()+"-"+(d.getUTCMonth()+1)+"-"+list.val()); 
    }else{ 
    $("#starTime").val(selMonth+"-1"); 
    $("#endTime").val(selMonth+"-"+list.val()); 
    } 
} 
  
  
//年月选择end 
    </script> 
  <body> 
<td nowrap="nowrap" style="width: 15%" align="center"> 
                    日期： 
                    <select id="dateList" onchange="getEndTime()"> </select> 
                    从 
                    <input name="starTime" id="starTime"
                        value="<s:date name="starTime" format="yyyy-MM-dd"/>" 
                        onFocus="WdatePicker()" class="Wdate" 
                        style="width: 110px; height: 17px; border-left: 0; border-top: 0; border-right: 0; border-bottom-color: #C06" /> 
                    至 
                    <input name="endTime" id="endTime"
                        value="<s:date name="endTime" format="yyyy-MM-dd"/>" 
                        onFocus="WdatePicker()" class="Wdate" 
                        style="width: 110px; height: 17px; border-left: 0; border-top: 0; border-right: 0; border-bottom-color: #C06" /> 
  
  
                </td> 
  </body> 
 
<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ taglib uri="/struts-tags"  prefix="s"%>
<script type="text/javascript" src="<%=path%>/js/jquery-1.9.0.js">
<script type="text/javascript">
 $(function(){
  
   selectMonth();
 })
//年月选择 star
  function selectMonth(){
  var myDate =  new Date();
     var year = myDate.getUTCFullYear();
     var month = myDate.getUTCMonth ();
     var dateList = new Array();
     var endDay;
     for(var i=0;i<=12;i++){
      var m = month+i;
      endDay = maxDay(m,year-1);
      if(m<12)
      dateList.push((year-1)+"-"+(m+1)+"~"+endDay);
      else
      dateList.push(year+"-"+(m-11)+"~"+endDay);
     }
     dateList.reverse();
 $.each(dateList,function(idx,item){
  var ym = item.split("~");
   var mon = ym[0].split("-");
   if(mon[1]==(month+1) && mon[0] == year)
         $("#dateList").append("<option value="+myDate.getDate()+">"+"本月"+"</option>");
         else
         $("#dateList").append("<option value="+ym[1]+">"+ym[0]+"</option>");
         })
 
 
   getEndTime();
 
 
}
 
 
function maxDay(month,year){//获得某年某月最大天数
var d= new Date();
d.setUTCFullYear(year,month);
return new Date(d.getFullYear(), d.getMonth()+1,0).getDate();
}
 
 
function getEndTime(){ //动态生成 月初日期 和 月末日期
 var list = $("#dateList option:selected");
 var selMonth = $("#dateList option:selected").html()
 if( selMonth == "本月"){
  var d = new Date();
  $("#starTime").val(d.getUTCFullYear()+"-"+(d.getUTCMonth()+1)+"-1");
  $("#endTime").val(d.getUTCFullYear()+"-"+(d.getUTCMonth()+1)+"-"+list.val());
 }else{
 $("#starTime").val(selMonth+"-1");
 $("#endTime").val(selMonth+"-"+list.val());
 }
}
 
 
//年月选择end
 </script>
  <body>
<td nowrap="nowrap" style="width: 15%" align="center">
     日期：
     <select id="dateList" onchange="getEndTime()"> </select>
     从
     <input name="starTime" id="starTime"
      value="<s:date name="starTime" format="yyyy-MM-dd"/>"
      onFocus="WdatePicker()" class="Wdate"
      style="width: 110px; height: 17px; border-left: 0; border-top: 0; border-right: 0; border-bottom-color: #C06" />
     至
     <input name="endTime" id="endTime"
      value="<s:date name="endTime" format="yyyy-MM-dd"/>"
      onFocus="WdatePicker()" class="Wdate"
      style="width: 110px; height: 17px; border-left: 0; border-top: 0; border-right: 0; border-bottom-color: #C06" />
 
 
    </td>
  </body>
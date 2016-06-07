    <script type="text/javascript">   
    function check()
    {
        var checked = false;
        var radios = document.getElementsByName('type');
        for (var x=0; x<radios.length; x++) {
            checked = checked || radios[x].checked;
        }
        if (!checked) {
            alert("请选择导出方式");
            return false;
        }

        if(document.getElementById("start_day").value == "")
        {  
            alert("请选择开始日期!"); 
            return false;  
        }

        if(document.getElementById("end_day").value == "")
        {  
            alert("请选择结束日期!"); 
            return false;  
        }

        if(document.getElementById("itemid").value == "-1")
        {  
            alert("请选择导出项目!"); 
            return false;  
        }

        if(confirm( '提交之后无法修改，请确定是否提交？ ')==false)
          return   false;
        else
          return true;
            
    }
    </script> 

        <div class="span9">
          <h1 class="page-title">Zabbix报表导出</h1>
          <div class="well">
              <ul class="nav nav-tabs">
                  <li class="active"><a href="#home" data-toggle="tab">项目选择</a></li>
                  <li><a href="<?php echo site_url('')?>">返回首页</a></li>
              </ul>
              <div id="myTabContent" class="tab-content">
              <div class="tab-pane active in" id="home">
              <form id="tab" action="<?php echo base_url().'index.php/report/excel_out_action';?>" method="post" onSubmit="return check()">
                <label>现在时间：<?php echo date('Y-m-d H:i:s',time());?></label>
                <label>选择分组：<?php echo $group_name;?></label><input type="hidden" name="group_name" value="<?php echo $group_name;?>">
                <label>选择主机：<?php echo $host_name;?></label><input type="hidden" name="host_name" value="<?php echo $host_name;?>">
                <label>选择项目：</label>
                <?php echo $item_select;?>

                <hr />
                <label>导出起始日期选择</label>
                <input type="text" id="datepicker" name="start_day" value="<?php echo $start_day;?>" class="input-xlarge">
                <br>
                <label>导出结束日期选择</label>
                <input type="text" id="datepicker_end" name="end_day" value="<?php echo $end_day;?>" class="input-xlarge">
                <br>
                <label>导出方式</label>
                <label><input name="type" type="radio" value="hour" />按每小时<input name="type" type="radio" value="day" />按每天</label> 

                <label><input name="submit" type="submit" value="导出" class="btn btn-primary pull-letf"><label>
              </form>
              </div>
              </div>

          </div>


        </div>
    </div>
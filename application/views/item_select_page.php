    <script type="text/javascript">   
    function check()
    {
          var reg = new RegExp("^[0-9]*$");
          if(!/^[0-9]*$/.test(document.getElementById("real_number").value))
          {
              alert("请在实到人数框内输入数字!");
              return false;
          }
          else
          {
            if(document.getElementById("real_number").value == "")
            {  
                alert("请填写实到人数!"); 
                return false;  
            }
            else
            { 
                if(confirm( '提交之后无法修改，请确定是否提交？ ')==false)
                  return   false;
                else
                  return true;
            }  
          }
            
    }
    </script>        

        <div class="span9">
          <h1 class="page-title">Zabbix报表导出</h1>
          <div class="well">
              <ul class="nav nav-tabs">
                  <li class="active"><a href="#home" data-toggle="tab">信息录入</a></li>
                  <li><a href="<?php echo base_url('student/data_entry')?>">返回班级选择页面</a></li>
              </ul>
              <div id="myTabContent" class="tab-content">
              <div class="tab-pane active in" id="home">
              <form id="tab" action="<?php echo base_url('student/data_entry_action')?>" method="post" onSubmit="return check()">
                <label>现在时间：<?php echo date('Y-m-d H:i:s',time());?></label>
                <label>目前学年：<?php echo $school_year;?></label>
                <label>目前学期：<?php echo $term;?></label>
                <label>目前周数：<?php echo $week;?></label>

                <hr />
                <label>选择教室：<?php echo $classroom;?></label>
                <input type="hidden" name="classroom" value="<?php echo $classroom;?>">
                <label><input name="submit" type="submit" value="提交" class="btn btn-primary pull-letf"><label>
              </form>
              </div>
              </div>

          </div>


        </div>
    </div>
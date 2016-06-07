    <script type="text/javascript">   
    function check()
    {
        if(document.getElementById("groupid").value == "-1")
        {  
            alert("请选择分组!"); 
            return false;  
        }

        if(document.getElementById("hostid").value == "-1")
        {  
            alert("请选择主机!"); 
            return false;  
        }

        return true;
            
    }
    </script> 

        <div class="span9">
          <h1 class="page-title">Zabbix报表导出</h1>
          <div class="well">
              <ul class="nav nav-tabs">
                  <li class="active"><a href="#home" data-toggle="tab">机器选择</a></li>
              </ul>
              <div id="myTabContent" class="tab-content">
                <div class="tab-pane active in" id="home">

                  <form id="tab" action="<?php echo base_url().'index.php/report/item_select';?>" method="post" onSubmit="return check()">
                  <label>机器分组</label>
                  <select name="groupid" id="groupid" class="input-xlarge" onchange="group_change(this);">
                      <option value="-1">请选择分组</option>
                      <?php
                        foreach ($details as $key => $value)
                        {
                          echo '         <option value="'.$key.'">'.$value."</option>\n";
                        }
                      ?>
                  </select> 

                  <label>机器名称</label>
                  <span id="host_list">
                    <select name="hostid"  class="input-xlarge">
                      <option value="-1">请选择机器</option>
                    </select>
                  </span>

                  <br>
                  <button type="submit" name="" value="send" class="btn btn-primary">查询项目，并进行报表导出</button>

                  <script language="javascript">
                     function group_change(obj){ 
                     $.ajax({
                          type: "POST",
                          url: "<?php echo base_url().'index.php/ajax/group_get_host';?>",
                          data: {groupid:obj.value},
                          dataType:'html', 
                          success: function(msg){
                         $("#host_list").html(msg);
                          }
                        });
                      }
                  </script>
                </form>

                </div>
              </div>
          </div>


        </div>
    </div>
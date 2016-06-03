<div class="span9">
  <div class="faq-content">
    <h1 class="page-title">Zabbix报表导出</h1>
    <div class="row-fluid">
        <div class="span9">
                  
           <div class="block">
              <p class="block-heading">单台机器报表导出</p>
                <div class="block-body">
                  
                <form id="tab" action="<?php echo site_url('report/item_select')?>" method="post" onSubmit="return check()">
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
                          url: "<?php echo site_url('ajax/group_get_host');?>",
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
        
        <div class="span3">
          <div class="well toc">
          <h3>使用方式</h3>
          <h4>联系人：</h4>
           <p>王晶</p>
                <h4>联系电话：</h4>
                <p>18951810421</p>
                <h4>E-mail：</h4>
                <p>wjing@njupt.edu.cn</p>
                <h4>办公室地址：</h4>
                <address>
                学生事务服务中心大楼<br>
                三楼323室
                </address>
          </div>
        </div>

</div>
</div>

        </div>
    </div>
    <script type="text/javascript">   
    function check()
    {
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

        if(confirm( '提交之后无法修改，请确定是否提交？ ')==false)
          return   false;
        else
          return true;
    }
    </script> 

        <div class="span9">
          <h1 class="page-title">Zabbix总表导出</h1>
          <div class="well">
              <ul class="nav nav-tabs">
                  <li class="active"><a href="#home" data-toggle="tab">项目选择</a></li>
                  <li><a href="<?php echo site_url('')?>">返回首页</a></li>
              </ul>
              <div id="myTabContent" class="tab-content">
              <div class="tab-pane active in" id="home">
              <form id="tab" action="<?php echo base_url().'index.php/report/all_excel_out_action';?>" method="post" onSubmit="return check()">
                <label>现在时间：<?php echo date('Y-m-d H:i:s',time());?></label>
                <label>选择项目：</label>
                <select name="itemname" id="itemname" class="input-xlarge">
                   <option value="winCPU使用率">winCPU使用率</option>
                   <option value="CPU使用率">CPU使用率</option>
                   <option value="$1的传入网络流量">$1的传入网络流量</option>
                   <option value="$1的传出网络流量">$1的传出网络流量</option>
                   <option value="$1的剩余空间">$1的剩余空间</option>
                   <option value="$1的剩余空间 (%)">$1的剩余空间 (%)</option>
                   <option value="$1的总空间">$1的总空间</option>
                   <option value="$1的已使用空间">$1的已使用空间</option>
                   <option value="剩余内存空间">剩余内存空间</option>
                   <option value="已使用内存空间%">已使用内存空间%</option>
                   <option value="总内存空间">总内存空间</option>
                   <option value="ICMP ping">ICMP ping</option>
                   <option value="ICMP 丢失">ICMP 丢失</option>
                   <option value="ICMP 响应时间">ICMP 响应时间</option>
                   <option value="最大进程数">最大进程数</option>
                   <option value="平均磁盘读队列长度">平均磁盘读队列长度</option>
                   <option value="平均磁盘写队列长度">平均磁盘写队列长度</option>
                   <option value="线程数">线程数</option>
                   <option value="进程数">进程数</option>
                   <option value="剩余虚拟内存空间">剩余虚拟内存空间</option>
                   <option value="总虚拟内存空间">总虚拟内存空间</option>
                   <option value="文件读取 bytes/s">文件读取 bytes/s</option>
                   <option value="文件写入 bytes/s">文件写入 bytes/s</option>
                   <option value="剩余swap空间">剩余swap空间</option>
                   <option value=">剩余swap空间%">>剩余swap空间%</option>
                   <option value="已使用swap空间%">已使用swap空间%</option>
                   <option value="可用内存空间">可用内存空间</option>
                   <option value="Agent ping">Agent ping</option>
                   <option value="系统运行时间">系统运行时间</option>
                </select>

                <hr />
                <label>导出起始月份选择</label>
                <input type="text" id="datepicker" name="start_day" value="<?php echo $start_day;?>" class="input-xlarge">
                <br>
                <label>导出结束月份选择</label>
                <input type="text" id="datepicker_end" name="end_day" value="<?php echo $end_day;?>" class="input-xlarge">
                <label>（上面选好月份就可以，具体日期在计算时候会忽略）</label>

                <label><input name="submit" type="submit" value="导出" class="btn btn-primary pull-letf"><label>
              </form>
              </div>
              </div>

          </div>


        </div>
    </div>
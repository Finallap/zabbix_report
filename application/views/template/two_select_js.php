<script type="text/javascript">
    var list1 = new Array;
    var list2 = new Array;

    <?php
        foreach ($list1_array as $key => $value)
        {
            echo 'list1[list1.length] ="'.$value['list1_number'].'";'."\n";
        }

        foreach ($list2_array as $key => $list2_array_value)
        {
            echo 'list2[list2.length] = new Array(';
            $result = NULL;
           foreach ($list2_array_value as $key => $value) 
           {
               $result.='"'.$value['list2_name'].'",';
           }
           echo substr($result, 0, -1);
            echo ');'."\n";
            
        }
    ?>
    
    var ddlschool = document.getElementById("list1");
    var ddlmajor = document.getElementById("list2");
    for(var i =0;i<list1.length; i++)
    {
        var option = document.createElement("option");
        option.appendChild(document.createTextNode(list1[i]));
        option.value = list1[i];
        ddlschool.appendChild(option);
        //major initialize
        var firstschool = list2[0];
        for (var j = 0; j < firstschool.length; j++) {
            var optionmajor = document.createElement("option");
            optionmajor.appendChild(document.createTextNode(firstschool[j]));
            optionmajor.value = firstschool[j];
            ddlmajor.appendChild(optionmajor);
        }
    }
    function indexof(obj,value)
    {
        var k=0;
        for(;k<obj.length;k++)
        {
            if(obj[k] == value)
            return k;
        }
        return k;
    }
    function selectschool(obj) {
        ddlmajor.options.length = 0;//clear
        var index = indexof(list1,obj.value);
        var list2element = list2[index];
        for(var i =0;i<list2element.length; i++)
        {
            var option = document.createElement("option");
            option.appendChild(document.createTextNode(list2element[i]));
            option.value = list2element[i];
            ddlmajor.appendChild(option);
        }
    }
</script>

     <select name="<?php echo $name;?>" id="<?php echo $name;?>" class="input-xlarge">
		<?php
			echo '<option value="-1">'.$default_value."</option>\n";
		    foreach ($details as $key => $value)
		    {
			    echo '         <option value="'.$key.'">'.$value."</option>\n";
		    }
		?>
    </select>
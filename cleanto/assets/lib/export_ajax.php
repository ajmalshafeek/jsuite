<?php 

	include(dirname(dirname(dirname(__FILE__))).'/objects/class_connection.php');
	include(dirname(dirname(dirname(__FILE__))).'/objects/class_services_addon.php');
	include(dirname(dirname(dirname(__FILE__))).'/objects/class_services_methods.php');
	include(dirname(dirname(dirname(__FILE__))).'/objects/class_setting.php');
	include(dirname(dirname(dirname(__FILE__))).'/objects/class_general.php');
	
	$con = new cleanto_db();
	$conn = $con->connect();
	$serviceaddon = new cleanto_services_addon();
	$serviceaddon->conn = $conn;
	$servicemethod = new cleanto_services_methods();
	$servicemethod->conn = $conn;
$general=new cleanto_general();
$general->conn=$conn;
$setting = new cleanto_setting();
$setting->conn = $conn;
$symbol_position=$setting->get_option('ct_currency_symbol_position');
$decimal=$setting->get_option('ct_price_format_decimal_places');
	
	$lang = $setting->get_option("ct_language");
$label_language_values = array();
$language_label_arr = $setting->get_all_labelsbyid($lang);

if ($language_label_arr[1] != "" || $language_label_arr[3] != "" || $language_label_arr[4] != "" || $language_label_arr[5] != "")
{
	$default_language_arr = $setting->get_all_labelsbyid("en");
	if($language_label_arr[1] != ''){
		$label_decode_front = base64_decode($language_label_arr[1]);
	}else{
		$label_decode_front = base64_decode($default_language_arr[1]);
	}
	if($language_label_arr[3] != ''){
		$label_decode_admin = base64_decode($language_label_arr[3]);
	}else{
		$label_decode_admin = base64_decode($default_language_arr[3]);
	}
	if($language_label_arr[4] != ''){
		$label_decode_error = base64_decode($language_label_arr[4]);
	}else{
		$label_decode_error = base64_decode($default_language_arr[4]);
	}
	if($language_label_arr[5] != ''){
		$label_decode_extra = base64_decode($language_label_arr[5]);
	}else{
		$label_decode_extra = base64_decode($default_language_arr[5]);
	}
			
    $label_decode_front_unserial = unserialize($label_decode_front);
	$label_decode_admin_unserial = unserialize($label_decode_admin);
	$label_decode_error_unserial = unserialize($label_decode_error);
	$label_decode_extra_unserial = unserialize($label_decode_extra);
    
	$label_language_arr = array_merge($label_decode_front_unserial,$label_decode_admin_unserial,$label_decode_error_unserial,$label_decode_extra_unserial);
	foreach($label_language_arr as $key => $value){
		$label_language_values[$key] = urldecode($value);
	}
}
else
{
    $default_language_arr = $setting->get_all_labelsbyid("en");
	
	$label_decode_front = base64_decode($default_language_arr[1]);
	$label_decode_admin = base64_decode($default_language_arr[3]);
	$label_decode_error = base64_decode($default_language_arr[4]);
	$label_decode_extra = base64_decode($default_language_arr[5]);
	
	$label_decode_front_unserial = unserialize($label_decode_front);
	$label_decode_admin_unserial = unserialize($label_decode_admin);
	$label_decode_error_unserial = unserialize($label_decode_error);   
	$label_decode_extra_unserial = unserialize($label_decode_extra);   
	
	$label_language_arr = array_merge($label_decode_front_unserial,$label_decode_admin_unserial,$label_decode_error_unserial,$label_decode_extra_unserial);
	foreach($label_language_arr as $key => $value){
		$label_language_values[$key] = urldecode($value);
	}
}
	
	
	/* Below Code is use for display details of service addons*/
	if(isset($_POST['action']) && $_POST['action']=='display_ser_addons'){
		$serviceaddon->service_id=$_POST['id'];
		$display_ser_addon = $serviceaddon->getdataby_serviceid();
        $cnt = 1;
		while($row=mysqli_fetch_array($display_ser_addon)){
		?>
		<tr>
            <td><?php echo $cnt;?></td>
			<td><?php echo $row['addon_service_name'];?></td>											
			<td><?php echo $general->ct_price_format($row['base_price'],$symbol_position,$decimal); ?></td>
			<td><?php echo $row['maxqty'];?></td>	
		</tr>
		<?php 
		$cnt++;}
	}
	
	/* Below Code is use for display details of service method*/
	if(isset($_POST['action']) && $_POST['action']=='display_ser_method'){
		$servicemethod->service_id=$_POST['id'];
		$display_ser_method = $servicemethod->readall();
        $cnt = 1;
		while($row1=mysqli_fetch_array($display_ser_method)){
			if($row1['status']=='E'){
				$method_status=$label_language_values['enable'];
			}else{
				$method_status=$label_language_values['disable'];
			}
		?>
		<tr>
            <td><?php echo $cnt;?></td>
			<td><?php echo $row1['method_title'];?></td>											
			<td><?php echo $method_status;?></td>	
		</tr>
		<?php 
		$cnt++;}
	}
	
	/* Below Code is use for display details of Booking service addons*/
	if(isset($_POST['action']) && $_POST['action']=='display_booking_addons'){
        $order_id=$_POST['id'];
		$display_booking_addons = $serviceaddon->display_booking_addons($order_id);
        $cnt = 1;
		while($row2=mysqli_fetch_array($display_booking_addons)){
            $serviceaddon->id=$row2['addons_service_id'];
			$service_addonce_title=$serviceaddon->readone_export();
            if($row2['addons_service_qty']==0){
              break;
            }
		?>
		<tr>
			<td><?php echo $cnt;?></td>
			<td><?php echo $service_addonce_title[2]; ?></td>
			<td><?php echo $general->ct_price_format($row2['addons_service_rate'],$symbol_position,$decimal); ?></td>
            <td><?php echo $row2['addons_service_qty']; ?></td>
        </tr>
		<?php 
            $cnt++;
		}
	}
	
	/* Below Code is use for display details of service method*/
	if(isset($_POST['action']) && $_POST['action']=='display_booking_method'){
        $order_id=$_POST['id'];
        $display_booking_addons = $serviceaddon->display_booking_addons($order_id);
		$display_ser_method = $servicemethod->display_booking_method($order_id);
        $cnt = 1;
		while($row1=mysqli_fetch_array($display_ser_method)){
			$servicemethod->id=$row1['method_id'];
			$display_method_name=$servicemethod->display_name_method();
			
			$servicemethod->id=$row1['method_unit_id'];
			$display_unit_method=$servicemethod->display_method_unit();
            if($row1['method_unit_qty']==0){
                break;
            }
		?>
		<tr>
			<td><?php echo $cnt;?></td>
            <td><?php echo $display_method_name[2];?></td>
			<td><?php echo $display_unit_method[3];?></td>
			<td><?php echo $row1['method_unit_qty'];?></td>
			<td><?php echo $general->ct_price_format($row1['method_unit_qty_rate'],$symbol_position,$decimal); ?></td>
		</tr>
		<?php 
		$cnt++;}
	}
?>
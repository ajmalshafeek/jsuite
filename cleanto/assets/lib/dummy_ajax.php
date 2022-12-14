<?php 

$config=parse_ini_file(__DIR__."/../../../jsheetconfig.ini");
if(!isset($_SESSION)) 
{ 
    session_name($config['sessionName']);
    session_start(); 
} 
	include(dirname(dirname(dirname(__FILE__)))."/header.php");
	include(dirname(dirname(dirname(__FILE__))).'/objects/class_connection.php');
	include(dirname(dirname(dirname(__FILE__))).'/objects/class_dummy.php');
	include(dirname(dirname(dirname(__FILE__))).'/objects/class_setting.php');
	if ( is_file(dirname(dirname(dirname(__FILE__))).'/extension/GoogleCalendar/google-api-php-client/src/Google_Client.php')){
		require_once dirname(dirname(dirname(__FILE__))).'/extension/GoogleCalendar/google-api-php-client/src/Google_Client.php';
	}
	include(dirname(dirname(dirname(__FILE__)))."/objects/class_gc_hook.php");
	
	$database= new cleanto_db();
	$conn=$database->connect();
	$database->conn=$conn;
	
	$dummy=new cleanto_dummy();
	$dummy->conn=$conn;
	
	$gc_hook = new cleanto_gcHook();
	$gc_hook->conn = $conn;
	
	$setting=new cleanto_setting();
	$setting->conn=$conn;
	
	$s1=new cleanto_dummy();
	$s1->conn=$conn;
	$s2=new cleanto_dummy();
	$s2->conn=$conn;
	$s3=new cleanto_dummy();
	$s3->conn=$conn;
	
if(isset($_POST['add_sample_data'])){
/*===================================== add first services ========================================*/


		$sample_data_status = $setting->get_option('ct_sample_data_status');



			if($sample_data_status!="Y"){
		$s1->s_title = 'House Cleaning';
		$s1->s_description = 'House cleaners work in residential settings where they are expected to keep houses clean and well-organized.';
		$s1->s_color = '#00a87e';
		$s1->s_image = '';
		$s1->s_status = 'E';
		$s1->s_position = '0';
		$add_service1 = $s1->add_service();
		if($add_service1){
			/* add service method */
			$s1->sm_service_id = $add_service1;
			$s1->sm_method_title = 'Property Based';
			$s1->sm_status = 'E';
			$add_services_method1 = $s1->add_services_method();
			if($add_services_method1){
			/*add units design */
				$s1->smd_service_methods_id = $add_services_method1;
				$s1->smd_design = '2';
				$add_service_methods_design1 = $s1->add_service_methods_design();
			/*add first unit */
				$s1->smu_service_id = $add_service1;
				$s1->smu_methods_id = $add_services_method1;
				$s1->smu_units_title = 'Bedroom Cleaning';
				$s1->smu_base_price = '10';
				$s1->smu_maxlimit = '10';
				$s1->smu_status = 'E';
				$add_services_method_unit1 = $s1->add_services_method_unit();
				if($add_services_method_unit1){
					$s1->smur_units_id = $add_services_method_unit1;
					$s1->smur_units = '5';
					$s1->smur_rules = 'G';
					$s1->smur_rates = '8';
					$add_services_methods_units_rate1 = $s1->add_services_methods_units_rate();
				}
			/*add second unit */
				$s1->smu_service_id = $add_service1;
				$s1->smu_methods_id = $add_services_method1;
				$s1->smu_units_title = 'Bathroom Cleaning';
				$s1->smu_base_price = '12';
				$s1->smu_maxlimit = '8';
				$s1->smu_status = 'E';
				$add_services_method_unit2 = $s1->add_services_method_unit();
				if($add_services_method_unit2){
					$s1->smur_units_id = $add_services_method_unit2;
					$s1->smur_units = '6';
					$s1->smur_rules = 'E';
					$s1->smur_rates = '10';
					$add_services_methods_units_rate2 = $s1->add_services_methods_units_rate();
				}
			}
			/* add first service addons */
			$s1->sa_service_id = $add_service1;
			$s1->sa_addon_service_name = 'Fridge Cleaning';
			$s1->sa_base_price = '5';
			$s1->sa_maxqty = '5';
			$s1->sa_image = '';
			$s1->sa_multipleqty = 'Y';
			$s1->sa_status = 'E';
			$s1->sa_predefine_image = 'ct-icon-fridge.png';
			$add_services_addon1 = $s1->add_services_addon();
			if($add_services_addon1){
				$s1->asr_addon_service_id = $add_services_addon1;
				$s1->asr_unit = '2';
				$s1->asr_rules = 'G';
				$s1->asr_rate = '4';
				$add_addon_service_rate1 = $s1->add_addon_service_rate();
			}
			/* add second service addons */
			$s1->sa_service_id = $add_service1;
			$s1->sa_addon_service_name = 'Oven Cleaning';
			$s1->sa_base_price = '5';
			$s1->sa_maxqty = '5';
			$s1->sa_image = '';
			$s1->sa_multipleqty = 'N';
			$s1->sa_status = 'E';
			$s1->sa_predefine_image = 'ct-icon-oven.png';
			$add_services_addon2 = $s1->add_services_addon();
			if($add_services_addon2){
				$s1->asr_addon_service_id = $add_services_addon2;
				$s1->asr_unit = '3';
				$s1->asr_rules = 'G';
				$s1->asr_rate = '3';
				$add_addon_service_rate1 = $s1->add_addon_service_rate();
			}
			/* add third service addons */
			$s1->sa_service_id = $add_service1;
			$s1->sa_addon_service_name = 'Inside Window Cleaning';
			$s1->sa_base_price = '5';
			$s1->sa_maxqty = '10';
			$s1->sa_image = '';
			$s1->sa_multipleqty = 'N';
			$s1->sa_status = 'E';
			$s1->sa_predefine_image = 'ct-icon-inside-window.png';
			$add_services_addon3 = $s1->add_services_addon();		
		}
		
/*====================================== add second services =========================================*/
		$s1->s_title = 'Plumbing Services';
		$s1->s_description = 'We are ready to provide plumbing services you can trust!';
		$s1->s_color = '#006999';
		$s1->s_image = '';
		$s1->s_status = 'E';
		$s1->s_position = '1';
		$add_service2 = $s1->add_service();
		if($add_service2){
			/* add first service method */
			$s1->sm_service_id = $add_service2;
			$s1->sm_method_title = 'Residential Services';
			$s1->sm_status = 'E';
			$add_services_method1 = $s1->add_services_method();
			if($add_services_method1){
			/*add units design */
				$s1->smd_service_methods_id = $add_services_method1;
				$s1->smd_design = '3';
				$add_service_methods_design = $s1->add_service_methods_design();
			/*add first unit */
				$s1->smu_service_id = $add_service2;
				$s1->smu_methods_id = $add_services_method1;
				$s1->smu_units_title = 'Water Line Repairs';
				$s1->smu_base_price = '5';
				$s1->smu_maxlimit = '2';
				$s1->smu_status = 'E';
				$add_services_method_unit1 = $s1->add_services_method_unit();
				if($add_services_method_unit1){
					/* rate 1 */
                    $s1->smur_units_id = $add_services_method_unit1;
                    $s1->smur_units = '3';
                    $s1->smur_rules = 'G';
                    $s1->smur_rates = '4';
                    $add_services_methods_units_rate1 = $s1->add_services_methods_units_rate();
                    /* rate 2 */
                    $s1->smur_units_id = $add_services_method_unit1;
                    $s1->smur_units = '6';
                    $s1->smur_rules = 'G';
                    $s1->smur_rates = '2.8';
                    $add_services_methods_units_rate2 = $s1->add_services_methods_units_rate();
                    /* rate 3 */
                    $s1->smur_units_id = $add_services_method_unit1;
                    $s1->smur_units = '8';
                    $s1->smur_rules = 'G';
                    $s1->smur_rates = '1.8';
                    $add_services_methods_units_rate2 = $s1->add_services_methods_units_rate();
                    /* rate 4 */
                    $s1->smur_units_id = $add_services_method_unit1;
                    $s1->smur_units = '10';
                    $s1->smur_rules = 'E';
                    $s1->smur_rates = '1.5';
                    $add_services_methods_units_rate2 = $s1->add_services_methods_units_rate();
				}
			/*add second unit */
				$s1->smu_service_id = $add_service2;
				$s1->smu_methods_id = $add_services_method1;
				$s1->smu_units_title = 'Frozen/Leaking Pipes';
				$s1->smu_base_price = '10';
				$s1->smu_maxlimit = '4';
				$s1->smu_status = 'E';
				$add_services_method_unit2 = $s1->add_services_method_unit();
				if($add_services_method_unit2){
					$s1->smur_units_id = $add_services_method_unit2;
					$s1->smur_units = '4';
					$s1->smur_rules = 'E';
					$s1->smur_rates = '8';
					$add_services_methods_units_rate = $s1->add_services_methods_units_rate();
				}
			}
			/* add second service method */
			$s1->sm_service_id = $add_service2;
			$s1->sm_method_title = 'Commercial Services';
			$s1->sm_status = 'E';
			$add_services_method2 = $s1->add_services_method();
			if($add_services_method2){
			/*add units design */
				$s1->smd_service_methods_id = $add_services_method2;
				$s1->smd_design = '3';
				$add_service_methods_design = $s1->add_service_methods_design();
			/*add first unit */
				$s1->smu_service_id = $add_service2;
				$s1->smu_methods_id = $add_services_method2;
				$s1->smu_units_title = 'Clogged Drains';
				$s1->smu_base_price = '4';
				$s1->smu_maxlimit = '4';
				$s1->smu_status = 'E';
				$add_services_method_unit1 = $s1->add_services_method_unit();
				if($add_services_method_unit1){
					$s1->smur_units_id = $add_services_method_unit1;
					$s1->smur_units = '2';
					$s1->smur_rules = 'E';
					$s1->smur_rates = '4';
					$add_services_methods_units_rate2 = $s1->add_services_methods_units_rate();
				}
			/*add second unit */
				$s1->smu_service_id = $add_service2;
				$s1->smu_methods_id = $add_services_method2;
				$s1->smu_units_title = 'Water Heater Repairs';
				$s1->smu_base_price = '10';
				$s1->smu_maxlimit = '3';
				$s1->smu_status = 'E';
				$add_services_method_unit2 = $s1->add_services_method_unit();
				if($add_services_method_unit2){
					$s1->smur_units_id = $add_services_method_unit2;
					$s1->smur_units = '3';
					$s1->smur_rules = 'E';
					$s1->smur_rates = '7';
					$add_services_methods_units_rate2 = $s1->add_services_methods_units_rate();
				}
			}
	}
		
/*============================================ add third services =========================================*/
		$s1->s_title = 'Carpenter Services';
		$s1->s_description = 'We are ready to provide plumbing services you can trust!';
		$s1->s_color = '#996600';
		$s1->s_image = '';
		$s1->s_status = 'E';
		$s1->s_position = '2';
		$add_service3 = $s1->add_service();
		if($add_service3){
			/* add first service method */
			$s1->sm_service_id = $add_service3;
			$s1->sm_method_title = 'Property Based';
			$s1->sm_status = 'E';
			$add_services_method1 = $s1->add_services_method();
			if($add_services_method1){
			/*add units design */
				$s1->smd_service_methods_id = $add_services_method1;
				$s1->smd_design = '4';
				$add_service_methods_design = $s1->add_service_methods_design();
			/*add first unit */
				$s1->smu_service_id = $add_service3;
				$s1->smu_methods_id = $add_services_method1;
				$s1->smu_units_title = 'Build walls';
				$s1->smu_base_price = '5';
				$s1->smu_maxlimit = '5';
				$s1->smu_status = 'E';
				$add_services_method_unit1 = $s1->add_services_method_unit();
				if($add_services_method_unit1){
					$s1->smur_units_id = $add_services_method_unit1;
					$s1->smur_units = '5';
					$s1->smur_rules = 'E';
					$s1->smur_rates = '4';
					$add_services_methods_units_rate = $s1->add_services_methods_units_rate();
				}
			/*add second unit */
				$s1->smu_service_id = $add_service3;
				$s1->smu_methods_id = $add_services_method1;
				$s1->smu_units_title = 'Build doorways';
				$s1->smu_base_price = '4';
				$s1->smu_maxlimit = '5';
				$s1->smu_status = 'E';
				$add_services_method_unit2 = $s1->add_services_method_unit();
			
			/*add third unit */
				$s1->smu_service_id = $add_service3;
				$s1->smu_methods_id = $add_services_method1;
				$s1->smu_units_title = 'Build windows';
				$s1->smu_base_price = '3';
				$s1->smu_maxlimit = '5';
				$s1->smu_status = 'E';
				$add_services_method_unit3 = $s1->add_services_method_unit();
				if($add_services_method_unit3){
					$s1->smur_units_id = $add_services_method_unit3;
					$s1->smur_units = '3';
					$s1->smur_rules = 'G';
					$s1->smur_rates = '1.5';
					$add_services_methods_units_rate = $s1->add_services_methods_units_rate();
				}
			}
			/* add second service method */
			$s1->sm_service_id = $add_service3;
			$s1->sm_method_title = 'Area Based (Fit)';
			$s1->sm_status = 'E';
			$add_services_method2 = $s1->add_services_method();
			if($add_services_method2){
			/*add units design */
				$s1->smd_service_methods_id = $add_services_method2;
				$s1->smd_design = '5';
				$add_service_methods_design = $s1->add_service_methods_design();
			/*add first unit */
				$s1->smu_service_id = $add_service3;
				$s1->smu_methods_id = $add_services_method2;
				$s1->smu_units_title = 'Remodeling or enhancing existing structures ';
				$s1->smu_base_price = '2';
				$s1->smu_maxlimit = '1000';
				$s1->smu_status = 'E';
				$add_services_method_unit1 = $s1->add_services_method_unit();
				if($add_services_method_unit1){
					/* rule 1*/
					$s1->smur_units_id = $add_services_method_unit1;
					$s1->smur_units = '100';
					$s1->smur_rules = 'G';
					$s1->smur_rates = '1.8';
					$add_services_methods_units_rate1 = $s1->add_services_methods_units_rate();
					/* rule 2 */
					$s1->smur_units_id = $add_services_method_unit1;
					$s1->smur_units = '500';
					$s1->smur_rules = 'G';
					$s1->smur_rates = '1.6';
					$add_services_methods_units_rate2 = $s1->add_services_methods_units_rate();
					/* rule 3 */
					$s1->smur_units_id = $add_services_method_unit1;
					$s1->smur_units = '800';
					$s1->smur_rules = 'G';
					$s1->smur_rates = '1.2';
					$add_services_methods_units_rate3 = $s1->add_services_methods_units_rate();
				}
			}
			
			/* add first service addons */
			$s1->sa_service_id = $add_service3;
			$s1->sa_addon_service_name = 'Damaged flooring';
			$s1->sa_base_price = '10';
			$s1->sa_maxqty = '5';
			$s1->sa_image = '';
			$s1->sa_multipleqty = 'N';
			$s1->sa_status = 'E';
			$s1->sa_predefine_image = 'ct-damaged-flooring.png';
			$add_services_addon1 = $s1->add_services_addon();
			
			/* add second service addons */
			$s1->sa_service_id = $add_service3;
			$s1->sa_addon_service_name = 'Door jams';
			$s1->sa_base_price = '10';
			$s1->sa_maxqty = '3';
			$s1->sa_image = '';
			$s1->sa_multipleqty = 'N';
			$s1->sa_status = 'E';
			$s1->sa_predefine_image = 'ct-door-jam.png';
			$add_services_addon2 = $s1->add_services_addon();
		}
/*============================================ add fourth services =========================================*/
		$s1->s_title = 'Office Cleaning';
		$s1->s_description = 'Office/Commercial Cleaners clean offices, industrial work areas, and other premises using heavy duty cleaning equipment.';
		$s1->s_color = '#800080';
		$s1->s_image = '';
		$s1->s_status = 'E';
		$s1->s_position = '3';
		$add_service4 = $s1->add_service();
		if($add_service4){
			/* add first service method */
			$s1->sm_service_id = $add_service4;
			$s1->sm_method_title = 'Property Based';
			$s1->sm_status = 'E';
			$add_services_method1 = $s1->add_services_method();
			if($add_services_method1){
			/*add units design */
				$s1->smd_service_methods_id = $add_services_method1;
				$s1->smd_design = '4';
				$add_service_methods_design = $s1->add_service_methods_design();
			/*add first unit */
				$s1->smu_service_id = $add_service4;
				$s1->smu_methods_id = $add_services_method1;
				$s1->smu_units_title = 'Swiping With Desk Cleaning';
				$s1->smu_base_price = '5';
				$s1->smu_maxlimit = '5';
				$s1->smu_status = 'E';
				$add_services_method_unit1 = $s1->add_services_method_unit();
				if($add_services_method_unit1){
					$s1->smur_units_id = $add_services_method_unit1;
					$s1->smur_units = '5';
					$s1->smur_rules = 'E';
					$s1->smur_rates = '4';
					$add_services_methods_units_rate = $s1->add_services_methods_units_rate();
				}
			/*add second unit */
				$s1->smu_service_id = $add_service4;
				$s1->smu_methods_id = $add_services_method1;
				$s1->smu_units_title = 'Doors And Window Cleaning';
				$s1->smu_base_price = '4';
				$s1->smu_maxlimit = '5';
				$s1->smu_status = 'E';
				$add_services_method_unit2 = $s1->add_services_method_unit();
			}
			/* add second service method */
			$s1->sm_service_id = $add_service4;
			$s1->sm_method_title = 'Area Based (Fit)';
			$s1->sm_status = 'E';
			$add_services_method2 = $s1->add_services_method();
			if($add_services_method2){
			/*add units design */
				$s1->smd_service_methods_id = $add_services_method2;
				$s1->smd_design = '5';
				$add_service_methods_design = $s1->add_service_methods_design();
			/*add first unit */
				$s1->smu_service_id = $add_service4;
				$s1->smu_methods_id = $add_services_method2;
				$s1->smu_units_title = 'Floor Cleaning';
				$s1->smu_base_price = '2';
				$s1->smu_maxlimit = '1000';
				$s1->smu_status = 'E';
				$add_services_method_unit1 = $s1->add_services_method_unit();
			}
			
			/* add first service addons */
			$s1->sa_service_id = $add_service4;
			$s1->sa_addon_service_name = 'Parking Cleaning';
			$s1->sa_base_price = '20';
			$s1->sa_maxqty = '3';
			$s1->sa_image = '';
			$s1->sa_multipleqty = 'N';
			$s1->sa_status = 'E';
			$s1->sa_predefine_image = 'ct-parking-cleaning.png';
			$add_services_addon1 = $s1->add_services_addon();
			
			/* add second service addons */
			$s1->sa_service_id = $add_service4;
			$s1->sa_addon_service_name = 'Storeroom Cleaning';
			$s1->sa_base_price = '10';
			$s1->sa_maxqty = '5';
			$s1->sa_image = '';
			$s1->sa_multipleqty = 'Y';
			$s1->sa_status = 'E';
			$s1->sa_predefine_image = 'ct-icon-basement.png';
			$add_services_addon2 = $s1->add_services_addon();	
		}
		
/************************** Add Off Day *****************************/
		$dummy->od_lastmodify = date('Y-m-d H:i:s');
		$dummy->od_off_date = date('Y-m-d', strtotime(' +5 day'));
		$add_off_days = $dummy->add_off_days();
		
		/*============ Add bookings ============*/
		$dummy->u_user_pwd=md5('12345678');
		$dummy->u_first_name=ucwords('John');
		$dummy->u_last_name=ucwords('Doe');
		$dummy->u_user_email='johndoe@example.com';
		$dummy->u_phone='+100000000000';
		$dummy->u_address='Perrine, FL';
		$dummy->u_zip='85001';
		$dummy->u_city=ucwords('Perrine');
		$dummy->u_state=ucwords('FL');
		$dummy->u_notes='Happy Booking';
		$dummy->u_vc_status='Y';
		$dummy->u_p_status='Y';
		$dummy->u_status='E';
		$dummy->u_usertype=serialize(array('client'));
		$dummy->u_contact_status='Please call me';
		$add_user=$dummy->add_users();
		
		if($add_user){
			/* insert into bookings table */
			$dummy->b_order_id='999';
			$dummy->b_client_id=$add_user;
			$dummy->b_order_date=date('Y-m-d H:i:s');
			$dummy->b_booking_date_time=date('Y-m-d', strtotime(' +3 day'))." 13:00:00";
			$dummy->b_service_id=$add_service1;
			$dummy->b_method_id=$add_services_method1;
			$dummy->b_method_unit_id=$add_services_method_unit1;
			$dummy->b_method_unit_qty=3;
			$dummy->b_method_unit_qty_rate=30;
			$dummy->b_booking_status='A';
			$dummy->b_lastmodify=date('Y-m-d H:i:s');
			$dummy->b_read_status='U';
			$add_bookings=$dummy->add_bookings();
			
			/* insert into addon bookings table */
			$dummy->ba_order_id = '999';
			$dummy->ba_service_id = $add_service1;
			$dummy->ba_addons_service_id = $add_services_addon1;
			$dummy->ba_addons_service_qty = 2;
			$dummy->ba_addons_service_rate = 220;
			$add_booking = $dummy->add_booking_addons();
			
			/* insert into payments table */
			$dummy->p_order_id = '999';
			$dummy->p_payment_method=ucwords('pay at venue');
			$dummy->p_transaction_id= '';
			$dummy->p_amount= 250;
			$dummy->p_discount= 0;
			$dummy->p_taxes= 0;
			$dummy->p_partial_amount= 0;
			$dummy->p_payment_date=date("Y-m-d H:i:s");
			$dummy->p_lastmodify=date("Y-m-d H:i:s");
			$dummy->p_net_amount= 250;
			$dummy->p_frequently_discount = 'O';
			$dummy->p_frequently_discount_amount = 0;
			$add_payment=$dummy->add_payments();
		
			$dummy->oci_order_id = '999';
			$dummy->oci_client_name=ucwords('John').' '.ucwords('Doe');
			$dummy->oci_client_email='johndoe@example.com';
			$dummy->oci_client_phone='+100000000000';
			$dummy->oci_client_personal_info=base64_encode(serialize(array('zip'=>'85001','address'=>'Perrine, FL','city'=>'Perrine','state'=>'FL','notes'=>'Happy Booking','vc_status'=>'Y','p_status'=>'Y','contact_status'=>'Please call me')));
			$add_new_user=$dummy->add_order_client_info();
		}
		
		/*============== Add Frequently discount ==============*/
		$dummy->fd_d_type = 'P';
		$dummy->fd_rates = '0';
		$dummy->fd_label = 'ZERO';
		$dummy->fd_id = '1';
		$update_frequently_discount1 = $dummy->update_frequently_discount();
		
		$dummy->fd_d_type = 'P';
		$dummy->fd_rates = '15';
		$dummy->fd_label = 'Save 15%';
		$dummy->fd_id = '2';
		$update_frequently_discount2 = $dummy->update_frequently_discount();
		
		$dummy->fd_d_type = 'P';
		$dummy->fd_rates = '12.5';
		$dummy->fd_label = 'Save 12.5%';
		$dummy->fd_id = '3';
		$update_frequently_discount3 = $dummy->update_frequently_discount();
		
		$dummy->fd_d_type = 'P';
		$dummy->fd_rates = '10';
		$dummy->fd_label = 'Save 10%';
		$dummy->fd_id = '4';
		$update_frequently_discount4 = $dummy->update_frequently_discount();
		
		$dummy_array = array($add_service1,$add_service2,$add_service3,$add_service4,$add_off_days,$add_user,$add_bookings,$add_booking,$add_payment,$add_new_user);
		
		$string_array=implode(',',$dummy_array);
		$dummy->ct_remove_data_array = $string_array;
		$dummy->add_settings();
		
			}
}
else if(isset($_POST['remove_sample_data'])){
	if($gc_hook->gc_purchase_status() == 'exist'){
		echo $gc_hook->gc_remove_sampledata_booking_hook();
	}
	$dummy->delete_all();
}
?>
<?php  class cleanto_services_methods_units{				public $id;		public $units_id;		public $services_id;		public $methods_id;		public $units_title;		public $base_price;		public $position;        public $maxlimit;        public $maxlimit_title;        public $status;		public $table_name="ct_service_methods_units";		public $tablename="ct_services_methods_units_rate";		public $conn;		/*Function for Add service*/		public function add_services_method_unit(){			$query="insert into `".$this->table_name."` (`id`,`services_id`,`methods_id`,`units_title`,`base_price`,`maxlimit`,`status`,`position`,`limit_title`,`half_section`) values(NULL,'".$this->services_id."','".$this->methods_id."','".$this->units_title."','".$this->base_price."','".$this->maxlimit."','".$this->status."','0','','D')";			$result=mysqli_query($this->conn,$query);			$value=mysqli_insert_id($this->conn);		    return $value;		}		/*Function for Update service-Not Used in this*/		public function update_services_method_unit(){			$query="update `".$this->table_name."` set  `units_title`='".$this->units_title."',`base_price`='".$this->base_price."',`maxlimit`='".$this->maxlimit."',`limit_title`='".$this->maxlimit_title."' where `id`=".$this->id;			$result=mysqli_query($this->conn,$query);			return $result;        }		/*Function for Delete service*/		public function delete_services_method_unit(){			$query="delete from `".$this->table_name."` where `id`='".$this->id."' ";			$result=mysqli_query($this->conn,$query);			return $result;		}        /*Function to update the status of  services */        public function  changestatus()        {            $query="update `".$this->table_name."` set `status`='".$this->status."' where `id`='".$this->id."' ";            $result=mysqli_query($this->conn,$query);            return $result;        }		public function changesinfotatus()        {            $query="update `".$this->table_name."` set `half_section`='".$this->status."' where `id`='".$this->id."' ";            $result=mysqli_query($this->conn,$query);            return $result;        }        /* Admin panel methods */        /*Function for Read All data from table by service and method id */        public function getunits_by_service_methods(){            $query="select * from `".$this->table_name."` where `services_id`='".$this->services_id."' and `methods_id` = '".$this->methods_id."'";            $result=mysqli_query($this->conn,$query);            return $result;        }        /* FUNRCTION FOR SET FRONT DESIGN */        public function getunits_by_service_methods_setdesign(){            $query="select * from `".$this->table_name."` where `services_id`='".$this->services_id."' and `methods_id` = '".$this->methods_id."' and `status` = 'E'";            $result=mysqli_query($this->conn,$query);            return $result;        }        /* function to get the design assigned to methods */        public function get_setting_design_methods($id)        {            $query="select `design` from `ct_service_methods_design` where `service_methods_id` = $id";            $result=mysqli_query($this->conn,$query);            $value=mysqli_fetch_row($result);            return $value[0];        }        /* set default design for methods */        public function set_default_design($id,$defaultdesign){            $query="insert into `ct_service_methods_design` (`id`,`service_methods_id`,`design`) values(NULL,".$id.",'".$defaultdesign."')";            $result=mysqli_query($this->conn,$query);            $value=mysqli_insert_id($this->conn);            return $value;        }        /* end  */        public function get_maxlimit_by_service_methods_ids(){        $query="select * from `".$this->table_name."` where `maxlimit` >0 and `services_id`=".$this->services_id." and `methods_id` = ".$this->methods_id." and `status` = 'E'";        $result=mysqli_query($this->conn,$query);        $value = mysqli_fetch_array($result);        return $value;    }        public function get_rate_by_service_methods_ids(){        $query="select * from `".$this->tablename."` where `units_id`=".$this->units_id." and `units` = ".$this->maxlimit." LIMIT 1";        $result=mysqli_query($this->conn,$query);        $value = mysqli_fetch_array($result);        return $value;    }        public function getunits_by_service_methods_front(){        $query="select * from `".$this->table_name."` where `status`='E' and `maxlimit` >0 and `services_id`=".$this->services_id." and `methods_id` = ".$this->methods_id." ORDER BY `position`";        $result=mysqli_query($this->conn,$query);        return $result;    }        public function get_maxlimit_by_service_methods_ids_baseratess(){        $query="select * from `".$this->table_name."` where `maxlimit` >0 and `id`=".$this->id." and `services_id`=".$this->services_id." and `methods_id` = ".$this->methods_id." and `status` = 'E'";        $result=mysqli_query($this->conn,$query);        $value = mysqli_fetch_array($result);        return $value;    }    /* Check for the bookings of the services */    public function method_unit_isin_use($id)    {        $query = "select * from `ct_bookings` where `ct_bookings`.`method_unit_id` = $id and `ct_bookings`.`booking_date_time` >= CURDATE() LIMIT 1";        $result=mysqli_query($this->conn,$query);        $value=mysqli_fetch_row($result);        return $value[0];    }    /* check for the entry of the same title */    public function check_same_title(){        $query = "select * from `".$this->table_name."` where `methods_id`= '".$this->methods_id."' and  `units_title`='".ucwords($this->units_title)."'";        $result=mysqli_query($this->conn,$query);        return $result;    }		public function readone(){		$query="select * from `ct_service_methods_units` where `id`='".$this->units_id."'";		$result=mysqli_query($this->conn,$query);		$value=mysqli_fetch_row($result);		return $value;	}			/*  function to update the position of the services_units*/	public function updateposition(){		$query="update `".$this->table_name."` set `position`='".$this->position."' where `id`='".$this->id."' ";		$result=mysqli_query($this->conn,$query);		return $result;	}}?>
<?php
require_once('../config.php');
Class Master extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings; 
		$this->permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		parent::__construct();
	}
	
	public function __destruct(){
		parent::__destruct();
	}

	function capture_err(){
		if(!$this->conn->error)
			return false;
		else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			return json_encode($resp);
			exit;
		}
	}


	//Save department
	function save_department(){
		extract($_POST);



		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				$v = addslashes($v);
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
				DBConnection::debugtaglog($k,$v);
			}
		}

		

		$check = $this->conn->query("SELECT * FROM `department` where `Name` = '{$name}' ".(!empty($id) ? " and DepartmentID != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = " Department already exist.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `department` set {$data} ";
			$save = $this->conn->query($sql);
		}else{
			$sql = "UPDATE `department` set {$data} where DepartmentID = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if($save){
			$resp['status'] = 'success';
			if(empty($id))
				$this->settings->set_flashdata('success',"New Department successfully saved.");
			else
				$this->settings->set_flashdata('success',"Department successfully updated.");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}


	function delete_department(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `department_ist` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Department successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}


	//designation management
	function save_designation(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				$v = addslashes($v);
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `designation` where `Name` = '{$name}' ".(!empty($id) ? " and DesignationID != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = " Designation already exist.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `designation` set {$data} ";
			$save = $this->conn->query($sql);
		}else{
			$sql = "UPDATE `designation` set {$data} where DesignationID = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if($save){
			$resp['status'] = 'success';
			if(empty($id))
				$this->settings->set_flashdata('success',"New Designation successfully saved.");
			else
				$this->settings->set_flashdata('success',"Designation successfully updated.");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}


	function delete_designation(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `designation_ist` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Designation successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}

    //Leave type
	function save_leave_type(){
		extract($_POST);

		

		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				$v = addslashes($v);
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
				
			}
			
		}

		$DefaultCredit = $_POST['DefaultCredit'];

		DBConnection::debuglog($data);

		$check = $this->conn->query("SELECT * FROM `Leavetype` where `Description` = '{$Description}' ".(!empty($id) ? " and LeaveID != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = " Leave Type already exist.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `Leavetype` set {$data} ";
			$save = $this->conn->query($sql);
		}else{
			$sql = "UPDATE `Leavetype` set {$data} where LeaveID = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if($save){

			//Update Leave DefaultCredit for all employee
			$this->conn->query("UPDATE `leavetypeids` SET `DefultCredit`='$DefaultCredit'");

			$resp['status'] = 'success';
			if(empty($id))
				$this->settings->set_flashdata('success',"New Leave Type successfully saved.");
			else
				$this->settings->set_flashdata('success',"Leave Type successfully updated.");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}

	function delete_leave_type(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `leave_types` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Leave Type successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}

	function generate_string($input, $strength = 10) {
		
		$input_length = strlen($input);
		$random_string = '';
		for($i = 0; $i < $strength; $i++) {
			$random_character = $input[mt_rand(0, $input_length - 1)];
			$random_string .= $random_character;
		}
	 
		return $random_string;
	}

	function upload_files(){
		extract($_POST);
		$data = "";
		if(empty($upload_code)){
			while(true){
				$code = $this->generate_string($this->permitted_chars);
				$chk = $this->conn->query("SELECT * FROM `uploads` where dir_code ='{$code}' ")->num_rows;
				if($chk <= 0){
					$upload_code = $code;
					$resp['upload_code'] =$upload_code;
					break;
				}
			}
		}

		if(!is_dir(base_app.'uploads/blog_uploads/'.$upload_code))
			mkdir(base_app.'uploads/blog_uploads/'.$upload_code);
		$dir = 'uploads/blog_uploads/'.$upload_code.'/';
		$images = array();
		for($i = 0;$i < count($_FILES['img']['tmp_name']); $i++){
			if(!empty($_FILES['img']['tmp_name'][$i])){
				$fname = $dir.(time()).'_'.$_FILES['img']['name'][$i];
				$f = 0;
				while(true){
					$f++;
					if(is_file(base_app.$fname)){
						$fname = $f."_".$fname;
					}else{
						break;
					}
				}
				$move = move_uploaded_file($_FILES['img']['tmp_name'][$i],base_app.$fname);
				if($move){
					$this->conn->query("INSERT INTO `uploads` (dir_code,user_id,file_path)VALUES('{$upload_code}','{$this->settings->userdata('id')}','{$fname}')");
					$this->capture_err();
					$images[] = $fname;
				}
			}
		}
		$resp['images'] = $images;
		$resp['status'] = 'success';
		return json_encode($resp);
	}

	//Save employee
	function save_employee(){
		
		extract($_POST);


		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				$v = addslashes($v);
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
				DBConnection::debugtaglog($k,$v);
			}
		}

	
		DBConnection::debuglog($id);
		if(empty($id))
		{
        //Check Email
		$chk2 = $this->conn->query("SELECT * FROM `employee` where Email ='{$email}'")->num_rows;
		$this->capture_err();
		if($chk2 > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Email is not available. Please review and try again.";
			return json_encode($resp);
			exit;
		}
	   }
	
		$imageData = 'null';

		//Dir not found
		$dir = 'uploads/';
		if(!is_dir(base_app.$dir))
		{
			mkdir(base_app.$dir);
		}


			$Fullname =  ($_POST['firstname']." ".$_POST['lastname']);
			$gender =  $_POST['gender'];
			$dob  = $_POST['dob'];
			$status =  $_POST['status'];
			$address = $_POST['address'];
			$netsalary = $_POST['netsalary'];
			$Email = $_POST['email'];
			$password = $_POST['password'];
			$designation_id  = $_POST['designation_id'];
			$currentempid = $this->settings->userdata('EmployeeID');


			//Upload image
			if(isset($_FILES['img'])){
			if(!empty($_FILES['img']['tmp_name']) && isset($_SESSION['userdata']) && isset($_SESSION['system_info'])){
						$fname = $dir.$Fullname."_emp.".(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));
						$move =  move_uploaded_file($_FILES['img']['tmp_name'],base_app.$fname);
						if($move){
							$imageData = "'".$fname."'";
							if(!empty($avatar) && is_file(base_app.$avatar))
								unlink(base_app.$avatar);
						}
					}
			}

		

       try {

		if(!empty($id))
		{

			$query = $this->conn->query("UPDATE `employee` SET `Avatar`=$imageData,`Fullname`='$Fullname',`Gender`='$gender',`DOB`='$dob',`Status`='$status',`Address`='$address',`NetSalary`='$netsalary',`Email`='$Email',`Password`='$password',`DesignationID_FK`='$designation_id',`Admin_ID_FK`='$currentempid' WHERE `EmployeeID`='$id'");
			
			DBConnection::debuglog("UPDATE `employee` SET `Avatar`=$imageData,`Fullname`='$Fullname',`Gender`='$gender',`DOB`='$dob',`Status`='$status',`Address`='$address',`NetSalary`='$netsalary',`Email`='$Email',`Password`='$password',`DesignationID_FK`='$designation_id',`Admin_ID_FK`='$currentempid' WHERE `EmployeeID`='$id'");

			if($query) {

				$empdata = $this->conn->query("SELECT * FROM `employee` WHERE Email = '$email'")->fetch_assoc();
	  
				$empid= $empdata['EmployeeID'];
	  
				$this->AddUpdateEmployeeON($phoneno1,$phonenoOld1,$phoneno2,$phonenoOld2,$phoneno3,$phonenoOld3,empty($empid),$empid);

				
	  
				 DBConnection::debuglog("Employee update successfully");
				 $resp['status'] = 'success';
				 $resp['id'] = $id;
				 $resp['msg'] =  "Employee inserted successfully";
	  
	  
			} 
			   

		

		}

		else{
          // Prepare the query
          $query = $this->conn->prepare("INSERT INTO `employee`(`Avatar`, `Fullname`, `Gender`, `DOB`, `Status`, `Address`, `NetSalary`, `Email`, `Password`, `DesignationID_FK`, `Admin_ID_FK`) VALUES (?,?,?,?,?,?,?,?,?,?,?)");

       		// Bind parameters
      		$query->bind_param("ssssisdssii",
        	$imageData,
        	$Fullname,
        	$gender,
        	$dob,
        	$status,
        	$address,
        	$netsalary,
        	$Email,
        	$password,
        	$designation_id,
        	$currentempid
       		);

         // Execute the query
          $query->execute();

	
         // Check if the query was successful
		 // then add phone no
         if($query->affected_rows > 0) {

		  $empdata = $this->conn->query("SELECT * FROM `employee` WHERE Email = '$email'")->fetch_assoc();

          $empid= $empdata['EmployeeID'];

		  //Insert phone no
		  $this->AddUpdateEmployeeON($phoneno1,$phonenoOld1,$phoneno2,$phonenoOld2,$phoneno3,$phonenoOld3,empty($empid),$empid);

           DBConnection::debuglog("Employee inserted successfully");
		   $resp['status'] = 'success';
		   $resp['id'] = $id;
	       $resp['msg'] =  "Employee inserted successfully";


           } else {
			$resp['status'] = 'failed';
			$resp['msg'] = "Failed to insert employee";
           DBConnection::debuglog("Failed to insert employee");
           }
		 }


          } catch (Exception $e) 
		  {
             // Handle exceptions
             DBConnection::debuglog($e->getMessage());
          }

	       return json_encode($resp);
      }


	function AddUpdateEmployeeON($phoneno1,$phonenoOld1,$phoneno2,$phonenoOld2,$phoneno3,$phonenoOld3,$isempty,$empid)
	{
		if($isempty)
		{
			//Phone no 1
			if(!empty($phoneno1) && isset($phoneno1))
			{
			 $this->conn->query("UPDATE `employeephoneno` SET `PhoneNo`='$phoneno1' WHERE `PhoneNo`='$phonenoOld1'");
			}

			//Phone no 2
			if(!empty($phoneno2) && isset($phoneno2))
			{
				$this->conn->query("UPDATE `employeephoneno` SET `PhoneNo`='$phoneno2' WHERE `PhoneNo`='$phonenoOld2'");
			}

			//Phone no 3
			if(!empty($phoneno3) && isset($phoneno3))
			{
				$this->conn->query("UPDATE `employeephoneno` SET `PhoneNo`='$phoneno3' WHERE `PhoneNo`='$phonenoOld3'");
			}
	    }
		else
		{
 			//Phone no 1
 			if(!empty($phoneno1) && isset($phoneno1))
 			{
 			$this->conn->query("INSERT INTO `employeephoneno`(`PhoneNo`, `EmployeeID_FK`) VALUES ('$phoneno1','$empid')");
 			}
		
 			//Phone no 2
 			if(!empty($phoneno2) && isset($phoneno2))
 			{
 			 $this->conn->query("INSERT INTO `employeephoneno`(`PhoneNo`, `EmployeeID_FK`) VALUES ('$phoneno2','$empid')");
 			}
		
 			//Phone no 3
 			if(!empty($phoneno3) && isset($phoneno3))
 			{
 			$this->conn->query("INSERT INTO `employeephoneno`(`PhoneNo`, `EmployeeID_FK`) VALUES ('$phoneno3','$empid')");
 			}
		}
	}

	function reset_password(){
		extract($_POST);
		$employee_id = $this->conn->query("SELECT meta_value FROM `employee_meta` where meta_field = 'employee_id' and user_id = '{$id}'")->fetch_array()['meta_value'];
		$this->capture_err();
		$update = $this->conn->query("UPDATE `users` set `password` = md5('{$employee_id}') where id = '{$id}'");
		$this->capture_err();
		$resp['status']='success';
		$this->settings->set_flashdata('success',' User\'s password successfully updated. ');
		return json_encode($resp);
	}

	function delete_img(){
		extract($_POST);
		if(is_file(base_app.$path)){
			if(unlink(base_app.$path)){
				$del = $this->conn->query("DELETE FROM `uploads` where file_path = '{$path}'");
				$resp['status'] = 'success';
			}else{
				$resp['status'] = 'failed';
				$resp['error'] = 'failed to delete '.$path;
			}
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = 'Unkown '.$path.' path';
		}
		return json_encode($resp);
	}

	function save_emp_leave_type(){
		extract($_POST);


		$insertstr = array();

		if(isset($leave_type_id) && count($leave_type_id) > 0){
	

		    $count =count($leave_type_id)-1;

			foreach($leave_type_id as $k=> $v){
				array_push($insertstr,"(",$user_id.','.$v.','.$leave_credit[$k].','.$leave_default_credit[$k].')'.($count == $k ? '' : ','));
			}
		}

       DBConnection::debuglog("DELETE  FROM `leavetypeids` WHERE EmployeeID_FK = '{$user_id}'");

		// $resp['status']='fail';
		// return json_encode($resp);


		
		$this->conn->query("DELETE  FROM `leavetypeids` WHERE EmployeeID_FK = '{$user_id}' ");

		
		$save = $this->conn->query("INSERT INTO `leavetypeids` VALUES ".implode($insertstr));
		

		
		
		$this->capture_err();
		
		$resp['status'] = 'success';
		$this->settings->set_flashdata("success"," Leave Type Credits successfully updated.");
		return json_encode($resp);
	}

	function save_application(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				$v = addslashes($v);
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}


		DBConnection::debuglog($data);

		$resp['status'] = 'failed';
		$resp['msg'] = "Currently testing";
		return json_encode($resp);

		$meta_qry = $this->conn->query("SELECT * FROM employee where EmployeeID = '{$user_id}' ");
		while($row = $meta_qry->fetch_assoc()){
			$meta[$row['meta_field']] = $row['meta_value'];
		}
		$leave_type_credits = isset($meta['leave_type_credits']) ? json_decode($meta['leave_type_credits']) : array();
		$ltc = array();
		foreach($leave_type_credits as $k=> $v){
			$ltc[$k] = $v;
		}

		


		$used = $this->conn->query("SELECT COALESCE(sum(`leave_days`),0) as total FROM leaveapplication where ApplyEmpID_FK = '{$user_id}' and `leave_type_id` = '{$leave_type_id}' and date_format(date_start,'%Y') = '".date('Y')."' and date_format(date_end,'%Y') = '".date('Y')."' and status = 1 ")->fetch_array()['total'];
		$allowed = (isset($ltc[$leave_type_id])) ? $ltc[$leave_type_id] : 0;
		$available =  $allowed - $used;
		if(!isset($ltc[$leave_type_id])){
			$resp['status'] = 'failed';
			$resp['msg'] = " Selected employee does not have previlege for the selected leave type.";
			return json_encode($resp);
			exit;
		}
		if($leave_days > $available){
			$resp['status'] = 'failed';
			$resp['msg'] = " Days of Leave is greated than available days of selected leave type. Available ({$available}).";
			return json_encode($resp);
			exit;
		}
		$check = $this->conn->query("SELECT * FROM `leave_applications` where (('{$date_start}' BETWEEN date(date_start) and date(date_end)) OR ('{$date_end}' BETWEEN date(date_start) and date(date_end))) and user_id = '{$user_id}' and status in (0,1) ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = " Leave date has conflict to other applications. Please review and try again.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `leave_applications` set {$data} ";
			$save = $this->conn->query($sql);
		}else{
			$sql = "UPDATE `leave_applications` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if($save){
			$resp['status'] = 'success';
			if(empty($id))
				$this->settings->set_flashdata('success',"New Leave Application successfully saved.");
			else
				$this->settings->set_flashdata('success',"Leave Application successfully updated.");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}

	function delete_application(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `leave_applications` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Leave Application successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}

	function update_status(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				$v = addslashes($v);
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$sql = "UPDATE `leave_applications` set {$data} where id = '{$id}' ";
		$save = $this->conn->query($sql);
		$this->capture_err();
		$resp['status'] = 'success';
		return json_encode($resp);
	}
}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'save_department':
		echo $Master->save_department();
	break;
	case 'delete_department':
		echo $Master->delete_department();
	break;
	case 'save_designation':
		echo $Master->save_designation();
	break;
	case 'delete_designation':
		echo $Master->delete_designation();
	break;
	case 'save_leave_type':
		echo $Master->save_leave_type();
	break;
	case 'delete_leave_type':
		echo $Master->delete_leave_type();
	break;
	case 'upload_files':
		echo $Master->upload_files();
	break;
	case 'save_employee':
		echo $Master->save_employee();
	break;
	case 'reset_password':
		echo $Master->reset_password();
	break;
	case 'save_emp_leave_type':
		echo $Master->save_emp_leave_type();
	break;
	case 'save_application':
		echo $Master->save_application();
	break;
	case 'delete_application':
		echo $Master->delete_application();
	break;
	case 'update_status':
		echo $Master->update_status();
	break;
	case 'delete_img':
		echo $Master->delete_img();
	break;
	default:
		// echo $sysset->index();
		break;
}
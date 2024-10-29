<?php
require_once('../config.php');
Class Users extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	public function save_users(){
		
		extract($_POST);
		$data = '';
		
		//meage full name
		$Fullname = $firstname." ".$lastname;

		foreach($_POST as $k => $v){
			if(!in_array($k,array('id','password'))){
				if(!empty($data)) $data .=" , ";
				$data .= " {$k} = '{$v}' ";
			}
		}
		if(!empty($password)){
			// $password = md5($password);
			if(!empty($data)) $data .=" , ";
			$data .= " `password` = '{$password}' ";
		}

		
		
		$fname = "";

		if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
				$fname = 'uploads/'.strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
				$move =  move_uploaded_file($_FILES['img']['tmp_name'],base_app.$fname);
					if($move){
						if(!empty($avatar) && is_file(base_app.$avatar))
							unlink(base_app.$avatar);

							$this->set_userdata('Avatar',$fname);
					}
		}
		
	
		if(!empty($id))
		{
			$imageData = null;
			
			$sql = "UPDATE `employee` SET "
			.(isset($fname ) ? "Avatar='$fname',":"").
			"Fullname='$Fullname',Email='$Email',Password='$password' WHERE EmployeeID='$id'";
			ob_start();
			var_dump($sql);
			$this->debuglog(ob_get_clean());
			$query = $this->conn->query($sql);
		
			
			
			
			if($query) {
				
				// $empdata = $this->conn->query("SELECT * FROM `employee` WHERE Email = '$email'")->fetch_assoc();

				// $this->AddUpdateEmployeeON($phoneno1,$phoneno2,$phoneno3,$id);

				
				//  $resp['status'] = 'success';
				//  $resp['id'] = $id;
				//  $resp['msg'] =  "Employee inserted successfully";
				 return 1;
	  
			} 

			else{
				return -1;
			}
		

	}


	}

	
	function AddUpdateEmployeeON($phoneno1,$phoneno2,$phoneno3,$empid)
	{
		
		    $this->conn->query("DELETE FROM employeephoneno WHERE EmployeeID_FK = ".$empid);

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

		// }
	}



	public function delete_users(){
		extract($_POST);
		$avatar = $this->conn->query("SELECT avatar FROM users where id = '{$id}'")->fetch_array()['avatar'];
		$qry = $this->conn->query("DELETE FROM users where id = $id");
		if($qry){
			$this->settings->set_flashdata('success','User Details successfully deleted.');
			if(is_file(base_app.$avatar))
				unlink(base_app.$avatar);
			$resp['status'] = 'success';
		}else{
			$resp['status'] = 'failed';
		}
		return json_encode($resp);
	}
	public function save_fusers(){
		
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id','password'))){
				if(!empty($data)) $data .= ", ";
				$data .= " `{$k}` = '{$v}' ";
			}
		}

			if(!empty($password))
			$data .= ", `password` = '".md5($password)."' ";
		
			if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
				$fname = 'uploads/'.strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
				$move = move_uploaded_file($_FILES['img']['tmp_name'],'../'. $fname);
				if($move){
					$data .=" , avatar = '{$fname}' ";
					if(isset($_SESSION['userdata']['avatar']) && is_file('../'.$_SESSION['userdata']['avatar']))
						unlink('../'.$_SESSION['userdata']['avatar']);
				}
			}
			$sql = "UPDATE faculty set {$data} where id = $id";
			$save = $this->conn->query($sql);

			if($save){
			$this->settings->set_flashdata('success','User Details successfully updated.');
			foreach($_POST as $k => $v){
				if(!in_array($k,array('id','password'))){
					if(!empty($data)) $data .=" , ";
					$this->settings->set_userdata($k,$v);
				}
			}
			if(isset($fname) && isset($move))
			$this->settings->set_userdata('avatar',$fname);
			return 1;
			}else{
				$resp['error'] = $sql;
				return json_encode($resp);
			}

	} 

	public function save_susers(){

		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id','password'))){
				if(!empty($data)) $data .= ", ";
				$data .= " `{$k}` = '{$v}' ";
			}
		}

			if(!empty($password))
			$data .= ", `password` = '".md5($password)."' ";
		
			if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
				$fname = 'uploads/'.strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
				$move = move_uploaded_file($_FILES['img']['tmp_name'],'../'. $fname);
				if($move){
					$data .=" , avatar = '{$fname}' ";
					if(isset($_SESSION['userdata']['avatar']) && is_file('../'.$_SESSION['userdata']['avatar']))
						unlink('../'.$_SESSION['userdata']['avatar']);
				}
			}
			$sql = "UPDATE students set {$data} where id = $id";
			$save = $this->conn->query($sql);

			if($save){
			$this->settings->set_flashdata('success','User Details successfully updated.');
			foreach($_POST as $k => $v){
				if(!in_array($k,array('id','password'))){
					if(!empty($data)) $data .=" , ";
					$this->settings->set_userdata($k,$v);
				}
			}
			if(isset($fname) && isset($move))
			$this->settings->set_userdata('avatar',$fname);
			return 1;
			}else{
				$resp['error'] = $sql;
				return json_encode($resp);
			}

	} 
	
}

$users = new users();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);

switch ($action) {
	case 'save':
		echo $users->save_users();
	break;
	case 'fsave':
		echo $users->save_fusers();
	break;
	case 'ssave':
		echo $users->save_susers();
	break;
	case 'delete':
		echo $users->delete_users();
	break;
	default:
		// echo $sysset->index();
		break;
}
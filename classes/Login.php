<?php
require_once '../config.php';
class Login extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;

		parent::__construct();
		ini_set('display_error', 1);
	}
	public function __destruct(){
		parent::__destruct();
	}
	public function index(){
		echo "<h1>Access Denied</h1> <a href='".base_url."'>Go Back.</a>";
	}
	public function login()
	{
		extract($_POST);
		$qry =$this->conn->query("SELECT 
		emp.*,
		IF(ad.EmployeeID  IS NOT null,1,
		IF(acc.EmployeeID IS NOT null,2,3)) as login_type,
		
		IF(ad.EmployeeID  IS NOT null,ad.PriorityLevel,
		IF(acc.EmployeeID IS NOT null,acc.PriorityLevel,null)) as PriorityLevel,
		
		ad.ManageEmployee as AdminManageEmployee,
		ad.ManageLeave as AdminManageLeave,
		ad.ManageSalary as AdminManageSalary,
		ad.ManageAttendance as AdminManageAttendance,
		
		acc.ManageSalary as AccManageSalary,
		acc.ManageAttendance as AccManageAttendance
		
		FROM employee emp 
		LEFT JOIN admin ad ON  emp.EmployeeID = ad.EmployeeID
		LEFT JOIN accountant acc ON emp.EmployeeID = acc.EmployeeID WHERE emp.Email = '$email' AND emp.Password = '$password'");

		if($qry->num_rows > 0 && $Usertype == 1 || $Usertype == 2 || $Usertype == 3){
			foreach($qry->fetch_array() as $k => $v)
			{
				if(!is_numeric($k) && $k != 'password'){
					$this->settings->set_userdata($k,$v);
				}

			}
		
        if($this->settings->userdata('Status') && $this->settings->userdata('login_type') !=  $Usertype)
		{
			$this->settings->sess_des();
			return json_encode(array('status'=>'incorrect','Authentication failed'));
		}
	
		else{
		return json_encode(array('status'=>'success'));
		}
		}else{
		return json_encode(array('status'=>'incorrect','last_qry'=>"SELECT * from employee where Email = '$email' and password = '$password'"));
		}
	}






	public function logout(){
		if($this->settings->sess_des()){
			redirect('admin/login.php');
		}
	}
	function login_user(){
		extract($_POST);
		$qry = $this->conn->query("SELECT * from clients where email = '$email' and password = md5('$password') ");
		if($qry->num_rows > 0){
			foreach($qry->fetch_array() as $k => $v){
				$this->settings->set_userdata($k,$v);
			}
			$this->settings->set_userdata('login_type',1);
		$resp['status'] = 'success';
		}else{
		$resp['status'] = 'incorrect';
		}
		if($this->conn->error){
			$resp['status'] = 'failed';
			$resp['_error'] = $this->conn->error;
		}
		return json_encode($resp);
	}

	
}



$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);



$auth = new Login();
switch ($action) {
	case 'login':
		echo $auth->login();
		break;
	case 'login_user':
		echo $auth->login_user();
		break;
	case 'logout':
		echo $auth->logout();
		break;
	default:
		echo $auth->index();
		break;
}





?>


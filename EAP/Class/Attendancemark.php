<?php

require_once ("DBConnection.php");
require_once("Vaildater.php");

class AttendanceMark extends DBConnection
{
   
    
    

//     if($empid == 1)
//     {

        
//     echo json_encode(array('status'=>'success'));
//     }
//     else if($empid==2)
//     {
//         echo json_encode(array('status'=>"showbtn"));
//     }
//     else
//     {
//         echo json_encode(array('status'=>'incorrect'));
//     }

//    // echo json_encode(array('status'=>'error','message'=>"message"));
 function Signin($empid) 
    {
        try {
         // Check if empty
        if(!isset($empid) || empty($empid))
        {
            return json_encode(array('status'=>'incorrect'));
        }

        
        $result =  $this->conn->query("CALL Pro_GetEmployeeDesignation($empid)");
          
       
         $exitsEmployee =  $result->fetch_assoc();

     
        $this->Reload();
        
        //If employee not found
        if(!isset($exitsEmployee) && empty($exitsEmployee))
        {
            return json_encode(array('status'=>'incorrect'));
            exit;
           
        }

        // Else
        else{


            $IsSingin = $this->conn->query("SELECT *  FROM `attendance` WHERE `EmployeeID_FK` = {$empid} AND CONVERT(attendance.Signin,DATE) = CURRENT_DATE()")->fetch_assoc();

            
            
            if(isset($IsSingin) &&  count($IsSingin) > 0 && isset($IsSingin["Lunchin"]) && isset($IsSingin["Lunchout"]) && isset($IsSingin["Signout"]))
            {
               return json_encode(array('status'=>'error','message'=>"Today all Attendance has already been marked"));
            }

            //Sign in already mark
           else if(isset($IsSingin) &&  count($IsSingin) > 0 && !isset($IsSingin["Lunchout"]) && !isset($IsSingin["Lunchin"]) && !isset($IsSingin["Signout"]))
            { return json_encode(array('status'=>"showbtn"));}

            

            //Lunch In
            else if(isset($IsSingin) &&  count($IsSingin) > 0 && isset($IsSingin["Lunchout"]) && !isset($IsSingin["Lunchin"]) && !isset($IsSingin["Signout"]))
            {

                $isinsert = $this->conn->query("UPDATE `attendance` SET  Lunchin=Now() Where `EmployeeID_FK` = {$empid} AND CONVERT(attendance.Signin,DATE) = CURRENT_DATE()");
            
                if($isinsert)
                {
                    return json_encode(array('status'=>'success',
                    'message'=>array(
                        "Avatar"=>validate_image($exitsEmployee["Avatar"]),
                        "Fullname"=>$exitsEmployee["Fullname"],
                        "DesignationName" => $exitsEmployee["DesignationName"]
                    )));
                }

            }

            //Sign out
            else if(isset($IsSingin) &&  count($IsSingin) > 0 && isset($IsSingin["Lunchout"]) && isset($IsSingin["Lunchin"]) && !isset($IsSingin["Signout"]))
            {
                $isinsert = $this->conn->query("UPDATE `attendance` SET  Signout=Now() Where `EmployeeID_FK` = {$empid} AND CONVERT(attendance.Signin,DATE) = CURRENT_DATE()");
            
                if($isinsert)
                {
                    return json_encode(array('status'=>'success',
                    'message'=>array(
                        "Avatar"=>validate_image($exitsEmployee["Avatar"]),
                        "Fullname"=>$exitsEmployee["Fullname"],
                        "DesignationName" => $exitsEmployee["DesignationName"]
                    )));
                }

            }

            //Not sigin in
            else
            {
                $isinsert = $this->conn->query("INSERT INTO `attendance`(AttendanceDate, Signin,EmployeeID_FK) VALUES (Now(),Now(),$empid)");
            
                if($isinsert)
                {
                    return json_encode(array('status'=>'success',
                    'message'=>array(
                        "Avatar"=>validate_image($exitsEmployee["Avatar"]),
                        "Fullname"=>$exitsEmployee["Fullname"],
                        "DesignationName" => $exitsEmployee["DesignationName"]
                    )));
                }
    
                else
                {
                    return json_encode(array('status'=>'error','message'=>"Failed to mark attendance"));
                }
            }
            
            
      
            }
         
       

        }
        catch(Exception $e)
            {
            return json_encode(array('status'=>'error','message'=> $e->getMessage())); 
        
            }

    }

 function LunchInORSignOut($empid,$Act)
    {

        try{

              // Check if empty
        if(!isset($empid) || empty($empid))
        {
            return json_encode(array('status'=>'incorrect'));
        }

        
        $result =  $this->conn->query("CALL Pro_GetEmployeeDesignation($empid)");
          
        $exitsEmployee =  $result->fetch_assoc();
        
      

        $this->Reload();

        //If employee not found
        if(!isset($exitsEmployee) && empty($exitsEmployee))
        {
            return json_encode(array('status'=>'incorrect'));
            exit;
        }

        else
        {
                $isinsert = $this->conn->query("UPDATE `attendance` SET  {$Act}=Now() Where `EmployeeID_FK` = {$empid} AND CONVERT(attendance.Signin,DATE) = CURRENT_DATE()");
            
                if($isinsert)
                {
                    return json_encode(array('status'=>'success',
                    'message'=>array(
                        "Avatar"=>validate_image($exitsEmployee["Avatar"]),
                        "Fullname"=>$exitsEmployee["Fullname"],
                        "DesignationName" => $exitsEmployee["DesignationName"]
                    )));
                }
    
                else
                {
                    return json_encode(array('status'=>'error','message'=>"Failed to mark attendance"));
                }
            }
        


        }
        catch(Exception $e)
        {
            return json_encode(array('status'=>'error','message'=>  $e->getMessage())); 
        }
    }

    function debug($object)
    {
        ob_start(); 
        var_dump($object);
        return json_encode(array('status'=>'error','message'=>ob_get_clean()));

    }
}

$Action =  isset($_GET['f'])? $_GET['f'] : '';
if(!empty($Action))
{

$att = new AttendanceMark();




switch($Action)
{

    case "Signin":
        echo $att->Signin($_POST['empid']);
    break;

    case "Lunchout":
        echo $att->LunchInORSignOut($_POST['empid'],"Lunchout");
        break;

    case "Signout":
        echo $att->LunchInORSignOut($_POST['empid'],"Signout");
    break;

    default:
    echo json_encode(array('status'=>'error','message'=>"Invalid Action"));
    break;
}
}




// if(isset($_POST['empid']))
// {

//   $att = new AttendanceMark();
//   echo $att->Signin($_POST['empid']);
// }

//  if(isset($_POST['action']))
//  {
//     $operation = $_POST['action'];
//     //$empid = $_POST['empid'];

//     echo json_encode(array('status'=>'error','message'=>$operation));

  

//  }


?>



<?php if($_settings->chk_flashdata('success')): ?>
    <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
    </script>
<?php endif;?>
<?php 
if(isset($_GET['id']) && $_GET['id'] > 0){

    DBConnection::debugtaglog("Recordlog",$_GET['id']);

    // $user = $conn->query("SELECT * FROM users where id ='{$_GET['id']}'");
    // foreach($user->fetch_array() as $k =>$v){
    //     $$k = $v;
    // }


    // $name = ucwords($lastname.', '.$firstname.' '.$middlename);


    //employee
	$meta_qry = $conn->query("SELECT emp.*,
    dep.Name AS Departmentname,des.Name AS Designationname 
    FROM employee emp  
    LEFT JOIN designation des ON emp.DesignationID_FK = des.DesignationID
    LEFT JOIN department dep ON des.DepartmentID_FK = dep.DepartmentID where emp.EmployeeID = '{$_GET['id']}' ");
	$row = $meta_qry->fetch_assoc();
    
    $employeename = $row['Fullname'];
    $id = $row['EmployeeID'];
    DBConnection::debuglog($employeename);

    //employee phone no
    $phonenoarry = array();
    $phonenodata = $conn->query("SELECT * FROM `employeephoneno` WHERE EmployeeID_FK = {$_GET['id']} ORDER BY id;");
								
	if ($phonenodata->num_rows > 0) {
			// output data of each row
			while($prow = $phonenodata->fetch_assoc()) {
					array_push($phonenoarry,$prow['PhoneNo']);
			}
	}

    $phoneno1 = isset($phonenoarry[0]) ? $phonenoarry[0]: 'N/A' ;
    $phoneno2 = isset($phonenoarry[1]) ? $phonenoarry[1]: 'N/A' ;
    $phoneno3 = isset($phonenoarry[2]) ? $phonenoarry[2]: 'N/A' ;
    

}

?>
<?php 
if(isMobileDevice()):
?>
<style>
    .info-table td{
        display:block !important;
        width:100% !important;
    }
</style>
<?php endif; ?>
<div class="card">
    <div class="card-body">
        <div class="w-100 d-flex justify-content-end mb-3">
            <?php if($_settings->userdata('type') != 3): ?>
            <a href="?page=employees/manage_employee&id=<?php echo $id ?>" class="btn btn-flat btn-primary"><span class="fas fa-edit"></span>  Edit Employee</a>
            <?php endif; ?>
            <a href="javascript:void(0)" class="btn btn-flat btn-success ml-3" id="print"><span class="fas fa-print"></span>  Print</a>
        </div>
        <div id="print_out">
        <table class="table info-table">
            <tr class='boder-0'>
                <td width="20%">
                    <div class="w-100 d-flex align-items-center justify-content-center">
                        <img src="<?php echo validate_image(isset($row['Avatar']) ? $row['Avatar'] : null) ?>" alt="Employee Avatar" class="img-thumbnail" id="cimg">
                    </div>
                </td>
                <td width="80%" class='boder-0 align-bottom'>
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex w-max-100">
                                <label class="float-left w-auto whitespace-nowrap">Employee ID:</label>
                                <p class="col-md-auto border-bottom border-dark w-100"><b><?php echo isset($row['EmployeeID']) ? $row['EmployeeID'] : "N/A" ?></b></p>
                            </div>
                            <div class="d-flex w-max-100">
                                <label class="float-left w-auto whitespace-nowrap">Name:</label>
                                <p class="col-md-auto border-bottom border-dark w-100"><b><?php echo isset($row['Fullname']) ? $row['Fullname'] : "N/A" ?></b></p>
                            </div>
                            <div class="d-flex w-max-100">
                                <label class="float-left w-auto whitespace-nowrap">Email:</label>
                                <p class="col-md-auto border-bottom border-dark w-100"><b><?php echo isset($row['Email']) ? $row['Email'] : "N/A" ?></b></p>
                            </div>
                            <div class="row justify-content-between  w-max-100 mr-0">
                                <div class="col-6 d-flex w-max-100">
                                    <label class="float-left w-auto whitespace-nowrap">DOB: </label>
                                    <p class="col-md-auto border-bottom px-2 border-dark w-100"><b><?php echo isset($row['DOB']) ? date("M d, Y",strtotime($row['DOB'])) : "N/A" ?></b></p>
                                </div>
                                
                                <div class="col-6 d-flex w-max-100">
                                    <label class="float-left w-auto whitespace-nowrap">Phone No 1: </label>
                                    <p class="col-md-auto border-bottom px-2 border-dark w-100"><b><?php echo $phoneno1 ?></b></p>
                                </div>

                                <div class="col-6 d-flex w-max-100">
                                    <label class="float-left w-auto whitespace-nowrap">Phone No 2: </label>
                                    <p class="col-md-auto border-bottom px-2 border-dark w-100"><b><?php echo $phoneno2 ?></b></p>
                                </div>

                                <div class="col-6 d-flex w-max-100">
                                    <label class="float-left w-auto whitespace-nowrap">Phone No 3: </label>
                                    <p class="col-md-auto border-bottom px-2 border-dark w-100"><b><?php echo $phoneno3 ?></b></p>
                                </div>
                                
                            </div>
                            <div class="d-flex w-max-100">
                                <label class="float-left w-auto whitespace-nowrap">Address:</label>
                                <p class="col-md-auto border-bottom border-dark w-100"><b><?php echo isset($row['Address']) ? $row['Address'] : "N/A" ?></b></p>
                            </div>
                            <div class="row justify-content-between  w-max-100  mr-0">
                                <div class="col-6 d-flex w-max-100">
                                    <label class="float-left w-auto whitespace-nowrap">Department: </label>
                                    <p class="col-md-auto border-bottom px-2 border-dark w-100"><b><?php echo isset($row['Departmentname']) ? $row['Departmentname'] : "N/A" ?></b></p>
                                </div>
                                <div class="col-6 d-flex w-max-100">
                                    <label class="float-left w-auto whitespace-nowrap">Designation: </label>
                                    <p class="col-md-auto border-bottom px-2 border-dark w-100"><b><?php echo isset($row['Designationname']) ?  $row['Designationname'] : "N/A" ?></b></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <hr class="border-dark">
        <div class="row">
            <div class="col-md-4 col-sm-12">
                <div class="callout border-0">
                    <?php if($_settings->userdata('type') != 3): ?>
                    <div class="float-right">
                        <!-- popup -->
                        <button class="btn btn-sm btn-default bg-lightblue rounded-circle text-center" type="button" id="manage_leave">
                            <span class="fa fa-cog"></span>
                        </button>
                    </div>
                    <?php endif; ?>

                    <h5 class="mb-2">Leave Credits</h5>
                    <table class="table table-hover ">
                        <colgroup>
                            <col width="70%">
                            <col width="15%">
                            <col width="15%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th class="py-1 px-2">Type</th>
                                <th class="py-1 px-2">Allowable</th>
                                <th class="py-1 px-2">Available</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 

                       
                        //Leave creatis for employees
                        $leavecreatis =$conn->query("SELECT * FROM `leavetype` lev LEFT JOIN leavetypeids levid ON lev.LeaveID = levid.leavetypeid where levid.EmployeeID_FK = {$id} order by ShortName asc ");
                        
                        //Leave credits count
                        if(!empty($leavecreatis)):
                        while($row=$leavecreatis->fetch_assoc()):

                            $used = $conn->query("SELECT SUM(DATEDIFF(EndDate,StartDate)) as total 
                            FROM `leaveapplication` where ApplyEmpID_FK = '{$id}' 
                            and status = 1 and date_format(StartDate,'%Y') = '".date('Y')."' 
                            and date_format(EndDate,'%Y') = '".date('Y')."' 
                            and LeaveTypeID_FK = '{$row['leavetypeid']}' ")->fetch_array()['total'];


                            //DBConnection::debuglog($row['leavetypeid']);

                            //$lt = $conn->query("SELECT * FROM `leavetype` lev LEFT JOIN leavetypeids levid ON lev.LeaveID = levid.leavetypeid where levid.EmployeeID_FK = {$id} order by ShortName asc ")->fetch_assoc();

                            //DBConnection::debuglog("SELECT * FROM `leavetype` lev LEFT JOIN leavetypeids levid ON lev.LeaveID = levid.leavetypeid where levid.EmployeeID_FK = {$id} order by ShortName asc ");

                            //remin leave credit
                            $allowed = isset($row['leavecredit']) ? $row['leavecredit'] : 0;
                            $available =  $allowed - $used;

                            

                        ?>
                        <tr>
                            <td><?php echo $row['ShortName'] ?></td>
                            <td><?php echo number_format($allowed) ?></td>
                            <td><?php echo number_format($available,1) ?></td>
                        </tr>
                        <?php endwhile; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-8 col-sm-12">
                <div class="callout border-0">
                    <h5>Records</h5>
                    <table class="table-stripped table">
                        <colgroup>
                                <col width="30%">
                                <col width="20%">
                                <col width="10%">
                                <col width="40%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th class="p-1">Leave Type</th>
                                <th class="p-1">Date</th>
                                <th class="p-1">Days</th>
                                <th class="p-1">Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            
                            $la = $conn->query("SELECT l.*,lt.ShortName, lt.Description,DATEDIFF(EndDate,StartDate) leave_days FROM `leaveapplication` l 
                            inner join `leavetype` lt on l.LeaveTypeID_FK = lt.leaveID
                             where l.status = 1 and l.ApplyEmpID_FK = '{$_GET['id']}' 
                             and (date_format(l.StartDate,'%Y') = '".date("Y").
                             "' or date_format(l.EndDate,'%Y') = '".date("Y")."')  order by unix_timestamp(l.StartDate) asc,unix_timestamp(l.EndDate) asc ");
                            
                            
                            while($row = $la->fetch_assoc()):
                            ?>
                            <tr>
                                <td class="p-1"><?php echo $row['ShortName'].' - '.$row['Description'] ?></td>
                                <td class="p-1">
                                    <?php
                                    if($row['StartDate'] == $row['EndDate']){
                                        echo date("Y-m-d", strtotime($row['StartDate']));
                                    }else{
                                        echo date("Y-m-d", strtotime($row['StartDate'])).' - '.date("Y-m-d", strtotime($row['EndDate']));
                                    }
                                    ?>
                                </td>
                                <td class="p-1"><?php echo $row['leave_days'] ?></td>
                                <td class="p-1"><small><i><?php echo $row['reason'] ?></i></small></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>

<script>
    $(function(){
        $('#manage_leave').click(function(){
            uni_modal('<i class="fa fa-cog"></i> Manage Leave Credits of <?php echo $employeename; ?>','employees/manage_leave_type.php?id=<?php echo $id; ?>');
            
        })
        $('#print').click(function(){
            start_loader()
            var _h = $('head').clone()
            var _p = $('#print_out').clone();
            var _el = $('<div>')
            _el.append(_h)
            _el.append('<style>html, body, .wrapper {min-height: unset !important;}.btn{display:none !important}</style>')
            _p.prepend('<div class="d-flex mb-3 w-100 align-items-center justify-content-center">'+
            '<img class="mx-4" src="<?php echo validate_image($_settings->info('logo')) ?>" width="50px" height="50px"/>'+
            '<div class="px-2">'+
            '<h3 class="text-center"><?php echo $_settings->info('name') ?></h3>'+
            '<h3 class="text-center">Employee\'s Leave Information Year(<?php echo date("Y") ?>)</h3>'+
            '</div>'+
            '</div><hr/>');
            _el.append(_p)
            var nw = window.open("","_blank","width=1200,height=1200")
                nw.document.write(_el.html())
                nw.document.close()
                setTimeout(() => {
                    nw.print()
                    setTimeout(() => {
                        nw.close()
                        end_loader()
                    }, 300);
                }, 500);
        })
    })
</script>
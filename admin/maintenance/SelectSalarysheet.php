<?php if($_settings->chk_flashdata('success')): ?>
    <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
    </script>
<?php endif;?>
<?php 
if(isset($_GET['id']) && $_GET['id'] > 0){

     $id = $_GET['id'];
     $StartDate =  isset($_GET['StartDate']) ? $_GET['StartDate'] : '';
     $EndDate = isset($_GET['EndDate']) ? $_GET['EndDate']: "";

	
    //employee
	$meta_qry = $conn->query("SELECT emp.*,
    dep.Name AS Departmentname,des.Name AS Designationname 
    FROM employee emp  
    LEFT JOIN designation des ON emp.DesignationID_FK = des.DesignationID
    LEFT JOIN department dep ON des.DepartmentID_FK = dep.DepartmentID  where emp.EmployeeID = '{$_GET['id']}'");
	$row = $meta_qry->fetch_assoc();
    
    $employeename = $row['Fullname'];
	$NetSalary = $row['NetSalary'];
	
    $id = $row['EmployeeID'];
   
	$month_name =  isset($_GET['month']) ? $_GET['month'] : '';
	$year = isset($_GET['year']) ? $_GET['year']: "";

	$monthdate = $conn->query("SELECT
	STR_TO_DATE(CONCAT('01 ', '".$month_name."', ' ', '".$year."'), '%d %M %Y') AS start_date,
	LAST_DAY(STR_TO_DATE(CONCAT('01 ', '".$month_name."', ' ', '".$year."'), '%d %M %Y')) AS end_date;")->fetch_assoc();


	$start_date = $monthdate['start_date'];
	$end_date = $monthdate['end_date'];

	$where =  "and AttendanceDate BETWEEN '".$start_date."' and '".$end_date."'" ;
    
	$totalhours = $conn->query("SELECT SUM(ROUND((TIMESTAMPDIFF(SECOND, Signin, Lunchin) / 3600.0), 2)+ROUND((TIMESTAMPDIFF(SECOND, Lunchout, Signout) / 3600.0), 2)) AS AllTotalHours FROM `attendance` WHERE `EmployeeID_FK` = {$id} ". $where)->fetch_assoc();
	$totalhours = $totalhours['AllTotalHours'];

	
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
               
<div class="card-header">
		<h3 id='reporttitle' class="card-title"><?php echo  isset($row['Fullname']) ? 'Salarysheet for '.$row['Fullname'] : "N/A" ?></h3>
        
		<input id="id" type="hidden" value="<?php echo $id; ?>" />
		
        <div class="w-100 d-flex justify-content-end mb-3">
            <a href="javascript:void(0)" class="btn btn-flat btn-success ml-3" id="print"><span class="fas fa-print"></span>  Print</a>
        </div>
    </div>
    <div class="card-body">
	<div id="print_out">
	<div class="cloumn">
                        <div class="col-12">
                            <div class="d-flex w-max-100">
                                <label class="float-left w-auto whitespace-nowrap">Employee ID:</label>
                                <p class="col-md-auto border-bottom"><b><?php echo isset($row['EmployeeID']) ? $row['EmployeeID'] : "N/A" ?></b></p>
                            </div>
                            <div class="d-flex w-max-100">
                                <label class="float-left w-auto whitespace-nowrap">Name:</label>
                                <p class="col-md-auto border-bottom"><b><?php echo isset($row['Fullname']) ? $row['Fullname'] : "N/A" ?></b></p>
                            </div>
                            <div class="d-flex w-max-100">
                                <label class="float-left w-auto whitespace-nowrap">Total Hours:</label>
                                <p class="col-md-auto border-bottom"><b><?php echo isset( $totalhours ) ?  $totalhours : "N/A" ?></b></p>
                            </div>
                           
                        </div>
         </div>
        
        <div class="container-fluid">
			<table class="table table-hover table-stripped">
				<colgroup>
					<col width="10%">
					<col width="15%">
					<col width="15%">
					<col width="20%">
					<col width="30%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Attendance ID</th>
						<th>Attendance Date</th>
						<th>Sign in</th>
						<th>Lunch out</th>
                        <th>Lunch in</th>
                        <th>Sign out</th>
						<th>Total hours</th>
						<th>Day Salary</th>
					</tr>
				</thead>
				<tbody>
					<?php
					//Start
					$i = 1;
					$total = 0;
                    $qry = $conn->query("SELECT *,ROUND((TIMESTAMPDIFF(SECOND, Signin, Lunchin) / 3600.0), 2)+ROUND((TIMESTAMPDIFF(SECOND, Lunchout, Signout) / 3600.0), 2) AS TotalHours FROM `attendance` WHERE `EmployeeID_FK` = {$id} ". $where ."  ORDER by AttendanceDate ASC");

                    while($row = $qry->fetch_assoc())
                   {

							 $total +=$row['TotalHours'] * $NetSalary;
							echo "<tr>"


				    ?>
						
							<td class="text-center"><?php echo $i++; ?></td>
							<td class="text-center"><?php echo DBConnection::Iset($row['AttendanceID'],"N/A")?></td>
                            <td class="text-center"><?php echo DBConnection::Iset($row['AttendanceDate'],"N/A")?></td>
                            <td class="text-center"><?php echo DBConnection::Iset($row['Signin'],"N/A")?></td>
                            <td class="text-center"><?php echo DBConnection::Iset($row['Lunchout'],"N/A")?></td>
                            <td class="text-center"><?php echo DBConnection::Iset($row['Lunchin'],"N/A")?></td>
                            <td class="text-center"><?php echo DBConnection::Iset($row['Signout'],"N/A")?></td>
                            <td class="text-center"><?php echo DBConnection::Iset($row['TotalHours'],"N/A")?></td>
							<td class="text-center"><?php echo DBConnection::Iset(($row['TotalHours'] * $NetSalary),"N/A")?></td>
                    <?php 
					
				   }
					echo "</tr>" 
                    
                    ?>

				   <tr>
				   <td></td>
				   <td></td>
				   <td></td>
				   <td></td>
				   <td></td>
				   <td></td>
				   <td></td>
				   <td class="text-center">Total :</td>
				   <td class="text-center"><?php echo DBConnection::Iset($total,"0")?></td>
				   </tr>
                    <?php if($qry->num_rows <=0 ): ?>
                        <tr>
							
                            <th class="text-center" colspan='6'> No Records.</th>
                        </tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
        
        </div>
    </div>
</div>

<script>

function getMonthNumber(monthName) {
    const monthNames = ["January", "February", "March", "April", "May", "June",
                        "July", "August", "September", "October", "November", "December"];
    const monthIndex = monthNames.indexOf(monthName);
    return monthIndex >= 0 ? (monthIndex + 1).toString().padStart(2, '0') : null;
}

function convertToMySQLDateTime(dateString) {
    const date = new Date(dateString);
    const mysqlDateTime = date.toISOString().slice(0, 19).replace('T', ' ');
    return mysqlDateTime;
}
    $(function(){
        $('#manage_leave').click(function(){
            uni_modal('<i class="fa fa-cog"></i> Manage Leave Credits of <?php echo $employeename; ?>','employees/manage_leave_type.php?id=<?php echo $id; ?>');
            
        })

        $("#year , #month").change(function(){

            var year = $('#year').val();
            var month = $('#month').val();

            if(year != 'All' && month != 'All')
            {

             
             const id = $('#id').val();
             const date = new Date(year, getMonthNumber(month) - 1); // JavaScript months are 0-indexed
             const startDate = new Date(date.getFullYear(), date.getMonth(), 1);
             const endDate = new Date(date.getFullYear(), date.getMonth() + 1, 0); // 0th day of next month is last day of current month
            
             $('#Apply').attr('href','?page=maintenance/view_attendance&id='+id+'&StartDate='+convertToMySQLDateTime(startDate)+'&EndDate='+convertToMySQLDateTime(endDate));

            }
           

        });


        

        $('#print').click(function(){
            start_loader()
            var _h = $('head').clone()
            var _p = $('#print_out').clone();
            var _el = $('<div>')

            var reporttitle = $('#reporttitle').html();
            console.log(reporttitle);
        

            _el.append(_h)
            _el.append('<style>html, body, .wrapper {min-height: unset !important;}.btn{display:none !important}</style>')
            _p.prepend('<div class="d-flex mb-3 w-100 align-items-center justify-content-center">'+
            '<img class="mx-4" src="<?php echo validate_image($_settings->info('logo')) ?>" width="50px" height="50px"/>'+
            '<div class="px-2">'+
            '<h3 class="text-center"><?php echo $_settings->info('name') ?></h3>'+
            '<h3 class="text-center">'+reporttitle+' <?php echo '('.date("Y") ?>)</h3>'+
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
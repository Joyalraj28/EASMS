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
		<h3 id='reporttitle' class="card-title"><?php echo  isset($row['Fullname']) ? 'Attendance for '.$row['Fullname'] : "N/A" ?></h3>
	   <div class="w-100 d-flex justify-content-end mb-3">
            <a href="javascript:void(0)" class="btn btn-flat btn-success ml-3" id="print"><span class="fas fa-print"></span>  Print</a>
        </div>
    </div>
    <div class="card-body">
     
        <div id="print_out">
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
						<th>Lunch</th>
                        <th>Lunch out</th>
                        <th>Sign out</th>
					</tr>
				</thead>
				<tbody>
					<?php
					//Start
					$i = 1;
                    $qry = $conn->query("SELECT * FROM `attendance` WHERE `EmployeeID_FK` = {$id}");

                    while($row = $qry->fetch_assoc())
                   {

							echo "<tr>"

				    ?>
						
							<td class="text-center"><?php echo $i++; ?></td>
							<td class="text-center"><?php echo DBConnection::Iset($row['AttendanceID'],"N/A")?></td>
                            <td class="text-center"><?php echo DBConnection::Iset($row['AttendanceDate'],"N/A")?></td>
                            <td class="text-center"><?php echo DBConnection::Iset($row['Signin'],"N/A")?></td>
                            <td class="text-center"><?php echo DBConnection::Iset($row['Lunch'],"N/A")?></td>
                            <td class="text-center"><?php echo DBConnection::Iset($row['Lunchout'],"N/A")?></td>
                            <td class="text-center"><?php echo DBConnection::Iset($row['Signout'],"N/A")?></td>
                    <?php 
					
				   }
					echo "</tr>" 
                    
                    ?>

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
    $(function(){
        $('#manage_leave').click(function(){
            uni_modal('<i class="fa fa-cog"></i> Manage Leave Credits of <?php echo $employeename; ?>','employees/manage_leave_type.php?id=<?php echo $id; ?>');
            
        })
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
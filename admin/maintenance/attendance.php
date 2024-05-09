<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>

<style>
    .img-avatar{
        width:45px;
        height:45px;
        object-fit:cover;
        object-position:center center;
        border-radius:100%;
    }
</style>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">List of Employees attendance</h3>
	</div>
	<div class="card-body">
		<div class="container-fluid">
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
						<th>Avatar</th>
						<th>Employee ID</th>
						<th>FullName</th>
						<th>Details</th>
						<th>View attendances</th>
					</tr>
				</thead>
				<tbody>
					<?php
					//Start
					$i = 1;
                    $qry = $conn->query("SELECT emp.*,
					dep.Name AS Departmentname,des.Name AS Designationname 
					FROM employee emp  
					LEFT JOIN designation des ON emp.DesignationID_FK = des.DesignationID
					LEFT JOIN department dep ON des.DepartmentID_FK = dep.DepartmentID;");

                    while($row = $qry->fetch_assoc())
                   {

							echo "<tr>"

				    ?>
						
							<td class="text-center"><?php echo $i++; ?></td>
							<td class="text-center"><img src="<?php echo validate_image($row['Avatar']);?>" class="img-avatar img-thumbnail p-0 border-2" alt="user_avatar"></td>
							
							<?php
							
								echo "<td>".$row['EmployeeID']."</td>".
								"<td>".$row['Fullname']."</td>"
							?>
							<td >
								<p class="m-0 ">
									<b>Department: </b><?php echo isset($row['Departmentname']) ? $row['Departmentname'] : 'N/A' ?><br>
									<b>Designation: </b><?php echo isset($row['Designationname']) ? $row['Designationname'] : 'N/A' ?><br>
								</p>
							</td>
							<td align="center">
                            <a href="?page=maintenance/view_attendance&id=<?php echo $row['EmployeeID'] ?>" class="btn btn-flat btn-primary">View attendances</a>
							<!-- <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		Action
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
								  	<a class="dropdown-item" href="?page=employees/records&id=<?php echo $row['EmployeeID'] ?>"><span class="fa fa-eye text-secodary"></span> View</a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item" href="?page=employees/manage_employee&id=<?php echo $row['EmployeeID'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
				                    <div class="dropdown-divider"></div>
									<a class="dropdown-item reset_password" href="javascript:void(0)" data-id="<?php echo $row['EmployeeID'] ?>"><span class="fa fa-key text-primary"></span> Reset Passwowrd</a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['EmployeeID'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
				                  </div> -->
							</td>
						
					<?php 
					
				   }
					echo "</tr>" ?>
				</tbody>
			</table>
		</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		
	})
	function delete_user($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Users.php?f=delete",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
	function reset_password($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=reset_password",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>
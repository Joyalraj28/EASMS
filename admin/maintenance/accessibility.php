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
		<h3 class="card-title">List of Employees</h3>
		<div class="card-tools">
			<a href="?page=employees/manage_employee" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Create New</a>
		</div>
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
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
                    $qry = $conn->query("SELECT 
					emp.*, 
					IF(ad.EmployeeID  IS NOT null,1,
					IF(ac.EmployeeID IS NOT null,2,3)) as login_type,
					IF(ad.EmployeeID  IS NOT null,ad.PriorityLevel,
					IF(ac.EmployeeID IS NOT null,ac.PriorityLevel,null)) as PriorityLevel,
					dep.Name AS Departmentname,
					des.Name AS Designationname 
					FROM admin ad 
					INNER JOIN accountant ac 
					LEFT JOIN employee emp ON ad.EmployeeID = emp.EmployeeID OR ac.EmployeeID = emp.EmployeeID 
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

							<td>
							<a class="dropdown-item" href="?page=maintenance/view_accessibility&id=<?php echo $row['EmployeeID'] ?>&login_type=<?php echo $row['login_type'] ?>"><span class="fa fa-eye text-secodary"></span> View</a>
							</td>
							<!-- <td align="center">
								 <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
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
				                  </div>
							</td> -->
						
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
</script>
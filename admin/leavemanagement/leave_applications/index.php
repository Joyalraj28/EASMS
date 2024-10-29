<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<?php 
// $meta_qry=$conn->query("SELECT * FROM employee where EmployeeID = '{$_settings->userdata('id')}' and meta_field = 'approver' ");
// $is_approver = $meta_qry->num_rows > 0 && $meta_qry->fetch_array()['meta_value'] == 'on' ? true : false;
?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">List of Applications</h3>
		<div class="card-tools">
			<a href="?page=leavemanagement/leave_applications/manage_application" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Create New</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-hover table-stripped">
				<?php if($_settings->userdata('type') != 3): ?>
				<colgroup>
					<col width="10%">
					<col width="25%">
					<col width="25%">
					<col width="15%">
					<col width="15%">
					<col width="10%">
				</colgroup>
				<?php else: ?>
					<colgroup>
						<col width="10%">
						<col width="50%">
						<col width="15%">
						<col width="15%">
						<col width="10%">
					</colgroup>
				<?php endif; ?>
				<thead>
					<tr>
						<th>#</th>
						<th>Employee</th>
						<th>Leave Type</th>
						<th>Days/Hours</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
						$where = '';
						// if($_settings->userdata('type') == 3)
						$where = (($_settings->userdata('login_type') == 1 && $_settings->userdata('AdminManageLeave')) || ($_settings->userdata('login_type') == 2 && $_settings->userdata('AccManageAttendance'))) ? "" : " and emp.EmployeeID = '{$_settings->userdata('EmployeeID')}' ";


						$qry = $conn->query("SELECT l.*,emp.EmployeeID,emp.Fullname,lt.ShortName,lt.TypeOfLeave,
													if(lt.TypeOfLeave=3,TIMESTAMPDIFF(HOUR,`EndDate`,`StartDate`),DATEDIFF(l.EndDate,l.StartDate)) as leave_days,
													lt.Description as lname from leaveapplication l inner join employee emp 
											on l.ApplyEmpID_FK=emp.EmployeeID inner join `leavetype` lt on lt.LeaveID = l.LeaveTypeID_FK 
											where (date_format(l.StartDate,'%Y') = '".date("Y")."' 
											or date_format(l.StartDate,'%Y') = '".date("Y")."') {$where} ");



						//if (isset($yourVariable) && is_array($yourVariable)):
						while($row = $qry->fetch_array()):
						
					?>

						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<?php if($_settings->userdata('type') != 3): ?>
							<th>
								<small><b>ID: </b><?php echo  DBConnection::Iset($row['EmployeeID'],'') ?></small><br>
								<small><b>Name: </b><?php echo DBConnection::Iset($row['Fullname'],'') ?></small>
							</th>
							<!-- <?php endif; ?> -->
							<td><?php echo DBConnection::Iset($row['ShortName'],'') . ' - '. DBConnection::Iset($row['lname'],'') ?></td>
							<td><?php echo  $row['leave_days'] .(isset($row['TypeOfLeave']) && $row['TypeOfLeave'] ==3 ? ' H':' D')  ?></td>
							<td class="text-center">
								<?php if(DBConnection::Iset($row['Status'],0) == 1): ?>
									<span class="badge badge-success">Approved</span>
								<?php elseif(DBConnection::Iset($row['Status'],0)  == 2): ?>
									<span class="badge badge-danger">Denied</span>
								<?php elseif(DBConnection::Iset($row['Status'],0)  == 3): ?>
									<span class="badge badge-danger">Cancelled</span>
								<?php else: ?>
									<span class="badge badge-primary">Pending</span>
								<?php endif; ?>
							</td>
							<td align="center">
								 <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		Action
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
								  	<a class="dropdown-item view_application" href="javascript:void(0)" data-id="<?php echo  $row['LeaveApplicationID'] ?>"><span class="fa fa-eye"></span> View</a>
				                    <div class="dropdown-divider"></div>
									<?php if($_settings->userdata('login_type') != 3): ?>
				                    <a class="dropdown-item update_status" href="javascript:void(0)" data-id="<?php echo $row['LeaveApplicationID'] ?>"><span class="fa fa-check-square"></span> Update Status</a>
				                    <div class="dropdown-divider"></div>
									<?php endif; ?>
									<?php if($_settings->userdata('login_type') != 3 || ($row['Status'] == '0') ): ?>
				                    <a class="dropdown-item" href="?page=leavemanagement/leave_applications/manage_application&id=<?php echo $row['LeaveApplicationID'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['LeaveApplicationID'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
									<?php endif; ?>
				                  </div>
							</td>
						</tr>
					
					<?php endwhile; ?>
					<?php //endif; ?>
				</tbody>
			</table>
		</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('.delete_data').click(function(){
			_conf("Are you sure to delete this Leave Application permanently?","delete_leave_application",[$(this).attr('data-id')])
		})
		$('.view_application').click(function(){
			uni_modal("<i class='fa fa-list'></i> Leave Application Details","leavemanagement/leave_applications/view_application.php?id="+$(this).attr('data-id'))
		})
		
		$('.update_status').click(function(){
			uni_modal("<i class='fa fa-check-square'></i> Update Leave Application Status","leavemanagement/leave_applications/update_status.php?id="+$(this).attr('data-id'))
		})
		$('.table').dataTable({
			columnDefs: [
				{ orderable: false, targets: [3,4] }
			]
		});
	})
	function delete_leave_application($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_leave_application",
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
<?php
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `leaveapplication` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
	
}

	$meta_qry = $conn->query("SELECT * FROM employee Where EmployeeID = '{$_settings->userdata('EmployeeID')}' ");
	$leave_type_ids = $conn->query("SELECT * FROM `leavetypeids` WHERE EmployeeID_FK = '{$_settings->userdata('EmployeeID')}' ")->fetch_array();
	
	
	

?>

<style>
	img#cimg{
		height: 25vh;
		width: 15vw;
		object-fit: scale-down;
		object-position: center center;
	}
	.select2-container--default .select2-selection--single{
		height:calc(2.25rem + 2px) !important;
	}
</style>
<div class="card card-outline card-info">
	<div class="card-header">
		<h3 class="card-title"><?php echo isset($id) ? "Update ": "Create New " ?> Leave Application</h3>
	</div>
	<div class="card-body">
		<form action="" id="leave_application-form">
			<input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
			<div class="row">
				<div class="col-6">
					<?php //if($_settings->userdata('type') != 3): ?>
					<div class="form-group">
						<label for="user_id" class="control-label">Employee</label>
						<input class="form-control form" data-placeholder="Please Select Employee here"  value="<?php echo $_settings->userdata('Fullname') ?>" readonly></select>
					</div>
					<?php //else: ?>
					<input type="hidden" name="ApplyEmpID_FK" value="<?php echo $_settings->userdata('EmployeeID') ?>">
					<?php //endif; ?>
					<div class="form-group">
						<label for="LeaveTypeID_FK" class="control-label">Leave Type</label>
						<select name="LeaveTypeID_FK" id="leave_type_id" class="form-control select2bs4 select2 rounded-0" data-placeholder="Please Select Leave  Type here" reqiured>
							<option value="" disabled <?php echo !isset($LeaveID) ? 'selected' : '' ?>></option>
							<?php 
							$where = '';
							
							$leave_type_ids = $conn->query("SELECT 
							empleave.EmployeeID_FK,
							empleave.leavetypeid,
							empleave.leavecredit, 
							empleave.DefultCredit,
							l.ShortName,
							l.Description 
							FROM `leavetypeids` empleave 
							LEFT JOIN leavetype l
							ON empleave.leavetypeid = l.LeaveID WHERE empleave.EmployeeID_FK = {$_settings->userdata('EmployeeID')}");
						
							// if(isset($leave_type_ids) && !empty($leave_type_ids))
							// {
							// 	$leaveIDrow = $leave_type_ids->fetch_assoc()['leavetypeid'];
							// 	if(isset($leaveIDrow) && !empty($leaveIDrow))
							// 	{
							// 		$where = "and id in (".implode(',',$leaveIDrow).")";
							// 	}
							// }
							// $lt = $conn->query("SELECT * FROM `leavetype` where Status = 1 {$where} order by `ShortName` asc");
							
							if(isset($leave_type_ids) && !empty($leave_type_ids)):
							while($row = $leave_type_ids->fetch_assoc()):
							?>
							    
								<option value="<?php echo $row['leavetypeid'] ?>" <?php echo (isset($LeaveID) && $LeaveID == $row['leavetypeid']) ? 'selected' : '' ?>><?php echo $row['ShortName'] ?></option>
							<?php endwhile; ?>
							<?php endif; ?>


						</select>


					</div>
					<div class="form-group">
						<label for="type" class="control-label">Day Type</label>
						<select id="type" name="type" class="form-control rounded-0">
							<option value="1" <?php echo (isset($type) && $type ==1)?'selected' : '' ?>>Whole Day</option>
							<option value="2" <?php echo (isset($type) && $type ==2)?'selected' : '' ?>>Half Day</option>
						</select>
					</div>
					<div class="form-group">
						<label for="StartDate" class="control-label">Date Start</label>
						<input type="datetime-local" id="StartDate" class="form-control form" required name="date_start" value="<?php echo isset($date_start) ? date("Y-m-d",strtotime($date_start)) : '' ?>">
					</div>
					<div class="form-group">
						<label for="EndDate" class="control-label">Date End</label>
						<input type="datetime-local" id="EndDate" class="form-control form" required name="date_end" value="<?php echo isset($date_end) ? date("Y-m-d",strtotime($date_end)) : '' ?>">
					</div>
					<div class="form-group">
						<label id='leave_days_label' for="leave_days" class="control-label">Days</label>
						<input type="number" id="leave_days" class="form-control form" name="leave_days" value="<?php echo isset($leave_days) ? $leave_days : 0 ?>" readonly min='1' max=''>
					</div>
					<div class="form-group">
							<label for="reason">Reason</label>
							<textarea rows="3" name="Reason" id="reason" class="form-control rounded-0" style="resize:none !important" required><?php echo isset($reason) ? $reason: '' ?></textarea>
						</div>
				</div>
			</div>
			
		</form>
	</div>
	<div class="card-footer">
		<button class="btn btn-flat btn-primary" form="leave_application-form">Save</button>
		<a class="btn btn-flat btn-default" href="?page=leave_applications">Cancel</a>
	</div>
</div>
<script>
	function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        	_this.siblings('.custom-file-label').html(input.files[0].name)
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}

	function calc_days(){
		var days = 0;

		//By defult
		$("#leave_days_label").html('Days')
		$("#leave_days").prop("readonly", true)
		$("#leave_days").prop("max", '')

		if($('#date_start').val() != ''){
			var start = new Date($('#date_start').val());
			var end = new Date($('#date_end').val());
			var diffDate = (end - start) / (1000 * 60 * 60 * 24);
			days = Math.round(diffDate);

		}
		if($('#type').val() == 2)
		{
			$('#leave_days').val('4')
			$("#leave_days_label").html('Hours')
			$("#leave_days").prop("readonly", false)
			$("#leave_days").prop("max", '4')
		}
		    
		else
			$('#leave_days').val(days +1)

	}
	$(document).ready(function(){
		$('.select2').select2();
		$('.select2-selection').addClass('form-control rounded-0')
		$('#type').change(function(){
			if($(this).val() == 2){
			console.log($(this).val())
				$('#leave_days').val('4')
				$('#date_end').attr('required',false)
				$('#date_end').val($('#date_start').val())
				$('#date_end').closest('.form-group').hide('fast')
			}else{
				$('#date_end').attr('reqiured',true)
				$('#date_end').closest('.form-group').show('fast')
				$('#leave_days').val(1)
			}
			calc_days()
		})
		$('#date_start, #date_end').change(function(){
			calc_days()
		})
		$('#leave_application-form').submit(function(e){
			e.preventDefault();
var _this = $(this)
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_application",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
				success:function(resp){
					if(typeof resp =='object' && resp.status == 'success'){
						location.href = "./?page=leave_applications";
					}else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            $("html, body").animate({ scrollTop: 0 }, "fast");
                            end_loader()
                    }else{
						alert_toast("An error occured",'error');
						end_loader();
                        console.log(resp)
					}
				}
			})
		})
	})
</script>
<?php



if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT *,DATEDIFF(EndDate,StartDate) as leave_days
	
	 from `leaveapplication` where LeaveApplicationID = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
	
}



  //echo $LeaveTypeID_FK;
	$id = isset($_GET['id'])? $_GET['id']:null;
    $empid = isset($ApplyEmpID_FK)  ?  $ApplyEmpID_FK : $_settings->userdata('EmployeeID');

	//$emp_arry = array();
	if(isset($empid))
	{
		$emp_qry = $conn->query("SELECT * FROM `employee` WHERE `EmployeeID` = '{$empid}' ");
		if($emp_qry->num_rows > 0){
			
			$emp_arry =	$emp_qry->fetch_array();
		}
	}
	$leave_type_ids = $conn->query("Call Pro_EmployeeLeavecreditsApplication('{$empid}')");
	

	
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
						<input class="form-control form" data-placeholder="Please Select Employee here"  value="<?php echo isset($id) ? $emp_arry['Fullname'] : $_settings->userdata('Fullname') ?>" readonly></select>
					</div>
					<?php //else: ?>
					<input type="hidden" name="ApplyEmpID_FK" value="<?php echo $empid ?>">
					<?php //endif; ?>
					<div class="form-group">
						<label for="LeaveTypeID_FK" class="control-label">Leave Type</label>
						<select name="LeaveTypeID_FK" id="leave_type_id" class="form-control select2bs4 select2 rounded-0" data-placeholder="Please Select Leave  Type here" reqiured>
							<!-- <option value="" disabled <?php echo !isset($LeaveTypeID_FK) ? 'selected' : '' ?>></option> -->
							<?php 
						

							if(isset($leave_type_ids) && !empty($leave_type_ids)):
								
								while($row = $leave_type_ids->fetch_assoc()):
								?>
									<option value="<?php echo $row['leavetypeid'].':'.$row['leavecredit'].':',$row['TypeOfLeave'] ?>" <?php echo (isset($LeaveTypeID_FK) && $LeaveTypeID_FK == $row['leavetypeid']) ? 'selected' : '' ?>><?php echo $row['ShortName'] ?></option>
								<?php endwhile; ?>
								<?php endif; ?>

						</select>


					</div>
					
					<div class="form-group">
						<label for="StartDate" class="control-label">Date Start</label>
						<input type="date" id="StartDate" class="form-control form" required name="StartDate" value="<?php echo isset($StartDate) ? date("Y-m-d",strtotime($StartDate)) : '' ?>" min='<?php echo date("Y-m-d") ?>'>
					</div>
					<div class="form-group">
						<label type='hidden' id='EndDatelable' for="EndDate" class="control-label">Date End</label>
						<input type="date" id="EndDate" class="form-control form" required name="EndDate" value="<?php echo isset($EndDate) ? date("Y-m-d",strtotime($EndDate)) : '' ?>">
					</div>

					<!-- <div class="form-group">
						<label for="type" class="control-label">Day Type</label>
						<select id="type" name="type" class="form-control rounded-0">
							<option value="1" <?php echo (isset($type) && $type ==1)?'selected' : '' ?>>Whole Day</option>
							<option value="2" <?php echo (isset($type) && $type ==2)?'selected' : '' ?>>Half Day</option>
						</select>
					</div> -->


					
					<!-- hidden -->
					<div class="form-group">
					    <!-- <input type="numbers" id="Max_leave_days" class="form-control form" name="Max_leave_days" value="0" readonly>	 -->
					    <label id='leave_days_label' for="leave_days" class="control-label">Days</label>
						<input type="number" id="leave_days" class="form-control form" name="leave_days" value="<?php echo isset($leave_days) ? $leave_days : 0 ?>" readonly min='1' max=''>
					</div>
					<div class="form-group">
							<label for="reason">Reason</label>
							<textarea rows="3" name="Reason" id="reason" class="form-control rounded-0" style="resize:none !important" required><?php echo isset($Reason) ? $Reason: '' ?></textarea>
					</div>

					
				</div>
			</div>
			
		</form>
	</div>
	<div class="card-footer">
		<button class="btn btn-flat btn-primary" form="leave_application-form">Save</button>
		<a class="btn btn-flat btn-default" href="?page=leavemanagement/leave_applications/">Cancel</a>
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

	//Set max leave type credit
	$(document).ready(function(){
		$('.select2').select2();
		$('.select2-selection').addClass('form-control rounded-0')

		ChangeLeaveType();

		function ChangeLeaveType()
		{
			var leavecredit = new Number($("#leave_type_id").val().split(':')[1]);

			var leaveid = new Number($("#leave_type_id").val().split(':')[0]);

			var leavetype = new Number($("#leave_type_id").val().split(':')[2]);

			var currentdate = new Date();

            var Avaliabledate = currentdate.getFullYear()+'-'+currentdate.getMonth()+'-'+ (currentdate.getDate() + leavecredit);

			$('#StartDate').attr('type','date');

			$('#EndDatelable').css('visibility','visible');
			$('#EndDate').attr('type','date');
			$("#leave_days").attr("readonly",true);
			$('#leave_days_label').html("Days");

			if(leavetype == 3)
			{
				$('#StartDate').attr('type','datetime-local');
				
				$('#EndDatelable').css('visibility','hidden');
				$('#EndDate').attr('type','hidden');

				$('#leave_days_label').html("Hours");
				$("#leave_days").val(2)
				$("#leave_days").attr("max",2);
				$("#leave_days").attr("readonly",false);
			}
			
			
			
			
			
			$('#Max_leave_days').val(leavecredit);
		}

        $("#leave_type_id").change(function(){
			
			ChangeLeaveType();
			
		});



	//Calulate days
	function calc_days(){
		var days = 0;

		//By defult
		// $("#leave_days_label").html('Days')
		// $("#leave_days").prop("readonly", true)
		// $("#leave_days").prop("max", '')


		// alert($('#StartDate').val() != '' +" > "+$('#EndDate').val() != '')
		if($('#StartDate').val() != '' && $('#EndDate').val() !=''){
			var start = new Date($('#StartDate').val());
			var end = new Date($('#EndDate').val());

			var diffDate = (end - start) / (1000 * 60 * 60 * 24);
			days = Math.round(diffDate);
			$('#leave_days').val(days);
		

		}
		
	}
	
	
	// $('#type').change(function(){

	// 		//Is sort leave
	// 		if($(this).val() == 2){
	// 		console.log($(this).val())
	// 			$('#leave_days').val('4')
	// 			$('#date_end').attr('required',false)
	// 			$('#date_end').val($('#date_start').val())
	// 			$('#date_end').closest('.form-group').hide('fast')
	// 		}
			
	// 		//annual leave or casual leave
	// 		else{
	// 			$('#date_end').attr('reqiured',true)
	// 			$('#date_end').closest('.form-group').show('fast')
	// 			$('#leave_days').val(1)
	// 		}
	// 		calc_days()
	// 	})


		$('#StartDate, #EndDate').change(function(){

			var leavetype = new Number($("#leave_type_id").val().split(':')[2]);

			if(leavetype != 3)
			{
				calc_days();
			}
		})



		//Submit form
		$('#leave_application-form').submit(function(e){
			e.preventDefault();
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
						location.href = "./?page=leavemanagement/leave_applications/";
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

<style>
	.select2-container--default .select2-selection--single{
		height:calc(2.25rem + 2px) !important;
	}
</style>
<?php 
if(isset($_GET['id']) && $_GET['id'] > 0){
    
	$meta_qry = $conn->query("SELECT * FROM employee where EmployeeID = '{$_GET['id']}' ");
	$meta = $meta_qry->fetch_assoc();
	$namearry =explode(" ", $meta['Fullname']); 
	$fname = isset($namearry[0]) ?$namearry[0]:'' ;
	$lname = isset($namearry[1]) ?$namearry[1]:'';

	$DepartmentID = $conn->query("SELECT dep.DepartmentID FROM designation des 
	LEFT JOIN department dep ON des.DepartmentID_FK = dep.DepartmentID
	WHERE des.DesignationID = {$meta['DesignationID_FK']}")->fetch_assoc()['DepartmentID'];

	$LointypeID = $conn->query("SELECT 
	IF(ad.EmployeeID  IS NOT null,1,
	IF(acc.EmployeeID IS NOT null,2,3)) as LointypeID
    FROM employee emp 
	LEFT JOIN admin ad ON  emp.EmployeeID = ad.EmployeeID
	LEFT JOIN accountant acc ON emp.EmployeeID = acc.EmployeeID WHERE emp.EmployeeID={$meta['EmployeeID']}")->fetch_assoc()['LointypeID'];


}


$department_qry = $conn->query("SELECT DepartmentID,Name FROM department");
$dept_arr = array_column($department_qry->fetch_all(MYSQLI_ASSOC),'Name','DepartmentID');
$designation_qry = $conn->query("SELECT DesignationID,Name FROM designation");
$desg_arr = array_column($designation_qry->fetch_all(MYSQLI_ASSOC),'Name','DesignationID');


?>
<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline card-primary">
	<div class="card-body">
		<div class="container-fluid">
			<div id="msg"></div>
			<form action="" id="manage-user">	
				<input type="hidden" name="id" value="<?php echo isset($meta['EmployeeID']) ? $meta['EmployeeID']: '' ?>">
				<input type="hidden" name="type" value="3">
				<div class="row">
					<div class="col-6">
						<div class="form-group">
					   <label for="employee_type">Employee type</label>
						<select name="employeetype" class="form-control">
                        	<option selected disabled >Select</option>
                        	<option value="1" <?php if(isset($LointypeID) && $LointypeID == 1): ?> selected="selected"<?php endif; ?>>Admin</option>
                        	<option value="2" <?php if(isset($LointypeID) && $LointypeID == 2): ?> selected="selected"<?php endif; ?>>Accountant</option>
                        	<option value="3" <?php if(isset($LointypeID) && $LointypeID == 3): ?> selected="selected"<?php endif; ?>>Employee</option>
                        </select>
						</div>


						<div class="form-group">
					   <label for="gender">Gender</label>
						<select name="gender" class="form-control">
                        	<option selected disabled require>Select</option>
                        	<option value="Male" <?php if(isset($meta['Gender']) && $meta['Gender'] == 'Male'): ?> selected="selected"<?php endif; ?>>Male</option>
                        	<option value="Female" <?php if(isset($meta['Gender']) && $meta['Gender'] == 'Female'): ?> selected="selected"<?php endif; ?>>Female</option>
                        </select>
						</div>


						<div class="form-group">
							<label for="firstname">First Name</label>
							<input placeholder="First Name" type="text" name="firstname" id="firstname" class="form-control rounded-0" value="<?php echo isset($fname) ? $fname: '' ?>" required>
						</div>

						<div class="form-group">
							<label for="lastname">Last Name</label>
							<input placeholder="Last Name" type="text" name="lastname" id="lastname" class="form-control rounded-0" value="<?php echo isset($lname) ? $lname: '' ?>" required>
						</div>


						<div class="form-group">
							<label for="dob">Date of birth</label>
							<input type="date" name="dob" id="dob" class="form-control rounded-0" value="<?php echo isset($meta['DOB']) ? date("Y-m-d",strtotime($meta['DOB'])): '' ?>" required>
						</div>

						
						<div class="form-group">

						    <?php 

							 if(isset($meta['EmployeeID']))
							 {
								$phonenoarry = array();
                                $phonenodata = $conn->query("SELECT * FROM `employeephoneno` WHERE EmployeeID_FK = {$meta['EmployeeID']} ORDER BY EmployeeID_FK;");
								
								if ($phonenodata->num_rows > 0) {

									// output data of each row
									while($row = $phonenodata->fetch_assoc()) {
										array_push($phonenoarry,$row['PhoneNo']);
									}

								}
							}

								
							?>

							<label for="phoneno1">Phone No 1</label>
							<input type="hidden" name="phonenoOld1" value="<?php echo isset($phonenoarry[0]) ? $phonenoarry[0]: '' ?>">
							<input placeholder="Phone No 1 (Required)" name="phoneno1" id="phoneno1" class="form-control rounded-0" value="<?php echo isset($phonenoarry[0]) ? $phonenoarry[0]: '' ?>" required>
							
							<label for="phoneno1">Phone No 2</label>
							<input type="hidden" name="phonenoOld2" value="<?php echo isset($phonenoarry[1]) ? $phonenoarry[1]: '' ?>">
							<input placeholder="Phone No 2 (Optional)"  name="phoneno2" id="phoneno2" class="form-control rounded-0" value="<?php echo isset($phonenoarry[1]) ? $phonenoarry[1]: '' ?>">
							
							<label for="phoneno2">Phone No 3</label>
							<input type="hidden" name="phonenoOld3" value="<?php echo isset($phonenoarry[2]) ? $phonenoarry[2]: '' ?>">
							<input placeholder="Phone No 3 (Optional)"  name="phoneno3" id="phoneno3" class="form-control rounded-0" value="<?php echo isset($phonenoarry[2]) ? $phonenoarry[2]: '' ?>">
						</div>



						
						<div class="form-group">
							<label for="address">Address</label>
							<textarea placeholder="Address" rows="3" name="address" id="address" class="form-control rounded-0" style="resize:none !important" required><?php echo isset($meta['Address']) ? $meta['Address']: '' ?></textarea>
						</div>
						<div class="form-group">
						<select name="status" id="status" class="form-control select2bs4 select2 rounded-0" data-placeholder="Please Staus" reqiured>
								<option value="" disabled <?php echo !isset($meta['Status']) ? 'selected' : '' ?>></option>
								<option value="1">Active</option>
								<option value="0">Deactive</option>
							</select>
						</div>

					</div>
					<div class="col-6">
						<div class="form-group">
							<label for="department_id">Department</label>
							<select name="department_id" id="department_id" class="form-control select2bs4 select2 rounded-0" data-placeholder="Please Select Department here" reqiured>
								<option value="" disabled <?php echo !isset($DepartmentID) ? 'selected' : '' ?>></option>
								<?php foreach($dept_arr as $k=>$v): ?>
									<option value="<?php echo $k ?>" <?php echo (isset($meta['department_id']) && $meta['department_id'] == $k) ? 'selected' : '' ?>><?php echo $v ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="form-group">
							<label for="designation_id">Designation</label>
							<select name="designation_id" id="designation_id" class="form-control select2bs4 select2 rounded-0" data-placeholder="Please Select Designation here" reqiured>
								<option value="" disabled <?php echo !isset($meta['designation_id']) ? 'selected' : '' ?>></option>
								<?php foreach($desg_arr as $k=>$v): ?>
									<option value="<?php echo $k ?>" <?php echo (isset($meta['DesignationID_FK']) && $meta['DesignationID_FK'] == $k) ? 'selected' : '' ?>><?php echo $v ?></option>
								<?php endforeach; ?>
							</select>
						</div>

						<div class="form-group">
							<label for="netsalary">Net salary</label>
							<input placeholder="Net salary" type="number" name="netsalary" id="netsalary" class="form-control rounded-0" value="<?php echo isset($meta['NetSalary']) ? $meta['NetSalary']: '0' ?>" required  autocomplete="off">
						</div>

						<div class="form-group">
							<label for="email">Email</label>
							<input placeholder="email" type="email" name="email" id="email" class="form-control rounded-0" value="<?php echo isset($meta['Email']) ? $meta['Email']: '' ?>" required  autocomplete="off">
						</div>


						<div class="form-group">
							<label for="password">Password</label>
							<input placeholder="password" type="password" name="password" id="password" class="form-control rounded-0" value="<?php echo isset($meta['Password']) ? $meta['Password']: '' ?>" required  autocomplete="off">
						</div>

						<div class="form-group">
							<label for="" class="control-label">Avatar</label>
							<div class="custom-file">
								<input type="hidden" name="avatar" value="<?php echo isset($meta['Avatar']) ? $meta['Avatar']: '' ?>">
							<input type="file" class="custom-file-input rounded-circle" id="customFile" name="img" onchange="displayImg(this,$(this))">
							<label class="custom-file-label" for="customFile">Choose file</label>
							</div>
						</div>
						<div class="form-group d-flex justify-content-center">
							<img src="<?php echo validate_image(isset($meta['Avatar']) ? $meta['Avatar'] :'') ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="card-footer">
			<div class="col-md-12">
				<div class="row">
					<button class="btn btn-sm btn-primary mr-2" form="manage-user">Save</button>
					<a class="btn btn-sm btn-secondary" href="./?page=employees">Cancel</a>
				</div>
			</div>
		</div>
</div>
<style>
	img#cimg{
		height: 15vh;
		width: 15vh;
		object-fit: cover;
		border-radius: 100% 100%;
	}
</style>
<script>


	$('#Addphoneno').click(function(){
		console.log($('#phoneno').val());

		$("#Phonenumber").append("<option>tt</option>")
	});

	function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}
	$('#manage-user').submit(function(e){
		e.preventDefault();
var _this = $(this)
		start_loader()
		$.ajax({
			url:_base_url_+'classes/Master.php?f=save_employee',
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
					location.href = './?page=employees/records&id='+resp.id;
				}else if(resp.status == 'failed' && !!resp.msg){
					var el = $('<div>')
						el.addClass("alert alert-danger err-msg").text(resp.msg)
						_this.prepend(el)
						el.show('slow')
						$("html, body").animate({ scrollTop: 0 }, "fast");
				}else{
					alert_toast("An error occured",'error');
					console.log(resp)
				}
                end_loader()
			}
		})
	})
	$(function(){
		$('.select2').select2()
		$('.select2-selection').addClass('form-control rounded-0')
	})

</script>
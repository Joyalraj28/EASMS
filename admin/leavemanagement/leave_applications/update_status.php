<?php
require_once('../../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `leaveapplication` where LeaveApplicationID = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
?>
<div class="continer-fluid">
    <form action="" id="update-status-form">
			<input type="hidden" name ="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
			<input type="hidden" name ="AprroveEmpID_FK" value="<?php echo $_settings->userdata('EmployeeID') ?>">
            <div class="form-group">
                <label for="status" class="control-label">Status</label>
                <select id="status" name="status" class="form-control rounded-0">
                    <option value="0" <?php echo (isset($Status) && $Status ==0)?'selected' : '' ?>>Pending</option>
                    <option value="1" <?php echo (isset($Status) && $Status ==1)?'selected' : '' ?>>Approved</option>
                    <option value="2" <?php echo (isset($Status) && $Status ==2)?'selected' : '' ?>>Deny</option>
                    <option value="3" <?php echo (isset($Status) && $Status ==3)?'selected' : '' ?>>Cancelled</option>
                </select>
            </div>
    </form>
</div>
<script>
    $(function(){
        $('#update-status-form').submit(function(e){
			e.preventDefault();
var _this = $(this)
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=update_status",
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
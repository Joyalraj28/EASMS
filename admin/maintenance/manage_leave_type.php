<?php
if(isset($_GET['id']) && $_GET['id'] > 0){
	require_once('../../config.php');
    $qry = $conn->query("SELECT * from `leavetype` where LeaveID = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
?>

<div class="container-fluid">
	<form action="" id="leave_type-form">
		<input type="hidden" name ="id" value="<?php echo isset($LeaveID) ? $LeaveID : '' ?>">
		<div class="form-group">
			<label for="Shortname" class="control-label">Shortname</label>
			<input name="Shortname" id="Shortname" type="text" class="form-control form  rounded-0" value="<?php echo isset($ShortName) ? $ShortName : ''; ?>" required/>
		</div>
		<div class="form-group">
			<label for="Description" class="control-label">Description</label>
			<textarea name="Description" id="Description" cols="30" rows="3" style="resize:none !important" class="form-control form no-resize rounded-0" required><?php echo isset($Description) ? $Description : ''; ?></textarea>
		</div>
		<div class="form-group">
			<label for="TypeOfLeave" class="control-label">Leave type</label>
			<select name="TypeOfLeave" id="TypeOfLeave" class="custom-select rounded-0" required>
				<option value="1" <?php echo isset($TypeOfLeave) && $TypeOfLeave == 1 ? "selected" : '' ?>>Annual Leave</option>
				<option value="2" <?php echo isset($TypeOfLeave) && $TypeOfLeave == 2 ? "selected" : '' ?>>Casual Leave</option>
				<option value="3" <?php echo isset($TypeOfLeave) && $TypeOfLeave == 3 ? "selected" : '' ?>>Short Leave</option>
			</select>
		</div>
		<div class="form-group">
			<label id='DefaultCredit-Lable' for="DefaultCredit" class="control-label"><?php echo isset($TypeOfLeave) && $TypeOfLeave == 3? "Default Credits (Hours)" : "Default Credits (Days)" ?></label>
			<input name="DefaultCredit" id="DefaultCredit" step="any" type="number" class="form-control form text-right col-5 rounded-0" value="<?php echo isset($DefaultCredit) ? $DefaultCredit : ''; ?>" max='14' required/>
		</div>
		<div class="form-group">
			<label for="status" class="control-label">Status</label>
			<select name="Status" id="status" class="custom-select rounded-0" required>
				<option value="1" <?php echo isset($Status) && $Status == 1 ? "selected" : '' ?>>Acitve</option>
				<option value="0" <?php echo isset($Status) && $Status == 0 ? "selected" : '' ?>>Inacitve</option>
			</select>
		</div>
	</form>
</div>
<script>
  
	$(document).ready(function(){


		TypeChange();
		

		$('#leave_type-form').submit(function(e){
			
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_leave_type",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					alert_toast("An error occured",'error');
					end_loader();
				},
				success:function(resp){
					
					if(typeof resp =='object' && resp.status == 'success'){
						location.reload();
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


		
			$("#TypeOfLeave").change(function() {
				TypeChange();

			});


		function TypeChange()
		{
			try { 
    (function($) {
			$("#DefaultCredit").attr("readonly",false);
			$("#DefaultCredit-Lable").html("Default Credits (Days)");
			if($("#TypeOfLeave").val()==1)
			{
			$("#DefaultCredit").attr('max',14)
			$("#DefaultCredit").val("14")
			}
			else if($("#TypeOfLeave").val()==2)
			{
				$("#DefaultCredit").attr('max',7)
				$("#DefaultCredit").val("7")
			}
			else if($("#TypeOfLeave").val()==3)
			{
				$("#DefaultCredit-Lable").html("Default Credits (Hours)");
				$("#DefaultCredit").attr('max',2)
				$("#DefaultCredit").val("2")
				$("#DefaultCredit").attr("readonly",true);
			}
		})(jQuery);
} catch(err) {  
    alert(err);
} 

		}

	})


	
		
</script>
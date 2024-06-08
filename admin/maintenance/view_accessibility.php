<?php if($_settings->chk_flashdata('success')): ?>
    <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
    </script>
<?php endif;?>



<style>
    .switch {
  position: relative;
  display: inline-block;
  width: 40px;
  height: 24px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 16px;
  width: 16px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(16px);
  -ms-transform: translateX(16px);
  transform: translateX(16px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 24px;
}

.slider.round:before {
  border-radius: 50%;
}

#ModuleName{
    font-size: 15px;
}
</style>

<?php 
if(isset($_GET['id']) && $_GET['id'] > 0){

    DBConnection::debugtaglog("Recordlog",$_GET['id']);

    //employee
	$meta_qry = $conn->query("SELECT emp.*,
    dep.Name AS Departmentname,des.Name AS Designationname 
    FROM employee emp  
    LEFT JOIN designation des ON emp.DesignationID_FK = des.DesignationID
    LEFT JOIN department dep ON des.DepartmentID_FK = dep.DepartmentID where emp.EmployeeID = '{$_GET['id']}' ");
	$row = $meta_qry->fetch_assoc();
    
    $employeename = $row['Fullname'];
    $id = $row['EmployeeID'];

    //employee phone no
    $phonenoarry = array();
    $phonenodata = $conn->query("SELECT * FROM `employeephoneno` WHERE EmployeeID_FK = {$_GET['id']} ORDER BY id;");
								
	if ($phonenodata->num_rows > 0) {
			// output data of each row
			while($prow = $phonenodata->fetch_assoc()) {
					array_push($phonenoarry,$prow['PhoneNo']);
			}
	}

    $phoneno1 = isset($phonenoarry[0]) ? $phonenoarry[0]: 'N/A' ;
    $phoneno2 = isset($phonenoarry[1]) ? $phonenoarry[1]: 'N/A' ;
    $phoneno3 = isset($phonenoarry[2]) ? $phonenoarry[2]: 'N/A' ;
    

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
<form id='Savebtn'>

        <input name="login_type" type="hidden" value="<?php echo isset($_GET['login_type']) ?>" />
        <input name="EmployeeID" type="hidden" value="<?php echo isset($_GET['id']) ?>" />
		<div class="card-tools">
        <a href="<?php echo base_url ?>classes/Master.php?f=save_employee_accessibility" class="btn btn-flat btn-danger"><span class="fas fa-times"></span> Cancel</a>
		<button  class="btn btn-flat btn-primary"><span class="fas fa-save"></span> Save</a>
		</div>
	</div>

    <div class="card-body">
        <div class="w-100 d-flex justify-content-end mb-3">
        </div>
        <div id="print_out">
        <table class="table info-table">
            <tr class='boder-0'>
                <td width="20%">
                    <div class="w-100 d-flex align-items-center justify-content-center">
                        <img src="<?php echo validate_image(isset($row['Avatar']) ? $row['Avatar'] : null) ?>" alt="Employee Avatar" class="img-thumbnail" id="cimg">
                    </div>
                </td>
                <td width="80%" class='boder-0 align-bottom'>
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex w-max-100">
                                <label class="float-left w-auto whitespace-nowrap">Employee ID:</label>
                                <p class="col-md-auto border-bottom border-dark w-100"><b><?php echo isset($row['EmployeeID']) ? $row['EmployeeID'] : "N/A" ?></b></p>
                            </div>
                            
                            <div class="d-flex w-max-100">
                                <label class="float-left w-auto whitespace-nowrap">Name:</label>
                                <p class="col-md-auto border-bottom border-dark w-100"><b><?php echo isset($row['Fullname']) ? $row['Fullname'] : "N/A" ?></b></p>
                            </div>
                            <div class="d-flex w-max-100">
                                <label class="float-left w-auto whitespace-nowrap">Email:</label>
                                <p class="col-md-auto border-bottom border-dark w-100"><b><?php echo isset($row['Email']) ? $row['Email'] : "N/A" ?></b></p>
                            </div>

                            <div class="d-flex w-max-100">
                                <label class="float-left w-auto whitespace-nowrap">Employee type</label>
                                <p class="col-md-auto border-bottom border-dark w-100"><b><?php echo isset($_GET['login_type']) ? $_GET['id'] == '1' ? "Admin" : "Accountant" : "N/A" ?></b></p>
                            </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <hr class="border-dark">
        <div class="row">
           
        
            <div class="col-md-8 col-sm-12">
                <div class="callout border-0">
                    <h5>Accessibility</h5>
                    <table class="table-stripped table">
                        <colgroup>
                                <col width="30%">
                                <col width="20%">
                                <col width="10%">
                                <col width="40%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th class="p-1">Accessibility</th>
                                <th class="p-1">Status</th>
                              
                            </tr>
                        </thead>
                        <tbody>

                            <?php


                            $row = $conn->query("SELECT * FROM ".( $_GET['login_type'] == 1? "Admin" :"accountant")." WHERE EmployeeID = ".$_GET['id'] )->fetch_assoc();
                           

                            foreach($row as $key => $item):
                            if($key == "EmployeeID")
                            {
                                continue;
                            }
                            ?>

                            <tr>
                                <td id="ModuleName"><?php echo $key ?> </td>
                          
                                <td><label class="switch">
                                    <input type="checkbox" name="<?php echo $key ?>" <?php echo $item == '1' ? "checked" : ""?>  >
                                    <span class="slider round"></span></label>
                                </td>
                            </tr>

                            <?php 
                            endforeach;?>
                            
                           
                        </tbody>
                    </table>
                </div>
            </div>
            </form>
        </div>
        </div>
    </div>
</div>

<script>

    $(function(){

        $('#Savebtn').submit(function(e){
			
            try { 
            
           
			e.preventDefault();
            var _this = $(this);
            console.log(new FormData($(this)[0]));
            alert(_base_url_);
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_employee_accessibility",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					alert_toast("An error occured",'error');
                    console.log("Error")
                    console.log(err)
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
            
        }
        catch(err)
        {
            alert(err)
        }
		})
        
    })
</script>
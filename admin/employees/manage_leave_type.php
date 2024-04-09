<?php 
require_once('../../config.php');
$meta_qry = $conn->query("SELECT * FROM employee where EmployeeID = '{$_GET['id']}' ");
$row = $meta_qry->fetch_assoc();


$Empleave_type_credits = $conn->query("SELECT `leavetypeid` as LeaveID, `leavecredit`, `DefultCredit` FROM `leavetypeids` WHERE `EmployeeID_FK` ='{$_GET['id']}'")->fetch_assoc();

$Empleave_type_credits = isset($Empleave_type_credits) ? $Empleave_type_credits: array();
?>
<div class="container-fluid">
    <form id="manage_emp_leave">
        <input type="hidden" name="user_id" value="<?php echo $_GET['id'] ?>">
        <table class="table">
            <colgroup>
                <col width="10%">
                <col width="70%">
                <col width="20%">
                <col width="20%">
            </colgroup>
            <thead>
                <tr>
                    <th class="py-1 px-1 text-center">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" id="selectAll">
                            <label for="selectAll">
                            </label>
                        </div>
                    </th>
                    <th class="px-2 py-1">Leave Type</th>
                    <th class="px-2 py-1">Leave Credits</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $lt = $conn->query("CALL `Pro_EmployeeLeavecredits`({$_GET['id']})");
                
                while($row=$lt->fetch_assoc()):

                   echo array_search($row['LeaveID'],$Empleave_type_credits); 
                ?>
                <tr>
                    <td class="text-center">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" class="check_item" id="select_<?php echo $row['LeaveID'] ?>" name="leave_type_id[]" value="<?php echo $row['LeaveID'] ?>" <?php echo isset($row['leavetypeid']) ? 'checked' : '' ?>>
                            <label for="select_<?php echo $row['LeaveID'] ?>">
                            </label>
                        </div>
                    </td>
                    <td><?php echo $row['ShortName']." - ".$row['Description'] ?></td>
                    <td>
                        <input type="number" step="any" name="leave_credit[]" value="<?php echo isset($row['leavetypeid']) ? $row['leavecredit'] : $row['DefaultCredit'] ?>" max='<?php echo isset($row['LeaveID']) ? $row['DefaultCredit'] : 0 ?>' class="form-control rounded-0">
                    </td>
                    <td>
                        <input type='hidden'  name="leave_default_credit[]" value="<?php echo isset($row['LeaveID']) ? $row['DefaultCredit'] : 0 ?>" class="form-control rounded-0">
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </form>
</div>
<script>
    function check_selected(){
        var count_item = $('input.check_item').length
        var checked_item = $('input.check_item:checked').length
        if(count_item == checked_item){
            $('#selectAll').attr('checked',true)
        }else{
            $('#selectAll').attr('checked',false)
        }
    }
    $(function(){
        $('input.check_item').each(function(){
            if($(this).is(':checked') == false){
                $(this).closest('tr').find('input[name="leave_credit[]"]').attr('disabled',true)
            }
            check_selected()
        })
        $('input.check_item').change(function(){
            if($(this).is(':checked') == true){
                $(this).closest('tr').find('input[name="leave_credit[]"]').attr('disabled',false)
            }else{
                $(this).closest('tr').find('input[name="leave_credit[]"]').attr('disabled',true)
            }
            check_selected()
        })
        $('#selectAll').change(function(){
            if($(this).is(':checked') == true){
                $('input.check_item').attr('checked',true).trigger('change')
            }else{
                $('input.check_item').attr('checked',false).trigger('change')
            }
        })

        $('#manage_emp_leave').submit(function(e){
            e.preventDefault();
var _this = $(this)
            start_loader()

            $.ajax({
                url:_base_url_+'classes/Master.php?f=save_emp_leave_type',
                method:'POST',
                data:$(this).serialize(),
                dataType:'json',
                error:err=>{
                    console.log(err)
                    alert_taost(' An error occured while saving the data','error')
                    end_loader()
                },
                success:function(resp){
                    if(resp.status == 'success'){
                        location.reload()
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
    })
</script>
<?php if($_settings->chk_flashdata('success')): ?>
    <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
    </script>
<?php endif;?>
<?php 
if(isset($_GET['id']) && $_GET['id'] > 0){

     $id = $_GET['id'];
    

    $StartDate =  isset($months['start_date']) ? $months['start_date']: '';
    $EndDate = isset($months['end_date']) ? $months['end_date']: "";

    //employee
	$meta_qry = $conn->query("SELECT emp.*,
    dep.Name AS Departmentname,des.Name AS Designationname 
    FROM employee emp  
    LEFT JOIN designation des ON emp.DesignationID_FK = des.DesignationID
    LEFT JOIN department dep ON des.DepartmentID_FK = dep.DepartmentID  where emp.EmployeeID = '{$_GET['id']}'");
	$row = $meta_qry->fetch_assoc();
    
    $employeename = $row['Fullname'];
    $id = $row['EmployeeID'];
   


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
		<h3 id='reporttitle' class="card-title"><?php echo  isset($row['Fullname']) ? 'List of Salarysheet for '.$row['Fullname'] : "N/A" ?></h3>
        <input id="id" type="hidden" value="<?php echo $id; ?>" />
    </div>
    <div class="card-body">
        <div id="print_out">
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
						<th>Month</th>
                        <th>View</th>
					</tr>
				</thead>
				<tbody>
					<?php
					//Start
					$i = 1;
                    $qry = $conn->query("SELECT DISTINCT MONTHNAME(`AttendanceDate`) as months FROM `attendance` WHERE `EmployeeID_FK` = ".$id."
                     ORDER BY AttendanceDate");

                    while($row = $qry->fetch_assoc())
                   {

							echo "<tr>"

				    ?>
						
							<td class="text-center"><?php echo $i++; ?></td>
							<td class="text-center"><?php echo DBConnection::Iset($row['months'],"N/A")?></td>
                            <td><a href="?page=maintenance/SelectSalarysheet&id=<?php echo $id ?>&month=<?php echo $row['months']  ?>&year=2024" class="btn btn-flat btn-primary">View</a></td>
                    <?php 
					
				   }
					echo "</tr>" 
                    
                    ?>

                    <?php if($qry->num_rows <=0 ): ?>
                        <tr>
                            <th class="text-center" colspan='6'> No Records.</th>
                        </tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
        
        </div>
    </div>
</div>

<script>

function getMonthNumber(monthName) {
    const monthNames = ["January", "February", "March", "April", "May", "June",
                        "July", "August", "September", "October", "November", "December"];
    const monthIndex = monthNames.indexOf(monthName);
    return monthIndex >= 0 ? (monthIndex + 1).toString().padStart(2, '0') : null;
}

function convertToMySQLDateTime(dateString) {
    const date = new Date(dateString);
    const mysqlDateTime = date.toISOString().slice(0, 19).replace('T', ' ');
    return mysqlDateTime;
}
    $(function(){
        $('#manage_leave').click(function(){
            uni_modal('<i class="fa fa-cog"></i> Manage Leave Credits of <?php echo $employeename; ?>','employees/manage_leave_type.php?id=<?php echo $id; ?>');
            
        })

        $("#year , #month").change(function(){

            var year = $('#year').val();
            var month = $('#month').val();

            if(year != 'All' && month != 'All')
            {

             
             const id = $('#id').val();
             const date = new Date(year, getMonthNumber(month) - 1); // JavaScript months are 0-indexed
             const startDate = new Date(date.getFullYear(), date.getMonth(), 1);
             const endDate = new Date(date.getFullYear(), date.getMonth() + 1, 0); // 0th day of next month is last day of current month
            
             $('#Apply').attr('href','?page=maintenance/view_attendance&id='+id+'&StartDate='+convertToMySQLDateTime(startDate)+'&EndDate='+convertToMySQLDateTime(endDate));

            }
           

        });


        

        $('#print').click(function(){
            start_loader()
            var _h = $('head').clone()
            var _p = $('#print_out').clone();
            var _el = $('<div>')

            var reporttitle = $('#reporttitle').html();
            console.log(reporttitle);
        

            _el.append(_h)
            _el.append('<style>html, body, .wrapper {min-height: unset !important;}.btn{display:none !important}</style>')
            _p.prepend('<div class="d-flex mb-3 w-100 align-items-center justify-content-center">'+
            '<img class="mx-4" src="<?php echo validate_image($_settings->info('logo')) ?>" width="50px" height="50px"/>'+
            '<div class="px-2">'+
            '<h3 class="text-center"><?php echo $_settings->info('name') ?></h3>'+
            '<h3 class="text-center">'+reporttitle+' <?php echo '('.date("Y") ?>)</h3>'+
            '</div>'+
            '</div><hr/>');
            _el.append(_p)
            var nw = window.open("","_blank","width=1200,height=1200")
                nw.document.write(_el.html())
                nw.document.close()
                setTimeout(() => {
                    nw.print()
                    setTimeout(() => {
                        nw.close()
                        end_loader()
                    }, 300);
                }, 500);
        })
    })
</script>
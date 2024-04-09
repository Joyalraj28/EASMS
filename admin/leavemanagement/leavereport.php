<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<?php 
$StartDate = isset($_GET['StartDate']) ? $_GET['StartDate'] : date("Y-m-d",strtotime(date('Y-m-d').' -3 days'));
$EndDate = isset($_GET['EndDate']) ? $_GET['EndDate'] : date("Y-m-d");
?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Reports</h3>
		<!-- <div class="card-tools">
			<a href="?page=offenses/manage_record" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Create New</a>
		</div> -->
	</div>
	<div class="card-body">
		<div class="">
        <div class="row">
            <div class="col-4">
                <div class="form-group">
                    <label for="StartDate" class="control-label">Date Start</label>
                    <input type="date" class="form-control" id="StartDate" value="<?php echo date("Y-m-d",strtotime($StartDate)) ?>">
                </div>
            </div>
            <div class="col-4">
            <div class="form-group">
                    <label for="EndDate" class="control-label">Date End</label>
                    <input type="date" class="form-control" id="EndDate" value="<?php echo date("Y-m-d",strtotime($EndDate)) ?>">
                </div>
            </div>
            <div class="col-2 row align-items-end pb-1">
                <div class="w-100">
                    <div class="form-group d-flex justify-content-between align-middle">
                        <button class="btn btn-flat btn-default bg-lightblue" type="button" id="filter"><i class="fa fa-filter"></i> Filter</button>
                        <button class="btn btn-flat btn-success" type="button" id="print"><i class="fa fa-print"></i> Print</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid" id="print_out">
			<table class="table table-hover table-stripped">
				<colgroup>
					<col width="5%">
					<col width="20%">
					<col width="20%">
					<col width="15%">
					<col width="10%">
					<col width="30%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Employee</th>
						<th>Leave Type</th>
						<th>Date</th>
						<th>Status</th>
						<th>Reason</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
                    $sql = "SELECT  l.*,emp.EmployeeID,emp.Fullname as name,
lt.Shortname, lt.Description as lname 
from `leaveapplication` l 
inner join `employee` emp on l.ApplyEmpID_FK=emp.EmployeeID inner join 
`leavetype` lt on lt.LeaveID = l.LeaveTypeID_FK where ((date(l.StartDate) BETWEEN 
'$StartDate' and '$EndDate') OR (date(l.EndDate) BETWEEN '$StartDate'  and '$EndDate') ) 
order by unix_timestamp(l.StartDate) asc,unix_timestamp(l.EndDate) asc";


						$qry = $conn->query($sql);
						while($row = $qry->fetch_assoc()):
                            // $lt_qry = $conn->query("SELECT meta_value FROM `employee_meta` where user_id = '{$row['user_id']}' and meta_field = 'employee_id' ");
							//$row['employee_id'] = ($lt_qry->num_rows > 0) ? $lt_qry->fetch_array()['meta_value'] : "N/A";
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td>
                                <small><b>ID: </b><?php echo $row['EmployeeID'] ?></small><br>
                                <small><b>Name: </b><?php echo $row['Description'] ?></small>
                            </td>
							<td><?php echo $row['Shortname'] ?> - <?php echo $row['lname'] ?></td>
							<td>
                            <?php
                                if($row['StartDate'] == $row['EndDate']){
                                    echo date("Y-m-d", strtotime($row['StartDate']));
                                }else{
                                    echo date("Y-m-d", strtotime($row['StartDate'])).' - '.date("Y-m-d", strtotime($row['EndDate']));
                                }
                            ?>
                            </td>
							<td class="text-center">
                            <?php if($row['Status'] == 1): ?>
                                <span class="badge badge-success mx-2">Approved</span>
                            <?php elseif($row['Status'] == 2): ?>
                                <span class="badge badge-danger mx-2">Denied</span>
                            <?php elseif($row['Status'] == 3): ?>
                                <span class="badge badge-danger mx-2">Cancelled</span>
                            <?php else: ?>
                                <span class="badge badge-primary mx-2">Pending</span>
                            <?php endif; ?>
                            </td>
							<td><small><?php echo $row['Reason'] ?></small></td>
						</tr>
					<?php endwhile; ?>
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
	$(document).ready(function(){
        $('#filter').click(function(){
            location.replace("./?page=reports&date_start="+($('#StartDate').val())+"&date_end="+($('#EndDate').val()));
        })

        $('#print').click(function(){
            start_loader()
            var _h = $('head').clone()
            var _p = $('#print_out').clone();
            var _el = $('<div>')
            _el.append(_h)
            _el.append('<style>html, body, .wrapper {min-height: unset !important;}</style>')
            var rdate = "";
            if('<?php echo $StartDate ?>' == '<?php echo $EndDate ?>')
                rdate = "<?php echo date("M d, Y",strtotime($StartDate)) ?>";
            else
                rdate = "<?php echo date("M d, Y",strtotime($StartDate)) ?> - <?php echo date("M d, Y",strtotime($EndDate)) ?>";
            _p.prepend('<div class="d-flex mb-3 w-100 align-items-center justify-content-center">'+
            '<img class="mx-4" src="<?php echo validate_image($_settings->info('logo')) ?>" width="50px" height="50px"/>'+
            '<div class="px-2">'+
            '<h3 class="text-center"><?php echo $_settings->info('name') ?></h3>'+
            '<h3 class="text-center">Leave Application Reports</h3>'+
            '<h4 class="text-center">as of</h4>'+
            '<h4 class="text-center">'+rdate+'</h4>'+
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
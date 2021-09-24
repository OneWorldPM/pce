
<div class="main-content" >
<!--    --><?php //      print_r($resouces_logs); ?>
    <div class="wrap-content container" id="container">
        <form name="frm_credit" id="frm_credit" method="POST" enctype="multipart/form-data">
            <div class="container-fluid container-fullw bg-white">
                <div class="row">
                        <table class="table table-striped table-bordered" id="resource_logs_table">

                            <label style="font-size: 18px">  OVERALL RESOURCE DOWNLOADS : <?= isset($resouces_logs) && !empty($resouces_logs) ? COUNT($resouces_logs):''?></label><br>
                            <label style="font-size: 18px">  UNIQUE USER DOWNLOADS : <?= isset($unique_resource_downloads) && !empty($unique_resource_downloads) ? COUNT($unique_resource_downloads):''?></label>
                            <a href="<?=base_url().'admin/sessions/exportResourceLogs/'.$session_id?>" class="btn btn-success btn-sm"> Export Logs </a>
                            <thead>
                                <th>#</th>
                                <th>Download Date</th>
                                <th>File Name</th>
                                <th>Attendee Name</th>
                            </thead>
                            <tbody>

                            <?php
                            if (isset($resouces_logs) && !empty($resouces_logs)){
                                foreach ($resouces_logs as $index=> $log){
                                ?>
                            <tr>
                                <td><?=($index+1)?></td>
                                <td><?=($log->date_time)?></td>
                                <td><?=($log->file_name)?></td>
                                <td><?=($log->attendee)?></td>
                            </tr>
                              <?php }
                            }?>

                            </tbody>

                        </table>
                </div>
            </div>
        </form>
        <!-- end: DYNAMIC TABLE -->
    </div>
</div>

</div>

<?php
$msg = $this->input->get('msg');
switch ($msg) {
    case "S":
        $m = "Session Resources Added Successfully...!!!";
        $t = "success";
        break;
    case "U":
        $m = "Session Resources Updated Successfully...!!!";
        $t = "success";
        break;
    case "D":
        $m = "Session Resources Delete Successfully...!!!";
        $t = "success";
        break;
    case "E":
        $m = "Something went wrong, Please try again!!!";
        $t = "error";
        break;
    default:
        $m = 0;
        break;
}
?>

<script>

$(function(){
    $("#resource_logs_table").dataTable({
        "pageLength": 25,
        "columnDefs": [
            { "width": "40%", "targets": 1 }
        ],
    });
})

</script>







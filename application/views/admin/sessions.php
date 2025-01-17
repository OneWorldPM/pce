<?php
$user_role = $this->session->userdata('role');
?>

<div class="main-content">
    <div class="wrap-content container" id="container">
        <!-- start: PAGE TITLE -->
        <section id="page-title">
            <div class="row">
                <div class="col-sm-8">
                    <h1 class="mainTitle">List Of Sessions</h1>
                </div>
            </div>
        </section>
        <!-- end: PAGE TITLE -->
        <!-- start: DYNAMIC TABLE -->
        <div class="container-fluid container-fullw">
		    <div class="row">
                <div class="panel panel-primary" id="panel5">
                    <div class="panel-heading">
                        <h4 class="panel-title text-white">Filter Data</h4>
                        <div class="panel-tools">
                            <a data-original-title="Collapse" data-toggle="tooltip" data-placement="top" class="btn btn-transparent btn-sm panel-collapse" href="#"><i class="ti-minus collapse-off"></i><i class="ti-plus collapse-on"></i></a>
                        </div>
                    </div>
                    <div class="panel-body bg-white" style="border: 1px solid #b2b7bb!important;">
                        <form action="<?= base_url() ?>admin/sessions/filter" name="filter_frm" id="filter_frm" method="POST">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Date Range:</label>
                                         <div class="input-group input-daterange datepicker">
                                            <input type="text" placeholder="Start Date" name="start_date" value="<?= ($this->session->userdata('start_date') != "") ? date("m/d/Y",strtotime($this->session->userdata('start_date'))) : ""  ?>" id="from_date" class="form-control">
                                            <span class="input-group-addon bg-green">to</span>
                                            <input type="text" placeholder="End Date" name="end_date" value="<?= ($this->session->userdata('end_date') != "") ? date("m/d/Y",strtotime($this->session->userdata('end_date'))) : ""  ?>" id="to_date" class="form-control">
                                        </div>
                                        <input type="submit" name="btn_today" class="btn btn-green" style="margin-top: 22px;" id="filter_btn" value="Today">
                                        <input type="submit" name="btn_tomorrow" class="btn btn-green" style="margin-top: 22px;" id="filter_btn" value="Tomorrow">
                                        
                           
                                    </div>
                                </div>
                                <input type="button" onclick="location.href='<?php echo base_url();?>admin/sessions/archive_session'" name="archive_session" class="btn btn-info" style="margin-top: 90px;margin-right:10px;float:right" id="archive_session" value="Archived Sessions">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Session Type:</label>
                                        <select name="session_type" id="session_type" class="form-control">
                                            <option value="">Select</option>
                                            <?php
                                            if (!empty($session_types)) {
                                                foreach ($session_types as $type) {
                                                    if ($type->sessions_type != '') {
                                                        ?>
                                                        <option value="<?= $type->sessions_type_id ?>"><?= $type->sessions_type ?></option>
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>
                                        
                                    </div>
                                      </div>
                                      
                                <div class="col-md-1">
                                    <input type="submit" name="filter_btn" class="btn btn-green" style="margin-top: 22px;" id="filter_btn" value="Submit">
                                </div>
                                <div class="col-md-2">
                                    <a href="<?= base_url() ?>admin/sessions/filter_clear" class="btn btn-danger" style="margin-top: 22px;">Clear</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="panel panel-primary" id="panel5">
                    <div class="panel-heading">
                        <h4 class="panel-title text-white">Sessions
                            <?= ($this->session->userdata('session_viewing'))?'| Now Viewing: '.$this->session->userdata('session_viewing'):''; ?></h4>
                    </div>
                    <div class="panel-body bg-white" style="border: 1px solid #b2b7bb!important;">
                        <?php if ($user_role == 'super_admin') { ?>
                        <h5 class="over-title margin-bottom-15">
                            <a href="<?= base_url() ?>admin/sessions/add_sessions" class="btn btn-green add-row">
                                Add Sessions  &nbsp;<i class="fa fa-plus"></i>
                            </a>
                        </h5>
                        <?php } ?>
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <table class="table table-bordered table-striped text-center " id="sessions_table">
                                    <thead class="th_center">
                                        <tr>
                                            <th style="padding-left:60px;padding-right:60px">Time Slot</th>
                                            <th style="padding-left:30px;padding-right:40px">Date</th>
                                            <th style="padding:0">Uni<br>que<br>Ide<br>nti<br>fier</th>
                                            <th>CCO Event ID</th>
                                            <th>Photo</th>
                                            <th>Title</th>
                                            <th>Presenters</th>
                                            <th>Moderators</th>
                                            <th>Stream<br>Name</th>
                                            <th style="padding:0">Pre<br>sen<br>ter<br>PPT<br>Up<br>load<br>ed</th>
                                            <th>Session Notes</th>
                                            <th style="white-space: nowrap; padding-left:40px;padding-right:60px">Other Info</th>
                                            <th style="border-right: 0px solid #ddd;">Action</th>
                                            <th style="border-left: 0px solid #ddd; border-right: 0px solid #ddd;"></th>
                                            <th style="border-left: 0px solid #ddd;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($sessions) && !empty($sessions)) {
                                            foreach ($sessions as $val) {
                                                $toolboxItems = explode(',', $val->right_bar);
                                                ?>
                                                <tr style="background: <?=($val->session_ended == 0)?'#f1fff1':'#fbe9e9'?>;">
                                                     <td><?= date("h:i A", strtotime($val->time_slot)) . ' - ' . date("h:i A", strtotime($val->end_time)) ?></td>
                                                    <td><?= date("Y-m-d", strtotime($val->sessions_date)) ?></td>
                                                    <td><?= $val->sessions_id ?></td>
                                                    <td><?= $val->cco_envent_id ?></td>
                                                    <td>
                                                        <?php if ($val->sessions_photo != "") { ?>
                                                            <img src="<?= base_url() ?>uploads/sessions/<?= $val->sessions_photo ?>" style="height: 40px; width: 40px;">
                                                        <?php } else { ?>
                                                            <img src="<?= base_url() ?>front_assets/images/session_avtar.jpg" style="height: 40px; width: 40px;">
                                                        <?php } ?>    
                                                    </td>
                                                    <td><?= $val->session_title ?></td>
                                                    <td>
                                                        <?php
                                                        //print_r($val->presenter);
                                                        if (isset($val->presenter) && !empty($val->presenter)) {
                                                            foreach ($val->presenter as $value) {
                                                                $pres_count=count($val->presenter);
                                                                echo $value->presenter_name .'<span> '.$value->degree.'</span>'. "<br>($value->email)<br>";
                                                            } 
                                                        }else{
                                                            $pres_count=0;
                                                        }
                                                        if (isset($val->groupchatPresenter) && !empty($val->groupchatPresenter)) {
                                                       
                                                            foreach ($val->groupchatPresenter as $name) {
                                                              
                                                             $groupPresCount=count($val->groupchatPresenter);
                                                           
                                                            }
                                                        }else{
                                                            $groupPresCount=0;
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if (isset($val->moderators) && !empty($val->moderators)) {
                                                            foreach ($val->moderators as $name) {
                                                                $mod_count=count($val->moderators);
                                                                echo $name . " <br>";
                                                            }      
                                                        }else{
                                                            $mod_count=0;
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php if (isset($val->embed_html_code)&& !empty($val->embed_html_code)){
                                                        if (strlen($val->embed_html_code)>19){
                                                          echo preg_replace('/([^\s]{10})(?=[^\s])/', '$1'.'</br>', $val->embed_html_code);
                                                        }
                                                        else{
                                                            echo $val->embed_html_code.'<br><hr>';
                                                        }
                                                       
                                                           
                                                    }else{
                                                        echo "";
                                                    }

                                                    if(isset($val->get_stream_name) && !empty ($val->get_stream_name)){
                                                        echo $val->get_stream_name[0]->name;
                                                    }

                                                        ?>
                                                    </td>
                                                    <td><?=(isset($val->embed_html_code_presenter) && !empty($val->embed_html_code_presenter))? 'Yes':'<i style="color:red">X</i>'?> </td>
                                                    <td> <?=(isset($val->session_notes) && !empty($val->session_notes))?$val->session_notes:''?></td>
                                                    <td>

                                                        <span style="float:left">  Claim Link: </span><span style="float:right"><i class="fa fa-circle" aria-hidden="true" style="color: <?=($val->attendee_view_links_status == 1)?'#0ab50a':'#ff2525'?>;"></i></span><br>
                                                        <span style="float:left"> Toolbox:</span><span style="float:right"> <i class="fa fa-circle" aria-hidden="true" style="color: <?=($val->tool_box_status == 1)?'#0ab50a':'#ff2525'?>;"></i></span><br>
                                                        <hr/>
                                                        <small><span style="float: left;">Questions</span> <i class="fa fa-circle" aria-hidden="true" style="color: <?=(in_array("questions", $toolboxItems))?'#0ab50a':'#ff2525'?>;float: right;"></i></small><br>
                                                        <small><span style="float: left;">Resources</span> <i class="fa fa-circle " aria-hidden="true" style="color: <?=(in_array("resources", $toolboxItems))?'#0ab50a':'#ff2525'?>;float: right;"></i></small><br>
                                                        <small><span style="float: left;">Attendee Chat</span> <i class="fa fa-circle " aria-hidden="true" style="color: <?=(in_array("chat", $toolboxItems))?'#0ab50a':'#ff2525'?>;float: right;"></i></small><br>
                                                        <small><span style="float: left;">Notes</span> <i class="fa fa-circle " aria-hidden="true" style="color: <?=(in_array("notes", $toolboxItems))?'#0ab50a':'#ff2525'?>;float: right;"></i></small><br>
                                                        <small><span style="float: left;">Ask A Rep</span> <i class="fa fa-circle " aria-hidden="true" style="color: <?=(in_array("askarep", $toolboxItems))?'#0ab50a':'#ff2525'?>;float: right;"></i></small><br>

                                                        <br>

                                                        <?php $total=$mod_count+$pres_count;?>
                                                        <small><span style="float: left;">Presenters + Moderators </span> <?= (isset($total) && !empty($total) ) ?'<span style="float:right">'. $total : "".'</span>' ?></small><br>
                                                        <?php if(isset($val->getChatAll) && !empty($val->getChatAll)){
                                                         foreach ($val->getChatAll as $value ){
                                                            $chatModCount=explode(',',($value->moderator_id));
                                                            $chatPresCount=explode(',',($value->presenter_id));
                                                            $sessionChatCount = count  ($chatModCount)+count  ($chatPresCount);
                                                            if ($value->status=='1'){
                                                                ?><small><span style="float: left;">Host Chat Participants</span><span style="float:right"><?=$sessionChatCount.'</span>'?></small><br><?php
                                                            }
                                                        }}?>
                                                            <hr style="width:100%;height:2px"> 
                                                         <?php if(isset($val->getChatAll) && !empty($val->getChatAll)){
                                                         foreach ($val->getChatAll as $value ){
                                                            $chatModCount=explode(',',($value->moderator_id));
                                                            $chatPresCount=explode(',',($value->presenter_id));
                                                            $sessionChatCount = count  ($chatModCount)+count  ($chatPresCount);
                                                            ?>
                                                        <small><?= (isset($value) && !empty($value)) ?'<span style="float: left;">Host Chat: '.$sessionChatCount.'/'.$total:""  ?></span><strong><span style="float:right;color:<?=($value->status==1)?'green':(($value->status==0)?'orange':'red')?>"><?=($value->status==1)?'Open':(($value->status==0)?'Pending':'Closed')?></small></span></strong><br>
                                                        <?php
                                                         } 
                                                        }
                                                         ?>
                                                    </td>
                                                    <td>
													  <a href="<?= base_url() ?>admin/sessions/view_session/<?= $val->sessions_id ?>" class="btn btn-info btn-sm" style="margin-bottom: 5px;">View</a>
                                                        <a href="<?= base_url() ?>admin/sessions/edit_sessions/<?= $val->sessions_id ?>" class="btn btn-green btn-sm">Edit</a>
                                                        <?php if ($user_role == 'super_admin') { ?>
                                                        <button class="reload-attendee btn btn-danger" app-name="<?=getAppName($val->sessions_id) ?>">Reload Attendee</button>
                                                        <button class="subsequent_session_redirect btn btn-success margin-top-5" app-name="<?=getAppName($val->sessions_id)?>" session-id="<?=$val->sessions_id?>">Redirect</button>
                                                        <?php } ?>
                                                    </td>
                                                    <td>
														<a href="<?= base_url() ?>admin/sessions/view_poll/<?= $val->sessions_id ?>" class="btn btn-info btn-sm" style="margin-bottom: 5px;">Polls</a>
                                                        <?php if ($user_role == 'super_admin') { ?>
                                                        <a href="<?= base_url() ?>admin/sessions/view_question_answer/<?= $val->sessions_id ?>" class="btn btn-green btn-sm" style="margin-bottom: 5px;">View Q&A</a>
                                                        <a href="<?= base_url() ?>admin/sessions/report/<?= $val->sessions_id ?>" class="btn btn-grey btn-sm" style="margin-bottom: 5px;">Report</a>
                                                        <?php } ?>
                                                        <a href="<?= base_url() ?>admin/groupchat/sessions_groupchat/<?= $val->sessions_id ?>" class="btn btn-blue btn-sm" style="margin-bottom: 5px;">Create Chat</a>
                                                        <a href="<?= base_url() ?>admin/sessions/resource/<?= $val->sessions_id ?>" style="margin-bottom: 5px;" class="btn btn-success btn-sm" >Resources</a>
                                                        <a href="<?= base_url() ?>admin/sessions/resourceLogs/<?= $val->sessions_id ?>" style="margin-bottom: 5px;" class="btn btn-light-orange btn-sm" >Resources Logs</a>
                                                    </td>
                                                    <td>
                                                         <?php if(isset($val->check_send_json_exist) && !empty($val->check_send_json_exist)){
                                                                foreach ($val->check_send_json_exist as $status) {
                                                                    if ($status->send_json_status==1) {
                                                                        ?>
                                                                         <a data-session-id="<?= $val->sessions_id ?>" class="btn btn-purple btn-sm send-json" style="margin-bottom: 5px;">JSON Sent</a>
                                                                        <?php
                                                                    } else {
                                                                        ?>  <a data-session-id="<?= $val->sessions_id ?>" href="<?= base_url() ?>admin/sessions/send_json/<?= $val->sessions_id ?>" class="btn btn-success btn-sm" style="margin-bottom: 5px;">Send JSON</a><?php
                                                                    }
                                                                }
                                                         }?>
                                                         <a href="<?= base_url() ?>admin/sessions/view_json/<?= $val->sessions_id ?>" class="btn btn-purple btn-sm" style="margin-bottom: 5px;">View JSON</a>
                                                        <?php if ($user_role == 'super_admin') { ?>
                                                            <button href-url="<?= base_url() ?>admin/sessions/reset_sessions/<?= $val->sessions_id ?>" session-name="<?= $val->session_title ?>" style="margin-bottom: 5px;"  class="clear-json-btn btn btn-danger btn-sm">Clear JSON</button>
                                                        <?php } ?>
                                                        <?php if ($user_role == 'super_admin') { ?>
                                                            <a data-session-id="<?= $val->sessions_id ?>" class="btn btn-danger btn-sm delete_session"  style="font-size: 10px !important; margin-bottom: 5px;">Delete Session</a>
                                                        <?php } ?>
                                                        <br><br>
														 <a href="<?= base_url() ?>admin/sessions/flash_report/<?= $val->sessions_id ?>" style="margin-bottom: 5px;" class="btn btn-info btn-sm">Flash Report</a>
                                                         <a href="<?= base_url() ?>admin/sessions/polling_report/<?= $val->sessions_id ?>" class="btn btn-azure btn-sm" style="margin-bottom: 5px;">Polling Report</a><br>
                                                         <a href="<?= base_url() ?>admin/sessions/attendee_question_report/<?= $val->sessions_id ?>" style="margin-bottom: 5px;" class="btn btn-azure btn-sm">Questions Report</a>
                                                        <a href="<?= base_url() ?>admin/sessions/ask_rep_report/<?= $val->sessions_id ?>" class="btn btn-yellow btn-sm">Ask A Rep Report</a>
                                                        <?php if ($user_role == 'super_admin') { ?>
                                                            <br><br><a data-session-id="<?=$val->sessions_id?>" data-session-name="<?=$val->session_title?>" data-session-status="<?=$val->session_ended?>" class="btn <?=($val->session_ended == 0)?'btn-danger':'btn-success'?> end_session"  style="font-size: 15px !important; margin-bottom: 5px;"><?=($val->session_ended == 0)?'<i class="fa fa-stop-circle-o" aria-hidden="true"></i> End Session':'<i class="fa fa-play-circle-o" aria-hidden="true"></i> Open Session'?></a>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@9.17.0/dist/sweetalert2.all.min.js"></script>

<?php
$msg = $this->input->get('msg');
$m;
$t;
switch ($msg) {
    case "S":
        $m = "Successfully Cleared";
        $t = "success";
        break;
    case "A":
        $m = "Successfully Added";
        $t = "success";
        break;
    case "D":
        $m = "Successfully Deleted";
        $t = "success";
        break;
    case "E":
        $m = "Something went wrong, Please try again!!!";
        $t = "error";
        break;
    case "JS":
        $m = "Json Sent";
        $t = "success";
        break;
    case "JE":
        $m = "Something went wrong, Please try again!!!";
        $t = "error";
        break;
    default:
        $m = 0;
        break;
}
?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#sessions_table").dataTable({
            "ordering": false,
            "columnDefs": [
                { "width": "10%", "targets": 7 },
                { "width": "8%", "targets": 8 },
                { "width": "10%", "targets": 9 }
            ]
        });
  $('.datepicker').datepicker();
   
        //====== session delete =======//
        $('#sessions_table').on("click", ".delete_session", function () {
            var sesionId = $(this).data("session-id");
            alertify.confirm("Are you sure you want to delete this session?", function (e) {
                if (e)
                {
                    $.post("<?= base_url() ?>admin/sessions/delete_sessions",{"sesionId":sesionId},function (response){
                        if(response=="success"){
                            alertify.success('Session Deleted!');
                            location.reload();
                        }
                    });
                }
            });
        });
        
<?php if (isset($msg) && isset($t) && isset($m)): ?>
            alertify.<?= $t ?>("<?= $m ?>");
<?php endif; ?>

    $('.reload-attendee').on('click', function () {
        socket.emit('reload-attendee', $(this).attr('app-name'));
    });

        $('#sessions_table').on('click', '.subsequent_session_redirect', function () {

            Swal.fire({
                title: 'Are you sure?',
                html: "This will either redirect the attendee to the subsequent session or open a pop-up asking where to go<br>(Regardless the session is over or not)",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, proceed!'
            }).then((result) => {
                if (result.isConfirmed)
                {
                    socket.emit('subsequent-session-redirect', $(this).attr('app-name'));
                    alertify.success('Redirection initiated!');
                }
            })

        });

    $('#sessions_table').on('click', '.clear-json-btn', function () {

        let session_name = $(this).attr('session-name');
        let href = $(this).attr('href-url');

        Swal.fire({
            title: 'Are you sure?',
            text: "This will delete all data collected from users on this session("+session_name+"), you won't be able to revert this action!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.open(href, "_self");
            }
        })
    });

        $('#sessions_table').on('click', '.end_session', function () {

            let session_id = $(this).data('session-id');
            let session_name = $(this).data('session-name');
            let status = ($(this).data('session-status') == 1)?0:1;
            let info_text;
            let buton_text;
            let button = $(this);
            let row = $(this).parent().parent();

            if (status == 1)
            {
                buton_text = 'Yes, end it!';
                info_text = "This will end session ("+session_name+"), further visits to this session will take attendees to the next session configured! <br><br> This does not redirect attendees or reload their page though";
            }
            else{
                buton_text = 'Yes, open it!';
                info_text = "This will open session ("+session_name+") <br><br> This does not redirect attendees or reload their page though";
            }

            Swal.fire({
                title: 'Are you sure?',
                html: info_text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: buton_text
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post("<?= base_url() ?>admin/sessions/change_session_status",
                        {
                            "id":session_id,
                            "status": status
                        },
                        function (response){
                            response = JSON.parse(response);
                            if(response.status == "success"){

                                if(status == 1)
                                {
                                    button.html('<i class="fa fa-play-circle-o" aria-hidden="true"></i> Open Session');
                                    button.removeClass('btn-danger');
                                    button.addClass('btn-success');
                                    button.data('session-status', 1);
                                    row.css('background', '#fbe9e9');
                                } else {
                                    button.html('<i class="fa fa-stop-circle-o" aria-hidden="true"></i> End Session');
                                    button.removeClass('btn-success');
                                    button.addClass('btn-danger');
                                    button.data('session-status', 0)
                                    row.css('background', '#f1fff1');
                                }

                                Swal.fire(
                                    'Done!',
                                    'Session status changed!',
                                    'success'
                                )
                            }else{
                                Swal.fire(
                                    'Error!',
                                    'Unable to change session status!',
                                    'error'
                                )
                            }
                    });
                }
            })
        });

    // This will confirm to send JSON if already sent
$('#sessions_table').on('click','.send-json', function () {

let sesionId = $(this).data("session-id");
    console.log(sesionId);
let href = $(this).attr('href-url');

Swal.fire({
    title: 'Are you sure?',
    text: "This will resend the Json in this session!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, Resend it!'
}).then((result) => {
    if (result.isConfirmed) {
        window.location.href = "<?=base_url()?>admin/sessions/send_json/"+sesionId;
    }
})

});
//
    });
</script>

<link href="<?= base_url() ?>assets/css/attendee-session-view.css?v=202" rel="stylesheet">

<!-- Please add styles only in this CSS file, NOT directly on this HTML file -->
<link href="<?= base_url() ?>front_assets/css/view_sessions.css?v=21" rel="stylesheet">


<section class="parallax" style="background: url('<?= base_url() ?>front_assets/images/pres_bg.jpg') no-repeat;">
    <!--<section class="parallax" style="background-image: url(<?= base_url() ?>front_assets/images/Sessions_BG_screened.jpg); top: 0; padding-top: 0px;">-->
    <div class="container-fullscreen">
        <!-- CONTENT -->
        <section class="content">
            <div>
                <div class="videContent">

                    <?php if (1==2) { ?>
                        <div style="background-color: #B2B7BB;">
                            <h3 class="videoTitle" style="margin-bottom: 2px; margin-left: 10px; color: #fff; font-weight: 700; text-transform: uppercase;"><?= isset($sessions) ? $sessions->session_title : "" ?></h3>
                        </div>
                    <?php } ?>

                    <div id="embededVideo">
                        <div id="iframeDiv" class="row embed-responsive embed-responsive-16by9">
                            <?= isset($sessions) ? '<iframe src="https://viewer.millicast.com/v2?streamId=pYVHx2/'.str_replace(' ', '', $sessions->embed_html_code).'&autoPlay=true&muted=true&disableFull=true" width="100%" height="100%"></iframe>' : "" ?>
                        <div class="videoElement">
                            <span id="btnFS" class="glyphicon glyphicon-resize-full" data-toggle="tooltip" title="Full Screen"></span>
                        </div>
                        </div>
                        <div class="modal fade" id="modal" tabindex="-1" role="modal" aria-labelledby="modal-label" aria-hidden="true" style="display: none; text-align: left;" data-keyboard="false" data-backdrop="static">
                            <div class="modal-dialog">
                                <div class="modal-content" style="padding: 0px; border: 0px solid #999; border-radius: 15px;">
                                    <div class="modal-header" style="height: 0">
                                        <button type="button" class="poll-modal-close close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body" style="padding: 0px;">
                                        <div class="row" style="padding-top: 0px; padding-bottom: 20px;">
                                            <div class="col-sm-12">
                                                <div class="" id="timer_sectiom" style="padding-top: 0px; padding-bottom: 0px; display: none; border-top-right-radius: 15px; border-top-left-radius: 15px; background-color: #ebeaea; ">
                                                    <div class=""  style="text-align: right; font-size: 20px; font-weight: 700; border-top-right-radius: 15px; border-top-left-radius: 15px;  ">
                                                        TIME LEFT : <span id="id_day_time" style=" font-size: 20px; font-weight: 700; color: #ef5e25; padding: 0px 10px 0px 0px;"></span>
                                                    </div>
                                                </div>
                                                <div id="poll_vot_section" style="padding: 0px 0px 0px 0px; margin-top: 0px; background-color: #fff; border-radius: 15px;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
<!--                    <p class="currentTime">
                        CURRENT TIME : <span id="show_time"></span> EDT <a class="button color currentTimeButton" id="close_session"><span>Close the Session</span></a>

                    </p>

                        <span class="borderFooter">test</span>
                    </p>-->

                    <div class="col-md-12">
                        <?php
                        if (isset($music_setting)) {
                            if ($music_setting->music_setting != "") {
                                ?>
                                <audio allow="autoplay" id="audio" src="<?= base_url() ?>uploads/music/<?= $music_setting->music_setting ?>"></audio>
                                <?php
                            }
                        }
                        ?>
                        <input type="hidden" id="view_sessions_history_id" value="">
                        <input type="hidden" id="sessions_id" value=" <?= isset($sessions) ? $sessions->sessions_id : "" ?>">
                        <input type="hidden" id="poll_vot_section_id_status" value="0">
                        <input type="hidden" id="poll_vot_section_is_ended" value="0">
                        <input type="hidden" id="poll_vot_section_last_status" value="0">
                        <!--                                    <div class="col-md-3">
                                                                <div id="poll_vot_section" style="padding: 0px 0px 0px 0px; margin-top: 10px; background-color: #fff; border-radius: 5px;">
                                                                </div>
                                                            </div>-->

                        <div class="row" style="display:none">

                            <div class="col-md-3">
                                <div id="resource_section" style="padding: 0px 0px 0px 0px; margin-top: 10px; background-color: #fff; border-radius: 5px;">
                                    <div>
                                        <h2 style='margin-bottom: 0px; color: #ffffff; font-weight: 700;font-size: 15px; padding: 5px 5px 5px 10px; background-color: #b2b7bb; text-transform: uppercase;'><i class="fa fa-paperclip" style="font-size: 18px; color: #ee5d26;"></i> Resources <i class="fa fa-caret-down" id="resource_show" data-resource_show_status="1" style="float: right; font-size: 16px;"></i></h2>
                                    </div>
                                    <div style="padding: 15px 15px 15px 15px; overflow-y: auto; height: 240px;" id="resource_display_status">
                                        <?php
                                        if (!empty($session_resource)) {
                                            foreach ($session_resource as $val) {
                                                ?>
                                                <div class="row" style="margin-bottom: 10px; padding-bottom: 5px;">
                                                    <div class="col-md-12"><a class="resources-link-text" href="<?= $val->resource_link ?>" target="_blank" ><?= $val->link_published_name ?></a></div>

                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                        <span id='success_resource' style='color:green;'></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- END: SECTION -->
    </div>
</section>
<div class="borderFrame"></div>



<?php
if (isset($sessions)) {
    if ($sessions->tool_box_status == "1") {
        ?>
        <div class="rightSticky" data-screen="customer">
            <ul>
                <?php
                if(sessionRightBarControl($sessions->right_bar, "notes")){
                    ?>
                    <li data-type="notesSticky"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <span>TAKE NOTES</span></li>
                    <?php
                }
                if(sessionRightBarControl($sessions->right_bar, "resources")){
                    ?>
                    <li data-type="resourcesSticky"><i class="fa fa-paperclip" aria-hidden="true"></i> <span>RESOURCES</span></li>
                    <?php
                }
                if(sessionRightBarControl($sessions->right_bar, "chat")){
                    ?>
                    <li data-type="messagesSticky"><i class="fa fa-comments" aria-hidden="true"></i> <span class="notify notify<?=getAppName($sessions->sessions_id) ?> displayNone"></span> <span>MESSAGES</span></li>
                    <?php
                }
                if(sessionRightBarControl($sessions->right_bar, "questions")){
                    ?>
                    <li data-type="questionsSticky"><i class="fa fa-question" aria-hidden="true"></i> <span>QUESTIONS</span></li>
                    <?php
                }
                if(sessionRightBarControl($sessions->right_bar, "askarep")){
                    ?>
                    <li data-type="askarepSticky"><img src="<?=base_url('front_assets/images/conversation_icon.png')?>" style="width: 25px;padding-bottom: 3px;"> <span>Ask a Rep</span></li>
                    <?php
                }
                    ?>
                <li id="adminChatStickeyIcon" data-type="adminChatSticky" class="admin-chat-stickey-icon" style="display: <?=(sessionRightBarControl($sessions->right_bar, "adminChat"))?'block':'none'?>;">
                    <span class="new-admin-chat-badge badge" style="position: absolute;margin-left: -29px;margin-top: -10px;border-radius: 9px;font-size: 10px;background-color: red;padding-right: 7px;padding-left: 4px;padding-bottom: 4px; display: none;">New</span>
                    <i class="fas fa-user-tie"></i> <span class="adminChat<?=getAppName($sessions->sessions_id) ?> displayNone"></span> <span>CHAT WITH ADMIN</span>
                </li>

            </ul>
        </div>
        <?php
    }
}
?>


<div class="rightSticykPopup notesSticky" style="display: none">
    <div class="header"><span></span>
        <div class="rightTool">
            <i id="minimizeTakeNote" class="fa fa-minus" aria-hidden="true"></i>
            <div class="dropdown">
<!--                <span class="glyphicon glyphicon-option-vertical" aria-hidden="true" data-toggle="dropdown"></span>-->
                <ul class="dropdown-menu">
                    <?php
                    if(sessionRightBarControl($sessions->right_bar, "resources")){
                        ?>
                        <li data-type="resourcesSticky"><a data-type2="off">Resources</a></li>
                        <?php
                    }
                    if(sessionRightBarControl($sessions->right_bar, "chat")){
                        ?>
                        <li data-type="messagesSticky"><a data-type2="off">Messages</a></li>
                        <?php
                    }
                    if(sessionRightBarControl($sessions->right_bar, "questions")){
                        ?>
                        <li data-type="questionsSticky"><a data-type2="off">Questions</a></li>
                        <?php
                    }

                    if(sessionRightBarControl($sessions->right_bar, "askarep")){
                        ?>
                        <li data-type="askarepSticky"><img src="<?=base_url('front_assets/images/conversation_icon.png')?>" style="width: 25px;padding-bottom: 3px;"> <span>Ask a Rep</span></li>
                        <?php
                    }

                    if(sessionRightBarControl($sessions->right_bar, "adminChat")){
                        ?>
                        <li data-type="adminChatSticky"><a data-type2="off">Chat with Admin</a></li>
                        <?php
                    }

                    ?>

                </ul>
            </div>
        </div>
    </div>
   <div class="content">
        <div class="contentHeader">Take Notes</div>
        <div id="briefcase_section">
            <div id="briefcase_section">
                <div class="col-md-12 input-group">
                    <textarea type="text" id="briefcase" class="form-control" placeholder="Add Notes (press enter to save)" value=""><?= isset($sessions_notes_download) ? $sessions_notes_download : "" ?></textarea>
                </div>
                <a class="button color btn btn-sm"  id="briefcase_send"><span>SUBMIT</span></a>
<!--                <a class="button color btn" id="downloadbriefcase"><span>Download</span></a>-->
            </div>
            <span id='error_briefcase' style='color:red;'></span>
            <span id='success_briefcase' style='color:green;'></span>
        </div>
    </div>

</div>
<div class="rightSticykPopup resourcesSticky" style="display: none">
    <div class="header"><span></span>
        <div class="rightTool">
            <i id="minimizeResources" class="fa fa-minus" aria-hidden="true"></i>
            <div class="dropdown">
<!--                <span class="glyphicon glyphicon-option-vertical" aria-hidden="true" data-toggle="dropdown"></span>-->
                <ul class="dropdown-menu">
                    <?php
                    if(sessionRightBarControl($sessions->right_bar, "chat")){
                        ?>
                        <li data-type="messagesSticky"><a data-type2="off">Messages</a></li>
                        <?php
                    }
                    if(sessionRightBarControl($sessions->right_bar, "questions")){
                        ?>
                        <li data-type="questionsSticky"><a data-type2="off">Questions</a></li>
                        <?php
                    }
                    if(sessionRightBarControl($sessions->right_bar, "notes")){
                        ?>
                        <li data-type="notesSticky"><a data-type2="off">Take Notes</a></li>
                        <?php
                    }
                    if(sessionRightBarControl($sessions->right_bar, "adminChat")){
                        ?>
                        <li data-type="adminChatSticky"><a data-type2="off">Chat with Admin</a></li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="contentHeader">
            Resources
        </div>
        <div id="resource_section" style="padding: 0px 0px 0px 0px; margin-top: 10px; background-color: #fff; border-radius: 5px;">
            <div style="padding: 0px 15px 15px 15px; overflow-y: auto; height: 240px;" id="resource_display_status">
                <?php
                if (!empty($session_resource)) {
                    foreach ($session_resource as $val) {
                        ?>
                        <div class="row" style="margin-bottom: 10px; padding-bottom: 5px">
                            <?php if ($val->resource_link != "") { ?>
                                <div class="col-md-12"><a class="resources-link-text" href="<?= $val->resource_link ?>" target="_blank"><?= $val->link_published_name ?></a></div>
                            <?php } ?>
                            <?php
                            if ($val->upload_published_name) {
                                if ($val->resource_file != "") {
                                    ?>
                                    <div class="col-md-12"><a class="resources-link-text" id="resource-download" data-resource-name="<?= $val->file_name ?>" data-resource-id="<?= $val->session_resource_id ?>" href="<?= base_url() ?>uploads/resource_sessions/<?= $val->resource_file ?>" download="<?= $val->file_name ?>"> <?= $val->upload_published_name ?>  </a></div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <?php
                    }
                }
                ?>
                <span id='success_resource' style='color:green;'></span>
            </div>
        </div>
    </div>

</div>
<div class="rightSticykPopup messagesSticky messagesSticky<?=getAppName($sessions->sessions_id) ?>" style="display: none">
    <div class="header"><span></span>
        <div class="rightTool">
            <i id="minimizeMessages" class="fa fa-minus" aria-hidden="true"></i>
            <div class="dropdown">
<!--                <span class="glyphicon glyphicon-option-vertical" aria-hidden="true" data-toggle="dropdown"></span>-->
                <ul class="dropdown-menu">
                    <?php
                    if(sessionRightBarControl($sessions->right_bar, "resources")){
                        ?>
                        <li data-type="resourcesSticky"><a data-type2="off">Resources</a></li>
                        <?php
                    }
                    if(sessionRightBarControl($sessions->right_bar, "questions")){
                        ?>
                        <li data-type="questionsSticky"><a data-type2="off">Questions</a></li>
                        <?php
                    }
                    if(sessionRightBarControl($sessions->right_bar, "notes")){
                        ?>
                        <li data-type="notesSticky"><a data-type2="off">Take Notes</a></li>
                        <?php
                    }
                    if(sessionRightBarControl($sessions->right_bar, "adminChat")){
                        ?>
                        <li data-type="adminChatSticky"><a data-type2="off">Chat with Admin</a></li>
                        <?php
                    }
                    ?>

                </ul>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="contentHeader">
            Messages
        </div>
        <div class="messages">

        </div>

        <input type="text" class="form-control" placeholder="Enter message" id='sendGroupChat'>

    </div>

</div>

<div class="rightSticykPopup adminChatSticky adminChatSticky<?=getAppName($sessions->sessions_id) ?>" style="display: none">
    <div class="header"><span></span>
        <div class="rightTool">
            <i class="minimize-admin-chat fa fa-minus" aria-hidden="true"></i>
            <div class="dropdown">
                <!--                <span class="glyphicon glyphicon-option-vertical" aria-hidden="true" data-toggle="dropdown"></span>-->
                <ul class="dropdown-menu">
                    <?php
                    if(sessionRightBarControl($sessions->right_bar, "resources")){
                        ?>
                        <li data-type="resourcesSticky"><a data-type2="off">Resources</a></li>
                        <?php
                    }
                    if(sessionRightBarControl($sessions->right_bar, "questions")){
                        ?>
                        <li data-type="questionsSticky"><a data-type2="off">Questions</a></li>
                        <?php
                    }
                    if(sessionRightBarControl($sessions->right_bar, "notes")){
                        ?>
                        <li data-type="notesSticky"><a data-type2="off">Take Notes</a></li>
                        <?php
                    }
                    if(sessionRightBarControl($sessions->right_bar, "adminChat")){
                        ?>
                        <li data-type="adminChatSticky"><a data-type2="off">Chat with Admin</a></li>
                        <?php
                    }
                    ?>

                </ul>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="contentHeader">
            Chat with Admin
        </div>
        <div class="admin-messages">
        </div>

        <input type="text" class="form-control" placeholder="Enter message" id='sendAdminChat'>

    </div>

</div>

<div class="rightSticykPopup questionsSticky" style="display: none">
    <div class="header"><span></span>
        <div class="rightTool">
            <i id="minimizeQuestions" class="fa fa-minus" aria-hidden="true"></i>
            <div class="dropdown">
<!--                <span class="glyphicon glyphicon-option-vertical" aria-hidden="true" data-toggle="dropdown"></span>-->
                <ul class="dropdown-menu">
                    <?php
                    if(sessionRightBarControl($sessions->right_bar, "resources")){
                        ?>
                        <li data-type="resourcesSticky"><a data-type2="off">Resources</a></li>
                        <?php
                    }
                    if(sessionRightBarControl($sessions->right_bar, "chat")){
                        ?>
                        <li data-type="messagesSticky"><a data-type2="off">Messages</a></li>
                        <?php
                    }

                    if(sessionRightBarControl($sessions->right_bar, "notes")){
                        ?>
                        <li data-type="notesSticky"><a data-type2="off">Take Notes</a></li>
                        <?php
                    }
                    ?>

                </ul>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="contentHeader">
            Questions
        </div>
        <div class="questionElement">
        </div>
        <div id="ask_questions_section" style="border-radius: 5px; position: absolute; bottom: 0; width: 100%;">
            <div style="padding:5px;">
                <div style="text-align: center; display: flex; " id="questions_section">

                    <div class="col-md-12 input-group">
                        <span class="input-group-addon" style="padding: 5px 6px"><img src="<?= base_url() ?>front_assets/images/emoji/happy.png" id="questions_emjis_section_show" title="Check to Show Emoji" data-questions_emjis_section_show_status="0" style="width: 20px; height: 20px;" alt=""/></span>
                        <input type="text" id="questions" class="form-control" placeholder="Enter Question" value="">
                    </div>
                    <a class="button color btn" style="margin: 0px; padding: 15px 7px;" id="ask_questions_send"><span>Send</span></a>
                </div>
                <div style="text-align: left; padding-left: 10px; display: flex;" id="questions_emojis_section">
                    <img src="<?= base_url() ?>front_assets/images/emoji/happy.png" title="Happy" id="questions_happy" data-title_name="&#128578;" style="width: 40px; height: 40px; padding: 5px;" alt=""/>
                    <img src="<?= base_url() ?>front_assets/images/emoji/sad.png" title="Sad" id="questions_sad" data-title_name="&#128543" style="width: 40px; height: 40px; padding: 5px;" alt=""/>
                    <img src="<?= base_url() ?>front_assets/images/emoji/laughing.png" title="Laughing" id="questions_laughing" data-title_name="😁" style="width: 40px; height: 40px; padding: 5px;" alt=""/>
                    <img src="<?= base_url() ?>front_assets/images/emoji/thumbs_up.png" title="Thumbs Up" id="questions_thumbs_up" data-title_name="&#128077;" style="width: 40px; height: 40px; padding: 5px;" alt=""/>
                    <img src="<?= base_url() ?>front_assets/images/emoji/thumbs_down.png" title="Thumbs Down" id="questions_thumbs_down" data-title_name="&#128078" style="width: 40px; height: 40px; padding: 5px;" alt=""/>
                    <img src="<?= base_url() ?>front_assets/images/emoji/clapping.png" title="Clapping" id="questions_clapping" data-title_name="&#128079;" style="width: 40px; height: 40px; padding: 5px;" alt=""/>
                </div>
                <span id='error_questions' style='color:red;'></span>
                <span id='success_questions' style='color:green;'></span>
            </div>
        </div>
    </div>

</div>

<div class="rightSticykPopup askarepSticky" style="display: none">
    <div class="header"><span></span>
        <div class="rightTool">
            <i id="minimizeAskARep" class="fa fa-minus" aria-hidden="true"></i>
        </div>
    </div>
    <div class="content">
        <div class="contentHeader">
            ASK A REP
        </div>
        <div class="ask-a-rep" style="color: white;">
            I would like a representative to contact me.
        </div>

        <div class="input-group" style="border-radius: 5px; position: absolute; bottom: 0; width: 100%;background-color: white;">
            <h6 style="margin: 0 0 0 10px;"><input type="radio" name="askarepRadio" value="Rep" checked> Reach a Rep</h6>
            <h6 style="margin: 0 0 0 10px;"><input type="radio" name="askarepRadio" value="MSL"> Reach an MSL</h6>
            <span class="input-group-btn">
        <button id="askARepSendBtn" class="btn btn-primary" type="button">SEND</button>
      </span>
        </div>

    </div>

</div>

<script>
    var base_url = "<?=base_url()?>";
    var site_url = "<?= site_url() ?>";
    var user_id = "<?=$this->session->userdata('cid')?>";
    var user_fullname = "<?=$this->session->userdata('fullname')?>";
    var app_name = "<?=getAppName($sessions->sessions_id) ?>";
    var session_id = "<?=$sessions->sessions_id?>";
    var session_start_datetime =  new Date("<?= date('M d, Y', strtotime($sessions->sessions_date)) . ' ' . $sessions->time_slot ?>");
    var session_end_datetime =  new Date("<?= date('M d, Y', strtotime($sessions->sessions_date)) . ' ' . $sessions->end_time ?>");

    var socket_session_name = "<?=getAppName('_admin-to-attendee-chat')?>";

    var this_session_type = "<?=$sessions->sessions_type_id?>";
    var subsequent_session_1 = "<?=($sessions->subsequent_session_1 && $sessions->subsequent_session_1 != null)?$sessions->subsequent_session_1:'null'?>";
    var subsequent_session_1_name = "<?=$sessions->subsequent_session_1_name?>";
    var subsequent_session_2 = "<?=($sessions->subsequent_session_2 && $sessions->subsequent_session_2 != null)?$sessions->subsequent_session_2:'null'?>";
    var subsequent_session_2_name = "<?=$sessions->subsequent_session_2_name?>";
    var subsequent_session_popup_text = `<?=$sessions->subsequent_session_popup_text?>`;

</script>
<?= getSocketScript()?>
<script src="<?= base_url() ?>front_assets/js/custom-fullscreen.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10.3.3/dist/sweetalert2.all.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous"></script>

<!--****** PubNub Stuff *****-->
<!-- DO NOT use production keys on the localhost-->
<script> var pubnub_channel = "PCE_Session_<?=$sessions->sessions_id?>"; </script>
<script src="<?= base_url() ?>front_assets/js/pubnub/pubnub_live_users.js?v=2"></script>

<!-- Please add scripts only in this JS file, NOT directly on this HTML file -->

<script src="<?= base_url() ?>front_assets/js/view_sessions.js?v=29"></script>

<script src="<?= base_url() ?>front_assets/js/admin-to-attendee-chat.js?v=203"></script>

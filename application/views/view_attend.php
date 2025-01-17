<style>
    .progress-bar {
        height: 100%;
        padding: 3px;
        background: rgb(200, 201, 202);
        box-shadow: none; 
    }
    .progress_bar_new {
        height: 100%;
        padding: 3px;
        background: #99d9ea;
        box-shadow: none;
        text-align: center;
        color: #fff;
        padding-top: 0px;
    }

    .option_section_css{
        background-color: #f1f1f1;
        padding-top: 4px;
        padding-left: 6px;
        border-radius: 9px;
        margin-bottom: 10px;
    }
    .option_section_css_selected{
        background-color: #e1f6ff;
        padding-top: 4px;
        padding-left: 6px;
        border-radius: 9px;
        margin-bottom: 10px;
    }
    .progress {
        height: 26px;
        margin-bottom: 10px;
        overflow: hidden;
        background-color: #e6edf3;
        border-radius: 5px;
        -webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,.1);
        box-shadow: inset 0 1px 2px rgba(0,0,0,.1);
    }
    section{
        padding: 25px 0px;
    }
    #bg {
        position: fixed;
        top: 0;
        left: 0;

        /* Preserve aspet ratio */
        min-width: 100%;
        min-height: 100%;
    }
</style>
<img src="<?= base_url() ?>front_assets/images/Green_BG.jpg" id="bg" alt="">
<section class="parallax" style=" top: 0; padding-top: 0px;">
    <div class="container container-fullscreen"> 
        <div class="text-middle">
            <div class="row">
                <div class="col-md-12">
                    <!-- CONTENT -->
                    <?php
                    if ((isset($sessions) && !empty($sessions))) {
                        $time = $sessions->time_slot;
                        $datetime = $sessions->sessions_date . ' ' . $time;
                        $datetime = date("Y-m-d H:i", strtotime($datetime));
                        $datetime = new DateTime($datetime);
                        $datetime1 = new DateTime();
                        $diff = $datetime->getTimestamp() - $datetime1->getTimestamp();
                        if ($diff >= 1800) {
                            $diff = $diff - 1800;
                        } else {
                            $diff = 0;
                        }
                    }
                    ?>
                    <input type="hidden" id="time_second" value="<?= $diff ?>">
                    <section class="content">
                        <div class="container" style=" background: rgba(250, 250, 250, 0.8);"> 
                            <div class="row p-b-40">
                                <div class="col-md-12" style="background-color: #B2B7BB; margin-bottom: 10px;">
                                    <h3 style="margin-bottom: 5px; color: #fff; font-weight: 700; text-transform: uppercase;"><?= isset($sessions) ? $sessions->session_title : "" ?></h3>
                                </div>    
                                <div class="col-md-7 m-t-20" style="border-right: 1px solid;">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <?php if ($sessions->sessions_photo != "") { ?>
                                                <img alt="" src="<?= base_url() ?>uploads/sessions/<?= (isset($sessions) && !empty($sessions)) ? $sessions->sessions_photo : "" ?>" style="width: 100%;">
                                            <?php } else { ?>
                                                <img alt="" src="<?= base_url() ?>front_assets/images/session_avtar.jpg" style="width: 100%;">
                                            <?php } ?>   
                                        </div>  
                                        <div class="col-md-8">
                                            <h2 style="margin-bottom: 0px;"><?= (isset($sessions) && !empty($sessions)) ? $sessions->session_title : "" ?></h2>
                                            <small><i class="fa fa-calendar" aria-hidden="true"></i> <?= date("M-d-Y", strtotime($sessions->sessions_date)) . ' ' . date("h:i A", strtotime($sessions->time_slot)) . ' - ' . date("h:i A", strtotime($sessions->end_time)) ?></small>  ET
                                            <p class="m-t-20"><?= (isset($sessions) && !empty($sessions)) ? $sessions->sessions_description : "" ?></p>
                                        </div>    
                                    </div>
                                </div>
                                <div class="col-md-5" style="text-align: center;">
                                    <?php
                                    $size = 0;
                                    if (isset($sessions->presenter) && !empty($sessions->presenter)) {
                                        $size = sizeof($sessions->presenter);
                                    }
                                    ?>
                                    <?php if ($size <= 2) { ?>
                                        <br>
                                        <br>
                                    <?php } ?>
                                    <?php
                                    if (isset($sessions->presenter) && !empty($sessions->presenter)) {
                                        foreach ($sessions->presenter as $value) {
                                            ?>
                                            <h3 style="margin-bottom: 0px; " data-presenter_photo="<?= $value->presenter_photo ?>" data-presenter_name="<?= $value->presenter_name ?>" data-designation="<?= $value->designation ?>" data-email="<?= $value->email ?>" data-company_name="<?= $value->company_name ?>" class="" ><?= $value->presenter_name ?><?= ($value->degree != "") ? "," : "" ?> <?= $value->degree ?></h3>
                                            <h3 style="margin-bottom: 0px; "> <?= $value->company_name ?></h3>
                                            <!--<p class="m-t-20"><?= (isset($sessions) && !empty($sessions)) ? $sessions->bio : "" ?></p>-->
                                            <!--<img alt="" src="<?= base_url() ?>uploads/presenter_photo/<?= (isset($sessions) && !empty($sessions)) ? $sessions->presenter_photo : "" ?>" class="img-circle" height="100" width="100">-->
                                            <?php
                                        }
                                    }
                                    ?>
<!--<p class="m-t-20"><?= (isset($sessions) && !empty($sessions)) ? $sessions->bio : "" ?></p>-->
<!--<img alt="" src="<?= base_url() ?>uploads/presenter_photo/<?= (isset($sessions) && !empty($sessions)) ? $sessions->presenter_photo : "" ?>" class="img-circle" height="100" width="100">-->
                                </div>

                                <?php if ($sessions->landing_page_text != NULL): ?>
                                    <div class="col-md-12 m-t-40 text-center">
                                        <?=$sessions->landing_page_text?>
                                    </div>
                                <?php endif; ?>

                                <div class="col-md-12 m-t-40">
                                    <div class="col-md-4 col-md-offset-4" style="text-align: center; text-align: center; padding: 10px; background-color: #fff; border: 1px solid;">
                                        <p><i class="fa fa-info-circle" aria-hidden="true" style="font-size: 20px;"></i></p>
                                        <p>You will automatically enter the session 30 minutes before it is due to begin.</p>
                                        <p>Entry will be enabled in <span id="id_day_time" ></span></p>
                                    </div>
                                </div>
                                <?php if (1 == 2){ ?>
                                    <div class="col-md-12">
                                        <a class="button black-light button-3d rounded right" style="margin: 0px 0;" href="<?= base_url() ?>sessions/view/<?= (isset($sessions) && !empty($sessions)) ? $sessions->sessions_id : "" ?>"><span>Take me there</span></a>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </section><br><br>
                    <!-- END: SECTION --> 
                </div>
            </div> 
        </div>
    </div>
</section>
<div class="modal fade" id="modal" tabindex="-1" role="modal" aria-labelledby="modal-label" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="padding: 0px;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row" style="padding-top: 10px; padding-bottom: 20px;">
                    <div class="col-sm-12">
                        <div class="col-sm-4">
                            <img src="" id="presenter_profile" class="img-circle" style="height: 170px; width: 170px;">
                        </div>
                        <div class="col-sm-8" style="padding-top: 15px;">
                            <h3 id="presenter_title" style="font-weight: 700"></h3>
                            <p style="border-bottom: 1px dotted; margin-bottom: 10px; padding-bottom: 10px;"><b style="color: #000;">Email </b> <span id="email" style="padding-left: 10px;"></span></p>
                            <p style="border-bottom: 1px dotted; margin-bottom: 10px; padding-bottom: 10px;"><b style="color: #000;">Company </b> <span id="company" style="padding-left: 10px;"></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">


    var session_id = "<?=$sessions->sessions_id?>";


    $(document).ready(function () {
        if ($("#time_second").val() <= 0) {
            timer();
        } else {
            setInterval('timer()', 1000);
        }
        $(".presenter_open_modul").click(function () {
            var presenter_photo = $(this).attr("data-presenter_photo");
            var presenter_name = $(this).attr("data-presenter_name");
            var designation = $(this).attr("data-designation");
            var company_name = $(this).attr("data-company_name");
            var email = $(this).attr("data-email");
            $('#presenter_profile').attr('src', "<?= base_url() ?>uploads/presenter_photo/" + presenter_photo);
            $('#presenter_title').text(presenter_name + ", " + designation);
            $('#email').text(email);
            $('#company').text(company_name);
            $('#modal').modal('show');
        });
    });
    // console.log($("#time_second").val())
    var upgradeTime = $("#time_second").val();
    var seconds = upgradeTime;
    function timer() {
        var days = Math.floor(seconds / 24 / 60 / 60);
        var hoursLeft = Math.floor((seconds) - (days * 86400));
        var hours = Math.floor(hoursLeft / 3600);
        var minutesLeft = Math.floor((hoursLeft) - (hours * 3600));
        var minutes = Math.floor(minutesLeft / 60);
        var remainingSeconds = seconds % 60;
        function pad(n) {
            return (n < 10 ? "0" + n : n);
        }
        if (pad(days) > 1) {
            var days_lable = "days";
        } else {
            var days_lable = "day";
        }

        if (pad(hours) > 1) {
            var hours_lable = "hours";
        } else {
            var hours_lable = "hour";
        }

        if (pad(minutes) > 1) {
            var minutes_lable = "minutes";
        } else {
            var minutes_lable = "minute";
        }
        if (pad(remainingSeconds) > 1) {
            var remainingSeconds_lable = "seconds";
        } else {
            var remainingSeconds_lable = "second";
        }
        document.getElementById('id_day_time').innerHTML = pad(days) + " " + days_lable + ", " + pad(hours) + " " + hours_lable + ", " + pad(minutes) + " " + minutes_lable + ", " + pad(remainingSeconds) + " " + remainingSeconds_lable;
        if (seconds <= 0) {
            window.location = "<?= site_url() ?>sessions/view/<?= (isset($sessions) && !empty($sessions)) ? $sessions->sessions_id : "" ?>";
                    } else {
                        seconds--;
                    }
                }
</script>
<script type="text/javascript">
    $(document).ready(function () {
        var page_link = $(location).attr('href');
        var user_id = <?= $this->session->userdata("cid") ?>;
        var page_name = "Attend View";
        $.ajax({
            url: "<?= base_url() ?>home/add_user_activity",
            type: "post",
            data: {'user_id': user_id, 'page_name': page_name, 'page_link': page_link},
            dataType: "json",
            success: function (data) {
            }
        });
    });

    $('#toolbox').hide();
</script>

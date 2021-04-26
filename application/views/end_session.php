<?php
if(isset($_GET['testing2']))
{
    print_r($sessions); exit;
}
?>

<style>
    .jumbotron{
        width: 900px;
        margin: 50px auto;
        text-align: center;
        max-width: 100%;
    }
    .jumbotron p{
     width: 100%;
    }
    .jumbotron h2{
               font-size: 45px;
    }

    .jumbotron .lounge{
        color: black;
        font-weight: 500;
    }.jumbotron .lounge a{
             font-weight: bold;
             text-decoration: underline !important;
    }

</style>
<section class="parallax fullscreen" style="background-image: url(<?= base_url() ?>front_assets/images/attend_background.png); top: 0; padding-top: 0px;">
<div class="container container-fullscreen">
    <div class="jumbotron">
        <h2>This session is now closed.</h2>
        <?php if($sessions->subsequent_session_popup_text != null && $sessions->subsequent_session_popup_text != ''): ?>
            <h3 style="width: 100%;"><?=$sessions->subsequent_session_popup_text?></h3>
        <?php endif; ?>
        <?php if($sessions->subsequent_session_1 != null && $sessions->subsequent_session_1 != ''): ?>
            <h5><a href="<?=base_url()?>sessions/attend/<?=$sessions->subsequent_session_1?>">Next CME/CE Session</a></h5>
        <?php endif; ?>
    </div>
</div>
</section>

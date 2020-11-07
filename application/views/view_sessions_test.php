<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <script src="//softvelum.com/player/releases/sldp-v2.17.1.min.js"></script>
</head>
<body>
<div id="player"></div>

<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", initPlayer);

    function initPlayer(){
        sldpPlayer = SLDP.init({
            container:          'player',
            stream_url:         "wss://oneworldlow.cachefly.net/oneworld/live1",
            initial_resolution: '240p',
            buffering:          1000,
            autoplay:           true,
            controls:           true,
            height:             'parent',
            width:              'parent'
        });
    };

    function removePlayer(){
        sldpPlayer.destroy(function () {
            console.log('SLDP Player is destroyed.');
        });
    }
</script>
</body>
</html>

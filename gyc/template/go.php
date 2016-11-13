<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>正在跳转到<?php echo $to_title ?> | <?php echo TITLE ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style type="text/css">
        * {
            padding: 0;
            margin: 0;
            border: 0;
        }

        #time {
            color: red;
        }

        body {
            background: #f7f7f7;
        }

        .spinner {
            font-size: 100px;
            width: 1em;
            height: 1em;
            margin: 100px auto;
            border-radius: 50%;
            box-shadow: inset 0 0 0 .1em rgba(58, 168, 237, .2);
        }

        .spinner i {
            position: absolute;
            width: 1em;
            height: 1em;
        }

        .spinner i:before {
            position: absolute;
            z-index: 2;
            clip: rect(0, 1em, 1em, .5em);
            width: 1em;
            height: 1em;
            content: '';
            animation: spinner-circle-clipper 5s ease-in-out infinite;
            background: rgba(255, 0, 0, .2);
        }

        @keyframes spinner-circle-clipper {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(180deg);
            }
        }

        .spinner i:after {
            position: absolute;
            clip: rect(0, 1em, 1em, .5em);
            width: 1em;
            height: 1em;
            content: '';
            animation: spinner-circle 5s ease-in-out infinite;
            border-radius: 50%;
            box-shadow: inset 0 0 0 .1em #3aa8ed;
        }

        @keyframes spinner-circle {
            0% {
                transform: rotate(-180deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        #content {
            text-align: center;
        }
    </style>
</head>
<body onload="load()">
<div class="spinner"><i></i></div>
<div id="content">
    <br>
    <span><?php echo $reason ?>,正在跳转到</span><a href="<?php echo $url ?>"><?php echo $to_title ?></a>
    <br>
    <span><span id="time">3</span>s</span>
</div>
<script>
    function load() {
        var time = document.getElementById('time');
        setInterval(function () {
            time.innerText = parseInt(time.innerText) - 1;
            if (time.innerText <= 1) {
                location.href = '<?php echo $url ?>';
            }
        }, 1000);
    }
</script>
</body>
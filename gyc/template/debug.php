<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo TITLE ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style type="text/css" rel="stylesheet">
        body {
            background-color: white;
            margin: 0;
            padding: 0;
        }

        /*PIG*/
        #pig {
            position: relative;
            top: 40px;
            width: 200px;
            height: 200px;
            margin: 0 auto;
        }

        #pig_head {
            width: 200px;
            height: 200px;
            background-color: #FA8CC8;
            border-radius: 100px;
        }

        #pig_ear_left {
            width: 0;
            height: 0;
            position: absolute;
            top: 15px;
            left: 18px;
            border-left: 20px solid transparent;
            border-right: 20px solid transparent;
            border-bottom: 28px solid #D30073;
            -webkit-transform: rotate(-25deg);
        }

        #pig_ear_right {
            width: 0;
            height: 0;
            position: absolute;
            top: 15px;
            left: 145px;
            border-left: 20px solid transparent;
            border-right: 20px solid transparent;
            border-bottom: 28px solid #D30073;
            -webkit-transform: rotate(25deg);
        }

        #pig_eye_left {
            position: absolute;
            top: 50px;
            left: 70px;
            width: 12px;
            height: 20px;
            background: black;
            -webkit-border-radius: 50px/100px;
        }

        #pig_eye_right {
            position: absolute;
            top: 50px;
            left: 125px;
            width: 12px;
            height: 20px;
            background: black;
            -webkit-border-radius: 50px/100px;
        }

        #pig_snout {
            position: absolute;
            top: 90px;
            left: 62px;
            width: 80px;
            height: 55px;
            background: #FA4EAC;
            -webkit-border-radius: 90px/60px;
        }

        #pig_snout_hole_left {
            position: absolute;
            top: 100px;
            left: 80px;
            width: 17px;
            height: 35px;
            background: #E01B87;
            -webkit-border-radius: 60px/100px;
        }

        #pig_snout_hole_right {
            position: absolute;
            top: 100px;
            left: 111px;
            width: 17px;
            height: 35px;
            background: #E01B87;
            -webkit-border-radius: 60px/100px;
        }

        #debug {
            margin-top: 75px;
            text-align: center;
        }
    </style>
</head>
<body>
<div id="pig">
    <div id="pig_head"></div>
    <div id="pig_ear_left"></div>
    <div id="pig_ear_right"></div>
    <div id="pig_eye_left"></div>
    <div id="pig_eye_right"></div>
    <div id="pig_snout"></div>
    <div id="pig_snout_hole_left"></div>
    <div id="pig_snout_hole_right"></div>
</div>
<div id="debug">
    <?php
    if (isset($desc)) {
        ?>
        <p><strong>MISTAKE : </strong><?php echo $desc ?></p>
        <?php
    } elseif (isset($code) && isset($message) && isset($file) && isset($line)) {
        ?>
        <p>
            <strong>Exception <?php echo $code ?> : </strong><?php echo $message ?>
            <br>
            <strong>in file : </strong><?php echo $file ?>
            <br>
            <strong>on line : </strong><?php echo $line ?>
        </p>
        <?php
    }
    ?>
</div>
</body>
</html>
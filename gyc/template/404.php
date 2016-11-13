<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>404 | <?php echo TITLE ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style type="text/css">
        body {
            font-family: 'Love Ya Like A Sister', cursive;
            background: #fff;
            margin: 0;
            padding: 0;
        }

        .wrap {
            width: 100%;
            height: 100%;
            position: absolute;
        }

        .logo {
            text-align: center;
            width: 300px;
            height: 200px;
            margin: auto;
            position: absolute;
            /*设定水平和垂直偏移父元素的50%，
            再根据实际长度将子元素上左挪回一半大小*/
            left: 50%;
            top: 50%;
            margin-left: -150px;
            margin-top: -100px;
        }

        h2 {
            font-size: 60pt;
        }

        .logo p {
            color: #272727;
            font-size: 40px;
            margin-top: 1px;
        }

        .logo p span {
            color: lightgreen;
        }

        .sub a {
            color: #fff;
            background: #272727;
            text-decoration: none;
            padding: 10px 20px;
            font-size: 13px;
            font-family: arial, serif;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="wrap">
    <div class="logo">
        <p>OOPS! - 找不到页面了！</p>
        <h2>404</h2>
        <div class="sub">
            <p><a href="javascript:history.go(-1);">返回</a></p>
        </div>
    </div>
</div>
</body>
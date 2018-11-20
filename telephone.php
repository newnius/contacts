<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <?php require_once('head.php'); ?>
    <title>号码归属地查询 | 云通讯录</title>
</head>

<body>
<div class="wrapper">
    <?php require_once('header.php'); ?>
    <div class="container">
        <div id="tel-belong" class="panel panel-default text-center">
            <div>
                <form role="search">
                    <div class="input-group">
                        <input id="input-search-1" type="text" class="form-control" placeholder="查归属地、查陌生人">
                        <span class="input-group-btn">
	        <button id="btn-search-1" type="submit" class="btn btn-default">搜索</button>
	      </span>
                    </div>
                </form>
            </div>
            <div id="carrier"></div>
            <div id="telString"></div>
            <div id="identity"></div>
        </div>
    </div> <!-- /container -->
    <!--This div exists to avoid footer from covering main body-->
    <div class="push"></div>
</div>
<?php require_once('footer.php'); ?>
<script src="static/search.js"></script>
</body>
</html>

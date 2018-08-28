<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <title><?php echo $site_name; ?></title> 
    <!-- CSS fonts.googleapis.com -->
    <link href="//fonts.lug.ustc.edu.cn/icon?family=Material+Icons" rel="stylesheet">
    <link href="asset/materialize/css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="asset/materialize/css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>
<nav class="light-blue lighten-1" role="navigation">
    <div class="nav-wrapper container"><a id="logo-container" href="/" class="brand-logo"><?php echo $site_name; ?></a>
        <ul class="right hide-on-med-and-down">
            <li><a href="index.php">首页</a></li>
            <li><a href="download.php">客户端</a></li>
            <li><a href="code.php">邀请码</a></li>
            <?php if($is_login){ ?>
            <li><a href="user">用户中心</a></li>
            <li><a href="user/logout.php">退出</a></li>
            <?php }else{ ?>
            <li><a href="user/login.php">登陆</a></li>
            <?php }?>
        </ul>

        <ul id="nav-mobile" class="side-nav">
            <li><a href="index.php">首页</a></li>
            <li><a href="download.php">客户端</a></li>
            <li><a href="code.php">邀请码</a></li>
            <?php if($is_login){ ?>
            <li><a href="user">用户中心</a></li>
            <li><a href="user/logout.php">退出</a></li>
            <?php }else{ ?>
            <li><a href="user/login.php">登陆</a></li>
            <?php }?>
        </ul>
        <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
    </div>
</nav>


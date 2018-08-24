<?php
include_once 'lib/config.php';
$is_login = false;
if (isset($_COOKIE['uid']) || $_COOKIE['uid'] != '') {
    //co
    $uid = $_COOKIE['uid'];
    $user_email = $_COOKIE['user_email'];
    $user_pwd = $_COOKIE['user_pwd'];

    $U = new \Ss\User\UserInfo($uid);
    //验证cookie
    $pwd = $U->GetPasswd();
    $pw = \Ss\User\Comm::CoPW($pwd);
    if ($pw != $user_pwd || $pw == null || $user_pwd == null) {
        $is_login = false;
    } else {
        $is_login = true;
    }
} else {
    $is_login = false;
}
include_once 'header.php';
?>


<div class="section no-pad-bot" id="index-banner">
        <div class="container">
            <br><br>
            <h1 class="header center orange-text"><?php echo $site_name; ?></h1>
            <div class="row center">
                <h5 class="header col s12 light">轻松科学上网   保护个人隐私</h5>
            </div>
            <div class="row center">
                <?php if($is_login){ ?>
                <a href="user" id="download-button" class="btn-large waves-effect waves-light orange">用户中心</a>
                <?php }else{ ?>
                <a href="user/register.php" id="download-button" class="btn-large waves-effect waves-light orange">注册</a>
                <a href="user/login.php" id="download-button" class="btn-large waves-effect waves-light orange">登陆</a>
                <?php }?>
            </div>
            <br><br>
        </div>
</div>


<div class="container">
    <div class="section">

        <!--   Icon Section   -->
        <div class="row">
            <div class="col s12 m4">
                <div class="icon-block">
                    <h2 class="center light-blue-text"><i class="material-icons">flash_on</i></h2>
                    <h5 class="center">Super Fast</h5>

                    <p class="light">
                        Bleeding edge techniques using Asynchronous I/O and Event-driven programming.
                    </p>
                </div>
            </div>

            <div class="col s12 m4">
                <div class="icon-block">
                    <h2 class="center light-blue-text"><i class="material-icons">group</i></h2>
                    <h5 class="center">Open Source</h5>

                    <p class="light">
                        Totally free and open source. A worldwide community devoted to deliver bug-free code and long-term support.
                    </p>
                </div>
            </div>

            <div class="col s12 m4">
                <div class="icon-block">
                    <h2 class="center light-blue-text"><i class="material-icons">settings</i></h2>
                    <h5 class="center">Easy to work with</h5>

                    <p class="light">
                        Available on multiple platforms, including PC, MAC, Mobile (Android and iOS) and Routers (OpenWRT).
                    </p>
                </div>
            </div>
        </div>

    </div>
    <br><br>

    <div class="section">

    </div>
</div>
<?php include_once 'ana.php';
include_once 'footer.php';?>

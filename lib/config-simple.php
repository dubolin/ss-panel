<?php
/*
 * ss-panel配置文件
 * https://github.com/orvice/ss-panel
 * Author @orvice
 * https://orvice.org
 */

//定义流量
$tokb = 1024;
$tomb = 1024 * 1024;
$togb = $tomb * 1024;
//Define DB Connection  数据库信息
define('DB_HOST', 'localhost');
define('DB_USER', 'ssr');
define('DB_PWD', 'ssr');
define('DB_DBNAME', 'ssr');
define('DB_CHARSET', 'utf8');
define('DB_TYPE', 'mysql');
/*
 * 下面的东西根据需求修改
 */

//define Plan
//注册用户的初始化流量
//默认5GiB
$a_transfer = $togb * 5;

//签到设置 签到活的的最低最高流量,单位MB
$check_min = 100;
$check_max = 500;

$check_invite = 100;

$port_min = 10000;
$port_max = 65535;
//name
$site_name = "ssr";
$site_url = "http://ssr.***.com/";
/**
 * 站点盐值，用于加密密码
 * 第一次安装请修改此值，安装后请勿修改！！否则会使所有密码失效，仅限加密方式不为1的时候有效
 */
$salt = "*****************";
/**
 * 密码加密方式，注意： 2.4以前的版本，请修改加密方式为「1」，否则会使密码失效！
 * 更多说明见wiki https://github.com/orvice/ss-panel/wiki/Install-Guide-zh_cn
 * 加密方式:
 * 1 md5
 * 2 带salt的Sha256加密，新安装建议使用此加密方式！
 */
$pwd_mode = 1;

//用户注册后获得的邀请码最低最高
//都设置为0用户就不能邀请
$user_invite_min = '1';
$user_invite_max = '1';
//推荐用户获得流量M
$user_invite_get = 1024;

//选择邮件服务
// smtp未完成，现在只能用mailgun
//mail-gun
//mail-smtp
$Selectmailservice = "mail-gun";

//允许注册的邮件后缀
$mail_allow_domain = ['gmail.com', '163.com', 'qq.com', 'live.cn', 'live.com', 'sohu.com', 'yeah.net', 'vip.qq.com', 'foxmail.com', 'outlook.com', 'hotmail.com', 'sina.com', '126.com', 'icloud.com'];

//邮件发件人
$mailgun_sender = "xxx@xxx.xx";

//mail-gun
// Get your key from https://mailgun.com
$mailgun_key = "";
$mailgun_domain = "";

//邮件发件人
$mail_smtp_Sender = "ssr小组";

//mail-smtp
$mail_smtp_Domain = "*****.com";
//设置smtp服务器连接方式:
$mail_smtp_Secure = "ssl";
//smtp服务器端口 25 , 465 ...
$mail_smtp_Port = 465;
//smtp服务器
$mail_smtp_Server = "smtp.qq.com";
//邮件帐号
$mail_smtp_Account = "ssuper@*****.com";
//邮件密码
$mail_smtp_password = "******************";

//
require_once 'do.php';

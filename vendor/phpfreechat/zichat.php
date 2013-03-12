<?php
$params = array();
$params["lang"] = 'en';
if (isset($_GET["lang"])) {
    $params["lang"] = $_GET["title"];
}
$params["title"] = "Zichat";
if (isset($_GET["title"])) {
    $params["title"] = $_GET["title"];
}
$params["refresh_delay"]  = 4000; // chat refresh speed is ms
if (isset($_GET["refresh_delay"])) {
    $params["refresh_delay"] = (int)$_GET["refresh_delay"];
}
$params["focus_on_connect"]  = true; // if to focus on chat
if (isset($_GET["focus_on_connect"])) {
    $params["focus_on_connect"] = $_GET["focus_on_connect"];
}
$params["theme"] = "carbon"; // default, carbon, gamer
if (isset($_GET["theme"])) {
    $params["theme"] = $_GET["theme"];
}
// Chat release type
$development = false;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $params["lang"]; ?>">
<head>
    <meta charset="utf-8" />
    <title><?php echo $params["title"]; ?></title>
    <script src="client/lib/jquery-1.8.2.min.js"></script>
    <?php if ($development) { /* Development phpFreeChat release */ ?>
        <link rel="stylesheet/less" type="text/css" href="client/themes/<?php echo $params["theme"]; ?>/jquery.phpfreechat.less" />
        <script src="client/lib/less-1.3.1.min.js" type="text/javascript"></script>
        <script src="client/jquery.phpfreechat.js" type="text/javascript"></script>
        <script src="client/jquery.phpfreechat.init.js" type="text/javascript"></script>
        <script src="client/jquery.phpfreechat.core.js" type="text/javascript"></script>
        <script src="client/jquery.phpfreechat.auth.js" type="text/javascript"></script>
        <script src="client/jquery.phpfreechat.commands.js" type="text/javascript"></script>
        <script src="client/jquery.phpfreechat.cmd_join.js" type="text/javascript"></script>
        <script src="client/jquery.phpfreechat.cmd_op.js" type="text/javascript"></script>
        <script src="client/jquery.phpfreechat.channels.js" type="text/javascript"></script>
        <script src="client/jquery.phpfreechat.users.js" type="text/javascript"></script>
        <script src="client/jquery.phpfreechat.utils.js" type="text/javascript"></script>
    <?php } else { /* Official phpFreeChat release */ ?>
    <link rel="stylesheet" type="text/css" href="client/themes/<?php echo $params["theme"]; ?>/jquery.phpfreechat.min.css" />
    <script src="client/jquery.phpfreechat.min.js" type="text/javascript"></script>
    <?php } ?>
</head>
<body style="margin:0; padding:0">
        <div class="zichat_freechat">
            <a href="http://www.phpfreechat.net">phpFreeChat: simple Web chat</a>
        </div>
        <script type="text/javascript">
            <?php if ($development) { /* Development phpFreeChat release */ ?>
            var less = { env: 'development' };
            <?php } ?>
            $('.zichat_freechat').phpfreechat({
                serverUrl: 'server',
                refresh_delay: <?php echo $params["refresh_delay"]; ?>,
                focus_on_connect: <?php if ($params["focus_on_connect"]) echo 'true'; else echo 'false'; ?>
            });
        </script>
</body>
</html>

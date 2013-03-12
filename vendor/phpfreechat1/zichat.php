<?php
require_once dirname(__FILE__)."/src/phpfreechat.class.php";

require_once __DIR__.'/../../lib/ztools.php';
// initiate Ztools::$ZConfig
Ztools::IncludeConfigFile();
// Get Zichat module config variables
$vars = Ztools::ZikulaModuleVars('Zichat');
if (!isset($vars['zichat_admingroups'])) {
    $vars['zichat_admingroups'] = 2; // 2 is default Zikula admin group Id
}
// variables dependat on GET
if (isset($_GET['s'])) {
    // get user session from Zikula session table, determine user Id
    $userid = Ztools::ZikulaSessionUserid($_GET['s']);

    // chech user group ids if are in list with group ids for admins
    $zichat_UserIsAdmin =  Ztools::ZikulaUserIsInGroup($userid, $vars['zichat_admingroups']);

    // chech user group ids if are in list with group ids for moderators
    //$_SESSION['zichat_UserIsModerator'] =  Ztools::ZikulaUserIsInGroup($userid, $vars['zichat_moderatorgroups']);

    // get user data if loged in Zikula
    IF ($userid >0) {
        $userdata =  Ztools::ZikulaUserData($userid);
    }
}

$params = array();
$params["title"] = "Zichat";
if (isset($_GET["title"])) {
    $params["title"] = $_GET["title"];
}
$params["channels"] = array("public");
//$params["frozen_channels"] = array("public"); // If the array is empty, it allows users to create their own channels. Default value: empty array
//$params["nick"] = "guest".rand(1,1000);  // setup the intitial nickname
if (isset($userdata['uname'])) {
    $params["nick"] = $userdata['uname'];
} else {
    $params["nick"] = ""; // ask for nickname on focus
}
$params["frozen_nick"] = false; // if to allow change the nickname
//$params["shownotice"] = 7; // 0 = nothing, 1 = just nickname changes, 2 = connect/quit, 3 nick + connect/quit, 4 will show kick/ban notifications, •Setting it to 7 (1+2+4) will show all the notifications. (Default value: 7
$params["max_nick_len"] = 15; // nickname length could not be longer
$params["max_text_len"]   = 300; // a message cannot be longer
$params["refresh_delay"]  = 4000; // chat refresh speed is ms
if (isset($_GET["refresh_delay"])) {
    $params["refresh_delay"] = (int)$_GET["refresh_delay"];
}
$params["height"] = "400px";  // Height of the chat area. (Default value: "440px")
if (isset($_GET["height"])) {
    $params["height"] = $_GET["height"].'px';
}
$$params['firstisadmin'] = false;
$params["isadmin"] = $zichat_UserIsAdmin;
$params["connect_at_startup"] = true;
$params["start_minimized"]    = false;
$params["nickmarker"]     = true; // Setting it to false will disable nickname colorization. (Default value: true)
$params["clock"] = true;
$params["language"] = 'en';
if (isset($_GET["lang"])) {
    $langList = pfcI18N::GetAcceptedLanguage();
    foreach ($langList as $code) {
        if ($_GET["lang"] == substr($code, 0, 2)) {
            $params["language"] = $code;
            break;
        }
    }
}
$params["islocked"] = false; // When this parameter is true, all the chatters will be redirected to the url indicated by the lockurl parameter
$params["lockurl"] = ''; // This url is used when islocked parameter is true. The users will be redirected (http redirect) to this url. (Default value: http://www.phpfreechat.net)
$params["focus_on_connect"] = false; // Setting this to true will give the focus to the input text box when connecting to the chat
if (isset($_GET["focus_on_connect"])) {
    $params["focus_on_connect"] = (bool)$_GET["focus_on_connect"];
}
$params["startwithsound"] = true; // Setting it to false will start the chat without sound notifications. (Default value: true)
$params["display_pfc_logo"] = false; // Used to hide the phpfreechat linkback logo. Be sure that you are conform to the license page before setting this to false! (Default value: true)
$params["showsmileys"] = false; // Used to show/hide the smiley selector at startup. (Default value: true)
$params["showwhosonline"] = true; // Used to show/hide online users list at startup. (Default value: true)
$params["displaytabimage"] = false; // Used to show/hide the images in the channels and pv tabs. (Default value: true)
$params["display_ping"] = false; // Used to show/hide the ping information near the phpfreechat linkback logo. The ping is the time between a client request and a server response. More the ping is low, faster the chat is responding. (Default value: true)
$params["prototypejs_url"] = ''; // This is the prototype javascript library URL. Use this parameter to use your external library. (Default value: '' - means data/js/prototype.js is used automatically)
$params["debug"] = false;
$params["date_format"] = 'd.m.Y';
$params["time_format"] = 'H:i:s';
$params["dyn_params"] = array("theme", "language");
$params["theme"] = "default"; // default, cerutti, blune, green, msn, phoenity, phpbb2, zilveer
if (isset($_GET["theme"])) {
    $params["theme"] = $_GET["theme"];
}
//$params["serverid"] = md5(__FILE__); // calculate a unique id for this chat
$params["serverid"] = md5($params["theme"].'122'.$params["title"]); // calculate a unique id for this chat
$chat = new phpFreeChat($params); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <title>Zichat</title>
</head>
<body>
    <div class="content">
        <?php $chat->printChat(); ?>
    </div>
</body>
</html>

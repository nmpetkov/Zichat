<?php
/*
 * @package AJAX_Chat
 * @author Sebastian Tschan
 * @copyright (c) Sebastian Tschan
 * @license GNU Affero General Public License
 * @link https://blueimp.net/ajax/
 */

class CustomAJAXChat extends AJAXChat {

    // Zichat post initSession actions
    // here session is started
	function initCustomSession() {
        // save values between sessions

        // Get Zichat module config variables
        $vars = Ztools::ZikulaModuleVars('Zichat');
        $_SESSION['zichat_admingroups'] = '2'; // 2 is default Zikula admin group Id
        if (isset($vars['zichat_admingroups'])) {
            $_SESSION['zichat_admingroups'] = $vars['zichat_admingroups'];
        }
        $_SESSION['zichat_moderatorgroups'] = $vars['zichat_moderatorgroups'];
        $_SESSION['zichat_channels'] = $vars['ajaxchat_channels'];
        $_SESSION['ajaxchat_channelsguest'] = $vars['ajaxchat_channelsguest'];

        // variables dependat on GET
        if (isset($_GET['s'])) {
            $_SESSION['zichat_title'] = $_GET["title"];
            setcookie('zichattitle', $_GET["title"], 0, $this->getConfig('sessionCookiePath'), $this->getConfig('sessionCookieDomain'), $this->getConfig('sessionCookieSecure'));
            $_SESSION['zichat_lang'] = $_GET["lang"];
            $_SESSION['zichat_theme'] = $_GET["theme"];

            // get user session from Zikula session table, determine user Id
            $_SESSION['zichat_userid'] = Ztools::ZikulaSessionUserid($_GET['s']);

            // chech user group ids if are in list with group ids for admins
            $_SESSION['zichat_UserIsAdmin'] =  Ztools::ZikulaUserIsInGroup($_SESSION['zichat_userid'], $_SESSION['zichat_admingroups']);

            // chech user group ids if are in list with group ids for moderators
            $_SESSION['zichat_UserIsModerator'] =  Ztools::ZikulaUserIsInGroup($_SESSION['zichat_userid'], $_SESSION['zichat_moderatorgroups']);
        }

        if (isset($_SESSION['zichat_lang'])) {
            $this->_config['langDefault'] = $_SESSION['zichat_lang'];
        }

        $this->_config['styleDefault'] = 'grey';
        if (isset($_SESSION['zichat_theme'])) {
            $this->_config['styleDefault'] = $_SESSION['zichat_theme'];
        }
        // Defines if login/logout and channel enter/leave are displayed:
        $this->_config['showChannelMessages'] = false;
    }

	// Override to initialize custom configuration settings
	function initCustomConfig() {
        // Zichat
        // Database hostname:
        $this->_config['dbConnection']['host'] = Ztools::$ZConfig['DBInfo']['databases']['default']['host']; // Zichat
        // Database username:
        $this->_config['dbConnection']['user'] = Ztools::$ZConfig['DBInfo']['databases']['default']['user']; // Zichat
        // Database password:
        $this->_config['dbConnection']['pass'] = Ztools::$ZConfig['DBInfo']['databases']['default']['password']; // Zichat
        // Database name:
        $this->_config['dbConnection']['name'] = Ztools::$ZConfig['DBInfo']['databases']['default']['dbname']; // Zichat

        return true;
	}

	// Override language settings
	function getLang($key=null) {
        $ret = parent::getLang($key);
		if ($ret === null) {
			return null;
		}

        // Set chat title
        if (isset($_SESSION['zichat_title'])) {
            $this->_lang['title'] = $_SESSION['zichat_title'];
        } else {
            $this->_lang['title'] = $_COOKIE['zichattitle'];
        }

		return $ret;
	}

	// Returns an associative array containing userName, userID and userRole
	// Returns null if login is invalid
	function getValidLoginUserData() {
		
		$customUsers = $this->getCustomUsers();
		
		if($this->getRequestVar('password')) {
			// Check if we have a valid registered user:

			$userName = $this->getRequestVar('userName');
			$userName = $this->convertEncoding($userName, $this->getConfig('contentEncoding'), $this->getConfig('sourceEncoding'));

			$password = $this->getRequestVar('password');
			$password = $this->convertEncoding($password, $this->getConfig('contentEncoding'), $this->getConfig('sourceEncoding'));

			foreach($customUsers as $key=>$value) {
				//if(($value['userName'] == $userName) && ($value['password'] == $password)) {
				if(($value['userName'] == $userName) && (Ztools::passwordsMatch($password, $value['pass']))) { // Zichat
                    // Get Zikula admin status
                    $UserIsAdmin = Ztools::ZikulaUserIsAdmin($value['uid']);
                    // Ajax Chat data
					$userData = array();
					$userData['userID'] = $key;
					$userData['userName'] = $this->trimUserName($value['userName']);
                    if ($_SESSION['zichat_UserIsAdmin']) {
                        $userData['userRole'] = AJAX_CHAT_ADMIN;
                    } else if ($_SESSION['zichat_UserIsModerator']) {
                        $userData['userRole'] = AJAX_CHAT_MODERATOR;
                    } else {
                        if ($UserIsAdmin) {
                            $userData['userRole'] = AJAX_CHAT_ADMIN;
                        } else {
                            $userData['userRole'] = $value['userRole'];
                        }
                    }
					return $userData;
				}
			}
			
			return null;
		} else {
			// Guest users:
			return $this->getGuestUser();
		}
	}

	// Store the channels the current user has access to
	// Make sure channel names don't contain any whitespace
	function &getChannels() {
		if($this->_channels === null) {
			$this->_channels = array();
			
			$customUsers = $this->getCustomUsers();
			
			// Get the channels, the user has access to:
			if($this->getUserRole() == AJAX_CHAT_GUEST) {
				$validChannels = $customUsers[0]['channels'];
			} else {
				$validChannels = $customUsers[$this->getUserID()]['channels'];
			}
			
			// Add the valid channels to the channel list (the defaultChannelID is always valid):
			foreach($this->getAllChannels() as $key=>$value) {
				// Check if we have to limit the available channels:
				if($this->getConfig('limitChannelList') && !in_array($value, $this->getConfig('limitChannelList'))) {
					continue;
				}
				
				if(in_array($value, $validChannels) || $value == $this->getConfig('defaultChannelID')) {
					$this->_channels[$key] = $value;
				}
			}
		}
		return $this->_channels;
	}

	// Store all existing channels
	// Make sure channel names don't contain any whitespace
	function &getAllChannels() {
		if($this->_allChannels === null) {
			// Get all existing channels:
			$customChannels = $this->getCustomChannels();
			
			$defaultChannelFound = false;
			
			foreach($customChannels as $key=>$value) {
				$forumName = $this->trimChannelName($value);
				
				$this->_allChannels[$forumName] = $key;
				
				if($key == $this->getConfig('defaultChannelID')) {
					$defaultChannelFound = true;
				}
			}
			
			if(!$defaultChannelFound) {
				// Add the default channel as first array element to the channel list:
				$this->_allChannels = array_merge(
					array(
						$this->trimChannelName($this->getConfig('defaultChannelName'))=>$this->getConfig('defaultChannelID')
					),
					$this->_allChannels
				);
			}
		}
		return $this->_allChannels;
	}

	function &getCustomUsers() {
		// List containing the registered chat users:
		$users = null;
		//require(AJAX_CHAT_PATH.'lib/data/users.php');

        // Available channels to users
        $userChannels = $this->getCustomChannels();
        $uChannels = array();
        for ($i = 0; $i < count($userChannels); ++$i) {
            $uChannels[] = $i;
        }
        // Available channels to guests
        $guestChannels = explode(',', $_SESSION['ajaxchat_channelsguest']);
        $gChannels = array();
        for ($i = 0; $i < count($userChannels); ++$i) {
            foreach ($guestChannels as $chanel) {
                if (strtolower($userChannels[$i]) == strtolower($chanel)) {
                    $gChannels[] = $i;
                }
            }
        }
        
        $daysago = 0; // How many days ago usera have been active
        $result = Ztools::ZikulaActiveUsersLoginData($daysago);
        if ($result) {
            $users = array(); 
            // Default guest user (don't delete this one):
            $users[0] = array();
            $users[0]['userRole'] = AJAX_CHAT_GUEST;
            $users[0]['userName'] = null;
            $users[0]['password'] = null;
            $users[0]['channels'] = $gChannels;
            $index = 1;
            while ($userdata = mysql_fetch_assoc($result)) {
                $users[$index] = $userdata;
                $users[$index]['userRole'] = AJAX_CHAT_USER;
                $users[$index]['userName'] = $userdata['uname'];
                $users[$index]['password'] = $userdata['uname'];    // this requires to replace password check procedure!
                //$users[$index]['channels'] = array(0,1);
                $users[$index]['channels'] = $uChannels;
                $index ++;
            }
        }

		return $users;
	}
	
	function &getCustomChannels() {
		// List containing the custom channels:
		/*$channels = null;
		require(AJAX_CHAT_PATH.'lib/data/channels.php');*/

        $channels = array();
        if (empty($_SESSION['zichat_channels'])) {
            $channels[0] = 'Public';
        } else {
            $channels = explode(',', $_SESSION['zichat_channels']);
        }

		return $channels;
	}

}

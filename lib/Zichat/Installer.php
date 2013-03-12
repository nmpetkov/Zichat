<?php
/**
 * Zichat Zikula Module
 *
 * @copyright Nikolay Petkov
 * @license GNU/GPL
 */
class Zichat_Installer extends Zikula_AbstractInstaller
{
    /**
     * Initializes a new install
     *
     * @return  boolean    true/false
     */
    public function install()
    {
        // create table
        /*if (!DBUtil::createTable('zichat')) {
            return LogUtil::registerError($this->__('Error! Could not create the table.'));
        }*/
        $connection = $this->entityManager->getConnection();

        // Create Axjax Chat tables
        $sqlQueries = array();
        $sqlQueries[] = "DROP TABLE IF EXISTS `ajax_chat_online`";
        $sqlQueries[] = "CREATE TABLE `ajax_chat_online` (
	userID INT(11) NOT NULL,
	userName VARCHAR(64) NOT NULL,
	userRole INT(1) NOT NULL,
	channel INT(11) NOT NULL,
	dateTime DATETIME NOT NULL,
	ip VARBINARY(16) NOT NULL,
	PRIMARY KEY (userID),
	INDEX (userName)
) DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
        $sqlQueries[] = "DROP TABLE IF EXISTS `ajax_chat_messages`";
        $sqlQueries[] = "CREATE TABLE `ajax_chat_messages` (
	id INT(11) NOT NULL AUTO_INCREMENT,
	userID INT(11) NOT NULL,
	userName VARCHAR(64) NOT NULL,
	userRole INT(1) NOT NULL,
	channel INT(11) NOT NULL,
	dateTime DATETIME NOT NULL,
	ip VARBINARY(16) NOT NULL,
	text TEXT,
	PRIMARY KEY (id),
	INDEX message_condition (id, channel, dateTime),
	INDEX (dateTime)
) DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
        $sqlQueries[] = "DROP TABLE IF EXISTS `ajax_chat_bans`";
        $sqlQueries[] = "CREATE TABLE `ajax_chat_bans` (
	userID INT(11) NOT NULL,
	userName VARCHAR(64) NOT NULL,
	dateTime DATETIME NOT NULL,
	ip VARBINARY(16) NOT NULL,
	PRIMARY KEY (userID),
	INDEX (userName),
	INDEX (dateTime)
) DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
        $sqlQueries[] = "DROP TABLE IF EXISTS `ajax_chat_invitations`";
        $sqlQueries[] = "CREATE TABLE `ajax_chat_invitations` (
	userID INT(11) NOT NULL,
	channel INT(11) NOT NULL,
	dateTime DATETIME NOT NULL,
	PRIMARY KEY (userID, channel),
	INDEX (dateTime)
) DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
        foreach ($sqlQueries as $sql) {
            $stmt = $connection->prepare($sql);
            try {
                $stmt->execute();
            } catch (Exception $e) {
            }   
        }

        // Set up module config variables
        $this->setVar('zichat_type', 'ajaxchat');
        $this->setVar('zichat_title', 'Zichat');
        $this->setVar('zichat_typehooked', 'freechat');
        $this->setVar('zichat_titlehooked', 'Zichat');
        $this->setVar('zichat_admingroups', '2');
        $this->setVar('zichat_moderatorgroups', '');
        // phpFreeChat Default Settings
        $this->setVar('freechat_theme', 'default');
        $this->setVar('freechat_itype', 'iframe');
        $this->setVar('freechat_height', '400px');
        $this->setVar('freechat_refresh_delay', 5000);
        $this->setVar('freechat_focus_on_connect', false);
        // phpFreeChat 1.6 Default Settings
        $this->setVar('freechat1_theme', 'zichat');
        $this->setVar('freechat1_height', '400px');
        $this->setVar('freechat1_refresh_delay', 5000);
        $this->setVar('freechat1_focus_on_connect', false);
        // AJAX Chat Default Settings
        $this->setVar('ajaxchat_theme', 'zichat');
        $this->setVar('ajaxchat_height', '400px');
        $this->setVar('ajaxchat_channels', 'Public');
        $this->setVar('ajaxchat_channelsguest', 'Public');

        // Register hooks
        $sqlQueries = array();
        $sqlQueries[] = 'DELETE FROM `hook_area` WHERE `owner`="Zichat"';
        $sqlQueries[] = 'DELETE FROM `hook_subscriber` WHERE `owner`="Zichat"';
        $sqlQueries[] = 'DELETE FROM `hook_provider` WHERE `owner`="Zichat"';
        foreach ($sqlQueries as $sql) {
            $stmt = $connection->prepare($sql);
            try {
                $stmt->execute();
            } catch (Exception $e) {
            }   
        }
        HookUtil::registerSubscriberBundles($this->version->getHookSubscriberBundles());
        HookUtil::registerProviderBundles($this->version->getHookProviderBundles());

        return true;
    }
    
    /**
     * Upgrade module
     *
     * @param   string    $oldversion
     * @return  boolean   true/false
     */
    public function upgrade($oldversion)
    {
        $this->throwForbiddenUnless(SecurityUtil::checkPermission('Zichat::', '::', ACCESS_ADMIN), LogUtil::getErrorMsgPermission());
    
        switch ($oldversion) {
            case '1.0.0':
                //future upgrade routines
        }
    
        return true;
    }
    
    /**
     * Delete module
     *
     * @return  boolean    true/false
     */
    public function uninstall()
    {
        /*if (!DBUtil::dropTable('zichat')) {
            return false;
        }*/
        $connection = $this->entityManager->getConnection();

        // Delete Axjax Chat tables, if exist
        $sqlQueries = array();
        $sqlQueries[] = "DROP TABLE IF EXISTS `ajax_chat_online`";
        $sqlQueries[] = "DROP TABLE IF EXISTS `ajax_chat_messages`";
        $sqlQueries[] = "DROP TABLE IF EXISTS `ajax_chat_bans`";
        $sqlQueries[] = "DROP TABLE IF EXISTS `ajax_chat_invitations`";
        foreach ($sqlQueries as $sql) {
            $stmt = $connection->prepare($sql);
            try {
                $stmt->execute();
            } catch (Exception $e) {
            }   
        }

        // Delete module variables
        $this->delVars();

        // Remove hooks
        HookUtil::unregisterSubscriberBundles($this->version->getHookSubscriberBundles());
        HookUtil::unregisterProviderBundles($this->version->getHookProviderBundles());

        return true;
    }
}
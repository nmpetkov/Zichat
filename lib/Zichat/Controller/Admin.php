<?php
/**
 * Zichat Zikula Module
 *
 * @copyright Nikolay Petkov
 * @license GNU/GPL
 */
class Zichat_Controller_Admin extends Zikula_AbstractController
{
    /**
     * Main administration function
     */
    public function main()
    {
        return $this->info();
    }
    /**
     * Modify module Config
     */
    public function modifyconfig()
    {
        $this->throwForbiddenUnless(SecurityUtil::checkPermission('Zichat::', '::', ACCESS_ADMIN), LogUtil::getErrorMsgPermission());

        // get all groups
        $groups = UserUtil::getGroups('', 'ORDER BY gid');
        // count groups
        $groups[count] = count($groups, 0);

        $this->getView()->assign('groups', $groups);

        return $this->view->fetch('admin/modifyconfig.tpl');
    }
    /**
     * Update module Config
     */
    public function updateconfig()
    {
        $this->checkCsrfToken();
        
        $this->throwForbiddenUnless(SecurityUtil::checkPermission('Zichat::', '::', ACCESS_ADMIN), LogUtil::getErrorMsgPermission());

        $modvars = array();
        $modvars['zichat_type'] = FormUtil::getPassedValue('zichat_type', 'ajaxchat');
        $modvars['zichat_title'] = FormUtil::getPassedValue('zichat_title', 'Zichat');
        $modvars['zichat_typehooked'] = FormUtil::getPassedValue('zichat_typehooked', 'freechat');
        $modvars['zichat_titlehooked'] = FormUtil::getPassedValue('zichat_titlehooked', 'Zichat');
        $modvars['zichat_admingroups'] = FormUtil::getPassedValue('zichat_admingroups', '2');
        $modvars['zichat_moderatorgroups'] = FormUtil::getPassedValue('zichat_moderatorgroups', '');
        $modvars['freechat_theme'] = FormUtil::getPassedValue('freechat_theme', 'default');
        $modvars['freechat_itype'] = FormUtil::getPassedValue('freechat_itype', 'iframe');
        $modvars['freechat_height'] = FormUtil::getPassedValue('freechat_height', '400px');
        $modvars['freechat_refresh_delay'] = FormUtil::getPassedValue('freechat_refresh_delay', 5000);
        $modvars['freechat_focus_on_connect'] = FormUtil::getPassedValue('freechat_focus_on_connect', false);
        $modvars['freechat1_theme'] = FormUtil::getPassedValue('freechat1_theme', 'default');
        $modvars['freechat1_height'] = FormUtil::getPassedValue('freechat1_height', '400px');
        $modvars['freechat1_refresh_delay'] = FormUtil::getPassedValue('freechat1_refresh_delay', 5000);
        $modvars['freechat1_focus_on_connect'] = FormUtil::getPassedValue('freechat1_focus_on_connect', false);
        $modvars['ajaxchat_theme'] = FormUtil::getPassedValue('ajaxchat_theme', 'grey');
        $modvars['ajaxchat_height'] = FormUtil::getPassedValue('ajaxchat_height', '400px');
        $modvars['ajaxchat_channels'] = FormUtil::getPassedValue('ajaxchat_channels', 'Public');
        $modvars['ajaxchat_channelsguest'] = FormUtil::getPassedValue('ajaxchat_channelsguest', 'Public');

        // set the new variables
        $this->setVars($modvars);
    
        // clear the cache
        $this->view->clear_cache();
    
        LogUtil::registerStatus($this->__('Done! Updated the Zichat configuration.'));
        return $this->modifyconfig();
    }
    /**
     * Display module information
     */
    public function info()
    {
        $this->throwForbiddenUnless(SecurityUtil::checkPermission('Zichat::', '::', ACCESS_ADMIN), LogUtil::getErrorMsgPermission());

        return $this->view->fetch('admin/info.tpl');
    }
}
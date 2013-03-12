<?php
/**
 * Zichat Zikula Module
 *
 * @copyright Nikolay Petkov
 * @license GNU/GPL
 */
class Zichat_Api_User extends Zikula_AbstractApi
{
    /**
     * Process before display the chat
     *  $args['vars'] array on output overrided module variables
     *  $args['vars1'] array on output parameters to pass as GET in chat URL
     *  $args['chat'] string freechat/freechat1/ajaxchat
     *  $args['itype'] string iframe/script
     */
    public function chatDisplay_preProcess($args)
    {
        // Module variables
        $args['vars'] = $this->getVars();

        // Chat type
        if (isset($args['chat'])) {
            if ($args['chat'] == 'freechat' || $args['chat'] == 'freechat1' || $args['chat'] == 'ajaxchat') {
                $args['vars']['zichat_type'] = $args['chat'];
            }
        } else {
            if ($args['displaytype'] == 'hook') {
                $args['vars']['zichat_type'] = $args['vars']['zichat_typehooked'];
            }
        }
        if (isset($args['itype'])) {
            if ($args['itype'] == 'iframe') {
                $args['vars']['zichat_itype'] = 'iframe';
            } else {
                $args['vars']['zichat_itype'] = 'script';
            }
        }

        // General parameters passed in chat URL (if itype is iframe)
        $args['vars1']['lang'] = ZLanguage::getLanguageCode();
        $args['vars1']['s'] = session_id();
        if (isset($args['vars']['chat_title'])) {
            $args['vars1']['title'] = $args['vars']['chat_title'];
        } else {
            if ($args['displaytype'] == 'hook') {
                $args['vars1']['title'] = $args['vars']['zichat_titlehooked'];
            } else {
                $args['vars1']['title'] = $args['vars']['zichat_title'];
            }
        }

        // Chat type dependent
        if ($args['vars']['zichat_type'] == 'freechat') {
            // phpFreeChat
            // default values for variables
            if (empty($args['vars']['freechat_theme'])) {
                $args['vars']['freechat_theme'] = 'default';
            }
            if (empty($args['vars']['freechat_refresh_delay'])) {
                $args['vars']['freechat_refresh_delay'] = 4000;
            }
            $args['vars']['vendor_url'] = 'modules/Zichat/vendor/phpfreechat';
            $args['vars']['server_url'] = $args['vars']['vendor_url'] . '/server';
            if (!isset($args['vars']['zichat_itype'])) {
                // if integration type is not given as parameter - get default
                $args['vars']['zichat_itype'] = $args['vars']['freechat_itype'];
            }
            if ($args['vars']['zichat_itype'] == 'iframe') {
                $args['vars1']['theme'] = $args['vars']['freechat_theme'];
                $args['vars1']['height'] = (int)$args['vars']['freechat_height'];
                $args['vars1']['refresh_delay'] = $args['vars']['freechat_refresh_delay'];
            }
        } else if ($args['vars']['zichat_type'] == 'freechat1') {
            // phpFreeChat 1.6
            // default values for variables
            $args['vars1']['theme'] = $args['vars']['freechat1_theme'];
            $args['vars1']['height'] = (int)$args['vars']['freechat1_height'];
            $args['vars1']['refresh_delay'] = $args['vars']['freechat1_refresh_delay'];
            $args['vars1']['focus_on_connect'] = $args['vars']['freechat1_focus_on_connect'];
            if (empty($args['vars1']['theme'])) {
                $args['vars1']['theme'] = 'default';
            }
            if (empty($args['vars1']['height'])) {
                $args['vars1']['height'] = '400px';
            }
            if (empty($args['vars1']['refresh_delay'])) {
                $args['vars1']['refresh_delay'] = 4000;
            }
            $args['vars']['vendor_url'] = 'modules/Zichat/vendor/phpfreechat1';
            $args['vars']['server_url'] = $args['vars']['vendor_url'] . '/data';
        } else if ($args['vars']['zichat_type'] == 'ajaxchat') {
            // AJAX Chat
            // default values for variables
            $args['vars1']['theme'] = $args['vars']['ajaxchat_theme'];
            $args['vars1']['height'] = (int)$args['vars']['ajaxchat_height'];
            if (empty($args['vars1']['theme'])) {
                $args['vars1']['theme'] = 'grey';
            }
            if (empty($args['vars1']['height'])) {
                $args['vars1']['height'] = '400px';
            }
            $args['vars']['vendor_url'] = 'modules/Zichat/vendor/ajaxchat';
            $args['vars']['server_url'] = $args['vars']['vendor_url'];
        }
        $args['vars']['chat_type'] = $args['vars']['zichat_type'];
        
        if ($args['vars']['chat_type'] == 'freechat' and $args['vars']['zichat_itype'] != 'iframe') {
            // set page vars
            // Chat release type
            PageUtil::addVar("javascript", $args['vars']['vendor_url'].'/client/lib/jquery-1.8.2.min.js');
            $args['vars']['freechat_development'] = false;
            if ($args['vars']['freechat_development']) {
                PageUtil::addVar('stylesheet', $args['vars']['vendor_url'].'/client/themes/'.$args['vars']['freechat_theme'].'/jquery.phpfreechat.variables.less');
                PageUtil::addVar('stylesheet', $args['vars']['vendor_url'].'/client/themes/'.$args['vars']['freechat_theme'].'/jquery.phpfreechat.full.less');
                PageUtil::addVar('stylesheet', $args['vars']['vendor_url'].'/client/themes/'.$args['vars']['freechat_theme'].'/jquery.phpfreechat.notabs.less');
                PageUtil::addVar('stylesheet', $args['vars']['vendor_url'].'/client/themes/'.$args['vars']['freechat_theme'].'/jquery.phpfreechat.responsive.less');
                PageUtil::addVar('stylesheet', $args['vars']['vendor_url'].'/client/themes/'.$args['vars']['freechat_theme'].'/jquery.phpfreechat.theme.less');
                PageUtil::addVar('javascript', $args['vars']['vendor_url'].'/client/lib/less-1.3.1.min.js');
                PageUtil::addVar('javascript', $args['vars']['vendor_url'].'/client/jquery.phpfreechat.js');
                PageUtil::addVar('javascript', $args['vars']['vendor_url'].'/client/jquery.phpfreechat.init.js');
                PageUtil::addVar('javascript', $args['vars']['vendor_url'].'/client/jquery.phpfreechat.core.js');
                PageUtil::addVar('javascript', $args['vars']['vendor_url'].'/client/jquery.phpfreechat.auth.js');
                PageUtil::addVar('javascript', $args['vars']['vendor_url'].'/client/jquery.phpfreechat.commands.js');
                PageUtil::addVar('javascript', $args['vars']['vendor_url'].'/client/jquery.phpfreechat.cmd_join.js');
                PageUtil::addVar('javascript', $args['vars']['vendor_url'].'/client/jquery.phpfreechat.cmd_op.js');
                PageUtil::addVar('javascript', $args['vars']['vendor_url'].'/client/jquery.phpfreechat.channels.js');
                PageUtil::addVar('javascript', $args['vars']['vendor_url'].'/client/jquery.phpfreechat.users.js');
                PageUtil::addVar('javascript', $args['vars']['vendor_url'].'/client/jquery.phpfreechat.utils.js');
            } else {
                PageUtil::addVar('stylesheet', $args['vars']['vendor_url'].'/client/themes/'.$args['vars']['freechat_theme'].'/jquery.phpfreechat.min.css');
                PageUtil::addVar("javascript", $args['vars']['vendor_url'].'/client/jquery.phpfreechat.min.js');
            }
        } else if ($args['vars']['chat_type'] == 'freechat1') {
        } else if ($args['vars']['chat_type'] == 'ajaxchat') {
        }

        return $args;
    }
}
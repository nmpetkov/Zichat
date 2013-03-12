<?php
/**
 * Zichat Zikula Module
 *
 * @copyright Nikolay Petkov
 * @license GNU/GPL
 */
class Zichat_Controller_User extends Zikula_AbstractController
{
    /**
     * Main user function
     *
     * @param array $args Arguments.
     */
    public function main($args)
    {
        return $this->display($args);
    }
    
    /**
     * Display chat
     */
    public function display($args)
    {
        // Chat type
        $chat   = FormUtil::getPassedValue('chat', isset($args['chat']) ? $args['chat'] : null, 'REQUEST');
        // Integration type
        $itype   = FormUtil::getPassedValue('itype', isset($args['itype']) ? $args['itype'] : null, 'REQUEST');
        // Block Id - if passed - display block insted
        $bid   = FormUtil::getPassedValue('bid', isset($args['bid']) ? $args['bid'] : null, 'REQUEST');

        // Check permissions
        $this->throwForbiddenUnless(SecurityUtil::checkPermission('Zichat::', '::', ACCESS_OVERVIEW), LogUtil::getErrorMsgPermission());

        if ($bid > 0) {
            $vars = array('blockid' => (int)$bid);
        } else {
            // Prepare chat parameters
            $args = array('vars' => array(), 'vars1' => array(), 'displaytype' => 'main', 'chat' => $chat, 'itype' => $itype);
            $args = ModUtil::apiFunc('Zichat', 'user', 'chatDisplay_preProcess', $args);
            $vars = $args['vars'];
            $vars1 = $args['vars1'];
        }

        $this->view->assign('vars', $vars);
        $this->view->assign('vars1', $vars1);

        return $this->view->fetch('user/display.tpl');
    }
}
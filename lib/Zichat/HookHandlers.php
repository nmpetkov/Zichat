<?php
/**
 * Zichat Zikula Module
 *
 * @copyright Nikolay Petkov
 * @license GNU/GPL
 */

/**
 * Zichat Hooks Handlers.
 */
class Zichat_HookHandlers extends Zikula_Hook_AbstractHandler
{

    /**
     * Display hook for view.
     *
     * @param Zikula_Hook $hook The hook.
     *
     * @return void
     */
    public function uiView(Zikula_DisplayHook $hook)
    {
        // Input from the hook
        $callermodname = $hook->getCaller();
        $callerobjectid = $hook->getId();
        // For now can not pass this parameters from the caller
        $chat = null;
        $itype = null;

        // Check permissions
        if (!SecurityUtil::checkPermission('Zichat::', "::", ACCESS_OVERVIEW)) {
            return;
        }

        // Prepare chat parameters
        $args = array('vars' => array(), 'vars1' => array(), 'displaytype' => 'hook', 'chat' => $chat, 'itype' => $itype);
        $args = ModUtil::apiFunc('Zichat', 'user', 'chatDisplay_preProcess', $args);
        $vars = $args['vars'];
        $vars1 = $args['vars1'];

        // create the output object
        $view = Zikula_View::getInstance('Zichat', false, null, true);
        $view->assign('areaid', $hook->getAreaId());
        $view->assign('vars', $vars);
        $view->assign('vars1', $vars1);
        $template = 'user/display.tpl';

        $response = new Zikula_Response_DisplayHook('provider.zichat.ui_hooks.chat', $view, $template);
        $hook->setResponse($response);
    }

}

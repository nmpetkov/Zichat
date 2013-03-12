<?php
/**
 * Zichat Zikula Module
 *
 * @copyright Nikolay Petkov
 * @license GNU/GPL
 */
class Zichat_Block_Zichat extends Zikula_Controller_AbstractBlock
{
    /**
     * Initialise block
     */
    public function init()
    {
        SecurityUtil::registerPermissionSchema('Zichat:zichatblock:', 'Block ID::');
    }
    
    /**
     * Return array with block information
     */
    public function info()
    {
        return array(
            'module'           => 'Zichat',
            'text_type'        => 'Zichat',
            'text_type_long'   => $this->__('Zichat block'),
            'allow_multiple'   => true,
            'form_content'     => false,
            'form_refresh'     => false,
            'show_preview'     => true,
            'admin_tableless'  => true);
    }
    
    /**
     * Display block
     */
    public function display($blockinfo)
    {
        if (!SecurityUtil::checkPermission('Zichat:zichatblock:', "$blockinfo[bid]::", ACCESS_OVERVIEW)) {
            return;
        }
        if (!ModUtil::available('Zichat')) {
            return;
        }

        // Block settings
        $blockvars = BlockUtil::varsFromContent($blockinfo['content']);

        // Prepare chat parameters
        $args = array('vars' => array(), 'vars1' => array(), 
            'displaytype' => 'block', 'chat' => $blockvars['chat_type'], 'chat_title' => $blockvars['chat_title']);
        $args = ModUtil::apiFunc('Zichat', 'user', 'chatDisplay_preProcess', $args);
        $vars = $args['vars'];
        $vars1 = $args['vars1'];

        ModUtil::apiFunc('Zichat', 'user', 'chatDisplay_preProcess', $vars);

        $this->view->assign('vars', $vars);
        $this->view->assign('vars1', $vars1);
        $this->view->assign('blockvars', $blockvars);

        if (empty($blockvars['chat_template'])) {
            $blockvars['chat_template'] = 'zichat_vertical.tpl';
        }
    
        $blockinfo['content'] = $this->view->fetch('blocks/zichat/'.$blockvars['chat_template']);
    
        return BlockUtil::themeBlock($blockinfo);
    }
    
    /**
     * modify block settings ..
     */
    public function modify($blockinfo)
    {
        $vars = BlockUtil::varsFromContent($blockinfo['content']);
        if (empty($vars['chat_template'])) {
            $vars['chat_template'] = 'zichat_vertical.tpl';
        }
        if (empty($vars['chat_type'])) {
            $vars['chat_type'] = ModUtil::getVar('Zichat', 'zichat_type');
        }
        if (empty($vars['chat_title'])) {
            $vars['chat_title'] = ModUtil::getVar('Zichat', 'zichat_title');
        }
        $vars['templates'] = $this->getTemplates();

        $this->view->assign('vars', $vars);
    
        return $this->view->fetch('blocks/zichat_modify.tpl');
    }
    
    /**
     * Get block templates
     */
    public function getTemplates()
    {
        $templates = FileUtil::getFiles('modules/Zichat/templates/blocks/zichat', false, true, 'tpl', false);
        return $templates;
    }

    /**
     * update block settings
     */
    public function update($blockinfo)
    {
        $vars = BlockUtil::varsFromContent($blockinfo['content']);
    
        // get variable values from modify form
        $vars['chat_template'] = FormUtil::getPassedValue('chat_template', 'zichat_vertical.tpl', 'POST');
        $vars['chat_type'] = FormUtil::getPassedValue('chat_type', 'freechat', 'POST');
        $vars['chat_title'] = FormUtil::getPassedValue('chat_title', 'Zichat', 'POST');
        $vars['chat_tophtml'] = FormUtil::getPassedValue('chat_tophtml', '', 'POST');
        $vars['chat_sidehtml'] = FormUtil::getPassedValue('chat_sidehtml', '', 'POST');
    
        // write new variable values
        $blockinfo['content'] = BlockUtil::varsToContent($vars);
    
        // clear the block cache
        $this->view->clear_cache('blocks/zichat/'.$vars['chat_template']);
    
        return $blockinfo;
    }
}
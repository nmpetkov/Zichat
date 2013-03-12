<?php
/**
 * Zichat Zikula Module
 *
 * @copyright Nikolay Petkov
 * @license GNU/GPL
 */
class Zichat_Version extends Zikula_AbstractVersion
{
    public function getMetaData()
    {
        $meta = array();
        $meta['displayname']    = $this->__('Zichat');
        $meta['url']            = 'chat';
        $meta['description']    = $this->__('Chat integration for Zikula');
        $meta['version']        = '1.0.0';
        $meta['capabilities']   = array(HookUtil::SUBSCRIBER_CAPABLE => array('enabled' => true),
                                        HookUtil::PROVIDER_CAPABLE => array('enabled' => true));
        $meta['securityschema'] = array('Zichat::' => '::');
        $meta['core_min']       = '1.3.0';

        return $meta;
    }

    protected function setupHookBundles()
    {
        // Register hooks
        $bundle = new Zikula_HookManager_SubscriberBundle($this->name, 'subscriber.zichat.ui_hooks.items', 'ui_hooks', $this->__('Zichat Hooks'));
        $bundle->addEvent('display_view', 'zichat.ui_hooks.items.display_view');
        $bundle->addEvent('form_edit', 'zichat.ui_hooks.items.form_edit');
        $this->registerHookSubscriberBundle($bundle);

        $bundle = new Zikula_HookManager_ProviderBundle($this->name, 'provider.zichat.ui_hooks.chat', 'ui_hooks', $this->__('Zichat Chat'));
        $bundle->addServiceHandler('display_view', 'Zichat_HookHandlers', 'uiView', 'zichat.chat');
        $this->registerHookProviderBundle($bundle);
    }
}
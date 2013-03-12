<?php
/**
 * Zichat Zikula Module
 *
 * @copyright Nikolay Petkov
 * @license GNU/GPL
 */
class Zichat_Api_Admin extends Zikula_AbstractApi
{
    /**
     * Get available admin panel links
     *
     * @return array array of admin links
     */
    public function getlinks()
    {
        $links = array();
    
        if (SecurityUtil::checkPermission('Zichat::', '::', ACCESS_ADMIN)) {
            $links[] = array(
                'url' => ModUtil::url('Zichat', 'admin', 'info'),
                'text' => $this->__('Information'),
                'class' => 'z-icon-es-info');
        }
        if (SecurityUtil::checkPermission('Zichat::', '::', ACCESS_ADMIN)) {
            $links[] = array(
                'url' => ModUtil::url('Zichat', 'admin', 'modifyconfig'),
                'text' => $this->__('Settings'),
                'class' => 'z-icon-es-config');
        }
    
        return $links;
    }
}
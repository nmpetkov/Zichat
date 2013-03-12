<?php
/*
 * @package AJAX_Chat
 * @author Sebastian Tschan
 * @copyright (c) Sebastian Tschan
 * @license GNU Affero General Public License
 * @link https://blueimp.net/ajax/
 */

// Include custom libraries and initialization code here

// All is Zichat below

// Attempt to locate Zikula config.php
require_once __DIR__.'/../../../lib/ztools.php';
// initiate Ztools::$ZConfig
Ztools::IncludeConfigFile();

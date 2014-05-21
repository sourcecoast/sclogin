<?php

/**
 * @package        JFBConnect
 * @copyright (C) 2011-2013 by Source Coast - All rights reserved
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

require_once(dirname(__FILE__) . '/helper.php');
require_once(dirname(__FILE__) . '/sc_helper.php');
$helper = new modSCLoginHelper($params);

$helper->setupTheme();
$helper->setupTwoFactorAuthentication();
$helper->setupJavascript();

$jLoginUrl = $helper->getLoginRedirect('jlogin');
$jLogoutUrl = $helper->getLoginRedirect('jlogout');
$registerType = $params->get('register_type');
$showRegisterLink = $params->get('showRegisterLink');
$showRegisterLinkInModal = $showRegisterLink == 2 || $showRegisterLink == 3;
$showRegisterLinkInLogin = $showRegisterLink == 1 || $showRegisterLink == 3;


// Setup our parameters
$layout = $params->get('socialButtonsLayout', 'vertical'); //horizontal or vertical
$orientation = $params->get('socialButtonsOrientation'); //bottom, side or top
$alignment = $params->get('socialButtonsAlignment');
$loginButtonType = $params->get('loginButtonType');

if ($layout == 'horizontal')
{
    $joomlaSpan = 'pull-left';
    $socialSpan = 'pull-' . $alignment;
}
else if ($orientation == 'side' && $helper->isJFBConnectInstalled)
{
    if($loginButtonType == "icon_button")
    {
        $joomlaSpan = 'span10';
        $socialSpan = 'span2';
    }
    else if($loginButtonType == "icon_text_button")
    {
        $joomlaSpan = 'span8';
        $socialSpan = 'span4';
    }
}
else //$orientation == 'bottom' || $orientation == 'top'
{
    $joomlaSpan = 'span12';
    $socialSpan = 'span12';
}

$addClearfix = ($layout == 'vertical' && $orientation == "side") ||
    ($layout == "horizontal" && $orientation == "side" && $params->get('displayType') == 'modal');

require(JModuleHelper::getLayoutPath('mod_sclogin', $helper->getType()));
?>

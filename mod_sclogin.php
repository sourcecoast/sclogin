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

$user = JFactory::getUser();

$jLoginUrl = $helper->getLoginRedirect('jlogin');
$jLogoutUrl = $helper->getLoginRedirect('jlogout');
$registerType = $params->get('register_type');
$showRegisterLink = $params->get('showRegisterLink');
$showRegisterLinkInModal = $showRegisterLink == 2 || $showRegisterLink == 3;
$showRegisterLinkInLogin = $showRegisterLink == 1 || $showRegisterLink == 3;

// Load our CSS and Javascript files
$document = JFactory::getDocument();
$document->addStyleSheet(JURI::base(true) . '/media/sourcecoast/css/sc_bootstrap.css');

$paths = array();
$paths[] = JPATH_ROOT . '/templates/' . JFactory::getApplication()->getTemplate() . '/html/mod_sclogin/themes/';
$paths[] = JPATH_ROOT . '/media/sourcecoast/themes/sclogin/';
$theme = $params->get('theme', 'default.css');
$file = JPath::find($paths, $theme);
$file = str_replace(JPATH_SITE, '', $file);
$file = str_replace('\\', "/", $file); //Windows support for file separators
$document->addStyleSheet(JURI::base(true) . $file);

// Add placeholder Javascript for old browsers that don't support the placeholder field
if ($user->guest)
{
    jimport('joomla.environment.browser');
    $browser = JBrowser::getInstance();
    $browserType = $browser->getBrowser();
    $browserVersion = $browser->getMajor();
    if (($browserType == 'msie') && ($browserVersion <= 9))
    {
        // Using addCustomTag to ensure this is the last section added to the head, which ensures that jfbcJQuery has been defined
        $document->addCustomTag('<script src="' . JURI::base(true) . '/media/sourcecoast/js/jquery.placeholder.js" type="text/javascript"> </script>');
        $document->addCustomTag("<script>jfbcJQuery(document).ready(function() { jfbcJQuery('input').placeholder(); });</script>");
    }
}

// Two factor authentication check
$jVersion = new JVersion();
$tfaLoaded = false;
if (version_compare($jVersion->getShortVersion(), '3.2.0', '>=') && ($user->guest))
{
    $db = JFactory::getDbo();
    // Check if TFA is enabled. If not, just return false
    $query = $db->getQuery(true)
        ->select('COUNT(*)')
        ->from('#__extensions')
        ->where('enabled=' . $db->q(1))
        ->where('folder=' . $db->q('twofactorauth'));
    $db->setQuery($query);
    $tfaCount = $db->loadResult();

    if ($tfaCount > 0)
    {
        $tfaLoaded = true;
    }
}

$needsBootstrap = $params->get('displayType') == 'modal' ||
    (!JFactory::getUser()->guest && ($params->get('showUserMenu') && $params->get('userMenuStyle') == 0));
if (!$helper->isJFBConnectInstalled)
{
    if ($params->get('loadJQuery'))
        $document->addScript(JURI::base(true) . '/media/sourcecoast/js/jq-bootstrap-1.8.3.js');
    if  ($needsBootstrap || $tfaLoaded)
        $document->addScriptDeclaration('if (typeof jfbcJQuery == "undefined") jfbcJQuery = jQuery;');
}

if ($tfaLoaded)
{
    $document->addScript(Juri::base(true) . '/media/sourcecoast/js/mod_sclogin.js');
    $document->addScriptDeclaration('sclogin.token = "' . JSession::getFormToken() . '";' .
        //"jfbcJQuery(window).on('load',  function() {
        // Can't use jQuery here because we don't know if jfbcJQuery has been loaded or not.
        "window.onload = function() {
            sclogin.init();
        };
        sclogin.base = '" . JURI::base() . "';\n"
    );
}

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

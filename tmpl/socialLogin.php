<?php
/**
 * @package        JFBConnect
 * @copyright (C) 2011-2013 by Source Coast - All rights reserved
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */
defined('_JEXEC') or die('Restricted access');

$loginButtons = $helper->getLoginButtons($addClearfix, $loginButtonType, $orientation, $alignment, $params->get("loginButtonSize"), $params->get('facebookLoginButtonLinkImage'), $params->get('linkedInLoginButtonLinkImage'), $params->get('googleLoginButtonLinkImage'), $params->get('twitterLoginButtonLinkImage'), $params->get('vkLoginButtonLinkImage'));

if ($loginButtons != '')
{
    $introText = JText::_('MOD_SCLOGIN_SOCIAL_INTRO_TEXT_LABEL');

    echo '<div class="sclogin-social-login '.$socialSpan . ' ' . $layout . ' ' . $orientation.'">';
    if($introText)
        echo '<span class="sclogin-social-intro '.$socialSpan.'">'.$introText.'</span>';
    echo $loginButtons;
    echo '</div>';
}
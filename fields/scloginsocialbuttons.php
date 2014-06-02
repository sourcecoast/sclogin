<?php

/**
 * @package        JFBConnect
 * @copyright (C) 2009-2014 by Source Coast - All rights reserved
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('JPATH_PLATFORM') or die;

jimport('joomla.form.helper');
$factoryPath = JPATH_SITE . '/components/com_jfbconnect/libraries/factory.php';
if (JFile::exists($factoryPath))
{
    require_once $factoryPath;
}

if (class_exists('JFBCFactory'))
{
    require_once(JPATH_ADMINISTRATOR . '/components/com_jfbconnect/models/fields/socialbuttons.php');
    class JFormFieldScloginSocialbuttons extends JFormFieldSocialbuttons
    {
    }
}
else
{
    class JFormFieldScloginSocialButtons extends JFormField
    {
        public function getInput()
        {
            return "";
        }
        public function getLabel()
        {
            return "";
        }
    }
}
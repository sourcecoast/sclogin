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
    require_once(JPATH_ADMINISTRATOR . '/components/com_jfbconnect/models/fields/buttonstype.php');
    class JFormFieldScloginButtonstype extends JFormFieldButtonstype
    {
    }
}
else
{
    class JFormFieldScloginButtonstype extends JFormFieldList
    {
        public function getInput()
        {
            return "";
        }
    }
}
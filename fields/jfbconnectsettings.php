<?php
/**
 * @package         SCLogin
 * @copyright (c)   2009-2014 by SourceCoast - All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @version         Release v4.1.0
 * @build-date      2014/07/07
 */

defined('JPATH_PLATFORM') or die;

jimport('joomla.form.helper');
jimport('sourcecoast.utilities');

$factoryPath = JPATH_SITE . '/components/com_jfbconnect/libraries/factory.php';
if (JFile::exists($factoryPath))
{
    require_once $factoryPath;
}

if (class_exists('JFBCFactory'))
{
    SCStringUtilities::loadLanguage('com_jfbconnect', JPATH_ADMINISTRATOR);
    require_once(JPATH_ADMINISTRATOR . '/components/com_jfbconnect/models/fields/buttonstype.php');

    class JFormFieldJFBConnectSettings extends JFormField
    {
        public function getInput()
        {
            $form = JForm::getInstance('mod_sclogin.jfbconnectsettings', JPATH_SITE . '/modules/mod_sclogin/fields/jfbconnectsettings.xml');
            foreach ($form->getFieldsets() as $fiedsets => $fieldset)
            {
                foreach ($form->getFieldset($fieldset->name) as $field)
                {
                    $html[] = $field->renderField();
                }
            }

            return implode('', $html);
        }

        public function getLabel()
        {
            return "";
        }
    }
}
else
{
    class JFormFieldJFBConnectSettings extends JFormFieldList
    {
        public function getInput()
        {
            return "Buy JFBConnect!";
        }

        public function getLabel()
        {
            return "";
        }
    }
}
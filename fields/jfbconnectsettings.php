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
            JFactory::getDocument()->addStyleDeclaration(
                '.jfbcButtonImg {height:77px; margin-bottom:10px;}
                .jfbcLearnMore {clear:left;margin-top:30px;}
                .jfbcLearnMore a {color:#FFFFFF;}
                .jfbc-btn-buynow{background-color:#F79C4B; padding:16px 20px; font-size:14px;text-decoration:none;}
                .jfbc-btn-buynow:hover{background-color:rgba(247,130,60,0.6);text-decoration:none;}
            ');

            $jfbcNotDetected = '<h3>Social Buttons are not currently available since JFBConnect is not detected.</h3>';
            $jfbcInstructions = 'Please reinstall JFBConnect to configure the following login and connect buttons.';
            $loginImage = '<div  class="jfbcButtonImg"><img src="'.JURI::root() .'modules/mod_sclogin/fields/images/socialloginbuttons.png'.'"/></div>';
            $buyNow = '<div class="jfbcLearnMore"><a class="jfbc-btn-buynow" href="https://www.sourcecoast.com/joomla-facebook/" target="_blank">Learn More</a></div>';

            return $jfbcNotDetected.$loginImage .$jfbcInstructions.$buyNow;
        }

        public function getLabel()
        {
            return "";
        }
    }
}
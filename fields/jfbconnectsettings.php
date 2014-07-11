<?php
/**
 * @package         SCLogin
 * @copyright (c)   2009-@CURRENT_YEAR@ by SourceCoast - All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @version         Release v@VERSION@
 * @build-date      @DATE@
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
    jimport('sourcecoast.utilities');
    SCStringUtilities::loadLanguage('com_jfbconnect', JPATH_ADMINISTRATOR);

    class JFormFieldJFBConnectSettings extends JFormField
    {
        public function getInput()
        {
            $form = JForm::getInstance('mod_sclogin.jfbconnectsettings', JPATH_SITE . '/modules/mod_sclogin/fields/jfbconnectsettings.xml', array('control' => 'jform'));
            // J3.2+ compatible way. Need lengthier code for J2.5
            //$form->bind($this->form->getData());
            $params = $this->form->getValue('params');
            $p['params'] = $params;
            $form->bind($p);

            foreach ($form->getFieldsets() as $fiedsets => $fieldset)
            {
                if (version_compare(JVERSION, '3.2.0', '<'))
                    $html[] = '<ul class="adminformlist">';
                foreach ($form->getFieldset($fieldset->name) as $field)
                {
                    if (version_compare(JVERSION, '3.2.0', '<'))
                    {
                        $label = $field->getLabel();
                        $input = $field->getInput();
                        $html[] = '<li>' . $label . $input . '</li>';
                    }
                    else
                        $html[] = $field->renderField();
                }
                if (version_compare(JVERSION, '3.2.0', '<'))
                    $html[] = '</ul>';
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
                    .jfbc-btn-buynow:hover{background-color:rgba(247,130,60,0.6);text-decoration:none;border-radius:5px}
                ');

            $jfbcNotDetected = '<h3>Add JFBConnect for Social Network Integration</h3>';
            $jfbcInstructions = '<p>JFBConnect is the premiere social network integration extension, used on the Joomla Extension Directory itself!</p><p>To add social network authentication, social sharing, newsfeeds and more to your site, get JFBConnect now.</p>';
            $loginImage = '<div  class="jfbcButtonImg"><img src="' . JURI::root() . 'modules/mod_sclogin/fields/images/socialloginbuttons.png' . '"/></div>';
            $buyNow = '<div class="jfbcLearnMore"><a class="jfbc-btn-buynow" href="https://www.sourcecoast.com/l/jfbconnect-for-sclogin" target="_blank">Learn More</a></div>';

            return $jfbcNotDetected . $loginImage . $jfbcInstructions . $buyNow;
        }

        public function getLabel()
        {
            return "";
        }
    }
}
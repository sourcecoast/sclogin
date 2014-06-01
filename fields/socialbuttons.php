<?php

/**
 * @package        JFBConnect
 * @copyright (C) 2009-2014 by Source Coast - All rights reserved
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('JPATH_PLATFORM') or die;

jimport('joomla.form.helper');
jimport('joomla.filesystem.folder');

class JFormFieldSocialbuttons extends JFormField
{
    protected function getInput()
    {
        if (!class_exists('JFBCFactory'))
        {
            return "JFBConnect must be installed to enable social network integration into the SCLogin module";
        }

        require_once(JPATH_ADMINISTRATOR . '/components/com_jfbconnect/models/fields/providerloginbutton.php');
        $html = array();
        $data = $this->form->getData()->get('params.' . $this->fieldname);
        foreach (JFBCFactory::getAllProviders() as $p)
        {
            $value = (is_array($data) && array_key_exists($p->systemName, $data)) ? $data[$p->systemName] : $p->systemName . '_icon_label.png';
            $field = '<field type="providerloginbutton"
                    label="Default Login Button"
                    provider="' . $p->systemName . '"
                                name="' . $p->systemName . '"
                                required="true"
                                />';
            $element = new SimpleXMLElement($field);
            $node = new JFormFieldProviderloginbutton($this->form);
            $node->setup($element, $value, 'params.' . $this->fieldname);

            $html[] = $node->getInput();

        }
        return implode($html);
    }

}

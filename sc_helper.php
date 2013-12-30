<?php
/**
 * @package        JFBConnect/JLinked
 * @copyright (C) 2011-2013 by Source Coast - All rights reserved
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */
// no direct access
defined('_JEXEC') or die('Restricted access');

class SCLibraryUtilities
{
    static function getAffiliateLink($affiliateID, $extension)
    {
        if($extension == 'jfbconnect')
        {
            $defaultLink = 'http://www.sourcecoast.com/joomla-facebook/';
            $textLinkId = '495360';
        }
        else if($extension == 'jlinked')
        {
            $defaultLink = 'http://www.sourcecoast.com/jlinked/';
            $textLinkId = '495361';
        }
        else //SourceCoast
        {
            $defaultLink = 'http://www.sourcecoast.com/';
            $textLinkId = '495362';
        }

        if($affiliateID)
            return 'http://www.shareasale.com/r.cfm?b='.$textLinkId.'&u='.$affiliateID.'&m=46720&urllink=&afftrack=';
        else
            return $defaultLink;
    }

    static function getLinkFromMenuItem($itemId, $isLogout)
    {
        $app =JFactory::getApplication();
        $menu =& $app->getMenu();
        $item =& $menu->getItem($itemId);

        if($item)
        {
            if($item->type == 'url') //External menu item
            {
                $redirect = $item->link;
            }
            else if($item->type == 'alias') //Alias menu item
            {
                $aliasedId = $item->params->get('aliasoptions');

                if($isLogout && SCLibraryUtilities::isMenuRegistered($aliasedId))
                    $link = 'index.php';
                else
                    $link = SCLibraryUtilities::getLinkWithItemId($item->link, $aliasedId);
                $redirect = JRoute::_($link, false);
            }
            else //Regular menu item
            {
                if($isLogout && SCLibraryUtilities::isMenuRegistered($itemId))
                    $link = 'index.php';
                else
                    $link = SCLibraryUtilities::getLinkWithItemId($item->link, $itemId);
                $redirect = JRoute::_($link, false);
            }
        }
        else
            $redirect = '';

        return $redirect;
    }

    static function getLinkWithItemId($link, $itemId)
    {
        $app =JFactory::getApplication();
        $router = $app->getRouter();

        if($link)
        {
            if ($router->getMode() == JROUTER_MODE_SEF)
                $url = 'index.php?Itemid=' . $itemId;
            else
                $url = $link . '&Itemid=' . $itemId;
        }
        else
            $url = '';

        return $url;
    }

    static function isMenuRegistered($menuItemId)
    {
        $db = JFactory::getDBO();
        $query = "SELECT * FROM #__menu WHERE id=" . $db->quote($menuItemId);
        $db->setQuery($query);
        $menuItem = $db->loadObject();
        return ($menuItem && $menuItem->access != "1");
    }
}
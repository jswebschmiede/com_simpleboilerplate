<?php


/**
 * @package     com_simpleboilerplate
 * @version     1.0.0
 * @copyright   Copyright (C) 2024. All rights reserved.
 * @license     MIT License (MIT) see LICENSE.txt
 * @author      Jörg Schöneburg <info@joerg-schoeneburg.de> - https://joerg-schoeneburg.de
 */

namespace Joomla\Component\Simpleboilerplate\Site\Helper;

use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\Categories\CategoryNode;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Simpleboilerplate Component Route Helper.
 *
 * @since  1.5
 */
abstract class RouteHelper
{
    /**
     * Get the boilerplate route.
     *
     * @param   integer  $id        The route of the content item.
     * @param   string   $language  The language code.
     * @param   string   $layout    The layout value.
     *
     * @return  string  The boilerplate route.
     *
     * @since   1.5
     */
    public static function getSimpleboilerplateRoute($id, $language = null, $layout = null): string
    {
        // Create the link
        $link = 'index.php?option=com_simpleboilerplate&view=simpleboilerplate&id=' . $id;

        if (!empty($language) && $language !== '*' && Multilanguage::isEnabled()) {
            $link .= '&lang=' . $language;
        }

        if ($layout) {
            $link .= '&layout=' . $layout;
        }

        return $link;
    }
}

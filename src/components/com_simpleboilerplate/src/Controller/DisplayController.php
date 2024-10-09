<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_simpleboilerplate
 *
 * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Simpleboilerplate\Site\Controller;

use Joomla\CMS\MVC\Controller\BaseController;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Simpleboilerplate Controller
 *
 * @since  1.0.0
 */
class DisplayController extends BaseController
{
    public function display($cachable = false, $urlparams = false): BaseController
    {
        return parent::display($cachable, $urlparams);
    }
}

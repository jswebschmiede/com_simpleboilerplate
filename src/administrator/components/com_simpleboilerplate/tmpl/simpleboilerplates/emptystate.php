<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  com_simpleboilerplate
 *
 * @copyright   (C) 2021 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Layout\LayoutHelper;

/** @var \Joomla\Component\Simpleboilerplate\Administrator\View\Simpleboilerplates\HtmlView $this */

$displayData = [
    'textPrefix' => 'COM_SIMPLEBOILERPLATE',
    'formURL' => 'index.php?option=com_simpleboilerplate&view=simpleboilerplates',
    'icon' => 'icon-bookmark simpleboilerplates',
];

$user = $this->getCurrentUser();

if ($user->authorise('core.create', 'com_simpleboilerplate') || count($user->getAuthorisedCategories('com_simpleboilerplate', 'core.create')) > 0) {
    $displayData['createURL'] = 'index.php?option=com_simpleboilerplate&task=simpleboilerplate.add';
}

echo LayoutHelper::render('joomla.content.emptystate', $displayData);

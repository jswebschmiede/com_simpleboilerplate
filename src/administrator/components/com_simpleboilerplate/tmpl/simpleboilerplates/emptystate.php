<?php

/**
 * @package     com_simpleboilerplate
 * @version     1.0.0
 * @copyright   Copyright (C) 2024. All rights reserved.
 * @license     MIT License (MIT) see LICENSE.txt
 * @author      Jörg Schöneburg <info@joerg-schoeneburg.de> - https://joerg-schoeneburg.de
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

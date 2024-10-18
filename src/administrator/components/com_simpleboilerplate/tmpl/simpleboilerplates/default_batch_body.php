<?php

/**
 * @package     com_simpleboilerplate
 * @version     1.0.0
 * @copyright   Copyright (C) 2024. All rights reserved.
 * @license     MIT License (MIT) see LICENSE.txt
 * @author      Jörg Schöneburg <info@joerg-schoeneburg.de> - https://joerg-schoeneburg.de
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Language\Multilanguage;

/** @var \Joomla\Component\Simpleboilerplate\Administrator\View\Simpleboilerplates\HtmlView $this */

$state = $this->getState();
$published = (int) $state->get('filter.published');
?>

<div class="p-3">
    <div class="row">
        <?php if (Multilanguage::isEnabled()): ?>
            <div class="form-group col-md-6">
                <div class="controls">
                    <?php echo LayoutHelper::render('joomla.html.batch.language', []); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <div class="row">
        <?php if ($published >= 0): ?>
            <div class="form-group col-md-6">
                <div class="controls">
                    <?php echo LayoutHelper::render('joomla.html.batch.item', ['extension' => 'com_simpleboilerplate']); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<div class="btn-toolbar p-3">
    <joomla-toolbar-button task="simpleboilerplate.batch" class="ms-auto">
        <button type="button" class="btn btn-success"><?php echo Text::_('JGLOBAL_BATCH_PROCESS'); ?></button>
    </joomla-toolbar-button>
</div>
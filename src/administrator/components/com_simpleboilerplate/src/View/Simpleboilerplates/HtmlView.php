<?php

/**
 * @package     com_simpleboilerplate
 * @version     1.0.0
 * @copyright   Copyright (C) 2024. All rights reserved.
 * @license     MIT License (MIT) see LICENSE.txt
 * @author      Jörg Schöneburg <info@joerg-schoeneburg.de> - https://joerg-schoeneburg.de
 */

namespace Joomla\Component\Simpleboilerplate\Administrator\View\Simpleboilerplates;

defined('_JEXEC') or die;

use Joomla\CMS\Form\Form;
use Joomla\CMS\Language\Text;
use Joomla\Registry\Registry;
use Joomla\CMS\Toolbar\Toolbar;
use Joomla\CMS\Helper\ContentHelper;
use Joomla\CMS\Pagination\Pagination;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\MVC\View\GenericDataException;
use Joomla\CMS\Toolbar\Button\DropdownButton;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;

/**
 * View class for a list of boilerplates.
 *
 * @since  1.0.0
 */
class HtmlView extends BaseHtmlView
{
	/**
	 * The search tools form
	 *
	 * @var    Form
	 * @since  1.0.0
	 */
	public $filterForm;

	/**
	 * The active search filters
	 *
	 * @var    array
	 * @since  1.0.0
	 */
	public $activeFilters = [];

	/**
	 * An array of items
	 *
	 * @var    array
	 * @since  1.0.0
	 */
	protected $items = [];

	/**
	 * The pagination object
	 *
	 * @var    Pagination
	 * @since  1.0.0
	 */
	protected $pagination;

	/**
	 * The model state
	 *
	 * @var    Registry
	 * @since  1.0.0
	 */
	protected $state;

	/**
	 * Is this view an Empty State
	 *
	 * @var  boolean
	 * @since 1.0.0
	 */
	private $isEmptyState = false;

	/**
	 * Get the state
	 *
	 * @return Registry
	 */
	public function getState(): Registry
	{
		return $this->state;
	}

	/**
	 * Get the items
	 *
	 * @return array
	 */
	public function getItems(): array
	{
		return $this->items;
	}

	/**
	 * Get the pagination
	 *
	 * @return Pagination
	 */
	public function getPagination(): Pagination
	{
		return $this->pagination;
	}


	/**
	 * Method to display the view.
	 *
	 * @param   string  $tpl  A template file to load. [optional]
	 *
	 * @return  void
	 *
	 * @since   1.0.0
	 * @throws  \Exception
	 */
	public function display($tpl = null): void
	{
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$this->state = $this->get('State');
		$this->filterForm = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters');

		if (!\count($this->items) && $this->isEmptyState = $this->get('IsEmptyState')) {
			$this->setLayout('emptystate');
		}

		// Check for errors.
		if (\count($errors = $this->get('Errors'))) {
			throw new GenericDataException(implode("\n", $errors), 500);
		}

		$this->addToolbar();

		// We do not need to filter by language when multilingual is disabled
		if (!Multilanguage::isEnabled()) {
			unset($this->activeFilters['language']);
			$this->filterForm->removeField('language', 'filter');
		}

		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 *
	 * @since   1.0.0
	 */
	protected function addToolbar(): void
	{
		$canDo = ContentHelper::getActions('com_simpleboilerplate');
		$user = $this->getCurrentUser();
		$toolbar = Toolbar::getInstance();

		ToolbarHelper::title(Text::_('COM_SIMPLEBOILERPLATE_MANAGER_BOILERPLATES'), 'bookmark simpleboilerplates');

		if ($canDo->get('core.create') || \count($user->getAuthorisedCategories('com_simpleboilerplate', 'core.create')) > 0) {
			$toolbar->addNew('simpleboilerplate.add');
		}

		if (!$this->isEmptyState && ($canDo->get('core.edit.state') || ($this->state->get('filter.published') == -2 && $canDo->get('core.delete')))) {
			/** @var  DropdownButton $dropdown */
			$dropdown = $toolbar->dropdownButton('status-group', 'JTOOLBAR_CHANGE_STATUS')
				->toggleSplit(false)
				->icon('icon-ellipsis-h')
				->buttonClass('btn btn-action')
				->listCheck(true);

			$childBar = $dropdown->getChildToolbar();

			if ($canDo->get('core.edit.state')) {
				if ($this->state->get('filter.published') != 2) {
					$childBar->publish('simpleboilerplates.publish')->listCheck(true);

					$childBar->unpublish('simpleboilerplates.unpublish')->listCheck(true);
				}

				if ($this->state->get('filter.published') != -1) {
					if ($this->state->get('filter.published') != 2) {
						$childBar->archive('simpleboilerplates.archive')->listCheck(true);
					} elseif ($this->state->get('filter.published') == 2) {
						$childBar->publish('publish')->task('simpleboilerplates.publish')->listCheck(true);
					}
				}

				$childBar->checkin('simpleboilerplates.checkin');

				if ($this->state->get('filter.published') != -2) {
					$childBar->trash('simpleboilerplates.trash')->listCheck(true);
				}
			}

			if ($this->state->get('filter.published') == -2 && $canDo->get('core.delete')) {
				$toolbar->delete('simpleboilerplates.delete', 'JTOOLBAR_EMPTY_TRASH')
					->message('JGLOBAL_CONFIRM_DELETE')
					->listCheck(true);
			}

			// Add a batch button
			if (
				$user->authorise('core.create', 'com_simpleboilerplate')
				&& $user->authorise('core.edit', 'com_simpleboilerplate')
				&& $user->authorise('core.edit.state', 'com_simpleboilerplate')
			) {
				$childBar->popupButton('batch', 'JTOOLBAR_BATCH')
					->popupType('inline')
					->textHeader(Text::_('COM_SIMPLEBOILERPLATE_BATCH_OPTIONS'))
					->url('#joomla-dialog-batch')
					->modalWidth('800px')
					->modalHeight('fit-content')
					->listCheck(true);
			}
		}

		if ($user->authorise('core.admin', 'com_simpleboilerplate') || $user->authorise('core.options', 'com_simpleboilerplate')) {
			$toolbar->preferences('com_simpleboilerplate');
		}
	}
}

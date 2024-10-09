<?php

/**
 * @package     com_simpleboilerplate
 * @version     1.0.0
 * @copyright   Copyright (C) 2024. All rights reserved.
 * @license     MIT License (MIT) see LICENSE.txt
 * @author      Jörg Schöneburg <info@joerg-schoeneburg.de> - https://joerg-schoeneburg.de
 */

namespace Joomla\Component\Simpleboilerplate\Administrator\View\Simpleboilerplate;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Language\Text;
use Joomla\Registry\Registry;
use Joomla\CMS\Toolbar\Toolbar;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\MVC\View\GenericDataException;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\Component\Content\Administrator\Helper\ContentHelper;
use Joomla\Component\Simpleboilerplate\Administrator\Model\SimpleboilerplateModel;

/**
 * View class for a list of boilerplates.
 *
 * @since   1.0.0
 */
class HtmlView extends BaseHtmlView
{


	/**
	 * An object of item
	 *
	 * @var    object
	 * @since  1.6
	 */
	protected $item;

	/**
	 * The model state
	 *
	 * @var    Registry
	 * @since  1.6
	 */
	protected $state;

	/**
	 * Filter form
	 *
	 * @var    \JForm
	 * @since  1.6
	 */
	protected $form;

	/**
	 * The actions the user is authorised to perform
	 *
	 * @var  \JObject
	 */
	protected $canDo;

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
	 * Get the form
	 *
	 * @return Form
	 */
	public function getForm(): Form
	{
		return $this->form;
	}

	/**
	 * Get the item
	 *
	 * @return object
	 */
	public function getItem(): object
	{
		return $this->item;
	}

	/**
	 * Method to display the view.
	 *
	 * @param   string  $tpl  A template file to load. [optional]
	 *
	 * @return  void
	 *
	 * @since   1.6
	 * @throws  \Exception
	 */
	public function display($tpl = null): void
	{
		$this->form = $this->get('Form');
		$this->item = $this->get('Item');
		$this->state = $this->get('State');

		if (count($errors = $this->get('Errors'))) {
			throw new GenericDataException(implode("\n", $errors), 500);
		}

		$this->addToolbar();

		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 *
	 * @throws \Exception
	 * @since   1.6
	 */
	protected function addToolbar(): void
	{
		Factory::getApplication()->getInput()->set('hidemainmenu', true);

		$user = $this->getCurrentUser();
		$isNew = ($this->item->id == 0);
		$toolbar = Toolbar::getInstance();

		$canDo = ContentHelper::getActions('com_simpleboilerplate');

		ToolbarHelper::title($isNew ? Text::_('COM_SIMPLEBOILERPLATE_MANAGER_BOILERPLATE_NEW') : Text::_('COM_SIMPLEBOILERPLATE_MANAGER_BOILERPLATE_EDIT'), 'bookmark simpleboilerplates');

		// If not checked out, can save the item.
		if ($canDo->get('core.edit') || \count($user->getAuthorisedCategories('com_simpleboilerplate', 'core.create')) > 0) {
			$toolbar->apply('simpleboilerplate.apply');
		}

		$saveGroup = $toolbar->dropdownButton('save-group');

		$saveGroup->configure(
			function (Toolbar $childBar) use ($canDo, $user, $isNew): void {
				// If not checked out, can save the item.
				if ($canDo->get('core.edit') > 0) {
					$childBar->save('simpleboilerplate.save');

					if ($canDo->get('core.create')) {
						$childBar->save2new('simpleboilerplate.save2new');
					}
				}

				// If an existing item, can save to a copy.
				if (!$isNew && $canDo->get('core.create')) {
					$childBar->save2copy('simpleboilerplate.save2copy');
				}
			}
		);

		if (empty($this->item->id)) {
			$toolbar->cancel('simpleboilerplate.cancel', 'JTOOLBAR_CANCEL');
		} else {
			$toolbar->cancel('simpleboilerplate.cancel');

			if (ComponentHelper::isEnabled('com_contenthistory') && $this->state->params->get('save_history', 0) && $canDo->get('core.edit')) {
				$toolbar->versions('com_simpleboilerplate.simpleboilerplate', $this->item->id);
			}
		}
	}
}

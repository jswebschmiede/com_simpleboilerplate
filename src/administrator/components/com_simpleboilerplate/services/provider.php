<?php
/**
 * @package     com_simpleboilerplate
 * @version     1.0.0
 * @copyright   Copyright (C) 2024. All rights reserved.
 * @license     MIT License (MIT) see LICENSE.txt
 * @author      Jörg Schöneburg <info@joerg-schoeneburg.de> - https://joerg-schoeneburg.de
 */

defined('_JEXEC') or die;

use Joomla\DI\Container;
use Joomla\CMS\HTML\Registry;
use Joomla\DI\ServiceProviderInterface;
use Joomla\CMS\Extension\ComponentInterface;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use Joomla\CMS\Extension\Service\Provider\MVCFactory;
use Joomla\CMS\Component\Router\RouterFactoryInterface;
use Joomla\CMS\Extension\Service\Provider\RouterFactory;
use Joomla\CMS\Dispatcher\ComponentDispatcherFactoryInterface;
use Joomla\CMS\Extension\Service\Provider\ComponentDispatcherFactory;
use Joomla\Component\Simpleboilerplate\Administrator\Extension\SimpleboilerplateComponent;

// Load Composer autoloader (uncomment if you want to use dependencies)
// require_once JPATH_ADMINISTRATOR . '/components/com_simpleboilerplate/dependencies/vendor/autoload.php';

/**
 * The simpleboilerplate service provider.
 *
 * @since  4.0.0
 */
return new class implements ServiceProviderInterface {
	/**
	 * Registers the service provider with a DI container.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  void
	 *
	 * @since   4.0.0
	 */
	public function register(Container $container): void
	{
		$container->registerServiceProvider(new MVCFactory('\\Joomla\\Component\\Simpleboilerplate'));
		$container->registerServiceProvider(new ComponentDispatcherFactory('\\Joomla\\Component\\Simpleboilerplate'));
		$container->registerServiceProvider(new RouterFactory('\\Joomla\\Component\\Simpleboilerplate'));

		$container->set(
			ComponentInterface::class,
			function (Container $container): SimpleboilerplateComponent {
				$component = new SimpleboilerplateComponent($container->get(ComponentDispatcherFactoryInterface::class));

				$component->setRegistry($container->get(Registry::class));
				$component->setMVCFactory($container->get(MVCFactoryInterface::class));
				$component->setRouterFactory($container->get(RouterFactoryInterface::class));

				return $component;
			}
		);
	}
};

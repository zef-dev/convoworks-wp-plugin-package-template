<?php

/*
Plugin Name: Convoworks Wp Plugin Package Template
Plugin URI: https://github.com/zef-dev/convoworks-wp-plugin-package-template
Description: Example Plugin which provides additional features such as additional element, intents, entities, functions, template for Convoworks WP Plugin.
Version: 1.0
Author: ZEF Development
Author URI: https://github.com/zef-dev
License: A "Slug" license name e.g. GPL2
*/


use MyNamespace\Pckg\MyExample\MyExamplePackageDefinition;

require_once __DIR__.'/vendor/autoload.php';

/**
 * @param Convo\Core\Factory\PackageProviderFactory $packageProviderFactory
 * @param Psr\Container\ContainerInterface $container
 */
function my_package_registratior($packageProviderFactory, $container) {
	if (class_exists('\Convo\Core\Factory\FunctionPackageDescriptor')) {
		$packageProviderFactory->registerPackage(
			new Convo\Core\Factory\FunctionPackageDescriptor(
				MyExamplePackageDefinition::class,
				function() use ( $container) {
					return new MyExamplePackageDefinition( $container->get('logger'));
				}));
	}
}
add_action( 'register_convoworks_package', 'my_package_registratior', 10, 2);
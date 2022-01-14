# Convoworks WP Plugin Package Template
This plugin template provides a package of example element, intents, entities, function and a template which extends the existing Convoworks WP Plugin.

You can also add additional functionality to convoworks from your existing plugin or theme by registering your own package like this:
```php
use MyNamespace\Pckg\MyExample\MyExamplePackageDefinition;

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
```
## Prepare to install on your WordPress Site
* Just create a zip file with which contains the code for extending the Convoworks WP functionality
* upload the created zip file to your WP site in the admin dashboard at the Add Plugins view
* then enable your recently created package in Convoworks -> Configure packages
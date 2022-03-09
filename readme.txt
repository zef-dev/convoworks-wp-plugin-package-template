=== Convoworks WP Plugin Package Template ===
Contributors: zefdev
Donate link: https://convoworks.com/
Tags: convoworks
Requires at least: 5.0
Tested up to: 5.8
Requires PHP: 7.2
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Extend the capabilities of your Convoworks WP Plugin by creating your own Elements, Data Sources, Functions, Intents and Entities.

== Description ==
You can also add additional functionality to convoworks from your existing plugin or theme by registering your own package like this:
```php
function my_package_register($packageProviderFactory, $container) {
    $packageProviderFactory->registerPackage(
        new Convo\Core\Factory\FunctionPackageDescriptor(
            MyExamplePackageDefinition::class,
            function() use ( $container) {
                return new \MyNamespace\Pckg\MyExample\MyExamplePackageDefinition( $container->get('logger'));
            }));
}
add_action( 'register_convoworks_package', 'my_package_register', 10, 2);
```
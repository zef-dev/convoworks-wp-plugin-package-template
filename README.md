# Convoworks WP Plugin Package Template
This plugin template provides a package of example element, intents, entities, function and a template which extends the existing Convoworks WP Plugin.

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
## Prepare to install on your WordPress Site
1. just upload the included zip file in the example folder
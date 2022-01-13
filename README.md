# Convoworks WP Plugin Package Template
This plugin template provides a package of example element, intents, entities, function and a template which extends the existing Convoworks WP Plugin
## Preparation for development
Just run composer install to create the vendor folder so that autoload can load all the necessary classes.
## Prepare to install on your WordPress Site
* Just create the zip file with name convoworks-my-package-wp.zip
* place the following files and folders in that zip
    * src
    * vendor
    * convoworks-wp-plugin-package-template.php (rename file to your needs)
* upload the created zip file to your WP site in the admin dashboard at the Add Plugins view
* then enable the "convo-my-package" package in convoworks -> Configure packages
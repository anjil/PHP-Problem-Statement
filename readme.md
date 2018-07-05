Pre-requisite

 PHP >= 7.0
 MySql = 5.5
 Apache = 2.4.7

Setup in ubuntu

PHP modules ( Listed module(s) are not installed by default )
    > sudo apt-get install php7.0-xml

Restart apache after running above command

Laravel Setup

1. If PHP version is 7.0.x (https://github.com/laravel/framework/issues/20255)
    > sudo composer require doctrine/instantiator ^1.0.2 --update-with-dependencies

2. If PHP version is 7.1.x
    > sudo composer install


Permission
    > sudo chown -R www-data:www-data /var/www/html/assignment/
	
	
Setup:
1. Run the .sql file in _sq; folder
2. composer install
3. localhost/<DIR_NAME>/public

Default User Name: admin@pro.com
Password: 123456
Co-design
=========

This is pilot software for the Co-design programme, based on 
[Project REALISE](https://github.com/AccessAtECS/Project-REALISE).

Database Setup
--------------

Create a MySQL database called `codesign_production` and a user login to
access it (you may need to be mysql-root to do this):

    $ mysql -u root 
    mysql> CREATE DATABASE codesign_production;
    mysql> GRANT ALL PRIVILEGES ON codesign_production.* TO SOME-USER@localhost IDENTIFIED BY 'SOME-PASSWORD';
    mysql> quit

Next, build the database by running the `sql/codesign_production.sql` script:

    $ mysql -u root codesign_development < sql/codesign_production.sql


Application Configuration
-------------------------

Create a `system_configuration.php` in the root application folder (the same 
folder as this file is in). It should define the database connection
parameters, e.g.

    <?php
    define('MYSQL_SERVER', '0.0.0.0');
    define('MYSQL_USERNAME', 'SOME-USER');
    define('MYSQL_PASSWORD', 'SOME-PASSWORD');
    define('MYSQL_SCHEMA', 'codesign_production');
    ?>

Create an `.htaccess` file in the root application folder. The application
should be served with Apache. Configure the following rewrite rules, to ensure
requests are processed by index.php:

    # .htaccess file for co-design
    RewriteEngine on

    # don't rewrite existing files (e.g. images, javascript)
    RewriteCond %{REQUEST_FILENAME} !-f

    # don't rewrite existing directories
    RewriteCond %{REQUEST_FILENAME} !-d

    # rewrite all other requests to index.php
    RewriteRule ^(.*)$ /index.php?p=$1

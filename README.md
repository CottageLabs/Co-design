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


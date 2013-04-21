Co-design
=========

This is pilot software for the Co-design programme, based on [Project REALISE](https://github.com/AccessAtECS/Project-REALISE).

Database setup
--------------

Create a MySQL database called `codesign_production` and a user login to access it (you may need to be mysql-root to do this):

    $ mysql -u root 
    mysql> CREATE DATABASE codesign_production;
    mysql> GRANT ALL PRIVILEGES ON codesign_production.* TO SOME-USER@localhost IDENTIFIED BY 'SOME-PASSWORD';
    mysql> quit

Next, build the database by running the `sql/codesign_production.sql` script:

    $ mysql -u root codesign_development < sql/codesign_production.sql

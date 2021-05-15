.. index:: Installation

Installation
============

There are several ways to install app.

- AWS Marketplace
- Docker installation
- Regular installation

AWS Marketplace
---------------

There is an AWS Marketplace prebuild app: https://aws.amazon.com/marketplace/pp/Nikeev-SesDashboard/B08DQ5CY6T

Docker installation
-------------------
* Git clone ``https://github.com/Nikeev/sesdashboard.git``
* Copy ``.env`` file to ``.env.local``
* Fill database parameters in ``.env.local`` with your MySQL credentials
* Run

::

$ docker-compose up -d
$ docker exec -it sesdashboard-php-fpm composer install
$ docker exec -it sesdashboard-php-fpm ./bin/console doctrine:migrations:migrate -n

* To create Admin user run

::

$ docker exec -it sesdashboard-php-fpm ./bin/console app:create-user --admin

* Go to http://your-ip/login or http://localhost/login

Regular installation
--------------------

* Download an app (download zip or git clone) to your web directory so your webserver should use /public/index.php
* Copy ``.env`` file to ``.env.local``
* Fill database parameters in ``.env.local`` with your MySQL credentials

::

$ composer install
$ ./bin/console doctrine:migrations:migrate -n

* To create Admin user run

::

$ ./bin/console app:create-user --admin

* (Optionally) If your server webroot is not /public directory you could create symlink to it. For example, if your server configured for /public_html directory, run

::

$ ln -s ~/sesdashboard/public ~/sesdashboard/public_html

* Go to http://your-ip/login or http://localhost/login

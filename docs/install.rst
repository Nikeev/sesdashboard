.. index:: Installation

Installation
============

There are several ways to install app.

- AWS Marketplace
- Docker installation
- Shared hosting installation

AWS Marketplace
---------------

There is an AWS Marketplace prebuild app: https://aws.amazon.com/marketplace/pp/Nikeev-SesDashboard/B08DQ5CY6T

Docker installation
-------------------
* Make sure you have Docker, Docker-compose, Git, Makefile installed
* ``git clone https://github.com/Nikeev/sesdashboard.git``
* Copy ``.env`` file to ``.env.local``
* Fill database parameters in ``.env.local`` with your MySQL credentials
* Run

::

$ make init

* After Docker and App init completed you will be asked to create admin user. The username must contain only lowercase latin characters and underscores.

* Go to http://your-ip/login or http://localhost/login

Shared hosting or vhost installation
---------------------------

* Download an app (download zip or git clone) to your web directory so your webserver should use /public/index.php
* Rename or remove the ``/public/.htaccess`` file if you don't use Apache.
* Check the [example nginx  config](https://github.com/Nikeev/sesdashboard/issues/70#issuecomment-2028008350) if you're using nginx.
* Copy ``.env`` file to ``.env.local``
* Fill database parameters in ``.env.local`` with your MySQL credentials. [Make sure your serverVersion is correct](https://github.com/Nikeev/sesdashboard/issues/70#issuecomment-2027965022).
* [Create MySQL database and user, and grant privilages](https://github.com/Nikeev/sesdashboard/issues/70#issuecomment-2027989022)

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

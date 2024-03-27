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
* Git clone ``https://github.com/Nikeev/sesdashboard.git``
* Run

::

$ make init

* After Docker and App init completed you will be asked to create admin user

* Go to http://your-ip/login or http://localhost/login

Shared hosting installation
---------------------------

**Prerequisites:**

Requires [PHP Composer](https://getcomposer.org/). _([Composer uses more resources than Docker](https://github.com/Nikeev/sesdashboard/issues/2#issuecomment-2021967743))_


**Installation:**

* Download an app _([download zip](https://github.com/Nikeev/sesdashboard/releases) or git clone)_ to your web directory so your webserver should use /public/index.php _([example of folder structure](https://github.com/Nikeev/sesdashboard/issues/2#issuecomment-2021417798))_
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

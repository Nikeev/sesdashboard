.. index:: Upgrades

Upgrades
========

To install new version follow these steps:

* Make backup

* Git pull or download new version

* If your app uses Docker run:

::

$ make upgrade

* For non docker setup run:

::

$ composer install
$ ./bin/console doctrine:migrations:migrate -n
$ ./bin/console cache:clear
$ ./bin/console cache:warmup
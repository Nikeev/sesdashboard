.. index:: Upgrades

Upgrades
========

To install new version follow these steps:

* Make backup

* Git pull or download new version

* If your app uses Docker run:

::

$ docker exec -it sesdashboard-php-fpm composer install
$ docker exec -it sesdashboard-php-fpm ./bin/console doctrine:migrations:migrate -n
$ docker exec -it sesdashboard-php-fpm ./bin/console cache:clear
$ docker exec -it sesdashboard-php-fpm ./bin/console cache:warmup

* For regular setup run:

::

$ composer install
$ ./bin/console doctrine:migrations:migrate -n
$ ./bin/console cache:clear
$ ./bin/console cache:warmup
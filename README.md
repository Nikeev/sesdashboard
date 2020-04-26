# About #
SesDashboard is an Analytics UI for Amazon Simple Email Service.

With activity tracking tool you could check which email was successfully delivered or there we any problems. Also you will be able to view detailed events log like mail opens and clicks info.

SesDashboard works as stand-alone app. No existing code needs to be changed.

# Install App #

* Download an app (download zip or git clone)
* Copy _.env_ file to _.env.local_
* Fill database parameters in _.env.local_ with your MySQL credentials 
OR
* For docker-compose usage fill database parameters with any values and database will be created on first startup.
* Run `docker-compose up -d`
* `docker exec -it sesdashboard-php-fpm /bin/bash`
* `composer install`
* `./bin/console doctrine:migrations:migrate`
* To create user use `app:create-user` command
* Navigate `127.0.0.1:8083` or `YOUR_SERVER_IP:8083`

# Configure SES #

# TODO #
* Create Dashboard statistics
* Add search (Activity)
* Improve documentation
* Create Analytics reports
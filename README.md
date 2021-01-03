# About
SesDashboard is an Analytics UI for Amazon Simple Email Service.

With activity tracking tool you could check which email was successfully delivered or there we any problems. Also you will be able to view detailed events log like mail opens and clicks info. Useful for transactional mails.

SesDashboard works as stand-alone app. No existing code needs to be changed.

# Install App

### With Docker
* Copy _.env_ file to _.env.local_
* Fill database parameters in _.env.local_ with your MySQL credentials
* Run 
  ```console
  $ docker-compose up -d
  $ docker exec -it sesdashboard-php-fpm composer install
  $ docker exec -it sesdashboard-php-fpm ./bin/console doctrine:migrations:migrate -n
  ```
* To create Admin user run `docker exec -it sesdashboard-php-fpm ./bin/console app:create-user --admin` command

### Regular installation
* Download an app (download zip or git clone) to your web directory so your webserver should use _/public/index.php_
* Copy _.env_ file to _.env.local_
* Fill database parameters in _.env.local_ with your MySQL credentials
* `composer install`
* `./bin/console doctrine:migrations:migrate -n`
* To create Admin user run `app:create-user --admin` command

### Done!
* Navigate to `http://127.0.0.1` or `http://YOUR_SERVER_IP` and log in with user credentials


# Configure SES
* Go to Amazon Simple Email Service (SES) console and select Configuration Sets menu.
* Click `Create Configuration Set` or edit your existing set.
* Add new SNS Destination, select events to track and create SNS topic.
* Next, navigate to Amazon Simple Notification Service (SNS).
* In `Topics` section select topic you created before.
* Add new subscription with HTTP (or HTTPS protocol if configured) and paste WebHook url from `/project/1/edit` SesDashboard project page. Check Enable raw message delivery. 

# Updates
* Make backup
* Git pull or download new version
* If your app uses Docker run:<br />
  ```console
  $ docker exec -it sesdashboard-php-fpm composer install
  $ docker exec -it sesdashboard-php-fpm ./bin/console doctrine:migrations:migrate -n
  $ docker exec -it sesdashboard-php-fpm ./bin/console cache:clear
  $ docker exec -it sesdashboard-php-fpm ./bin/console cache:warmup
  ```
* For regular setup run:<br />
  ```console
  $ composer install
  $ ./bin/console doctrine:migrations:migrate -n
  $ ./bin/console cache:clear
  $ ./bin/console cache:warmup
  ```

# TODO
* Create Dashboard statistics
* Improve documentation
* Create Analytics reports
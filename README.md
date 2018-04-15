Currency Convertor
==================================

# Start project (Mac)

Docker is required to be installed on the machinw

  * Clone repository `git clone https://github.com/pirvulescu/currency_docker_symfony.git`
  * Open directory  `cd currency_docker_symfony`
  * Start docker containers: `docker-compose up -d`
  * Log in to the PHP7 image: `docker-compose exec php-fpm bash`
  * install the project: `composer install`
  
Application will be available at the URL http://localhost:8082
  
# Run unit test  
  
   * Log in to the PHP7 image: `docker-compose exec php-fpm bash`
   * Execute: `php bin/phpunit`
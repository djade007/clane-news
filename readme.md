## About Clane News

Clane news is a platform that gives you the freedom to read breaking and trending news stories from Nigeria, and around the world.
#
The Dockerfile consists of basic apache document root config, mod_rewrite and mod_header, composer and sync container's uid with host uid.

docker-compose.yml boots up php-apache (mount app files) and mysql (mount db files), using networks to interconnect. 

## Installing Clane news api

Built with Laravel and Dockerised, this api project can be installed by following the simple steps below.
- `docker-compose build && docker-compose up -d && docker-compose logs -f`
- Run the project setup script `./setup`


## Helper Scripts
Some helpers scripts were created to ease working with the project interface with docker.
- `./setup` - To setup the entire project.
- `./php-artisan` - To run laravel's artisan commands
- `./phpunit` - To run PHP unit tests
- `./db` - To access the mysql command
- `./container` - To ssh into the docker container


## Additional Packages to The Laravel Framework
- **[jwt-auth](https://github.com/tymondesigns/jwt-auth/tree/1.0.0-rc.5)**
- **[spatie/laravel-sluggable](https://github.com/spatie/laravel-sluggable)**

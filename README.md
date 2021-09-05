# cv_sonnt
1. PREPARE
    - Install Docker desktop on your PC ( https://www.docker.com/products/docker-desktop )
    - If it running on Windows OS, switch to Linux OS
    - Create file `.env`, refer `.env.example`
2. BUILD
    - Open cmd/shell in root folder [ **\01_Sourcecode\cv_nguyentrongson** ]
    - Run command : *`docker-compose build`* for build image
    - Run command : *`docker-compose up -d`* for start db and web service
    - Run command : *`docker-compose exec cv_app composer install`* for install packeges
    - Run command : *`docker-compose exec cv_app php artisan key:generate`* for create app key
    - Run command : *`docker-compose exec cv_app php artisan config:cache`* for cache settings into a file
    - Web service running default on : **localhost:2213**
3. NOTE
    - If wanna to change post of web service, go to file docker-compose.yml and change port of web service
	- If you need to run command line in docker, run this: *`docker exec -it toploop_app bash`*

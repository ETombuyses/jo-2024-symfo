# JO-2024 G7 - API

Back-end expertise : Emilie Tombuyses

Front-end repository : https://github.com/ETombuyses/jo2024-front

## Used technologies

Symfony 4

## Back-end expertise

You can find my expertise report in this repository (dossier-expertise-back-end.pdf)
Have a nice reading !

## How to use the API ? 

### Documentation
API documentation : https://jo2024g7.docs.apiary.io/#

### Installation
To use the API, first clone this repository. Then run composer install in the project :

> composer install

Then you have to create the database. 
In order to do so you can either import the jo_2024_database_full.sql form PHP my admin or import it via command line from the database/database_creation folder with the following command :
> mysql -u <username> -p <password> < jo_2024_database_full.sql

replace <username> and <password> by your personal username and password for mysql.

Then start you mysql server or keep you Mamp / Xampp running
> mysql.server start


You can now modify the .env file to suit your configuration. Replace the root username, add a password if necessary and change you sql port if necessary too.
> DATABASE_URL=mysql://root:@127.0.0.1:3306/jo_2024?serverVersion=5.7

### Run the API
You can now run the command : 
>php -S 127.0.0.1:8080 -t public 

The port needs to be 8080 or the front-end part of the project will not work.

You can now open you browser on http://127.0.0.1:8080/ and use the API documentation to test the routes.


## To know more about the database creation :
Check the database folder. It includes the original JSON files and the PHP script used to insert the data into the database.



<p  align="right">
<a  href="https://www.dropee.com/"  target="_blank"><img  src="https://www.dropee.com/themes/stampede_1/images/logo-orange.png"  width="140"></a></p>
<p  align="right"><a  href="https://laravel.com"  target="_blank"><img  src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg"  width="150"></a>
</p>

  
## Instruction

  

Pre-requisites, need to install Composer, NPM, Apache and MySQL service according to your preference, can use for example [Laragon](https://laragon.org/)

After done install all required services, may follow these step:

1. Clone this repo
2. Make sure .env file has been set
3. Install required Composer package
	```
	composer install
	```
4. Install required NPM package
	```
	npm install
	```
5. Compile assets
	```
	npm run prod
	```
6. Run migration
	```
	php artisan migrate
	```
7. Run specific seeder
	```
	php artisan db:seed --class=InitSeeder
	```
8. Optimize the project
	```
	php artisan optimize
	```

  



  

## Accessing the content

  
By default, the user's email and password will be:
Email: admin@email.com
Password: 123456

1. To display data, may go to this URL
	```
	/sentences/admin@email.com
	```
2. To edit data, may go to this URL
	```
	/admin/login
	```
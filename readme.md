1. Extract the archive and put it in the folder you want

2. Prepare your .env file there with database connection and other settings

3. Run "composer install" command

4. Run "php artisan migrate --seed" command. Notice: seed is important, because it will create the first admin user for you.

5. Run "php artisan key:generate" command.

Email: admin@admin.com
Password: password

Notice: if you use CKEditor fields, there are a few more commands to launch for Laravel Filemanager package:
php artisan vendor:publish --tag=lfm_config
php artisan vendor:publish --tag=lfm_public

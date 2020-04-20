# Laravel Support Package

### You can easily add support system in your laravel application

### How to Install

1. You can install the package via composer:

``` bash 
composer require flexibleit/support
```

2. You need to run the vendor publish to give your specific configuration

``` bash 
php artisan vendor:publish --provider="Flexibleit\Support\SupportServiceProvider"
```

3. You need to run the migration

``` bash
php artisan migrate
```

4. You need to set your mail configuration in the env file to send email

```
MAIL_USERNAME=yourmailusername
MAIL_PASSWORD=yoursmptpemailpassword
MAIL_ENCRYPTION=tls
```

Okay all set. You can use it.
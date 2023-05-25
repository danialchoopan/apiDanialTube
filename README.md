<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About danial tube

danialTubeApi is a simple api for the [danialTubeApp](https://github.com/danialchoopan/DanialTube)
i used LaravelSanctum for token auth

## how setup project
### run composer comment
```
composer update
```
### migrate tables
```
php artisan migrate
```
this app use sms.ir for sending validation sms code 
and idpay
if you want use default api add this to the .env file
```
UserApiKey={sms ir}
SecretKey={sms ir}

idPayApiKey={id pay api key}

SMS_DOT_IR_RESTFUL_URL_SEND_SMS=http://RestfulSms.com/api/MessageSend

SMS_DOT_IR_RESTFUL_URL_GET_TOKEN=https://RestfulSms.com/api/Token
```
you can use other api services by changing the api/authUserColtroller.php

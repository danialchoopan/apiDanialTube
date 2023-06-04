<p align="center">

<img src="img/danialtub.png" width="200">

</p>

<p align="center">
<img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License">
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

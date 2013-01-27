#setup

*taobao app_key app_secret
*mkdir cache & complie under root dir

#this project base on
>1. Slim Framework
>
>2. Twig Template
>
>3. Taobao Open API

you can read Slim Framework document to change the request params for different
category or other api. 

##for example
```php
$app->get('/:params', function($functionName) use ($twig) {
	// todo	
});
```

[www.shibeike.com](http://www.shibeike.com/)
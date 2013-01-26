<?php

error_reporting(E_ALL);
date_default_timezone_set('Asia/Shanghai');

define('DIR', __DIR__);
define('TB_APP_KEY', 'xxxxxxxx');
define('TB_APP_SECRET', 'xxxxxxxxxxxxxxxxxxxxxxxx');
define('T', DIR . DIRECTORY_SEPARATOR . 'templates');

set_include_path(implode(PATH_SEPARATOR, array(
	get_include_path(),
	implode(DIRECTORY_SEPARATOR, array(
		DIR,
		'lib',
	)),
)));

require 'Twig/Autoloader.php';
require 'Slim/Slim.php';
require 'api/taobao/TopSdk.php';
require 'Tdata.php';

Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem(T);
$twig   = new Twig_Environment($loader, array(
	'cache' => DIR . '/compile/',
));

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

// $cates = Tdata::getAllCategory();

/**
*  	[16] => 女装/女士精品 [50006843] => 女鞋 
*	[50020808] => 家居饰品
*	[50010788] => 彩妆/香水/美妆工具
*	[1801] => 美容护肤/美体/精油 
*	[1625] => 女士内衣/男士内衣/家居服
*
*/ 

$app->get('/', function() use ($twig) {
	
	$all = Tdata::getTmallRecommended(16);
	$tpl = $twig->loadTemplate('index.html');
	$tpl->display(array(
		'items' => $all,
	));

});

$app->get('/shoes', function() use ($twig) {

	$all = Tdata::getTmallRecommended(50006843);
	$tpl = $twig->loadTemplate('index.html');
	$tpl->display(array(
		'items' => $all,
	));

});

$app->get('/skin', function() use ($twig) {

	$all = Tdata::getTmallRecommended(1801);
	$tpl = $twig->loadTemplate('index.html');
	$tpl->display(array(
		'items' => $all,
	));

});

$app->get('/face', function() use ($twig) {

	$all = Tdata::getTmallRecommended(50010788);
	$tpl = $twig->loadTemplate('index.html');
	$tpl->display(array(
		'items' => $all,
	));

});

$app->get('/home', function() use ($twig) {

	$all = Tdata::getTmallRecommended(50020808);
	$tpl = $twig->loadTemplate('index.html');
	$tpl->display(array(
		'items' => $all,
	));

});

$app->get('/short', function() use ($twig) {

	$all = Tdata::getTmallRecommended(1625);
	$tpl = $twig->loadTemplate('index.html');
	$tpl->display(array(
		'items' => $all,
	));

});

$app->run();

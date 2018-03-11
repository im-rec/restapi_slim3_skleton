<?php

$app->get('/', function ($request, $response, $args) {
    return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode(['code'=>200, 'msg'=>'Wecome To berrybenka Service']));
});

$app->get('/user', '\User:home');
$app->get('/user_call_uid_controller', '\User:call_another_controller');
$app->get('/user_call_uid_service', '\User:call_another_service');
$app->get('/user_call_uid_model', '\User:call_another_model');
$app->get('/user_call_external_class', '\User:call_external_class');
$app->get('/redis_test', '\User:coba_redis');
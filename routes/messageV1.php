<?php

$router->group(['prefix' => 'V1', 'namespace' => 'V1'], function () use ($router){
    $router->post('Register', 'UsersController@UserRegister');
    $router->post('Login', 'UsersController@UserLogin');
    $router->post('SendMessage', 'MessageController@SendMessage');
    $router->post('ReceiveMessage', 'MessageController@listReceiveMessage');
    $router->post('ListMessage', 'MessageController@listMessage');
});
<?php

spl_autoload_register(function($class) {
    if (file_exists('./models/' . $class . '.php')) {
        require './models/' . $class . '.php';
    } elseif (file_exists('./controllers/' . $class . '.php')) {
        require './controllers/' . $class . '.php';
    } elseif (file_exists('./services/' . $class . '.php')) {
        require './services/' . $class . '.php';
    } elseif (file_exists('./views/' . $class . '.php')) {
        require './views/' . $class . '.php';
    }
});
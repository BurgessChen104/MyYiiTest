<?php
require_once('vendor/autoload.php');

use \Rollbar\Rollbar;
use \Rollbar\Payload\Level;

// installs global error and exception handlers
Rollbar::init(
    array(
        //'access_token' => 'b43ef13df2bb41aeadf2e19c511ed5f9',
        //'environment' => 'development',
        //required POST_SERVER_ITEM_ACCESS_TOKEN
        'access_token' => 'b43ef13df2bb41aeadf2e19c511ed5f9',
        'environment' => 'LOCAL'
    )
);

// Message at level 'info'
//Rollbar::log(Level::info(), 'testing 123');

// Catch an exception and send it to Rollbar
/*
try {
    throw new \Exception('test exception');
} catch (\Exception $e) {
    Rollbar::log(Level::error(), $e);
}
*/

// Will also be reported by the exception handler
//throw new Exception('test 4');

Rollbar::log(Level::warning(), 'PHP warning TEST');
Rollbar::log(
    Level::info(), 
    'PHP info TEST ~~',
    array('x' => 10, 'code' => 'blue')
);

?>













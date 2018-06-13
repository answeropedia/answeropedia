<?php

/**
 * @return bool
 */
spl_autoload_register(function ($class_name) {
    $class_map = [

        'AWApp' => 'app/AWApp.php',

        # Helpers

        'FineDiff' => 'app/Helper/FineDiff/FineDiff.php',
        'PassHash' => 'app/Helper/PassHash.php',
        'KeyWordExtractor' => 'app/Helper/KeyWordExtractor/KeyWordExtractor.php',
        'Lang' => 'app/Helper/Lang.php',
        'Localizer' => 'app/Helper/Localizer/Localizer.php',
        'PDOFactory' => 'app/Helper/PDOFactory.php',
        'CookieStorage' => 'app/Helper/CookieStorage.php',
        'ExtendedParsedown' => 'app/Helper/ExtendedParsedown/ExtendedParsedown.php',
        'Html2Text\Html2Text' => 'app/Helper/Html2Text.php',
        'HumanDate' => 'app/Humanizer/HumanDate/HumanDate.php',

        # Mailer`s

        'AbstractMailer' => 'app/Helper/Mailer/Abstract.php',
        'SubscriptionMailer' => 'app/Helper/Mailer/Subscription.php',

    ];

    // Auto-include classes as Show_Question_PageController
    if (strpos($class_name, '_') !== false) {

        $pieces = explode('_', $class_name);
        $pathPieces = array_reverse($pieces);
        $classPath = 'app/'.implode('/', $pathPieces).'.php';

        if (file_exists($classPath)) {
            require_once $classPath;
            if (class_exists($class_name)) {
                return true;
            }
        }
    }

    if (array_key_exists($class_name, $class_map)) {
        if (file_exists($class_map[$class_name])) {
            require_once $class_map[$class_name];
            if (class_exists($class_name)) {
                return true;
            }
        }
    }

    return false;
});
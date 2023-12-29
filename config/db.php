<?php

use yii\db\Connection;

$host = getenv('DB_EXAMPLE_HOST');
$dbname = getenv('DB_EXAMPLE_NAME');
$username = getenv('DB_EXAMPLE_USERNAME');
$password = getenv('DB_EXAMPLE_PASSWORD');

return [
    'class' => Connection::class,
    'dsn' => "mysql:host={$host};dbname={$dbname}",
    'username' => $username,
    'password' => $password,
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];

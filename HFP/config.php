<?php
return [
    'database' => [
        'driver'    => 'sqlsrv',
        'host'      => getenv('DB_HOST') ?: 'haarlemfestival.database.windows.net',
        'port'      => getenv('DB_PORT') ?: '1433',
        'database'  => getenv('DB_DATABASE') ?: 'haarlemprojectdatabase',
        'username'  => getenv('DB_USERNAME') ?: 'HaarelmFestival',
        'password'  => getenv('DB_PASSWORD') ?: 'Haarlem1234',
        'charset'   => 'utf8',
        'prefix'    => '',
    ],
];

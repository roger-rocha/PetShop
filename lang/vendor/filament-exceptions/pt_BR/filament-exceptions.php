<?php

return [

    'labels' => [
        'model' => 'Exception',
        'model_plural' => 'Exceptions',
        'navigation' => 'Bugs',
        'navigation_group' => 'Admin',

        'tabs' => [
            'exception' => 'Exception',
            'headers' => 'Headers',
            'cookies' => 'Cookies',
            'body' => 'Body',
            'queries' => 'Queries',
        ],
    ],

    'empty_list' => 'Tudo certo patrão! 😎',

    'columns' => [
        'method' => 'Método',
        'path' => 'Caminho',
        'type' => 'Tipo',
        'code' => 'Codígo',
        'ip' => 'IP',
        'occurred_at' => 'Ocorrido em',
    ],

];

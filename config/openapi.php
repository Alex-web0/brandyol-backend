<?php

use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;

return [

    'collections' => [

        'default' => [

            'info' => [
                'title' => config('app.name'),
                'description' => 'Brandyol App OpenApi Documentation',
                'version' => '1.0.0',
                'contact' => [],
            ],

            'servers' => [
                [
                    'url' => 'http://127.0.0.1:8000',
                    'description' => null,
                    'variables' => [],
                ],
            ],

            'tags' => [

                // [
                //    'name' => 'user',
                //    'description' => 'Application users',
                // ],

            ],

            'security' => [],

            // Non standard attributes used by code/doc generation tools can be added here
            'extensions' => [
                // 'x-tagGroups' => [
                //     [
                //         'name' => 'General',
                //         'tags' => [
                //             'user',
                //         ],
                //     ],
                // ],
            ],

            // Route for exposing specification.
            // Leave uri null to disable.
            'route' => [
                'uri' => '/openapi',
                'middleware' => [],
            ],

            // Register custom middlewares for different objects.
            'middlewares' => [
                'paths' => [
                    //
                ],
                'components' => [
                    //
                ],
            ],

        ],

    ],

    // Directories to use for locating OpenAPI object definitions.
    'locations' => [
        'callbacks' => [
            app_path('OpenApi/Callbacks'),
        ],

        'request_bodies' => [
            app_path('OpenApi/RequestBodies'),
        ],

        'responses' => [
            app_path('OpenApi/Responses'),
        ],

        'schemas' => [
            app_path('OpenApi/Schemas'),
        ],

        'security_schemes' => [
            app_path('OpenApi/SecuritySchemes'),
        ],
    ],

    'tags' => [

        [
            'name' => 'user',
            'description' => 'Users',
        ],

        [
            'name' => 'staff',
            'description' => 'Admins, Managers and Staff',

            // You may optionally add a link to external documentation like so:
            'externalDocs' => [
                'description' => 'External API documentation',
                'url' => 'https://example.com/external-docs',
            ],
        ],

    ],

];

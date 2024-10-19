<?php


return [
    'essentials' => [
        'id' => 1,
        'created_at' => '2024-09-20T07:49:27.000000Z',
        'updated_at' => '2024-09-20T07:49:27.000000Z',
    ],

    'meta' =>  [
        "current_page" => 1,
        "from" => 1,
        "last_page" => 1,
        "links" => [
            [
                "url" => null,
                "label" => "&laquo; Previous",
                "active" => false
            ],
            [
                "url" => "http://localhost:30000/api/v1/drivers/popular?page=1",
                "label" => "1",
                "active" => true
            ],
            [
                "url" => null,
                "label" => "Next &raquo;",
                "active" => false
            ]
        ],
        "path" => "http://localhost:30000/api/v1/drivers/popular",
        "per_page" => 15,
        "to" => 1,
        "total" => 1
    ],

    'links' => [
        "first" => "http://localhost:30000/api/v1/drivers/popular?page=1",
        "last" => "http://localhost:30000/api/v1/drivers/popular?page=1",
        "prev" => null,
        "next" => null
    ],
];

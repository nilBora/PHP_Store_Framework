<?php

$table = [
    "table" => [
        "name"       => "shortener_hosts",
        "primaryKey" => "id"
    ],
    "fields" => [
        "host" => [
            "type" => "text",
            "name" => "host",
            "caption" => "Host Name"
        ],
        "cdate" => [
            "type" => "datetime",
            "name" => "cdate",
            "caption" => "Date Created"
        ]
    ],
    "actions" => [
        "list" => [
            "type" => "list",
            "caption" => "Hosts"
        ],
        "edit" => [
            "type" => "edit",
            "caption" => "Edit Host ID#%id%"
        ],
        "remove" => [
            "type" => "remove",
            "caption" => "Delete"
        ]
    ]
];

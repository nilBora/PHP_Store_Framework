<?php

$table = [
    "table" => [
        "name"        => "shortener_links",
        "primaryKey"  => "id",
        "rowsForPage" => "100"
    ],
    "fields" => [
        "host" => [
            "type" => "text",
            "name" => "host",
            "caption" => "Host"
        ],
        "link" => [
            "type" => "text",
            "name" => "link",
            "caption" => "Link"
        ],
        "code" => [
            "type" => "text",
            "name" => "code",
            "caption" => "Code",
            "readonly" => true
        ],
        "cdate" => [
            "type" => "datetime",
            "name" => "cdate",
            "caption" => "Date Created"
        ]
    ],
    "listeners" => [
        [
            "name" => "BeforeInsert",
            "plugin" => "\App\Http\Controllers\ShortenerController",
            "method" => "onBeforeInsert"
        ],
        [
            "name" => "BeforeList",
            "plugin" => "\App\Http\Controllers\ShortenerController",
            "method" => "onBeforeList"
        ]
    ],
    "actions" => [
        "list" => [
            "type" => "list",
            "caption" => "Shortener List"
        ],
        "edit" => [
            "type" => "edit",
            "caption" => "Edit Short Link ID#%id%"
        ],
        "remove" => [
            "type" => "remove",
            "caption" => "Delete"
        ]
    ]

];

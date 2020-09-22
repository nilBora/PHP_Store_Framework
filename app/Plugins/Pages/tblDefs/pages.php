<?php

$table = [
    "table" => [
        "name"       => "pages",
        "primaryKey" => "id"
    ],
    "fields" => [
        "id_type" => [
            "type" => "foreignKey",
            "foreignTable" => "pages_type",
            "alias" => "type",
            "foreignKeyField" => "id",
            "foreignValueField" => "name",
            "name" => "id_type",
            "caption" => "Page"
        ],
        "name" => [
            "type" => "text",
            "name" => "name",
            "caption" => "File Input"
        ],
        "body" => [
            "type" => "text",
            "name" => "body",
            "caption" => "File Output"
        ]
    ],
    "actions" => [
        "list" => [
            "type" => "list",
            "caption" => "Pages"
        ],
        "edit" => [
            "type" => "edit",
            "caption" => "Edit Page ID#%id%"
        ],
        "remove" => [
            "type" => "remove",
            "caption" => "Delete"
        ]
    ]

];


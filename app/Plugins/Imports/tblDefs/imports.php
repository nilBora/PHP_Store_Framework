<?php

$table = [
    "table" => [
        "name"       => "shortener_imports",
        "primaryKey" => "id"
    ],
    "fields" => [
        "host" => [
            "type" => "text",
            "name" => "host",
            "caption" => "Host Name"
        ],
        "file_input" => [
            "type" => "text",
            "name" => "file_input",
            "caption" => "File Input"
        ],
        "file_output" => [
            "type" => "text",
            "name" => "file_output",
            "caption" => "File Output"
        ],
        "status" => [
            "type" => "text",
            "name" => "status",
            "caption" => "Status"
        ],
        "count" => [
            "type" => "text",
            "name" => "count",
            "caption" => "Count"
        ],
        "error" => [
            "type" => "textarea",
            "name" => "error",
            "caption" => "Error"
        ],
        "cdate" => [
            "type" => "datetime",
            "name" => "cdate",
            "caption" => "Date Created"
        ],
        "mdate" => [
            "type" => "datetime",
            "name" => "mdate",
            "caption" => "Date Modified"
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

<?php

$table = [
    "table" => [
        "name"       => "pages",
        "primaryKey" => "id",
        "model"      => \App\Plugins\Pages\Pages::class
    ],
    "fields" => [
        "name"     => [
            "type"    => "text",
            "name"    => "name",
            "caption" => "Page Name",
            "search"  => true
        ],
        "email"     => [
            "type"    => "text",
            "name"    => "email",
            "caption" => "Email"
        ],
        "password"     => [
            "type"    => "password",
            "name"    => "password",
            "caption" => "Password"
        ],
        "created_at"     => [
            "type"    => "datetime",
            "name"    => "created_at",
            "caption" => "Created Date",
            "format"  => "d-m-Y H:i",
        ],
        "updated_at"     => [
            "type"    => "datetime",
            "name"    => "updated_at",
            "caption" => "Updated Date",
            "format"  => "d-m-Y H:i"
        ],
        "cv"     => [
            "type"      => "file",
            "name"      => "cv",
            "caption"   => "User CV",
            "uploadDir" => storage_path('app/public')
        ],
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


<?php

use App\Plugins\PageComments\PageComments;

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
        "body"     => [
            "type"    => "textarea",
            "name"    => "body",
            "caption" => "Body"
        ],
        "id_type"  => [
            "type"              => "foreignKey",
            "foreignTable"      => "pages_type",
            "foreignModel"      => \App\Plugins\PagesType\PagesType::class,
            "alias"             => "type",
            "foreignKeyField"   => "id",
            "foreignValueField" => "name",
            "name"              => "id_type",
            "caption"           => "Type"
        ],
        "comments" => [
            "name"              => "comments",
            "type"              => "many2many",
            "caption"           => "Comments",
            "linkTable"         => "page2comments",
            "linkField"         => "id_page",
            "linkForeignField"  => "id_comment",
            "foreignTable"      => "page_comments",
            "foreignModel"      => \App\Plugins\PagesType\PageComments::class,
            "foreignKeyField"   => "id",
            "foreignValueField" => "name",
            "alias"             => "comments",
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


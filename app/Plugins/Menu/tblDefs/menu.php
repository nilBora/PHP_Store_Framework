<?php

$table = [
    "table" => [
        "name"       => "festi_menus",
        "primaryKey" => "id",
        "orderBy"    => "order_n ASC"
    ],
    "fields" => [
        "caption" => [
            "type" => "text",
            "name" => "caption",
            "caption" => "Host"
        ],
        "url" => [
            "type" => "text",
            "name" => "url",
            "caption" => "Link"
        ],
        "id_parent" => [
            "type" => "text",
            "name" => "id_parent",
            "caption" => "ID parent",
        ],
        "order_n" => [
            "type" => "text",
            "name" => "order_n",
            "caption" => "Order"
        ],
        "icon" => [
            "type" => "text",
            "name" => "icon",
            "caption" => "Icon"
        ]
    ],
    "actions" => [
        "list" => [
            "type" => "list",
            "caption" => "Menu List"
        ],
        "edit" => [
            "type" => "edit",
            "caption" => "Edit Menu ID#%id%"
        ],
        "remove" => [
            "type" => "remove",
            "caption" => "Delete"
        ]
    ]

];

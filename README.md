# Store Framework

Создание dgs
 
`App/Plugins/PluginName/tblDefs/PluginName.php`

### Роутинг
Роуты dgs заходет по шаблону REST и заходят в контроллер `ApiDefault`

`GET /{name} - list`

`GET /{name}/{id} - info`

`POST /{name} - create`

`POST /{name}/{id} - edit`

`DELETE /{name}/{id} - remove`



```php
<?php

$table = [
    "table" => [
        "name"       => "hosts",
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
```

```php
$store = new Store($name, new LaravelRequest($request), new LaravelProxy(), new Event(), $this->options);
$response = $store->createActionList();
```

### Search
`?search[name]=Page111&search[0][0]=body&search[0][1]=like&search[0][2]=%sdfsdf%`


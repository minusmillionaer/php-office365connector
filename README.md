kernpunkt OPS Office365Connector Client via Graph-API
=======================

## Installing kernpunkt OPS Office365Connector via composer

Add this to your "composer.json"
```json
"repositories": [
        {
            "url": "ssh://git@stash.kernarea.de:7999/ops/composer-office365connector.git",
            "type": "git"
        },
    ],
```

Now you can install "kernpunkt/office365connector" via composer
```bash
php composer.phar require "kernpunkt/office365connector": "^1.0"
```

## Use
```php
  $office = new Office365Connector('yourcompany.onmicrosoft.com', 'client-id', 'client-secret', 'https://graph.microsoft.com', 'client_credentials');
  dd($office->getUsers());
```

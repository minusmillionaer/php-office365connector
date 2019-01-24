kernpunkt OPS Office365Connector Client via Graph-API
=======================

## Installing kernpunkt OPS Office365Connector via composer

Add this to your "composer.json" and load your packages via kernpunkt satis composer proxy
```json
"repositories": [
        {
            "type": "composer",
            "url": "https://composer.kernarea.de"
        }
    ],
```

Now you can install "kernpunkt/office365connector" via composer
```bash
php composer.phar require "kernpunkt/office365connector": "dev-master#1.0"
```

## Use
```php
  $office = new Office365Connector('yourcompany.onmicrosoft.com', 'client-id', 'client-secret', 'https://graph.microsoft.com', 'client_credentials');
  dd($office->getUsers());
```

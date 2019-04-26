kernpunkt OPS Office365Connector Client via Graph-API
=======================

## Installing kernpunkt OPS Office365Connector via composer

Now you can install "kernpunkt/office365connector" via composer
```bash
php composer.phar require "kernpunkt/office365connector": "dev-master#1.0"
```

## Use
```php
  $office = new Office365Connector('yourcompany.onmicrosoft.com', 'client-id', 'client-secret', 'https://graph.microsoft.com', 'client_credentials');
  dd($office->getUsers());
```

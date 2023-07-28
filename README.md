![](https://www.seven.io/wp-content/uploads/Logo.svg "seven Logo")

Adds the functionality to send SMS via seven.

## Prerequisites

- An [API Key](https://help.seven.io/en/api-key-access) from [seven](https://www.seven.io)
- [Krayin CRM](https://krayincrm.com/) - tested with v1.2.x

## Installation

1. Register the package as service provider by appending an entry in **config/app.php**.

```php
<?php
return [
    // ...
    'providers' => [
        // ...
        Seven\Krayin\Providers\SevenServiceProvider::class,
    ],
        // ...
];
```

2. Add the package namespace as PSR-4 key in composer.json file for autoloading.

```json
{
    "autoload": {
        "psr-4": {
            "Seven\\Krayin\\": "packages/Seven/Krayin/src"
        }
    }
}
```

3. Execute these commands to clear the cache and migrate the database:

```
php artisan cache:clear
php artisan migrate
```

## Setup

Before you can start sending SMS you will need to submit your seven API key. This can be
in two ways:

### Configuration via administration panel

1. Navigate to **Dashboard -> Configuration -> seven** in your Krayin admin panel.
2. Enter your API Key and submit by clicking on **Save**.

### Setting an environment variable

1. Define your seven API key in the environment by adding an entry to the **.env** file in
   the root of your project.

```dotenv
SEVEN_API_KEY=YourSuperSecretApiKeyFromSeven
```

2. Add the following lines to **config/services.php**:

```php
return [
    // ...
    'seven' => [
        'api_key' => env('SEVEN_API_KEY'), // must match the key from .env file added in the previous step
    ],
];
```

Clear the cache and cache the configuration by executing
`php artisan cache:clear && php artisan config:cache`.

**Please note:** Setting the API key via configuration takes precedence over defining it
as an environment variable. Also, the value from the environment won't get shown in the
configuration form due to technical limitations.

## Usage

### Send SMS to Person

Go to `Contacts -> Persons` and click on the seven icon in the actions column.

### Send SMS to Organization

Go to `Contacts -> Organizations` and click on the seven icon in the actions column.

You can use property placeholders which resolve to the person's property as long as it is
defined, e.g. {{name}} resolves to the person's name.

## Support

Need help? Feel free to [contact us](https://www.seven.io/en/company/contact).

[![MIT](https://img.shields.io/badge/License-MIT-teal.svg)](LICENSE)

<img src="https://www.seven.io/wp-content/uploads/Logo.svg" width="250" />

# seven SMS Integration for Krayin CRM

[![License: MIT](https://img.shields.io/badge/License-MIT-teal.svg)](LICENSE)
[![Krayin Version](https://img.shields.io/badge/Krayin-v2-blue.svg)](https://krayincrm.com/)
[![PHP Version](https://img.shields.io/badge/PHP-%3E%3D8.0-8892BF.svg)](https://php.net)

Seamlessly integrate SMS functionality into your Krayin CRM with seven's powerful messaging API. Send individual and bulk SMS messages directly from your CRM interface.

## 📋 Table of Contents

- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Bulk SMS](#bulk-sms)
- [Placeholders](#placeholders)
- [Troubleshooting](#troubleshooting)
- [FAQ](#faq)
- [Support](#support)
- [License](#license)

## ✨ Features

- **Direct SMS Integration** - Send SMS messages directly from person and organization records
- **Bulk SMS Campaigns** - Send messages to multiple contacts simultaneously
- **Smart Placeholders** - Personalize messages with dynamic contact information
- **Performance Tracking** - Monitor SMS delivery and engagement metrics
- **Admin Configuration** - Easy setup through Krayin's admin panel
- **Environment Variables** - Secure API key management
- **Contact Integration** - Seamlessly works with existing Krayin contacts

## 📦 Requirements

| Component | Version |
|-----------|---------|
| PHP | >= 8.0 |
| Krayin CRM | v2.x |
| Composer | >= 2.0 |
| seven API Key | [Get one here](https://www.seven.io) |

## 🚀 Installation

### Step 1: Install via Composer (Recommended)

```bash
composer require seven/krayin
```

### Step 2: Register Service Provider

Add the service provider to your `config/app.php`:

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

### Step 3: Configure Autoloading

Add the package namespace to your `composer.json`:

```json
{
    "autoload": {
        "psr-4": {
            "Seven\\Krayin\\": "packages/Seven/Krayin/src"
        }
    }
}
```

### Step 4: Run Migrations

```bash
# Clear cache
php artisan cache:clear

# Run database migrations
php artisan migrate

# Regenerate autoload files
composer dump-autoload
```

## ⚙️ Configuration

You can configure the seven SMS integration in two ways:

### Option 1: Admin Panel Configuration (Recommended)

1. Navigate to **Dashboard → Configuration → seven** in your Krayin admin panel
2. Enter your seven API Key
3. Click **Save** to apply the configuration

### Option 2: Environment Variables

1. Add your API key to the `.env` file:

```dotenv
SEVEN_API_KEY=YourSuperSecretApiKeyFromSeven
```

2. Update `config/services.php`:

```php
return [
    // ...
    'seven' => [
        'api_key' => env('SEVEN_API_KEY'),
    ],
];
```

3. Clear and cache configuration:

```bash
php artisan cache:clear && php artisan config:cache
```

> **Note:** Admin panel configuration takes precedence over environment variables.

## 📱 Usage

### Send SMS to Individual Contacts

#### For Persons
1. Navigate to **Contacts → Persons**
2. Find the person you want to message
3. Click the seven icon in the actions column
4. Compose and send your message

#### For Organizations
1. Navigate to **Contacts → Organizations**
2. Find the organization you want to message
3. Click the seven icon in the actions column
4. Compose and send your message

### Example: Programmatic SMS Sending

```php
use Seven\Krayin\Services\SmsService;

$smsService = app(SmsService::class);

// Send SMS to a contact
$smsService->send(
    to: '+1234567890',
    message: 'Hello {{name}}, your appointment is confirmed!',
    contactId: $contact->id
);
```

## 📨 Bulk SMS

Send SMS campaigns to multiple contacts at once:

1. Navigate to **Contacts → Persons** or **Organizations**
2. Select multiple contacts using checkboxes
3. Click **Bulk Actions → Send SMS**
4. Compose your message with placeholders
5. Review and send

### Bulk SMS Best Practices

- Test with a small group first
- Use placeholders for personalization
- Monitor delivery reports
- Respect sending limits and regulations
- Schedule campaigns during appropriate hours

## 🔤 Placeholders

Personalize your messages with dynamic placeholders:

| Placeholder | Description | Example Output |
|------------|-------------|----------------|
| `{{name}}` | Contact's full name | John Doe |
| `{{first_name}}` | First name only | John |
| `{{last_name}}` | Last name only | Doe |
| `{{organization}}` | Organization name | Acme Corp |
| `{{email}}` | Email address | john@example.com |
| `{{phone}}` | Phone number | +1234567890 |

### Example Message with Placeholders

```
Hello {{first_name}},

Your appointment at {{organization}} is confirmed for tomorrow at 2 PM.

Best regards,
Your CRM Team
```

## 🔧 Troubleshooting

### Common Issues and Solutions

#### SMS Not Sending

1. **Check API Key**: Verify your seven API key is correctly configured
2. **Phone Format**: Ensure phone numbers include country code (e.g., +1234567890)
3. **Balance**: Check your seven account has sufficient SMS credits
4. **Logs**: Review Laravel logs at `storage/logs/laravel.log`

#### Migration Errors

```bash
# Reset migrations if needed
php artisan migrate:rollback
php artisan migrate

# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

#### Service Provider Not Found

```bash
# Regenerate composer autoload
composer dump-autoload

# Clear bootstrap cache
php artisan optimize:clear
```

## ❓ FAQ

**Q: Can I use SMS templates?**
A: Yes, you can create reusable message templates with placeholders in the admin panel.

**Q: Are there sending limits?**
A: Limits depend on your seven account plan. Check your seven dashboard for details.

**Q: Can I track SMS delivery?**
A: Yes, delivery reports are available in the Performance Tracking section.

**Q: How do I test SMS functionality?**
A: Use seven's test mode by adding `test=1` parameter in your API configuration.

**Q: Can I schedule SMS messages?**
A: Scheduled messaging is planned for a future release.

## 🛠️ Development

### Running Tests

```bash
# Run package tests
php artisan test packages/Seven/Krayin

# Run with coverage
php artisan test --coverage packages/Seven/Krayin
```

### Contributing

We welcome contributions! Please see our [Contributing Guide](CONTRIBUTING.md) for details.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📞 Support

Need help? We're here to assist!

- 📧 Email: [support@seven.io](mailto:support@seven.io)
- 📚 Documentation: [seven API Docs](https://docs.seven.io)
- 💬 Contact: [Contact Form](https://www.seven.io/en/company/contact)
- 🐛 Issues: [GitHub Issues](https://github.com/seven-io/krayin/issues)

## 📄 License

This package is open-source software licensed under the [MIT License](LICENSE).

---

<p align="center">
Made with ❤️ by <a href="https://www.seven.io">seven</a>
</p>
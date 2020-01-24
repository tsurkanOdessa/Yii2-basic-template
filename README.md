# Yii2 Start Project Basic Template

[![Latest Stable Version](https://poser.pugx.org/dominus77/yii2-basic-start/v/stable)](https://packagist.org/packages/dominus77/yii2-basic-start)
[![License](https://poser.pugx.org/dominus77/yii2-basic-start/license)](https://packagist.org/packages/dominus77/yii2-basic-start)
[![Build Status](https://travis-ci.org/Dominus77/yii2-basic-start.svg?branch=master)](https://travis-ci.org/Dominus77/yii2-basic-start)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Dominus77/yii2-basic-start/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Dominus77/yii2-basic-start/?branch=master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/Dominus77/yii2-basic-start/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)
[![PayPal donate button](https://img.shields.io/badge/paypal-donate-yellow.svg)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=XR3VKHSUN9D88 "Donate once-off to this project using Paypal")
[![Total Downloads](https://poser.pugx.org/dominus77/yii2-basic-start/downloads)](https://packagist.org/packages/dominus77/yii2-basic-start)

The application is built using basic pattern and has a modular structure.

## Base components

Pages
- Home
- About
- Contact
- Check in
- Login
- Profile

Modules
- main
- users
- admin
- rbac (manage web interface)

Functional
- Reset password
- Confirmation by email
- Last visit
- Console commands
- RBAC

## CSS Themes Bootstrap

The template includes the of the CSS Theme Bootstrap

Switching the theme occurs in the `app/config/web.php`

## Requirements

The minimum requirement by this project template that your Web server supports PHP 5.5.0.

## INSTALLATION

Create a project:

```
composer create-project --prefer-dist --stability=dev dominus77/yii2-basic-start basic-project
```

or clone the repository for `pull` command availability:

```
git clone https://github.com/Dominus77/yii2-basic-start.git basic-project
cd basic-project
composer install
```

Init an environment:

```
php init
```

Create a database, default configure: yii2_basic_start

Apply migration:

```
php yii migrate
```

See all available commands:

```
php yii
```

Create users, enter the command and follow the instructions:

```
php yii users/user/create
```

- Username: set username;
- Email: set email username;
- Password: set password username (min 6 symbol);
- Status: set status username (0 - blocked, 1 - active, 2 - wait, ? - Help);

### Initialize RBAC

When initialized, the user with ID:1 is assigned the SuperAdmin role.

```
php yii rbac/init
```
A command to assign roles to other users:

```
php yii rbac/roles/assign
```
To untie:
```
php yii rbac/roles/revoke
```

You can then access the application through the following URL:

```
http://localhost/basic-project/web/
```

Create .htaccess file or add folder \web

```
AddDefaultCharset utf-8
# Mod_Autoindex
<IfModule mod_autoindex.c>
  # Disable indexes
  Options -Indexes
</IfModule>

# Mod_Rewrite
<IfModule mod_rewrite.c>
  # Enable symlinks
  Options +FollowSymlinks
  # Enable mod_rewrite
  RewriteEngine On

  # If a directory or a file exists, use the request directly
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteCond %{REQUEST_FILENAME} !-d
  # Otherwise forward the request to index.php
  RewriteRule . index.php
</IfModule>
```

## TESTING

Create a database, default configure yii2_basic_start_test in app\config\test-local.php

```
//...
'components' => [
    'db' => [
        'dsn' => 'mysql:host=localhost;dbname=yii2_basic_start_test',
    ],
]
//...
```

Apply migration:

```
php yii_test migrate/up
```

Run in console for Windows system:
```
vendor\bin\codecept build
vendor\bin\codecept run
```
Other:
```
vendor/bin/codecept build
vendor/bin/codecept run
```


### Yii2 Setting

### Add Your Setting:

Config /common/config/main.php to use Yii::$app->setting
```
    'components' => [
        'setting' => [
            'class' => 'funson86\setting\Setting',
        ],
    ],
```
Config backend modules in backend/config/main.php to manage settings
```
    'modules' => [
        'setting' => [
            'class' => 'funson86\setting\Module',
            'controllerNamespace' => 'funson86\setting\controllers'
        ],
    ],
```
    
Setting support 3 type of setting: text, password, select. You could add your setting by migration or insert to table setting manually.
```
INSERT INTO `setting` (`id`, `parent_id`, `code`, `type`, `store_range`, `store_dir`, `value`, `sort_order`) VALUES
(11, 0, 'info', 'group', '', '', '', '50'),
(21, 0, 'basic', 'group', '', '', '', '50'),
(31, 0, 'smtp', 'group', '', '', '', '50'),
(1111, 11, 'siteName', 'text', '', '', 'Your Site', '50'),
(1112, 11, 'siteTitle', 'text', '', '', 'Your Site Title', '50'),
(1113, 11, 'siteKeyword', 'text', '', '', 'Your Site Keyword', '50'),
(2111, 21, 'timezone', 'select', '-12,-11,-10,-9,-8,-7,-6,-5,-4,-3.5,-3,-2,-1,0,1,2,3,3.5,4,4.5,5,5.5,5.75,6,6.5,7,8,9,9.5,10,11,12', '', '8', '50'),
(2112, 21, 'commentCheck', 'select', '0,1', '', '1', '50'),
(3111, 31, 'smtpHost', 'text', '', '', 'localhost', '50'),
(3112, 31, 'smtpPort', 'text', '', '', '', '50'),
(3113, 31, 'smtpUser', 'text', '', '', '', '50'),
(3114, 31, 'smtpPassword', 'password', '', '', '', '50'),
(3115, 31, 'smtpMail', 'text', '', '', '', '50');
```

###Use Your Setting

Once you set the value at the backend. Simply access your setting by the following code:

```
echo Yii::$app->setting->get('siteName');
```
<p align="left"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/schoolviser/art/main/site/logo.svg" width="400"></a></p>


### Configuration Guide

```php
'school_name' => 'Delgont Primary School',
```

```php
  'admin_layout' => env('ADMIN_LAYOUT', 'admin.layouts.master'),
```

```php
  'type' => 'tertiary',
```

```php
 'intakes' => [
    '1' => 'Jan Intake',
    '2' => 'July Intake',
    '3' => 'Configure Intage Name'
  ],
  ```

  ```php
     'modules' => [
    'student',
    //'fee',
    'accounting',
    //'requisition',
    'admission',
    //'course',
    //'applicant',
    'user'
   ],
   ```


### Console Commands

```php
php artisan subjects:sync --O
```

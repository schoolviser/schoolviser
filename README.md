<p align="left"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/schoolviser/art/main/site/logo.svg" width="400"></a></p>



<ul>
  <li><a href="#config">Confi</a></li>
  <li><a href="#artisan-commands">Artisan Commands</a></li>

</ul>

<h2 id="config">Configuration</h2>

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


<h2 id="artisan-commands">Artisan Commands</h2>


```php
php artisan subjects:sync --O
```

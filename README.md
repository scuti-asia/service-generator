# Scuti/repository-generator
A package to generator service layer.
# How to install

### Step 1: Install via composer

```php
composer require scuti/service-generator
```

### Step 2: Publish service-generator (optional if you want to custom config)

```php
php artisan vendor:publish --provider="Scuti\Admin\ServiceGenerator\ServiceGeneratorProvider"
```
```
// Config file
// service_layer.php
return [
    'service_path' => 'Services', // The path of Service folder 
    'allow_implement_interface' => false, // User the interface or not
];
```
### Step 3: Use command to generate service
```
php artisan make:service NameOfService
```

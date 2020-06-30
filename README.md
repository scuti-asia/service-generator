# Scuti/repository-generator
A package to generator service layer.
# How to install

### Step 1: Install via composer

```php
composer require scuti/service-generator
```

### Step 2: Publish service-generator

```php
php artisan vendor:publish --provider="Scuti\Admin\ServiceGenerator\ServiceGeneratorProvider"
```
### Step 3: Use command to generate Repository
```
php artisan make:service NameOfRepository
```

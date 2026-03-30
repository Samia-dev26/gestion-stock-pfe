# TODO.md - Frontend/Backend Integration Fix

## Plan Approved Steps:

### 1. [x] Clean up routes/web.php
- Remove duplicate route definitions
- Ensure products resource route works
- Point dashboard routes to Sneat template views

### 2. [x] Fix ProductController (index returns view)
- Rename productController.php → ProductController.php
- Update index() to return view('products') with data instead of JSON
- Keep API endpoints separate

### 3. [x] Update layouts/app.blade.php
- Uncomment @vite directive for CSS/JS assets

### 4. [x] Update products.blade.php (dynamic data + layout)
- Add @extends('layouts.app')
- Add @section('content')
- Create dynamic table with @foreach($products)
- Add proper action forms (edit/delete)

### 5. [x] Update dashboard routes for Sneat (already using sneat-layout)
- Make dashboard routes return sneat-layout views
- Ensure role middleware compatibility

### 6. [x] Run setup commands (cache cleared, autoload, npm build, migrate)
```
php artisan route:clear
php artisan config:clear
php artisan view:clear
composer dump-autoload
npm install && npm run build
php artisan migrate
```

### 7. [ ] Test
- Login as admin/gestionnaire
- Visit /products
- Check assets loading (F12 → Network)

# Inventory Management Backend  
## Use PHP Version
```
8.1 or avobe
```

### Use Composer Version
```
 2.5.7 or avobe
```

## Project setup
### 1 .Run Composer install Command
```
Composer Install
```

### 2. Create .env in the root folder. And copy everything from env.example

### 3. By default Laravel 10 APP_KEY. 
If it does not create run the command
```
php artisan key:generate
```

### 4. Connect Database
```
DB_DATABASE=database_name
DB_USERNAME=user_name
DB_PASSWORD=password
```
### 5. Run Migration and seed command
```
php artisan migrate:fresh --seed
```

### 6. Here I am using JWT
So we need to generate JWT_SECRET
```
php artisan jwt:secret
```

### 7. Run project
```
php artisan serve
```
### 8. Don't forget to make symlink
```
php artisan storage:link
```



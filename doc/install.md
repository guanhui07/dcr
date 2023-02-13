## install

### 安装
```
composer create-project dcr/framework skeleton
```

配置好`.env` 文件


### http:

http: 生产不推荐，推荐使用nginx
```
php -S 127.0.0.1:8001 -t ./public
```

### websocket: 基础于workerman gateway

```
php ./bin/startWs.php start   
```

### console:

```
php artisan test
```

### crontab: 基础于workerman crontab

```
php ./bin/crontab.php start  
```

### migrate:

```
php migrate.php  migrations:generate
php migrate.php migrations:migrate

```


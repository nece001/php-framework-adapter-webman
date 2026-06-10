# php-framework-adapter-webmanb
webman框架适配


# 必要设置

config\route.php 中添加以下代码，否则还可以继续使用默认路由访问应用。

```php
// 禁用全局自动路由（所有插件和应用）
Route::disableDefaultRoute('', '*');
```
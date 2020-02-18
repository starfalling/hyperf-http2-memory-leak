
### coredump 重现 2020-02-18
```
# 可重现 swoole 版本，4.4.15
# 无需配置数据库，服务端会报数据库无法连接的错误，也会 crash

# 进入项目目录，执行下面命令启动服务端
php bin/hyperf.php start
# 执行下面命令启动测试端
php bin/hyperf.php test2
```


### 内存泄漏重现（4.4.15 已解决）
```
# 进入项目目录，执行下面命令启动服务端
php bin/hyperf.php start
# 执行下面命令启动测试端
php bin/hyperf.php test
```

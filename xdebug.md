# Docker 使用

- 往容器里挂载文件

# 排查问题

- 以什么域名请求？
- nginx配置的域名是什么？

# 概念

- 调试客户端
- 被调试的进程
- 断点

# 安装 XDebug

略

# 启用 XDebug 远程调试

xdebug.remote_enable=1
xdebug.remote_host=localhost

# 建立调试会话

调试会话：调试客户端（如 IDE）连接到被调试的 PHP 进程。

## 自动建立调试会话

xdebug.remote_autostart=1

## 根据需要建立调试会话

- 在 URL 或 POST 里增加 XDEBUG_SESSION_START=会话名 参数，XDebug 会创建名为 XDEBUG_SESSION，值为会话名的 Cookie
- 如果 XDEBUG_SESSION Cookie 存在，XDebug 就会建立调试会话，所以也可以直接在谷歌浏览器调试工具里添加 Cookie

## 停止调试会话

- 在 URL 里增加 XDEBUG_SESSION_STOP 参数，不需要指定取值

# 断点

调试会话建立后，调试客户端（IDE）会把断点位置发给被调试的进程，进程执行到断点位置，就会暂停运行，并把程序状态返回给调试客户端，调试客户端可使用调试工具来控制接下来的执行步骤。

IDE 和 PHP 进程的源代码路径不一定匹配，那被调试的进程，怎么知道断点到底加在哪个文件的？

PHPStorm 可以以 Server 为单元配置代码的路径映射关系，Server 有 name 和 host 可以参与匹配，如果是 CLI 进程，则可以通过环境变量来指定：

`XDEBUG_CONFIG='idekey=PHPSTORM' PHP_IDE_CONFIG='serverName=wbl' php yii`
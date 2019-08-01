- 虽然一个项目一套独立 docker 配置的做法封装性更好，但如果觉得折腾 Docker 比较费劲，当然也可以只运行一套 php + nginx + mysql + redis + ... 的环境，而把多个项目都挂载到一个 php 容器里
- 我制作的 php fpm 基础镜像，应用在项目里，都会再 build 一次增加和登录主机桌面的用户对应的用户，这么做的出发点，一是为了保证文件权限的一致，二是为了用 SSH，但，我最近的实践中证实了，FPM 用非 root 用户运行没有任何问题，而主机用户也可以直接挂载到容器里来支持使用 SSH
- 和前一点有关的，我最近的实践中，顺利使用了单独的 Composer 和 PHP-CS-Fixer 镜像，而不必打包到运行环境镜像里


function dcomposer()
{
    LOCAL_COMPOSER_HOME=${COMPOSER_HOME:-$HOME/.config/composer}
    if [[ ! -d $LOCAL_COMPOSER_HOME ]]; then
        mkdir -p $LOCAL_COMPOSER_HOME
    fi
    eval `keychain --eval id_rsa id_lhjx`; \
    docker run --rm -it \
        -v $PWD:/app \
        -v $SSH_AUTH_SOCK:/ssh-auth.sock \
        -v /etc/passwd:/etc/passwd:ro \
        -v /etc/group:/etc/group:ro \
        -e SSH_AUTH_SOCK=/ssh-auth.sock \
        -v $LOCAL_COMPOSER_HOME:/tmp \
        -u $(id -u):$(id -g) \
        composer "$@"
}

function dcsfixer()
{
    docker run --rm -it \
        -u $(id -u):$(id -g) \
        -v $PWD:/code \
        modihq/php-cs-fixer "$@"
}
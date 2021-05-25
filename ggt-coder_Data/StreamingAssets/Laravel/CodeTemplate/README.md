<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://blog-cn.curatorc.com/resources/images/ggt-coder/menu-title.png" width="400"></a></p>

<p align="center">
<a href="https://blog-cn.curatorc.com/#/ggt-coder/README"><img src="https://img.shields.io/badge/ggt--coder-v1.1.2-orange"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
</p>

# 部署步骤
* 安装依赖

  ```
  composer install
  ```

* 配置环境变量

  ```
  cp .env.example .env
  ```

* 生成密钥
  * 项目密钥

    ```
    php artisan key:generate
    ```

  * JWT 密钥

    ```
    php artisan jwt:secret
    ```
* 配置数据库
  * 创建数据库
  * 创建数据库用户及授权
  * 数据库迁移

    ```
    php artisan migrate
    ```
* 测试
* 文档
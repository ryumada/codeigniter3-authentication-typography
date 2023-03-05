# CodeIgniter3 Authentication and Typography
## Overview
This repository contains codeigniter 3 souce code with added authentication using [IonAuth](https://github.com/benedmunds/CodeIgniter-Ion-Auth) and some typography plugins. I will list it later, but for my plan I will use this for demonstration:
- [CKEDITOR](https://ckeditor.com/) and [CKFINDER]()
- [tinymce](https://www.tiny.cloud/)
- [summernote](https://summernote.org/) and [summernote-gallery](https://github.com/eissasoubhi/summernote-gallery)

## Technology Used
- [CodeIgniter](https://github.com/bcit-ci/CodeIgniter) 3.1.13 (PHP Framework)
- [MySQL 8](https://www.mysql.com/) (Database)
- [Bootstrap 5](https://getbootstrap.com/docs/5.3/examples/) CSS Library

## How to run this project using Nginx
To prepare the LEMP stack, read this [README](https://github.com/ryumada/centratama-hcportal-new/blob/master/README-persiapan-lemp-stack-linux-nginx-engine-x-mysql-php.md).

1. Clone this Repository
```bash
git clone <.git_address>
```

2. Copy this repository into your server directory (`/var/www/ci3-auth-typography`).

see this file [application/config/config.php](/application/config/config.php).

```php
$config['base_url'] = 'http://' . $_SERVER["HTTP_HOST"] . ':81';
```

As you can see above, the baseurl has been changed with php superglobal variable `$_SERVER`.


3. Create a new site configuration at `/etc/nginx/sites-available`
```nginx
server {
  listen 81 default_server;
  listen [::]:81 default_server;
  root /var/www/ci3-auth-typography/;

  index index.php index.html index.htm;

  server_name _;

  location / {
    try_files $uri $uri/ /index.php;
  }

  location ~ \.php$ {
    include snippets/fastcgi-php.conf;
    fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
  }

  location ~ /\.ht {
    deny all;
  }
}
```

4. Create a softlink to the configuration at `/etc/nginx/sites-enabled`
```bash
sudo ln -s /etc/nginx/sites-available/ci3-auth-typography /etc/nginx/sites-enabled/ci3-auth-typography
```

5. Test the configuration
```bash
sudo nginx -t
```

6. Restart your Nginx
```bash
sudo systemctl restart nginx
```

7. Run this SQL to create the database.
[ci3-ionauth-ckeditor](/sql/ci3-ionauth-ckeditor.sql)

8. Set permission on these folders to be writable by the server:
    - public/files/ckeditor/images

> For deployment, please read these:
> - https://codeigniter.com/userguide3/general/security.html
> - https://codeigniter.com/userguide3/installation/index.html

---

Copyright © 2023 ryumada. All Rights Reserved.

Licensed under the [MIT](LICENSE) license.

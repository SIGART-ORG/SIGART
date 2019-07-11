# SIGART

## Jefe de proyecto: 
* Julio Salsavilca *<j.salsavilca@gmail.com>*
* Jonathan Monsefú *<benjamin.mg.20@gmail.com>*

## ¿Cómo levantar el proyecto en local?

* Crear tu fork del repositorio principal.
    https://github.com/jkolaz/SIGART
* Clonar el repositorio al lugar de tu elección.
* Hacer una copia del archivo **.env.example**, renombrarlo **.env**
* Asegurese de tener instalado **composer**.
* Asegurese de tener instalado **node/npm**

##Requisitos
* PHP 7.2 >=
* Maria DB
* Nginx

## Instalación y configuración
### Instalación 
Instalar las librerías de **PHP** a traves de **Composer**
```sh
composer install
```
Instalar las librerías para **JavaScript** a traves de **npm**
```sh
npm install
```
**IMPORTANTE** todo desarrollo de archivos JS y CSS se realizarán los siguientes comandos:
```sh
npm run dev
```
o
```sh
npm run watch
```

**Para subir los archivos a producción, se ejecutará el siguiente comando antes de enviar el commit al repositorio.**
```sh
npm run prod
```

### Configuración Nginx(Server Blocks)

* Crear archivo config en la siguiente ruta **/etc/nginx/sites-available/config**
```sh
sudo nano /etc/nginx/sites-available/config
```

* pegar las siguientes lineas en el archivo config.

```sh
server {
        listen 80;
        root /home/user/Projects/SIGART/web/public;
        index index.php index.html index.htm;
        server_name www.dpintart.devel;
        location / {
                try_files $uri $uri/ /index.php$is_args$args;
        }
        location ~ \.php$ {
                try_files $uri /index.php = 404;
                fastcgi_pass unix:/var/run/php/php7.2-fpm.sock;
                fastcgi_index index.php;
                fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
                include fastcgi_params;
        }
}

server {
        listen 80;
        root /home/user/Projects/SIGART/admin/public;
        index index.php index.html index.htm;
        server_name admin.dpintart.devel;
        location / {
                try_files $uri /index.php?$query_string;
        }
        location ~ \.php$ {
                try_files $uri /index.php = 404;
                fastcgi_pass unix:/var/run/php/php7.2-fpm.sock;
                fastcgi_index index.php;
                fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
                include fastcgi_params;
        }
}
```
* luego ejecutar los siguientes comandos en la terminal:
```sh
sudo ln -s /etc/nginx/sites-available/config /etc/nginx/sites-enabled/
```
```sh
sudo nginx -t
```
```sh
sudo service nginx restart
```

Por ultimo debemos de crear los dominios locales en el archivo **hosts**

```sh
sudo nano /etc/hosts
```

Luego pegamos las siguientes lineas en el archivo **hosts**
```sh
127.0.0.1       www.dpintart.devel
127.0.0.1       admin.dpintart.devel
```

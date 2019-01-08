# Página web D'PINTART

## Jefe de proyecto: 
* Julio Salsavilca *<j.salsavilca@gmail.com>*
* Jonathan Monsefú *<benjamin.mg.20@gmail.com>*

## ¿Cómo levantar el proyecto en local?

* Clonar el repositorio al lugar de tu elección.
* Hacer una copia del archivo **.env.example**, renombrarlo **.env**
* Asegurese de tener instalado **composer**.
* Asegurese de tener instalado **node/npm** y su paquete **Gulp**.

## Organización del proyecto
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
luego
```sh
gulp
```
Para subir a producción se compila los archivos JS y CSS con el comando:
```sh
gulp dist
```
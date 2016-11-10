# Docker setup for DS3

This repositry contains base docker image for *DS3* project development. It also contains scripts to run all projects as a bunch of containers

## Quickstart

To build and run all containers you should clone all repos into one directory

```
$ ls -l
drwxr-xr-x  ds3-private01
drwxr-xr-x  ds3-private02
drwxr-xr-x  ds3-private03
drwxr-xr-x  ds3-private04-Docker
```

Build and run all containers with two commands

```bash
make all
docker-compose up -d
```

Patch you DNS

```bash
sudo echo 127.0.0.1 loader.ds3soft.dev api.ds3soft.dev >> /etc/hosts
```

Go to a browser and get access to https://loader.ds3soft.dev

## Base Image

Base image is built on top of `centos:6.7` and users `SCL` repos to install `php56` and `httpd24`. Here is the list installed software, required for *DS3* projects runtime:

```
docker run --rm ds3-base yum list installed | grep -e php56 -e mcrypt -e pdf -e httpd24
httpd24.x86_64                      1.1-14.el6                 @centos-sclo-rh
httpd24-apr.x86_64                  1.5.1-1.el6                @centos-sclo-rh
httpd24-apr-util.x86_64             1.5.4-1.el6                @centos-sclo-rh
httpd24-httpd.x86_64                2.4.18-11.el6              @centos-sclo-rh
httpd24-httpd-tools.x86_64          2.4.18-11.el6              @centos-sclo-rh
httpd24-libnghttp2.x86_64           1.7.1-1.el6                @centos-sclo-rh
httpd24-mod_ssl.x86_64              1:2.4.18-11.el6            @centos-sclo-rh
httpd24-runtime.x86_64              1.1-14.el6                 @centos-sclo-rh
libmcrypt.x86_64                    2.5.8-9.el6                @epel
more-php56-php-mcrypt.x86_64        5.6.5-2.el6                @remi-php56more-epel-6-x86_64
pdftk.x86_64                        2.02-1.el6                 installed
php-tcpdf.noarch                    6.2.11-1.el6               @epel
php-tcpdf-dejavu-sans-fonts.noarch  6.2.11-1.el6               @epel
remi-php56more-epel-6-x86_64.noarch 1-2                        installed
rh-php56.x86_64                     2.0-6.el6                  @centos-sclo-rh
rh-php56-php.x86_64                 5.6.5-9.el6                @centos-sclo-rh
rh-php56-php-bcmath.x86_64          5.6.5-9.el6                @centos-sclo-rh
rh-php56-php-cli.x86_64             5.6.5-9.el6                @centos-sclo-rh
rh-php56-php-common.x86_64          5.6.5-9.el6                @centos-sclo-rh
rh-php56-php-gd.x86_64              5.6.5-9.el6                @centos-sclo-rh
rh-php56-php-mbstring.x86_64        5.6.5-9.el6                @centos-sclo-rh
rh-php56-php-mysqlnd.x86_64         5.6.5-9.el6                @centos-sclo-rh
rh-php56-php-opcache.x86_64         5.6.5-9.el6                @centos-sclo-rh
rh-php56-php-pdo.x86_64             5.6.5-9.el6                @centos-sclo-rh
rh-php56-php-pear.noarch            1:1.9.5-3.el6              @centos-sclo-rh
rh-php56-php-pecl-jsonc.x86_64      1.3.6-3.el6                @centos-sclo-rh
rh-php56-php-process.x86_64         5.6.5-9.el6                @centos-sclo-rh
rh-php56-php-tidy.x86_64            5.6.5-9.el6                @centos-sclo-rh
rh-php56-php-xml.x86_64             5.6.5-9.el6                @centos-sclo-rh
rh-php56-runtime.x86_64             2.0-6.el6                  @centos-sclo-rh
```

It has a entrypoint script which is going to:
- Create self-signes SSL sertificates for a domain specified by `HTTPD_SERVER_NAME` environment variable
- Run `httpd` in foreground

## Make

Makefile provides shortcuts to build images:

- `make base` to build base image
- `make all` to build everything required to start a cluster

## Compose

There is a `docker-compose.yml` file which has the following services described:

- `db` is a mysql database container based on custom *mysql* image from *ds3-private01*
- `loader` is a container to run application from *ds3-private02* repository (which code base is strongly coupled with legacy *ds3-private01* and api from *ds3-private03*)
- `api` is a container running *api* application from *ds3-private03*

**NOTE** this setup implies that all repositories are clone in one root.

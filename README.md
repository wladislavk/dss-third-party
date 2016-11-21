# Docker setup for DS3

This repositry contains base docker image for *DS3* project development. It also contains scripts to run all DS3-Docker projects as a group of linked containers.

## Quickstart

To build and run all containers you should clone all repos into one directory

```
$ ls -l
drwxr-xr-x  ds3-private01
drwxr-xr-x  ds3-private02
drwxr-xr-x  ds3-private03
drwxr-xr-x  ds3-private04-Docker
```

#### REQUIRED DOCKER FIX for Windows
If you run Docker in Windows you **must** change the end-of-line encoding for a particular Docker file BEFORE you 'make' the images or the containers will fail. Docker expects Linux-style end-of-line encoding, but for some reason Windows *automatically* reads the Docker text file with Windows-style encoding.  

With MS Visual Studio code, open this file:  
> ds3-private04-Docker/docker-entrypoint.sh

In VS code on the bottom left pane, change the "CRLF" option to "LF".  Save the file.  That's it.  For a screenshot see the bottom section "The Simple Fix - VS Code Rocks" on [this page](https://blogs.msdn.microsoft.com/stevelasker/2016/09/22/running-scripts-in-a-docker-container-from-windows-cr-or-crlf/).

If you see something like this when starting containers on your Windows machine, this means you failed to save the file correctly.
```bash
/bin/sh: /usr/sbin/docker-entrypoint.sh: /bin/bash^M: bad interpreter: No such file or directory
```
###Build Images
Navigate to the Docker repo, then build and run all containers with two commands. (Make sure you apply the 'Windows fix' above if using W10 before doing this.)

**Note:** These images take a *long time* to build initially (40 min+). Go do something else.

```bash
cd ds3-private04-Docker
make all
```



###Start Containers
After the images are built, run docker-compose (within ds3-private04-Docker) to initialize the containers.
```bash
docker-compose up -d
```
###Patch Hosts
Patch your DNS hosts file.  On Windows, Hosts file is located at {c:\windows\system32\drivers\etc\hosts}.

On Mac/Linux use command below.  

```bash
sudo echo 127.0.0.1 loader.ds3soft.dev api.ds3soft.dev >> /etc/hosts
```
###Test Containers
Go to a browser and verify access to https://loader.ds3soft.dev

Verify the images are connected by navigating to https://loader.ds3soft.dev:9443/manage
Login with Username: doc1f Password: cr3at1vItY.  If you can login then all containers run correctly.

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

## Docker Tips

There is no simple command in Docker to delete all containers or images.

Delete all Docker containers
```bash
# Must be run first because images are attached to containers
docker rm $(docker ps -a -q)
```
Delete all Docker images

```bash
docker rmi $(docker images -q)
```
## Kitematic
If you use Windows, you can use the Docker addon "Kitematic" as a GUI to manage your containers.  It is just a GUI wrapper for the command line, but it is useful for debugging and viewing container info.  It is included with Docker for Windows.  https://kitematic.com/

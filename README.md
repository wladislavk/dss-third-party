# Docker setup for DS3

This repositry contains base docker image for *DS3* project development. It also contains scripts to run all DS3-Docker projects as a group of linked containers.

## Quickstart
After your images are built (see "Initial Setup") you can run start Docker from the -04 repo
```bash
cd ds3-private04-Docker
docker-compose up -d
```
Navigate to https://loader.docker.localhost (Loader / UI endpoint) and https://api.docker.localhost (API endpoint).

To stop your containers
```bash
docker-compose down
```

## Initial Setup

To build and run all containers, first clone ds3 repos 01-04 into one directory:

```
$ ls -l
drwxr-xr-x  ds3-private01
drwxr-xr-x  ds3-private02
drwxr-xr-x  ds3-private03
drwxr-xr-x  ds3-private04-Docker
```

### Build Images
Navigate to ```ds3-private04-Docker``` repo, then build and run all containers. Note that ```docker-compose``` file contains all necessary build scripts (```make``` is not required). (See 'Troubleshooting' below if these commands generate weird errors in Windows.)


#### Build BaseImage (do this ONCE - only needed for first time run)
```bash
cd ds3-private04-Docker
docker-compose build baseimage
```
**Note:** These images take a *long time* to build initially (25 min+). Go do something else.

#### Build Images (do this EVERY time you UPDATE your derived images)
```bash
cd ds3-private04-Docker
docker-compose build
```

### Patch Hosts
Patch your DNS hosts file.  On Windows, Hosts file is located at `c:\windows\system32\drivers\etc\hosts`.

Add the following lines:
```
127.0.0.1 loader.docker.localhost
127.0.0.1 api.docker.localhost
```
On Mac/Linux use command below.  

```bash
sudo echo 127.0.0.1 loader.docker.localhost api.docker.localhost >> /etc/hosts
```

### Start/Stop Containers
After the images are built, run docker-compose up (within ds3-private04-Docker) to initialize the containers, and docker-compose down to halt.
```bash
docker-compose up -d
docker-compose down
```

### Test Containers
Go to a browser and verify access to https://loader.docker.localhost/manage

Login with Username: doc1f Password: cr3at1vItY.  If you can login then all containers run correctly.

**Windows Issue** If you cannot access the HTTPS ports, you may need to alter your ```docker-compose.yml``` file.  See "Troubleshooting" below.

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
- Create self-signed SSL sertificates for a domain specified by `HTTPD_SERVER_NAME` environment variable
- Run `httpd` in foreground

## Make

**DEPRECATED - Use updated docker-compose.yml** <strike>Makefile provides shortcuts to build images:

- `make base` to build base image
- `make all` to build everything required to start a cluster
</strike>

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

### Troubleshooting - DOCKER FIXES for Windows

#### HTTPS Connection Issue
Windows 10 (possibly W7 also) can have issues related to secure port allocation. If you see connection errors like ```ERR_CONNECTION_REFUSED``` or ```SSL_LENGTH_VIOLATION``` this is likely a Windows-specific port / firewall issue.

**Skype** It is known that Skype BLOCKS access to port 443!  Kill the Skype application, then restart your containers.  If the containers work, the issue was related to Skype blocking access to port 443.

If you still see errors (or you don't use Skype) you should CHANGE the secure port assignment for Traefik.  Open ```docker-compose.yml``` and CHANGE the port 443 assignment.  For example, instead of default 443:443, use 4433:443 (or similar):

```
  balancer:
    image: traefik:v1.2.3-alpine
    command: --docker --docker.domain=docker.localhost --logLevel=DEBUG
    ports:
      - 80:80
      - 4433:443
      # CHANGE the 443:443 to 4433:443 or something else to use alternate secure port
```

#### End of File Issue
If you see something like this when starting containers on your Windows machine, this means you need to fix an end-of-line encoding issue with Windows vs. Docker parsing. This ALWAYS happened on older versions of Docker, newer versions do not seem to have this problem.
```bash
/bin/sh: /usr/sbin/docker-entrypoint.sh: /bin/bash^M: bad interpreter: No such file or directory
```
**FIX**
In Windows, the end-of-line encoding for ```docker-entrypoint.sh``` must be changed BEFORE you ```make``` images, or the containers will fail. Docker expects Linux-style end-of-line encoding, but for some reason Windows *automatically* reads the Docker text file with Windows-style encoding.  

With MS Visual Studio code, open this file:  
> ds3-private04-Docker/docker-entrypoint.sh

In VS code on the bottom left pane, change the "CRLF" option to "LF".  Save the file.  That's it.  For a screenshot see the bottom section "The Simple Fix - VS Code Rocks" on [this page](https://blogs.msdn.microsoft.com/stevelasker/2016/09/22/running-scripts-in-a-docker-container-from-windows-cr-or-crlf/).

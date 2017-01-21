#!/bin/bash

. /opt/rh/httpd24/enable
httpd -v
exec httpd -D FOREGROUND

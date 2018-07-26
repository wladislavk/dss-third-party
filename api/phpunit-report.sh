#!/bin/bash

php -d$(cat /etc/php/7.2/mods-available/xdebug.ini) `which phpunit` -c phpunit-report.xml $@

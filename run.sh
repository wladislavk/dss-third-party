#!/usr/bin/env bash

nohup node_modules/phantomjs-prebuilt/bin/phantomjs --webdriver=8643 > /dev/null 2>&1
vendor/behat/behat/bin/behat -f progress
nohup fuser -k -n tcp 8643 > /dev/null 2>&1

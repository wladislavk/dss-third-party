#!/usr/bin/env bash

export BEHAT_BROWSER="phantomjs"
nohup node_modules/phantomjs-prebuilt/bin/phantomjs --webdriver=8643 > /dev/null 2>&1
vendor/behat/behat/bin/behat -p phantom -f progress $@
nohup fuser -k -n tcp 8643 > /dev/null 2>&1

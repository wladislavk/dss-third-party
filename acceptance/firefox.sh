#!/usr/bin/env bash

export BEHAT_BROWSER="firefox"
export SUT_HOST=$1
shift
nohup java -jar /selenium/selenium-server-standalone-2.53.1.jar > /dev/null 2>&1 &
vendor/behat/behat/bin/behat -p firefox -f progress $@
nohup fuser -k -n tcp 4444 > /dev/null 2>&1

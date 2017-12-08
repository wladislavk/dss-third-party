#!/usr/bin/env bash

export BEHAT_BROWSER="chrome"
export SUT_HOST=$1
shift
#nohup java -jar /selenium-server-standalone-2.53.1.jar -role hub -Dwebdriver.chrome.driver="/opt/chromedriver/chromedriver" > /dev/null 2>&1 &
vendor/behat/behat/bin/behat -p chrome2 -f progress $@
#nohup fuser -k -n tcp 9222 > /dev/null 2>&1

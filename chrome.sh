#!/usr/bin/env bash

export BEHAT_BROWSER="chrome"
export SUT_HOST=$1
shift
nohup google-chrome --headless --disable-gpu --no-sandbox \
        --remote-debugging-address=0.0.0.0 \
        --remote-debugging-port=9222 http://localhost:9222/ > /dev/null 2>&1 &
    vendor/behat/behat/bin/behat -p chrome -f progress $@
nohup fuser -k -n tcp 9222 > /dev/null 2>&1

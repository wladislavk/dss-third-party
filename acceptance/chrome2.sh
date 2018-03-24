#!/usr/bin/env bash

export BEHAT_BROWSER="chrome"
export SUT_HOST=$1
shift
vendor/behat/behat/bin/behat -p chrome2 -f progress $@

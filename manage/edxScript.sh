#!/bin/bash
if [ -z "$1" ]; then 
	echo usage: $0 {userID}
    exit
fi
curl --data "uid=$1" --cookie "csrftoken=LR8Q6lNC2E57c5vEqeHpM3kleSLYcFqw" --header "X-CSRFToken: LR8Q6lNC2E57c5vEqeHpM3kleSLYcFqw" http://edx.dss-rh.xforty.com:8001/new_session
#!/bin/bash
if [ -z "$1" ]; then
    echo usage: $0 {user ID}
    exit
fi
token=$(<edxProductionToken.txt)
if [ -z "$token" ]; then
    token=$(<edxDefaultToken.txt)
fi
curl --data "uid=$1" --cookie "csrftoken=$token" --header "X-CSRFToken: $token" http://education.dentalsleepsolutions.com:18010/remove_user

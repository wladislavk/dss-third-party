#!/bin/bash
if [ -z "$5" ]; then
    echo usage: $0 {user ID} {username} {email} {password} {full name}
    exit
fi
token=$(<edxProductionToken.txt)
if [ -z "$token" ]; then
    token=$(<edxDefaultToken.txt)
fi
curl --data "uid=$1" --data "username=$2" --data "email=$3" --data "password=$4" --data "name=$5" --cookie "csrftoken=$token" --header "X-CSRFToken: $token" http://education.dentalsleepsolutions.com:18010/edit_user

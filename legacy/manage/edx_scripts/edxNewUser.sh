#!/bin/bash
if [ -z "$4" ]; then
    echo usage: $0 {username} {email} {password} {full name}
    exit
fi
currentDir=$(dirname "$0")
token=$(<"$currentDir/edxProductionToken.txt")
if [ -z "$token" ]; then
    token=$(<"$currentDir/edxDefaultToken.txt")
fi
curl --data "username=$1" --data "email=$2" --data "password=$3" --data "name=$4" --cookie "csrftoken=$token" --header "X-CSRFToken: $token" http://education.dentalsleepsolutions.com:18010/new_user

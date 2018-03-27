#/usr/bin/bash
BRANCH=${2:-master}
git push $1 `git subtree split --prefix=$1 -b $1-$BRANCH`:$BRANCH --force

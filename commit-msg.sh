#!/bin/sh

# 1. Create an empty commit-msg git hook file, and make it executable. From your project's root directory:
#    install -b -m 755 /dev/null .git/hooks/commit-msg
# 2. Save the following script to the newly-created .git/hooks/commit-msg file.

COMMIT_MSG=$(cat $1)
CURRENT_BRANCH=$(git rev-parse --abbrev-ref HEAD)
JIRA_ID=$(echo "$CURRENT_BRANCH" | grep -Eo "DSS\-[0-9]+?")

if [ ! -z "$JIRA_ID" ]; then
    echo "$JIRA_ID * $COMMIT_MSG" > $1
    echo "JIRA ID '$JIRA_ID', matched in current branch name, prepended to commit message. (Use --no-verify to skip)"
fi

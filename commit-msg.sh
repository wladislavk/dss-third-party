#!/bin/sh

# 1. Create an empty commit-msg git hook file, and make it executable. From your project's root directory:
#    install -b -m 755 /dev/null .git/hooks/commit-msg
# 2. Save the following script to the newly-created .git/hooks/commit-msg file.

COMMIT_MSG=$(cat $1)
CURRENT_BRANCH=$(git rev-parse --abbrev-ref HEAD)
JIRA_ID=$(echo "$CURRENT_BRANCH" | grep -Eo "^DSS\-[0-9]+?")
COMMIT_MSG_MATCH=$(echo "$COMMIT_MSG" | grep -Eo "^$JIRA_ID")

# if branch name starts with the regexp and commit message does not start with the regexp
if [ ! -z "$JIRA_ID" ] && [ -z "$COMMIT_MSG_MATCH" ]; then
    echo "$JIRA_ID * $COMMIT_MSG" > $1
    echo "JIRA ID '$JIRA_ID', matched in current branch name, prepended to commit message. (Use --no-verify to skip)"
fi


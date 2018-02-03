#!/bin/bash

# chmod +x Build/update-changelog.sh && ./Build/update-changelog.sh x.y.z

# Tag name is passed as argument
TAG_NAME=$1

# Format "02 Feb 2018"
CURRENT_DATE=`date +'%e %b %Y'`

# Fetches last tag that was added in git
LAST_GIT_TAG=`git describe --tags --abbrev=0`

# Log range goes from head to last git tag
LOG_RANGE="HEAD...$LAST_GIT_TAG"

LOG_REVISION="[%h](https://github.com/CuyZ/NotiZ/commit/%H)"

LOG_FORMAT_FULL=" - **%s**%n%n   >*$LOG_REVISION by [%an](mailto:%ae) – %ad*%n%n%w(72, 3, 3)%b"
LOG_FORMAT_TINY=" - [$LOG_REVISION] **%s** – *by [%an](mailto:%ae) – %ad*%n"

LOG_REPLACE_ISSUES="s/#([0-9]+)/[#\1](https:\/\/github.com\/CuyZ\/NotiZ\/issues\/\1)/g"

git_log () {
    git log $LOG_RANGE \
        --grep="^\[$1\\]" \
        --date=format:"%d %b %Y" \
        --pretty=tformat:"$LOG_FORMAT_FULL" \
        | sed -r "$LOG_REPLACE_ISSUES" \
        | sed -r "s/\[$1\] //g"
}

FIRST_LINE=`sed -n 1p CHANGELOG.md`
FULL_CONTENT=`sed 1,1d CHANGELOG.md`

FEATURES=$(git_log FEATURE)
BUGFIX=$(git_log BUGFIX)
OTHERS=`git log $LOG_RANGE --grep="^\[BUGFIX\\]" --grep="^\[FEATURE\\]" --invert-grep --pretty=tformat:"$LOG_FORMAT_TINY" --date=format:"%d %b %Y"`

echo "$FIRST_LINE

v$TAG_NAME - $CURRENT_DATE
====================

New features
------------

$FEATURES

---

Bugs fixed
----------

$BUGFIX

Others
------

$OTHERS
$FULL_CONTENT" > CHANGELOG.md

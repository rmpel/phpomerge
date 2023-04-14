#!/usr/bin/env bash

CURDIR="$(pwd)";

TOOLDIR="$(realpath "$0")"
TOOLDIR="$(dirname "$TOOLDIR")"

[ ! -d "$TOOLDIR/vendor" ] && echo Tool not installed completely, please go to && echo "$TOOLDIR" && echo and run composer install && exit 1;

[ "$2" = "" ] && echo Usage: $0 masterfile.po to-be-merged-1.po \[ to-be-merged-2.po \[ ... to-be-merged-N.po \] \] && exit 1;

php "$TOOLDIR"/pomerge.php "$@"

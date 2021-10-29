#!/bin/sh

set -e

if [ "${1#-}" != "$1" ]; then
	set -- node "$@"
fi

yarn install

exec "$@"
#! /bin/bash

CMD="$1"

if [[ $# -eq 0 ]]; then
    CMD="dev"
fi

echo -e "Running composer install..."
composer install

echo -e "Running npm install..."
npm install

echo -e "Running npm run ${CMD}..."
npm run $CMD

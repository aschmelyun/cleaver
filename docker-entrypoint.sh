#! /bin/bash

CMD="$1"

if [[ $# -eq 0 ]]; then
    CMD="dev"
fi

echo -e "Running npm run ${CMD}..."
npm run $CMD

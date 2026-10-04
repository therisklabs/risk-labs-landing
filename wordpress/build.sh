#!/usr/bin/env bash
# Builds the upload-ready zips into wordpress/dist/.
# Usage: bash wordpress/build.sh
set -euo pipefail

cd "$(dirname "$0")"
rm -rf dist
mkdir -p dist

zip -rq dist/therisklabs.zip therisklabs -x '*.DS_Store'
zip -rq dist/trl-content-migration.zip trl-content-migration -x '*.DS_Store'

ls -l dist

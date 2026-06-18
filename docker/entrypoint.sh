#!/bin/bash
set -e

chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true

exec "$@"

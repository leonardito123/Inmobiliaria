#!/usr/bin/env bash
set -euo pipefail

APP_PATH="${1:-}"
WEBROOT_PATH="${2:-}"

if [ -z "$APP_PATH" ] || [ -z "$WEBROOT_PATH" ]; then
  echo "Uso: cpanel_publish_index.sh <app_path> <webroot_path>"
  exit 1
fi

mkdir -p "$WEBROOT_PATH"

cat > "$WEBROOT_PATH/index.php" <<PHP
<?php
/**
 * cPanel wrapper entrypoint.
 * This file is generated automatically by scripts/cpanel_publish_index.sh
 */

define('ROOT_PATH', '${APP_PATH}');
require ROOT_PATH . '/public/index.php';
PHP

echo "Wrapper index.php publicado en $WEBROOT_PATH apuntando a $APP_PATH"
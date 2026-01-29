#!/usr/bin/env bash
# Sama Water — إنشاء أرشفة للرفع على sama.baitpait.space
# يستثني: vendor, node_modules, .git, .env, storage runtime, zip files

set -e
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
cd "$SCRIPT_DIR"
OUTPUT_ZIP="sama-deployment.zip"

if [[ -f "$OUTPUT_ZIP" ]]; then
  echo "Removing existing $OUTPUT_ZIP..."
  rm -f "$OUTPUT_ZIP"
fi

echo "Creating $OUTPUT_ZIP (excluding vendor, node_modules, .git, .env, storage runtime)..."
zip -r "$OUTPUT_ZIP" . \
  -x "node_modules/*" \
  -x "vendor/*" \
  -x ".git/*" \
  -x ".env" \
  -x ".env.*" \
  -x "storage/logs/*" \
  -x "storage/framework/cache/*" \
  -x "storage/framework/sessions/*" \
  -x "storage/framework/views/*" \
  -x "*.zip" \
  -x ".DS_Store" \
  -x "*.log" \
  -x "tests/coverage/*"

echo "Done. Output: $SCRIPT_DIR/$OUTPUT_ZIP"
ls -la "$OUTPUT_ZIP"

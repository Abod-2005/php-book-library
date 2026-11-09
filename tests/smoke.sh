#!/usr/bin/env bash
set -euo pipefail
base=${1:-http://localhost:8080}
cookies=$(mktemp)
page=$(mktemp)
trap 'rm -f "$cookies" "$page"' EXIT
curl -fsS -c "$cookies" -b "$cookies" "$base/index.php" > "$page"
grep -q '1984' "$page"
curl -fsS -o /dev/null -c "$cookies" -b "$cookies" -d 'title=Test+Book&author=Jane+Doe&genre=Science&year=2020&pages=120' "$base/index.php"
curl -fsS -b "$cookies" "$base/index.php" > "$page"
grep -q 'Test Book' "$page"
curl -fsS -o /dev/null -c "$cookies" -b "$cookies" -d 'edit_id=4&title=Edited+Book&author=Jane+Doe&genre=Science&year=2020&pages=120' "$base/index.php"
curl -fsS -b "$cookies" "$base/index.php" > "$page"
grep -q 'Edited Book' "$page"
! grep -q 'Test Book' "$page"
curl -fsS -o /dev/null -c "$cookies" -b "$cookies" -d 'delete_id=4' "$base/index.php"
curl -fsS -b "$cookies" "$base/index.php" > "$page"
! grep -q 'Edited Book' "$page"
echo 'CRUD smoke test passed'

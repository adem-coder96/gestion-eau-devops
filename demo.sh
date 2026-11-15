#!/bin/bash
set -euo pipefail

REPO_URL="https://github.com/adem-coder96/gestion-eau-devops"
BRANCH="demo/$(date +%Y%m%d-%H%M%S)"
VERSION="demo-$(date +%Y%m%d-%H%M%S)"

echo "=== Gestion Eau DevOps Demo ==="

# Check current branch
if [ "$(git branch --show-current)" != "main" ]; then
    echo "Error: Run this script from the main branch."
    exit 1
fi

# Ensure health.php has no existing local changes
if ! git diff --quiet -- health.php || ! git diff --cached --quiet -- health.php; then
    echo "Error: health.php has existing changes. Protect them first."
    exit 1
fi

# Check expected version
if ! grep -q "'version' => 'step-5-test'" health.php; then
    echo "Error: Expected version was not found in health.php."
    exit 1
fi

# Create demonstration branch
git switch -c "$BRANCH"

# Update only the health endpoint version
sed -i "s/'version' => 'step-5-test'/'version' => '$VERSION'/" health.php

# Validate PHP if PHP CLI is installed
if command -v php >/dev/null 2>&1; then
    php -l health.php
else
    echo "PHP CLI not installed locally; GitHub Actions will validate PHP."
fi

# Stage and commit only health.php
git add -- health.php
git commit -m "demo: update health endpoint version"

# Push demonstration branch
git push -u github "$BRANCH"

echo ""
echo "Demo branch pushed successfully!"
echo "Create your Pull Request here:"
echo "$REPO_URL/compare/main...$BRANCH?expand=1"

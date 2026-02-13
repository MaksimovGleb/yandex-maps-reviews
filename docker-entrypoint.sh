#!/bin/bash
set -e

# Install composer dependencies
if [ ! -d "vendor" ]; then
    composer install --no-interaction --optimize-autoloader
fi

# Install npm dependencies and build assets
if [ ! -f "public/build/manifest.json" ]; then
    echo "Vite manifest not found. Installing dependencies and building assets..."
    npm install --legacy-peer-deps
    npm run build
fi

# Copy .env if not exists
if [ ! -f ".env" ]; then
    cp .env.docker .env
fi

# Generate key if not set in .env
if ! grep -q "APP_KEY=base64:" .env; then
    php artisan key:generate --force
fi

# Export the key to the environment so tests can see it
# Using sed to remove potential carriage returns and extract value
RAW_KEY=$(grep '^APP_KEY=' .env | head -1 | cut -d '=' -f2- | tr -d '\r')
export APP_KEY="$RAW_KEY"

if [ -z "$APP_KEY" ]; then
    echo "ERROR: APP_KEY is empty! Tests will fail."
else
    echo "APP_KEY detected, starting environment..."
fi

# Wait for database to be ready
echo "Waiting for database..."
until php artisan db:monitor --databases=mysql > /dev/null 2>&1; do
  sleep 1
done

# Clear config cache only to ensure correct env detection
php artisan config:clear

# Run tests
echo "Running tests..."
# IMPORTANT: Tests use SQLite in-memory (phpunit.xml)
php artisan test --without-tty || echo "WARNING: Tests failed! Check logs for details."

# Run migrations and seeders AFTER tests to ensure DB is ready for use
echo "Preparing database for application..."
php artisan migrate --seed --force

# Now it is safe to clear other caches since tables exist
php artisan cache:clear
php artisan route:clear

# Set permissions
chown -R www-data:www-data storage bootstrap/cache

# Start Apache in foreground
exec apache2-foreground

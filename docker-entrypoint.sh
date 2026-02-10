#!/bin/bash

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

# Wait for database to be ready
echo "Waiting for database..."
until php artisan db:monitor --databases=mysql > /dev/null 2>&1; do
  sleep 1
done

# Run migrations
php artisan migrate --seed --force

# Set permissions
chown -R www-data:www-data storage bootstrap/cache

# Start Apache in foreground
exec apache2-foreground

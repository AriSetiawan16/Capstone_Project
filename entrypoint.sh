#!/bin/bash

echo "Waiting for MySQL to be ready..."

until mysql -h"$DB_HOST" -u"$DB_USERNAME" -p"$DB_PASSWORD" -e "SHOW DATABASES;" > /dev/null 2>&1; do
  echo "MySQL belum siap. Coba lagi..."
  sleep 5
done

echo "MySQL ready! Melanjutkan..."

php artisan config:clear
php artisan migrate --force

exec apache2-foreground

echo "🚀 Starting deployment..."

git pull origin main

echo "📦 Installing Dependencies..."
composer install --no-dev --optimize-autoloader
npm ci
npm audit fix
npm run build

echo "🗄️ Migrating Database..."
php artisan migrate --force --pretend
if [ $? -eq 0 ]; then
    php artisan migrate --force
else
    echo "❌ Migrasi error! Batal deploy."
    exit 1
fi

echo "🧹 Clearing Cache..."
php artisan optimize:clear
php artisan optimize

echo "✅ Deployment Finished! Aman semua King, Seloww"

#!/bin/bash

echo "🚀 Setup Supabase untuk Laravel Logbook"
echo "========================================"

echo ""
echo "1. Buka https://supabase.com dan buat project baru"
echo "2. Setelah project siap, copy credentials berikut:"
echo ""

echo "Update .env file dengan konfigurasi ini:"
echo "----------------------------------------"
echo "DB_CONNECTION=pgsql"
echo "DB_HOST=db.YOUR_PROJECT_REF.supabase.co"
echo "DB_PORT=5432"
echo "DB_DATABASE=postgres"
echo "DB_USERNAME=postgres"
echo "DB_PASSWORD=YOUR_DB_PASSWORD"
echo ""

echo "3. Jalankan command ini setelah update .env:"
echo "--------------------------------------------"
echo "php artisan migrate:fresh --seed"
echo "php artisan key:generate"
echo ""

echo "4. Test koneksi database:"
echo "-------------------------"
echo "php artisan tinker"
echo "DB::connection()->getPdo();"
echo ""

echo "5. Deploy ke platform hosting:"
echo "------------------------------"
echo "- Vercel (Frontend)"
echo "- Railway (Backend)"
echo "- Render (Full Stack)"
echo ""

echo "✅ Setup selesai! Jangan lupa update .env dengan credentials Supabase yang bener."

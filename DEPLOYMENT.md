# 🚀 Deployment Guide - Laravel Logbook ke Supabase

## Prerequisites
- PHP 8.2+
- Composer
- Git
- Supabase account

## Step 1: Setup Supabase

1. **Buat Project**
   - Buka [supabase.com](https://supabase.com)
   - Sign up/Login
   - Create new project
   - Pilih region terdekat (Singapore/Japan)
   - Tunggu setup selesai

2. **Get Database Credentials**
   - Buka project dashboard
   - Settings → Database
   - Copy connection string

## Step 2: Update Environment

Update `.env` file:

```env
DB_CONNECTION=pgsql
DB_HOST=db.YOUR_PROJECT_REF.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=YOUR_DB_PASSWORD

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
```

## Step 3: Database Setup

```bash
# Install dependencies
composer install --optimize-autoloader --no-dev

# Run migrations
php artisan migrate:fresh --seed

# Generate app key
php artisan key:generate

# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

## Step 4: Deploy Options

### Option A: Railway (Recommended)
```bash
# Install Railway CLI
npm i -g @railway/cli

# Login
railway login

# Deploy
railway init
railway up
```

### Option B: Render
1. Connect GitHub repo
2. Build command: `composer install && php artisan migrate`
3. Start command: `php artisan serve --host 0.0.0.0 --port $PORT`

### Option C: Vercel + Railway
- Frontend: Vercel
- Backend: Railway
- Database: Supabase

## Step 5: Environment Variables di Hosting

Set environment variables di platform hosting:
- `APP_KEY`
- `APP_ENV=production`
- `APP_DEBUG=false`
- Database credentials dari Supabase

## Step 6: Test Deployment

1. Test koneksi database
2. Test semua routes
3. Test authentication
4. Test CRUD operations

## Troubleshooting

### Database Connection Error
- Cek credentials di `.env`
- Pastikan IP whitelist di Supabase
- Test dengan `php artisan tinker`

### Migration Error
- Cek PostgreSQL version compatibility
- Run `php artisan migrate:status`
- Reset dengan `php artisan migrate:fresh`

### Performance Issues
- Enable query caching
- Optimize database indexes
- Use Redis untuk cache (optional)

## Cost Estimation

**Supabase Free Tier:**
- 500MB database ✅
- 2GB bandwidth/month ✅
- 50K monthly users ✅

**Hosting (Monthly):**
- Railway: $5 credit
- Render: Free (sleep mode)
- Vercel: Free

**Total: $0-5/month** 🎉

## Security Checklist

- [ ] `APP_DEBUG=false`
- [ ] Strong database password
- [ ] HTTPS enabled
- [ ] Environment variables secured
- [ ] Database access restricted
- [ ] Regular backups

## Monitoring

- Supabase dashboard untuk database
- Hosting platform metrics
- Laravel logs
- Error tracking (optional)

---

**Next Steps:**
1. Setup Supabase project
2. Update `.env`
3. Test locally
4. Deploy ke hosting
5. Monitor performance

Need help? Check Laravel docs atau Supabase docs!

# 🚀 Production Deployment Checklist - Mail-ER

**Project**: Disposable Temporary Email System  
**Date**: 2026-01-31  
**Status**: Ready for Production

---

## ✅ PRE-DEPLOYMENT CHECKLIST

### 1. **Environment Configuration** (.env)
```env
# PRODUCTION SETTINGS (Update these on live server)
APP_NAME="Mail-ER"
APP_ENV=production
APP_DEBUG=false  # ⚠️ MUST BE FALSE IN PRODUCTION
APP_URL=https://yourdomain.com  # Update with your domain

# Security
APP_KEY=  # Run: php artisan key:generate

# Database (Update with your hosting credentials)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1  # Or your DB host
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_secure_password

# Cache (Recommended for production)
CACHE_DRIVER=redis  # Or file if Redis not available
SESSION_DRIVER=redis  # Or database
SESSION_LIFETIME=1440  # 24 hours

# Queue (Recommended)
QUEUE_CONNECTION=database  # Or redis

# Mail (For notifications - optional)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"
```

---

## 2. **Security Hardening**

### Required Updates:
- [x] Set `APP_DEBUG=false`
- [x] Set `APP_ENV=production`
- [x] Generate new `APP_KEY` on server
- [ ] Enable HTTPS (SSL Certificate)
- [ ] Update CORS settings if needed
- [ ] Remove debug files from public folder

### Files to Remove Before Upload:
```
check_providers.php
check_providers_debug.php
fix_cookie_settings.php
fix_duplicate_provider.php
fix_settings.php
check_db.php
```

---

## 3. **Database Preparation**

### On Live Server, Run:
```bash
# 1. Migrate tables
php artisan migrate --force

# 2. Seed essential data
php artisan db:seed --class=DatabaseSeeder

# 3. Seed page content
php artisan db:seed --class=MainPageSeeder

# 4. Create admin user (if not exists)
php artisan tinker
>>> \App\Models\User::create(['name' => 'Admin', 'email' => 'admin@yourdomain.com', 'password' => bcrypt('YourSecurePassword123'), 'role' => 'admin']);
```

---

## 4. **File Permissions (Linux/cPanel)**

```bash
# Storage and cache folders must be writable
chmod -R 775 storage
chmod -R 775 bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

---

## 5. **Optimization Commands**

### Run on production server:
```bash
# Clear all caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create storage link
php artisan storage:link
```

---

## 6. **Web Server Configuration**

### Apache (.htaccess) - Already included
Make sure `mod_rewrite` is enabled.

### Nginx (nginx.conf)
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/mail-er/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

---

## 7. **cPanel Deployment Steps**

### 1. Upload Files
- Upload entire project via FTP/File Manager
- Place in `public_html/` or subdirectory

### 2. Update Document Root
- In cPanel, update domain's Document Root to: `public_html/public`
- Or create `.htaccess` redirect in root

### 3. Setup Database
- Create MySQL database via cPanel
- Create database user
- Grant all privileges
- Update `.env` with credentials

### 4. Install Dependencies (SSH required)
```bash
composer install --optimize-autoloader --no-dev
npm install --production
npm run build
```

### 5. Run Artisan Commands
```bash
php artisan key:generate
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 8. **SSL Certificate (HTTPS)**

### Free SSL (Let's Encrypt via cPanel):
1. Go to cPanel → SSL/TLS Status
2. Click "Run AutoSSL"
3. Wait for certificate installation
4. Force HTTPS redirect

### Add to `.htaccess` (in public folder):
```apache
# Force HTTPS
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

---

## 9. **Post-Deployment Testing**

### Test Checklist:
- [ ] Homepage loads correctly
- [ ] Generate email (Random Domain)
- [ ] Generate email (Specific Domain)
- [ ] Check inbox for messages
- [ ] View message details
- [ ] Copy email functionality
- [ ] Admin login (`/admin/login`)
- [ ] Admin dashboard displays stats
- [ ] Provider management works
- [ ] Settings update works
- [ ] Cookie consent banner appears
- [ ] All pages load (About, Privacy, Terms, etc.)
- [ ] API Partners section displays
- [ ] Responsive design on mobile

---

## 10. **Maintenance & Monitoring**

### Regular Tasks:
1. **Database Cleanup** (Weekly):
   ```bash
   php artisan email:cleanup
   ```

2. **Check Logs**:
   - `storage/logs/laravel.log`

3. **Backups**:
   - Database: Weekly
   - Files: Monthly

4. **Updates**:
   ```bash
   composer update
   php artisan migrate
   php artisan cache:clear
   ```

---

## 11. **Known Issues & Solutions**

### Issue: "CSRF Token Mismatch"
**Solution**: Clear cache and regenerate APP_KEY
```bash
php artisan config:clear
php artisan key:generate
```

### Issue: "Storage link not working"
**Solution**: 
```bash
rm public/storage
php artisan storage:link
```

### Issue: "500 Error"
**Solution**: Check permissions
```bash
chmod -R 775 storage bootstrap/cache
```

### Issue: "Session not persisting"
**Solution**: Change SESSION_DRIVER to database
```bash
php artisan session:table
php artisan migrate
```

---

## 12. **Performance Optimization**

### Recommended Production Settings:

1. **Enable OPcache** (php.ini):
```ini
opcache.enable=1
opcache.memory_consumption=128
opcache.max_accelerated_files=10000
opcache.revalidate_freq=60
```

2. **Use Redis** (if available):
```env
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

3. **CDN for Assets** (Optional):
- Upload CSS/JS/Images to CDN
- Update asset URLs

---

## 📋 FINAL CHECKLIST

Before going live:
- [ ] `.env` configured for production
- [ ] `APP_DEBUG=false`
- [ ] Database migrated and seeded
- [ ] Admin user created
- [ ] Storage linked
- [ ] Caches optimized
- [ ] SSL certificate installed
- [ ] All debug files removed
- [ ] Permissions set correctly
- [ ] Email generation tested
- [ ] Admin panel tested
- [ ] Mobile responsiveness checked
- [ ] Cookie consent working
- [ ] All pages accessible

---

## 🎉 DEPLOYMENT COMPLETE!

Your Mail-ER application is now ready for production!

**Admin Access**: `https://yourdomain.com/admin/login`  
**Default Admin**: Create via tinker (see Database Preparation section)

**Support**: Check `storage/logs` for any errors.

---

**Last Updated**: 2026-01-31  
**Project Version**: 1.0.0

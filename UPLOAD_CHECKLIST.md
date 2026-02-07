# 📦 UPLOAD CHECKLIST - Mail-ER Production

## ✅ Files to UPLOAD (Everything except exclusions below)

### Core Laravel Files
✅ Upload these directories/files:
```
app/
bootstrap/
config/
database/
docs/
public/
resources/
routes/
storage/  (create if doesn't exist, set permissions)
vendor/  (if not using composer on server)

artisan
composer.json
composer.lock
package.json
.env.example
.htaccess (in public/)
README.md
DEPLOYMENT_GUIDE.md
DEPLOYMENT_SUMMARY.md
```

---

## ❌ Files to EXCLUDE (Do NOT upload)

### Debug/Test Files (DELETE before upload):
```
❌ check_providers.php
❌ check_providers_debug.php
❌ fix_cookie_settings.php
❌ fix_duplicate_provider.php
❌ fix_settings.php
❌ check_db.php
❌ check-deployment.php (run locally first, then delete)
```

### Development Dependencies:
```
❌ /node_modules/  (rebuild on server with: npm install --production)
❌ /vendor/  (rebuild on server with: composer install --no-dev)
❌ .env  (create new on server from .env.production)
❌ .env.backup
❌ /.git/  (if using Git)
❌ /.idea/
❌ /.vscode/
```

Quick delete command (run before uploading):
```bash
rm check_providers.php check_providers_debug.php fix_cookie_settings.php fix_duplicate_provider.php fix_settings.php check_db.php check-deployment.php
```

---

## 📋 Upload Methods

### Method 1: FTP/SFTP (Recommended for Beginners)
1. Use FileZilla or similar
2. Upload to: `public_html/` or `public_html/yourdomain/`
3. Set `public` folder as document root in cPanel

### Method 2: cPanel File Manager
1. Compress project to .zip locally
2. Upload via File Manager
3. Extract on server
4. Delete unnecessary files

### Method 3: Git (Advanced)
```bash
# On server via SSH
git clone your-repository.git
cd your-repository
composer install --optimize-autoloader --no-dev
npm install --production
npm run build
```

---

## ⚙️ Server-Side Setup (After Upload)

### 1. Create .env file
```bash
cp .env.production .env
# Edit with your credentials:
nano .env
```

### 2. Install Dependencies (if SSH available)
```bash
composer install --optimize-autoloader --no-dev
npm install --production
npm run build
```

### 3. Set Permissions
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache  # Linux
# Or via cPanel File Manager: Right-click → Permissions → 775
```

### 4. Generate App Key
```bash
php artisan key:generate
```

### 5. Run Database Migrations
```bash
php artisan migrate --force
php artisan db:seed --force
php artisan db:seed --class=MainPageSeeder --force
```

### 6. Create Storage Link
```bash
php artisan storage:link
```

### 7. Optimize for Production
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 8. Create Admin User
```bash
php artisan tinker
>>> \App\Models\User::create(['name' => 'Admin', 'email' => 'admin@yourdomain.com', 'password' => bcrypt('SecurePass123!'), 'role' => 'admin']);
>>> exit
```

---

## 🌐 cPanel Specific Instructions

### A. Point Domain to Public Folder

**Option 1: Update Document Root (Recommended)**
1. cPanel → Domains → Manage
2. Click domain name
3. Change Document Root to: `/public_html/public`
4. Save

**Option 2: Use .htaccess Redirect**
1. Copy `.htaccess.root` to root directory
2. Rename to `.htaccess`
3. All requests will redirect to public folder

### B. Create Database
1. cPanel → MySQL Databases
2. Create new database: `youruser_mailer`
3. Create user with strong password
4. Add user to database (All Privileges)
5. Note: hostname, database name, username, password

### C. Update .env
```env
DB_HOST=localhost
DB_DATABASE=youruser_mailer
DB_USERNAME=youruser_dbuser
DB_PASSWORD=your_secure_password
```

### D. PHP Version
1. cPanel → MultiPHP Manager
2. Select domain
3. Set to PHP 8.0 or higher

---

## 🔒 Security Final Checks

Before going live:
- [ ] `.env` file: `APP_DEBUG=false`
- [ ] `.env` file: `APP_ENV=production`
- [ ] `.env` file: Strong database password
- [ ] SSL Certificate installed (HTTPS)
- [ ] Debug files deleted
- [ ] Storage permissions: 775
- [ ] Test admin login
- [ ] Test email generation

---

## 🧪 Test Your Live Site

After deployment, test:
1. Visit homepage: `https://yourdomain.com`
2. Generate random email
3. Select specific domain & generate
4. Check inbox
5. View a message
6. Copy email to clipboard
7. Admin login: `https://yourdomain.com/admin/login`
8. Check mobile view
9. Test all footer links (Privacy, Terms, About, etc.)
10. Verify API Partners section

---

## 📦 Deployment Package Structure

Your upload should look like:
```
public_html/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/  ← Point domain here
│   ├── css/
│   ├── js/
│   ├── index.php
│   └── .htaccess
├── resources/
├── routes/
├── storage/  ← Must be writable (775)
├── vendor/  ← Install via composer
├── .env  ← Create from .env.production
├── artisan
├── composer.json
└── README.md
```

---

## 🆘 Troubleshooting

### 500 Internal Server Error
```bash
# Check permissions
chmod -R 775 storage bootstrap/cache

# Clear caches
php artisan config:clear
php artisan cache:clear

# Check error logs
tail -f storage/logs/laravel.log
```

### Blank Page / White Screen
- Enable debug temporarily: `APP_DEBUG=true`
- Check PHP error logs in cPanel
- Verify PHP version is 8.0+

### CSS/JS Not Loading
```bash
# Clear caches
php artisan view:clear
php artisan cache:clear

# Rebuild assets
npm run build
```

### Database Connection Error
- Verify credentials in `.env`
- Check database exists in cPanel
- Test connection via cPanel phpMyAdmin

---

## ✅ CHECKLIST SUMMARY

**Before Upload:**
- [ ] Run `php check-deployment.php` locally
- [ ] Delete all debug files
- [ ] Test locally one more time
- [ ] Backup current version

**During Upload:**
- [ ] Upload all files except exclusions
- [ ] Set correct file permissions
- [ ] Create database in cPanel
- [ ] Configure .env file

**After Upload:**
- [ ] Run migrations & seeders
- [ ] Create admin user
- [ ] Optimize caches
- [ ] Test all features
- [ ] Enable SSL/HTTPS
- [ ] Test from different browsers/devices

---

## 🎉 Ready to Deploy!

Follow this checklist step-by-step for a successful deployment.

**For detailed instructions, see:** `DEPLOYMENT_GUIDE.md`

**Questions?** Check `storage/logs/laravel.log` for errors.

---

**Good luck!** 🚀

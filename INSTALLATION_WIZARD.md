# 🎯 Mail-ER Installation Wizard Guide

## Overview

Your Mail-ER application now includes a **web-based installation wizard** that automates the entire setup process. No command-line knowledge required!

---

## 🚀 Quick Installation Steps

### 1. Upload Files
Upload all project files to your hosting:
- Via FTP/SFTP
- Via cPanel File Manager
- Via SSH/Git

### 2. Access Installer
Visit: `https://yourdomain.com/install`

The wizard will automatically launch.

### 3. Follow 5 Simple Steps

#### Step 1: Welcome
- Read the overview
- Click "Get Started"

#### Step 2: Requirements Check
The wizard will automatically check:
- ✅ PHP version (8.0+)
- ✅ Required PHP extensions
- ✅ Directory permissions

**If any requirements fail:**
```bash
# Fix permissions via SSH:
chmod -R 775 storage bootstrap/cache

# Or via cPanel File Manager:
# Right-click → Permissions → 775
```

#### Step 3: Database Configuration
Enter your database credentials:
- **Host**: Usually `localhost` or `127.0.0.1`
- **Port**: Usually `3306`
- **Database Name**: Your database name (must exist)
- **Username**: Database user
- **Password**: Database password

The wizard will:
- Test the connection
- Create all tables automatically
- Seed initial data
- Configure providers

#### Step 4: Admin Account
Create your administrator account:
- Application name (e.g., "Mail-ER")
- Application URL (e.g., "https://yourdomain.com")
- Admin full name
- Admin email (for login)
- Admin password (minimum 8 characters)

**Password Strength Indicator** will help you create a secure password.

#### Step 5: Finish
The wizard will automatically:
- Create storage links
- Optimize configuration
- Cache routes
- Cache views
- Create installation lock file

---

## 📋 What Gets Installed

### Database Tables
- `users` - Admin and user accounts
- `providers` - Email service providers  
- `pages` - Content management
- `settings` - Site configuration
- `temp_email_history` - Email tracking
- `activity_logs` - Admin activity logs
- And more...

### Initial Data
- **5 Email Providers** (Mail.tm, 1SecMail, Guerrilla Mail, DropMail.me, Mailsac)
- **6 Content Pages** (Home, About, Privacy Policy, Terms, Contact, Cookie Policy)
- **Default Settings** (Site name, timezone, etc.)
- **Your Admin Account**

### Optimizations
- Config caching
- Route caching
- View caching  
- Storage linking

---

## 🔒 Security Features

### Automatic Security Settings
The installer automatically sets:
```env
APP_ENV=production
APP_DEBUG=false
APP_KEY=[auto-generated]
```

### Installation Lock
After completion, a lock file is created at `storage/installed` to prevent re-installation.

### To Reinstall (if needed)
```bash
# Delete the lock file
rm storage/installed

# Clear database tables
# Then access /install again
```

---

## 🌐 Accessing Your Site

### After Installation

**Frontend (Public Site)**
- URL: `https://yourdomain.com`
- Features: Email generation, inbox, pages

**Admin Panel**
- URL: `https://yourdomain.com/admin/login`
- Login with your admin credentials created in Step 4

---

## 🛠️ Manual Installation (Alternative)

If you prefer command-line installation:

```bash
# 1. Copy environment file
cp .env.production .env

# 2. Edit .env with your settings
nano .env

# 3. Install dependencies
composer install --optimize-autoloader --no-dev

# 4. Generate app key
php artisan key:generate

# 5. Run migrations
php artisan migrate --force
php artisan db:seed --force

# 6. Create admin
php artisan tinker
>>> \App\Models\User::create(['name' => 'Admin', 'email' => 'admin@example.com', 'password' => bcrypt('password'), 'role' => 'admin']);

# 7. Optimize
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 8. Create lock file
echo "$(date)" > storage/installed
```

---

## ❓ Troubleshooting

### Installer Won't Load
**Problem**: 404 error on `/install`  
**Solution**: 
- Clear route cache: `php artisan route:clear`
- Check `.htaccess` exists in public folder
- Ensure mod_rewrite is enabled

### Permission Errors
**Problem**: Not writable errors  
**Solution**:
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Database Connection Failed
**Problem**: Can't connect to database  
**Solution**:
- Verify database exists in cPanel/phpMyAdmin
- Check credentials are correct
- Ensure database user has all privileges
- Try `127.0.0.1` instead of `localhost`

### White Screen After Install
**Problem**: Blank page  
**Solution**:
```bash
php artisan config:clear
php artisan cache:clear
chmod -R 775 storage
```

### Already Installed Error
**Problem**: Getting "already installed" message  
**Solution**:
- Delete `storage/installed` file
- Or access site normally (not `/install`)

---

## 🎨 Post-Installation

### Recommended Next Steps

1. **Configure Settings**
   - Admin Panel → Settings
   - Update site name, timezone, etc.

2. **Customize Pages**
   - Admin Panel → Content → Pages
   - Edit About, Privacy Policy, etc.

3. **Test Email Generation**
   - Visit homepage
   - Generate random email
   - Check inbox functionality

4. **Enable SSL/HTTPS**
   - Install SSL certificate
   - Force HTTPS in `.htaccess`

5. **Setup Backup**
   - Database backup schedule
   - File backup schedule

6. **Monitor Logs**
   - Check `storage/logs/laravel.log`
   - Review any errors

---

## 🔐 Important Files

### Created During Installation
- `.env` - Environment configuration
- `storage/installed` - Installation lock
- Database tables - All schema
- `bootstrap/cache/` - Cached config/routes

### Keep Secure
- `.env` file (never commit/share)
- Admin credentials
- Database credentials

---

## 🎯 Installation Wizard Features

### Modern UI
- Dark premium gaming theme
- Step-by-step progress indicator
- Real-time validation
- Password strength meter
- Animated progress bars

### Smart Checks
- Automatic requirement validation
- Database connection testing
- Permission verification
- Error handling with helpful messages

### Automation
- Zero terminal commands needed
- Auto-migration and seeding
- Auto-optimization
- Self-locking after completion

---

## 📞 Support

### If Installation Fails
1. Check `storage/logs/laravel.log`
2. Verify all requirements are met
3. Try manual installation method
4. Contact hosting support for permission issues

### Common Hosting Issues
- **Shared Hosting**: May need to contact support for PHP version
- **cPanel**: Use File Manager permissions UI
- **VPS/Dedicated**: Full control via SSH

---

## ✅ Installation Checklist

Before starting:
- [ ] Files uploaded to server
- [ ] Database created in cPanel/phpMyAdmin  
- [ ] Database user created with privileges
- [ ] SSL certificate installed (recommended)
- [ ] PHP 8.0+ available
- [ ] Composer dependencies installed

During installation:
- [ ] Completed Step 1: Welcome
- [ ] Completed Step 2: Requirements (all green)
- [ ] Completed Step 3: Database
- [ ] Completed Step 4: Admin account
- [ ] Completed Step 5: Finish

After installation:
- [ ] Tested homepage
- [ ] Tested email generation
- [ ] Logged into admin panel
- [ ] Reviewed settings
- [ ] Tested mobile responsiveness

---

## 🎉 Success!

Once you see "Installation Complete!" you're ready to use Mail-ER!

**Admin Access**: `https://yourdomain.com/admin/login`  
**Frontend**: `https://yourdomain.com`

Enjoy your new disposable email service! 🚀

---

**Version**: 1.0.0  
**Installation Method**: Web-Based Wizard  
**Time Required**: ~2-3 minutes

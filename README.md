# Mail-ER - Disposable Temporary Email System

Premium, secure disposable email service with multi-provider support.

## 🌟 Features

- **Multi-Provider Support**: Mail.tm, 1SecMail, Guerrilla Mail, DropMail.me, Mailsac
- **Smart Failover**: Automatic provider switching
- **Real-time Inbox**: Instant email updates
- **Premium UI**: Dark, glassmorphic, gaming-inspired design
- **Admin Panel**: Full control over providers, users, and content
- **Rich Content Editor**: Summernote WYSIWYG for pages
- **Cookie Consent**: GDPR-compliant banner
- **API Documentation**: Built-in docs for developers
- **Responsive Design**: Mobile-first, fully responsive

## 📋 Requirements

- PHP 8.0 or higher
- MySQL 5.7 or higher
- Composer
- Node.js & NPM (for assets)
- Apache/Nginx web server

## 🚀 Quick Start (Production)

### 1. Upload Files
Upload entire project to your hosting.

### 2. Install Dependencies
```bash
composer install --optimize-autoloader --no-dev
npm install --production
npm run build
```

### 3. Configure Environment
```bash
cp .env.production .env
# Edit .env with your database credentials
php artisan key:generate
```

### 4. Setup Database
```bash
php artisan migrate --force
php artisan db:seed --force
php artisan db:seed --class=MainPageSeeder --force
```

### 5. Optimize
```bash
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 6. Create Admin User
```bash
php artisan tinker
>>> \App\Models\User::create(['name' => 'Admin', 'email' => 'admin@yourdomain.com', 'password' => bcrypt('SecurePassword123'), 'role' => 'admin']);
```

## 🔐 Admin Access

**URL**: `https://yourdomain.com/admin/login`  
**Email**: admin@yourdomain.com  
**Password**: As set above

## 📖 Full Documentation

See `DEPLOYMENT_GUIDE.md` for comprehensive deployment instructions.

## 🏗️ Project Structure

```
mail-er/
├── app/                    # Application logic
│   ├── Http/Controllers/   # Controllers
│   ├── Models/             # Eloquent models
│   └── Services/           # Business logic
├── database/               # Migrations & seeders
├── public/                 # Web root (point domain here)
├── resources/              # Views, assets, lang
│   └── views/              # Blade templates
├── routes/                 # Route definitions
├── storage/                # Logs, cache, uploads
└── docs/                   # Documentation
```

## 🛠️ Configuration

### Providers
Manage email providers in Admin Panel → Providers

### Settings
Update site settings in Admin Panel → Settings

### Pages
Edit content pages in Admin Panel → Content → Pages

## 🐛 Troubleshooting

### Cache Issues
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### Permission Errors
```bash
chmod -R 775 storage bootstrap/cache
```

### Session Not Working
Update `.env`:
```env
SESSION_DRIVER=database
```
Then run:
```bash
php artisan session:table
php artisan migrate
```

## 📊 Tech Stack

- **Framework**: Laravel 9.x
- **Frontend**: Bootstrap 5, Font Awesome 6
- **Fonts**: Orbitron, Rajdhani (Google Fonts)
- **Database**: MySQL
- **Cache**: File/Redis
- **Queue**: Sync/Database

## 🔗 API Endpoints

- `GET /domains` - List available domains
- `POST /inbox/create` - Generate new email
- `GET /messages` - Fetch messages
- `GET /message/{id}` - Get specific message

## 🌐 Browser Support

- Chrome/Edge 90+
- Firefox 88+
- Safari 14+
- Mobile browsers (iOS/Android)

## 📝 License

Proprietary - All Rights Reserved

## 👨‍💻 Support

For issues, check `storage/logs/laravel.log`

---

**Version**: 1.0.0  
**Last Updated**: 2026-01-31

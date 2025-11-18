# 🌌 Ragilmalik's URL Shortener

<div align="center">

![Version](https://img.shields.io/badge/version-2.0-blue.svg)
![PHP](https://img.shields.io/badge/PHP-7.4+-purple.svg)
![License](https://img.shields.io/badge/license-MIT-green.svg)
![Status](https://img.shields.io/badge/status-production-success.svg)

**A next-generation URL shortener with stunning dark glassmorphism UI**

[Features](#-features) • [Demo](https://url.ragilmalik.com) • [Installation](#-installation) • [Usage](#-usage) • [API](#-api-reference)

---

### ✨ Why This URL Shortener?

Because settling for boring is not an option. I built this with a pure black (#000000) base, glassmorphism effects that would make Apple jealous, and animations smoother than butter. Oh, and it's **100% ad-free**. Forever.

</div>

---

## 🎯 Features

### 🎨 **Stunning Dark Theme**
- **Pure Black** (#000000) background with subtle gradient overlays
- **Glassmorphism** effects with 20px backdrop blur
- **Animated gradient borders** that glow on hover/focus
- **Floating particle effects** in the background
- **Smooth animations** (fadeIn, fadeInUp, scale, rotate)
- **Responsive design** that looks perfect on any device

### ⚡ **Single URL Shortening**
- Shorten URLs instantly with one click
- Custom short codes (e.g., `ragilmalik.com/portfolio`)
- Choose code length from **5 to 20 characters**
- Real-time validation and error handling
- Beautiful result cards with one-click copy

### 📦 **Bulk URL Shortening** *(NEW!)*
- Shorten up to **50 URLs at once**
- Custom codes per URL: `https://example.com mycustomcode`
- Batch processing with individual success/error tracking
- Download or copy all results
- Progress indicators and detailed results

### 📊 **Analytics & Tracking**
- Click counting for every short URL
- Track last accessed timestamp
- IP address logging (optional)
- User agent tracking
- Referrer information
- Admin dashboard with real-time stats

### 🔐 **Security First**
- SQL injection protection via PDO prepared statements
- XSS prevention with input sanitization
- Password-protected admin panel
- URL validation and malicious link prevention
- File access restrictions via .htaccess
- Secure session management

### 🎛️ **Admin Panel**
- Beautiful dark glassmorphism theme
- View all shortened URLs
- Enable/disable URLs without deleting
- Delete URLs permanently
- Sort and filter capabilities
- Pagination for large datasets
- Real-time statistics dashboard

---

## 🌟 What Makes This Special?

```
┌─────────────────────────────────────────────────────────┐
│                                                         │
│  ✓ No ads. Never had them. Never will.                │
│  ✓ Open source and free forever                       │
│  ✓ Dark theme that actually looks good                │
│  ✓ Animations that don't make you nauseous            │
│  ✓ Bulk shortening (because efficiency matters)       │
│  ✓ Tab system (single vs bulk mode)                   │
│  ✓ Custom code lengths (5-20 characters)              │
│  ✓ Glass effects everywhere                           │
│  ✓ Gradient borders that glow                         │
│  ✓ Mobile responsive (actually works on phones)       │
│                                                         │
└─────────────────────────────────────────────────────────┘
```

---

## 📸 Screenshots

### Main Interface (Single URL)
```
┌──────────────────────────────────────────────────────────────┐
│  🔗 Free URLs Shortener                     [Admin Panel]    │
│  No ads. We never serve ads. Nope. Never...                 │
│                                                              │
│  ┌─────────────────────────────────────────────────────┐   │
│  │ [Single URL] [Bulk URLs]                            │   │
│  ├─────────────────────────────────────────────────────┤   │
│  │ Enter your long URL                                  │   │
│  │ ┌─────────────────────────────────────────────────┐ │   │
│  │ │ https://example.com/very/long/url               │ │   │
│  │ └─────────────────────────────────────────────────┘ │   │
│  │                                                      │   │
│  │ Custom short code (optional)                         │   │
│  │ ┌──────────────┬───────────────────────────────────┐│   │
│  │ │ragilmalik.com/│ mycustomcode                     ││   │
│  │ └──────────────┴───────────────────────────────────┘│   │
│  │                                                      │   │
│  │ Short Code Length: [6 characters ▼]                 │   │
│  │                                                      │   │
│  │            [SHORTEN URL]                            │   │
│  └─────────────────────────────────────────────────────┘   │
│                                                              │
│  ⚡ Lightning Fast  🔒 Secure  📊 Analytics  ✨ Custom     │
└──────────────────────────────────────────────────────────────┘
```

### Bulk URL Mode
```
┌──────────────────────────────────────────────────────────────┐
│  ┌─────────────────────────────────────────────────────┐   │
│  │ [Single URL] [Bulk URLs] ←                          │   │
│  ├─────────────────────────────────────────────────────┤   │
│  │ Enter Multiple URLs                                  │   │
│  │ ┌─────────────────────────────────────────────────┐ │   │
│  │ │ https://example.com/page1                       │ │   │
│  │ │ https://example.com/page2 customcode            │ │   │
│  │ │ https://example.com/page3 portfolio             │ │   │
│  │ │                                                  │ │   │
│  │ └─────────────────────────────────────────────────┘ │   │
│  │                                                      │   │
│  │ ℹ️ How to use Bulk Shortening:                      │   │
│  │ • Enter one URL per line                            │   │
│  │ • Optional: Add custom code after URL              │   │
│  │ • Maximum 50 URLs at once                           │   │
│  │                                                      │   │
│  │            [SHORTEN ALL URLs]                       │   │
│  │                                                      │   │
│  │ Results:                                             │   │
│  │ ✓ ragilmalik.com/abc123 → example.com/page1 [Copy] │   │
│  │ ✓ ragilmalik.com/customcode → .../page2    [Copy] │   │
│  │ ✗ Invalid URL format                                │   │
│  └─────────────────────────────────────────────────────┘   │
└──────────────────────────────────────────────────────────────┘
```

---

## 🚀 Installation

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher / MariaDB 10.2+
- Apache with mod_rewrite enabled
- SSL certificate (recommended)

### Step 1: Clone & Upload

```bash
# Clone the repository
git clone https://github.com/ragilmalik/shortener.git

# Upload to your Hostinger via:
# - File Manager (hPanel)
# - FTP (FileZilla, WinSCP)
# - Git deployment

# Upload to:
# Main domain: /public_html/
# Subdomain: /public_html/subdomain_name/
```

### Step 2: Create MySQL Database

1. **Login to hPanel** (Hostinger Control Panel)
2. Navigate to **Databases → MySQL Databases**
3. Click **"Create New Database"**
   ```
   Database name: u123456_urlshortener
   ```
4. Click **Create**

5. **Create Database User**:
   ```
   Username: u123456_admin
   Password: [Generate strong password]
   ```
6. Click **Create**

7. **Assign User to Database**:
   - Select database: `u123456_urlshortener`
   - Select user: `u123456_admin`
   - Grant **ALL PRIVILEGES**
   - Click **Add**

8. **Save your credentials**:
   ```
   Host: localhost
   Database: u123456_urlshortener
   User: u123456_admin
   Password: [your_generated_password]
   ```

### Step 3: Import Database Schema

1. Go to **phpMyAdmin** in hPanel
2. Select your database from the left sidebar
3. Click **"Import"** tab
4. Click **"Choose File"** → Select `database.sql`
5. Click **"Go"**
6. ✅ Success message should appear

**Alternative - Manual SQL:**
```sql
-- Copy contents of database.sql
-- Paste into phpMyAdmin → SQL tab
-- Click Go
```

### Step 4: Configure Application

Edit `config.php` with your favorite editor:

```php
<?php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'u123456_urlshortener');    // Your database
define('DB_USER', 'u123456_admin');            // Your username
define('DB_PASS', 'your_secure_password_here'); // Your password

// Site Configuration
define('SITE_URL', 'https://yourdomain.com'); // No trailing slash!
define('SITE_NAME', 'Your URL Shortener');

// Security - CHANGE THIS!
define('ADMIN_PASSWORD', 'YourSuperSecretPassword123!');

// URL Generation
define('SHORT_CODE_LENGTH', 6);  // Default: 6
define('MIN_CODE_LENGTH', 5);    // Minimum: 5
define('MAX_CODE_LENGTH', 20);   // Maximum: 20

// Analytics
define('TRACK_CLICKS', true);    // Enable click tracking

// Debug (false in production!)
define('DEBUG_MODE', false);
?>
```

⚠️ **IMPORTANT**: Change `ADMIN_PASSWORD` to something secure!

### Step 5: Configure Cloudflare DNS

1. **Login to Cloudflare Dashboard**
2. Select your domain
3. Go to **DNS** settings

**For Main Domain:**
```
Type: A
Name: @
Content: [Your Hostinger Server IP]
Proxy: ✅ Proxied (Orange cloud)
TTL: Auto
```

**For Subdomain (e.g., s.yourdomain.com):**
```
Type: CNAME
Name: s
Content: yourdomain.com
Proxy: ✅ Proxied (Orange cloud)
TTL: Auto
```

4. **Enable SSL/TLS**:
   - Go to **SSL/TLS → Overview**
   - Set to **"Full"** or **"Full (strict)"**

5. Wait 5-10 minutes for DNS propagation

### Step 6: Configure .htaccess (If Needed)

**Installing in subdirectory?** Update `.htaccess`:

```apache
# For main domain (yourdomain.com/)
RewriteBase /

# For subdirectory (yourdomain.com/short/)
RewriteBase /short/
```

**Force HTTPS** (Recommended):
```apache
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

**Remove www** (Optional):
```apache
RewriteCond %{HTTP_HOST} ^www\.(.*)$ [NC]
RewriteRule ^(.*)$ https://%1/$1 [R=301,L]
```

### Step 7: Test Installation

#### 1. **Visit Your Domain**
```
https://yourdomain.com
```
You should see the beautiful dark interface!

#### 2. **Test Single URL Shortening**
- Enter: `https://github.com`
- Custom code: `github` (optional)
- Length: `6 characters`
- Click **Shorten URL**
- Result: `https://yourdomain.com/github` or `yourdomain.com/abc123`

#### 3. **Test Bulk URL Shortening**
- Click **"Bulk URLs"** tab
- Enter:
  ```
  https://github.com github
  https://twitter.com twitter
  https://youtube.com
  ```
- Click **Shorten All URLs**
- See results with copy buttons!

#### 4. **Test Redirect**
- Visit: `https://yourdomain.com/github`
- Should redirect to GitHub ✅

#### 5. **Test Admin Panel**
- Visit: `https://yourdomain.com/admin.php`
- Enter your admin password
- See dashboard with statistics!

---

## 🎯 Usage Guide

### Creating Single Short URLs

#### Basic Shortening
```
1. Enter long URL: https://example.com/very/long/url/path
2. Click "Shorten URL"
3. Get: yourdomain.com/abc123
4. Click "Copy" and share!
```

#### Custom Short Codes
```
1. Enter URL: https://github.com/ragilmalik
2. Custom code: github
3. Get: yourdomain.com/github
4. Easy to remember! ✨
```

#### Custom Length
```
1. Enter URL: https://example.com
2. Leave custom code empty
3. Select length: 10 characters
4. Get: yourdomain.com/aBcD123456
5. More secure with longer codes!
```

### Creating Bulk Short URLs

#### Format Options

**Option 1: URLs Only (Random Codes)**
```
https://example.com/page1
https://example.com/page2
https://example.com/page3
```
Result: Random 6-character codes (default)

**Option 2: URLs with Custom Codes**
```
https://example.com/page1 page1
https://example.com/page2 custom
https://example.com/page3 portfolio
```
Result: Custom codes as specified

**Option 3: Mixed**
```
https://example.com/page1
https://example.com/page2 mycode
https://example.com/page3
```
Result: Random codes for line 1 & 3, custom code for line 2

#### Advanced Examples

**Social Media Links:**
```
https://github.com/yourusername github
https://twitter.com/yourusername twitter
https://linkedin.com/in/yourusername linkedin
https://youtube.com/@yourusername youtube
https://instagram.com/yourusername instagram
```

**Product Pages:**
```
https://shop.example.com/products/item-1 product1
https://shop.example.com/products/item-2 product2
https://shop.example.com/products/item-3 product3
```

**Campaign Tracking:**
```
https://example.com/?utm_source=facebook&utm_campaign=sale fb-sale
https://example.com/?utm_source=twitter&utm_campaign=sale tw-sale
https://example.com/?utm_source=email&utm_campaign=sale email-sale
```

### Admin Panel Features

#### Dashboard Statistics
- **Total URLs**: Count of all shortened URLs
- **Total Clicks**: Aggregate click count
- **Custom URLs**: Number of custom short codes
- **Active URLs**: Currently enabled URLs

#### URL Management
```
┌────────────────────────────────────────────────────────┐
│ Short Code │ Original URL        │ Clicks │ Actions   │
├────────────────────────────────────────────────────────┤
│ github     │ github.com/user     │ 152    │ [Disable] │
│ abc123     │ example.com/page    │ 43     │ [Delete]  │
│ custom     │ mysite.com          │ 0      │ [Enable]  │
└────────────────────────────────────────────────────────┘
```

**Actions:**
- **Disable**: Temporarily disable URL (shows 410 error)
- **Enable**: Re-enable disabled URL
- **Delete**: Permanently remove URL and analytics

---

## 🎨 Customization

### Changing Colors

Edit `style.css`:

```css
:root {
    /* Your brand colors */
    --gradient-1: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --gradient-2: linear-gradient(135deg, #your-color-1, #your-color-2);

    /* Glass effects */
    --glass-bg: rgba(255, 255, 255, 0.03);
    --glass-border: rgba(255, 255, 255, 0.1);
}
```

### Changing Site Name

Edit `index.html`:
```html
<h1 class="logo">Your Brand Name</h1>
```

Edit `config.php`:
```php
define('SITE_NAME', 'Your Brand URL Shortener');
```

### Changing Footer

Edit `index.html`:
```html
<footer class="footer">
    <p>&copy; 2025 Your Company. All rights reserved.</p>
</footer>
```

### Custom Domain Setup

Update `config.php`:
```php
define('SITE_URL', 'https://short.yourdomain.com');
```

Then add DNS record in Cloudflare as shown in Step 5.

---

## 🔧 API Reference

### Shorten URL

```http
POST /api.php?action=shorten
Content-Type: application/json

{
  "url": "https://example.com",
  "custom": "mycustomcode",
  "length": 8
}
```

**Response:**
```json
{
  "success": true,
  "short_code": "mycustomcode",
  "short_url": "https://yourdomain.com/mycustomcode",
  "original_url": "https://example.com"
}
```

### Get URL Statistics

```http
GET /api.php?action=stats&code=abc123
```

**Response:**
```json
{
  "success": true,
  "stats": {
    "short_code": "abc123",
    "original_url": "https://example.com",
    "created_at": "2025-01-15 10:30:00",
    "clicks": 152,
    "last_accessed": "2025-01-18 15:45:00",
    "is_custom": false
  }
}
```

### List All URLs (Admin)

```http
POST /api.php?action=list
Content-Type: application/json

{
  "password": "your_admin_password",
  "page": 1
}
```

### Delete URL (Admin)

```http
POST /api.php?action=delete
Content-Type: application/json

{
  "password": "your_admin_password",
  "id": 123
}
```

### Toggle URL Status (Admin)

```http
POST /api.php?action=toggle
Content-Type: application/json

{
  "password": "your_admin_password",
  "id": 123
}
```

---

## 🐛 Troubleshooting

### "Database connection failed"

**Problem**: Can't connect to MySQL database

**Solutions**:
1. Verify credentials in `config.php`
2. Check database exists in phpMyAdmin
3. Ensure user has ALL PRIVILEGES
4. Test connection in phpMyAdmin directly
5. Contact Hostinger support if needed

```bash
# Check MySQL service
mysql -u username -p
# Enter password
SHOW DATABASES;
```

### "404 Not Found" on Short URLs

**Problem**: Short URLs return 404 error

**Solutions**:
1. Check `.htaccess` file is uploaded
2. Verify `RewriteBase` is correct:
   ```apache
   RewriteBase /          # For root
   RewriteBase /short/    # For subdirectory
   ```
3. Ensure mod_rewrite is enabled (Hostinger has this enabled)
4. Check Apache configuration allows .htaccess overrides
5. Test direct access: `yourdomain.com/redirect.php`

### "Short URL not redirecting"

**Problem**: URL exists but doesn't redirect

**Solutions**:
1. Enable DEBUG_MODE in `config.php`:
   ```php
   define('DEBUG_MODE', true);
   ```
2. Visit the short URL and check error message
3. Verify URL exists in database (phpMyAdmin)
4. Check if URL is active (not disabled)
5. Review PHP error logs in hPanel

### Admin Panel Login Issues

**Problem**: Can't login to admin panel

**Solutions**:
1. Verify password in `config.php`:
   ```php
   define('ADMIN_PASSWORD', 'YourPassword');
   ```
2. Clear browser cache and cookies
3. Try incognito/private mode
4. Check browser console for JavaScript errors (F12)
5. Ensure `admin.php` is uploaded correctly

### Cloudflare SSL Issues

**Problem**: "Error 522" or SSL warnings

**Solutions**:
1. Check Hostinger server is online
2. Verify DNS settings in Cloudflare:
   - A record points to correct IP
   - Proxy is enabled (orange cloud)
3. Set SSL/TLS to "Full" or "Full (strict)"
4. Wait 24 hours for SSL to propagate
5. Try "DNS only" mode temporarily (grey cloud)

### Bulk URLs Not Working

**Problem**: Bulk shortening fails or shows errors

**Solutions**:
1. Check URL format (one per line)
2. Verify custom codes are alphanumeric only
3. Don't exceed 50 URLs per batch
4. Check for extra spaces or special characters
5. Test with single URL first

### Permission Denied Errors

**Problem**: "Permission denied" when accessing files

**Solutions**:
```bash
# Via SSH or File Manager
chmod 755 public_html
chmod 644 *.php
chmod 644 *.html
chmod 644 *.css
chmod 644 *.js
chmod 644 .htaccess
chmod 600 config.php  # Most secure for config
```

---

## 📊 Database Schema

### `urls` Table
```sql
CREATE TABLE `urls` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `short_code` VARCHAR(10) UNIQUE NOT NULL,
  `original_url` TEXT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `clicks` INT DEFAULT 0,
  `last_accessed` TIMESTAMP NULL,
  `custom` TINYINT(1) DEFAULT 0,
  `active` TINYINT(1) DEFAULT 1,
  INDEX `idx_short_code` (`short_code`),
  INDEX `idx_created_at` (`created_at`)
) ENGINE=InnoDB;
```

**Fields:**
- `id` - Primary key, auto-increment
- `short_code` - Unique short code (e.g., "abc123")
- `original_url` - Full destination URL
- `created_at` - Creation timestamp
- `clicks` - Total click count
- `last_accessed` - Last click timestamp
- `custom` - 1 if custom code, 0 if random
- `active` - 1 if enabled, 0 if disabled

### `clicks` Table
```sql
CREATE TABLE `clicks` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `url_id` INT NOT NULL,
  `ip_address` VARCHAR(45),
  `user_agent` TEXT,
  `referer` VARCHAR(255),
  `clicked_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`url_id`) REFERENCES `urls`(`id`) ON DELETE CASCADE,
  INDEX `idx_url_id` (`url_id`)
) ENGINE=InnoDB;
```

**Fields:**
- `id` - Primary key
- `url_id` - Foreign key to urls table
- `ip_address` - Visitor IP (IPv4/IPv6)
- `user_agent` - Browser/device info
- `referer` - Referring URL
- `clicked_at` - Click timestamp

---

## 🔒 Security Features

### Built-in Protection

✅ **SQL Injection Prevention**
- PDO prepared statements
- Parameterized queries
- Input validation

✅ **XSS Protection**
- Input sanitization
- Output encoding
- Content Security Policy headers

✅ **CSRF Protection**
- JSON-based API
- Request validation
- Origin checking

✅ **Password Security**
- Hash comparison (timing-safe)
- No passwords in URLs
- Session-based admin auth

✅ **File Access Control**
- .htaccess restrictions
- Config file protection
- Database file blocking

✅ **URL Validation**
- Format checking
- Protocol enforcement
- Malicious pattern detection

### Recommended Security Practices

1. **Use Strong Admin Password**
   ```php
   // Minimum 12 characters, mixed case, numbers, symbols
   define('ADMIN_PASSWORD', 'MyStr0ng!P@ssw0rd2025');
   ```

2. **Enable HTTPS Only**
   ```apache
   # Force HTTPS in .htaccess
   RewriteCond %{HTTPS} off
   RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
   ```

3. **Disable Debug Mode in Production**
   ```php
   define('DEBUG_MODE', false);
   ```

4. **Regular Backups**
   - Daily database exports
   - Weekly file backups
   - Store backups off-server

5. **Monitor Your URLs**
   - Check admin panel regularly
   - Disable suspicious URLs
   - Review click analytics

6. **Update Regularly**
   - Keep PHP updated
   - Update MySQL/MariaDB
   - Monitor security advisories

---

## 📈 Performance Tips

### Optimization Checklist

✅ **Enable Cloudflare Caching**
```
1. Login to Cloudflare
2. Go to Caching
3. Set Cache Level: Standard
4. Browser Cache TTL: 4 hours
```

✅ **Database Indexing**
```sql
-- Already included in schema
CREATE INDEX idx_short_code ON urls(short_code);
CREATE INDEX idx_created_at ON urls(created_at);
```

✅ **Enable Compression**
```apache
# Already in .htaccess
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/css application/javascript
</IfModule>
```

✅ **Browser Caching**
```apache
# Already in .htaccess
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
</IfModule>
```

✅ **Optimize Images** (if you add any)
- Use WebP format
- Compress before upload
- Lazy loading for below-fold images

### Expected Performance

- **Response Time**: < 100ms
- **Redirect Speed**: < 50ms
- **Page Load**: < 1s (on 4G)
- **Lighthouse Score**: 95+ Performance

---

## 🚀 Advanced Features

### Adding Custom Analytics

Track additional metrics by extending the `clicks` table:

```sql
ALTER TABLE clicks
ADD COLUMN country VARCHAR(50),
ADD COLUMN device_type VARCHAR(20),
ADD COLUMN browser VARCHAR(50);
```

Then update `redirect.php` to log these values.

### Rate Limiting

Add rate limiting to prevent abuse:

```php
// In api.php, before handleShorten()
function checkRateLimit($ip) {
    // Allow 10 URLs per hour per IP
    $stmt = $db->prepare("
        SELECT COUNT(*) as count
        FROM urls
        WHERE created_at > DATE_SUB(NOW(), INTERVAL 1 HOUR)
        AND creator_ip = ?
    ");
    $stmt->execute([$ip]);
    $result = $stmt->fetch();

    if ($result['count'] >= 10) {
        throw new Exception('Rate limit exceeded. Try again later.', 429);
    }
}
```

### Email Notifications

Get notified when URLs are created:

```php
// In api.php, after successful creation
mail(
    'your@email.com',
    'New Short URL Created',
    "Short Code: $shortCode\nOriginal: $originalUrl",
    'From: noreply@yourdomain.com'
);
```

### QR Code Generation

Add QR codes for each short URL:

```php
// Install phpqrcode library
require_once 'phpqrcode/qrlib.php';

// Generate QR code
QRcode::png($shortUrl, "qrcodes/$shortCode.png", 'L', 4, 2);
```

---

## 🎓 Best Practices

### URL Naming Convention

**Do:**
- `yourdomain.com/github` ✅
- `yourdomain.com/linkedin` ✅
- `yourdomain.com/blog-post-1` ✅

**Don't:**
- `yourdomain.com/ThisIsWayTooLongForAShortURL` ❌
- `yourdomain.com/special-chars-!@#` ❌
- `yourdomain.com/admin` ❌ (conflicts with admin.php)

### Bulk URL Best Practices

1. **Test with small batches first** (5-10 URLs)
2. **Use consistent naming** (product1, product2, etc.)
3. **Validate URLs** before bulk import
4. **Keep a backup** of your URL list
5. **Document custom codes** for future reference

### Admin Panel Tips

1. **Regular cleanup** - Delete unused URLs
2. **Monitor statistics** - Check click patterns
3. **Disable, don't delete** - Keep analytics by disabling instead
4. **Export data** - Backup URL list monthly
5. **Strong password** - Change admin password periodically

---

## 🌟 Roadmap

### Coming Soon™
- [ ] 📊 Advanced analytics dashboard with charts
- [ ] 🔐 Multi-user support with roles
- [ ] 📱 QR code generation
- [ ] 🌍 Geolocation tracking
- [ ] 📧 Email reports
- [ ] ⏰ Expiring links (auto-delete after X days)
- [ ] 🎯 A/B testing for URLs
- [ ] 📦 Bulk export/import
- [ ] 🔗 Link in bio feature
- [ ] 🎨 Custom themes

**Want a feature?** Open an issue!

---

## 🤝 Contributing

Found a bug? Have a feature request? Want to improve the code?

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## 📝 License

This project is licensed under the MIT License - feel free to use it for personal or commercial projects.

```
MIT License

Copyright (c) 2025 Ragilmalik

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software...
```

---

## 💬 Support

### Need Help?

- 📖 **Documentation**: You're reading it!
- 🐛 **Bug Reports**: [Open an issue](https://github.com/ragilmalik/shortener/issues)
- 💡 **Feature Requests**: [Open an issue](https://github.com/ragilmalik/shortener/issues)
- 📧 **Email**: [Send Email](mailto:hello@ragilmalik.com)

### Hostinger Support
- **Help Center**: https://support.hostinger.com
- **Live Chat**: Available 24/7 in hPanel
- **Tickets**: Create in hPanel

### Cloudflare Support
- **Community**: https://community.cloudflare.com
- **Documentation**: https://developers.cloudflare.com

---

## 🎉 Acknowledgments

Built with:
- ☕ Lots of coffee
- 🎵 Good music
- 💻 VS Code
- 🌙 Late nights
- ✨ Pure passion

Special thanks to:
- **PHP** - For being reliable
- **MySQL** - For storing everything
- **Cloudflare** - For making it fast
- **Hostinger** - For hosting it all
- **You** - For using this!

---

## 📊 Stats

![Lines of Code](https://img.shields.io/badge/lines%20of%20code-3500+-blue)
![Files](https://img.shields.io/badge/files-10-green)
![Coffee Consumed](https://img.shields.io/badge/coffee%20consumed-∞-brown)
![Hours Spent](https://img.shields.io/badge/hours%20spent-too%20many-red)

---

<div align="center">

### 🌟 Star this repo if you found it useful!

**Made with ❤️ by Ragilmalik**

[⬆ Back to Top](#-ragilmaliks-url-shortener)

---

**© 2025 Ragilmalik's URL Shortener**

*No ads. No tracking. No BS. Just short URLs.*

</div>

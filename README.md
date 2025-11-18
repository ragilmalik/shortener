# URL Shortener - Complete Setup Guide

A modern, full-featured URL shortener built with PHP, MySQL, HTML, CSS, and JavaScript. Perfect for Hostinger shared hosting with Cloudflare DNS management.

## 🌟 Features

- ✨ **Beautiful UI** - Modern gradient design with smooth animations
- ⚡ **Fast & Lightweight** - Optimized for shared hosting environments
- 🔒 **Secure** - Password-protected admin panel
- 📊 **Analytics** - Track clicks and view statistics
- 🎨 **Custom Short Codes** - Create memorable branded links
- 📱 **Responsive Design** - Works perfectly on all devices
- 🛡️ **Security Features** - Protected against common vulnerabilities
- 🔄 **URL Management** - Enable/disable or delete short URLs

## 📁 Project Structure

```
url-shortener/
├── index.html          # Main landing page
├── admin.php           # Admin panel for managing URLs
├── api.php             # REST API endpoints
├── config.php          # Configuration file (EDIT THIS!)
├── redirect.php        # Handles short URL redirects
├── database.sql        # Database schema
├── style.css           # Stylesheet
├── script.js           # Frontend JavaScript
├── .htaccess           # URL rewriting rules
└── README.md           # This file
```

## 🚀 Installation Guide

### Step 1: Download and Upload Files

1. **Download all project files** to your local computer
2. **Connect to your Hostinger account** via:
   - **Option A: File Manager** (in hPanel)
   - **Option B: FTP Client** (FileZilla, WinSCP, etc.)

3. **Upload all files** to your web root directory:
   - For main domain: Upload to `/public_html/`
   - For subdomain: Upload to `/public_html/subdomain_name/`
   - For addon domain: Upload to the corresponding directory

### Step 2: Create MySQL Database

1. **Log in to hPanel** (Hostinger Control Panel)
2. Navigate to **Databases → MySQL Databases**
3. Click **"Create New Database"**
   - Database name: Choose a name (e.g., `u123456_shortener`)
   - Click **Create**
4. **Create Database User**:
   - Username: Choose a username (e.g., `u123456_admin`)
   - Password: Generate a strong password
   - Click **Create**
5. **Assign User to Database**:
   - Select the database you created
   - Select the user you created
   - Grant **ALL PRIVILEGES**
   - Click **Add**

6. **Save these credentials** - you'll need them in Step 3:
   ```
   Database Host: localhost (usually)
   Database Name: [your_database_name]
   Database User: [your_username]
   Database Password: [your_password]
   ```

### Step 3: Import Database Schema

1. In hPanel, go to **Databases → phpMyAdmin**
2. Click on your database name in the left sidebar
3. Click the **"Import"** tab at the top
4. Click **"Choose File"** and select `database.sql`
5. Scroll down and click **"Go"**
6. You should see a success message

**Alternative: Manual Import**
```sql
-- Copy the contents of database.sql and paste into phpMyAdmin SQL tab
```

### Step 4: Configure the Application

1. **Open `config.php` in a text editor**

2. **Update Database Credentials** (from Step 2):
   ```php
   define('DB_HOST', 'localhost');           // Usually 'localhost'
   define('DB_NAME', 'your_database_name');  // Your database name
   define('DB_USER', 'your_database_user');  // Your database username
   define('DB_PASS', 'your_database_password'); // Your database password
   ```

3. **Update Site Configuration**:
   ```php
   define('SITE_URL', 'https://ragilmalik.com'); // Your domain (no trailing slash)
   define('SITE_NAME', 'RagilMalik URL Shortener'); // Your site name
   ```

4. **Set Admin Password** (IMPORTANT!):
   ```php
   define('ADMIN_PASSWORD', 'your_secure_password'); // Change this!
   ```
   ⚠️ **Security Note**: Choose a strong, unique password!

5. **Optional Settings**:
   ```php
   define('SHORT_CODE_LENGTH', 6);  // Length of short codes (6-10 recommended)
   define('TRACK_CLICKS', true);    // Enable/disable click analytics
   define('DEBUG_MODE', false);     // Set to true only when debugging
   ```

6. **Save the file** and **re-upload** to your server

### Step 5: Configure Cloudflare DNS

1. **Log in to Cloudflare**
2. Select your domain **ragilmalik.com**
3. Go to **DNS** settings
4. Verify you have an **A Record** or **CNAME Record** pointing to your Hostinger server:

   **For Main Domain:**
   ```
   Type: A
   Name: @ (or ragilmalik.com)
   Content: [Your Hostinger Server IP]
   Proxy status: Proxied (orange cloud)
   ```

   **For Subdomain (e.g., short.ragilmalik.com):**
   ```
   Type: CNAME
   Name: short
   Content: ragilmalik.com
   Proxy status: Proxied (orange cloud)
   ```

5. **Enable SSL/TLS** in Cloudflare:
   - Go to **SSL/TLS** → **Overview**
   - Set encryption mode to **"Full"** or **"Full (strict)"**

6. Wait 5-10 minutes for DNS propagation

### Step 6: Configure .htaccess (If Needed)

1. **Open `.htaccess` file**

2. **If installing in a subdirectory**, update RewriteBase:
   ```apache
   # For main domain (ragilmalik.com/)
   RewriteBase /

   # For subdirectory (ragilmalik.com/shortener/)
   RewriteBase /shortener/
   ```

3. **Optional: Force HTTPS** (Recommended):
   Uncomment these lines:
   ```apache
   RewriteCond %{HTTPS} off
   RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
   ```

4. **Optional: Redirect www to non-www**:
   Uncomment if you want www.ragilmalik.com → ragilmalik.com:
   ```apache
   RewriteCond %{HTTP_HOST} ^www\.(.*)$ [NC]
   RewriteRule ^(.*)$ https://%1/$1 [R=301,L]
   ```

### Step 7: Test the Installation

1. **Visit your domain**: `https://ragilmalik.com`
   - You should see the URL shortener homepage

2. **Test Creating a Short URL**:
   - Enter a long URL (e.g., `https://example.com/very/long/url`)
   - Click "Shorten URL"
   - You should get a short URL like `https://ragilmalik.com/abc123`

3. **Test the Short URL**:
   - Click on the generated short URL
   - It should redirect to your original URL

4. **Test Admin Panel**:
   - Visit `https://ragilmalik.com/admin.php`
   - Enter your admin password (from config.php)
   - You should see a list of all short URLs

### Step 8: Security Hardening (Important!)

1. **Change Default Admin Password**:
   - Edit `config.php`
   - Set a strong password for `ADMIN_PASSWORD`

2. **Set Correct File Permissions**:
   ```bash
   # In Hostinger File Manager or via SSH:
   chmod 644 config.php      # Read/write for owner, read for others
   chmod 644 database.sql    # Same as above
   chmod 644 .htaccess       # Same as above
   ```

3. **Disable DEBUG_MODE in Production**:
   ```php
   define('DEBUG_MODE', false); // In config.php
   ```

4. **Backup Your Database Regularly**:
   - Use phpMyAdmin → Export
   - Or use Hostinger's automated backup feature

5. **Monitor Your URLs**:
   - Regularly check the admin panel
   - Delete or disable malicious URLs

## 🎯 Usage Guide

### Creating Short URLs

1. **Go to homepage**: `https://ragilmalik.com`
2. **Enter your long URL** in the input field
3. **Optional**: Enter a custom short code (3-20 alphanumeric characters)
4. **Click "Shorten URL"**
5. **Copy and share** your short URL!

### Custom Short Codes

Create memorable links:
- `ragilmalik.com/github` → Your GitHub profile
- `ragilmalik.com/linkedin` → Your LinkedIn
- `ragilmalik.com/portfolio` → Your portfolio

### Admin Panel Features

Access at: `https://ragilmalik.com/admin.php`

**Features**:
- 📊 View statistics (total URLs, clicks, etc.)
- 📋 List all short URLs with details
- ✏️ Enable/disable URLs without deleting
- 🗑️ Delete URLs permanently
- 🔄 Refresh data in real-time

## 🔧 Customization

### Changing Colors/Theme

Edit `style.css`:
```css
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    /* Change these to your preferred colors */
}
```

### Changing Site Name/Logo

Edit `index.html` and `admin.php`:
```html
<h1 class="logo">Your Brand Name</h1>
```

### Changing Short Code Length

Edit `config.php`:
```php
define('SHORT_CODE_LENGTH', 8); // Change from 6 to any number (6-10 recommended)
```

## 🐛 Troubleshooting

### Problem: "Database connection failed"

**Solution**:
1. Check `config.php` database credentials
2. Verify database exists in phpMyAdmin
3. Test database connection in phpMyAdmin
4. Check if database user has correct privileges

### Problem: "404 Not Found" on short URLs

**Solution**:
1. Check if `.htaccess` file is uploaded
2. Verify `RewriteBase` in `.htaccess` is correct
3. Contact Hostinger to ensure mod_rewrite is enabled
4. Check if Apache configuration allows `.htaccess` overrides

### Problem: "Short URL not redirecting"

**Solution**:
1. Test with `https://ragilmalik.com/redirect.php?code=abc123`
2. Check if URL exists in database (phpMyAdmin)
3. Enable `DEBUG_MODE` in `config.php` to see errors
4. Check PHP error logs in hPanel

### Problem: "Admin panel not working"

**Solution**:
1. Verify admin password in `config.php`
2. Clear browser cache and cookies
3. Try incognito/private browsing mode
4. Check browser console for JavaScript errors

### Problem: "Permission denied" errors

**Solution**:
```bash
# Set correct permissions via File Manager or SSH:
chmod 755 public_html
chmod 644 *.php
chmod 644 *.html
chmod 644 *.css
chmod 644 *.js
chmod 644 .htaccess
```

### Problem: Cloudflare shows "Error 522"

**Solution**:
1. Check if Hostinger server is online
2. Verify DNS settings in Cloudflare
3. Try setting Cloudflare to "DNS only" (grey cloud) temporarily
4. Contact Hostinger support

## 📊 Database Schema

### `urls` Table
- `id` - Primary key
- `short_code` - The short code (e.g., "abc123")
- `original_url` - The full URL to redirect to
- `created_at` - Timestamp of creation
- `clicks` - Number of times clicked
- `last_accessed` - Last click timestamp
- `custom` - Whether it's a custom code (1) or random (0)
- `active` - Whether URL is active (1) or disabled (0)

### `clicks` Table
- `id` - Primary key
- `url_id` - Foreign key to urls table
- `ip_address` - Visitor IP
- `user_agent` - Browser/device info
- `referer` - Referring URL
- `clicked_at` - Click timestamp

## 🔒 Security Features

✅ **SQL Injection Protection** - Prepared statements with PDO
✅ **XSS Protection** - Input sanitization and validation
✅ **CSRF Protection** - API request validation
✅ **Password Protection** - Admin panel secured
✅ **File Access Control** - .htaccess restrictions
✅ **URL Validation** - Prevents malicious URLs
✅ **Rate Limiting** - Can be added via Cloudflare

## 📈 Future Enhancements

Want to add more features? Here are some ideas:

- 📧 **Email Reports** - Weekly statistics via email
- 📊 **Advanced Analytics** - Graphs and charts
- 🔐 **User Accounts** - Multi-user support
- 🌍 **Geographic Tracking** - See where clicks come from
- 📱 **QR Codes** - Generate QR codes for short URLs
- ⏰ **Expiring Links** - Set expiration dates
- 🔗 **Link in Bio** - Create a link page
- 🎯 **A/B Testing** - Test different URLs

## 📞 Support

### Hostinger Support
- **Help Center**: https://support.hostinger.com
- **Live Chat**: Available 24/7 in hPanel
- **Email**: support@hostinger.com

### Cloudflare Support
- **Help Center**: https://support.cloudflare.com
- **Community**: https://community.cloudflare.com

### Common Hostinger Resources
- How to upload files: https://support.hostinger.com/en/articles/1583245-how-to-upload-files-to-your-hosting
- How to create MySQL database: https://support.hostinger.com/en/articles/1583188-how-to-create-a-mysql-database
- How to use phpMyAdmin: https://support.hostinger.com/en/articles/1583223-how-to-use-phpmyadmin

## 📝 License

This project is free to use and modify for personal and commercial purposes.

## 🎉 You're All Set!

Your URL shortener is now live at **https://ragilmalik.com**!

**Next Steps**:
1. Create your first short URL
2. Share it with friends
3. Monitor clicks in the admin panel
4. Customize the design to match your brand

**Need Help?** Re-read the troubleshooting section or contact Hostinger support.

---

**Made with ❤️ for ragilmalik.com**

Last Updated: November 2024

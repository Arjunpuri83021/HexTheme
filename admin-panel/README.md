# Hexmy Admin Panel

Custom PHP admin panel for Hexmy video streaming website with full CRUD operations for videos, categories, tags, and pornstars.

## Features

- **Dashboard** - Statistics overview (total videos, views, likes, categories, tags, pornstars)
- **Video Management** - Add, edit, delete videos with all required fields
- **Categories Management** - Add and delete video categories
- **Tags Management** - Add and delete video tags
- **Pornstars Management** - Add and delete pornstars with bio and images
- **Authentication** - Secure login system
- **Dark Theme** - Modern dark UI with neon accents

## Database Fields for Videos

- Title
- Image URL
- Preview Video URL
- Alt Keywords (comma separated)
- Star Name
- Tags (comma separated)
- Views
- Iframe URL
- Video URL
- Duration (minutes)
- Description
- Likes

## Database Setup

### Local Setup (XAMPP/WAMP)

1. **Install XAMPP/WAMP**
   - Download and install XAMPP from https://www.apachefriends.org/

2. **Start MySQL**
   - Open XAMPP Control Panel
   - Start MySQL

3. **Create Database**
   - Go to phpMyAdmin: http://localhost/phpmyadmin
   - Click "New" to create database
   - Database name: `hexmy_db`
   - Click "Create"

4. **Update Config**
   - Open `config.php`
   - Update database credentials if needed:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   define('DB_NAME', 'hexmy_db');
   ```

5. **Run Admin Panel**
   - Place admin-panel folder in XAMPP htdocs: `C:\xampp\htdocs\admin-panel`
   - Access: http://localhost/admin-panel/
   - Login: admin / admin123

### Hostinger Setup

1. **Create MySQL Database**
   - Login to Hostinger hPanel
   - Go to **Databases** → **MySQL Databases**
   - Click **Create database**
   - Database name: `hexmy_db` (or any name)
   - Username: (auto-generated)
   - Password: (set strong password)
   - Click **Create**

2. **Update Config for Hostinger**
   - Open `config.php`
   - Update with Hostinger credentials:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'your_hostinger_username');
   define('DB_PASS', 'your_hostinger_password');
   define('DB_NAME', 'your_database_name');
   ```

3. **Upload to Hostinger**
   - Go to Hostinger hPanel → **Websites** → **demo1.hextheme.com** → **File Manager**
   - Upload `admin-panel` folder to `/public_html/`
   - Or upload to a subdirectory: `/public_html/admin/`

4. **Access Admin Panel**
   - Go to: https://demo1.hextheme.com/admin-panel/
   - Login: admin / admin123
   - **IMPORTANT**: Change default password after first login

## File Structure

```
admin-panel/
├── config.php           # Database configuration and table creation
├── index.php            # Login page
├── dashboard.php        # Main dashboard
├── videos.php           # Video list
├── add-video.php        # Add video form
├── edit-video.php       # Edit video form
├── delete-video.php     # Delete video
├── logout.php           # Logout
├── categories.php       # Categories management
├── tags.php             # Tags management
├── pornstars.php        # Pornstars management
└── README.md            # This file
```

## Usage

### Login
- URL: http://yoursite.com/admin-panel/
- Username: admin
- Password: admin123

### Add Video
1. Go to **Add Video**
2. Fill in all fields:
   - Title: Video title
   - Image URL: Thumbnail image URL
   - Preview Video URL: Preview video URL
   - Alt Keywords: Keywords (comma separated)
   - Star Name: Star/Pornstar name
   - Tags: Tags (comma separated)
   - Views: Initial view count
   - Iframe URL: Iframe embed URL
   - Video URL: Direct video URL
   - Duration: Duration (e.g., 10:30)
   - Description: Video description
   - Likes: Initial like count
3. Click **Add Video**

### Manage Videos
- Go to **Videos** to see all videos
- Click **Edit** to modify video details
- Click **Delete** to remove video

### Categories
- Go to **Categories**
- Add category name
- Categories will be auto-slugified

### Tags
- Go to **Tags**
- Add tag name
- Tags will be auto-slugified

### Pornstars
- Go to **Pornstars**
- Add name, image URL, and bio
- Pornstars will be auto-slugified

## Database Tables

The admin panel automatically creates these tables on first run:

- **videos** - Video data
- **categories** - Video categories
- **tags** - Video tags
- **pornstars** - Pornstar profiles

## Security

- Change default admin password after first login
- Use strong database passwords
- Update config.php with real credentials before deployment
- Consider adding IP restrictions for admin access
- Use HTTPS in production

## Frontend Integration

To display data from admin panel in your WordPress theme:

### Connect WordPress to Admin Panel Database

In your WordPress theme's functions.php, add:

```php
// Connect to admin panel database
$admin_db = new mysqli('localhost', 'db_user', 'db_pass', 'hexmy_db');

// Fetch videos
$videos_query = "SELECT * FROM videos ORDER BY created_at DESC LIMIT 10";
$videos_result = $admin_db->query($videos_query);

// Display in theme
while ($video = $videos_result->fetch_assoc()) {
    // Display video data
}
```

### API Endpoint (Optional)

Create an API endpoint to serve data as JSON:

```php
// api.php in admin-panel
header('Content-Type: application/json');
require_once 'config.php';

$videos = $conn->query("SELECT * FROM videos ORDER BY created_at DESC");
$videos_array = array();

while ($row = $videos->fetch_assoc()) {
    $videos_array[] = $row;
}

echo json_encode($videos_array);
```

Then fetch in WordPress theme:
```javascript
fetch('/admin-panel/api.php')
    .then(response => response.json())
    .then(data => {
        // Display videos
    });
```

## Troubleshooting

### Database Connection Error
- Check database credentials in config.php
- Ensure MySQL server is running
- Verify database name is correct

### Tables Not Creating
- Ensure database user has CREATE TABLE privileges
- Check PHP error logs
- Manually run the SQL from config.php in phpMyAdmin

### Login Issues
- Clear browser cookies
- Check session is working
- Verify admin credentials in config.php

## Support

For issues and support:
- Email: support@hextheme.com
- GitHub: https://github.com/Arjunpuri83021/hexmy-wordpress

## License

Copyright © 2026 Hexmy. All rights reserved.

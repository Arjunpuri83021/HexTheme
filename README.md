# Hexmy - Premium Adult Video Streaming WordPress Theme

A modern, premium WordPress theme for adult video streaming websites inspired by PornX and Vicetemple style platforms.

## Features

### Design
- Dark cinematic UI with neon purple, pink, and red accents
- Glassmorphism effects and soft glow
- Premium modern typography (Inter font)
- Smooth hover animations and transitions
- Mobile-first responsive design
- Fast loading and optimized UI

### Header
- Logo with customizable branding
- Large search bar with AJAX suggestions
- Upload button
- Login/Register buttons
- Premium upgrade button
- Sticky transparent navbar
- Responsive mobile menu
- Notification icon
- User avatar dropdown

### Navigation
- Home
- Videos
- Categories
- Tags
- Pornstars
- Photos
- Community
- Blog

### Homepage Sections
1. **Hero Section** - Large featured video slider with auto-sliding banners
2. **Watched Recently** - Horizontal video card carousel
3. **Most Popular** - Grid layout with premium video cards
4. **All Videos** - Large responsive video grid with infinite scroll
5. **New Videos** - Recently uploaded content
6. **Blog Section** - Blog cards with featured images

### Video Cards
- Large thumbnail with hover preview animation
- Duration badge
- HD badge
- Views counter
- Like percentage bar
- Title text
- Category label
- Responsive scaling animation
- Rounded corners
- Shadow effects

### Video Page
- Large responsive video player
- Auto play support
- Like/dislike system
- Comments section
- Related videos
- Tags section
- Pornstar profiles
- Video description
- Favorite/watch later system
- Share buttons
- Theater mode
- Fullscreen mode

### Custom Post Types
- **Videos** - Custom post type for video content with meta fields for duration, views, likes, dislikes, video URL

### Custom Taxonomies
- **Categories** - Hierarchical taxonomy for video categories
- **Tags** - Non-hierarchical taxonomy for video tags
- **Pornstars** - Non-hierarchical taxonomy for pornstar profiles

### Footer
- Logo and branding
- DMCA page
- Privacy Policy
- Terms and Conditions
- Contact Us
- Content Removal
- Parental Control
- FAQ
- Social media icons

## Installation

### Method 1: WordPress Admin
1. Upload the `hexmy-theme` folder to `/wp-content/themes/`
2. Navigate to **Appearance** → **Themes**
3. Activate **Hexmy** theme

### Method 2: FTP/File Manager
1. Extract the theme ZIP file
2. Upload the `hexmy-theme` folder to `/wp-content/themes/`
3. Navigate to **Appearance** → **Themes**
4. Activate **Hexmy** theme

### Method 3: Git (Advanced)
1. Clone repository to `/wp-content/themes/hexmy-theme`
2. Activate theme in WordPress admin

## Setup

### 1. Create Pages
Create the following pages in WordPress:
- Home (use default template)
- Videos (leave blank - will use archive-video.php)
- About
- Contact
- DMCA
- Privacy Policy
- Terms & Conditions

### 2. Set Homepage
1. Go to **Settings** → **Reading**
2. Select "A static page"
3. Set "Homepage" to "Home"
4. Save changes

### 3. Configure Navigation
1. Go to **Appearance** → **Menus**
2. Create a new menu named "Primary Menu"
3. Add pages to menu
4. Check "Primary" under Display location
5. Save menu

### 4. Add Videos
1. Go to **Videos** → **Add New**
2. Add video title
3. Add video description
4. Set featured image (thumbnail)
5. Add video details in meta box:
   - Duration (e.g., "10:30")
   - Views (number)
   - Likes (number)
   - Dislikes (number)
   - Video URL (if using external video)
6. Select categories and tags
7. Publish

### 5. Customize Theme
1. Go to **Appearance** → **Customize**
2. Upload logo in **Site Identity**
3. Adjust colors if needed
4. Save changes

## Customization

### Colors
Edit CSS variables in `style.css`:
```css
:root {
    --bg-primary: #0a0a0a;
    --accent-purple: #9333ea;
    --accent-pink: #ec4899;
    --accent-red: #ef4444;
}
```

### Logo
Upload logo via **Appearance** → **Customize** → **Site Identity** or set in `functions.php`

### Video Cards
Modify video card HTML in `front-page.php` or create template parts in `template-parts/` folder

## Features to Add (Future)

### User System
- User registration/login
- User profiles
- Favorites
- Watch history
- Uploads management

### Video Player
- Premium video player integration
- HLS/DASH support
- Ads integration
- Premium locked videos

### Monetization
- Banner ads
- Native ads
- Popunder ads
- Membership plans
- Premium subscription
- Payment integration (Stripe, PayPal, Crypto)

### Community
- Comments system
- User playlists
- Follow system
- Social sharing

### Performance
- CDN integration
- Image optimization
- Lazy loading
- Caching
- Database optimization

## Technical Details

### WordPress Requirements
- WordPress 5.0 or higher
- PHP 7.4 or higher
- MySQL 5.6 or higher

### Recommended Plugins
- Classic Editor (for better content editing)
- Contact Form 7 (for contact forms)
- WP Super Cache (for caching)
- Smush (for image optimization)

### Browser Support
- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers

## File Structure

```
hexmy-theme/
├── style.css              # Main stylesheet
├── functions.php          # Theme functions and setup
├── header.php             # Site header
├── footer.php             # Site footer
├── index.php              # Default template
├── front-page.php         # Homepage
├── page.php               # Page template
├── single-video.php       # Single video template
├── archive-video.php      # Video archive template
├── assets/
│   └── js/
│       └── main.js        # JavaScript functionality
└── screenshot.png         # Theme screenshot
```

## Support

For support and updates:
- GitHub: https://github.com/Arjunpuri83021/hexmy-wordpress
- Email: support@hextheme.com

## License

GNU General Public License v2 or later

## Credits

- Theme by Hextheme
- Inspired by PornX and Vicetemple
- Icons from Lucide
- Fonts from Google Fonts (Inter)

## Changelog

### Version 1.0.0 (2026-05-24)
- Initial release
- Dark theme with neon accents
- Custom video post type
- Video cards with hover effects
- Homepage with multiple sections
- Responsive design
- AJAX search functionality
- Custom taxonomies (Categories, Tags, Pornstars)
- Single video page template
- Video archive page template

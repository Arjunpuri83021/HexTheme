<?php
require_once 'config.php';

// Check authentication
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit();
}

$success_msg = '';
$error_msg = '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Save settings directly to WordPress options
    update_option('_hexmy_ad_popunder', wp_unslash($_POST['ad_popunder'] ?? ''));
    update_option('_hexmy_ad_socialbar', wp_unslash($_POST['ad_socialbar'] ?? ''));
    update_option('_hexmy_ad_banner_300x250', wp_unslash($_POST['ad_banner_300x250'] ?? ''));
    
    $dl = trim($_POST['ad_direct_link'] ?? '');
    if (!empty($dl) && filter_var($dl, FILTER_VALIDATE_URL) === false) {
        $error_msg = 'Invalid Direct Link URL. Please enter a valid URL (starting with http:// or https://).';
    } else {
        update_option('_hexmy_ad_direct_link', esc_url_raw(wp_unslash($dl)));
        $success_msg = 'Ad Network configurations updated successfully!';
    }
}

// Retrieve current options
$ad_popunder = get_option('_hexmy_ad_popunder', '');
$ad_socialbar = get_option('_hexmy_ad_socialbar', '');
$ad_banner_300x250 = get_option('_hexmy_ad_banner_300x250', '');
$ad_direct_link = get_option('_hexmy_ad_direct_link', '');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hexmy Admin - Ad Network Settings</title>
    <link rel="stylesheet" href="css/admin-style.css?v=4">
    <script src="js/admin.js?v=4" defer></script>
</head>
<body>
    <?php $active_page = 'ads.php'; require_once 'sidebar.php'; ?>

    <div class="main-content">
        <div class="header">
            <div style="display:flex;align-items:center;gap:15px;">
                <button id="menu-toggle" class="menu-toggle">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </button>
                <h1>Ad Network Manager</h1>
            </div>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>

        <?php if (!empty($success_msg)): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($success_msg); ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($error_msg)): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($error_msg); ?>
            </div>
        <?php endif; ?>

        <!-- Ad Settings Form -->
        <div class="form-container">
            <form action="ads.php" method="POST" class="form-section">
                <h3>Adsterra / General Ad Placements</h3>

                <div class="form-group">
                    <label for="ad_direct_link">Direct Link / Smartlink URL</label>
                    <input type="url" id="ad_direct_link" name="ad_direct_link" 
                           placeholder="e.g., https://www.profitablecpmrate.com/abcdefgh"
                           value="<?php echo esc_url($ad_direct_link); ?>">
                    <small style="color:var(--text-muted);display:block;margin-top:5px;font-size:12px;">
                        This link will be bound to the global <strong>Download in HD</strong> button on single video detail pages.
                    </small>
                </div>

                <div class="form-group">
                    <label for="ad_banner_300x250">Banner Ad Code (300x250)</label>
                    <textarea id="ad_banner_300x250" name="ad_banner_300x250" 
                              placeholder="Paste your 300x250 script or iframe tag here..."
                              style="min-height: 120px; font-family: monospace; font-size:13px;"><?php echo htmlspecialchars($ad_banner_300x250); ?></textarea>
                    <small style="color:var(--text-muted);display:block;margin-top:5px;font-size:12px;">
                        This banner will render in the right-hand sidebar of all video pages.
                    </small>
                </div>

                <div class="form-group">
                    <label for="ad_popunder">Popunder Script Code</label>
                    <textarea id="ad_popunder" name="ad_popunder" 
                              placeholder="Paste your Popunder javascript block here..."
                              style="min-height: 140px; font-family: monospace; font-size:13px;"><?php echo htmlspecialchars($ad_popunder); ?></textarea>
                    <small style="color:var(--text-muted);display:block;margin-top:5px;font-size:12px;">
                        Popunder ad scripts are placed globally in the footer of all public frontend pages.
                    </small>
                </div>

                <div class="form-group">
                    <label for="ad_socialbar">Social Bar Ad Code</label>
                    <textarea id="ad_socialbar" name="ad_socialbar" 
                              placeholder="Paste your Social Bar code or script tag here..."
                              style="min-height: 140px; font-family: monospace; font-size:13px;"><?php echo htmlspecialchars($ad_socialbar); ?></textarea>
                    <small style="color:var(--text-muted);display:block;margin-top:5px;font-size:12px;">
                        Social bar scripts are placed globally in the footer of all public pages.
                    </small>
                </div>

                <button type="submit" class="btn" style="margin-top:10px;">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
                         style="display:inline;vertical-align:middle;margin-right:5px;">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                        <polyline points="7 3 7 8 15 8"></polyline>
                    </svg>
                    Save Configurations
                </button>
            </form>
        </div>
    </div>
</body>
</html>



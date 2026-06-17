<?php
require_once 'config.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit();
}

$categories = get_terms(['taxonomy' => 'video_category', 'hide_empty' => false]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hexmy Admin - Web Scraper Tool</title>
    <link rel="stylesheet" href="css/admin-style.css?v=4">
    <script src="js/admin.js?v=4" defer></script>
    <style>
        /* ── Progress Dashboard ───────────────────────── */
        .progress-section {
            margin-top: 30px;
            display: none; /* shown via JS */
        }
        .progress-section.visible { display: block; }

        .progress-dashboard {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 14px;
        }
        @media (max-width: 900px) { .progress-dashboard { grid-template-columns: repeat(3, 1fr); } }
        @media (max-width: 540px)  { .progress-dashboard { grid-template-columns: repeat(2, 1fr); } }

        .prog-card {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 14px;
            padding: 18px 20px;
            display: flex;
            flex-direction: column;
            gap: 5px;
            position: relative;
            overflow: hidden;
            transition: border-color 0.4s, transform 0.2s;
        }
        .prog-card:hover { transform: translateY(-2px); }
        .prog-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at top left, rgba(var(--cg),0.07), transparent 65%);
            pointer-events: none;
        }
        .prog-card.c-total   { --cg: 139,92,246;  border-color: rgba(139,92,246,0.35); }
        .prog-card.c-done    { --cg: 16,185,129;  border-color: rgba(16,185,129,0.35); }
        .prog-card.c-skipped { --cg: 245,158,11;  border-color: rgba(245,158,11,0.35); }
        .prog-card.c-errors  { --cg: 239,68,68;   border-color: rgba(239,68,68,0.35); }
        .prog-card.c-remain  { --cg: 99,179,237;  border-color: rgba(99,179,237,0.35); }

        .prog-card-lbl {
            font-size: 10.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.09em;
            color: var(--text-muted);
        }
        .prog-card-val {
            font-size: 38px;
            font-weight: 800;
            font-family: var(--font-heading);
            line-height: 1;
            transition: color 0.3s;
        }
        .prog-card.c-total   .prog-card-val { color: #a78bfa; }
        .prog-card.c-done    .prog-card-val { color: #10b981; }
        .prog-card.c-skipped .prog-card-val { color: #f59e0b; }
        .prog-card.c-errors  .prog-card-val { color: #ef4444; }
        .prog-card.c-remain  .prog-card-val { color: #63b3ed; }
        .prog-card-sub { font-size: 12px; color: var(--text-muted); }

        /* ── Progress Bar ─────────────────────────────── */
        .pbar-wrap {
            margin-top: 20px;
            background: rgba(255,255,255,0.06);
            border-radius: 999px;
            height: 11px;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.08);
        }
        .pbar-fill {
            height: 100%;
            width: 0%;
            border-radius: 999px;
            background: linear-gradient(90deg, #8b5cf6, #06b6d4);
            box-shadow: 0 0 12px rgba(139,92,246,0.55);
            transition: width 0.6s cubic-bezier(0.4,0,0.2,1);
        }
        .pbar-labels {
            margin-top: 7px;
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            color: var(--text-muted);
        }

        /* ── Status Badge ─────────────────────────────── */
        .scraper-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 600;
            padding: 7px 16px;
            border-radius: 999px;
            margin-top: 16px;
            transition: all 0.3s;
        }
        .scraper-badge.idle    { color: var(--text-muted); background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); }
        .scraper-badge.running { color: #60a5fa; background: rgba(96,165,250,0.1); border: 1px solid rgba(96,165,250,0.3); }
        .scraper-badge.done    { color: #10b981; background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.3); }
        .scraper-badge.error   { color: #ef4444; background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.3); }
        .badge-dot {
            width: 7px; height: 7px; border-radius: 50%; background: currentColor;
        }
        .scraper-badge.running .badge-dot { animation: blink 1.2s infinite; }
        @keyframes blink {
            0%,100% { opacity: 0.3; transform: scale(0.8); }
            50%      { opacity: 1;   transform: scale(1.2); }
        }

        /* ── Ticker ───────────────────────────────────── */
        .ticker {
            margin-top: 12px;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 8px;
            padding: 10px 16px;
            display: none;
            align-items: center;
            gap: 10px;
            font-size: 13px;
        }
        .ticker.visible { display: flex; }
        .ticker-lbl {
            font-weight: 700;
            color: var(--accent-cyan);
            white-space: nowrap;
            font-size: 10.5px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            flex-shrink: 0;
        }
        .ticker-title {
            color: #f1f5f9;
            font-weight: 500;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        /* ── Console ──────────────────────────────────── */
        .console-container {
            margin-top: 20px;
            background: #050508;
            border: 1px solid var(--accent-purple);
            border-radius: 12px;
            padding: 20px;
            box-shadow: var(--shadow-neon);
        }
        .console-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            padding-bottom: 10px;
            margin-bottom: 14px;
        }
        .console-title {
            font-family: var(--font-heading);
            font-size: 13px;
            font-weight: 700;
            color: var(--accent-cyan);
            text-transform: uppercase;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .cpulse {
            width: 8px; height: 8px;
            background: var(--accent-cyan);
            border-radius: 50%;
            transition: background 0.3s;
        }
        .cpulse.running { animation: blink 1.2s infinite; }
        .console-output {
            width: 100%;
            height: 280px;
            background: transparent;
            border: none;
            color: #10b981;
            font-family: 'Courier New', Courier, monospace;
            font-size: 12.5px;
            line-height: 1.65;
            resize: vertical;
            outline: none;
        }

        /* ── Start Button States ──────────────────────── */
        .btn-scraper { position: relative; overflow: hidden; }
        .btn-scraper.loading {
            opacity: 0.7;
            cursor: not-allowed;
            pointer-events: none;
        }
        .btn-scraper.loading::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.08), transparent);
            animation: shimmer 1.2s infinite;
        }
        @keyframes shimmer {
            from { transform: translateX(-100%); }
            to   { transform: translateX(100%); }
        }
    </style>
</head>
<body>
    <?php $active_page = 'scraper.php'; require_once 'sidebar.php'; ?>

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
                <h1>Web Scraper Tool</h1>
            </div>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>

        <!-- Config Form -->
        <div class="form-container">
            <div class="form-section">
                <h3>Scraper Configuration</h3>

                <div class="form-group">
                    <label for="scraper_site">Target Website *</label>
                    <select id="scraper_site" name="scraper_site" onchange="updatePlaceholder()" required>
                        <option value="xvideos">XVideos2</option>
                        <option value="fullhd">FullHD.xxx</option>
                        <option value="bigassz">Bigassz.com</option>
                        <option value="publicporno">Public-Porno.com</option>
                        <option value="pornve">Pornve.com</option>
                        <option value="anysex">AnySex.com</option>
                        <option value="iceporn">IcePorn.com</option>
                        <option value="w4nkr">W4nkr.com</option>
                        <option value="dafreeporn">DaFreePorn.com</option>
                        <option value="viptube">VipTube.icu</option>
                        <option value="juicexxx">JuiceXXX.com</option>
                        <option value="freeporn8">FreePorn8.com</option>
                        <option value="starwank">StarWank.com</option>
                        <option value="neporn">NePorn.com</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="scraper_url">Target Listings URL *</label>
                    <input type="url" id="scraper_url" name="scraper_url"
                           placeholder="e.g., https://www.xvideos2.com/tags/blowjob" required>
                    <small id="scraper_url_help" style="color:var(--text-muted);display:block;margin-top:5px;font-size:12px;">
                        Enter an XVideos2 tag/category URL.
                    </small>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
                    <div class="form-group">
                        <label for="video_limit">Scrape Limit (Videos)</label>
                        <input type="number" id="video_limit" name="video_limit" min="1" max="100" value="10">
                    </div>
                    <div class="form-group">
                        <label for="video_category">Assign to Category</label>
                        <select id="video_category" name="video_category">
                            <option value="">-- No Category --</option>
                            <?php if (!empty($categories) && !is_wp_error($categories)): ?>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?php echo $cat->term_id; ?>"><?php echo htmlspecialchars($cat->name); ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>

                <button type="button" id="start-btn" class="btn btn-scraper" style="margin-top:10px;" onclick="startScraper()">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
                         style="display:inline;vertical-align:middle;margin-right:5px;">
                        <path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l5.67-5.67"/>
                    </svg>
                    Start Scraping
                </button>
            </div>
        </div>

        <!-- ── Live Progress Section (hidden until scraping starts) ── -->
        <div class="progress-section" id="progress-section">

            <!-- Stat Cards -->
            <div class="progress-dashboard">
                <div class="prog-card c-total">
                    <div class="prog-card-lbl">Total</div>
                    <div class="prog-card-val" id="stat-total">—</div>
                    <div class="prog-card-sub">to process</div>
                </div>
                <div class="prog-card c-done">
                    <div class="prog-card-lbl">Scraped</div>
                    <div class="prog-card-val" id="stat-done">0</div>
                    <div class="prog-card-sub">inserted</div>
                </div>
                <div class="prog-card c-skipped">
                    <div class="prog-card-lbl">Skipped</div>
                    <div class="prog-card-val" id="stat-skipped">0</div>
                    <div class="prog-card-sub">duplicates</div>
                </div>
                <div class="prog-card c-errors">
                    <div class="prog-card-lbl">Errors</div>
                    <div class="prog-card-val" id="stat-errors">0</div>
                    <div class="prog-card-sub">failed</div>
                </div>
                <div class="prog-card c-remain">
                    <div class="prog-card-lbl">Remaining</div>
                    <div class="prog-card-val" id="stat-remain">—</div>
                    <div class="prog-card-sub">pending</div>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="pbar-wrap">
                <div class="pbar-fill" id="pbar-fill"></div>
            </div>
            <div class="pbar-labels">
                <span id="pbar-text">Waiting to start...</span>
                <span id="pbar-pct">0%</span>
            </div>

            <!-- Status Badge -->
            <div class="scraper-badge running" id="scraper-badge">
                <div class="badge-dot"></div>
                <span id="badge-text">Initializing...</span>
            </div>

            <!-- Current Video Ticker -->
            <div class="ticker" id="ticker">
                <span class="ticker-lbl">Now Processing:</span>
                <span class="ticker-title" id="ticker-title">—</span>
            </div>

            <!-- Terminal Log -->
            <div class="console-container">
                <div class="console-header">
                    <div class="console-title">
                        <div class="cpulse running" id="cpulse"></div>
                        Live Terminal Log
                    </div>
                    <span style="font-size:11px;color:var(--text-muted);" id="engine-lbl">CRAWLER ACTIVE</span>
                </div>
                <textarea id="console-log" class="console-output" readonly></textarea>
            </div>

        </div><!-- /progress-section -->
    </div>

<script>
// ───────────────────────────────────────────────────
// Website Dropdown Placeholder Config
// ───────────────────────────────────────────────────
const sitePlaceholders = {
    xvideos: {
        placeholder: "e.g., https://www.xvideos2.com/tags/blowjob",
        helpText: "Enter an XVideos2 tag/category URL."
    },
    fullhd: {
        placeholder: "e.g., https://www.fullhd.xxx/models/cherie-deville/",
        helpText: "Enter a FullHD.xxx model/pornstar listing URL."
    },
    bigassz: {
        placeholder: "e.g., https://bigassz.com/models/dani-daniels/",
        helpText: "Enter a Bigassz.com model listing URL."
    },
    publicporno: {
        placeholder: "e.g., https://public-porno.com/categories/cumshot/",
        helpText: "Enter a Public-Porno.com category/tag/model URL."
    },
    pornve: {
        placeholder: "e.g., https://pornve.com/tags/threesome/",
        helpText: "Enter a Pornve.com tags/category/model URL."
    },
    anysex: {
        placeholder: "e.g., https://anysex.com/videos/categories/threesome/",
        helpText: "Enter an AnySex category/tag/model listing URL."
    },
    iceporn: {
        placeholder: "e.g., https://www.iceporn.net/japanese",
        helpText: "Enter an IcePorn.com category/tag listing URL."
    },
    w4nkr: {
        placeholder: "e.g., https://w4nkr.com/categories/cumshot/",
        helpText: "Enter a W4nkr.com category/tag/model URL."
    },
    dafreeporn: {
        placeholder: "e.g., https://www.dafreeporn.com/categories/milf/",
        helpText: "Enter a DaFreePorn.com category/tag/model URL."
    },
    viptube: {
        placeholder: "e.g., https://www.viptube.icu/fingering",
        helpText: "Enter a VipTube.icu category/tag/model URL."
    },
    juicexxx: {
        placeholder: "e.g., https://juicexxx.com/categories/big-dick/",
        helpText: "Enter a JuiceXXX.com category/tag/model URL."
    },
    freeporn8: {
        placeholder: "e.g., https://www.freeporn8.com/categories/hardcore/",
        helpText: "Enter a FreePorn8.com category/tag/model URL."
    },
    starwank: {
        placeholder: "e.g., https://starwank.com/tags/kissing/",
        helpText: "Enter a StarWank.com category/tag/model URL."
    },
    neporn: {
        placeholder: "e.g., https://neporn.com/categories/big-ass/",
        helpText: "Enter a NePorn.com category/tag/model URL."
    }
};

function updatePlaceholder() {
    const site = document.getElementById('scraper_site').value;
    const urlInput = document.getElementById('scraper_url');
    const helpText = document.getElementById('scraper_url_help');
    if (sitePlaceholders[site]) {
        urlInput.placeholder = sitePlaceholders[site].placeholder;
        helpText.textContent = sitePlaceholders[site].helpText;
    }
}

document.addEventListener('DOMContentLoaded', updatePlaceholder);

// ───────────────────────────────────────────────────
// State
// ───────────────────────────────────────────────────
let pollTimer   = null;
let lastLogLen  = 0;
let isRunning   = false;

// ───────────────────────────────────────────────────
// Start scraping via AJAX
// ───────────────────────────────────────────────────
function startScraper() {
    const url   = document.getElementById('scraper_url').value.trim();
    const limit = document.getElementById('video_limit').value;
    const cat   = document.getElementById('video_category').value;

    if (!url) {
        alert('Please enter a target URL.');
        return;
    }

    // Reset UI
    resetUI();
    document.getElementById('progress-section').classList.add('visible');
    document.getElementById('start-btn').classList.add('loading');
    document.getElementById('start-btn').textContent = '⏳ Scraping...';
    isRunning = true;

    // Start polling immediately
    startPolling();

    // Fire AJAX to background worker
    const fd = new FormData();
    fd.append('scraper_url',    url);
    fd.append('video_limit',    limit);
    fd.append('video_category', cat);

    fetch('scraper-run.php', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(d => {
            // scraper-run.php returned — polling will pick up final state
        })
        .catch(e => {
            addLocalLog('❌ AJAX error: ' + e.message);
            setStatus('error', '❌ Failed to connect to scraper worker.');
            stopPolling();
        });
}

// ───────────────────────────────────────────────────
// Polling — fetches progress every 1.2 seconds
// ───────────────────────────────────────────────────
function startPolling() {
    if (pollTimer) clearInterval(pollTimer);
    pollTimer = setInterval(fetchProgress, 1200);
}

function stopPolling() {
    if (pollTimer) clearInterval(pollTimer);
    pollTimer = null;
    isRunning = false;
}

function fetchProgress() {
    fetch('scraper-progress.php?t=' + Date.now())
        .then(r => r.json())
        .then(d => updateUI(d))
        .catch(() => {}); // silent on network blips
}

// ───────────────────────────────────────────────────
// Update UI from progress data
// ───────────────────────────────────────────────────
function updateUI(d) {
    if (!d || d.status === 'idle') return;

    // Stat cards
    if (d.total    !== undefined) setText('stat-total',   d.total);
    if (d.done     !== undefined) setText('stat-done',    d.done);
    if (d.skipped  !== undefined) setText('stat-skipped', d.skipped);
    if (d.errors   !== undefined) setText('stat-errors',  d.errors);
    if (d.remaining !== undefined) setText('stat-remain', d.remaining);

    // Progress bar
    const pct = d.pct || 0;
    document.getElementById('pbar-fill').style.width = pct + '%';
    setText('pbar-pct',  pct + '%');
    if (d.message) setText('pbar-text', d.message);

    // Status badge
    if (d.status === 'running') setStatus('running', d.message || 'Running...');
    if (d.status === 'done')    setStatus('done',    d.message || '✅ Complete!');
    if (d.status === 'error')   setStatus('error',   d.message || '❌ Error');

    // Ticker
    const ticker = document.getElementById('ticker');
    if (d.current && d.status === 'running') {
        ticker.classList.add('visible');
        setText('ticker-title', d.current);
    } else {
        ticker.classList.remove('visible');
    }

    // Append new log lines
    if (d.log && d.log.length > lastLogLen) {
        const newLines = d.log.slice(lastLogLen);
        lastLogLen = d.log.length;
        const ta = document.getElementById('console-log');
        newLines.forEach(line => { ta.value += line + '\n'; });
        ta.scrollTop = ta.scrollHeight;
    }

    // Stop polling when done/error
    if (d.status === 'done' || d.status === 'error') {
        stopPolling();
        // Reset button
        const btn = document.getElementById('start-btn');
        btn.classList.remove('loading');
        btn.innerHTML = '<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" style="display:inline;vertical-align:middle;margin-right:5px;"><path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l5.67-5.67"/></svg> Start Scraping';
        // Console pulse
        const pulse = document.getElementById('cpulse');
        pulse.classList.remove('running');
        pulse.style.background = d.status === 'done' ? '#10b981' : '#ef4444';
        // Engine label
        setText('engine-lbl', d.status === 'done' ? 'COMPLETED ✓' : 'FAILED ✗');
    }
}

// ───────────────────────────────────────────────────
// Helpers
// ───────────────────────────────────────────────────
function setText(id, val) {
    const el = document.getElementById(id);
    if (el) el.textContent = val;
}

function setStatus(type, msg) {
    const badge = document.getElementById('scraper-badge');
    badge.className = 'scraper-badge ' + type;
    setText('badge-text', msg);
}

function addLocalLog(line) {
    const ta = document.getElementById('console-log');
    if (ta) { ta.value += line + '\n'; ta.scrollTop = ta.scrollHeight; }
}

function resetUI() {
    lastLogLen = 0;
    setText('stat-total',   '—');
    setText('stat-done',    '0');
    setText('stat-skipped', '0');
    setText('stat-errors',  '0');
    setText('stat-remain',  '—');
    setText('pbar-pct',     '0%');
    setText('pbar-text',    'Waiting to start...');
    document.getElementById('pbar-fill').style.width = '0%';
    document.getElementById('console-log').value = '';
    document.getElementById('ticker').classList.remove('visible');
    document.getElementById('cpulse').className = 'cpulse running';
    document.getElementById('cpulse').style.background = '';
    setText('engine-lbl', 'CRAWLER ACTIVE');
    setStatus('running', 'Initializing...');
}
</script>
</body>
</html>



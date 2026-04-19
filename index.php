<?php
require_once 'db/config.php';

// ==========================================
// 1. CONFIGURATION & FILTERS
// ==========================================

$limit = 12; // Countries per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// Get Region Filter from URL (default to 'All')
$regionFilter = isset($_GET['region']) ? $_GET['region'] : 'All';

// ==========================================
// 2. BUILD MAIN QUERY (Grid Data)
// ==========================================

$whereClause = "";
$params = [];
$types = "";

// Apply Region Filter if not "All"
if ($regionFilter !== 'All' && !empty($regionFilter)) {
    $whereClause = "WHERE region = ?";
    $params[] = $regionFilter;
    $types .= "s";
}

// A. Get Total Count FOR THIS REGION (for Pagination)
$countSql = "SELECT COUNT(*) AS total FROM countries $whereClause";
$stmtCount = $mysqli->prepare($countSql);
if (!empty($params)) {
    $stmtCount->bind_param($types, ...$params);
}
$stmtCount->execute();
$totalResult = $stmtCount->get_result();
$totalCountriesRegion = $totalResult ? (int)$totalResult->fetch_assoc()['total'] : 0;
$totalPages = ceil($totalCountriesRegion / $limit);
$stmtCount->close();

// B. Get Paginated Data
$sql = "SELECT * FROM countries $whereClause ORDER BY name LIMIT ? OFFSET ?";
$paramsForData = $params;
$typesForData = $types . "ii";
$paramsForData[] = $limit;
$paramsForData[] = $offset;

$stmt = $mysqli->prepare($sql);
$stmt->bind_param($typesForData, ...$paramsForData);
$stmt->execute();
$countriesResult = $stmt->get_result();

$countries = [];
if ($countriesResult) {
    while ($row = $countriesResult->fetch_assoc()) {
        $countries[] = $row;
    }
}
$stmt->close();

// ==========================================
// 3. GET DATA FOR CALCULATOR & GLOBAL STATS (ALL COUNTRIES)
// ==========================================
$calcResult = $mysqli->query("
    SELECT 
        name,
        slug,
        region,
        short_description,
        currency,
        best_period,
        image_url,
        avg_budget_min,
        avg_budget_max
    FROM countries
    ORDER BY name ASC
");

$allCountries = [];
if ($calcResult) {
    while ($row = $calcResult->fetch_assoc()) {
        $allCountries[] = $row;
    }
}

// Global stats
$totalAllCountries = count($allCountries);
$globalMinBudget = null;
$globalMaxBudget = null;
$cheapestCountryName = '';
$priciestCountryName = '';

foreach ($allCountries as $c) {
    if (!empty($c['avg_budget_min'])) {
        if ($globalMinBudget === null || $c['avg_budget_min'] < $globalMinBudget) {
            $globalMinBudget = (int)$c['avg_budget_min'];
            $cheapestCountryName = $c['name'];
        }
    }
    if (!empty($c['avg_budget_max'])) {
        if ($globalMaxBudget === null || $c['avg_budget_max'] > $globalMaxBudget) {
            $globalMaxBudget = (int)$c['avg_budget_max'];
            $priciestCountryName = $c['name'];
        }
    }
}

// Fallback values
if ($globalMinBudget === null) $globalMinBudget = 20;
if ($globalMaxBudget === null) $globalMaxBudget = 200;

// ==========================================
// 4. RANDOM CITIES LOGIC
// ==========================================
$randomCitiesQuery = $mysqli->query("
    SELECT name AS country, slug, top_city_1 AS city, top_city_1_image AS img FROM countries WHERE top_city_1 IS NOT NULL AND top_city_1 <> ''
    UNION ALL
    SELECT name AS country, slug, top_city_2 AS city, top_city_2_image AS img FROM countries WHERE top_city_2 IS NOT NULL AND top_city_2 <> ''
    UNION ALL
    SELECT name AS country, slug, top_city_3 AS city, top_city_3_image AS img FROM countries WHERE top_city_3 IS NOT NULL AND top_city_3 <> ''
");

$randomCities = [];
if ($randomCitiesQuery) {
    while ($row = $randomCitiesQuery->fetch_assoc()) {
        if (!empty($row['img'])) {
            $randomCities[] = $row;
        }
    }
}
shuffle($randomCities);
$randomCities = array_slice($randomCities, 0, 4);

// ==========================================
// HELPER FUNCTIONS
// ==========================================
function isActive($current, $target) {
    return $current === $target ? 'active' : '';
}

function getPageLink($pageNum) {
    $params = $_GET;
    $params['page'] = $pageNum;
    return '?' . http_build_query($params);
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    
    <meta name="google-adsense-account" content="ca-pub-7323563508006159">
    
    <!-- Google AdSense - Un singur script -->
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6865215291326132" crossorigin="anonymous"></script>

    <!-- Google AdSense Verification -->
    <meta name="google-adsense-account" content="ca-pub-6865215291326132">

    <title>Europe Uncovered – Smart Travel Guides & Real Daily Budgets</title>

    <!-- VIEWPORT -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- DESCRIPTION (SEO) -->
    <meta name="description" content="Plan your Europe trip with real daily budgets, detailed country guides, top cities, travel tips, and best periods to visit. Updated travel insights for 2025.">

    <!-- KEYWORDS -->
    <meta name="keywords" content="Europe travel budget 2025, European vacation costs, daily expenses Europe, cheap European destinations, travel calculator Europe, backpacking Europe cost, Europe trip planner, European countries budget comparison, affordable Europe travel, Europe on a budget">

    <!-- CANONICAL -->
    <link rel="canonical" href="https://europeuncovered.com/">

    <!-- OPEN GRAPH -->
    <meta property="og:title" content="Europe Uncovered – Smart Travel Guides & Real Daily Budgets">
    <meta property="og:description" content="Discover Europe with accurate daily budgets, top cities, travel seasons, and easy-to-read guides.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://europeuncovered.com/">
    <meta property="og:image" content="https://europeuncovered.com/assets/images/og-banner.png">
    <meta property="og:site_name" content="Europe Uncovered">

    <!-- TWITTER -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Europe Uncovered – Travel Guides & Budgets">
    <meta name="twitter:description" content="Europe travel guides with real daily costs, top destinations, beautiful cities, and practical tips.">
    <meta name="twitter:image" content="https://europeuncovered.com/assets/images/og-banner.png">

    <!-- FAVICONS -->
    <link rel="icon" type="image/png" sizes="48x48" href="https://europeuncovered.com/assets/images/logo.png">
    <link rel="icon" type="image/x-icon" href="https://europeuncovered.com/assets/images/logo.png">

    <!-- CSS -->
    <link rel="stylesheet" href="/assets/base.css">
    <link rel="stylesheet" href="/assets/header.css">
    <link rel="stylesheet" href="/assets/home-sections.css">
    <link rel="stylesheet" href="/assets/footer.css">
    <link rel="stylesheet" href="/assets/responsive.css">
    <link rel="stylesheet" href="/assets/nav-bar.css">
    <link rel="stylesheet" href="style.css">

    <!-- PERFORMANCE -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- SCHEMA.ORG (SEO Rich Results) -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebSite",
      "name": "Europe Uncovered",
      "url": "https://europeuncovered.com",
      "description": "Travel guides, daily budgets, top cities and insights for Europe.",
      "publisher": {
        "@type": "Organization",
        "name": "Europe Uncovered",
        "logo": {
          "@type": "ImageObject",
          "url": "https://europeuncovered.com/assets/images/logo.png"
        }
      },
      "potentialAction": {
        "@type": "SearchAction",
        "target": "https://europeuncovered.com/search?q={query}",
        "query-input": "required name=query"
      }
    }
    </script>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "FAQPage",
      "mainEntity": [
        {
          "@type": "Question",
          "name": "How accurate are the daily budgets?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Our daily budgets are based on real traveler data from 2024-2025, including accommodation, food, transport, and attractions. They're updated quarterly to reflect current prices."
          }
        },
        {
          "@type": "Question",
          "name": "Which is the cheapest country in Europe to visit?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Based on our 2025 data, <?php echo $cheapestCountryName ?: 'Eastern European countries'; ?> offers the lowest daily budget starting from €<?php echo $globalMinBudget; ?> per day for budget travelers."
          }
        },
        {
          "@type": "Question",
          "name": "When is the best time to visit Europe?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "The shoulder seasons (April-May and September-October) typically offer the best balance of good weather, fewer crowds, and reasonable prices across most European destinations."
          }
        }
      ]
    }
    </script>

    <!-- Custom CSS -->
    <style>
        /* Budget Calculator Enhanced Styles */
        .budget-calculator-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 60px 0;
            margin: 40px 0;
            border-radius: 20px;
        }
        
        .calculator-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1.5fr 1fr;
            gap: 30px;
            padding: 0 20px;
        }
        
        .calculator-card {
            background: white;
            border-radius: 20px;
            padding: 35px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        
        .calculator-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
            color: #2d3748;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .calculator-subtitle {
            color: #718096;
            margin-bottom: 25px;
            font-size: 16px;
        }
        
        .input-group {
            margin-bottom: 20px;
        }
        
        .input-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #4a5568;
            font-size: 14px;
        }
        
        .input-group select,
        .input-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        
        .input-group select:focus,
        .input-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .calculate-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-top: 10px;
        }
        
        .calculate-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }
        
        .budget-result {
            margin-top: 25px;
            padding: 20px;
            background: #f7fafc;
            border-radius: 15px;
            display: none;
            border: 1px solid #e2e8f0;
        }
        
        .budget-result.show {
            display: block;
            animation: slideIn 0.5s ease;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .budget-item {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .budget-item:last-child {
            border-bottom: none;
        }
        
        .budget-label {
            font-weight: 600;
            color: #4a5568;
        }
        
        .budget-value {
            font-weight: 700;
            color: #2d3748;
        }
        
        .budget-highlight {
            background: linear-gradient(135deg, #f6e05e 0%, #fbbf24 100%);
            border: none;
            color: #1a202c;
            padding: 20px;
            border-radius: 10px;
            margin-top: 15px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(246, 224, 94, 0.3);
        }
        
        .budget-highlight .amount {
            font-size: 36px;
            font-weight: 700;
            display: block;
        }
        
        .budget-note {
            font-size: 14px;
            color: #718096;
            margin-top: 10px;
            font-style: italic;
        }
        
        .info-card {
            background: rgba(255,255,255,0.95);
            border: none;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
        }
        
        .info-card h3 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #2d3748;
        }
        
        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding: 15px;
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
            border-radius: 10px;
            border: 1px solid #e9ecef;
        }
        
        .info-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 22px;
            color: white;
        }
        
        .info-text {
            flex: 1;
            color: #4a5568;
        }
        
        .info-text strong {
            display: block;
            margin-bottom: 5px;
            font-size: 16px;
            color: #2d3748;
        }
        
        .info-text span {
            font-size: 14px;
            opacity: 0.9;
        }
        
        /* Vehicle options styling */
        .vehicle-options {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-top: 5px;
        }
        
        .vehicle-option {
            position: relative;
            cursor: pointer;
        }
        
        .vehicle-option input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        .vehicle-option label {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 10px;
            background: #f7fafc;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .vehicle-option input[type="radio"]:checked + label {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: #667eea;
            color: white;
        }
        
        .vehicle-option label span:first-child {
            font-size: 24px;
            margin-bottom: 5px;
        }
        
        .vehicle-option label span:last-child {
            font-size: 12px;
            font-weight: 600;
        }
        
        @media (max-width: 768px) {
            .calculator-wrapper {
                grid-template-columns: 1fr;
            }
            
            .vehicle-options {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        
        /* Travel Tips Grid */
        .tips-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        
        .tip-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            border: 1px solid #e9ecef;
            transition: transform 0.3s ease;
        }
        
        .tip-card:hover {
            transform: translateY(-5px);
        }
        
        .tip-icon {
            font-size: 30px;
            margin-bottom: 10px;
        }
        
        .tip-card h4 {
            color: #2d3748;
            margin-bottom: 10px;
            font-size: 18px;
        }
        
        .tip-card p {
            color: #718096;
            font-size: 14px;
            line-height: 1.6;
        }

        /* Footer Legal Links */
        .footer-legal {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
            text-align: center;
        }

        .footer-legal a {
            color: #6c757d;
            text-decoration: none;
            margin: 0 10px;
            font-size: 14px;
        }

        .footer-legal a:hover {
            color: #4299e1;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <header class="site-header">
        <div class="container header-inner">
            <div class="brand">
                <div class="logo-circle">
                    <img src="../assets/images/logo.png" alt="Europe Uncovered Logo" class="logo-img" style="width: 35px;height: 35px;border-radius: 999px;object-fit: cover;" loading="lazy">
                </div>
                <div class="brand-text">
                    <div class="brand-title">Europe Uncovered</div>
                    <div class="brand-subtitle">Smart & simple Europe travel guides</div>
                </div>
            </div>

            <!-- Desktop Navigation -->
            <nav class="main-nav">
                <a href="#top-destinations">Top Destinations</a>
                <a href="#budget-calculator">Budget Calculator</a>
                <a href="about.php">About</a>
            </nav>

            <!-- Mobile Hamburger Button -->
            <button class="mobile-menu-btn" id="openMenu" aria-label="Menu">
                ☰
            </button>

            <!-- Mobile Fullscreen Menu -->
            <div class="mobile-menu" id="mobileMenu">
                <button class="close-menu-btn" id="closeMenu" aria-label="Close">✕</button>
                <a href="#top-destinations" class="mobile-link">Top Destinations</a>
                <a href="#budget-calculator" class="mobile-link">Budget Calculator</a>
                <a href="about.php" class="mobile-link">About</a>
            </div>
        </div>
    </header>

    <section class="hero">
        <div class="container hero-inner">
            <div class="hero-text">
                <h1>Explore Europe affordably</h1>
                <p>Find real budgets, best travel periods and must-see spots for each country.</p>
                <div class="hero-actions">
                    <a href="#top-destinations" class="btn primary">Start exploring</a>
                    <a href="top/top3.html" class="btn ghost">Top 3 cities</a>
                </div>
            </div>

            <div class="hero-card">
                <h2>Plan your next European trip</h2>
                
                <div class="hero-field">
                    <label for="searchCountry">Search country</label>
                    <input type="text" id="searchCountry" placeholder="Try Spain, Romania, France...">
                </div>

                <div class="hero-field">
                    <label>Filter by region</label>
                    <div class="region-filters" id="regionFilters">
                        <a href="?region=All" class="chip <?php echo isActive($regionFilter, 'All'); ?>">All Europe</a>
                        <a href="?region=Western Europe" class="chip <?php echo isActive($regionFilter, 'Western Europe'); ?>">Western</a>
                        <a href="?region=Eastern Europe" class="chip <?php echo isActive($regionFilter, 'Eastern Europe'); ?>">Eastern</a>
                        <a href="?region=Southern Europe" class="chip <?php echo isActive($regionFilter, 'Southern Europe'); ?>">Southern</a>
                        <a href="?region=Northern Europe" class="chip <?php echo isActive($regionFilter, 'Northern Europe'); ?>">Northern</a>
                        <a href="?region=Central Europe" class="chip <?php echo isActive($regionFilter, 'Central Europe'); ?>">Central</a>
                    </div>
                </div>

                <p class="hero-note">Data is based on real average daily budgets.</p>
            </div>
        </div>

        <section class="stats-bar">
            <div class="stats-inner">
                <div class="stat-item">
                    <div class="stat-label">Countries in database</div>
                    <div class="stat-value"><?php echo $totalAllCountries; ?></div>
                    <div style="font-size:0.8rem; opacity:0.8;">
                        Showing <?php echo $totalCountriesRegion; ?> in 
                        <?php echo ($regionFilter === 'All') ? 'all regions' : htmlspecialchars($regionFilter); ?>
                    </div>
                </div>
                <div class="stat-item">
                    <div class="stat-label">Cheapest daily budget</div>
                    <div class="stat-value">
                        €<?php echo $globalMinBudget; ?>/day
                    </div>
                    <?php if ($cheapestCountryName): ?>
                        <div style="font-size:0.8rem; opacity:0.8;">in <?php echo htmlspecialchars($cheapestCountryName); ?></div>
                    <?php endif; ?>
                </div>
                <div class="stat-item">
                    <div class="stat-label">Highest average daily budget</div>
                    <div class="stat-value">
                        €<?php echo $globalMaxBudget; ?>/day
                    </div>
                    <?php if ($priciestCountryName): ?>
                        <div style="font-size:0.8rem; opacity:0.8;">in <?php echo htmlspecialchars($priciestCountryName); ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </section>

    <main class="container">
        <section id="top-destinations" class="section">
            <h2>
                <?php echo ($regionFilter === 'All') ? 'All European Countries' : htmlspecialchars($regionFilter); ?>
            </h2>

            <p class="section-subtitle">Click a card to see more details.</p>

            <!-- Filter by budget -->
            <div class="filter-bar">
                <div class="filter-group">
                    <label for="budgetRange">Filter by daily budget</label>
                    <input type="range"
                           id="budgetRange"
                           min="<?php echo $globalMinBudget; ?>"
                           max="<?php echo $globalMaxBudget; ?>"
                           value="<?php echo $globalMaxBudget; ?>">
                    <span id="budgetValue">Up to €<?php echo $globalMaxBudget; ?>/day</span>
                </div>
                <button class="btn-reset-filters" id="clearFilters">
                    ✨ Clear filters
                </button>
            </div>

            <?php if (count($countries) > 0): ?>
                <div id="countriesGrid" class="cards-grid">
                    <?php foreach ($countries as $country): ?>
                        <?php
                            $slug = htmlspecialchars($country['slug']);
                            $name = htmlspecialchars($country['name']);
                            $region = htmlspecialchars($country['region']);
                            $shortDesc = htmlspecialchars($country['short_description']);
                            $currency = htmlspecialchars($country['currency'] ?: 'EUR');
                            $bestPeriod = htmlspecialchars($country['best_period'] ?? '');
                            $imgUrl = $country['image_url'] ? htmlspecialchars($country['image_url']) : '';
                        ?>
                        <a href="/country/<?php echo $slug; ?>" 
                           class="country-card"
                           data-name="<?php echo strtolower($name); ?>"
                           data-region="<?php echo $region; ?>"
                           data-min="<?php echo (int)($country['avg_budget_min'] ?? 0); ?>"
                           data-max="<?php echo (int)($country['avg_budget_max'] ?? 0); ?>">

                            <?php if (!empty($imgUrl)): ?>
                                <div class="country-thumb" style="background-image:url('<?php echo $imgUrl; ?>');" loading="lazy" alt="<?php echo $name; ?> travel guide image"></div>
                            <?php else: ?>
                                <div class="country-thumb placeholder" alt="<?php echo $name; ?> placeholder image"></div>
                            <?php endif; ?>

                            <div class="country-content">
                                <h3><?php echo $name; ?></h3>
                                <p class="country-region"><?php echo $region; ?></p>
                                <p class="country-description">
                                    <?php echo $shortDesc; ?>
                                </p>
                                <div class="country-meta">
                                    <?php if ($country['avg_budget_min'] && $country['avg_budget_max']): ?>
                                        <span class="badge">
                                            <?php echo (int)$country['avg_budget_min']; ?>–<?php echo (int)$country['avg_budget_max']; ?>
                                            <?php echo $currency; ?>/day
                                        </span>
                                    <?php endif; ?>

                                    <?php if (!empty($bestPeriod)): ?>
                                        <span class="badge outline">
                                            Best: <?php echo $bestPeriod; ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div style="text-align:center; padding: 50px;">
                    <h3>No countries found for this region.</h3>
                    <a href="?region=All" class="btn primary">View All</a>
                </div>
            <?php endif; ?>

        </section>

        <?php if ($totalPages > 1): ?>
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a class="page-btn" href="<?php echo getPageLink($page - 1); ?>">« Prev</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a class="page-btn <?php echo $i == $page ? 'active' : ''; ?>" href="<?php echo getPageLink($i); ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                    <a class="page-btn" href="<?php echo getPageLink($page + 1); ?>">Next »</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <section class="section" style="margin-top:70px;">
            <h2 style="text-align:center;">Popular Cities in Europe</h2>
            <p style="text-align:center;color:#6b7280;margin-bottom:25px;">
                Discover a few beautiful cities chosen randomly.
            </p>

            <div class="city-grid">
                <?php foreach ($randomCities as $city): ?>
                    <a href="country/<?php echo $city['slug']; ?>" class="city-card">
                        <div class="city-img" style="background-image:url('<?php echo htmlspecialchars($city['img']); ?>');" loading="lazy" alt="<?php echo htmlspecialchars($city['city']); ?> city view"></div>
                        <div class="city-info">
                            <h3><?php echo htmlspecialchars($city['city']); ?></h3>
                            <p><?php echo htmlspecialchars($city['country']); ?></p>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>
        
        <?php if ($page == 1): ?>
        <section class="section articles-section">
            <h2 class="articles-title">Travel Guides & Articles</h2>
            <p class="articles-subtitle">
                In-depth guides to help you plan smarter, more affordable trips across Europe.
            </p>

            <div class="articles-grid">
                <a href="https://europeuncovered.com/europe-on-a-budget-2025.php" class="article-card">
                    <div class="article-tag">Budget guide</div>
                    <h3 class="article-heading">Europe on a Budget 2026 – Complete Daily Costs Guide</h3>
                    <p class="article-excerpt">
                        Learn how much you really spend per day in different European countries, from
                        the cheapest destinations to the most expensive, plus practical tips to cut costs.
                    </p>
                    <span class="article-readmore">Read guide →</span>
                </a>

                <a href="cheapest-countries-europe.php" class="article-card">
                    <div class="article-tag">Trip planning</div>
                    <h3 class="article-heading">10 Cheapest Countries in Europe for 2025</h3>
                    <p class="article-excerpt">
                        A detailed look at the most affordable countries in Europe with real
                        daily budgets, example itineraries and who each destination is best for.
                    </p>
                    <span class="article-readmore">Read guide →</span>
                </a>

                <a href="7-day-europe-itinerary.php" class="article-card">
                    <div class="article-tag">Itinerary</div>
                    <h3 class="article-heading">7-Day Europe Itinerary – Simple Plan for First Timers</h3>
                    <p class="article-excerpt">
                        A step-by-step route, day-by-day breakdown, transport tips and budget ranges
                        to help you plan a realistic one-week Europe trip.
                    </p>
                    <span class="article-readmore">Read guide →</span>
                </a>
            </div>
        </section>
        <?php endif; ?>
        
        <section id="budget-calculator" class="budget-calculator-section">
            <div class="calculator-wrapper">
                <!-- Calculator Card -->
                <div class="calculator-card">
                    <h2 class="calculator-title">💰 Enhanced Trip Budget Calculator</h2>
                    <p class="calculator-subtitle">Customize your accommodation and vehicle for accurate estimates</p>
                    
                    <div class="input-group">
                        <label for="calcCountry">🌍 Select Destination Country</label>
                        <select id="calcCountry" class="country-select">
                            <option value="">Choose a country...</option>
                            <?php foreach ($allCountries as $country): 
                                if (!empty($country['avg_budget_min']) && !empty($country['avg_budget_max'])): 
                            ?>
                                <option value="<?php echo $country['avg_budget_min']; ?>|<?php echo $country['avg_budget_max']; ?>|<?php echo htmlspecialchars($country['currency'] ?: 'EUR'); ?>|<?php echo htmlspecialchars($country['name']); ?>">
                                    <?php echo htmlspecialchars($country['name']); ?> (€<?php echo $country['avg_budget_min']; ?>-<?php echo $country['avg_budget_max']; ?>/day)
                                </option>
                            <?php endif; endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="input-group">
                        <label for="calcDays">📅 Trip Duration (days)</label>
                        <input type="number" id="calcDays" min="1" max="365" value="7" placeholder="Number of days">
                    </div>
                    
                    <div class="input-group">
                        <label for="calcPersons">👥 Number of Travelers</label>
                        <input type="number" id="calcPersons" min="1" max="20" value="2" placeholder="How many people?">
                    </div>
                    
                    <div class="input-group">
                        <label for="accommodationStyle">🏨 Accommodation Style</label>
                        <select id="accommodationStyle" class="input">
                            <option value="budget">Budget / Hostel (30% cheaper)</option>
                            <option value="standard" selected>Standard / Mid-range (Base budget)</option>
                            <option value="luxury">Luxury / Boutique (50% more expensive)</option>
                        </select>
                    </div>
                    
                    <div class="input-group">
                        <label for="vehicleType">🚗 Vehicle Rental</label>
                        <select id="vehicleType" class="input">
                            <option value="none" selected>🚫 No vehicle / Public transport</option>
                            <option value="sedan">🚗 Economy / Sedan (€45/day)</option>
                            <option value="suv">🚙 SUV / Crossover (€75/day)</option>
                            <option value="minivan">🚐 Minivan / Family (€95/day)</option>
                        </select>
                    </div>
                    
                    <div class="input-group">
                        <label for="extraBudget">✨ Extra Daily Budget (activities, shopping)</label>
                        <input type="number" id="extraBudget" min="0" max="500" value="0" placeholder="Extra € per person/day">
                    </div>
                    
                    <button class="calculate-btn" onclick="calculateEnhancedBudget()">
                        Calculate Detailed Budget
                    </button>
                    
                    <!-- Results Container -->
                    <div id="budgetResult" class="budget-result">
                        <h3 style="margin-bottom: 15px; color: #2d3748;">Your Detailed Trip Estimate</h3>
                        
                        <div class="budget-item">
                            <span class="budget-label">Destination:</span>
                            <span class="budget-value" id="resultCountry">-</span>
                        </div>
                        
                        <div class="budget-item">
                            <span class="budget-label">Trip Details:</span>
                            <span class="budget-value" id="resultDuration">-</span>
                        </div>
                        
                        <div class="budget-item">
                            <span class="budget-label">Accommodation:</span>
                            <span class="budget-value" id="resultAccommodation">-</span>
                        </div>
                        
                        <div class="budget-item">
                            <span class="budget-label">Vehicle:</span>
                            <span class="budget-value" id="resultVehicle">-</span>
                        </div>
                        
                        <div class="budget-item">
                            <span class="budget-label">Daily Budget (per person):</span>
                            <span class="budget-value" id="resultDaily">-</span>
                        </div>
                        
                        <div class="budget-item">
                            <span class="budget-label">Accommodation + Food:</span>
                            <span class="budget-value" id="resultBaseTotal">-</span>
                        </div>
                        
                        <div class="budget-item">
                            <span class="budget-label">Vehicle Cost:</span>
                            <span class="budget-value" id="resultVehicleCost">-</span>
                        </div>
                        
                        <div class="budget-highlight">
                            <div style="font-size: 16px; margin-bottom: 5px;">Total Trip Cost</div>
                            <span class="amount" id="resultTotal">€0</span>
                            <div style="font-size: 14px; margin-top: 5px;" id="resultPerDay"></div>
                        </div>
                        
                        <div class="budget-note" id="budgetNote">
                            💡 Tip: Book vehicle early for best rates
                        </div>
                    </div>
                </div>
                
                <!-- Info Card with Country Details -->
                <div class="info-card">
                    <h3>🇪🇺 Europe Travel Insights</h3>
                    
                    <div class="info-item">
                        <div class="info-icon">💰</div>
                        <div class="info-text">
                            <strong>Cheapest Destination</strong>
                            <span><?php echo $cheapestCountryName ?: 'Eastern Europe'; ?> from €<?php echo $globalMinBudget; ?>/day</span>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-icon">✨</div>
                        <div class="info-text">
                            <strong>Premium Choice</strong>
                            <span><?php echo $priciestCountryName ?: 'Switzerland'; ?> up to €<?php echo $globalMaxBudget; ?>/day</span>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-icon">📊</div>
                        <div class="info-text">
                            <strong>Average Trip Cost</strong>
                            <span>€<?php echo round(($globalMinBudget + $globalMaxBudget) / 2); ?>/day for 2 people</span>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-icon">🏆</div>
                        <div class="info-text">
                            <strong>Best Value</strong>
                            <span>Portugal, Greece, Croatia (€50-80/day)</span>
                        </div>
                    </div>
                    
                    <!-- Vehicle Comparison -->
                    <div style="margin-top: 30px;">
                        <h4 style="margin-bottom: 15px;">🚗 Vehicle Cost Comparison</h4>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                            <div style="background: #f7fafc; padding: 10px; border-radius: 8px;">
                                <strong>Sedan</strong><br>
                                <span style="font-size: 13px;">€45/day + fuel</span>
                            </div>
                            <div style="background: #f7fafc; padding: 10px; border-radius: 8px;">
                                <strong>SUV</strong><br>
                                <span style="font-size: 13px;">€75/day + fuel</span>
                            </div>
                            <div style="background: #f7fafc; padding: 10px; border-radius: 8px;">
                                <strong>Minivan</strong><br>
                                <span style="font-size: 13px;">€95/day + fuel</span>
                            </div>
                            <div style="background: #f7fafc; padding: 10px; border-radius: 8px;">
                                <strong>Public Transport</strong><br>
                                <span style="font-size: 13px;">Included in daily budget</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Quick Tips -->
                    <div style="margin-top: 30px;">
                        <h4 style="margin-bottom: 15px;">⚡ Money-Saving Tips</h4>
                        <div style="font-size: 14px; line-height: 1.8;">
                            • Travel in shoulder season (Apr-Jun, Sep-Oct)<br>
                            • Book accommodation 2-3 months ahead<br>
                            • Use public transport instead of taxis<br>
                            • Eat where locals eat, avoid tourist traps<br>
                            • Get a travel card with no fees (Revolut/Wise)<br>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Travel Tips Grid Section -->
        <section class="section" style="margin-top: 60px;">
            <h2 style="text-align:center; margin-bottom: 40px;">✈️ Smart Travel Tips for Europe</h2>
            
            <div class="tips-grid">
                <div class="tip-card">
                    <div class="tip-icon">🏠</div>
                    <h4>Accommodation Hacks</h4>
                    <p>Book apartments with kitchens to save on meals. Stay slightly outside city centers for better rates.</p>
                </div>
                
                <div class="tip-card">
                    <div class="tip-icon">🚂</div>
                    <h4>Transport Savings</h4>
                    <p>Use night trains to save on accommodation. Get city cards for free public transport and museum entries.</p>
                </div>
                
                <div class="tip-card">
                    <div class="tip-icon">🍽️</div>
                    <h4>Food on Budget</h4>
                    <p>Lunch menus are cheaper than dinner. Visit local markets and bakeries for fresh, affordable food.</p>
                </div>
                
                <div class="tip-card">
                    <div class="tip-icon">📱</div>
                    <h4>Money Apps</h4>
                    <p>Use Splitwise for group expenses, Revolut for no-fee exchanges, and TooGoodToGo for cheap restaurant leftovers.</p>
                </div>
                
                <div class="tip-card">
                    <div class="tip-icon">🎫</div>
                    <h4>Free Attractions</h4>
                    <p>Many museums have free entry days. Walking tours are often "pay what you want" and excellent value.</p>
                </div>
                
                <div class="tip-card">
                    <div class="tip-icon">💳</div>
                    <h4>Hidden Costs</h4>
                    <p>Watch for city taxes (€1-5/night), ATM fees, and tourist pricing. Always have some local cash.</p>
                </div>
            </div>
        </section>
        
        <section class="content-section" style="margin-top: 60px; padding: 40px 0;">
            <div class="container">
                <h2 style="text-align:center;margin-bottom:30px;">Europe Travel Planning Guide 2026</h2>
                
                <div style="max-width:800px;margin:0 auto;line-height:1.7;">
                    <h3>Why Use Our Europe Travel Budget Calculator?</h3>
                    <p>Planning a trip to Europe requires careful budgeting, especially with varying costs across different regions. Our travel budget calculator uses real-time data from thousands of travelers to give you accurate daily cost estimates for <?php echo $totalAllCountries; ?> European countries.</p>
                    
                    <h3>Understanding European Regions</h3>
                    <p>Europe is typically divided into <?php 
                        $regions = array_unique(array_column($allCountries, 'region'));
                        echo count($regions); 
                    ?> major regions, each with distinct characteristics:</p>
                    <ul>
                        <li><strong>Western Europe</strong>: Countries like France, Germany, and Switzerland offer rich history but higher costs</li>
                        <li><strong>Eastern Europe</strong>: Destinations like Romania, Bulgaria, and Poland provide excellent value for money</li>
                        <li><strong>Southern Europe</strong>: Spain, Italy, and Greece combine Mediterranean charm with moderate prices</li>
                        <li><strong>Northern Europe</strong>: Scandinavian countries feature stunning landscapes but premium prices</li>
                        <li><strong>Central Europe</strong>: Austria, Czech Republic, and Hungary balance culture and affordability</li>
                    </ul>
                    
                    <h3>Travel Budget Categories Explained</h3>
                    <p>Our daily budget estimates include four main categories:</p>
                    <ol>
                        <li><strong>Accommodation</strong>: Hostels, budget hotels, or Airbnb options</li>
                        <li><strong>Food & Dining</strong>: Local restaurants, street food, and grocery shopping</li>
                        <li><strong>Transportation</strong>: Public transport, intercity trains, and local taxis</li>
                        <li><strong>Activities & Attractions</strong>: Museum entries, tours, and entertainment</li>
                    </ol>
                    
                    <h3>Money-Saving Tips for European Travel</h3>
                    <p>Based on our 2025 data analysis, here are proven ways to reduce your travel costs:</p>
                    <ul>
                        <li>Visit during shoulder seasons (April-May, September-October)</li>
                        <li>Use regional trains instead of high-speed rail</li>
                        <li>Book accommodations 2-3 months in advance</li>
                        <li>Eat at local markets and avoid tourist restaurants</li>
                        <li>Consider multi-country rail passes for extensive travel</li>
                        <li>Use travel credit cards with no foreign transaction fees</li>
                    </ul>
                    
                    <h3>Best Value Destinations for 2025</h3>
                    <p>According to our latest data, these countries offer the best combination of attractions, culture, and affordability:</p>
                    <ul>
                        <li><strong>Portugal</strong>: Beautiful beaches, rich history, and reasonable prices</li>
                        <li><strong>Romania</strong>: Medieval castles, stunning nature, and low daily costs</li>
                        <li><strong>Poland</strong>: Vibrant cities, WWII history, and excellent food at great prices</li>
                        <li><strong>Greece</strong>: Ancient ruins, island hopping, and Mediterranean cuisine</li>
                        <li><strong>Czech Republic</strong>: Architectural beauty, beer culture, and central location</li>
                    </ul>
                    
                    <p style="margin-top:30px;padding:20px;background:#f8fafc;border-radius:8px;border-left:4px solid #4299e1; color: black">
                        <strong>Pro Tip:</strong> Always add a 15-20% buffer to your calculated budget for unexpected expenses, currency fluctuations, or special experiences you might want to enjoy.
                    </p>
                </div>
            </div>
        </section>

        <!-- Enhanced Budget Calculator Section -->
        

        <!-- Send all countries to JS -->
        <script>
        window.ALL_COUNTRIES = <?php 
            echo json_encode($allCountries, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
        ?>;
        </script>

        <script src="../assets/app.js"></script>

        <script>
        // ======================
        // ENHANCED BUDGET CALCULATOR FUNCTION
        // ======================
        function calculateEnhancedBudget() {
            const countrySelect = document.getElementById('calcCountry');
            const days = parseInt(document.getElementById('calcDays').value);
            const persons = parseInt(document.getElementById('calcPersons').value);
            const accommodationStyle = document.getElementById('accommodationStyle').value;
            const vehicleType = document.getElementById('vehicleType').value;
            const extraBudget = parseInt(document.getElementById('extraBudget').value) || 0;
            
            // Get result elements
            const resultDiv = document.getElementById('budgetResult');
            const resultCountry = document.getElementById('resultCountry');
            const resultDuration = document.getElementById('resultDuration');
            const resultAccommodation = document.getElementById('resultAccommodation');
            const resultVehicle = document.getElementById('resultVehicle');
            const resultDaily = document.getElementById('resultDaily');
            const resultBaseTotal = document.getElementById('resultBaseTotal');
            const resultVehicleCost = document.getElementById('resultVehicleCost');
            const resultTotal = document.getElementById('resultTotal');
            const resultPerDay = document.getElementById('resultPerDay');
            const budgetNote = document.getElementById('budgetNote');
            
            // Validate inputs
            if (!countrySelect.value) {
                alert('Please select a destination country');
                return;
            }
            
            if (!days || days < 1) {
                alert('Please enter a valid number of days');
                return;
            }
            
            if (!persons || persons < 1) {
                alert('Please enter a valid number of travelers');
                return;
            }
            
            // Parse country data
            const [minBudget, maxBudget, currency, countryName] = countrySelect.value.split('|');
            const minPerDay = parseInt(minBudget);
            const maxPerDay = parseInt(maxBudget);
            
            // Accommodation multipliers
            const accommodationMultipliers = {
                'budget': 0.7,      // 30% cheaper
                'standard': 1.0,     // base budget
                'luxury': 1.5        // 50% more expensive
            };
            
            // Vehicle daily costs
            const vehicleCosts = {
                'none': 0,
                'sedan': 45,
                'suv': 75,
                'minivan': 95
            };
            
            // Get multiplier and labels
            const multiplier = accommodationMultipliers[accommodationStyle] || 1.0;
            
            const accommodationLabels = {
                'budget': 'Budget / Hostel (30% cheaper)',
                'standard': 'Standard / Mid-range',
                'luxury': 'Luxury / Boutique (50% more)'
            };
            
            const vehicleLabels = {
                'none': 'No vehicle / Public transport',
                'sedan': 'Economy / Sedan (€45/day)',
                'suv': 'SUV / Crossover (€75/day)',
                'minivan': 'Minivan (€95/day)'
            };
            
            // Calculate adjusted daily budgets (with accommodation multiplier)
            const adjustedMinPerDay = Math.round(minPerDay * multiplier) + extraBudget;
            const adjustedMaxPerDay = Math.round(maxPerDay * multiplier) + extraBudget;
            
            // Calculate base totals (accommodation + food + activities)
            const baseTotalMin = adjustedMinPerDay * days * persons;
            const baseTotalMax = adjustedMaxPerDay * days * persons;
            
            // Calculate vehicle cost
            const vehicleDailyCost = vehicleCosts[vehicleType] || 0;
            const totalVehicleCost = vehicleDailyCost * days;
            
            // Calculate final totals
            const finalTotalMin = baseTotalMin + totalVehicleCost;
            const finalTotalMax = baseTotalMax + totalVehicleCost;
            
            // Calculate averages
            const avgPerDayMin = Math.round(finalTotalMin / days);
            const avgPerDayMax = Math.round(finalTotalMax / days);
            const avgTotal = Math.round((finalTotalMin + finalTotalMax) / 2);
            
            // Format currency
            const formatMoney = (amount) => {
                return '€' + amount.toLocaleString();
            };
            
            // Update result elements
            resultCountry.textContent = `${countryName} (${currency})`;
            resultDuration.textContent = `${days} days • ${persons} ${persons === 1 ? 'person' : 'people'}`;
            resultAccommodation.textContent = accommodationLabels[accommodationStyle];
            resultVehicle.textContent = vehicleLabels[vehicleType];
            resultDaily.textContent = `${formatMoney(adjustedMinPerDay)} - ${formatMoney(adjustedMaxPerDay)}`;
            resultBaseTotal.textContent = `${formatMoney(baseTotalMin)} - ${formatMoney(baseTotalMax)}`;
            resultVehicleCost.textContent = vehicleType === 'none' ? '€0' : formatMoney(totalVehicleCost);
            resultTotal.textContent = formatMoney(avgTotal);
            resultPerDay.textContent = `≈ ${formatMoney(avgPerDayMin)}-${formatMoney(avgPerDayMax)} / day total`;
            
            // Add contextual note
            if (vehicleType !== 'none') {
                budgetNote.innerHTML = '💡 Tip: Consider booking your vehicle online for better rates and free cancellation.';
            } else if (adjustedMinPerDay < 50) {
                budgetNote.innerHTML = '💡 Great choice! This destination is very budget-friendly. Check local markets for meals.';
            } else if (adjustedMaxPerDay > 150) {
                budgetNote.innerHTML = '💡 Premium destination! Look for city cards that include attractions and transport.';
            } else {
                budgetNote.innerHTML = '💡 Balanced budget! Book accommodation early for best rates.';
            }
            
            // Show result
            resultDiv.classList.add('show');
        }

        // ======================
        // NAME MATCH LOGIC
        // ======================
        function isNameMatch(name, term) {
            if (!term) return true;
            name = (name || "").toLowerCase();
            term = term.toLowerCase();
            const words = name.split(/[\s,-]+/);
            return words.some(w => w.startsWith(term));
        }

        // ======================
        // BUILD CARD HTML FROM JS
        // ======================
        function createCountryCardHTML(c) {
            const slug = c.slug || '';
            const name = c.name || '';
            const region = c.region || '';
            const shortDesc = c.short_description || '';
            const currency = (c.currency && c.currency.trim() !== '') ? c.currency : 'EUR';
            const bestPeriod = c.best_period || '';
            const imgUrl = c.image_url || '';
            const min = c.avg_budget_min ? parseInt(c.avg_budget_min, 10) : 0;
            const max = c.avg_budget_max ? parseInt(c.avg_budget_max, 10) : 0;

            return `
                <a href="/country/${slug}" 
                   class="country-card"
                   data-name="${name.toLowerCase()}"
                   data-region="${region}"
                   data-min="${min}"
                   data-max="${max}">
                    ${imgUrl
                        ? `<div class="country-thumb" style="background-image:url('${imgUrl}');" loading="lazy" alt="${name} travel guide image"></div>`
                        : `<div class="country-thumb placeholder" alt="${name} placeholder image"></div>`
                    }
                    <div class="country-content">
                        <h3>${name}</h3>
                        <p class="country-region">${region}</p>
                        <p class="country-description">
                            ${shortDesc}
                        </p>
                        <div class="country-meta">
                            ${ (min && max) 
                                ? `<span class="badge">${min}–${max} ${currency}/day</span>` 
                                : '' 
                            }
                            ${ bestPeriod
                                ? `<span class="badge outline">Best: ${bestPeriod}</span>`
                                : ''
                            }
                        </div>
                    </div>
                </a>
            `;
        }

        // ======================
        // FILTER FUNCTION
        // ======================
        function applyFilters() {
            const searchInput = document.getElementById('searchCountry');
            const budgetRange = document.getElementById('budgetRange');
            const countriesGrid = document.getElementById('countriesGrid');
            const noResults = document.getElementById('noResultsMsg');
            const pagination = document.querySelector('.pagination');

            if (!countriesGrid || !window.ALL_COUNTRIES) return;

            const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';
            const maxBudget = budgetRange ? parseInt(budgetRange.value, 10) : null;
            const sliderMax = budgetRange ? parseInt(budgetRange.max, 10) : null;

            const noSearch = searchTerm === '';
            const sliderAtMax = (maxBudget === sliderMax || !budgetRange);

            if (noSearch && sliderAtMax) {
                if (pagination) pagination.style.display = '';
                if (noResults) noResults.style.display = 'none';
                if (window.ORIGINAL_GRID_HTML && countriesGrid.innerHTML !== window.ORIGINAL_GRID_HTML) {
                    countriesGrid.innerHTML = window.ORIGINAL_GRID_HTML;
                }
                return;
            }

            if (pagination) pagination.style.display = 'none';

            let visibleCount = 0;
            const results = [];

            window.ALL_COUNTRIES.forEach(c => {
                const countryName = (c.name || '').toLowerCase();
                const matchesSearch = isNameMatch(countryName, searchTerm);

                let matchesBudget = true;
                if (maxBudget !== null && !isNaN(maxBudget) && maxBudget > 0) {
                    const minBudget = c.avg_budget_min ? parseInt(c.avg_budget_min, 10) : 0;
                    const maxBudgetCountry = c.avg_budget_max ? parseInt(c.avg_budget_max, 10) : 0;

                    if (minBudget > 0 || maxBudgetCountry > 0) {
                        const effectiveBudget = (minBudget > 0 ? minBudget : maxBudgetCountry);
                        matchesBudget = effectiveBudget <= maxBudget;
                    }
                }

                if (matchesSearch && matchesBudget) {
                    results.push(c);
                }
            });

            countriesGrid.innerHTML = '';

            results.forEach(c => {
                countriesGrid.insertAdjacentHTML('beforeend', createCountryCardHTML(c));
                visibleCount++;
            });

            if (noResults) {
                noResults.style.display = visibleCount === 0 ? 'block' : 'none';
            }
        }

        // ======================
        // INIT SEARCH + BUDGET UI
        // ======================
        function initSearchAndBudgetFilter() {
            const searchInput = document.getElementById('searchCountry');
            const budgetRange = document.getElementById('budgetRange');
            const budgetValue = document.getElementById('budgetValue');
            const clearBtn = document.getElementById('clearFilters');
            const countriesGrid = document.getElementById('countriesGrid');

            if (countriesGrid) {
                window.ORIGINAL_GRID_HTML = countriesGrid.innerHTML;
            }

            if (countriesGrid && !document.getElementById('noResultsMsg')) {
                const noResults = document.createElement('div');
                noResults.id = 'noResultsMsg';
                noResults.style.textAlign = 'center';
                noResults.style.padding = '40px 0';
                noResults.style.display = 'none';
                noResults.innerHTML = "<h3>No countries match your search.</h3>";
                countriesGrid.parentNode.insertBefore(noResults, countriesGrid.nextSibling);
            }

            if (searchInput) {
                searchInput.addEventListener('input', function () {
                    applyFilters();
                });
            }

            if (budgetRange && budgetValue) {
                const updateBudgetLabel = () => {
                    const val = parseInt(budgetRange.value, 10);
                    budgetValue.textContent = 'Up to €' + val + '/day';
                };
                updateBudgetLabel();

                budgetRange.addEventListener('input', function () {
                    updateBudgetLabel();
                    applyFilters();
                });
            }

            if (clearBtn) {
                clearBtn.addEventListener('click', function () {
                    if (searchInput) searchInput.value = '';
                    if (budgetRange) {
                        budgetRange.value = budgetRange.max;
                        if (budgetValue) {
                            budgetValue.textContent = 'Up to €' + budgetRange.max + '/day';
                        }
                    }
                    applyFilters();
                });
            }

            applyFilters();
        }

        // ======================
        // MOBILE MENU
        // ======================
        function initMobileMenu() {
            const openBtn = document.getElementById('openMenu');
            const closeBtn = document.getElementById('closeMenu');
            const mobileMenu = document.getElementById('mobileMenu');

            if (!openBtn || !closeBtn || !mobileMenu) return;

            function lockScroll() {
                document.body.style.overflow = 'hidden';
                document.documentElement.style.overflow = 'hidden';
            }

            function unlockScroll() {
                document.body.style.overflow = '';
                document.documentElement.style.overflow = '';
            }

            function openMenu() {
                mobileMenu.classList.add('active');
                lockScroll();
            }

            function closeMenuFn() {
                mobileMenu.classList.remove('active');
                unlockScroll();
            }

            openBtn.addEventListener('click', openMenu);
            closeBtn.addEventListener('click', closeMenuFn);

            mobileMenu.querySelectorAll('.mobile-link').forEach(link => {
                link.addEventListener('click', closeMenuFn);
            });
        }

        // ======================
        // INITIALIZE PRESET VALUES
        // ======================
        function initializeCalculator() {
            const daysInput = document.getElementById('calcDays');
            const personsInput = document.getElementById('calcPersons');
            const extraInput = document.getElementById('extraBudget');
            
            if (daysInput) daysInput.value = 7;
            if (personsInput) personsInput.value = 2;
            if (extraInput) extraInput.value = 0;
            
            const calcBtn = document.querySelector('.calculate-btn');
            if (calcBtn) {
                calcBtn.addEventListener('click', calculateEnhancedBudget);
            }
            
            // Add enter key support
            const inputs = ['calcDays', 'calcPersons', 'extraBudget'];
            inputs.forEach(id => {
                const input = document.getElementById(id);
                if (input) {
                    input.addEventListener('keypress', function(e) {
                        if (e.key === 'Enter') {
                            calculateEnhancedBudget();
                        }
                    });
                }
            });
            
            const resultDiv = document.getElementById('budgetResult');
            if (resultDiv) {
                resultDiv.classList.remove('show');
            }
        }

        // MAIN INIT
        document.addEventListener('DOMContentLoaded', function () {
            initSearchAndBudgetFilter();
            if (typeof initScrollTop === 'function') {
                initScrollTop();
            }
            initMobileMenu();
            initializeCalculator();
        });
        </script>
    </main>
        
    <footer class="site-footer" style="width: 100%">
        <div class="container footer-inner">
            <div class="footer-main">
                <span>© <?php echo date('Y'); ?> Europe Uncovered</span>
                <span class="footer-dot">•</span>
                <span>
                    Created by 
                    <a href="https://webb2go.com" target="_blank" rel="nofollow">
                        webb2go.com
                    </a>
                </span>
                <span class="footer-dot">•</span>
                <a href="https://instagram.com/web.dev.md" target="_blank" rel="nofollow">
                    @web.dev.md
                </a>
            </div>
            
            <!-- LEGAL LINKS - ESENȚIAL pentru AdSense -->
            <div class="footer-legal">
                <a href="privacy-policy.php">Privacy Policy</a>
                <a href="terms-of-service.php">Terms of Service</a>
                <a href="cookie-policy.php">Cookie Policy</a>
                <a href="about.php">About Us</a>
                <a href="contact.php">Contact</a>
            </div>
        </div>
    </footer>
</body>
</html>
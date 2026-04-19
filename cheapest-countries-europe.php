<?php
require_once 'db/config.php';

// Get cheapest countries
$cheapestQuery = $mysqli->query("
    SELECT name, slug, region, avg_budget_min, avg_budget_max, currency, image_url, short_description, best_period
    FROM countries 
    WHERE avg_budget_min IS NOT NULL 
    ORDER BY avg_budget_min ASC 
    LIMIT 10
");

$cheapestCountries = [];
if ($cheapestQuery) {
    while ($row = $cheapestQuery->fetch_assoc()) {
        $cheapestCountries[] = $row;
    }
}

$pageTitle = "10 Cheapest Countries in Europe for 2025 | Budget Travel Guide";
$metaDesc = "Discover the most affordable European countries for 2025. Complete guide with daily budgets, sample itineraries, and money-saving tips for each destination.";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title><?php echo $pageTitle; ?></title>
    <meta name="description" content="<?php echo $metaDesc; ?>">
    
    <link rel="canonical" href="https://europeuncovered.com/guides/cheapest-countries-europe.php">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    
    <!-- Base CSS -->
    <link rel="stylesheet" href="/assets/base.css">
    <link rel="stylesheet" href="/assets/header.css">
    <link rel="stylesheet" href="/assets/footer.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            color: #1e293b;
            line-height: 1.5;
        }
        
        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Hero Section */
        .cheapest-hero {
            background: linear-gradient(135deg, #065f46 0%, #059669 100%);
            color: white;
            padding: 60px 0;
            position: relative;
            overflow: hidden;
        }
        
        .cheapest-hero::before {
            content: "💰 💶 💷";
            position: absolute;
            font-size: 180px;
            opacity: 0.1;
            right: -30px;
            bottom: -50px;
            transform: rotate(-10deg);
            white-space: nowrap;
        }
        
        .cheapest-hero::after {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background: radial-gradient(circle at 70% 50%, rgba(255,255,255,0.1) 0%, transparent 50%);
            pointer-events: none;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
        }
        
        .hero-badge {
            display: inline-block;
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            padding: 8px 16px;
            border-radius: 100px;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 20px;
            border: 1px solid rgba(255,255,255,0.2);
        }
        
        .cheapest-hero h1 {
            font-size: 40px;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 20px;
            letter-spacing: -0.02em;
        }
        
        .cheapest-hero p {
            font-size: 18px;
            opacity: 0.95;
            max-width: 600px;
        }
        
        .hero-stats-mini {
            display: flex;
            gap: 30px;
            margin-top: 30px;
        }
        
        .hero-stat-mini {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .hero-stat-icon {
            width: 48px;
            height: 48px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        
        /* Main Content */
        .main-content {
            padding: 40px 0;
        }
        
        /* Introduction Section */
        .intro-section {
            background: white;
            border-radius: 24px;
            padding: 32px;
            margin-bottom: 40px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            border: 1px solid #e2e8f0;
        }
        
        .intro-section h2 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 16px;
            color: #0f172a;
        }
        
        .intro-section p {
            color: #475569;
            font-size: 16px;
            line-height: 1.7;
            margin-bottom: 24px;
        }
        
        .budget-highlight {
            background: #f0fdf4;
            border-left: 4px solid #059669;
            padding: 20px;
            border-radius: 12px;
            font-size: 18px;
            font-weight: 600;
            color: #065f46;
        }
        
        /* Country Cards */
        .country-card {
            background: white;
            border-radius: 24px;
            overflow: hidden;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .country-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        
        .country-grid {
            display: grid;
            grid-template-columns: 320px 1fr;
        }
        
        .country-image {
            height: 100%;
            min-height: 300px;
            background-size: cover;
            background-position: center;
            position: relative;
        }
        
        .rank-badge {
            position: absolute;
            top: 20px;
            left: 20px;
            background: #059669;
            color: white;
            padding: 8px 16px;
            border-radius: 100px;
            font-weight: 700;
            font-size: 14px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            z-index: 2;
        }
        
        .country-content {
            padding: 32px;
        }
        
        .country-header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }
        
        .country-header h2 {
            font-size: 28px;
            font-weight: 700;
            color: #0f172a;
        }
        
        .region-tag {
            background: #f1f5f9;
            padding: 6px 14px;
            border-radius: 100px;
            font-size: 13px;
            font-weight: 500;
            color: #475569;
        }
        
        .country-description {
            color: #475569;
            font-size: 15px;
            line-height: 1.7;
            margin-bottom: 24px;
        }
        
        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin: 24px 0;
        }
        
        .stat-card {
            background: #f8fafc;
            padding: 16px;
            border-radius: 16px;
            text-align: center;
            border: 1px solid #e2e8f0;
        }
        
        .stat-label {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 8px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: #0f172a;
        }
        
        .stat-value small {
            font-size: 14px;
            font-weight: 400;
            color: #64748b;
        }
        
        .stat-note {
            font-size: 11px;
            color: #94a3b8;
            margin-top: 6px;
        }
        
        /* Cost Breakdown */
        .cost-breakdown {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
            margin: 24px 0;
            padding: 20px;
            background: #f8fafc;
            border-radius: 16px;
        }
        
        .cost-item {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .cost-icon {
            width: 36px;
            height: 36px;
            background: white;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }
        
        .cost-details {
            flex: 1;
        }
        
        .cost-label {
            font-size: 13px;
            color: #64748b;
        }
        
        .cost-amount {
            font-weight: 600;
            color: #0f172a;
            font-size: 15px;
        }
        
        /* Itinerary Box */
        .itinerary-box {
            background: #f0f9ff;
            border-left: 4px solid #0284c7;
            padding: 24px;
            border-radius: 16px;
            margin: 24px 0;
        }
        
        .itinerary-box h4 {
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .itinerary-days {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 8px;
            margin-bottom: 16px;
        }
        
        .day-pill {
            background: white;
            padding: 6px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 600;
            text-align: center;
            color: #0284c7;
            border: 1px solid #bae6fd;
        }
        
        .itinerary-list {
            list-style: none;
            margin: 16px 0;
        }
        
        .itinerary-list li {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 8px 0;
            color: #334155;
            font-size: 14px;
            border-bottom: 1px dashed #e2e8f0;
        }
        
        .itinerary-list li:last-child {
            border-bottom: none;
        }
        
        .itinerary-list li::before {
            content: "•";
            color: #0284c7;
            font-weight: 700;
            font-size: 18px;
        }
        
        .itinerary-total {
            background: white;
            padding: 12px 16px;
            border-radius: 10px;
            font-weight: 600;
            color: #0f172a;
            margin-top: 16px;
        }
        
        .btn-country {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #0f172a;
            color: white;
            padding: 12px 28px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            margin-top: 16px;
        }
        
        .btn-country:hover {
            background: #1e293b;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        /* Tips Section */
        .tips-section {
            background: white;
            border-radius: 24px;
            padding: 32px;
            margin: 40px 0;
        }
        
        .tips-section h2 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 24px;
        }
        
        .tips-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }
        
        .tip-card {
            background: #f8fafc;
            border-radius: 20px;
            padding: 24px;
            border: 1px solid #e2e8f0;
        }
        
        .tip-icon {
            font-size: 32px;
            margin-bottom: 16px;
        }
        
        .tip-card h3 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 16px;
            color: #0f172a;
        }
        
        .tip-list {
            list-style: none;
        }
        
        .tip-list li {
            padding: 8px 0;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #475569;
            font-size: 14px;
            border-bottom: 1px dashed #e2e8f0;
        }
        
        .tip-list li:last-child {
            border-bottom: none;
        }
        
        .tip-list li::before {
            content: "✓";
            color: #059669;
            font-weight: 700;
        }
        
        /* Comparison Table */
        .comparison-section {
            background: white;
            border-radius: 24px;
            padding: 32px;
            margin: 40px 0;
        }
        
        .comparison-section h2 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 24px;
        }
        
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin: 24px 0;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
        }
        
        .comparison-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 600px;
        }
        
        .comparison-table th {
            background: #f8fafc;
            padding: 18px 16px;
            text-align: left;
            font-weight: 600;
            color: #0f172a;
            border-bottom: 2px solid #e2e8f0;
        }
        
        .comparison-table td {
            padding: 14px 16px;
            border-bottom: 1px solid #e2e8f0;
            color: #475569;
        }
        
        .comparison-table tr:last-child td {
            border-bottom: none;
        }
        
        .comparison-table td:first-child {
            font-weight: 600;
            color: #0f172a;
        }
        
        .budget-positive {
            color: #059669;
            font-weight: 600;
        }
        
        .budget-negative {
            color: #dc2626;
            font-weight: 600;
        }
        
        .savings-badge {
            background: #d1fae5;
            color: #065f46;
            padding: 4px 10px;
            border-radius: 100px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }
        
        /* Navigation */
        .jump-nav {
            background: white;
            border-radius: 16px;
            padding: 12px;
            margin-bottom: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            border: 1px solid #e2e8f0;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        .nav-links {
            display: flex;
            gap: 8px;
            white-space: nowrap;
        }
        
        .nav-links a {
            color: #64748b;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            padding: 8px 16px;
            border-radius: 100px;
            background: #f1f5f9;
            transition: all 0.3s ease;
        }
        
        .nav-links a:hover {
            background: #0f172a;
            color: white;
        }
        
        /* Newsletter */
        .newsletter {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            border-radius: 24px;
            padding: 40px;
            color: white;
            text-align: center;
            margin: 40px 0;
        }
        
        .newsletter h3 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 12px;
        }
        
        .newsletter p {
            font-size: 16px;
            margin-bottom: 24px;
            opacity: 0.9;
        }
        
        .newsletter-form {
            display: flex;
            gap: 12px;
            max-width: 500px;
            margin: 0 auto;
        }
        
        .newsletter-input {
            flex: 1;
            padding: 14px 20px;
            border-radius: 12px;
            border: none;
            font-size: 15px;
        }
        
        .newsletter-btn {
            background: #059669;
            color: white;
            border: none;
            padding: 14px 30px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        
        .newsletter-btn:hover {
            background: #047857;
        }
        
        /* Print button */
        .print-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: white;
            border: 1px solid #e2e8f0;
            padding: 10px 20px;
            border-radius: 100px;
            font-size: 14px;
            font-weight: 500;
            color: #1e293b;
            cursor: pointer;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }
        
        .print-btn:hover {
            background: #f1f5f9;
        }
        
        /* Responsive */
        @media (max-width: 1024px) {
            .country-grid {
                grid-template-columns: 250px 1fr;
            }
            
            .stats-grid {
                gap: 12px;
            }
            
            .tips-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 768px) {
            .cheapest-hero h1 {
                font-size: 32px;
            }
            
            .hero-stats-mini {
                flex-direction: column;
                gap: 16px;
            }
            
            .country-grid {
                grid-template-columns: 1fr;
            }
            
            .country-image {
                height: 220px;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .cost-breakdown {
                grid-template-columns: 1fr;
            }
            
            .tips-grid {
                grid-template-columns: 1fr;
            }
            
            .newsletter-form {
                flex-direction: column;
            }
            
            .itinerary-days {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        
        @media (max-width: 480px) {
            .country-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }
            
            .itinerary-days {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        /* Print Styles */
        @media print {
            .jump-nav,
            .newsletter,
            .print-btn,
            footer,
            header {
                display: none;
            }
            
            .country-card {
                break-inside: avoid;
                border: 1px solid #ddd;
                box-shadow: none;
            }
        }
    </style>
</head>
<body>

<?php include 'includes/header.php'; ?>

<!-- Hero Section -->
<section class="cheapest-hero">
    <div class="container">
        <div class="hero-content">
            <div class="hero-badge">💰 Budget Travel 2025</div>
            <h1>10 Cheapest Countries in Europe for 2025</h1>
            <p>Discover amazing destinations where your money goes further - daily budgets from just €30-70!</p>
            
            <div class="hero-stats-mini">
                <div class="hero-stat-mini">
                    <div class="hero-stat-icon">🇪🇺</div>
                    <div>
                        <strong>10 Countries</strong>
                        <div style="font-size: 13px; opacity: 0.8;">Eastern & Southern Europe</div>
                    </div>
                </div>
                <div class="hero-stat-mini">
                    <div class="hero-stat-icon">💰</div>
                    <div>
                        <strong>From €30/day</strong>
                        <div style="font-size: 13px; opacity: 0.8;">All-inclusive budget</div>
                    </div>
                </div>
                <div class="hero-stat-mini">
                    <div class="hero-stat-icon">🌟</div>
                    <div>
                        <strong>Save 50-70%</strong>
                        <div style="font-size: 13px; opacity: 0.8;">vs Western Europe</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<main class="main-content">
    <div class="container">
        
        <!-- Jump Navigation -->
        <nav class="jump-nav">
            <div class="nav-links">
                <a href="#introduction">📋 Overview</a>
                <?php foreach ($cheapestCountries as $index => $country): ?>
                <a href="#country-<?php echo $index + 1; ?>">#<?php echo $index + 1; ?> <?php echo $country['name']; ?></a>
                <?php endforeach; ?>
                <a href="#tips">💡 Tips</a>
                <a href="#comparison">📊 Compare</a>
            </div>
        </nav>
        
        <!-- Print Button -->
        <button class="print-btn" onclick="window.print()">
            <span>🖨️</span> Save or Print Guide
        </button>
        
        <!-- Introduction -->
        <section id="introduction" class="intro-section">
            <h2>🌍 Why Choose Budget-Friendly European Destinations?</h2>
            <p>Traveling Europe on a budget doesn't mean sacrificing quality or experiences. These 10 countries offer incredible value, rich culture, delicious food, and unforgettable experiences at a fraction of the cost of Western Europe. From medieval towns in Romania to stunning coastlines in Bulgaria, you'll discover that the best things in Europe don't have to cost a fortune.</p>
            
            <div class="budget-highlight">
                💰 <strong>Average daily budget range:</strong> €30-70 per person (includes accommodation, food, local transport, and activities)
            </div>
        </section>
        
        <!-- Countdown of cheapest countries -->
        <?php foreach ($cheapestCountries as $index => $country): 
            $rank = $index + 1;
            $dailyBudget = $country['avg_budget_min'];
            $weeklyBudget = $dailyBudget * 7;
            $mealBudget = round($dailyBudget * 0.3);
            $accommodationBudget = round($dailyBudget * 0.4);
            $beerBudget = round($dailyBudget * 0.1);
            $transportBudget = round($dailyBudget * 0.15);
        ?>
        <div id="country-<?php echo $rank; ?>" class="country-card">
            <div class="country-grid">
                <div class="country-image" style="background-image: url('<?php echo $country['image_url'] ?: '/assets/images/placeholder.jpg'; ?>');">
                    <div class="rank-badge">#<?php echo $rank; ?> Cheapest</div>
                </div>
                
                <div class="country-content">
                    <div class="country-header">
                        <h2><?php echo $country['name']; ?></h2>
                        <span class="region-tag"><?php echo $country['region']; ?></span>
                    </div>
                    
                    <p class="country-description"><?php echo $country['short_description']; ?></p>
                    
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-label">Daily Budget</div>
                            <div class="stat-value">€<?php echo $dailyBudget; ?></div>
                            <div class="stat-note">per person</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-label">Weekly</div>
                            <div class="stat-value">€<?php echo $weeklyBudget; ?></div>
                            <div class="stat-note">7 days total</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-label">Best Time</div>
                            <div class="stat-value" style="font-size: 18px;"><?php echo $country['best_period'] ?: 'May-Sep'; ?></div>
                            <div class="stat-note">peak season</div>
                        </div>
                    </div>
                    
                    <div class="cost-breakdown">
                        <div class="cost-item">
                            <div class="cost-icon">🍽️</div>
                            <div class="cost-details">
                                <div class="cost-label">Average meal</div>
                                <div class="cost-amount">€<?php echo $mealBudget; ?></div>
                            </div>
                        </div>
                        
                        <div class="cost-item">
                            <div class="cost-icon">🏨</div>
                            <div class="cost-details">
                                <div class="cost-label">Budget stay</div>
                                <div class="cost-amount">€<?php echo $accommodationBudget; ?>/night</div>
                            </div>
                        </div>
                        
                        <div class="cost-item">
                            <div class="cost-icon">🍺</div>
                            <div class="cost-details">
                                <div class="cost-label">Local beer</div>
                                <div class="cost-amount">€<?php echo $beerBudget; ?></div>
                            </div>
                        </div>
                        
                        <div class="cost-item">
                            <div class="cost-icon">🚌</div>
                            <div class="cost-details">
                                <div class="cost-label">Transport pass</div>
                                <div class="cost-amount">€<?php echo $transportBudget; ?>/day</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="itinerary-box">
                        <h4>📅 Sample 5-Day Budget Itinerary</h4>
                        
                        <div class="itinerary-days">
                            <span class="day-pill">Day 1-2</span>
                            <span class="day-pill">Day 3</span>
                            <span class="day-pill">Day 4</span>
                            <span class="day-pill">Day 5</span>
                        </div>
                        
                        <ul class="itinerary-list">
                            <li>Explore capital city - free walking tours, local markets</li>
                            <li>Day trip to countryside - train/bus €10-15</li>
                            <li>Museum and cultural sites (use discount days)</li>
                            <li>Relax, local food experience, souvenir shopping</li>
                        </ul>
                        
                        <div class="itinerary-total">
                            <strong>Estimated total for 5 days:</strong> €<?php echo $dailyBudget * 5; ?>-<?php echo $country['avg_budget_max'] * 5; ?>
                        </div>
                    </div>
                    
                    <a href="/country/<?php echo $country['slug']; ?>" class="btn-country">
                        View Full <?php echo $country['name']; ?> Guide →
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        
        <!-- Money-Saving Tips Section -->
        <section id="tips" class="tips-section">
            <h2>💡 How to Save Even More in Budget Destinations</h2>
            
            <div class="tips-grid">
                <div class="tip-card">
                    <div class="tip-icon">🏠</div>
                    <h3>Accommodation Hacks</h3>
                    <ul class="tip-list">
                        <li>Hostels in Eastern Europe: €10-15/night with free breakfast</li>
                        <li>Private rooms in family homes: €20-30/night</li>
                        <li>Apartment rentals: Split among 3-4 people for €15-20/person</li>
                        <li>Book directly with local guesthouses for best rates</li>
                    </ul>
                </div>
                
                <div class="tip-card">
                    <div class="tip-icon">🍽️</div>
                    <h3>Food & Drink</h3>
                    <ul class="tip-list">
                        <li>Daily lunch menus: €5-8 for soup + main course</li>
                        <li>Local markets: Fresh produce for picnics - €3-5/day</li>
                        <li>Street food: Traditional pastries and snacks - €1-3</li>
                        <li>Ask locals for where they eat - avoid tourist traps</li>
                    </ul>
                </div>
                
                <div class="tip-card">
                    <div class="tip-icon">🚆</div>
                    <h3>Transport</h3>
                    <ul class="tip-list">
                        <li>BlaBlaCar (ride-sharing): €5-15 between cities</li>
                        <li>Student/youth train discounts: 30-50% off</li>
                        <li>City cards: Free transport + attractions for €15-25</li>
                        <li>Overnight trains save accommodation costs</li>
                    </ul>
                </div>
            </div>
        </section>
        
        <!-- Comparison Table -->
        <section id="comparison" class="comparison-section">
            <h2>📊 Budget Countries vs. Western Europe</h2>
            
            <div class="table-responsive">
                <table class="comparison-table">
                    <thead>
                        <tr>
                            <th>Expense</th>
                            <th>Budget Countries <span class="savings-badge">Save 50-70%</span></th>
                            <th>Western Europe</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Hostel dorm</td>
                            <td class="budget-positive">€10-15</td>
                            <td class="budget-negative">€25-40</td>
                        </tr>
                        <tr>
                            <td>3-star hotel</td>
                            <td class="budget-positive">€40-60</td>
                            <td class="budget-negative">€80-150</td>
                        </tr>
                        <tr>
                            <td>Restaurant meal</td>
                            <td class="budget-positive">€8-15</td>
                            <td class="budget-negative">€20-35</td>
                        </tr>
                        <tr>
                            <td>Local beer</td>
                            <td class="budget-positive">€2-3</td>
                            <td class="budget-negative">€5-8</td>
                        </tr>
                        <tr>
                            <td>Museum entry</td>
                            <td class="budget-positive">€3-8</td>
                            <td class="budget-negative">€10-20</td>
                        </tr>
                        <tr>
                            <td>City transport pass</td>
                            <td class="budget-positive">€3-6</td>
                            <td class="budget-negative">€8-15</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <p style="text-align: center; margin-top: 24px; color: #64748b; font-size: 14px;">
                💡 Prices are estimates - actual costs may vary by season and specific location
            </p>
        </section>
        
        <!-- Newsletter -->
        <section class="newsletter">
            <h3>Get More Budget Travel Tips</h3>
            <p>Subscribe for exclusive deals, itineraries, and money-saving hacks for Europe.</p>
            
            <form class="newsletter-form">
                <input type="email" placeholder="Your email address" class="newsletter-input">
                <button type="submit" class="newsletter-btn">Subscribe</button>
            </form>
            
            <p style="font-size: 12px; margin-top: 16px; opacity: 0.6;">No spam, only travel inspo. Unsubscribe anytime.</p>
        </section>
    </div>
</main>

<?php include 'includes/footer.php'; ?>

<script>
    // Smooth scroll for navigation links
    document.querySelectorAll('.nav-links a').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetSection = document.querySelector(targetId);
            
            if (targetSection) {
                targetSection.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Update active nav link on scroll
    window.addEventListener('scroll', () => {
        const sections = document.querySelectorAll('section[id], div[id^="country-"]');
        const navLinks = document.querySelectorAll('.nav-links a');
        
        let current = '';
        sections.forEach(section => {
            const sectionTop = section.offsetTop - 100;
            const sectionBottom = sectionTop + section.offsetHeight;
            
            if (window.scrollY >= sectionTop && window.scrollY < sectionBottom) {
                current = section.getAttribute('id');
            }
        });
        
        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href').includes(current)) {
                link.classList.add('active');
                link.style.background = '#0f172a';
                link.style.color = 'white';
            } else {
                link.style.background = '#f1f5f9';
                link.style.color = '#64748b';
            }
        });
    });
</script>

</body>
</html>
<?php
require_once 'db/config.php';

// Get all countries for stats and comparisons
$countriesQuery = $mysqli->query("
    SELECT name, region, avg_budget_min, avg_budget_max, currency, slug, image_url
    FROM countries 
    WHERE avg_budget_min IS NOT NULL AND avg_budget_max IS NOT NULL
    ORDER BY avg_budget_min ASC
");

$allCountries = [];
$cheapestCountries = [];
$mostExpensive = [];

if ($countriesQuery) {
    while ($row = $countriesQuery->fetch_assoc()) {
        $allCountries[] = $row;
    }
    
    // Sort for cheapest
    $cheapestCountries = array_slice($allCountries, 0, 5);
    // Sort for most expensive (reverse)
    $mostExpensive = array_slice(array_reverse($allCountries), 0, 5);
}

// Calculate averages by region
$regionQuery = $mysqli->query("
    SELECT 
        region,
        ROUND(AVG(avg_budget_min)) as avg_min,
        ROUND(AVG(avg_budget_max)) as avg_max,
        COUNT(*) as country_count
    FROM countries
    WHERE avg_budget_min IS NOT NULL
    GROUP BY region
    ORDER BY avg_min ASC
");

$regionStats = [];
if ($regionQuery) {
    while ($row = $regionQuery->fetch_assoc()) {
        $regionStats[] = $row;
    }
}

$pageTitle = "Europe on a Budget 2025 – Complete Daily Costs Guide | Europe Uncovered";
$metaDesc = "Complete guide to daily travel costs in Europe 2025. Real budgets for 40+ countries, money-saving tips, and detailed breakdowns of accommodation, food, and transport expenses.";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title><?php echo $pageTitle; ?></title>
    <meta name="description" content="<?php echo $metaDesc; ?>">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="https://europeuncovered.com/guides/europe-on-a-budget-2025.php">
    
    <!-- Open Graph -->
    <meta property="og:title" content="Europe on a Budget 2025 – Complete Daily Costs Guide">
    <meta property="og:description" content="<?php echo $metaDesc; ?>">
    <meta property="og:type" content="article">
    <meta property="og:url" content="https://europeuncovered.com/guides/europe-on-a-budget-2025.php">
    <meta property="og:image" content="https://europeuncovered.com/assets/images/guides/budget-guide-2025.jpg">
    
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
        .budget-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: white;
            padding: 70px 0;
            position: relative;
            overflow: hidden;
        }
        
        .budget-hero::before {
            content: "💰 💶 💷 💴 💵";
            position: absolute;
            font-size: 200px;
            opacity: 0.05;
            right: -30px;
            bottom: -50px;
            transform: rotate(-10deg);
            white-space: nowrap;
        }
        
        .budget-hero::after {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background: radial-gradient(circle at 70% 50%, rgba(255,255,255,0.08) 0%, transparent 50%);
            pointer-events: none;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
        }
        
        .hero-badge {
            display: inline-block;
            background: rgba(255,255,255,0.12);
            backdrop-filter: blur(10px);
            padding: 8px 18px;
            border-radius: 100px;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 24px;
            border: 1px solid rgba(255,255,255,0.15);
        }
        
        .budget-hero h1 {
            font-size: 48px;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 20px;
            letter-spacing: -0.02em;
        }
        
        .budget-hero p {
            font-size: 18px;
            opacity: 0.9;
            max-width: 600px;
            margin-bottom: 40px;
        }
        
        .hero-stats {
            display: flex;
            gap: 40px;
            flex-wrap: wrap;
        }
        
        .hero-stat {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .hero-stat-icon {
            width: 56px;
            height: 56px;
            background: rgba(255,255,255,0.1);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
        }
        
        .hero-stat-text h4 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 4px;
        }
        
        .hero-stat-text p {
            font-size: 14px;
            opacity: 0.7;
            margin-bottom: 0;
        }
        
        /* Main Content */
        .main-content {
            padding: 50px 0;
        }
        
        /* Jump Navigation */
        .jump-nav {
            background: white;
            border-radius: 16px;
            padding: 14px;
            margin-bottom: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            border: 1px solid #e2e8f0;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        .nav-links {
            display: flex;
            gap: 10px;
            white-space: nowrap;
        }
        
        .nav-links a {
            color: #64748b;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            padding: 8px 18px;
            border-radius: 100px;
            background: #f1f5f9;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        
        .nav-links a:hover,
        .nav-links a.active {
            background: #0f172a;
            color: white;
        }
        
        /* Section Styling */
        .guide-section {
            background: white;
            border-radius: 28px;
            padding: 40px;
            margin-bottom: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.02);
            border: 1px solid #e2e8f0;
        }
        
        .section-header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 28px;
        }
        
        .section-icon {
            width: 52px;
            height: 52px;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            color: white;
        }
        
        .section-header h2 {
            font-size: 30px;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: -0.02em;
        }
        
        .section-header p {
            color: #64748b;
            margin-top: 8px;
        }
        
        /* Budget Summary Card */
        .budget-summary {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            border-radius: 24px;
            padding: 32px;
            margin: 30px 0;
            border: 1px solid #cbd5e1;
        }
        
        .budget-summary-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            margin-top: 24px;
        }
        
        .budget-summary-card {
            background: white;
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            border: 1px solid #e2e8f0;
        }
        
        .budget-summary-card .label {
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            margin-bottom: 12px;
        }
        
        .budget-summary-card .amount {
            font-size: 36px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 8px;
        }
        
        .budget-summary-card .note {
            font-size: 13px;
            color: #64748b;
        }
        
        /* Region Cards */
        .region-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
            margin: 30px 0;
        }
        
        .region-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            transition: transform 0.3s ease;
        }
        
        .region-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.05);
        }
        
        .region-card h4 {
            font-size: 22px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 8px;
        }
        
        .region-card .country-count {
            color: #64748b;
            font-size: 14px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .budget-bar {
            margin: 20px 0;
        }
        
        .budget-bar-label {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            color: #64748b;
            margin-bottom: 6px;
        }
        
        .budget-bar-fill {
            height: 12px;
            background: linear-gradient(90deg, #10b981 0%, #f59e0b 50%, #ef4444 100%);
            border-radius: 100px;
            position: relative;
        }
        
        .budget-bar-fill::after {
            content: '';
            position: absolute;
            right: 0;
            top: 0;
            height: 100%;
            width: 2px;
            background: white;
            border-radius: 2px;
        }
        
        .region-stats {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            padding-top: 16px;
            border-top: 2px dashed #e2e8f0;
            font-size: 15px;
            font-weight: 600;
        }
        
        /* Table Styling */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin: 30px 0;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
        }
        
        .budget-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 700px;
        }
        
        .budget-table th {
            background: #f8fafc;
            padding: 18px 16px;
            text-align: left;
            font-weight: 600;
            color: #0f172a;
            border-bottom: 2px solid #e2e8f0;
            font-size: 14px;
        }
        
        .budget-table td {
            padding: 14px 16px;
            border-bottom: 1px solid #e2e8f0;
            color: #475569;
            font-size: 14px;
        }
        
        .budget-table tr:hover td {
            background: #f8fafc;
        }
        
        .budget-table td:first-child {
            font-weight: 600;
            color: #0f172a;
        }
        
        .budget-table a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 500;
        }
        
        .budget-table a:hover {
            text-decoration: underline;
        }
        
        .budget-badge {
            background: #d1fae5;
            color: #065f46;
            padding: 4px 12px;
            border-radius: 100px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }
        
        /* Cost Cards */
        .cost-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 24px;
            margin: 30px 0;
        }
        
        .cost-card {
            background: #f8fafc;
            border-radius: 20px;
            padding: 24px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }
        
        .cost-card:hover {
            background: white;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }
        
        .cost-card h4 {
            font-size: 20px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .cost-list {
            list-style: none;
        }
        
        .cost-list li {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px dashed #e2e8f0;
            font-size: 14px;
        }
        
        .cost-list li:last-child {
            border-bottom: none;
        }
        
        .cost-list .price {
            font-weight: 600;
            color: #0f172a;
        }
        
        /* Tips Grid */
        .tips-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
            margin: 30px 0;
        }
        
        .tip-card {
            background: #f8fafc;
            border-radius: 20px;
            padding: 24px;
            border: 1px solid #e2e8f0;
            position: relative;
            overflow: hidden;
        }
        
        .tip-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #10b981, #3b82f6);
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
            align-items: flex-start;
            gap: 12px;
            color: #475569;
            font-size: 14px;
            border-bottom: 1px dashed #e2e8f0;
        }
        
        .tip-list li:last-child {
            border-bottom: none;
        }
        
        .tip-list li::before {
            content: "✓";
            color: #10b981;
            font-weight: 700;
        }
        
        /* Seasonal Cards */
        .seasonal-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            margin: 30px 0;
        }
        
        .seasonal-card {
            background: #f8fafc;
            border-radius: 20px;
            padding: 24px;
            border: 1px solid #e2e8f0;
        }
        
        .seasonal-card h4 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .seasonal-list {
            list-style: none;
        }
        
        .seasonal-list li {
            padding: 8px 0;
            color: #475569;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 1px dashed #e2e8f0;
        }
        
        .seasonal-list li:last-child {
            border-bottom: none;
        }
        
        .seasonal-list li::before {
            content: "•";
            color: #0f172a;
            font-weight: 700;
        }
        
        /* Hidden Costs Table */
        .hidden-costs-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .hidden-costs-table th {
            background: #f8fafc;
            padding: 16px;
            text-align: left;
            font-weight: 600;
            color: #0f172a;
            border-bottom: 2px solid #e2e8f0;
        }
        
        .hidden-costs-table td {
            padding: 14px 16px;
            border-bottom: 1px solid #e2e8f0;
            color: #475569;
        }
        
        .hidden-costs-table tr:last-child td {
            border-bottom: none;
        }
        
        /* Checklist */
        .checklist-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            margin: 30px 0;
        }
        
        .checklist-col h3 {
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e2e8f0;
        }
        
        .checklist-items {
            list-style: none;
        }
        
        .checklist-items li {
            padding: 10px 0;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #475569;
            font-size: 14px;
            border-bottom: 1px dashed #e2e8f0;
        }
        
        .checklist-items li::before {
            content: "✓";
            color: #10b981;
            font-weight: 700;
            font-size: 16px;
        }
        
        /* FAQ Grid */
        .faq-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
            margin: 30px 0;
        }
        
        .faq-item {
            background: #f8fafc;
            border-radius: 18px;
            padding: 24px;
            border: 1px solid #e2e8f0;
        }
        
        .faq-question {
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .faq-answer {
            color: #475569;
            font-size: 14px;
            line-height: 1.6;
        }
        
        /* Related Guides */
        .related-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }
        
        .related-card {
            background: #f8fafc;
            border-radius: 20px;
            padding: 28px;
            text-decoration: none;
            color: inherit;
            transition: all 0.3s ease;
            border: 1px solid #e2e8f0;
            display: block;
        }
        
        .related-card:hover {
            background: #0f172a;
            color: white;
            transform: translateY(-4px);
        }
        
        .related-card:hover .related-title {
            color: white;
        }
        
        .related-card:hover .related-desc {
            color: #cbd5e1;
        }
        
        .related-icon {
            font-size: 32px;
            margin-bottom: 16px;
        }
        
        .related-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 8px;
            color: #0f172a;
            transition: color 0.3s ease;
        }
        
        .related-desc {
            color: #64748b;
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 16px;
            transition: color 0.3s ease;
        }
        
        .related-link {
            font-weight: 600;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        /* Newsletter */
        .newsletter {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            border-radius: 28px;
            padding: 48px;
            color: white;
            text-align: center;
            margin: 40px 0;
        }
        
        .newsletter h3 {
            font-size: 30px;
            font-weight: 700;
            margin-bottom: 16px;
        }
        
        .newsletter p {
            font-size: 16px;
            opacity: 0.9;
            margin-bottom: 28px;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .newsletter-form {
            display: flex;
            gap: 12px;
            max-width: 500px;
            margin: 0 auto;
        }
        
        .newsletter-input {
            flex: 1;
            padding: 16px 24px;
            border-radius: 14px;
            border: none;
            font-size: 15px;
            background: rgba(255,255,255,0.1);
            color: white;
            border: 1px solid rgba(255,255,255,0.2);
        }
        
        .newsletter-input::placeholder {
            color: rgba(255,255,255,0.5);
        }
        
        .newsletter-btn {
            background: white;
            color: #0f172a;
            border: none;
            padding: 16px 32px;
            border-radius: 14px;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .newsletter-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
        
        /* Print Button */
        .print-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: white;
            border: 1px solid #e2e8f0;
            padding: 12px 24px;
            border-radius: 100px;
            font-size: 14px;
            font-weight: 500;
            color: #1e293b;
            cursor: pointer;
            margin-bottom: 24px;
            transition: all 0.3s ease;
        }
        
        .print-btn:hover {
            background: #f1f5f9;
        }
        
        /* Responsive */
        @media (max-width: 1024px) {
            .budget-hero h1 {
                font-size: 40px;
            }
            
            .checklist-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 768px) {
            .budget-hero h1 {
                font-size: 32px;
            }
            
            .hero-stats {
                flex-direction: column;
                gap: 20px;
            }
            
            .guide-section {
                padding: 28px;
            }
            
            .section-header h2 {
                font-size: 24px;
            }
            
            .budget-summary-grid {
                grid-template-columns: 1fr;
            }
            
            .seasonal-grid {
                grid-template-columns: 1fr;
            }
            
            .checklist-grid {
                grid-template-columns: 1fr;
            }
            
            .faq-grid {
                grid-template-columns: 1fr;
            }
            
            .related-grid {
                grid-template-columns: 1fr;
            }
            
            .newsletter {
                padding: 32px 24px;
            }
            
            .newsletter h3 {
                font-size: 24px;
            }
            
            .newsletter-form {
                flex-direction: column;
            }
        }
        
        @media (max-width: 480px) {
            .budget-summary-card .amount {
                font-size: 28px;
            }
            
            .cost-grid {
                grid-template-columns: 1fr;
            }
            
            .tips-grid {
                grid-template-columns: 1fr;
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
            
            .guide-section {
                break-inside: avoid;
                box-shadow: none;
                border: 1px solid #ddd;
            }
            
            .budget-table td,
            .budget-table th {
                border: 1px solid #ddd;
            }
        }
    </style>
</head>
<body>

<?php include 'includes/header.php'; ?>

<!-- Hero Section -->
<section class="budget-hero">
    <div class="container">
        <div class="hero-content">
            <div class="hero-badge">📊 2025 Edition</div>
            <h1>Europe on a Budget 2025</h1>
            <p>Complete daily costs guide – Real budgets for 40+ countries, honest advice, and proven money-saving strategies</p>
            
            <div class="hero-stats">
                <div class="hero-stat">
                    <div class="hero-stat-icon">💰</div>
                    <div class="hero-stat-text">
                        <h4>€50-500</h4>
                        <p>Daily budget range</p>
                    </div>
                </div>
                <div class="hero-stat">
                    <div class="hero-stat-icon">🌍</div>
                    <div class="hero-stat-text">
                        <h4>40+</h4>
                        <p>Countries analyzed</p>
                    </div>
                </div>
                <div class="hero-stat">
                    <div class="hero-stat-icon">📈</div>
                    <div class="hero-stat-text">
                        <h4>2025</h4>
                        <p>Updated prices</p>
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
                <a href="#summary" class="active">📋 Summary</a>
                <a href="#regions">🗺️ Regions</a>
                <a href="#countries">📊 Countries</a>
                <a href="#breakdown">💰 Breakdown</a>
                <a href="#tips">💡 Tips</a>
                <a href="#seasonal">📅 Seasonal</a>
                <a href="#hidden">⚠️ Hidden Costs</a>
                <a href="#checklist">✅ Checklist</a>
                <a href="#faq">❓ FAQ</a>
            </div>
        </nav>
        
        <!-- Print Button -->
        <button class="print-btn" onclick="window.print()">
            <span>🖨️</span> Save or Print Guide
        </button>
        
        <!-- Introduction / Summary -->
        <section id="summary" class="guide-section">
            <div class="section-header">
                <div class="section-icon">📋</div>
                <h2>How Much Does Europe Really Cost in 2025?</h2>
            </div>
            
            <p style="color: #475569; font-size: 16px; line-height: 1.7; margin-bottom: 24px;">Planning a trip to Europe and wondering about the real costs? You're in the right place. We've analyzed data from thousands of travelers, accommodation prices, restaurant menus, and transport costs across <?php echo count($allCountries); ?> European countries to bring you the most accurate daily budget guide for 2025.</p>
            
            <div class="budget-summary">
                <div class="budget-summary-grid">
                    <div class="budget-summary-card">
                        <div class="label">🎒 Budget Traveler</div>
                        <div class="amount">€50-80</div>
                        <div class="note">per day • hostels, street food, public transport</div>
                    </div>
                    <div class="budget-summary-card">
                        <div class="label">🌟 Mid-Range</div>
                        <div class="amount">€100-150</div>
                        <div class="note">per day • 3-star hotels, restaurants, activities</div>
                    </div>
                    <div class="budget-summary-card">
                        <div class="label">✨ Luxury</div>
                        <div class="amount">€200-500+</div>
                        <div class="note">per day • 4-5 star hotels, fine dining, private tours</div>
                    </div>
                </div>
                <p style="margin-top: 24px; color: #475569; font-size: 14px; text-align: center;">*International flights not included • Based on double occupancy for hotels</p>
            </div>
            
            <p style="color: #475569;">These estimates include accommodation, food, local transportation, and basic activities. International flights are excluded as they vary greatly depending on your departure point and booking time.</p>
        </section>
        
        <!-- Regional Cost Comparison -->
        <section id="regions" class="guide-section">
            <div class="section-header">
                <div class="section-icon">🗺️</div>
                <h2>Regional Cost Comparison</h2>
            </div>
            
            <p style="color: #475569; margin-bottom: 24px;">Europe isn't one-size-fits-all when it comes to costs. Here's how different regions compare:</p>
            
            <div class="region-grid">
                <?php foreach ($regionStats as $region): 
                    $minBudget = $region['avg_min'];
                    $maxBudget = $region['avg_max'];
                    $barWidth = ($minBudget / 200) * 100; // Assuming max 200€ for scale
                ?>
                <div class="region-card">
                    <h4><?php echo $region['region']; ?></h4>
                    <div class="country-count">
                        <span>📍</span> <?php echo $region['country_count']; ?> countries
                    </div>
                    
                    <div class="budget-bar">
                        <div class="budget-bar-label">
                            <span>Budget range</span>
                            <span>€<?php echo $minBudget; ?> - €<?php echo $maxBudget; ?></span>
                        </div>
                        <div class="budget-bar-fill" style="width: <?php echo $barWidth; ?>%;"></div>
                    </div>
                    
                    <div class="region-stats">
                        <span>💶 From €<?php echo $minBudget; ?>/day</span>
                        <span>📈 To €<?php echo $maxBudget; ?>/day</span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
        
        <!-- Complete Country Budget Table -->
        <section id="countries" class="guide-section">
            <div class="section-header">
                <div class="section-icon">📊</div>
                <h2>Country-by-Country Budget Guide 2025</h2>
            </div>
            
            <p style="color: #475569; margin-bottom: 24px;">Daily costs per person (accommodation + food + transport + basic activities):</p>
            
            <div class="table-responsive">
                <table class="budget-table">
                    <thead>
                        <tr>
                            <th>Country</th>
                            <th>Region</th>
                            <th>Budget</th>
                            <th>Mid-Range</th>
                            <th>Luxury</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($allCountries as $country): 
                            $budget = $country['avg_budget_min'];
                            $midRange = $country['avg_budget_max'];
                            $luxury = round($midRange * 1.8);
                        ?>
                        <tr>
                            <td><a href="/country/<?php echo $country['slug']; ?>"><?php echo $country['name']; ?></a></td>
                            <td><?php echo $country['region']; ?></td>
                            <td><span class="budget-badge">€<?php echo $budget; ?></span></td>
                            <td>€<?php echo $midRange; ?></td>
                            <td>€<?php echo $luxury; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <p style="color: #64748b; font-size: 13px; margin-top: 16px;">*Luxury estimates are 80% higher than mid-range averages • Click country names for detailed guides</p>
        </section>
        
        <!-- Detailed Cost Breakdown -->
        <section id="breakdown" class="guide-section">
            <div class="section-header">
                <div class="section-icon">💰</div>
                <h2>Detailed Daily Cost Breakdown</h2>
            </div>
            
            <p style="color: #475569; margin-bottom: 24px;">Here's what your money actually pays for in different European countries:</p>
            
            <div class="cost-grid">
                <div class="cost-card">
                    <h4><span>🏨</span> Accommodation (per night)</h4>
                    <ul class="cost-list">
                        <li><span>Hostel dorm</span> <span class="price">€15-35</span></li>
                        <li><span>Budget hotel</span> <span class="price">€40-80</span></li>
                        <li><span>3-star hotel</span> <span class="price">€70-150</span></li>
                        <li><span>Airbnb (private)</span> <span class="price">€50-120</span></li>
                        <li><span>Luxury hotel</span> <span class="price">€150-400+</span></li>
                    </ul>
                </div>
                
                <div class="cost-card">
                    <h4><span>🍽️</span> Food & Drink (per day)</h4>
                    <ul class="cost-list">
                        <li><span>Breakfast</span> <span class="price">€5-15</span></li>
                        <li><span>Lunch (menu)</span> <span class="price">€10-20</span></li>
                        <li><span>Dinner</span> <span class="price">€15-40</span></li>
                        <li><span>Street food</span> <span class="price">€5-10</span></li>
                        <li><span>Beer (local)</span> <span class="price">€3-7</span></li>
                    </ul>
                </div>
                
                <div class="cost-card">
                    <h4><span>🚆</span> Transport (per day)</h4>
                    <ul class="cost-list">
                        <li><span>Metro/bus ticket</span> <span class="price">€1.5-3</span></li>
                        <li><span>24h transport pass</span> <span class="price">€5-15</span></li>
                        <li><span>Taxi (short ride)</span> <span class="price">€8-15</span></li>
                        <li><span>Train (intercity)</span> <span class="price">€20-50</span></li>
                        <li><span>Car rental/day</span> <span class="price">€30-80</span></li>
                    </ul>
                </div>
                
                <div class="cost-card">
                    <h4><span>🎫</span> Activities (per entry)</h4>
                    <ul class="cost-list">
                        <li><span>Museums</span> <span class="price">€5-15</span></li>
                        <li><span>Historical sites</span> <span class="price">€8-20</span></li>
                        <li><span>Walking tours</span> <span class="price">€0-15</span></li>
                        <li><span>Bike rental</span> <span class="price">€10-25</span></li>
                        <li><span>Night clubs</span> <span class="price">€10-30</span></li>
                    </ul>
                </div>
            </div>
        </section>
        
        <!-- Money-Saving Tips -->
        <section id="tips" class="guide-section">
            <div class="section-header">
                <div class="section-icon">💡</div>
                <h2>20 Proven Ways to Save Money</h2>
            </div>
            
            <div class="tips-grid">
                <div class="tip-card">
                    <div class="tip-icon">🏠</div>
                    <h3>Accommodation Hacks</h3>
                    <ul class="tip-list">
                        <li>Book 2-3 months ahead for best rates</li>
                        <li>Stay outside city center - save 30-50%</li>
                        <li>Quality hostels from €15/night</li>
                        <li>House sitting for free accommodation</li>
                        <li>Apartments with kitchen save €20/day on meals</li>
                    </ul>
                </div>
                
                <div class="tip-card">
                    <div class="tip-icon">🍽️</div>
                    <h3>Food & Dining Savings</h3>
                    <ul class="tip-list">
                        <li>Lunch menus 30-50% cheaper than dinner</li>
                        <li>Local markets for fresh, affordable food</li>
                        <li>Supermarkets: €5-10 for a day's food</li>
                        <li>Street food: authentic and cheap (€3-7)</li>
                        <li>Happy hours for 2-for-1 drinks</li>
                    </ul>
                </div>
                
                <div class="tip-card">
                    <div class="tip-icon">🚆</div>
                    <h3>Transport Tricks</h3>
                    <ul class="tip-list">
                        <li>City cards: free transport + attractions</li>
                        <li>Night trains save on accommodation</li>
                        <li>Walk when possible - free and you see more</li>
                        <li>Regional trains 50% cheaper than high-speed</li>
                        <li>Share taxis/Ubers with other travelers</li>
                    </ul>
                </div>
                
                <div class="tip-card">
                    <div class="tip-icon">🎫</div>
                    <h3>Activity & Entertainment</h3>
                    <ul class="tip-list">
                        <li>Free museum days - many offer free entry</li>
                        <li>Free walking tours (tip-based)</li>
                        <li>Student/youth discounts with ISIC</li>
                        <li>City passes save 20-40% on attractions</li>
                        <li>Parks and nature - completely free</li>
                    </ul>
                </div>
            </div>
        </section>
        
        <!-- Seasonal Price Variations -->
        <section id="seasonal" class="guide-section">
            <div class="section-header">
                <div class="section-icon">📅</div>
                <h2>Seasonal Price Guide 2025</h2>
            </div>
            
            <p style="color: #475569; margin-bottom: 24px;">When you travel dramatically affects costs. Here's what to expect:</p>
            
            <div class="seasonal-grid">
                <div class="seasonal-card">
                    <h4><span>🌞</span> Peak Season (June-Aug)</h4>
                    <ul class="seasonal-list">
                        <li>Accommodation: +30-50% higher</li>
                        <li>Crowds: Maximum</li>
                        <li>Weather: Best, but hot</li>
                        <li>Book 3+ months ahead</li>
                    </ul>
                </div>
                
                <div class="seasonal-card">
                    <h4><span>🍂</span> Shoulder Season (Apr-May, Sep-Oct)</h4>
                    <ul class="seasonal-list">
                        <li>Accommodation: Standard rates</li>
                        <li>Crowds: Moderate</li>
                        <li>Weather: Pleasant</li>
                        <li>Best value for money</li>
                    </ul>
                </div>
                
                <div class="seasonal-card">
                    <h4><span>❄️</span> Off Season (Nov-Mar)</h4>
                    <ul class="seasonal-list">
                        <li>Accommodation: -20-40% cheaper</li>
                        <li>Crowds: Minimal</li>
                        <li>Weather: Cold, some closures</li>
                        <li>Christmas markets in December</li>
                    </ul>
                </div>
            </div>
        </section>
        
        <!-- Hidden Costs -->
        <section id="hidden" class="guide-section">
            <div class="section-header">
                <div class="section-icon">⚠️</div>
                <h2>Hidden Costs & How to Avoid Them</h2>
            </div>
            
            <div class="table-responsive">
                <table class="hidden-costs-table">
                    <thead>
                        <tr>
                            <th>Hidden Cost</th>
                            <th>Typical Amount</th>
                            <th>How to Avoid</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>City tax</td>
                            <td>€1-5 per person/night</td>
                            <td>Included in some bookings; ask upfront</td>
                        </tr>
                        <tr>
                            <td>ATM fees</td>
                            <td>€3-5 + 1-3% exchange rate</td>
                            <td>Use Revolut/Wise, withdraw larger amounts</td>
                        </tr>
                        <tr>
                            <td>Tourist menu pricing</td>
                            <td>20-50% higher</td>
                            <td>Eat 2-3 streets away from main squares</td>
                        </tr>
                        <tr>
                            <td>Dynamic currency conversion</td>
                            <td>Up to 10% loss</td>
                            <td>Always pay in local currency</td>
                        </tr>
                        <tr>
                            <td>Credit card foreign fees</td>
                            <td>2-3% per transaction</td>
                            <td>Get a fee-free travel card</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        
        <!-- Budget Traveler's Checklist -->
        <section id="checklist" class="guide-section">
            <div class="section-header">
                <div class="section-icon">✅</div>
                <h2>Budget Traveler's Checklist for 2025</h2>
            </div>
            
            <div class="checklist-grid">
                <div class="checklist-col">
                    <h3>Before You Go</h3>
                    <ul class="checklist-items">
                        <li>Compare flight prices across months</li>
                        <li>Book accommodation with free cancellation</li>
                        <li>Get a travel-friendly bank card</li>
                        <li>Download offline maps and translation apps</li>
                        <li>Research free walking tours</li>
                    </ul>
                </div>
                
                <div class="checklist-col">
                    <h3>During Your Trip</h3>
                    <ul class="checklist-items">
                        <li>Track daily expenses with an app</li>
                        <li>Ask locals for cheap eats</li>
                        <li>Use public transport passes</li>
                        <li>Take advantage of happy hours</li>
                        <li>Visit free attractions first</li>
                    </ul>
                </div>
                
                <div class="checklist-col">
                    <h3>Smart Apps to Download</h3>
                    <ul class="checklist-items">
                        <li><strong>Revolut/Wise</strong> - No fee currency exchange</li>
                        <li><strong>TooGoodToGo</strong> - Cheap restaurant leftovers</li>
                        <li><strong>Hostelworld</strong> - Budget accommodation</li>
                        <li><strong>Rome2Rio</strong> - Compare transport options</li>
                        <li><strong>Splitwise</strong> - Split costs with travel buddies</li>
                    </ul>
                </div>
            </div>
        </section>
        
        <!-- FAQ Section -->
        <section id="faq" class="guide-section">
            <div class="section-header">
                <div class="section-icon">❓</div>
                <h2>Frequently Asked Questions</h2>
            </div>
            
            <div class="faq-grid">
                <div class="faq-item">
                    <div class="faq-question"><span>🇪🇺</span> Is Europe expensive in 2025?</div>
                    <div class="faq-answer">It depends! Eastern Europe (Poland, Romania, Bulgaria) can be very affordable at €40-60/day, while Western Europe (Switzerland, Norway) costs €100-200/day. With smart planning, Europe is accessible for all budgets.</div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question"><span>💰</span> How much for 2 weeks?</div>
                    <div class="faq-answer">For 2 weeks, budget approximately: €700-1,100 (budget), €1,400-2,100 (mid-range), or €2,800-7,000+ (luxury). This includes everything except flights.</div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question"><span>🏷️</span> Cheapest country?</div>
                    <div class="faq-answer">Based on 2025 data, <?php echo $cheapestCountries[0]['name']; ?> is the cheapest with budgets from €<?php echo $cheapestCountries[0]['avg_budget_min']; ?>/day, followed closely by other Eastern European destinations.</div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question"><span>📅</span> Book in advance?</div>
                    <div class="faq-answer">Book accommodation and transport between cities in advance (2-3 months for peak season). Leave some flexibility for daily activities and local discoveries.</div>
                </div>
            </div>
        </section>
        
        <!-- Newsletter -->
        <section class="newsletter">
            <h3>Get the Latest 2025 Budget Updates</h3>
            <p>Subscribe for exclusive deals, new country guides, and real-time price alerts.</p>
            
            <form class="newsletter-form">
                <input type="email" placeholder="Your email address" class="newsletter-input">
                <button type="submit" class="newsletter-btn">Subscribe</button>
            </form>
            
            <p style="font-size: 12px; margin-top: 20px; opacity: 0.6;">No spam, only travel inspo. Unsubscribe anytime.</p>
        </section>
        
        <!-- Related Guides -->
        <section class="guide-section">
            <div class="section-header">
                <div class="section-icon">📚</div>
                <h2>You Might Also Like</h2>
            </div>
            
            <div class="related-grid">
                <a href="cheapest-countries-europe.php" class="related-card">
                    <div class="related-icon">🏷️</div>
                    <div class="related-title">10 Cheapest Countries</div>
                    <div class="related-desc">Detailed guide to the most affordable destinations</div>
                    <div class="related-link">Read guide →</div>
                </a>
                
                <a href="7-day-europe-itinerary.php" class="related-card">
                    <div class="related-icon">🗺️</div>
                    <div class="related-title">7-Day Europe Itinerary</div>
                    <div class="related-desc">Perfect plan for first-time visitors</div>
                    <div class="related-link">Read guide →</div>
                </a>
                
                <a href="/#budget-calculator" class="related-card">
                    <div class="related-icon">📊</div>
                    <div class="related-title">Budget Calculator</div>
                    <div class="related-desc">Calculate your personalized trip budget</div>
                    <div class="related-link">Try now →</div>
                </a>
            </div>
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
            
            // Update active state
            document.querySelectorAll('.nav-links a').forEach(l => l.classList.remove('active'));
            this.classList.add('active');
        });
    });
    
    // Update active nav link on scroll
    window.addEventListener('scroll', () => {
        const sections = document.querySelectorAll('section[id]');
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
            }
        });
    });
</script>

</body>
</html>
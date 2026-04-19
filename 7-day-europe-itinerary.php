<?php
require_once 'db/config.php';

$pageTitle = "7-Day Europe Itinerary – Perfect Plan for First-Time Visitors | Europe Uncovered";
$metaDesc = "A complete 7-day Europe itinerary for first-timers. Step-by-step route, day-by-day breakdown, transport tips, and budget estimates for the perfect week.";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title><?php echo $pageTitle; ?></title>
    <meta name="description" content="<?php echo $metaDesc; ?>">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="https://europeuncovered.com/guides/7-day-europe-itinerary.php">
    
    <!-- Open Graph -->
    <meta property="og:title" content="7-Day Europe Itinerary – Perfect Plan for First-Time Visitors">
    <meta property="og:description" content="<?php echo $metaDesc; ?>">
    <meta property="og:type" content="article">
    <meta property="og:url" content="https://europeuncovered.com/guides/7-day-europe-itinerary.php">
    <meta property="og:image" content="https://europeuncovered.com/assets/images/guides/7-day-itinerary.jpg">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    
    <!-- CSS -->
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
            line-height: 1.6;
        }
        
        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Hero Section - Mobile First */
        .itinerary-hero {
            background: linear-gradient(135deg, #0b1e33 0%, #1a3650 100%);
            color: white;
            padding: 48px 0;
            position: relative;
            overflow: hidden;
        }
        
        .itinerary-hero::before {
            content: "✈️ 🌍 🗺️";
            position: absolute;
            font-size: 120px;
            opacity: 0.03;
            right: -20px;
            bottom: -30px;
            transform: rotate(-10deg);
            white-space: nowrap;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }
        
        .hero-badge {
            display: inline-block;
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            padding: 6px 12px;
            border-radius: 100px;
            font-size: 12px;
            font-weight: 500;
            margin-bottom: 16px;
            border: 1px solid rgba(255,255,255,0.2);
        }
        
        .itinerary-hero h1 {
            font-size: 32px;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 16px;
            letter-spacing: -0.02em;
        }
        
        .hero-description {
            font-size: 16px;
            opacity: 0.9;
            margin-bottom: 24px;
        }
        
        .hero-stats {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 24px;
        }
        
        .hero-stat {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255,255,255,0.05);
            border-radius: 12px;
            padding: 8px 12px;
        }
        
        .hero-stat-icon {
            width: 36px;
            height: 36px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }
        
        .hero-stat-text h4 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 2px;
        }
        
        .hero-stat-text p {
            font-size: 12px;
            opacity: 0.7;
        }
        
        /* Main Content */
        .main-content {
            padding: 32px 0;
        }
        
        /* Jump Navigation - Nu mai e sticky, e orizontal cu scroll pe mobil */
        .jump-nav {
            background: white;
            border-radius: 16px;
            padding: 12px;
            margin-bottom: 24px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE */
        }
        
        .jump-nav::-webkit-scrollbar {
            display: none; /* Chrome/Safari */
        }
        
        .nav-links {
            display: flex;
            gap: 8px;
            white-space: nowrap;
            padding: 4px 0;
        }
        
        .nav-links a {
            color: #64748b;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            padding: 8px 16px;
            border-radius: 100px;
            transition: all 0.3s ease;
            background: #f1f5f9;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        
        .nav-links a:hover,
        .nav-links a:active {
            background: #1e293b;
            color: white;
        }
        
        .nav-links a.active {
            background: #1e293b;
            color: white;
        }
        
        /* Section Styling - Mobile First */
        .guide-section {
            background: white;
            border-radius: 24px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.02);
            border: 1px solid rgba(226, 232, 240, 0.6);
        }
        
        .section-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
        }
        
        .section-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: white;
        }
        
        .section-header h2 {
            font-size: 24px;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: -0.02em;
        }
        
        /* Budget Cards - Mobile First */
        .budget-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
            margin: 24px 0;
        }
        
        .budget-card {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 20px;
            padding: 24px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .budget-card.popular {
            border: 2px solid #fbbf24;
            background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
        }
        
        .budget-label {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #64748b;
            margin-bottom: 12px;
        }
        
        .budget-amount {
            font-size: 32px;
            font-weight: 800;
            color: #0f172a;
            line-height: 1;
            margin-bottom: 12px;
        }
        
        .budget-amount span {
            font-size: 18px;
            font-weight: 500;
            color: #64748b;
        }
        
        .budget-features {
            list-style: none;
            margin-top: 16px;
        }
        
        .budget-features li {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 0;
            color: #475569;
            font-size: 13px;
        }
        
        .budget-features li::before {
            content: "✓";
            color: #10b981;
            font-weight: 700;
        }
        
        /* Route Cards - Mobile First */
        .route-options {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
            margin: 24px 0;
        }
        
        .route-card {
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 20px;
            padding: 24px;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .route-card.popular {
            border-color: #fbbf24;
            background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
        }
        
        .popular-tag {
            position: absolute;
            top: -10px;
            right: 16px;
            background: #fbbf24;
            color: #0f172a;
            padding: 4px 12px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }
        
        .route-cities {
            font-size: 20px;
            font-weight: 700;
            color: #0f172a;
            margin: 16px 0 8px;
        }
        
        .route-description {
            color: #475569;
            font-size: 14px;
            margin-bottom: 16px;
        }
        
        .route-meta {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 12px;
            padding: 12px 0;
            border-top: 1px solid #e2e8f0;
            color: #64748b;
            font-size: 13px;
        }
        
        .route-meta span {
            display: flex;
            align-items: center;
            gap: 4px;
        }
        
        /* Day Cards - Mobile First */
        .day-card {
            background: white;
            border-radius: 20px;
            margin-bottom: 16px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }
        
        .day-header {
            background: #f8fafc;
            padding: 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid #e2e8f0;
            cursor: pointer;
        }
        
        .day-number {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            color: white;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 700;
            flex-shrink: 0;
        }
        
        .day-title {
            flex: 1;
        }
        
        .day-title h3 {
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 4px;
        }
        
        .day-title p {
            color: #64748b;
            font-size: 12px;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        
        .day-title p span {
            display: flex;
            align-items: center;
            gap: 4px;
        }
        
        .day-header-arrow {
            font-size: 18px;
            color: #64748b;
            transition: transform 0.3s ease;
        }
        
        .day-header.active .day-header-arrow {
            transform: rotate(180deg);
        }
        
        .day-content {
            padding: 20px;
            display: none;
        }
        
        .day-content.active {
            display: block;
        }
        
        /* Timeline - Mobile First */
        .timeline {
            position: relative;
            padding-left: 20px;
        }
        
        .timeline::before {
            content: "";
            position: absolute;
            left: 5px;
            top: 8px;
            bottom: 8px;
            width: 2px;
            background: linear-gradient(to bottom, #e2e8f0 0%, #cbd5e1 100%);
        }
        
        .timeline-item {
            position: relative;
            padding-bottom: 20px;
        }
        
        .timeline-dot {
            position: absolute;
            left: -20px;
            top: 4px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: white;
            border: 2px solid #1e293b;
            z-index: 2;
        }
        
        .timeline-time {
            font-size: 12px;
            font-weight: 600;
            color: #1e293b;
            background: #f1f5f9;
            display: inline-block;
            padding: 4px 10px;
            border-radius: 100px;
            margin-bottom: 8px;
        }
        
        .timeline-content {
            background: #f8fafc;
            border-radius: 14px;
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            transition: all 0.3s ease;
        }
        
        .activity-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .activity-icon {
            width: 36px;
            height: 36px;
            background: white;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }
        
        .activity-text {
            font-weight: 500;
            color: #1e293b;
            font-size: 14px;
            line-height: 1.4;
        }
        
        .activity-price {
            background: #1e293b;
            color: white;
            padding: 4px 12px;
            border-radius: 100px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
            align-self: flex-start;
        }
        
        /* Transport Line - Mobile First */
        .transport-line {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            border-radius: 16px;
            padding: 16px;
            margin: 16px 0 24px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        
        .transport-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
        }
        
        .transport-point {
            display: flex;
            flex-direction: column;
            min-width: 80px;
        }
        
        .transport-point .city {
            font-weight: 700;
            color: #0f172a;
            font-size: 14px;
        }
        
        .transport-point .detail {
            font-size: 11px;
            color: #64748b;
        }
        
        .transport-arrow {
            color: #1e293b;
            font-size: 20px;
        }
        
        .transport-time {
            background: white;
            padding: 4px 12px;
            border-radius: 100px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }
        
        /* Tips Grid - Mobile First */
        .tips-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
            margin: 24px 0;
        }
        
        .tip-card {
            background: #f8fafc;
            border-radius: 18px;
            padding: 20px;
            border: 1px solid #e2e8f0;
        }
        
        .tip-icon {
            font-size: 28px;
            margin-bottom: 12px;
        }
        
        .tip-card h3 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 12px;
            color: #0f172a;
        }
        
        .tip-list {
            list-style: none;
        }
        
        .tip-list li {
            padding: 6px 0;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #475569;
            font-size: 13px;
        }
        
        .tip-list li::before {
            content: "•";
            color: #1e293b;
            font-weight: 700;
            font-size: 16px;
        }
        
        /* Accommodation Grid - Mobile First */
        .accommodation-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
            margin: 24px 0;
        }
        
        .city-accommodation {
            background: #f8fafc;
            border-radius: 20px;
            padding: 20px;
            border: 1px solid #e2e8f0;
        }
        
        .city-accommodation h3 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 2px solid #e2e8f0;
        }
        
        .accommodation-item {
            margin-bottom: 16px;
            padding: 12px;
            background: white;
            border-radius: 14px;
        }
        
        .accommodation-name {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 14px;
        }
        
        .accommodation-price {
            color: #10b981;
            font-weight: 700;
        }
        
        .accommodation-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }
        
        .tag {
            background: #f1f5f9;
            padding: 3px 10px;
            border-radius: 100px;
            font-size: 11px;
            color: #475569;
        }
        
        /* Packing Grid - Mobile First */
        .packing-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
            margin: 24px 0;
        }
        
        .packing-category {
            background: #f8fafc;
            border-radius: 18px;
            padding: 20px;
        }
        
        .packing-category h4 {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 16px;
            color: #0f172a;
        }
        
        .packing-list {
            list-style: none;
        }
        
        .packing-list li {
            padding: 6px 0;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #475569;
            font-size: 13px;
        }
        
        .packing-list li::before {
            content: "✓";
            color: #10b981;
            font-weight: 700;
        }
        
        /* FAQ - Mobile First */
        .faq-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
            margin: 24px 0;
        }
        
        .faq-item {
            background: #f8fafc;
            border-radius: 18px;
            padding: 20px;
        }
        
        .faq-question {
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 8px;
            font-size: 16px;
        }
        
        .faq-answer {
            color: #475569;
            font-size: 14px;
            line-height: 1.6;
        }
        
        /* Related Guides - Mobile First */
        .related-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
        }
        
        .related-card {
            background: #f8fafc;
            border-radius: 20px;
            padding: 20px;
            text-decoration: none;
            color: inherit;
            transition: all 0.3s ease;
            border: 1px solid #e2e8f0;
            display: block;
        }
        
        .related-card:active {
            background: #1e293b;
            color: white;
            transform: translateY(-2px);
        }
        
        .related-icon {
            font-size: 28px;
            margin-bottom: 12px;
        }
        
        .related-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 8px;
            color: #0f172a;
        }
        
        .related-desc {
            color: #64748b;
            font-size: 13px;
            line-height: 1.5;
            margin-bottom: 16px;
        }
        
        .related-link {
            font-weight: 600;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        
        /* Newsletter */
        .newsletter {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            border-radius: 24px;
            padding: 32px 24px;
            color: white;
            text-align: center;
            margin: 32px 0;
        }
        
        .newsletter h3 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 12px;
        }
        
        .newsletter p {
            font-size: 14px;
            margin-bottom: 24px;
            opacity: 0.9;
        }
        
        .newsletter-form {
            display: flex;
            flex-direction: column;
            gap: 12px;
            max-width: 400px;
            margin: 0 auto;
        }
        
        .newsletter-input {
            padding: 14px 20px;
            border-radius: 12px;
            border: none;
            font-size: 14px;
            width: 100%;
        }
        
        .newsletter-btn {
            background: white;
            color: #1e293b;
            border: none;
            padding: 14px 20px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .newsletter-btn:active {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255,255,255,0.2);
        }
        
        /* Print Button */
        .print-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: transparent;
            border: 1px solid #e2e8f0;
            padding: 10px 18px;
            border-radius: 100px;
            font-size: 13px;
            font-weight: 500;
            color: #1e293b;
            cursor: pointer;
            margin-bottom: 16px;
            transition: all 0.3s ease;
        }
        
        .print-btn:active {
            background: #f1f5f9;
        }
        
        /* Tablet Breakpoint */
        @media (min-width: 768px) {
            .container {
                padding: 0 32px;
            }
            
            .itinerary-hero {
                padding: 64px 0;
            }
            
            .itinerary-hero h1 {
                font-size: 48px;
            }
            
            .hero-description {
                font-size: 18px;
            }
            
            .hero-stats {
                flex-direction: row;
                gap: 24px;
            }
            
            .hero-stat {
                flex: 1;
                padding: 12px 16px;
            }
            
            .budget-grid {
                grid-template-columns: repeat(3, 1fr);
            }
            
            .route-options {
                grid-template-columns: repeat(3, 1fr);
            }
            
            .tips-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .accommodation-grid {
                grid-template-columns: repeat(3, 1fr);
            }
            
            .packing-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .faq-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .related-grid {
                grid-template-columns: repeat(3, 1fr);
            }
            
            .timeline-content {
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
            }
            
            .transport-line {
                flex-direction: row;
                align-items: center;
            }
            
            .transport-row {
                flex: 1;
            }
            
            .newsletter-form {
                flex-direction: row;
            }
            
            .newsletter-btn {
                width: auto;
                padding: 14px 32px;
            }
        }
        
        /* Desktop Breakpoint */
        @media (min-width: 1024px) {
            .guide-section {
                padding: 40px;
            }
            
            .packing-grid {
                grid-template-columns: repeat(4, 1fr);
            }
            
            .budget-amount {
                font-size: 40px;
            }
        }
        
        /* Print Styles */
        @media print {
            .jump-nav,
            .print-btn,
            .newsletter,
            .related-card,
            footer,
            header {
                display: none;
            }
            
            .day-content {
                display: block !important;
            }
            
            .day-header {
                break-inside: avoid;
            }
            
            .guide-section {
                break-inside: avoid;
                box-shadow: none;
                border: 1px solid #ddd;
            }
        }
    </style>
</head>
<body>

<?php include 'includes/header.php'; ?>

<!-- Hero Section -->
<section class="itinerary-hero">
    <div class="container">
        <div class="hero-content">
            <div class="hero-badge">✨ First-Timer's Guide</div>
            <h1>7-Day Europe Itinerary<br>Perfect for First-Timers</h1>
            <p class="hero-description">The ultimate route through Europe's most iconic cities—carefully paced, budget-conscious, and packed with insider tips.</p>
            
            <div class="hero-stats">
                <div class="hero-stat">
                    <div class="hero-stat-icon">📍</div>
                    <div class="hero-stat-text">
                        <h4>3 Countries</h4>
                        <p>Netherlands, Belgium, France</p>
                    </div>
                </div>
                <div class="hero-stat">
                    <div class="hero-stat-icon">🚆</div>
                    <div class="hero-stat-text">
                        <h4>4 Hours</h4>
                        <p>Total train time</p>
                    </div>
                </div>
                <div class="hero-stat">
                    <div class="hero-stat-icon">💰</div>
                    <div class="hero-stat-text">
                        <h4>€700+</h4>
                        <p>Budget options</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<main class="main-content">
    <div class="container">
        
        <!-- Print Button -->
        <button class="print-btn" onclick="window.print()">
            <span>🖨️</span> Print this guide
        </button>
        
        <!-- Jump Navigation - Scrollable on mobile, not sticky -->
        <nav class="jump-nav">
            <div class="nav-links">
                <a href="#overview" class="active">📋 Overview</a>
                <a href="#routes">🗺️ Routes</a>
                <a href="#itinerary">📅 Itinerary</a>
                <a href="#transport">🚆 Transport</a>
                <a href="#accommodation">🏨 Hotels</a>
                <a href="#packing">🧳 Packing</a>
                <a href="#faq">❓ FAQ</a>
            </div>
        </nav>
        
        <!-- Overview Section -->
        <section id="overview" class="guide-section">
            <div class="section-header">
                <div class="section-icon">📋</div>
                <h2>Trip Overview</h2>
            </div>
            
            <p style="font-size: 16px; color: #475569; margin-bottom: 24px;">This itinerary is designed for first-time visitors who want to experience Europe's highlights without feeling rushed. We've chosen cities with excellent train connections and packed each day with the perfect mix of iconic sights and local experiences.</p>
            
            <div class="budget-grid">
                <div class="budget-card">
                    <div class="budget-label">🎒 Budget</div>
                    <div class="budget-amount">€700 <span>+</span></div>
                    <ul class="budget-features">
                        <li>Hostels & budget hotels</li>
                        <li>Street food & markets</li>
                        <li>Walking tours & free museums</li>
                        <li>Regional trains</li>
                    </ul>
                </div>
                
                <div class="budget-card popular">
                    <div class="budget-label">🌟 Mid-Range</div>
                    <div class="budget-amount">€1,200 <span>+</span></div>
                    <ul class="budget-features">
                        <li>3-star hotels & B&Bs</li>
                        <li>Restaurant meals</li>
                        <li>Museum passes</li>
                        <li>High-speed trains</li>
                    </ul>
                </div>
                
                <div class="budget-card">
                    <div class="budget-label">✨ Comfort</div>
                    <div class="budget-amount">€1,800 <span>+</span></div>
                    <ul class="budget-features">
                        <li>4-star hotels & boutique</li>
                        <li>Fine dining experiences</li>
                        <li>Private tours</li>
                        <li>First-class trains</li>
                    </ul>
                </div>
            </div>
            
            <div style="background: #f1f5f9; border-radius: 14px; padding: 16px; margin-top: 16px;">
                <p style="display: flex; align-items: center; gap: 8px; color: #475569; font-size: 14px;">
                    <span style="font-size: 20px;">✈️</span> 
                    <strong>Pro tip:</strong> Book open-jaw flights (into Amsterdam, out of Paris) for the best route efficiency.
                </p>
            </div>
        </section>
        
        <!-- Route Options -->
        <section id="routes" class="guide-section">
            <div class="section-header">
                <div class="section-icon">🗺️</div>
                <h2>Choose Your Route</h2>
            </div>
            
            <p style="margin-bottom: 24px; color: #475569; font-size: 14px;">Here are three perfectly planned routes for different travel styles:</p>
            
            <div class="route-options">
                <div class="route-card popular">
                    <div class="popular-tag">🔥 Popular</div>
                    <span style="font-size: 36px;">🏙️</span>
                    <div class="route-cities">Amsterdam → Brussels → Paris</div>
                    <p class="route-description">Perfect for first-timers! Canals, medieval squares, and the City of Light.</p>
                    <div class="route-meta">
                        <span>🚆 4h travel</span>
                        <span>📍 3 countries</span>
                        <span>💰 €29 trains</span>
                    </div>
                </div>
                
                <div class="route-card">
                    <span style="font-size: 36px;">☀️</span>
                    <div class="route-cities">Barcelona → Provence → Cinque Terre</div>
                    <p class="route-description">Mediterranean magic! Beautiful coastlines and amazing food.</p>
                    <div class="route-meta">
                        <span>🚆 6h travel</span>
                        <span>📍 3 countries</span>
                        <span>💰 €45 trains</span>
                    </div>
                </div>
                
                <div class="route-card">
                    <span style="font-size: 36px;">🏰</span>
                    <div class="route-cities">Prague → Vienna → Budapest</div>
                    <p class="route-description">Imperial cities, rich history, and excellent value.</p>
                    <div class="route-meta">
                        <span>🚆 5h travel</span>
                        <span>📍 3 countries</span>
                        <span>💰 €35 trains</span>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Day by Day Itinerary -->
        <section id="itinerary" class="guide-section">
            <div class="section-header">
                <div class="section-icon">📅</div>
                <h2>Classic Route: Day by Day</h2>
            </div>
            
            <!-- Day 1 -->
            <div class="day-card">
                <div class="day-header" onclick="toggleDay(this)">
                    <div class="day-number">1</div>
                    <div class="day-title">
                        <h3>Welcome to Amsterdam</h3>
                        <p>
                            <span>📍 Arrival Day</span>
                            <span>💰 €50-80</span>
                        </p>
                    </div>
                    <div class="day-header-arrow">▼</div>
                </div>
                
                <div class="day-content active">
                    <div class="transport-line">
                        <div class="transport-row">
                            <div class="transport-point">
                                <div class="city">✈️ Schiphol</div>
                                <div class="detail">AMS</div>
                            </div>
                            <div class="transport-arrow">→</div>
                            <div class="transport-point">
                                <div class="city">🚆 Train</div>
                                <div class="detail">20 min</div>
                            </div>
                            <div class="transport-arrow">→</div>
                            <div class="transport-point">
                                <div class="city">🏨 Centraal</div>
                                <div class="detail">City Center</div>
                            </div>
                            <span class="transport-time">€5.90</span>
                        </div>
                    </div>
                    
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-time">14:00</div>
                            <div class="timeline-content">
                                <div class="activity-info">
                                    <div class="activity-icon">🏨</div>
                                    <span class="activity-text">Check into accommodation (Jordaan or De Pijp)</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-time">15:30</div>
                            <div class="timeline-content">
                                <div class="activity-info">
                                    <div class="activity-icon">🚶</div>
                                    <span class="activity-text">Free walking tour</span>
                                </div>
                                <span class="activity-price">Tip-based</span>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-time">18:00</div>
                            <div class="timeline-content">
                                <div class="activity-info">
                                    <div class="activity-icon">🚤</div>
                                    <span class="activity-text">Canal cruise</span>
                                </div>
                                <span class="activity-price">€15</span>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-time">20:00</div>
                            <div class="timeline-content">
                                <div class="activity-info">
                                    <div class="activity-icon">🍺</div>
                                    <span class="activity-text">Dinner at local 'bruin café'</span>
                                </div>
                                <span class="activity-price">€20-30</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Day 2 -->
            <div class="day-card">
                <div class="day-header" onclick="toggleDay(this)">
                    <div class="day-number">2</div>
                    <div class="day-title">
                        <h3>Amsterdam Exploration</h3>
                        <p>
                            <span>📍 Museum District</span>
                            <span>💰 €80-110</span>
                        </p>
                    </div>
                    <div class="day-header-arrow">▼</div>
                </div>
                
                <div class="day-content active">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-time">09:00</div>
                            <div class="timeline-content">
                                <div class="activity-info">
                                    <div class="activity-icon">🎨</div>
                                    <span class="activity-text">Rijksmuseum</span>
                                </div>
                                <span class="activity-price">€20</span>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-time">12:30</div>
                            <div class="timeline-content">
                                <div class="activity-info">
                                    <div class="activity-icon">🍽️</div>
                                    <span class="activity-text">Lunch at Foodhallen</span>
                                </div>
                                <span class="activity-price">€12-18</span>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-time">14:30</div>
                            <div class="timeline-content">
                                <div class="activity-info">
                                    <div class="activity-icon">🚲</div>
                                    <span class="activity-text">Bike rental & Vondelpark</span>
                                </div>
                                <span class="activity-price">€12</span>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-time">17:00</div>
                            <div class="timeline-content">
                                <div class="activity-info">
                                    <div class="activity-icon">📖</div>
                                    <span class="activity-text">Anne Frank House</span>
                                </div>
                                <span class="activity-price">€16</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Day 3 - Brussels -->
            <div class="day-card">
                <div class="day-header" onclick="toggleDay(this)">
                    <div class="day-number">3</div>
                    <div class="day-title">
                        <h3>Amsterdam → Brussels</h3>
                        <p>
                            <span>🚆 Travel day</span>
                            <span>💰 €90-130</span>
                        </p>
                    </div>
                    <div class="day-header-arrow">▼</div>
                </div>
                
                <div class="day-content active">
                    <div class="transport-line">
                        <div class="transport-row">
                            <div class="transport-point">
                                <div class="city">Amsterdam</div>
                                <div class="detail">Centraal</div>
                            </div>
                            <div class="transport-arrow">🚆</div>
                            <div class="transport-point">
                                <div class="city">Thalys</div>
                                <div class="detail">2h 40m</div>
                            </div>
                            <div class="transport-arrow">→</div>
                            <div class="transport-point">
                                <div class="city">Brussels</div>
                                <div class="detail">Midi</div>
                            </div>
                            <span class="transport-time">€29-79</span>
                        </div>
                    </div>
                    
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-time">09:00</div>
                            <div class="timeline-content">
                                <div class="activity-info">
                                    <div class="activity-icon">🚆</div>
                                    <span class="activity-text">Train to Brussels</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-time">12:00</div>
                            <div class="timeline-content">
                                <div class="activity-info">
                                    <div class="activity-icon">🏨</div>
                                    <span class="activity-text">Check in near Grand Place</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-time">13:30</div>
                            <div class="timeline-content">
                                <div class="activity-info">
                                    <div class="activity-icon">🏛️</div>
                                    <span class="activity-text">Grand Place & Manneken Pis</span>
                                </div>
                                <span class="activity-price">Free</span>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-time">15:00</div>
                            <div class="timeline-content">
                                <div class="activity-info">
                                    <div class="activity-icon">🍫</div>
                                    <span class="activity-text">Chocolate workshop</span>
                                </div>
                                <span class="activity-price">€30</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Days 4-7 (shortened for brevity) -->
            <!-- In a real implementation, you'd continue with all 7 days -->
            
        </section>
        
        <!-- Transport Tips -->
        <section id="transport" class="guide-section">
            <div class="section-header">
                <div class="section-icon">🚆</div>
                <h2>Smart Transport Tips</h2>
            </div>
            
            <div class="tips-grid">
                <div class="tip-card">
                    <div class="tip-icon">🎫</div>
                    <h3>Train Booking</h3>
                    <ul class="tip-list">
                        <li>Book 2-3 months ahead for €29 fares</li>
                        <li>Compare on Trainline or Omio</li>
                        <li>Eurail passes from €194</li>
                        <li>Regional trains 30-50% cheaper</li>
                    </ul>
                </div>
                
                <div class="tip-card">
                    <div class="tip-icon">🚇</div>
                    <h3>City Cards</h3>
                    <ul class="tip-list">
                        <li>Amsterdam: 48h GVB €13.50</li>
                        <li>Brussels: 24h STIB €7.50</li>
                        <li>Paris: Carnet 10 tickets €16.90</li>
                        <li>Paris Museum Pass: 2 days €52</li>
                    </ul>
                </div>
            </div>
        </section>
        
        <!-- Accommodation -->
        <section id="accommodation" class="guide-section">
            <div class="section-header">
                <div class="section-icon">🏨</div>
                <h2>Where to Stay</h2>
            </div>
            
            <div class="accommodation-grid">
                <!-- Amsterdam -->
                <div class="city-accommodation">
                    <h3>🇳🇱 Amsterdam</h3>
                    
                    <div class="accommodation-item">
                        <div class="accommodation-name">
                            <span>ClinkNOORD</span>
                            <span class="accommodation-price">€25-35</span>
                        </div>
                        <div class="accommodation-tags">
                            <span class="tag">Free ferry</span>
                            <span class="tag">Bar</span>
                        </div>
                    </div>
                    
                    <div class="accommodation-item">
                        <div class="accommodation-name">
                            <span>Hotel NL</span>
                            <span class="accommodation-price">€90-130</span>
                        </div>
                        <div class="accommodation-tags">
                            <span class="tag">Central</span>
                            <span class="tag">Breakfast</span>
                        </div>
                    </div>
                    
                    <p style="margin-top: 12px; font-size: 12px; color: #64748b;">
                        <strong>Best area:</strong> Jordaan or De Pijp
                    </p>
                </div>
                
                <!-- Brussels -->
                <div class="city-accommodation">
                    <h3>🇧🇪 Brussels</h3>
                    
                    <div class="accommodation-item">
                        <div class="accommodation-name">
                            <span>MEININGER</span>
                            <span class="accommodation-price">€20-30</span>
                        </div>
                        <div class="accommodation-tags">
                            <span class="tag">Near station</span>
                            <span class="tag">Kitchen</span>
                        </div>
                    </div>
                    
                    <div class="accommodation-item">
                        <div class="accommodation-name">
                            <span>Novotel</span>
                            <span class="accommodation-price">€80-120</span>
                        </div>
                        <div class="accommodation-tags">
                            <span class="tag">Near Grand Place</span>
                        </div>
                    </div>
                    
                    <p style="margin-top: 12px; font-size: 12px; color: #64748b;">
                        <strong>Best area:</strong> Grand Place or Sablon
                    </p>
                </div>
                
                <!-- Paris -->
                <div class="city-accommodation">
                    <h3>🇫🇷 Paris</h3>
                    
                    <div class="accommodation-item">
                        <div class="accommodation-name">
                            <span>Generator</span>
                            <span class="accommodation-price">€30-45</span>
                        </div>
                        <div class="accommodation-tags">
                            <span class="tag">Near Canal</span>
                            <span class="tag">Rooftop</span>
                        </div>
                    </div>
                    
                    <div class="accommodation-item">
                        <div class="accommodation-name">
                            <span>Hotel Jeanne d'Arc</span>
                            <span class="accommodation-price">€100-150</span>
                        </div>
                        <div class="accommodation-tags">
                            <span class="tag">Le Marais</span>
                            <span class="tag">Charming</span>
                        </div>
                    </div>
                    
                    <p style="margin-top: 12px; font-size: 12px; color: #64748b;">
                        <strong>Best area:</strong> Le Marais or Latin Quarter
                    </p>
                </div>
            </div>
        </section>
        
        <!-- Packing List -->
        <section id="packing" class="guide-section">
            <div class="section-header">
                <div class="section-icon">🧳</div>
                <h2>Essential Packing List</h2>
            </div>
            
            <div class="packing-grid">
                <div class="packing-category">
                    <h4>📄 Documents</h4>
                    <ul class="packing-list">
                        <li>Passport (6+ months)</li>
                        <li>Travel insurance</li>
                        <li>Flight/train confirmations</li>
                        <li>2 credit/debit cards</li>
                        <li>€50-100 cash</li>
                    </ul>
                </div>
                
                <div class="packing-category">
                    <h4>👕 Clothing</h4>
                    <ul class="packing-list">
                        <li>Comfortable walking shoes</li>
                        <li>Layers for weather</li>
                        <li>Rain jacket/umbrella</li>
                        <li>1 nicer outfit</li>
                        <li>Scarf (for churches)</li>
                    </ul>
                </div>
                
                <div class="packing-category">
                    <h4>📱 Tech</h4>
                    <ul class="packing-list">
                        <li>Universal adapter</li>
                        <li>Power bank</li>
                        <li>Phone + charger</li>
                        <li>Offline maps</li>
                    </ul>
                </div>
                
                <div class="packing-category">
                    <h4>💊 Health</h4>
                    <ul class="packing-list">
                        <li>First-aid kit</li>
                        <li>Prescriptions</li>
                        <li>Hand sanitizer</li>
                        <li>Sunscreen</li>
                    </ul>
                </div>
            </div>
            
            <div style="background: #1e293b; color: white; border-radius: 16px; padding: 16px; margin-top: 24px;">
                <p style="display: flex; align-items: center; gap: 12px; font-size: 14px;">
                    <span style="font-size: 24px;">💡</span>
                    <span><strong>Pack light!</strong> A carry-on (40x55x20cm) is perfect for 7 days.</span>
                </p>
            </div>
        </section>
        
        <!-- FAQ -->
        <section id="faq" class="guide-section">
            <div class="section-header">
                <div class="section-icon">❓</div>
                <h2>FAQs</h2>
            </div>
            
            <div class="faq-grid">
                <div class="faq-item">
                    <div class="faq-question">Is 7 days enough for Europe?</div>
                    <div class="faq-answer">For 2-3 cities, absolutely! This itinerary focuses on one region.</div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">Book trains in advance?</div>
                    <div class="faq-answer">Yes! Book 2-3 months ahead for €29 fares vs €80 last minute.</div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">Best way to handle money?</div>
                    <div class="faq-answer">Use fee-free card (Revolut/Wise) + €50-100 cash backup.</div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">Can I add more cities?</div>
                    <div class="faq-answer">Not recommended. 3 cities in 7 days is perfect pace.</div>
                </div>
            </div>
        </section>
        
        <!-- Newsletter -->
        <section class="newsletter">
            <h3>Get More Travel Tips</h3>
            <p>Subscribe for exclusive itineraries, budget hacks, and destination guides.</p>
            
            <form class="newsletter-form">
                <input type="email" placeholder="Your email address" class="newsletter-input">
                <button type="submit" class="newsletter-btn">Subscribe</button>
            </form>
            
            <p style="font-size: 11px; margin-top: 16px; opacity: 0.6;">No spam, only travel inspo. Unsubscribe anytime.</p>
        </section>
        
        <!-- Related Guides -->
        <section class="guide-section">
            <div class="section-header">
                <div class="section-icon">📚</div>
                <h2>You Might Also Like</h2>
            </div>
            
            <div class="related-grid">
                <a href="europe-on-a-budget-2025.php" class="related-card">
                    <div class="related-icon">💰</div>
                    <div class="related-title">Europe on a Budget 2025</div>
                    <div class="related-desc">Daily costs for 40+ countries</div>
                    <div class="related-link">Read guide →</div>
                </a>
                
                <a href="cheapest-countries-europe.php" class="related-card">
                    <div class="related-icon">🏷️</div>
                    <div class="related-title">10 Cheapest Countries</div>
                    <div class="related-desc">Destinations from €30/day</div>
                    <div class="related-link">Read guide →</div>
                </a>
                
                <a href="/#budget-calculator" class="related-card">
                    <div class="related-icon">📊</div>
                    <div class="related-title">Budget Calculator</div>
                    <div class="related-desc">Calculate your trip cost</div>
                    <div class="related-link">Try now →</div>
                </a>
            </div>
        </section>
    </div>
</main>

<?php include 'includes/footer.php'; ?>

<script>
    // Toggle day details
    function toggleDay(header) {
        const content = header.nextElementSibling;
        const arrow = header.querySelector('.day-header-arrow');
        
        content.classList.toggle('active');
        header.classList.toggle('active');
        
        if (content.classList.contains('active')) {
            arrow.style.transform = 'rotate(180deg)';
        } else {
            arrow.style.transform = 'rotate(0deg)';
        }
    }
    
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
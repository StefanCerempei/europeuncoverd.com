<?php
require_once 'db/config.php';

// Get site settings if needed
$siteName = "Europe Uncovered";
$siteUrl = "https://europeuncovered.com";
$contactEmail = "contact@europeuncovered.com"; // Replace with your email
$lastUpdated = "March 15, 2025";
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    
    <!-- Google AdSense -->
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6865215291326132" crossorigin="anonymous"></script>
    <meta name="google-adsense-account" content="ca-pub-6865215291326132">

    <title>Privacy Policy - Europe Uncovered</title>

    <!-- VIEWPORT -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- DESCRIPTION -->
    <meta name="description" content="Privacy Policy for Europe Uncovered - Learn how we collect, use, and protect your personal information when you use our travel website.">

    <!-- CANONICAL -->
    <link rel="canonical" href="https://europeuncovered.com/privacy-policy.php">

    <!-- CSS -->
    <link rel="stylesheet" href="/assets/base.css">
    <link rel="stylesheet" href="/assets/header.css">
    <link rel="stylesheet" href="/assets/footer.css">
    <link rel="stylesheet" href="/assets/responsive.css">
    
    <style>
        /* Legal Pages Styling */
        .legal-page {
            max-width: 900px;
            margin: 40px auto;
            padding: 0 20px;
        }
        
        .legal-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .legal-header h1 {
            font-size: 36px;
            color: #2d3748;
            margin-bottom: 10px;
        }
        
        .legal-header .last-updated {
            color: #718096;
            font-size: 14px;
        }
        
        .legal-content {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            border: 1px solid #e9ecef;
            line-height: 1.7;
            color: #4a5568;
        }
        
        .legal-content h2 {
            color: #2d3748;
            font-size: 24px;
            margin: 30px 0 15px;
        }
        
        .legal-content h2:first-of-type {
            margin-top: 0;
        }
        
        .legal-content h3 {
            color: #2d3748;
            font-size: 20px;
            margin: 25px 0 10px;
        }
        
        .legal-content p {
            margin-bottom: 15px;
        }
        
        .legal-content ul, .legal-content ol {
            margin-bottom: 20px;
            padding-left: 20px;
        }
        
        .legal-content li {
            margin-bottom: 8px;
        }
        
        .legal-content a {
            color: #4299e1;
            text-decoration: none;
        }
        
        .legal-content a:hover {
            text-decoration: underline;
        }
        
        .legal-content .highlight-box {
            background: #f7fafc;
            border-left: 4px solid #4299e1;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
        }
        
        .legal-content table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        
        .legal-content th {
            background: #f7fafc;
            padding: 12px;
            text-align: left;
            font-weight: 600;
            color: #2d3748;
        }
        
        .legal-content td {
            padding: 12px;
            border-bottom: 1px solid #e2e8f0;
        }
        
        @media (max-width: 768px) {
            .legal-content {
                padding: 25px;
            }
            
            .legal-header h1 {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>

<?php include 'includes/header.php'; ?>

<main class="legal-page">
    <div class="legal-header">
        <h1>Privacy Policy</h1>
        <p class="last-updated">Last Updated: <?php echo $lastUpdated; ?></p>
    </div>
    
    <div class="legal-content">
        <div class="highlight-box">
            <strong>📌 Quick Summary:</strong> We respect your privacy and are committed to protecting your personal data. This policy explains how we collect, use, and safeguard your information when you use our website.
        </div>

        <h2>1. Introduction</h2>
        <p>Welcome to Europe Uncovered ("we," "our," or "us"). We are dedicated to providing accurate travel information and budget guides for Europe. This Privacy Policy explains how we handle your personal information when you visit our website at <?php echo $siteUrl; ?> (the "Site").</p>
        
        <p>By using our Site, you agree to the collection and use of information in accordance with this policy. If you do not agree with any part of this Privacy Policy, please do not use our Site.</p>

        <h2>2. Information We Collect</h2>
        
        <h3>2.1 Personal Information You Provide</h3>
        <p>We may collect personal information that you voluntarily provide to us when you:</p>
        <ul>
            <li><strong>Contact us:</strong> When you send us a message through our contact form, we collect your name, email address, and any information you include in your message.</li>
            <li><strong>Subscribe to newsletters:</strong> If we offer newsletters, we collect your email address.</li>
            <li><strong>Leave comments:</strong> If you comment on our articles, we collect your name and email address.</li>
        </ul>

        <h3>2.2 Automatically Collected Information</h3>
        <p>When you visit our Site, we automatically collect certain information about your device and usage, including:</p>
        <ul>
            <li><strong>Log Data:</strong> Your IP address, browser type, operating system, referring URLs, pages viewed, and time spent on our Site.</li>
            <li><strong>Device Information:</strong> Information about the device you're using, including device type and mobile network information.</li>
            <li><strong>Cookies and Similar Technologies:</strong> We use cookies and similar tracking technologies to enhance your experience. See our <a href="cookie-policy.php">Cookie Policy</a> for more details.</li>
        </ul>

        <h2>3. How We Use Your Information</h2>
        <p>We use the information we collect for the following purposes:</p>
        
        <table>
            <tr>
                <th>Purpose</th>
                <th>Legal Basis</th>
            </tr>
            <tr>
                <td>To provide and maintain our Site</td>
                <td>Legitimate interests</td>
            </tr>
            <tr>
                <td>To improve user experience and analyze Site usage</td>
                <td>Legitimate interests</td>
            </tr>
            <tr>
                <td>To respond to your inquiries and provide support</td>
                <td>Consent / Contract</td>
            </tr>
            <tr>
                <td>To display personalized advertisements (via Google AdSense)</td>
                <td>Consent</td>
            </tr>
            <tr>
                <td>To comply with legal obligations</td>
                <td>Legal obligation</td>
            </tr>
        </table>

        <h2>4. Google AdSense and Advertising</h2>
        <p>We use Google AdSense to display advertisements on our Site. Google AdSense uses cookies to serve ads based on your prior visits to our website or other websites. Google's use of advertising cookies enables it and its partners to serve ads to you based on your visit to our Site and/or other sites on the Internet.</p>

        <div class="highlight-box">
            <strong>🍪 Cookie Consent:</strong> We use a cookie consent banner that allows you to accept or reject non-essential cookies, including those used for advertising purposes.
        </div>

        <h3>4.1 Third-Party Vendors</h3>
        <ul>
            <li>Google, as a third-party vendor, uses cookies to serve ads on our Site.</li>
            <li>Google's use of the DART cookie enables it to serve ads to you based on your visit to our Site and other sites on the Internet.</li>
            <li>You may opt out of personalized advertising by visiting <a href="https://www.google.com/settings/ads" target="_blank" rel="nofollow">Google Ads Settings</a>.</li>
        </ul>

        <h3>4.2 Advertising Partners</h3>
        <p>We may work with the following advertising partners:</p>
        <ul>
            <li>Google AdSense (privacy policy: <a href="https://policies.google.com/privacy" target="_blank" rel="nofollow">https://policies.google.com/privacy</a>)</li>
        </ul>

        <h2>5. Cookies and Tracking Technologies</h2>
        <p>We use cookies and similar tracking technologies to track activity on our Site and hold certain information. For detailed information about the cookies we use, please visit our <a href="cookie-policy.php">Cookie Policy</a>.</p>

        <h3>Types of Cookies We Use:</h3>
        <ul>
            <li><strong>Essential Cookies:</strong> Necessary for the website to function properly.</li>
            <li><strong>Analytics Cookies:</strong> Help us understand how visitors interact with our Site.</li>
            <li><strong>Advertising Cookies:</strong> Used to deliver relevant advertisements.</li>
            <li><strong>Preference Cookies:</strong> Remember your settings and preferences.</li>
        </ul>

        <h2>6. Third-Party Links</h2>
        <p>Our Site may contain links to third-party websites that are not operated by us. If you click on a third-party link, you will be directed to that third party's site. We strongly advise you to review the Privacy Policy of every site you visit.</p>
        <p>We have no control over and assume no responsibility for the content, privacy policies, or practices of any third-party sites or services.</p>

        <h2>7. Data Security</h2>
        <p>We implement appropriate technical and organizational security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction. However, no method of transmission over the Internet or electronic storage is 100% secure, and we cannot guarantee absolute security.</p>

        <h2>8. Data Retention</h2>
        <p>We will retain your personal information only for as long as necessary for the purposes set out in this Privacy Policy. We will retain and use your information to the extent necessary to comply with our legal obligations, resolve disputes, and enforce our legal agreements and policies.</p>

        <h2>9. Your Data Protection Rights</h2>
        <p>Depending on your location, you may have the following rights regarding your personal data:</p>

        <h3>9.1 For EU Residents (GDPR)</h3>
        <ul>
            <li><strong>Right to access:</strong> You have the right to request copies of your personal data.</li>
            <li><strong>Right to rectification:</strong> You have the right to request correction of inaccurate information.</li>
            <li><strong>Right to erasure:</strong> You have the right to request deletion of your data under certain conditions.</li>
            <li><strong>Right to restrict processing:</strong> You have the right to request restriction of processing.</li>
            <li><strong>Right to data portability:</strong> You have the right to request transfer of your data.</li>
            <li><strong>Right to object:</strong> You have the right to object to our processing of your data.</li>
        </ul>

        <h3>9.2 For California Residents (CCPA)</h3>
        <ul>
            <li><strong>Right to know:</strong> You have the right to request disclosure of personal information collected.</li>
            <li><strong>Right to delete:</strong> You have the right to request deletion of personal information.</li>
            <li><strong>Right to opt-out:</strong> You have the right to opt-out of the sale of your personal information.</li>
            <li><strong>Right to non-discrimination:</strong> You have the right not to be discriminated against for exercising your rights.</li>
        </ul>

        <h3>9.3 How to Exercise Your Rights</h3>
        <p>To exercise any of these rights, please contact us at <a href="mailto:<?php echo $contactEmail; ?>"><?php echo $contactEmail; ?></a>. We will respond to your request within 30 days.</p>

        <h2>10. Children's Privacy</h2>
        <p>Our Site is not intended for children under 13 years of age. We do not knowingly collect personal information from children under 13. If you are a parent or guardian and believe your child has provided us with personal information, please contact us, and we will take steps to delete that information.</p>

        <h2>11. International Data Transfers</h2>
        <p>Your information may be transferred to and maintained on computers located outside of your state, province, country, or other governmental jurisdiction where data protection laws may differ. If you are located outside and choose to provide information to us, please note that we transfer the data to our servers in the European Union and the United States.</p>

        <h2>12. Changes to This Privacy Policy</h2>
        <p>We may update our Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page and updating the "Last Updated" date. You are advised to review this Privacy Policy periodically for any changes.</p>

        <h2>13. Contact Us</h2>
        <p>If you have any questions about this Privacy Policy, please contact us:</p>
        <ul>
            <li>By email: <a href="mailto:<?php echo $contactEmail; ?>"><?php echo $contactEmail; ?></a></li>
            <li>By visiting our <a href="contact.php">Contact Page</a></li>
        </ul>

        <div class="highlight-box" style="margin-top: 30px;">
            <p style="margin:0;"><strong>📧 Data Protection Officer:</strong> For privacy-specific inquiries, please email <a href="mailto:privacy@europeuncovered.com">privacy@europeuncovered.com</a></p>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>

</body>
</html>
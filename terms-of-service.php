<?php
require_once 'db/config.php';

$siteName = "Europe Uncovered";
$siteUrl = "https://europeuncovered.com";
$contactEmail = "contact@europeuncovered.com";
$lastUpdated = "March 15, 2025";
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    
    <!-- Google AdSense -->
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6865215291326132" crossorigin="anonymous"></script>
    <meta name="google-adsense-account" content="ca-pub-6865215291326132">

    <title>Terms of Service - Europe Uncovered</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Terms of Service for Europe Uncovered - Read our terms and conditions for using our travel website and services.">
    <link rel="canonical" href="https://europeuncovered.com/terms-of-service.php">
    
    <link rel="stylesheet" href="/assets/base.css">
    <link rel="stylesheet" href="/assets/header.css">
    <link rel="stylesheet" href="/assets/footer.css">
    <link rel="stylesheet" href="/assets/responsive.css">
    
    <style>
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
        
        .legal-content .warning-box {
            background: #fff5f5;
            border-left: 4px solid #f56565;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
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
        <h1>Terms of Service</h1>
        <p class="last-updated">Last Updated: <?php echo $lastUpdated; ?></p>
    </div>
    
    <div class="legal-content">
        <div class="highlight-box">
            <strong>📋 Please Read Carefully:</strong> By accessing or using Europe Uncovered, you agree to be bound by these Terms of Service. If you disagree with any part of these terms, please do not use our website.
        </div>

        <h2>1. Agreement to Terms</h2>
        <p>These Terms of Service constitute a legally binding agreement made between you, whether personally or on behalf of an entity ("you") and Europe Uncovered ("we," "us," or "our"), concerning your access to and use of the <?php echo $siteUrl; ?> website as well as any other media form, media channel, mobile website, or mobile application related, linked, or otherwise connected thereto (collectively, the "Site").</p>
        
        <p>You agree that by accessing the Site, you have read, understood, and agree to be bound by all of these Terms of Service. IF YOU DO NOT AGREE WITH ALL OF THESE TERMS OF SERVICE, THEN YOU ARE EXPRESSLY PROHIBITED FROM USING THE SITE AND YOU MUST DISCONTINUE USE IMMEDIATELY.</p>

        <h2>2. Intellectual Property Rights</h2>
        <p>Unless otherwise indicated, the Site is our proprietary property and all source code, databases, functionality, software, website designs, audio, video, text, photographs, and graphics on the Site (collectively, the "Content") and the trademarks, service marks, and logos contained therein (the "Marks") are owned or controlled by us or licensed to us, and are protected by copyright and trademark laws and various other intellectual property rights and unfair competition laws of the United States, foreign jurisdictions, and international conventions.</p>

        <h3>2.1 Content Usage</h3>
        <p>Provided that you are eligible to use the Site, you are granted a limited license to access and use the Site and to download or print a copy of any portion of the Content to which you have properly gained access solely for your personal, non-commercial use. We reserve all rights not expressly granted to you in and to the Site, the Content, and the Marks.</p>

        <div class="warning-box">
            <strong>⚠️ Prohibited Actions:</strong> You may not:
            <ul style="margin-top:10px;">
                <li>Copy, reproduce, distribute, or modify our content without written permission</li>
                <li>Use our content for commercial purposes without authorization</li>
                <li>Scrape, data mine, or extract content from our Site</li>
                <li>Remove any copyright or proprietary notices from our content</li>
            </ul>
        </div>

        <h2>3. User Representations</h2>
        <p>By using the Site, you represent and warrant that:</p>
        <ol>
            <li>All registration information you submit will be true, accurate, current, and complete.</li>
            <li>You will maintain the accuracy of such information and promptly update such information as necessary.</li>
            <li>You have the legal capacity and you agree to comply with these Terms of Service.</li>
            <li>You are not under the age of 13.</li>
            <li>You are not a minor in the jurisdiction in which you reside, or if a minor, you have received parental permission to use the Site.</li>
            <li>You will not access the Site through automated or non-human means, whether through a bot, script, or otherwise.</li>
            <li>You will not use the Site for any illegal or unauthorized purpose.</li>
            <li>Your use of the Site will not violate any applicable law or regulation.</li>
        </ol>

        <h2>4. Prohibited Activities</h2>
        <p>You may not access or use the Site for any purpose other than that for which we make the Site available. The Site may not be used in connection with any commercial endeavors except those that are specifically endorsed or approved by us.</p>

        <p>As a user of the Site, you agree not to:</p>
        <ul>
            <li>Systematically retrieve data or other content from the Site to create or compile, directly or indirectly, a collection, compilation, database, or directory without written permission from us.</li>
            <li>Trick, defraud, or mislead us and other users, especially in any attempt to learn sensitive account information such as user passwords.</li>
            <li>Circumvent, disable, or otherwise interfere with security-related features of the Site, including features that prevent or restrict the use or copying of any Content or enforce limitations on the use of the Site and/or the Content contained therein.</li>
            <li>Disparage, tarnish, or otherwise harm, in our opinion, us and/or the Site.</li>
            <li>Use any information obtained from the Site in order to harass, abuse, or harm another person.</li>
            <li>Make improper use of our support services or submit false reports of abuse or misconduct.</li>
            <li>Use the Site in a manner inconsistent with any applicable laws or regulations.</li>
            <li>Engage in unauthorized framing of or linking to the Site.</li>
            <li>Upload or transmit (or attempt to upload or to transmit) viruses, Trojan horses, or other material that interferes with any party's uninterrupted use and enjoyment of the Site.</li>
            <li>Engage in any automated use of the system, such as using scripts to send comments or messages.</li>
            <li>Delete the copyright or other proprietary rights notice from any Content.</li>
            <li>Attempt to impersonate another user or person or use the username of another user.</li>
            <li>Sell or otherwise transfer your profile.</li>
            <li>Interfere with, disrupt, or create an undue burden on the Site or the networks or services connected to the Site.</li>
            <li>Harass, annoy, intimidate, or threaten any of our employees or agents engaged in providing any portion of the Site to you.</li>
            <li>Attempt to bypass any measures of the Site designed to prevent or restrict access to the Site, or any portion of the Site.</li>
        </ul>

        <h2>5. User-Generated Contributions</h2>
        <p>The Site may invite you to chat, contribute to, or participate in blogs, message boards, online forums, and other functionality, and may provide you with the opportunity to create, submit, post, display, transmit, perform, publish, distribute, or broadcast content and materials to us or on the Site, including but not limited to text, writings, video, audio, photographs, graphics, comments, suggestions, or personal information or other material (collectively, "Contributions").</p>

        <h3>5.1 Contribution Guidelines</h3>
        <p>Any Contribution you transmit will be treated as non-confidential and non-proprietary. When you create or make available a Contribution, you thereby represent and warrant that:</p>
        <ul>
            <li>The creation, distribution, transmission, public display, or performance, and the accessing, downloading, or copying of your Contribution do not and will not infringe the proprietary rights, including but not limited to the copyright, patent, trademark, trade secret, or moral rights of any third party.</li>
            <li>You are the creator and owner of or have the necessary licenses, rights, consents, releases, and permissions to use and to authorize us, the Site, and other users of the Site to use your Contributions in any manner contemplated by the Site and these Terms of Service.</li>
            <li>You have the written consent, release, and/or permission of each and every identifiable individual person in your Contributions to use the name or likeness of each and every such identifiable individual person to enable inclusion and use of your Contributions in any manner contemplated by the Site and these Terms of Service.</li>
            <li>Your Contributions are not false, inaccurate, or misleading.</li>
            <li>Your Contributions are not unsolicited or unauthorized advertising, promotional materials, pyramid schemes, chain letters, spam, mass mailings, or other forms of solicitation.</li>
            <li>Your Contributions are not obscene, lewd, lascivious, filthy, violent, harassing, libelous, slanderous, or otherwise objectionable (as determined by us).</li>
            <li>Your Contributions do not ridicule, mock, disparage, intimidate, or abuse anyone.</li>
            <li>Your Contributions do not advocate the violent overthrow of any government or incite, encourage, or threaten physical harm against another.</li>
            <li>Your Contributions do not violate any applicable law, regulation, or rule.</li>
            <li>Your Contributions do not violate the privacy or publicity rights of any third party.</li>
        </ul>

        <h2>6. Copyright Infringement</h2>
        <p>We respect the intellectual property rights of others. If you believe that any material available on or through the Site infringes upon any copyright you own or control, please immediately notify our Designated Copyright Agent using the contact information provided below (a "Notification").</p>
        
        <p>A copy of your Notification will be sent to the person who posted or stored the material addressed in the Notification. Please be advised that pursuant to applicable law you may be held liable for damages if you make material misrepresentations in a Notification. Thus, if you are not sure that material located on or linked to by the Site infringes your copyright, you should consider first contacting an attorney.</p>

        <h2>7. Termination</h2>
        <p>We may terminate or suspend your account and bar access to the Site immediately, without prior notice or liability, under our sole discretion, for any reason whatsoever and without limitation, including but not limited to a breach of the Terms.</p>
        
        <p>If you wish to terminate your account, you may simply discontinue using the Site.</p>
        
        <p>All provisions of the Terms which by their nature should survive termination shall survive termination, including, without limitation, ownership provisions, warranty disclaimers, indemnity, and limitations of liability.</p>

        <h2>8. Disclaimer of Warranties</h2>
        <p>THE SITE IS PROVIDED ON AN "AS-IS" AND "AS AVAILABLE" BASIS. YOU AGREE THAT YOUR USE OF THE SITE AND OUR SERVICES WILL BE AT YOUR SOLE RISK. TO THE FULLEST EXTENT PERMITTED BY LAW, WE DISCLAIM ALL WARRANTIES, EXPRESS OR IMPLIED, IN CONNECTION WITH THE SITE AND YOUR USE THEREOF, INCLUDING, WITHOUT LIMITATION, THE IMPLIED WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, AND NON-INFRINGEMENT. WE MAKE NO WARRANTIES OR REPRESENTATIONS ABOUT THE ACCURACY OR COMPLETENESS OF THE SITE'S CONTENT OR THE CONTENT OF ANY WEBSITES LINKED TO THE SITE AND WE WILL ASSUME NO LIABILITY OR RESPONSIBILITY FOR ANY:</p>
        <ol>
            <li>ERRORS, MISTAKES, OR INACCURACIES OF CONTENT AND MATERIALS,</li>
            <li>PERSONAL INJURY OR PROPERTY DAMAGE, OF ANY NATURE WHATSOEVER, RESULTING FROM YOUR ACCESS TO AND USE OF THE SITE,</li>
            <li>ANY UNAUTHORIZED ACCESS TO OR USE OF OUR SECURE SERVERS AND/OR ANY AND ALL PERSONAL INFORMATION AND/OR FINANCIAL INFORMATION STORED THEREIN,</li>
            <li>ANY INTERRUPTION OR CESSATION OF TRANSMISSION TO OR FROM THE SITE,</li>
            <li>ANY BUGS, VIRUSES, TROJAN HORSES, OR THE LIKE WHICH MAY BE TRANSMITTED TO OR THROUGH THE SITE BY ANY THIRD PARTY, AND/OR</li>
            <li>ANY ERRORS OR OMISSIONS IN ANY CONTENT AND MATERIALS OR FOR ANY LOSS OR DAMAGE OF ANY KIND INCURRED AS A RESULT OF THE USE OF ANY CONTENT POSTED, TRANSMITTED, OR OTHERWISE MADE AVAILABLE VIA THE SITE.</li>
        </ol>

        <h2>9. Limitation of Liability</h2>
        <p>IN NO EVENT WILL WE OR OUR DIRECTORS, EMPLOYEES, OR AGENTS BE LIABLE TO YOU OR ANY THIRD PARTY FOR ANY DIRECT, INDIRECT, CONSEQUENTIAL, EXEMPLARY, INCIDENTAL, SPECIAL, OR PUNITIVE DAMAGES, INCLUDING LOST PROFIT, LOST REVENUE, LOSS OF DATA, OR OTHER DAMAGES ARISING FROM YOUR USE OF THE SITE, EVEN IF WE HAVE BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES.</p>

        <h2>10. Indemnification</h2>
        <p>You agree to defend, indemnify, and hold us harmless, including our subsidiaries, affiliates, and all of our respective officers, agents, partners, and employees, from and against any loss, damage, liability, claim, or demand, including reasonable attorneys' fees and expenses, made by any third party due to or arising out of: (1) your Contributions; (2) use of the Site; (3) breach of these Terms of Service; (4) any breach of your representations and warranties set forth in these Terms of Service; (5) your violation of the rights of a third party, including but not limited to intellectual property rights; or (6) any overt harmful act toward any other user of the Site with whom you connected via the Site. Notwithstanding the foregoing, we reserve the right, at your expense, to assume the exclusive defense and control of any matter for which you are required to indemnify us, and you agree to cooperate, at your expense, with our defense of such claims. We will use reasonable efforts to notify you of any such claim, action, or proceeding which is subject to this indemnification upon becoming aware of it.</p>

        <h2>11. User Data</h2>
        <p>We will maintain certain data that you transmit to the Site for the purpose of managing the performance of the Site, as well as data relating to your use of the Site. Although we perform regular routine backups of data, you are solely responsible for all data that you transmit or that relates to any activity you have undertaken using the Site. You agree that we shall have no liability to you for any loss or corruption of any such data, and you hereby waive any right of action against us arising from any such loss or corruption of such data.</p>

        <h2>12. Electronic Communications, Transactions, and Signatures</h2>
        <p>Visiting the Site, sending us emails, and completing online forms constitute electronic communications. You consent to receive electronic communications, and you agree that all agreements, notices, disclosures, and other communications we provide to you electronically, via email and on the Site, satisfy any legal requirement that such communication be in writing. YOU HEREBY AGREE TO THE USE OF ELECTRONIC SIGNATURES, CONTRACTS, ORDERS, AND OTHER RECORDS, AND TO ELECTRONIC DELIVERY OF NOTICES, POLICIES, AND RECORDS OF TRANSACTIONS INITIATED OR COMPLETED BY US OR VIA THE SITE.</p>

        <h2>13. California Users and Residents</h2>
        <p>If any complaint with us is not satisfactorily resolved, you can contact the Complaint Assistance Unit of the Division of Consumer Services of the California Department of Consumer Affairs in writing at 1625 North Market Blvd., Suite N 112, Sacramento, California 95834 or by telephone at (800) 952-5210 or (916) 445-1254.</p>

        <h2>14. Governing Law</h2>
        <p>These Terms shall be governed and construed in accordance with the laws of [Your Country/State], without regard to its conflict of law provisions.</p>
        
        <p>Our failure to enforce any right or provision of these Terms will not be considered a waiver of those rights. If any provision of these Terms is held to be invalid or unenforceable by a court, the remaining provisions of these Terms will remain in effect. These Terms constitute the entire agreement between us regarding our Site and supersede and replace any prior agreements we might have had between us regarding the Site.</p>

        <h2>15. Changes to Terms</h2>
        <p>We reserve the right, at our sole discretion, to modify or replace these Terms at any time. If a revision is material, we will try to provide at least 30 days' notice prior to any new terms taking effect. What constitutes a material change will be determined at our sole discretion.</p>
        
        <p>By continuing to access or use our Site after any revisions become effective, you agree to be bound by the revised terms. If you do not agree to the new terms, you are no longer authorized to use the Site.</p>

        <h2>16. Contact Us</h2>
        <p>If you have any questions about these Terms of Service, please contact us:</p>
        <ul>
            <li>By email: <a href="mailto:<?php echo $contactEmail; ?>"><?php echo $contactEmail; ?></a></li>
            <li>By visiting our <a href="contact.php">Contact Page</a></li>
        </ul>

        <div class="highlight-box" style="margin-top: 30px;">
            <p style="margin:0;"><strong>📬 Legal Address:</strong><br>
            Europe Uncovered<br>
            [Your Street Address]<br>
            [City, Postal Code]<br>
            [Country]</p>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>

</body>
</html>
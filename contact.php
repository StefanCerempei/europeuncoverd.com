<?php
require_once 'db/config.php';

$siteName = "Europe Uncovered";
$contactEmail = "contact@europeuncovered.com";
$successMessage = "";
$errorMessage = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';
    
    // Basic validation
    $errors = [];
    if (empty($name)) $errors[] = "Name is required";
    if (empty($email)) $errors[] = "Email is required";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required";
    if (empty($message)) $errors[] = "Message is required";
    
    // Honeypot for spam
    $honeypot = isset($_POST['website']) ? $_POST['website'] : '';
    if (!empty($honeypot)) {
        // Likely a bot - silently fail
        $successMessage = "Thank you for your message. We'll get back to you soon.";
    } else if (empty($errors)) {
        // Send email
        $to = $contactEmail;
        $email_subject = "Contact Form: " . $subject;
        $email_body = "You have received a new message from the contact form on your website.\n\n";
        $email_body .= "Name: $name\n";
        $email_body .= "Email: $email\n";
        $email_body .= "Subject: $subject\n";
        $email_body .= "Message:\n$message\n";
        
        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        
        if (mail($to, $email_subject, $email_body, $headers)) {
            $successMessage = "Thank you for contacting us! We'll get back to you within 48 hours.";
        } else {
            $errorMessage = "Sorry, there was an error sending your message. Please try again later.";
        }
    } else {
        $errorMessage = implode("<br>", $errors);
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    
    <!-- Google AdSense -->
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6865215291326132" crossorigin="anonymous"></script>
    <meta name="google-adsense-account" content="ca-pub-6865215291326132">

    <title>Contact Us - Europe Uncovered</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Contact Europe Uncovered - Get in touch with our team for questions, suggestions, or partnerships.">
    <link rel="canonical" href="https://europeuncovered.com/contact.php">
    
    <link rel="stylesheet" href="/assets/base.css">
    <link rel="stylesheet" href="/assets/header.css">
    <link rel="stylesheet" href="/assets/footer.css">
    <link rel="stylesheet" href="/assets/responsive.css">
    
    <style>
        .contact-page {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }
        
        .contact-header {
            text-align: center;
            margin-bottom: 50px;
        }
        
        .contact-header h1 {
            font-size: 42px;
            color: #2d3748;
            margin-bottom: 15px;
        }
        
        .contact-header .subtitle {
            font-size: 18px;
            color: #718096;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 40px;
        }
        
        .contact-info-section {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            border: 1px solid #e9ecef;
        }
        
        .contact-info-section h2 {
            color: #2d3748;
            font-size: 24px;
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 10px;
        }
        
        .contact-info-section h2:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: #4299e1;
        }
        
        .contact-method {
            display: flex;
            align-items: flex-start;
            margin-bottom: 25px;
            padding: 15px;
            background: #f8fafc;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
        }
        
        .contact-icon {
            width: 50px;
            height: 50px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 24px;
            border: 1px solid #e2e8f0;
        }
        
        .contact-details {
            flex: 1;
        }
        
        .contact-details strong {
            display: block;
            color: #2d3748;
            font-size: 16px;
            margin-bottom: 5px;
        }
        
        .contact-details span, .contact-details a {
            color: #718096;
            font-size: 14px;
            line-height: 1.6;
            text-decoration: none;
        }
        
        .contact-details a:hover {
            color: #4299e1;
            text-decoration: underline;
        }
        
        .faq-preview {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
        }
        
        .faq-item {
            margin-bottom: 15px;
        }
        
        .faq-question {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 5px;
        }
        
        .faq-answer {
            color: #718096;
            font-size: 14px;
        }
        
        .contact-form-section {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            border: 1px solid #e9ecef;
        }
        
        .contact-form-section h2 {
            color: #2d3748;
            font-size: 24px;
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 10px;
        }
        
        .contact-form-section h2:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: #4299e1;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #4a5568;
            font-size: 14px;
        }
        
        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
            font-family: inherit;
        }
        
        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #4299e1;
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
        }
        
        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        
        .honeypot {
            display: none;
        }
        
        .submit-btn {
            width: 100%;
            padding: 15px;
            background-color: #4299e1;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }
        
        .submit-btn:hover {
            background-color: #3182ce;
        }
        
        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        .alert-success {
            background: #c6f6d5;
            border: 1px solid #9ae6b4;
            color: #22543d;
        }
        
        .alert-error {
            background: #fed7d7;
            border: 1px solid #fc8181;
            color: #742a2a;
        }
        
        .map-section {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            border: 1px solid #e9ecef;
            margin-top: 30px;
        }
        
        .map-placeholder {
            background: #f8fafc;
            border-radius: 12px;
            padding: 60px 20px;
            text-align: center;
            border: 2px dashed #e2e8f0;
            color: #a0aec0;
        }
        
        @media (max-width: 768px) {
            .contact-grid {
                grid-template-columns: 1fr;
            }
            
            .contact-header h1 {
                font-size: 32px;
            }
            
            .form-row {
                grid-template-columns: 1fr;
            }
            
            .contact-info-section,
            .contact-form-section {
                padding: 25px;
            }
        }
    </style>
</head>
<body>

<?php include 'includes/header.php'; ?>

<main class="contact-page">
    <div class="contact-header">
        <h1>Contact Us</h1>
        <p class="subtitle">Have questions, suggestions, or just want to say hello? We'd love to hear from you!</p>
    </div>
    
    <div class="contact-grid">
        <!-- Contact Information -->
        <div class="contact-info-section">
            <h2>Get in Touch</h2>
            
            <div class="contact-method">
                <div class="contact-icon">📧</div>
                <div class="contact-details">
                    <strong>Email</strong>
                    <span><a href="mailto:<?php echo $contactEmail; ?>"><?php echo $contactEmail; ?></a></span>
                    <span style="display:block; margin-top:5px;">We typically respond within 24-48 hours</span>
                </div>
            </div>
            
            <div class="contact-method">
                <div class="contact-icon">💬</div>
                <div class="contact-details">
                    <strong>General Inquiries</strong>
                    <span>Questions about our content, partnerships, or media inquiries</span>
                </div>
            </div>
            
            <div class="contact-method">
                <div class="contact-icon">🔒</div>
                <div class="contact-details">
                    <strong>Privacy & Legal</strong>
                    <span>For privacy-related questions: <a href="mailto:privacy@europeuncovered.com">privacy@europeuncovered.com</a></span>
                </div>
            </div>
            
            <div class="contact-method">
                <div class="contact-icon">📱</div>
                <div class="contact-details">
                    <strong>Social Media</strong>
                    <span>
                        <a href="https://instagram.com/web.dev.md" target="_blank" rel="nofollow">Instagram</a>
                    </span>
                </div>
            </div>
            
            <div class="faq-preview">
                <h3 style="margin-bottom:15px;">Frequently Asked Questions</h3>
                
                <div class="faq-item">
                    <div class="faq-question">How accurate are your budget estimates?</div>
                    <div class="faq-answer">Our budgets are based on real traveler data from 2024-2025 and updated quarterly.</div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">Can I contribute my travel data?</div>
                    <div class="faq-answer">Yes! We welcome user contributions. Use the form to share your experiences.</div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">Do you accept guest posts?</div>
                    <div class="faq-answer">We occasionally accept guest posts. Please email us with your proposal.</div>
                </div>
            </div>
        </div>
        
        <!-- Contact Form -->
        <div class="contact-form-section">
            <h2>Send a Message</h2>
            
            <?php if ($successMessage): ?>
                <div class="alert alert-success"><?php echo $successMessage; ?></div>
            <?php endif; ?>
            
            <?php if ($errorMessage): ?>
                <div class="alert alert-error"><?php echo $errorMessage; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <!-- Honeypot field for spam prevention -->
                <div class="honeypot">
                    <label for="website">Website (leave empty)</label>
                    <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="name">Your Name *</label>
                        <input type="text" id="name" name="name" required value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email Address *</label>
                        <input type="email" id="email" name="email" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="subject">Subject</label>
                    <select id="subject" name="subject">
                        <option value="General Question">General Question</option>
                        <option value="Budget Question">Budget Question</option>
                        <option value="Country Guide Suggestion">Country Guide Suggestion</option>
                        <option value="Partnership Opportunity">Partnership Opportunity</option>
                        <option value="Report Issue">Report an Issue</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="message">Your Message *</label>
                    <textarea id="message" name="message" required><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>
                </div>
                
                <button type="submit" class="submit-btn">Send Message</button>
                
                <p style="font-size:12px; color:#a0aec0; margin-top:15px; text-align:center;">
                    By submitting this form, you agree to our 
                    <a href="privacy-policy.php" style="color:#4299e1;">Privacy Policy</a>
                </p>
            </form>
        </div>
    </div>
    
    <!-- Map / Location Section (Optional) -->
    <div class="map-section">
        <h2 style="margin-bottom:20px;">📍 Our Location</h2>
        <div class="map-placeholder">
            <p style="margin-bottom:10px;">🌍 Europe Uncovered is based in Romania, serving travelers worldwide.</p>
            <p style="font-size:14px;">We're a remote team spread across Europe, passionate about helping you explore this beautiful continent.</p>
        </div>
    </div>
    
    <!-- Response Times -->
    <div style="background:#f8fafc; border-radius:15px; padding:25px; margin-top:30px; text-align:center; border:1px solid #e2e8f0;">
        <h3 style="color:#2d3748; margin-bottom:10px;">⏱️ Response Times</h3>
        <p style="color:#718096;">We aim to respond to all inquiries within 24-48 hours during weekdays. For urgent matters, please include "URGENT" in your subject line.</p>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
<script>
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
</script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - Frequently Asked Questions</title>
    <style>
        /* General styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        
        body {
            background-color: #f9f9f9;
        }
        
        /* Header styles */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background-color: white;
            border-bottom: 1px solid #e5e5e5;
        }
        
        .logo {
            max-height: 50px;
        }
        
        .search-container {
            flex: 0 1 400px;
        }
        
        .search-input {
            width: 100%;
            padding: 10px 15px;
            border-radius: 20px;
            border: none;
            background-color: #f2f2f2;
        }
        
        .nav-links {
            display: flex;
            gap: 20px;
        }
        
        .nav-links a {
            text-decoration: none;
            color: #666;
        }
        
        .cart-button {
            background-color: #1e525b;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }
        
        /* Main content */
        .main-title {
            text-align: center;
            padding: 40px 0;
            font-size: 28px;
            color: #1e525b;
            background-color: white;
            border-bottom: 1px solid #e5e5e5;
        }
        
        .faq-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 0 20px;
        }
        
        .faq-item {
            margin-bottom: 15px;
            border-radius: 8px;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .faq-question {
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            font-weight: 500;
            color: #1e525b;
        }
        
        .faq-question .icon {
            width: 24px;
            height: 24px;
            color: #9370db;
        }
        
        .faq-answer {
            padding: 0 20px 20px 20px;
            display: none;
            color: #555;
            line-height: 1.5;
        }
        
        .active .faq-answer {
            display: block;
        }
        
        /* Footer */
        .footer {
            background-color: #1e525b;
            color: white;
            padding: 50px 20px;
            margin-top: 40px;
        }
        
        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
        }
        
        .footer-column {
            flex: 1;
            margin-right: 20px;
        }
        
        .footer-title {
            margin-bottom: 20px;
            font-size: 18px;
            border-bottom: 2px solid #2a7382;
            padding-bottom: 10px;
        }
        
        .footer-links {
            list-style: none;
        }
        
        .footer-links li {
            margin-bottom: 12px;
        }
        
        .footer-links a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        
        .footer-links a:before {
            content: "•";
            margin-right: 10px;
        }
    </style>
</head>
<body>    
    <!-- Main FAQ Section -->
    <h1 class="main-title">PALING SERING DITANYAKAN</h1>
    
    <div class="faq-container">
    <?php if(empty($faqs)): ?>
        <div class="no-faqs">
            <p>No FAQs available at the moment.</p>
        </div>
    <?php else: ?>
        <?php foreach($faqs as $index => $faq): ?>
            <div class="faq-item <?php echo ($index === 2) ? 'active' : ''; ?>">
                <div class="faq-question">
                    <?php echo $faq->question; ?>
                    
                    <?php if($index === 2): ?>
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: #9370db;">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                    <?php else: ?>
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    <?php endif; ?>
                </div>
                <div class="faq-answer">
                    <?php echo $faq->answer; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
    
    <script>
        // JavaScript to toggle FAQ answers
        document.querySelectorAll('.faq-question').forEach(question => {
            question.addEventListener('click', () => {
                const faqItem = question.parentElement;
                faqItem.classList.toggle('active');
            });
        });
    </script>
</body>
</html>
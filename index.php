<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<?php
$pageTitle = "DriveN School | Drive with Confidence";

$courses = [
    ["01", "Beginner Driving", "Build confidence with step-by-step driving lessons.", "Beginner"],
    ["02", "Road Test Preparation", "Practice essential skills before your road test.", "Test Prep"],
    ["03", "Defensive Driving", "Learn safer driving habits and road awareness.", "Safety"],
];

$packages = [
    ["Starter", "3 Lessons", "Perfect for getting started", "149"],
    ["Popular", "6 Lessons", "Build skills and confidence", "279"],
    ["Complete", "10 Lessons", "More practice, more confidence", "449"],
];
$selectedPackage = strtolower($_GET['package'] ?? '');

$allowedPackages = [
    'basic' => 'Basic Package',
    'standard' => 'Standard Package',
    'individual' => 'Individual Lessons',
    'custom' => 'Custom Package',
];

$selectedPackageName = $allowedPackages[$selectedPackage] ?? '';
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Learn to drive with confidence at DriveN School. Explore driving lessons, road test preparation and flexible lesson packages.">
    <title><?= htmlspecialchars($pageTitle) ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >
    
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <?php require_once __DIR__ . '/includes/navbar.php'; ?>

    <header class="hero" id="home">
        <div class="hero-overlay"></div>
        <div class="container hero-content">
            <div class="row align-items-center min-vh-100">
                <div class="col-lg-7">
                    <div class="eyebrow"><span></span> YOUR JOURNEY STARTS HERE</div>
                    <h1>Learn to Drive.<br>Drive with <span>Confidence.</span></h1>
                    <p class="hero-description">
                        Professional driving lessons, patient instructors and a
                        learning experience designed around you.
                    </p>
                    <div class="d-flex flex-wrap gap-3 mt-4">
                        <a href="#packages" class="btn btn-gold btn-lg">Explore Packages <span>↗</span></a>
                        <a href="#lessons" class="btn btn-outline-light btn-lg">Explore Lessons</a>
                    </div>
                    <div class="hero-proof mt-5">
                        <div class="avatar-stack">
                            <span>A</span><span>M</span><span>J</span>
                        </div>
                        <div><strong>Learn at your own pace</strong><small>Friendly guidance. Safer driving.</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 d-none d-lg-block">
                    <div class="hero-card">
                        <div class="hero-card-icon">✦</div>
                        <p>YOUR NEXT CHAPTER</p>
                        <h3>Freedom begins<br>behind the wheel.</h3>
                        <a href="#contact">Start learning <span>↗</span></a>
                    </div>
                </div>
            </div>
        </div>
        <a href="#lessons" class="scroll-cue">SCROLL TO EXPLORE ↓</a>
    </header>

    <section class="trust-strip">
        <div class="container">
            <div class="row text-center g-4">
                <div class="col-6 col-lg-3"><strong>01</strong><span>Patient Instructors</span></div>
                <div class="col-6 col-lg-3"><strong>02</strong><span>Flexible Scheduling</span></div>
                <div class="col-6 col-lg-3"><strong>03</strong><span>Safety First</span></div>
                <div class="col-6 col-lg-3"><strong>04</strong><span>Personalized Lessons</span></div>
            </div>
        </div>
    </section>

    <section class="section-padding" id="lessons">
        <div class="container">
            <div class="section-heading">
                <div>
                    <div class="eyebrow dark-eyebrow">WHAT WE OFFER</div>
                    <h2>Find the right lesson<br>for <span>your journey.</span></h2>
                </div>
                <p>From your first time behind the wheel to preparing for a road test, learn with a plan that fits your
                    needs.</p>
            </div>

            <div class="row g-4 mt-3">
                <?php foreach ($courses as $course): ?>
                <div class="col-md-6 col-lg-4">
                    <article class="course-card">
                        <div class="course-number"><?= htmlspecialchars($course[0]) ?></div>
                        <span class="course-tag"><?= htmlspecialchars($course[3]) ?></span>
                        <div class="course-icon">↗</div>
                        <h3><?= htmlspecialchars($course[1]) ?></h3>
                        <p><?= htmlspecialchars($course[2]) ?></p>
                        <a href="#contact" class="text-link">Learn more <span>↗</span></a>
                    </article>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="about-section section-padding" id="about">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <div class="about-image">
                        <img src="https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?auto=format&fit=crop&w=1100&q=85"
                            alt="Driver learning inside a car" loading="lazy">
                        <div class="image-label"><strong>DriveN School</strong><span>Your confidence is our
                                priority.</span></div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="eyebrow dark-eyebrow">ABOUT DRIVEN</div>
                    <h2>A better way to<br>learn <span>the road.</span></h2>
                    <p class="body-copy">Learning to drive should feel exciting, not overwhelming. Our learning approach
                        focuses on building confidence, practical skills and responsible road habits, one lesson at a
                        time.</p>
                    <div class="feature-list">
                        <div><span>✓</span>
                            <p><strong>Personalized learning</strong><small>Lessons that match your current skill
                                    level.</small></p>
                        </div>
                        <div><span>✓</span>
                            <p><strong>Safety-focused practice</strong><small>Build awareness and good driving
                                    habits.</small></p>
                        </div>
                        <div><span>✓</span>
                            <p><strong>Support at every step</strong><small>Clear guidance from start to finish.</small>
                            </p>
                        </div>
                    </div>
                    <a href="#contact" class="btn btn-navy mt-3">Meet Your Next Milestone ↗</a>
                </div>
            </div>
        </div>
    </section>

    <section class="packages-section section-padding" id="packages">
        <div class="container">
            <div class="section-heading light-heading">
                <div>
                    <div class="eyebrow">SIMPLE, FLEXIBLE OPTIONS</div>
                    <h2>Choose your <span>package.</span></h2>
                </div>
                <p>Start with a few lessons or choose a longer learning plan. Find the option that works for you.</p>
            </div>
            <div class="row g-4 mt-3">
                <?php foreach ($packages as $index => $package): ?>
                <div class="col-md-4">
                    <article class="package-card <?= $index === 1 ? 'featured-package' : '' ?>">
                        <?php if ($index === 1): ?><div class="popular-label">MOST POPULAR</div><?php endif; ?>
                        <p class="package-name"><?= htmlspecialchars($package[0]) ?></p>
                        <h3><?= htmlspecialchars($package[1]) ?></h3>
                        <p class="package-description"><?= htmlspecialchars($package[2]) ?></p>
                        <div class="package-price">
                            <sup>$</sup>
                            <span><?= htmlspecialchars($package[3]) ?></span>
                            <small>/ package</small>
                        </div>
                        <hr>
                        <ul>
                            <li>✓ Personalized lesson plan</li>
                            <li>✓ Instructor guidance</li>
                            <li>✓ Practical driving skills</li>
                        </ul>
                        <a href="#contact"
                            class="btn <?= $index === 1 ? 'btn-gold' : 'btn-outline-light' ?> w-100">Choose Package
                            ↗</a>
                    </article>
                </div>
                <?php endforeach; ?>
            </div>
            <p class="price-note">Demo prices for design preview only. Confirm real prices, currency, lesson duration
                and local requirements before accepting bookings.</p>
        </div>
    </section>

    <section class="section-padding process-section">
        <div class="container">
            <div class="section-heading">
                <div>
                    <div class="eyebrow dark-eyebrow">HOW IT WORKS</div>
                    <h2>Three steps to<br><span>get moving.</span></h2>
                </div>
            </div>
            <div class="row g-4 mt-3">
                <div class="col-md-4">
                    <div class="process-card"><span>01</span>
                        <h3>Choose your lesson</h3>
                        <p>Explore lesson types and select a suitable package.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="process-card"><span>02</span>
                        <h3>Request a booking</h3>
                        <p>Share your details and preferred lesson time.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="process-card"><span>03</span>
                        <h3>Build your confidence</h3>
                        <p>Practice your skills and progress at your pace.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="reviews-section section-padding" id="reviews">
        <div class="container">
            <div class="eyebrow dark-eyebrow">THE LEARNING EXPERIENCE</div>
            <h2>Confidence looks good <span>on you.</span></h2>
            <div class="review-box mt-4">
                <div class="review-stars">★★★★★</div>
                <blockquote id="reviewText">“A great learning experience starts with patience, clear guidance and time
                    to practice.”</blockquote>
                <p id="reviewAuthor">— The DriveN School promise</p>
                <div class="review-controls">
                    <button type="button" id="prevReview" aria-label="Previous review">←</button>
                    <button type="button" id="nextReview" aria-label="Next review">→</button>
                </div>
            </div>
            <p class="price-note">The text above is sample website copy, not a real customer testimonial.</p>
        </div>
    </section>

    <section class="faq-section section-padding">
        <div class="container">
            <div class="section-heading">
                <div>
                    <div class="eyebrow dark-eyebrow">COMMON QUESTIONS</div>
                    <h2>Good to know<br><span>before you start.</span></h2>
                </div>
            </div>
            <div class="accordion mt-4" id="faqAccordion">
                <?php
            $faqs = [
                ["Do I need driving experience?", "No. Beginner lessons can start with the basics. Your actual eligibility depends on local licensing rules."],
                ["Can I choose my lesson time?", "You can request a preferred time. Final availability must be confirmed by the school."],
                ["How do I choose a package?", "Consider your experience, goals and instructor advice before selecting a suitable package."],
                ["Can I prepare for a road test?", "Road-test preparation can focus on practical driving skills and applicable local road rules."]
            ];
            foreach ($faqs as $i => $faq):
            ?>
                <div class="accordion-item">
                    <h3 class="accordion-header">
                        <button class="accordion-button <?= $i ? 'collapsed' : '' ?>" type="button"
                            data-bs-toggle="collapse" data-bs-target="#faq<?= $i ?>"
                            aria-expanded="<?= $i === 0 ? 'true' : 'false' ?>">
                            <?= htmlspecialchars($faq[0]) ?>
                        </button>
                    </h3>
                    <div id="faq<?= $i ?>" class="accordion-collapse collapse <?= $i === 0 ? 'show' : '' ?>"
                        data-bs-parent="#faqAccordion">
                        <div class="accordion-body"><?= htmlspecialchars($faq[1]) ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- <section class="contact-section section-padding" id="contact">
        <div class="container">
            <div class="contact-panel">
                <div class="row align-items-center g-4">
                    <div class="col-lg-7">
                        <div class="eyebrow">READY WHEN YOU ARE</div>
                        <h2>Your next journey<br>starts <span>with one step.</span></h2>
                        <p>Send a booking request and take the first step toward driving with confidence.</p>
                    </div>
                    <div class="col-lg-5 text-lg-end">
                        <a href="booking.php" class="btn btn-gold btn-lg">Request a Lesson ↗</a>
                        <p class="small mt-3 mb-0">Booking system will be connected to PHP and MySQL in the next step.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section> -->

    <?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!empty($_SESSION["contact_success"])):
?>
    <div class="alert alert-success" role="status">
        <?= htmlspecialchars($_SESSION["contact_success"]) ?>
    </div>
    <?php
    unset($_SESSION["contact_success"]);
endif;

if (!empty($_SESSION["contact_errors"])):
?>
    <div class="alert alert-danger" role="alert">
        <?php foreach ($_SESSION["contact_errors"] as $error): ?>
        <p class="mb-1"><?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>
    </div>
    <?php
    unset($_SESSION["contact_errors"]);
endif;
?>
    <!-- Contact Section -->
    <section class="contact-section section-padding" id="contact">
        <div class="container">
            <div class="contact-heading">
                <span class="eyebrow">GET IN TOUCH</span>
                <h2>Ready to start your <span>driving journey?</span></h2>
                <p>Have questions or want to book a lesson? Send us a message and our team will help you get started.
                </p>
            </div>

            <div class="row g-4 mt-4">
                <!-- Contact Information -->
                <div class="col-lg-5">
                    <div class="contact-info">
                        <h3>Let's talk.</h3>
                        <p>We're here to help you become a confident and safe driver.</p>

                        <div class="contact-item">
                            <div class="contact-icon">☎</div>
                            <div>
                                <h5>Call Us</h5>
                                <p>Add your official phone number</p>
                            </div>
                        </div>

                        <div class="contact-item">
                            <div class="contact-icon">✉</div>
                            <div>
                                <h5>Email Us</h5>
                                <p>Add your official email address</p>
                            </div>
                        </div>

                        <div class="contact-item">
                            <div class="contact-icon">⌖</div>
                            <div>
                                <h5>Our Location</h5>
                                <p>Add your driving school's address</p>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Contact Form -->
                <div class="col-lg-7">
                    <div class="contact-form-card">
                        <h3>Send us a message</h3>
                        <p>Fill out the form below and we'll get back to you.</p>

                        <form action="process-contact.php" method="post" id="contactForm">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="contactName">Full Name</label>
                                    <input type="text" id="contactName" name="name" placeholder="Your full name"
                                        required>
                                </div>

                                <div class="col-md-6">
                                    <label for="contactEmail">Email Address</label>
                                    <input type="email" id="contactEmail" name="email" placeholder="you@example.com"
                                        required>
                                </div>

                                <div class="col-12">
                                    <label for="contactPhone">Phone Number</label>
                                    <input type="tel" id="contactPhone" name="phone" placeholder="Your phone number"
                                        required>
                                </div>


                                <?php if ($selectedPackageName !== ''): ?>
                                <div class="mb-3">
                                    <label for="selected_package" class="form-label">
                                        Selected Package
                                    </label>
                                    <input type="text" id="selected_package" class="form-control"
                                        value="<?= htmlspecialchars($selectedPackageName, ENT_QUOTES, 'UTF-8') ?>"
                                        readonly>
                                </div>
                                <?php endif; ?>


                                <div class="col-12">
                                    <label for="contactMessage">Your Message</label>
                                    <input type="hidden" name="package"
                                        value="<?= htmlspecialchars($selectedPackageName, ENT_QUOTES, 'UTF-8') ?>">
                                    <textarea id="contactMessage" name="message" rows="4"
                                        placeholder="How can we help you?" required></textarea>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-gold w-100">
                                        Send Message ↗
                                    </button>
                                </div>
                            </div>
                        </form>

                        <p class="contact-note">
                            Demo form: message delivery will work after backend integration.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- ===== DriveN School Footer ===== -->
    <footer class="driven-footer">
        <div class="container">
            <div class="row g-4 footer-main">

                <!-- Brand -->
                <div class="col-lg-4 col-md-6">
                    <a href="#home" class="footer-brand">
                        <span class="footer-brand-mark">D</span>
                        Drive<span class="brand-gold">N</span>
                    </a>

                    <p class="footer-description">
                        Learn to drive with confidence.
                        Build safe driving skills with professional
                        guidance and personalized lessons.
                    </p>

                    <div class="footer-socials">
                        <a href="https://facebook.com/" target="_blank" rel="noopener noreferrer"
                            aria-label="Facebook">f</a>
                        <a href="https://instagram.com/" target="_blank" rel="noopener noreferrer"
                            aria-label="Instagram">ig</a>
                        <a href="https://youtube.com/" target="_blank" rel="noopener noreferrer"
                            aria-label="YouTube">▶</a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-2 col-md-6">
                    <h4 class="footer-title">Quick Links</h4>
                    <ul class="footer-links">
                        <li><a href="#home">Home</a></li>
                        <li><a href="#about">About Us</a></li>
                        <li><a href="#lessons">Lessons</a></li>
                        <li><a href="#packages">Packages</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>

                <!-- Our Services -->
                <div class="col-lg-3 col-md-6">
                    <h4 class="footer-title">Our Services</h4>
                    <ul class="footer-links">
                        <li><a href="#lessons">Beginner Driving</a></li>
                        <li><a href="#lessons">Practical Lessons</a></li>
                        <li><a href="#packages">Driving Packages</a></li>
                        <li><a href="#contact">Book a Lesson</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div class="col-lg-3 col-md-6">
                    <h4 class="footer-title">Get in Touch</h4>

                    <p class="footer-contact-item">
                        <span>☎</span>
                        <a href="#contact">Contact Our Team</a>
                    </p>

                    <p class="footer-contact-item">
                        <span>✉</span>
                        <a href="#contact">Send Us a Message</a>
                    </p>

                    <a href="#contact" class="footer-cta">
                        Book Your Lesson <span>↗</span>
                    </a>
                </div>

            </div>

            <!-- Bottom Bar -->
            <div class="footer-bottom">
                <p>
                    © <?= date('Y') ?> DriveN School.
                    All rights reserved.
                </p>

                <div class="footer-bottom-links">
                    <a href="#contact">Privacy Policy</a>
                    <a href="#contact">Terms & Conditions</a>
                </div>
            </div>
        </div>
    </footer>


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>

</html>
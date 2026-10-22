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
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark fixed-top driven-nav">
        <div class="container">
            <a class="navbar-brand" href="#home">
                <span class="brand-mark">D</span> Drive<span>N</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">
                    <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#lessons">Lessons</a></li>
                    <li class="nav-item"><a class="nav-link" href="#packages">Packages</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#reviews">Reviews</a></li>
                    <li class="nav-item">
                        <a class="btn btn-gold nav-cta" href="#contact">Book a Lesson ↗</a>
                    </li>
                    
                </ul>
            </div>
        </div>
    </nav>

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
                        <div class="package-price"><sup>$</sup><?= htmlspecialchars($package[3]) ?><small> /
                                package</small></div>
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

    <section class="contact-section section-padding" id="contact">
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
    </section>

    <footer class="site-footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-5">
                    <a class="navbar-brand" href="#home"><span class="brand-mark">D</span> Drive<span>N</span></a>
                    <p class="footer-description">Helping learners build confidence, develop safer habits and move
                        forward with purpose.</p>
                </div>
                <div class="col-6 col-lg-2">
                    <h4>Explore</h4><a href="#lessons">Driving Lessons</a><a href="#packages">Packages</a><a
                        href="#about">About Us</a>
                </div>
                <div class="col-6 col-lg-2">
                    <h4>Support</h4><a href="#reviews">Experience</a><a href="#contact">Contact</a><a
                        href="#faqAccordion">FAQs</a>
                </div>
                <div class="col-lg-3">
                    <h4>Start learning</h4>
                    <p>Choose your next step toward confident driving.</p><a href="booking.php"
                        class="footer-link">Request a lesson ↗</a>
                </div>
            </div>
            <div class="footer-bottom">© <?= date("Y") ?> DriveN School. All rights reserved. <span>Learn confidently.
                    Drive responsibly.</span></div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>

</html>
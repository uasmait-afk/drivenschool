
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driving Packages | DriveN School</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="packages-page">

    <?php require_once __DIR__ . '/includes/navbar.php'; ?>

    <!-- Hero -->
    <section class="packages-hero">
        <div class="container">
            <span class="packages-eyebrow">SIMPLE. FLEXIBLE. CONFIDENT.</span>

            <h1>Find Your Perfect<br><span>Driving Package.</span></h1>

            <p>
                Flexible learning options designed to help you build
                confidence, improve your skills and reach your driving goals.
            </p>

            <a href="#pricing" class="btn btn-gold nav-cta">
                Explore Packages ↓
            </a>
        </div>
    </section>

    <!-- Pricing -->
    <section class="packages-pricing" id="pricing">
        <div class="container">

            <div class="packages-heading text-center">
                <span class="packages-eyebrow">OUR PRICING</span>
                <h2>Choose Your <span>Learning Plan</span></h2>
                <p>Start with the package that suits your experience and goals.</p>
                <small>*Prices below are demo prices. Replace them with your actual rates.</small>
            </div>

            <div class="row g-4 mt-4">

                <!-- Beginner -->
                <div class="col-md-6 col-lg-4">
                    <article class="pricing-card">
                        <span class="pricing-tier">01 · STARTER</span>
                        <h3>Beginner</h3>
                        <p class="pricing-description">
                            A starting point for new drivers.
                        </p>

                        <div class="pricing-price">
                            <span>$</span>199
                            <small>/ package</small>
                        </div>

                        <div class="pricing-divider"></div>

                        <ul class="pricing-features">
                            <li>✓ 3 Driving Lessons</li>
                            <li>✓ Basic Vehicle Controls</li>
                            <li>✓ Road Safety Fundamentals</li>
                            <li>✓ Instructor Feedback</li>
                            <li class="feature-muted">— Advanced Practice</li>
                        </ul>

                        <a href="booking.php" class="pricing-button">
                            Choose Beginner
                        </a>
                    </article>
                </div>

                <!-- Standard -->
                <div class="col-md-6 col-lg-4">
                    <article class="pricing-card pricing-popular">
                        <div class="popular-badge">MOST POPULAR</div>

                        <span class="pricing-tier">02 · RECOMMENDED</span>
                        <h3>Standard</h3>
                        <p class="pricing-description">
                            Build skills and confidence on the road.
                        </p>

                        <div class="pricing-price">
                            <span>$</span>349
                            <small>/ package</small>
                        </div>

                        <div class="pricing-divider"></div>

                        <ul class="pricing-features">
                            <li>✓ 6 Driving Lessons</li>
                            <li>✓ Vehicle Control Practice</li>
                            <li>✓ Road Safety Training</li>
                            <li>✓ Personalized Feedback</li>
                            <li>✓ Confidence-Building Practice</li>
                        </ul>

                        <a href="booking.php" class="pricing-button pricing-button-gold">
                            Choose Standard ↗
                        </a>
                    </article>
                </div>

                <!-- Premium -->
                <div class="col-md-6 col-lg-4">
                    <article class="pricing-card">
                        <span class="pricing-tier">03 · COMPLETE</span>
                        <h3>Premium</h3>
                        <p class="pricing-description">
                            More practice for advanced preparation.
                        </p>

                        <div class="pricing-price">
                            <span>$</span>549
                            <small>/ package</small>
                        </div>

                        <div class="pricing-divider"></div>

                        <ul class="pricing-features">
                            <li>✓ 10 Driving Lessons</li>
                            <li>✓ Extended Driving Practice</li>
                            <li>✓ Defensive Driving Skills</li>
                            <li>✓ Personalized Feedback</li>
                            <li>✓ Road Test Preparation</li>
                        </ul>

                        <a href="booking.php" class="pricing-button">
                            Choose Premium
                        </a>
                    </article>
                </div>

            </div>
        </div>
    </section>

    <!-- Comparison -->
    <section class="packages-comparison">
        <div class="container">
            <div class="packages-heading text-center">
                <span class="packages-eyebrow">COMPARE YOUR OPTIONS</span>
                <h2>What Fits <span>Your Goals?</span></h2>
            </div>

            <div class="table-responsive comparison-table-wrap">
                <table class="table comparison-table align-middle">
                    <thead>
                        <tr>
                            <th>Package Features</th>
                            <th>Beginner</th>
                            <th>Standard</th>
                            <th>Premium</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>Driving Lessons</td>
                            <td>3</td>
                            <td>6</td>
                            <td>10</td>
                        </tr>
                        <tr>
                            <td>Vehicle Control</td>
                            <td>✓</td>
                            <td>✓</td>
                            <td>✓</td>
                        </tr>
                        <tr>
                            <td>Road Safety</td>
                            <td>✓</td>
                            <td>✓</td>
                            <td>✓</td>
                        </tr>
                        <tr>
                            <td>Personalized Feedback</td>
                            <td>✓</td>
                            <td>✓</td>
                            <td>✓</td>
                        </tr>
                        <tr>
                            <td>Road Test Preparation</td>
                            <td>—</td>
                            <td>—</td>
                            <td>✓</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <p class="comparison-note">
                Package features are illustrative. Confirm actual lesson inclusions before publishing.
            </p>
        </div>
    </section>

    <!-- FAQ -->
    <section class="packages-faq">
        <div class="container">
            <div class="packages-heading text-center">
                <span class="packages-eyebrow">NEED HELP?</span>
                <h2>Frequently Asked <span>Questions</span></h2>
            </div>

            <div class="accordion packages-accordion" id="packageFAQ">

                <div class="accordion-item">
                    <h3 class="accordion-header">
                        <button class="accordion-button" type="button"
                            data-bs-toggle="collapse" data-bs-target="#faqOne"
                            aria-expanded="true">
                            Which package should a beginner choose?
                        </button>
                    </h3>
                    <div id="faqOne" class="accordion-collapse collapse show"
                        data-bs-parent="#packageFAQ">
                        <div class="accordion-body">
                            The Beginner package is a starting option.
                            Your instructor can help you decide how much practice you need.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h3 class="accordion-header">
                        <button class="accordion-button collapsed" type="button"
                            data-bs-toggle="collapse" data-bs-target="#faqTwo">
                            Can I book a lesson online?
                        </button>
                    </h3>
                    <div id="faqTwo" class="accordion-collapse collapse"
                        data-bs-parent="#packageFAQ">
                        <div class="accordion-body">
                            Yes. Visit the booking page to view the available booking form.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h3 class="accordion-header">
                        <button class="accordion-button collapsed" type="button"
                            data-bs-toggle="collapse" data-bs-target="#faqThree">
                            Are these prices final?
                        </button>
                    </h3>
                    <div id="faqThree" class="accordion-collapse collapse"
                        data-bs-parent="#packageFAQ">
                        <div class="accordion-body">
                            No. The prices on this demonstration page are examples.
                            Confirm the actual prices before publishing the website.
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="packages-cta">
        <div class="container">
            <h2>Your Driving Journey Starts Here.</h2>
            <p>Choose your plan and take the next step toward confident driving.</p>
            <a href="booking.php" class="btn btn-gold nav-cta">
                Book a Lesson ↗
            </a>
        </div>
    </section>

    <footer class="services-footer">
        <div class="container">
            <p>© <?php echo date('Y'); ?> DriveN School. All rights reserved.</p>
            <a href="index.php">Back to Home ↑</a>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>

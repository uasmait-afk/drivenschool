```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Our Services | DriveN School</title>
    <meta name="description" content="Explore professional driving lessons, road test preparation, and defensive driving training at DriveN School.">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>

<body class="services-page">

<!-- NAVBAR -->
<?php require_once __DIR__ . '/includes/navbar.php'; ?>

<!-- HERO -->
<header class="services-hero">
    <div class="services-hero-overlay"></div>

    <div class="container services-hero-content">
        <div class="services-eyebrow">
            <span></span> YOUR JOURNEY STARTS HERE
        </div>

        <h1>Driving Skills for a<br>
            <span>Safer Tomorrow.</span>
        </h1>

        <p>
            Professional instruction, practical experience, and
            confidence-building lessons to help you become a safer driver.
        </p>

        <div class="d-flex flex-wrap gap-3 mt-4">
            <a href="#our-services" class="btn services-primary-btn">
                Explore Our Services <span>→</span>
            </a>
            <a href="booking.php" class="btn services-outline-btn">
                Book Your Lesson
            </a>
        </div>

        <div class="services-hero-note">
            <span class="note-check">✓</span>
            Learn at your pace. Drive with confidence.
        </div>
    </div>

    <div class="services-hero-label">DRIVE SMART. DRIVE SAFE.</div>
</header>

<!-- INTRO -->
<section class="services-intro section-space" id="our-services">
    <div class="container">
        <div class="row align-items-end g-4">
            <div class="col-lg-7">
                <div class="services-section-label">WHAT WE OFFER</div>
                <h2 class="services-section-title">
                    The right training for<br>
                    <span>every driver.</span>
                </h2>
            </div>

            <div class="col-lg-5">
                <p class="services-intro-text">
                    Whether you are learning to drive for the first time
                    or preparing for your road test, our training is designed
                    around your goals and experience level.
                </p>
            </div>
        </div>

        <div class="row g-4 mt-3">

            <!-- SERVICE 1 -->
            <div class="col-md-6 col-lg-4">
                <article class="service-card">
                    <div class="service-image-wrap">
                        <img
                            src="https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?auto=format&fit=crop&w=900&q=85"
                            alt="Student learning to drive a car">
                        <span class="service-number">01</span>
                    </div>

                    <div class="service-card-body">
                        <div class="service-icon">↗</div>
                        <h3>Beginner Driving Lessons</h3>
                        <p>
                            Start with the fundamentals, from steering and
                            braking to road awareness and safe vehicle control.
                        </p>
                        <a href="booking.php" class="service-link">
                            Start Learning <span>→</span>
                        </a>
                    </div>
                </article>
            </div>

            <!-- SERVICE 2 -->
            <div class="col-md-6 col-lg-4">
                <article class="service-card">
                    <div class="service-image-wrap">
                        <img
                            src="https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?auto=format&fit=crop&w=900&q=85"
                            alt="Modern car for driving practice">
                        <span class="service-number">02</span>
                    </div>

                    <div class="service-card-body">
                        <div class="service-icon">⌁</div>
                        <h3>Advanced Driving</h3>
                        <p>
                            Improve parking, lane changes, traffic navigation,
                            and decision-making in more challenging situations.
                        </p>
                        <a href="booking.php" class="service-link">
                            Improve Your Skills <span>→</span>
                        </a>
                    </div>
                </article>
            </div>

            <!-- SERVICE 3 -->
            <div class="col-md-6 col-lg-4">
                <article class="service-card">
                    <div class="service-image-wrap">
                        <img
                            src="https://images.unsplash.com/photo-1511919884226-fd3cad34687c?auto=format&fit=crop&w=900&q=85"
                            alt="Car on the road">
                        <span class="service-number">03</span>
                    </div>

                    <div class="service-card-body">
                        <div class="service-icon">✓</div>
                        <h3>Road Test Preparation</h3>
                        <p>
                            Practice key driving maneuvers, review road rules,
                            and build confidence before your driving test.
                        </p>
                        <a href="booking.php" class="service-link">
                            Prepare for Your Test <span>→</span>
                        </a>
                    </div>
                </article>
            </div>

            <!-- SERVICE 4 -->
            <div class="col-md-6 col-lg-4">
                <article class="service-card">
                    <div class="service-image-wrap">
                        <img
                            src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=900&q=85"
                            alt="Car ready for driving practice">
                        <span class="service-number">04</span>
                    </div>

                    <div class="service-card-body">
                        <div class="service-icon">◎</div>
                        <h3>Defensive Driving</h3>
                        <p>
                            Learn hazard awareness, safe following distances,
                            and techniques for anticipating road risks.
                        </p>
                        <a href="booking.php" class="service-link">
                            Drive More Safely <span>→</span>
                        </a>
                    </div>
                </article>
            </div>

            <!-- SERVICE 5 -->
            <div class="col-md-6 col-lg-4">
                <article class="service-card">
                    <div class="service-image-wrap">
                        <img
                            src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=900&q=85"
                            alt="Open road for driving practice">
                        <span class="service-number">05</span>
                    </div>

                    <div class="service-card-body">
                        <div class="service-icon">↔</div>
                        <h3>Highway & Road Practice</h3>
                        <p>
                            Build experience with road positioning, merging,
                            speed awareness, and route planning where appropriate.
                        </p>
                        <a href="booking.php" class="service-link">
                            Gain Experience <span>→</span>
                        </a>
                    </div>
                </article>
            </div>

            <!-- SERVICE 6 -->
            <div class="col-md-6 col-lg-4">
                <article class="service-card">
                    <div class="service-image-wrap">
                        <img
                            src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=900&q=85"
                            alt="Learning and training resources">
                        <span class="service-number">06</span>
                    </div>

                    <div class="service-card-body">
                        <div class="service-icon">✦</div>
                        <h3>Refresher Lessons</h3>
                        <p>
                            Refresh your skills, rebuild confidence, and
                            revisit specific driving situations with an instructor.
                        </p>
                        <a href="booking.php" class="service-link">
                            Refresh Your Skills <span>→</span>
                        </a>
                    </div>
                </article>
            </div>

        </div>
    </div>
</section>

<!-- TRAINING PROCESS -->
<section class="services-process section-space">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-5">
                <div class="services-section-label">A SIMPLE PROCESS</div>
                <h2 class="services-section-title">
                    From first lesson<br>
                    to <span>confident driving.</span>
                </h2>

                <p class="services-process-description">
                    Learning to drive does not have to feel overwhelming.
                    Follow a clear learning path and progress step by step.
                </p>

                <a href="booking.php" class="btn services-primary-btn mt-3">
                    Schedule a Lesson <span>→</span>
                </a>
            </div>

            <div class="col-lg-7">
                <div class="process-step">
                    <div class="process-step-number">01</div>
                    <div>
                        <h3>Choose Your Training</h3>
                        <p>Select the lesson type that matches your experience and goals.</p>
                    </div>
                </div>

                <div class="process-step">
                    <div class="process-step-number">02</div>
                    <div>
                        <h3>Book Your Session</h3>
                        <p>Use the booking page to request a suitable date and time.</p>
                    </div>
                </div>

                <div class="process-step">
                    <div class="process-step-number">03</div>
                    <div>
                        <h3>Practice With Purpose</h3>
                        <p>Work on essential techniques and build your confidence.</p>
                    </div>
                </div>

                <div class="process-step">
                    <div class="process-step-number">04</div>
                    <div>
                        <h3>Keep Moving Forward</h3>
                        <p>Review your progress and identify the next skills to develop.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- PACKAGES -->
<section class="services-packages section-space">
    <div class="container">
        <div class="text-center">
            <div class="services-section-label">FLEXIBLE LEARNING</div>
            <h2 class="services-section-title">
                Find your <span>training plan.</span>
            </h2>
            <p class="packages-intro">
                Choose a starting point and contact the school to confirm
                lesson availability and pricing.
            </p>
        </div>

        <div class="row g-4 mt-4 justify-content-center">

            <div class="col-md-6 col-lg-4">
                <div class="package-card">
                    <span class="package-label">GET STARTED</span>
                    <h3>Starter</h3>
                    <p class="package-description">
                        For new learners building their driving foundations.
                    </p>

                    <div class="package-feature">✓ Fundamental driving skills</div>
                    <div class="package-feature">✓ Vehicle control practice</div>
                    <div class="package-feature">✓ Road safety basics</div>

                    <a href="booking.php" class="btn package-btn">
                        Ask About Starter <span>→</span>
                    </a>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="package-card package-featured">
                    <span class="package-label">BUILD CONFIDENCE</span>
                    <h3>Progress</h3>
                    <p class="package-description">
                        For learners ready to improve practical driving skills.
                    </p>

                    <div class="package-feature">✓ Skills development</div>
                    <div class="package-feature">✓ Road awareness practice</div>
                    <div class="package-feature">✓ Personalized learning goals</div>

                    <a href="booking.php" class="btn package-btn">
                        Ask About Progress <span>→</span>
                    </a>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="package-card">
                    <span class="package-label">TEST READINESS</span>
                    <h3>Road Test</h3>
                    <p class="package-description">
                        For learners focusing on test preparation and review.
                    </p>

                    <div class="package-feature">✓ Maneuver practice</div>
                    <div class="package-feature">✓ Driving skills review</div>
                    <div class="package-feature">✓ Confidence building</div>

                    <a href="booking.php" class="btn package-btn">
                        Ask About Road Test <span>→</span>
                    </a>
                </div>
            </div>

        </div>

        <p class="packages-disclaimer">
            Package names are illustrative. Confirm actual services, lesson
            duration, availability, and fees with DriveN School before booking.
        </p>
    </div>
</section>

<!-- CTA -->
<section class="services-cta">
    <div class="container">
        <div class="services-cta-content">
            <div>
                <div class="services-cta-label">READY TO GET STARTED?</div>
                <h2>Your next journey<br>starts with one lesson.</h2>
                <p>Take the first step toward safer, more confident driving.</p>
            </div>

            <a href="booking.php" class="btn services-cta-btn">
                Book Your Lesson <span>→</span>
            </a>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="services-footer">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-5">
                <a href="index.php" class="services-brand footer-brand">
                    <span class="brand-mark">D</span>
                    <span>DriveN<span class="brand-highlight"> School</span></span>
                </a>

                <p class="footer-description">
                    Building better driving habits, one lesson at a time.
                    Learn with purpose. Drive with confidence.
                </p>
            </div>

            <div class="col-6 col-lg-2">
                <h4>Explore</h4>
                <a href="index.php">Home</a>
                <a href="about.php">About Us</a>
                <a href="services.php">Services</a>
            </div>

            <div class="col-6 col-lg-2">
                <h4>Quick Links</h4>
                <a href="booking.php">Book a Lesson</a>
                <a href="student-login.php">Student Login</a>
                <a href="login.php">Admin Login</a>
            </div>

            <div class="col-lg-3">
                <h4>Let's Get Started</h4>
                <p class="footer-contact-text">
                    Ready to improve your driving skills?
                </p>
                <a href="booking.php" class="footer-book-link">
                    Book your session →
                </a>
            </div>
        </div>

        <div class="services-footer-bottom">
            <span>© <?php echo date('Y'); ?> DriveN School. All rights reserved.</span>
            <span>Drive Smart. Drive Safe.</span>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>

</body>
</html>
```
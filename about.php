
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>About Us | DriveN School</title>
    <meta name="description"
          content="Discover DriveN School's mission, training approach and commitment to safer driving.">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap"
          rel="stylesheet">

    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="about-page">

<!-- NAVBAR -->
<?php require_once __DIR__ . '/includes/navbar.php'; ?>

<main>
    <!-- HERO -->
    <section class="about-hero">
        <div class="about-hero-image"></div>
        <div class="container about-hero-content">
            <div class="about-eyebrow">
                <span></span> GET TO KNOW US
            </div>

            <h1>Driving Confidence.<br>
                <span>Building Safer Roads.</span>
            </h1>

            <p>
                More than driving lessons. We help you build the skills,
                confidence and awareness to enjoy every journey.
            </p>

            <div class="d-flex flex-wrap gap-3 mt-4">
                <a href="booking.php" class="btn about-primary-btn">
                    Start Your Journey <span>↗</span>
                </a>
                <a href="#our-story" class="btn about-outline-btn">
                    Discover Our Story
                </a>
            </div>

            <div class="about-hero-note">
                <span class="note-icon">✓</span>
                Learn at your pace. Drive with confidence.
            </div>
        </div>

        <div class="about-hero-label">CONFIDENCE STARTS HERE</div>
    </section>

    <!-- INTRO / OUR STORY -->
    <section class="about-section" id="our-story">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <div class="about-image-wrap">
                        <img
                            src="https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?auto=format&fit=crop&w=1100&q=85"
                            alt="Driving on a road"
                            class="about-story-image"
                            loading="lazy">

                        <div class="about-image-tag">
                            <span class="tag-symbol">D</span>
                            <div>
                                <strong>Your journey matters</strong>
                                <small>Confidence behind the wheel</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="about-eyebrow dark-eyebrow">
                        <span></span> OUR STORY
                    </div>

                    <h2 class="about-heading">
                        Every great driver<br>
                        starts with <span>the right guide.</span>
                    </h2>

                    <p class="about-body">
                        At DriveN School, we believe learning to drive is
                        about more than passing a test. It is about developing
                        good habits, making responsible decisions and feeling
                        comfortable on the road.
                    </p>

                    <p class="about-body">
                        Our training approach focuses on clear guidance,
                        practical experience and a supportive learning
                        environment. Every learner deserves the opportunity
                        to progress at their own pace.
                    </p>

                    <a href="booking.php" class="about-text-link">
                        Find the right lesson for you <span>→</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- MISSION AND VISION -->
    <section class="about-purpose">
        <div class="container">
            <div class="text-center about-section-intro">
                <div class="about-eyebrow justify-content-center">
                    <span></span> OUR PURPOSE <span></span>
                </div>
                <h2 class="about-heading">
                    Guided by purpose.<br>
                    <span>Driven by safety.</span>
                </h2>
                <p>
                    Our values shape how we teach, support and prepare every learner.
                </p>
            </div>

            <div class="row g-4 mt-4">
                <div class="col-md-6">
                    <article class="purpose-card mission-card">
                        <div class="purpose-icon">
                            <svg viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="1.7"
                                 aria-hidden="true">
                                <path d="M12 3 4 7v5c0 5 3.5 8 8 9 4.5-1 8-4 8-9V7l-8-4Z"/>
                                <path d="m8.5 12 2.3 2.3 4.7-5"/>
                            </svg>
                        </div>

                        <span class="purpose-number">01 / OUR MISSION</span>
                        <h3>Empowering safer drivers</h3>
                        <p>
                            To provide clear, supportive and practical driving
                            education that helps learners develop confidence,
                            awareness and responsible driving habits.
                        </p>
                    </article>
                </div>

                <div class="col-md-6">
                    <article class="purpose-card vision-card">
                        <div class="purpose-icon">
                            <svg viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="1.7"
                                 aria-hidden="true">
                                <circle cx="12" cy="12" r="9"/>
                                <circle cx="12" cy="12" r="5"/>
                                <circle cx="12" cy="12" r="1.5"/>
                            </svg>
                        </div>

                        <span class="purpose-number">02 / OUR VISION</span>
                        <h3>A safer road for everyone</h3>
                        <p>
                            To inspire a community of skilled, thoughtful and
                            confident drivers who make safety a priority
                            on every journey.
                        </p>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <!-- WHY CHOOSE US -->
    <section class="about-section about-benefits">
        <div class="container">
            <div class="row align-items-end mb-5 g-3">
                <div class="col-lg-7">
                    <div class="about-eyebrow dark-eyebrow">
                        <span></span> THE DRIVEN DIFFERENCE
                    </div>

                    <h2 class="about-heading">
                        A better way to<br>
                        <span>learn to drive.</span>
                    </h2>
                </div>

                <div class="col-lg-5">
                    <p class="about-body mb-0">
                        The right learning environment can make all the
                        difference. Our approach puts the learner first.
                    </p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <article class="benefit-card">
                        <div class="benefit-icon">01</div>
                        <h3>Learn at Your Pace</h3>
                        <p>
                            Build your skills step by step in a supportive
                            learning environment.
                        </p>
                        <span class="benefit-arrow">↗</span>
                    </article>
                </div>

                <div class="col-md-6 col-lg-4">
                    <article class="benefit-card">
                        <div class="benefit-icon">02</div>
                        <h3>Safety Comes First</h3>
                        <p>
                            Develop awareness, responsible habits and
                            safer decision-making skills.
                        </p>
                        <span class="benefit-arrow">↗</span>
                    </article>
                </div>

                <div class="col-md-6 col-lg-4">
                    <article class="benefit-card">
                        <div class="benefit-icon">03</div>
                        <h3>Practical Experience</h3>
                        <p>
                            Build real-world driving skills through
                            structured, practical learning.
                        </p>
                        <span class="benefit-arrow">↗</span>
                    </article>
                </div>

                <div class="col-md-6 col-lg-4">
                    <article class="benefit-card">
                        <div class="benefit-icon">04</div>
                        <h3>Clear Guidance</h3>
                        <p>
                            Understand each step with straightforward
                            explanations and helpful feedback.
                        </p>
                        <span class="benefit-arrow">↗</span>
                    </article>
                </div>

                <div class="col-md-6 col-lg-4">
                    <article class="benefit-card">
                        <div class="benefit-icon">05</div>
                        <h3>Goal-Focused Lessons</h3>
                        <p>
                            Work towards your individual learning goals
                            with a clear training plan.
                        </p>
                        <span class="benefit-arrow">↗</span>
                    </article>
                </div>

                <div class="col-md-6 col-lg-4">
                    <article class="benefit-card">
                        <div class="benefit-icon">06</div>
                        <h3>Confidence for Life</h3>
                        <p>
                            Develop skills that help you approach
                            everyday driving more confidently.
                        </p>
                        <span class="benefit-arrow">↗</span>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <!-- TRAINING APPROACH -->
    <section class="about-training">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-5">
                    <div class="about-eyebrow">
                        <span></span> YOUR LEARNING JOURNEY
                    </div>

                    <h2 class="about-heading text-white">
                        From first lesson<br>
                        to <span>confident driver.</span>
                    </h2>

                    <p class="training-description">
                        Progress looks different for everyone. Our structured
                        approach helps learners understand what comes next.
                    </p>

                    <a href="booking.php" class="btn about-primary-btn mt-3">
                        Explore Lessons <span>↗</span>
                    </a>
                </div>

                <div class="col-lg-7">
                    <div class="training-step">
                        <span class="training-step-number">01</span>
                        <div>
                            <h3>Understand the basics</h3>
                            <p>Get familiar with road rules, controls and safety.</p>
                        </div>
                    </div>

                    <div class="training-step">
                        <span class="training-step-number">02</span>
                        <div>
                            <h3>Practise essential skills</h3>
                            <p>Build vehicle control and awareness through practice.</p>
                        </div>
                    </div>

                    <div class="training-step">
                        <span class="training-step-number">03</span>
                        <div>
                            <h3>Develop road confidence</h3>
                            <p>Apply your skills to more varied driving situations.</p>
                        </div>
                    </div>

                    <div class="training-step">
                        <span class="training-step-number">04</span>
                        <div>
                            <h3>Prepare for your next goal</h3>
                            <p>Review your progress and identify what to practise next.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CALL TO ACTION -->
    <section class="about-cta">
        <div class="container">
            <div class="about-cta-inner">
                <div>
                    <div class="about-eyebrow">
                        <span></span> YOUR NEXT CHAPTER STARTS HERE
                    </div>
                    <h2>Ready to take the<br>
                        <span>driver's seat?</span>
                    </h2>
                    <p>
                        Take the first step towards a more confident
                        driving experience.
                    </p>
                </div>

                <a href="booking.php" class="btn about-dark-btn">
                    Book Your First Lesson <span>↗</span>
                </a>
            </div>
        </div>
    </section>
</main>

<!-- FOOTER -->
<footer class="about-footer">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-5">
                <a class="navbar-brand about-brand footer-brand" href="index.php">
                    <span class="brand-mark">D</span>
                    <span>DriveN<span class="brand-highlight">.</span>
                        <small>DRIVING SCHOOL</small>
                    </span>
                </a>

                <p class="footer-description">
                    Building driving confidence through practical learning
                    and a commitment to safer roads.
                </p>
            </div>

            <div class="col-6 col-lg-2">
                <h4>Explore</h4>
                <a href="index.php">Home</a>
                <a href="about.php">About Us</a>
                <a href="booking.php">Lessons & Booking</a>
            </div>

            <div class="col-6 col-lg-2">
                <h4>Portals</h4>
                <a href="student-login.php">Student Login</a>
                <a href="login.php">Admin Login</a>
            </div>

            <div class="col-lg-3">
                <h4>Start Learning</h4>
                <p class="footer-small">
                    Take your next step towards confident driving.
                </p>
                <a href="booking.php" class="footer-cta-link">
                    Book a Lesson →
                </a>
            </div>
        </div>

        <div class="footer-bottom">
            <span>© <?php echo date('Y'); ?> DriveN School. All rights reserved.</span>
            <span>Drive smart. Drive safe.</span>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

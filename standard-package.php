
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Standard Package | DriveN School</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        body {
            background: #f5f7fb;
            color: #1b2940;
            font-family: Arial, sans-serif;
        }

        .standard-hero {
            background: linear-gradient(120deg, #091426, #1a3765);
            color: white;
            padding: 150px 0 85px;
        }

        .standard-hero .eyebrow {
            color: #f5a623;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .standard-hero h1 {
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 800;
        }

        .standard-hero h1 span {
            color: #f5a623;
        }

        .standard-hero p {
            color: #d1dbea;
            max-width: 600px;
            line-height: 1.8;
        }

        .standard-price-card {
            background: white;
            border-radius: 20px;
            padding: 35px;
            box-shadow: 0 15px 45px rgba(9, 20, 38, .12);
            border-top: 5px solid #f5a623;
        }

        .price-label {
            color: #6e7787;
            font-weight: 700;
            font-size: .85rem;
            text-transform: uppercase;
        }

        .price {
            color: #101d35;
            font-size: 3.2rem;
            font-weight: 800;
        }

        .price small {
            color: #6e7787;
            font-size: .95rem;
            font-weight: 400;
        }

        .btn-standard {
            background: #f5a623;
            color: #101d35;
            font-weight: 700;
            padding: 13px 22px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            transition: .25s;
        }

        .btn-standard:hover {
            background: #ffbb4c;
            color: #101d35;
            transform: translateY(-2px);
        }

        .standard-section {
            padding: 80px 0;
        }

        .section-kicker {
            color: #2878f0;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            font-size: .8rem;
        }

        .feature-card {
            background: white;
            border: 1px solid #e5eaf2;
            border-radius: 15px;
            padding: 27px;
            height: 100%;
            transition: .25s;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(16, 29, 53, .08);
        }

        .feature-icon {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            display: grid;
            place-items: center;
            background: #fff2d9;
            color: #a96800;
            font-size: 1.5rem;
            margin-bottom: 18px;
        }

        .feature-card p {
            color: #6e7787;
            line-height: 1.7;
        }

        .included-section {
            background: #101d35;
            color: white;
        }

        .included-list {
            list-style: none;
            padding: 0;
        }

        .included-list li {
            padding: 12px 0;
            border-bottom: 1px solid rgba(255,255,255,.12);
            color: #dbe3f1;
        }

        .included-list i {
            color: #f5a623;
            margin-right: 10px;
        }

        .faq-section .accordion-item {
            border: 1px solid #e5eaf2;
            border-radius: 10px;
            margin-bottom: 12px;
            overflow: hidden;
        }

        .faq-section .accordion-button {
            font-weight: 700;
            padding: 20px;
        }

        .faq-section .accordion-button:not(.collapsed) {
            background: #fff2d9;
            color: #101d35;
        }

        .standard-cta {
            background: linear-gradient(120deg, #1a3765, #101d35);
            color: white;
            border-radius: 20px;
            padding: 45px 25px;
        }

        .standard-footer {
            background: #091426;
            color: #bdc9da;
            padding: 25px 0;
        }

        @media (max-width: 767px) {
            .standard-hero {
                padding-top: 125px;
            }

            .standard-price-card {
                margin-top: 30px;
            }

            .standard-section {
                padding: 55px 0;
            }
        }
    </style>
</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top driven-nav">
    <div class="container">

        <a class="navbar-brand" href="index.php#home">
            <span class="brand-mark">D</span> Drive<span>N</span>
        </a>

        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse" data-bs-target="#mainNav"
                aria-controls="mainNav" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">

                <li class="nav-item">
                    <a class="nav-link" href="index.php#home">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="index.php#lessons">Lessons</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#"
                       id="packagesDropdown" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        Packages
                    </a>

                    <ul class="dropdown-menu driven-dropdown"
                        aria-labelledby="packagesDropdown">
                        <li>
                            <a class="dropdown-item" href="basic-package.php">
                                Basic Package
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="standard-package.php">
                                Standard Package
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item"
                               href="packages.php?type=individual">
                                Individual Package
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item"
                               href="packages.php?type=custom">
                                Custom Package
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="services.php">Services</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="about.php">About</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="reviews.php">Reviews</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="index.php#contact">Contact</a>
                </li>

                <li class="nav-item">
                    <a class="btn btn-gold nav-cta" href="booking.php">
                        Book a Lesson ↗
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>

<?php
$standardPackages = [
    [
        'lessons' => 5,
        'bonus' => 1,
        'price' => 445,
        'features' => [
            '45 mins per lesson',
            '1 bonus lesson free',
            'Car for road test',
            'Rush road test appointment'
        ]
    ],
    [
        'lessons' => 10,
        'bonus' => 2,
        'price' => 700,
        'features' => [
            '45 mins per lesson',
            '2 bonus lessons free',
            'Car for road test',
            'Rush road test appointment'
        ]
    ],
    [
        'lessons' => 15,
        'bonus' => 3,
        'price' => 975,
        'features' => [
            '45 mins per lesson',
            '3 bonus lessons free',
            'Car for road test',
            'Rush road test appointment'
        ]
    ],
    [
        'lessons' => 20,
        'bonus' => 4,
        'price' => 1250,
        'features' => [
            '45 mins per lesson',
            '4 bonus lessons free',
            'Car for road test',
            'Rush road test appointment'
        ]
    ]
];
?>

<!-- Hero -->
<section class="standard-hero">
    <div class="container">
        <div class="row align-items-center g-5">

            <div class="col-lg-7">
                <div class="eyebrow mb-3">
                    DriveN School · Our Packages
                </div>

                <h1>
                    Build Confidence.<br>
                    Drive <span>Smarter.</span>
                </h1>

                <p class="mt-4">
                    Take your driving skills to the next level with our
                    Standard Package. Get structured lessons, professional
                    guidance and practical driving experience.
                </p>

                <div class="d-flex flex-wrap gap-3 mt-4">
                    <a href="#pricing" class="btn-standard">
                        Explore Package <i class="bi bi-arrow-right"></i>
                    </a>

                    <a href="#included"
                       class="btn btn-outline-light px-4 py-3">
                        What's Included
                    </a>
                </div>
            </div>

            <div class="col-lg-5" id="pricing">
                <div class="standard-price-card">
                    <span class="price-label">Standard Package</span>

                    <h2 class="h4 mt-3">Professional Driving Lessons</h2>

                    <!-- Change the placeholder price here -->
                    <div class="price mt-3">
                        $490
                        <small>/ package</small>
                    </div>

                    <p class="text-secondary">
                        A balanced choice for learners building
                        confidence behind the wheel.
                    </p>

                    <hr>

                    <div class="d-flex justify-content-between py-2">
                        <span><i class="bi bi-car-front me-2"></i>Lessons</span>
                        <strong>6 Sessions</strong>
                    </div>

                    <div class="d-flex justify-content-between py-2">
                        <span><i class="bi bi-clock me-2"></i>Duration</span>
                        <strong>45 Minutes Each</strong>
                    </div>

                    <div class="d-flex justify-content-between py-2">
                        <span><i class="bi bi-person-check me-2"></i>Guidance</span>
                        <strong>Instructor Led</strong>
                    </div>

                    <a href="booking.php"
                       class="btn-standard text-center w-100 mt-4">
                        Book Your Lessons <i class="bi bi-arrow-up-right"></i>
                    </a>

                    <p class="small text-secondary text-center mt-3 mb-0">
                        Price is an editable placeholder.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Dynamic Standard Package Cards -->
<section class="standard-packages py-5" id="standard-pricing">
    <div class="container py-lg-4">

        <div class="text-center mb-5">
            <span class="standard-kicker">FIND YOUR FIT</span>
            <h2 class="display-5 fw-bold mt-2">
                Choose Your Lesson Package
            </h2>
            <p>
                Every package includes bonus lessons and essential road practice.
            </p>
        </div>

        <div class="row g-4">

            <?php foreach ($standardPackages as $package): ?>
                <div class="col-md-6 col-xl-3">

                    <div class="standard-package-card h-100 d-flex flex-column">

                        <span class="popular-badge">POPULAR</span>

                        <p class="package-type mt-3 mb-2">
                            STANDARD PACKAGE
                        </p>

                        <h3>
                            <?= (int) $package['lessons'] ?> Lessons
                        </h3>

                        <p class="bonus-text">
                            <i class="bi bi-gift-fill"></i>
                            + <?= (int) $package['bonus'] ?>
                            bonus <?= $package['bonus'] === 1
                                ? 'lesson' : 'lessons' ?> free
                        </p>

                        <div class="standard-package-price">
                            <sup>$</sup><?= number_format($package['price']) ?><small>.00</small>
                            <span>Per Package</span>
                        </div>

                        <hr>

                        <ul class="package-features">
                            <?php foreach ($package['features'] as $feature): ?>
                                <li>
                                    <i class="bi bi-check-circle-fill"></i>
                                    <?= htmlspecialchars($feature, ENT_QUOTES, 'UTF-8') ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>

                        <a
                            href="add-to-cart.php?package=standard-<?= (int) $package['lessons'] ?>"
                            class="choose-package-btn mt-auto"
                        >
                            Choose Package
                            <i class="bi bi-arrow-right"></i>
                        </a>

                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    </div>
</section>

<!-- Features -->
<section class="standard-section">
    <div class="container">

        <div class="text-center mb-5">
            <div class="section-kicker mb-2">Why Choose Standard?</div>
            <h2 class="display-6 fw-bold">More Practice. More Confidence.</h2>
            <p class="text-secondary">
                Build the essential skills you need for everyday driving.
            </p>
        </div>

        <div class="row g-4">

            <div class="col-md-6 col-lg-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-car-front-fill"></i>
                    </div>
                    <h3 class="h5 fw-bold">Practical Driving</h3>
                    <p class="mb-0">
                        Practice vehicle control, steering, braking
                        and smooth driving with instructor guidance.
                    </p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-sign-turn-right-fill"></i>
                    </div>
                    <h3 class="h5 fw-bold">Road Skills</h3>
                    <p class="mb-0">
                        Learn road awareness, lane positioning,
                        turning and safe decision-making.
                    </p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h3 class="h5 fw-bold">Safety First</h3>
                    <p class="mb-0">
                        Develop safer driving habits and learn
                        to recognise common road hazards.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- What's Included -->
<section class="standard-section included-section" id="included">
    <div class="container">
        <div class="row align-items-center g-5">

            <div class="col-lg-6">
                <div class="section-kicker mb-2">Package Benefits</div>

                <h2 class="display-6 fw-bold">
                    Everything You Need to Move Forward
                </h2>

                <p class="mt-3" style="color:#bdc9da; line-height:1.8;">
                    Follow a structured learning experience designed
                    to help you become a more confident and responsible driver.
                </p>

                <a href="booking.php" class="btn-standard mt-3">
                    Get Started Today <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <div class="col-lg-6">
                <ul class="included-list">
                    <li><i class="bi bi-check-circle-fill"></i> 6 instructor-led driving sessions</li>
                    <li><i class="bi bi-check-circle-fill"></i> Vehicle handling practice</li>
                    <li><i class="bi bi-check-circle-fill"></i> Road awareness and traffic rules</li>
                    <li><i class="bi bi-check-circle-fill"></i> Turning and parking practice</li>
                    <li><i class="bi bi-check-circle-fill"></i> Personal feedback from your instructor</li>
                    <li><i class="bi bi-check-circle-fill"></i> Guidance on your next learning steps</li>
                </ul>
            </div>

        </div>
    </div>
</section>

<!-- FAQ -->
<section class="standard-section faq-section">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-kicker mb-2">FAQ</div>
            <h2 class="display-6 fw-bold">Frequently Asked Questions</h2>
        </div>

        <div class="accordion mx-auto" id="standardFAQ"
             style="max-width:850px;">

            <div class="accordion-item">
                <h3 class="accordion-header">
                    <button class="accordion-button" type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#faqOne"
                            aria-expanded="true" aria-controls="faqOne">
                        Who should choose the Standard Package?
                    </button>
                </h3>

                <div id="faqOne" class="accordion-collapse collapse show"
                     data-bs-parent="#standardFAQ">
                    <div class="accordion-body">
                        It is suitable for learners who want structured
                        practice and more time to develop their driving skills.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h3 class="accordion-header">
                    <button class="accordion-button collapsed" type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#faqTwo"
                            aria-expanded="false" aria-controls="faqTwo">
                        How long is each lesson?
                    </button>
                </h3>

                <div id="faqTwo" class="accordion-collapse collapse"
                     data-bs-parent="#standardFAQ">
                    <div class="accordion-body">
                        This page currently lists 45 minutes per session.
                        Confirm the actual lesson duration before publishing.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h3 class="accordion-header">
                    <button class="accordion-button collapsed" type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#faqThree"
                            aria-expanded="false" aria-controls="faqThree">
                        How do I book my lessons?
                    </button>
                </h3>

                <div id="faqThree" class="accordion-collapse collapse"
                     data-bs-parent="#standardFAQ">
                    <div class="accordion-body">
                        Select Book Your Lessons to open the booking page
                        and submit your preferred lesson details.
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- CTA -->
<section class="pb-5">
    <div class="container">
        <div class="standard-cta text-center">
            <div class="section-kicker mb-2">Your Next Step</div>

            <h2 class="display-6 fw-bold">
                Ready to Become a Better Driver?
            </h2>

            <p class="mt-3 mb-4" style="color:#d1dbea;">
                Start learning with a plan that puts safety and confidence first.
            </p>

            <a href="booking.php" class="btn-standard">
                Book a Lesson Now <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

<footer class="standard-footer">
    <div class="container text-center">
        <p class="mb-0">
            &copy; <?php echo date('Y'); ?> DriveN School.
            All rights reserved.
        </p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

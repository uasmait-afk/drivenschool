<?php
$package = [
    'title' => 'Basic Driving Package',
    'price' => 149,
    'price_note' => 'per package',
    'lessons' => 3,
    'duration' => '60 minutes per lesson',
    'description' => 'Build a strong foundation and start your driving journey with confidence.',
    'features' => [
        [
            'title' => 'Vehicle Controls',
            'description' => 'Understand steering, pedals, mirrors and essential vehicle controls.'
        ],
        [
            'title' => 'Basic Manoeuvres',
            'description' => 'Learn basic vehicle movement, stopping and turning safely.'
        ],
        [
            'title' => 'Traffic Signs',
            'description' => 'Understand common traffic signs and essential road rules.'
        ],
        [
            'title' => 'Road Awareness',
            'description' => 'Develop awareness of other vehicles, pedestrians and road conditions.'
        ],
        [
            'title' => 'Practical Driving',
            'description' => 'Build confidence through instructor-guided driving practice.'
        ],
        [
            'title' => 'Safety Fundamentals',
            'description' => 'Learn safe driving habits and responsible road behaviour.'
        ],
    ],
    'faqs' => [
        [
            'question' => 'Who is this package for?',
            'answer' => 'This package is designed for beginners who want to learn basic driving skills.'
        ],
        [
            'question' => 'How many lessons are included?',
            'answer' => 'This demonstration package includes 3 lessons.'
        ],
        [
            'question' => 'How long is each lesson?',
            'answer' => 'The placeholder duration is 60 minutes per lesson.'
        ],
        [
            'question' => 'What is the package price?',
            'answer' => 'The displayed $149 price is a placeholder and must be confirmed before publishing.'
        ],
    ],
];

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Basic Driving Package | DriveN School</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

     <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
    .basic-page {
        --navy: #101c3a;
        --blue: #174b8c;
        --gold: #f5ae35;
        --light: #f5f7fc;
        color: var(--navy);
    }

    .basic-hero {
        padding: 100px 0;
        color: white;
        background:
            radial-gradient(circle at 85% 15%,
                rgba(245, 174, 53, .25), transparent 30%),
            linear-gradient(130deg, var(--navy), var(--blue));
    }

    .basic-eyebrow {
        color: var(--gold);
        font-size: .8rem;
        font-weight: 800;
        letter-spacing: 3px;
    }

    .basic-hero h1 {
        margin: 20px 0;
        font-size: clamp(2.5rem, 6vw, 4.5rem);
        font-weight: 850;
    }

    .basic-hero p {
        max-width: 650px;
        color: #e0e8f6;
        line-height: 1.9;
    }

    .basic-btn {
        display: inline-block;
        padding: 14px 23px;
        border-radius: 9px;
        color: var(--navy);
        background: var(--gold);
        font-weight: 800;
        text-decoration: none;
    }

    .basic-btn:hover {
        color: var(--navy);
        background: #ffc65c;
    }

    .basic-overview {
        padding: 28px;
        border: 1px solid rgba(255, 255, 255, .2);
        border-radius: 18px;
        background: rgba(255, 255, 255, .08);
    }

    .basic-section {
        padding: 80px 0;
    }

    .basic-light {
        background: var(--light);
    }

    .basic-card {
        height: 100%;
        padding: 28px;
        border: 1px solid #e5eaf3;
        border-radius: 16px;
        background: white;
        box-shadow: 0 10px 30px rgba(16, 28, 58, .06);
        transition: .25s;
    }

    .basic-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 18px 40px rgba(16, 28, 58, .1);
    }

    .basic-icon {
        display: grid;
        place-items: center;
        width: 50px;
        height: 50px;
        margin-bottom: 20px;
        border-radius: 13px;
        background: #fff0cc;
        font-size: 24px;
    }

    .basic-card h3 {
        font-size: 1.15rem;
        font-weight: 800;
    }

    .basic-card p {
        color: #46536b;
        line-height: 1.8;
    }

    .basic-price {
        max-width: 850px;
        margin: auto;
        padding: 38px;
        border: 1px solid #f5d59a;
        border-radius: 20px;
        background: white;
        box-shadow: 0 20px 50px rgba(16, 28, 58, .08);
    }

    .basic-price-number {
        margin: 12px 0;
        font-size: clamp(3rem, 7vw, 5rem);
        font-weight: 850;
    }

    .basic-faq .accordion-item {
        margin-bottom: 12px;
        overflow: hidden;
        border: 1px solid #e5eaf3;
        border-radius: 12px;
    }

    .basic-faq .accordion-button {
        padding: 20px;
        color: var(--navy);
        font-weight: 700;
    }

    .basic-faq .accordion-button:not(.collapsed) {
        background: #fff5df;
    }

    .basic-footer {
        padding: 25px 0;
        color: #c7d2e4;
        background: #0a142b;
    }

    @media (max-width: 767px) {
        .basic-hero {
            padding: 65px 0;
        }

        .basic-section {
            padding: 55px 0;
        }

        .basic-price {
            padding: 24px;
        }
    }
    </style>
</head>

<body class="basic-page">

    <?php require_once __DIR__ . '/includes/navbar.php'; ?>

    <!-- HERO SECTION -->
    <header class="basic-hero">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <div class="basic-eyebrow">YOUR FIRST STEP</div>

                    <h1><?= e($package['title']) ?></h1>

                    <p><?= e($package['description']) ?></p>

                    <div class="d-flex flex-wrap gap-3 mt-4">
                        <a href="index.php?package=basic#contact" class="basic-btn">
                            Enquire Now &rarr;
                        </a>

                        <a href="#lessons" class="btn btn-outline-light px-4 py-3">
                            Explore Lessons
                        </a>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="basic-overview">
                        <div class="basic-eyebrow mb-3">PACKAGE OVERVIEW</div>

                        <h3 class="fw-bold">
                            <?= e($package['lessons']) ?> Lessons
                        </h3>

                        <p><?= e($package['duration']) ?></p>

                        <hr>

                        <div class="fs-1 fw-bold">
                            $<?= e($package['price']) ?>
                        </div>

                        <div class="text-white-50">
                            <?= e($package['price_note']) ?>
                        </div>

                        <small class="text-warning">
                            Editable placeholder price
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </header>



    <!-- FOUR PACKAGE CARDS -->
    <section class="basic-section basic-light" id="packages">
        <div class="container">

            <div class="text-center mb-5">
                <div class="basic-eyebrow">DRIVEN SCHOOL PACKAGES</div>
                <h2 class="package-heading">
                    Choose Your <span>Package</span>
                </h2>
                <p class="package-subtitle">
                    Flexible driving lesson packages to help you prepare for the road.
                </p>
            </div>

            <div class="row g-4">

                <?php
            $packages = [
                [
                    'lessons' => '1 Lesson',
                    'price' => '225.00',
                    'description' => 'One 45-minute driving lesson',
                    'code' => 'FGZDMR'
                ],
                [
                    'lessons' => '2 Lessons',
                    'price' => '280.00',
                    'description' => 'Two 45-minute driving lessons',
                    'code' => 'BP4ISN'
                ],
                [
                    'lessons' => '3 Lessons',
                    'price' => '335.00',
                    'description' => 'Three 45-minute driving lessons',
                    'code' => '65147S'
                ],
                [
                    'lessons' => '4 Lessons',
                    'price' => '390.00',
                    'description' => 'Four 45-minute driving lessons',
                    'code' => '5Q4SIR'
                ]
            ];
            ?>

                <?php foreach ($packages as $package): ?>
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="basic-card package-card h-100">

                        <div class="basic-icon">
                            <i class="bi bi-car-front-fill"></i>
                        </div>

                        <h3>
                            <?= htmlspecialchars($package['lessons']) ?>
                        </h3>

                        <p class="package-description">
                            <?= htmlspecialchars($package['description']) ?>
                        </p>

                        <div class="package-price">
                            <span class="currency">$</span><?= htmlspecialchars($package['price']) ?>
                        </div>

                        <span class="package-price-label">Per Package</span>

                        <div class="package-divider"></div>

                        <ul class="package-features">
                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                45 mins per lesson
                            </li>
                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                Car for road test
                            </li>
                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                Rush road test appointment
                            </li>
                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                New fully equipped vehicle
                            </li>
                        </ul>

                        <a href="enroll.php?package=<?= urlencode($package['code']) ?>"
                            class="btn basic-btn package-btn">
                            Choose Package
                            <i class="bi bi-arrow-right"></i>
                        </a>
                        

                    </div>
                </div>
                <?php endforeach; ?>

            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="basic-footer">
        <div class="container d-flex flex-wrap justify-content-between gap-3">
            <span>&copy; <?= date('Y') ?> DriveN School. All rights reserved.</span>
            <a href="index.php" class="text-white text-decoration-none">
                Back to Home
            </a>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
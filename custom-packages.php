
<?php
$customPackages = [
    [
        'name' => 'Starter',
        'lessons' => 5,
        'bonus' => 1,
        'price' => 445,
        'description' => 'A great start for new drivers.',
        'features' => [
            '45 minutes per lesson',
            '1 bonus lesson free',
            'Car for road test',
            'Flexible scheduling'
        ],
        'popular' => false
    ],
    [
        'name' => 'Popular',
        'lessons' => 10,
        'bonus' => 2,
        'price' => 700,
        'description' => 'Build skills with extra practice.',
        'features' => [
            '45 minutes per lesson',
            '2 bonus lessons free',
            'Car for road test',
            'Rush road test appointment'
        ],
        'popular' => true
    ],
    [
        'name' => 'Advanced',
        'lessons' => 15,
        'bonus' => 3,
        'price' => 975,
        'description' => 'More practice for greater confidence.',
        'features' => [
            '45 minutes per lesson',
            '3 bonus lessons free',
            'Car for road test',
            'Rush road test appointment'
        ],
        'popular' => false
    ],
    [
        'name' => 'Complete',
        'lessons' => 20,
        'bonus' => 4,
        'price' => 1250,
        'description' => 'More lessons for your driving journey.',
        'features' => [
            '45 minutes per lesson',
            '4 bonus lessons free',
            'Car for road test',
            'Rush road test appointment'
        ],
        'popular' => false
    ]
];

function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Custom Packages | DriveN School</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
          rel="stylesheet">

    <!-- Existing project stylesheet -->
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        :root {
            --navy: #071d38;
            --blue: #123b69;
            --gold: #ffb52e;
            --light: #f3f7fc;
            --muted: #718198;
        }

        body {
            margin: 0;
            color: var(--navy);
            font-family: Arial, Helvetica, sans-serif;
        }

        /* Navbar: same DriveN structure */
        .driven-nav {
            background: var(--navy);
            padding: 14px 0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, .12);
        }

        .driven-nav .navbar-brand {
            color: #fff;
            font-size: 27px;
            font-weight: 800;
        }

        .brand-gold {
            color: var(--gold);
        }

        .driven-nav .nav-link {
            color: #f0f4fa;
            font-size: 14px;
            font-weight: 600;
            padding: 12px 13px !important;
        }

        .driven-nav .nav-link:hover {
            color: var(--gold);
        }

        .driven-nav .dropdown-menu {
            border: 0;
            border-radius: 10px;
            padding: 8px;
            min-width: 210px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .15);
        }

        .driven-nav .dropdown-item {
            padding: 11px 13px;
            border-radius: 6px;
            color: var(--navy);
            font-weight: 600;
            font-size: 14px;
        }

        .driven-nav .dropdown-item:hover {
            color: var(--navy);
            background: #fff0c7;
        }

        .btn-gold {
            display: inline-block;
            padding: 12px 22px;
            border-radius: 30px;
            background: var(--gold);
            color: var(--navy);
            text-decoration: none;
            font-weight: 800;
            transition: .25s;
        }

        .btn-gold:hover {
            background: #fff;
            color: var(--navy);
        }

        /* Hero */
        .custom-hero {
            position: relative;
            overflow: hidden;
            padding: 145px 0 100px;
            background:
                radial-gradient(circle at 85% 30%,
                    rgba(52, 113, 183, .35), transparent 35%),
                linear-gradient(120deg, #061529, #123b69 65%, #071d38);
            color: white;
        }

        .custom-hero::after {
            content: "";
            position: absolute;
            right: -100px;
            bottom: -210px;
            width: 380px;
            height: 380px;
            border: 2px solid rgba(255, 181, 46, .5);
            border-radius: 50%;
            box-shadow: 0 0 0 35px rgba(255, 181, 46, .04),
                        0 0 0 70px rgba(255, 181, 46, .03);
        }

        .custom-hero .container {
            position: relative;
            z-index: 1;
        }

        .hero-label {
            display: inline-block;
            border: 1px solid var(--gold);
            border-radius: 30px;
            padding: 8px 15px;
            color: var(--gold);
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 2px;
        }

        .custom-hero h1 {
            max-width: 800px;
            margin-top: 24px;
            font-size: clamp(2.7rem, 5vw, 4.5rem);
            line-height: 1.1;
            font-weight: 800;
            letter-spacing: -1px;
        }

        .custom-hero h1 span {
            color: var(--gold);
        }

        .custom-hero p {
            max-width: 620px;
            margin-top: 22px;
            color: #d1deee;
            line-height: 1.9;
            font-size: 17px;
        }

        .hero-stat {
            border-left: 3px solid var(--gold);
            padding-left: 14px;
        }

        .hero-stat strong {
            display: block;
            font-size: 23px;
            color: #fff;
        }

        .hero-stat span {
            color: #c6d4e6;
            font-size: 12px;
        }

        /* Packages */
        .packages-section {
            padding: 85px 0;
            background: var(--light);
        }

        .section-label {
            color: #b77c0e;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 4px;
        }

        .section-title {
            font-size: clamp(2rem, 4vw, 2.8rem);
            font-weight: 800;
        }

        .section-description {
            color: var(--muted);
            line-height: 1.8;
        }

        .custom-card {
            position: relative;
            height: 100%;
            display: flex;
            flex-direction: column;
            padding: 28px 23px 25px;
            background: #fff;
            border: 1px solid #e1e8f1;
            border-radius: 16px;
            box-shadow: 0 8px 28px rgba(7, 29, 56, .06);
            transition: .25s ease;
        }

        .custom-card:hover {
            transform: translateY(-8px);
            border-color: var(--gold);
            box-shadow: 0 18px 38px rgba(7, 29, 56, .12);
        }

        .custom-card.featured {
            border: 2px solid var(--gold);
        }

        .popular-badge {
            position: absolute;
            top: -13px;
            left: 50%;
            transform: translateX(-50%);
            padding: 7px 17px;
            border-radius: 30px;
            background: var(--gold);
            color: var(--navy);
            white-space: nowrap;
            font-size: 10px;
            font-weight: 900;
            letter-spacing: .5px;
        }

        .package-icon {
            width: 58px;
            height: 58px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 15px;
            background: #fff1cc;
            color: var(--navy);
            font-size: 26px;
        }

        .package-type {
            margin-top: 22px;
            color: var(--muted);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 2px;
        }

        .custom-card h3 {
            font-size: 24px;
            font-weight: 800;
        }

        .package-description {
            min-height: 44px;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.6;
        }

        .package-price {
            margin: 17px 0 5px;
            font-size: 38px;
            font-weight: 900;
            letter-spacing: -1px;
        }

        .package-price sup {
            font-size: 17px;
            top: -.8em;
        }

        .price-caption {
            color: var(--muted);
            font-size: 12px;
        }

        .bonus-box {
            margin: 18px 0;
            padding: 11px;
            border-radius: 8px;
            background: #fff5df;
            color: #8b5b00;
            font-size: 13px;
            font-weight: 700;
        }

        .package-features {
            list-style: none;
            padding: 0;
            margin: 10px 0 25px;
        }

        .package-features li {
            display: flex;
            gap: 9px;
            margin-bottom: 12px;
            color: #42556e;
            font-size: 13px;
            line-height: 1.5;
        }

        .package-features i {
            color: #21845a;
        }

        .choose-btn {
            display: block;
            margin-top: auto;
            padding: 14px 12px;
            border-radius: 30px;
            background: var(--navy);
            color: white;
            text-align: center;
            text-decoration: none;
            font-size: 13px;
            font-weight: 800;
            box-shadow: 5px 0 0 var(--gold);
            transition: .25s;
        }

        .choose-btn i {
            margin-left: 8px;
            color: var(--gold);
        }

        .choose-btn:hover {
            background: var(--gold);
            color: var(--navy);
        }

        .choose-btn:hover i {
            color: var(--navy);
        }

        /* CTA */
        .custom-cta {
            padding: 55px 25px;
            border-radius: 18px;
            background: linear-gradient(120deg, var(--navy), var(--blue));
            color: #fff;
        }

        .custom-cta h2 {
            font-weight: 800;
        }

        .custom-cta p {
            color: #d1deee;
        }

        /* Footer */
        .custom-footer {
            padding: 25px 15px;
            background: var(--navy);
            color: #d1deee;
            text-align: center;
            font-size: 13px;
        }

        @media (max-width: 991px) {
            .driven-nav .navbar-collapse {
                padding-top: 15px;
            }

            .custom-hero {
                padding: 120px 0 75px;
            }
        }

        @media (max-width: 575px) {
            .packages-section {
                padding: 60px 0;
            }

            .custom-card {
                padding: 26px 22px;
            }
        }
    </style>
</head>

<body>

<!-- NAVBAR: keep the same menu structure -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top driven-nav">
    <div class="container">

        <a class="navbar-brand" href="index.php#home">
            <span class="brand-gold">D</span> Drive<span class="brand-gold">N</span>
        </a>

        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#mainNav"
                aria-controls="mainNav"
                aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">

            <ul class="navbar-nav mx-auto align-items-lg-center">

                <li class="nav-item">
                    <a class="nav-link" href="index.php#home">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="index.php#lessons">Lessons</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"
                       href="#"
                       role="button"
                       data-bs-toggle="dropdown"
                       aria-expanded="false">
                        Packages
                    </a>

                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="package.php">
                                All Packages
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="standard-package.php">
                                Standard Package
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="individual-lessons.php">
                                Individual Lessons
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="custom-packages.php">
                                Custom Packages
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="index.php#about">About</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="index.php#reviews">Reviews</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact</a>
                </li>

            </ul>

            <a href="booking.php" class="btn-gold">
                Book a Lesson <i class="bi bi-arrow-up-right"></i>
            </a>

        </div>
    </div>
</nav>

<!-- HERO -->
<section class="custom-hero">
    <div class="container">

        <span class="hero-label">DRIVEN SCHOOL · CUSTOM PACKAGES</span>

        <h1>
            Find Your Fit.<br>
            <span>Build Your Confidence.</span>
        </h1>

        <p>
            Choose a driving lesson package that matches your experience
            and goals. Get structured practice, professional guidance
            and bonus lessons to help you prepare for the road.
        </p>

        <div class="d-flex flex-wrap gap-3 mt-4">
            <a href="#packages" class="btn-gold">
                Explore Packages
                <i class="bi bi-arrow-down-right"></i>
            </a>

            <a href="booking.php"
               class="btn btn-outline-light rounded-pill px-4 py-3">
                Book a Lesson
            </a>
        </div>

        <div class="row g-4 mt-4">
            <div class="col-auto">
                <div class="hero-stat">
                    <strong>5–20</strong>
                    <span>Driving Lessons</span>
                </div>
            </div>

            <div class="col-auto">
                <div class="hero-stat">
                    <strong>1–4</strong>
                    <span>Bonus Lessons</span>
                </div>
            </div>

            <div class="col-auto">
                <div class="hero-stat">
                    <strong>45 min</strong>
                    <span>Each Lesson</span>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- DYNAMIC PACKAGE CARDS -->
<section class="packages-section" id="packages">
    <div class="container">

        <div class="text-center mb-5">
            <span class="section-label">CHOOSE YOUR PLAN</span>

            <h2 class="section-title mt-3">
                Custom Driving Packages
            </h2>

            <p class="section-description mt-3">
                Explore our flexible packages and choose the practice
                plan that works best for you.
            </p>
        </div>

        <div class="row g-4">

            <?php foreach ($customPackages as $package): ?>

                <div class="col-md-6 col-xl-3">

                    <div class="custom-card
                        <?= $package['popular'] ? 'featured' : '' ?>">

                        <?php if ($package['popular']): ?>
                            <span class="popular-badge">
                                MOST POPULAR
                            </span>
                        <?php endif; ?>

                        <div class="package-icon">
                            <i class="bi bi-car-front-fill"></i>
                        </div>

                        <div class="package-type">CUSTOM PACKAGE</div>

                        <h3 class="mt-2">
                            <?= e($package['name']) ?>
                        </h3>

                        <p class="package-description">
                            <?= e($package['description']) ?>
                        </p>

                        <div class="package-price">
                            <sup>$</sup><?= number_format($package['price']) ?>
                            <span class="fs-6">.00</span>
                        </div>

                        <div class="price-caption">Per Package</div>

                        <div class="bonus-box">
                            <i class="bi bi-gift-fill"></i>
                            <?= (int) $package['lessons'] ?> lessons
                            + <?= (int) $package['bonus'] ?>
                            bonus
                            <?= $package['bonus'] === 1
                                ? 'lesson'
                                : 'lessons' ?>
                        </div>

                        <ul class="package-features">
                            <?php foreach ($package['features'] as $feature): ?>
                                <li>
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span><?= e($feature) ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>

                        <a class="choose-btn"
                           href="booking.php?package=custom-<?= (int) $package['lessons'] ?>">
                            Choose Package
                            <i class="bi bi-arrow-right"></i>
                        </a>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

        <!-- CALL TO ACTION -->
        <div class="custom-cta text-center mt-5">
            <h2>Not Sure Which Package to Choose?</h2>

            <p class="mt-3 mb-4">
                Contact us and let us help you choose the right
                driving lesson plan for your needs.
            </p>

            <a href="contact.php" class="btn-gold">
                Contact Us <i class="bi bi-arrow-right"></i>
            </a>
        </div>

    </div>
</section>

<!-- FOOTER -->
<footer class="custom-footer">
    <span class="brand-gold">DriveN</span>
    &nbsp; · &nbsp; Safe Drivers. Brighter Futures.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

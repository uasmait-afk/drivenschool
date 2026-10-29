<?php
$services = [
    [
        'title' => 'Driving Lesson',
        'subtitle' => '45-minute individual lesson',
        'price' => 55,
        'unit' => 'Per Lesson',
        'icon' => 'bi-steering-wheel',
        'features' => [
            '45 mins with instructor',
            'Car available for your road test',
            'All skill levels welcome',
            'Flexible scheduling'
        ],
        'code' => 'driving-lesson'
    ],
    [
        'title' => '5-Hour Course',
        'subtitle' => 'Pre-licensing course',
        'price' => 50,
        'unit' => 'Per Course',
        'icon' => 'bi-file-earmark-text',
        'features' => [
            'DMV-approved course',
            'Available online',
            'Required for road test',
            'Certificate included'
        ],
        'code' => 'five-hour-course'
    ],
    [
        'title' => 'Road Test Appointment',
        'subtitle' => 'Pre-licensing course',
        'price' => 50,
        'unit' => 'Per Course',
        'icon' => 'bi-calendar-check',
        'features' => [
            'Appointment within 1 week',
            'Not guaranteed',
            'Best value',
            'Affordable service'
        ],
        'code' => 'road-test-appointment'
    ],
    [
        'title' => 'Highway Lesson',
        'subtitle' => 'Highway driving lesson',
        'price' => 120,
        'unit' => 'Per Lesson',
        'icon' => 'bi-signpost-split',
        'features' => [
            'Highway and expressway skills',
            'Minimum 2 lessons',
            'Experienced instructors',
            'Build speed confidence'
        ],
        'code' => 'highway-lesson'
    ],
    [
        'title' => 'Car for Road Test (Within 1-3 Days)',
        'subtitle' => 'Car rental for road test',
        'price' => 200,
        'unit' => 'Per Test',
        'icon' => 'bi-car-front-fill',
        'features' => [
            'DMV-ready vehicle',
            'Instructor included',
            'Fully insured and equipped',
            'Arrive stress-free'
        ],
        'code' => 'road-test-car-1-3-days'
    ],
    [
        'title' => 'Car for Road Test',
        'subtitle' => 'Car rental for road test',
        'price' => 150,
        'unit' => 'Per Test',
        'icon' => 'bi-car-front',
        'features' => [
            'DMV-ready vehicle',
            'Instructor included',
            'Fully insured and equipped',
            'Arrive stress-free'
        ],
        'code' => 'road-test-car'
    ]
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Individual Lessons & Services | DriveN School</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
    :root {
        --navy: #071d38;
        --blue: #123b69;
        --gold: #ffb52e;
        --light: #f2f7fd;
        --muted: #74849b;
    }

    * {
        box-sizing: border-box;
    }

    html {
        scroll-behavior: smooth;
        scroll-padding-top: 90px;
    }

    body {
        margin: 0;
        font-family: Arial, Helvetica, sans-serif;
        color: var(--navy);
        background: var(--light);
    }

    /* Navbar */
    .driven-nav {
        background: var(--navy);
        padding: 14px 0;
        box-shadow: 0 4px 18px rgba(0, 0, 0, .12);
    }

    .navbar-brand {
        font-size: 27px;
        font-weight: 800;
        color: #fff !important;
        letter-spacing: -.8px;
    }

    .brand-mark {
        color: var(--gold);
    }

    .driven-nav .nav-link {
        color: #edf3fb;
        font-size: 14px;
        font-weight: 600;
        padding: 12px 13px !important;
        position: relative;
    }

    .driven-nav .nav-link:hover,
    .driven-nav .nav-link.active {
        color: var(--gold);
    }

    .driven-nav .nav-link.active::after {
        content: "";
        height: 3px;
        width: 28px;
        background: var(--gold);
        position: absolute;
        bottom: 2px;
        left: 13px;
    }

    .btn-gold {
        background: var(--gold);
        color: var(--navy);
        border: 1px solid var(--gold);
        border-radius: 30px;
        padding: 12px 22px;
        font-weight: 800;
        text-decoration: none;
        display: inline-block;
        transition: .25s;
    }

    .btn-gold:hover {
        background: #fff;
        color: var(--navy);
        border-color: #fff;
        transform: translateY(-2px);
    }

    /* Hero */
    .individual-hero {
        position: relative;
        overflow: hidden;
        min-height: 360px;
        padding: 130px 0 75px;
        color: #fff;
        background:
            radial-gradient(circle at 80% 35%,
                rgba(41, 102, 160, .45),
                transparent 38%),
            linear-gradient(120deg, #06172d, #123b69 75%, #071d38);
    }

    .individual-hero::before {
        content: "";
        position: absolute;
        width: 330px;
        height: 330px;
        right: -90px;
        bottom: -205px;
        border: 2px solid rgba(255, 181, 46, .55);
        border-radius: 50%;
        box-shadow:
            0 0 0 30px rgba(255, 181, 46, .05),
            0 0 0 65px rgba(255, 181, 46, .04);
    }

    .individual-hero .container {
        position: relative;
        z-index: 1;
    }

    .hero-label {
        display: inline-block;
        padding: 9px 15px;
        border: 1px solid var(--gold);
        border-radius: 30px;
        color: var(--gold);
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 2px;
    }

    .individual-hero h1 {
        font-size: clamp(2.7rem, 5vw, 4.5rem);
        font-weight: 800;
        letter-spacing: -1.5px;
        line-height: 1.08;
        margin-top: 22px;
    }

    .individual-hero h1 span {
        color: var(--gold);
    }

    .individual-hero p {
        max-width: 590px;
        color: #d0dced;
        font-size: 17px;
        line-height: 1.8;
        margin-top: 20px;
    }

    /* Service section */
    .services-section {
        padding: 75px 0 85px;
        background:
            radial-gradient(ellipse at top,
                #ffffff 0%,
                #f2f7fd 70%);
    }

    .section-kicker {
        color: #c18413;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 4px;
    }

    .section-heading {
        font-size: clamp(2rem, 4vw, 2.8rem);
        font-weight: 800;
        margin-top: 12px;
    }

    .section-description {
        color: var(--muted);
        line-height: 1.8;
        max-width: 560px;
        margin: 0 auto;
    }

    /* Dynamic cards */
    .service-card {
        height: 100%;
        padding: 27px 25px 25px;
        background: rgba(255, 255, 255, .95);
        border: 1px solid #e5edf7;
        border-radius: 14px;
        box-shadow: 0 8px 28px rgba(16, 49, 86, .07);
        transition:
            transform .25s ease,
            box-shadow .25s ease,
            border-color .25s ease;
        display: flex;
        flex-direction: column;
    }

    .service-card:hover {
        transform: translateY(-7px);
        border-color: var(--gold);
        box-shadow: 0 18px 38px rgba(16, 49, 86, .13);
    }

    .service-card-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .service-icon {
        width: 55px;
        height: 55px;
        flex-shrink: 0;
        border-radius: 50%;
        background: #fff0c7;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--navy);
        font-size: 25px;
    }

    .popular-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 30px;
        background: var(--gold);
        color: var(--navy);
        font-size: 10px;
        font-weight: 900;
        letter-spacing: .5px;
    }

    .service-price {
        margin-top: 18px;
        display: flex;
        align-items: baseline;
        flex-wrap: wrap;
        gap: 9px;
    }

    .service-price .amount {
        font-size: clamp(2rem, 3vw, 2.45rem);
        font-weight: 900;
        line-height: 1;
        letter-spacing: -1px;
    }

    .service-price sup {
        font-size: 15px;
        top: -.7em;
    }

    .service-price .cents {
        font-size: 15px;
        letter-spacing: 0;
    }

    .service-price .unit {
        font-size: 13px;
        color: var(--muted);
    }

    .service-title {
        margin-top: 20px;
        margin-bottom: 5px;
        font-size: 19px;
        font-weight: 800;
        line-height: 1.4;
    }

    .service-subtitle {
        color: #536985;
        font-size: 14px;
        margin-bottom: 17px;
    }

    .service-features {
        list-style: none;
        padding: 0;
        margin: 0 0 24px;
    }

    .service-features li {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        color: #25496f;
        font-size: 13px;
        line-height: 1.6;
        margin-bottom: 8px;
    }

    .service-features i {
        color: #d59a18;
        font-size: 14px;
        margin-top: 2px;
    }

    .choose-btn {
        margin-top: auto;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
        width: 100%;
        padding: 13px 16px;
        border-radius: 30px;
        background: var(--navy);
        color: #fff;
        text-decoration: none;
        font-size: 13px;
        font-weight: 800;
        box-shadow: 5px 0 0 var(--gold);
        transition: .25s;
    }

    .choose-btn i {
        color: var(--gold);
        font-size: 17px;
    }

    .choose-btn:hover {
        background: var(--gold);
        color: var(--navy);
        box-shadow: 5px 0 0 var(--navy);
    }

    .choose-btn:hover i {
        color: var(--navy);
    }

    /* Footer */
    .driven-footer {
        background: var(--navy);
        color: #d6e0ee;
        text-align: center;
        padding: 27px 15px;
        font-size: 13px;
        position: relative;
        overflow: hidden;
    }

    .driven-footer::before {
        content: "";
        position: absolute;
        width: 180px;
        height: 180px;
        border: 1px solid rgba(255, 181, 46, .3);
        border-radius: 50%;
        top: -140px;
        left: 10%;
    }

    .footer-gold {
        color: var(--gold);
    }

    @media (max-width: 991px) {
        .driven-nav .nav-link.active::after {
            display: none;
        }

        .driven-nav .navbar-collapse {
            padding-top: 15px;
        }

        .individual-hero {
            padding: 115px 0 65px;
        }
    }

    @media (max-width: 575px) {
        .individual-hero h1 {
            font-size: 2.6rem;
        }

        .services-section {
            padding: 55px 0;
        }

        .service-card {
            padding: 23px 20px;
        }
    }
    </style>
</head>

<body>

    <!-- Navbar -->
    <?php require_once __DIR__ . '/includes/navbar.php'; ?>

    <!-- Hero Section -->
    <section class="individual-hero">
        <div class="container">
            <span class="hero-label">INDIVIDUAL LESSONS</span>

            <h1>
                Single Lessons &amp;<br>
                <span>Services</span>
            </h1>

            <p>
                Flexible options, professional instruction and additional
                services to help you become a confident and safe driver.
            </p>

            <a href="#services" class="btn-gold mt-2">
                Explore Services
                <i class="bi bi-arrow-down-right"></i>
            </a>
        </div>
    </section>

    <!-- Services / Dynamic Cards -->
    <section class="services-section" id="services">
        <div class="container">

            <div class="text-center mb-5">
                <span class="section-kicker">OUR SERVICES</span>

                <h2 class="section-heading">
                    Driving Lessons &amp; More
                </h2>

                <p class="section-description mt-3">
                    Choose the service that fits your goals. All our services
                    are designed to give you the best learning experience
                    and support.
                </p>
            </div>

            <div class="row g-4">

                <?php foreach ($services as $service): ?>
                <div class="col-md-6 col-xl-4">

                    <div class="service-card">

                        <div class="service-card-top">
                            <div class="service-icon">
                                <i class="bi <?= htmlspecialchars(
                                    $service['icon'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>"></i>
                            </div>

                            <span class="popular-badge">POPULAR</span>
                        </div>

                        <div class="service-price">
                            <div class="amount">
                                <sup>$</sup><?= number_format(
                                    $service['price']
                                ) ?><span class="cents">.00</span>
                            </div>

                            <span class="unit">
                                <?= htmlspecialchars(
                                    $service['unit'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </span>
                        </div>

                        <h3 class="service-title">
                            <?= htmlspecialchars(
                                $service['title'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </h3>

                        <p class="service-subtitle">
                            <?= htmlspecialchars(
                                $service['subtitle'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </p>

                        <ul class="service-features">
                            <?php foreach ($service['features'] as $feature): ?>
                            <li>
                                <i class="bi bi-check-circle-fill"></i>

                                <span>
                                    <?= htmlspecialchars(
                                            $feature,
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                </span>
                            </li>
                            <?php endforeach; ?>
                        </ul>

                        <a class="choose-btn" href="booking.php?service=<?= urlencode(
                                $service['code']
                            ) ?>">
                            Choose Package
                            <i class="bi bi-arrow-right"></i>
                        </a>

                    </div>
                </div>
                <?php endforeach; ?>

            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="driven-footer">
        <span class="footer-gold">———</span>
        &nbsp; DriveN &nbsp; · &nbsp; Safe Drivers. Brighter Futures. &nbsp;
        <span class="footer-gold">———</span>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
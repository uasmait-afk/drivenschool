<?php
$pageTitle = 'Driving Lessons | DriveN School';

$lessons = [
    [
        'icon' => 'bi-car-front-fill',
        'title' => 'Individual Driving Lesson',
        'description' => 'Learn essential driving skills with personalized, one-on-one instruction.',
        'price' => '$55',
        'duration' => '45 Minutes',
        'link' => 'individual-lessons.php'
    ],
    [
        'icon' => 'bi-signpost-split-fill',
        'title' => 'Highway Driving Lesson',
        'description' => 'Practice highway merging, lane changes, and safe driving techniques.',
        'price' => '$120',
        'duration' => '90 Minutes',
        'link' => 'booking.php'
    ],
    [
        'icon' => 'bi-car-front',
        'title' => 'Road Test Car Rental',
        'description' => 'Arrange a vehicle for your road test and prepare for your appointment.',
        'price' => '$150',
        'duration' => 'Road Test',
        'link' => 'booking.php'
    ],
    [
        'icon' => 'bi-journal-check',
        'title' => '5-Hour Pre-Licensing Course',
        'description' => 'Learn important road safety principles and pre-licensing topics.',
        'price' => '$50',
        'duration' => '5 Hours',
        'link' => 'booking.php'
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?></title>

    <meta name="description"
          content="Explore driving lessons and road test services at DriveN School.">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
          rel="stylesheet">

    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        :root {
            --navy: #101d35;
            --navy-deep: #091426;
            --blue: #2878f0;
            --gold: #f5a623;
            --gold-hover: #ffbb4c;
            --text: #5c687c;
            --light: #f5f7fb;
        }

        body {
            margin: 0;
            color: var(--navy);
            font-family: "DM Sans", Arial, sans-serif;
            line-height: 1.7;
        }

        .lessons-hero {
            padding: 155px 0 100px;
            color: #fff;
            background:
                linear-gradient(90deg, rgba(9,20,38,.94), rgba(9,20,38,.65)),
                url("assets/images/lessons-hero.png") center/cover no-repeat,
                var(--navy-deep);
        }

        .hero-content {
            max-width: 760px;
        }

        .hero-label {
            display: inline-block;
            margin-bottom: 22px;
            padding: 8px 15px;
            border: 1px solid rgba(245,166,35,.5);
            border-radius: 30px;
            background: rgba(245,166,35,.12);
            color: #ffd17b;
            font-size: .9rem;
            font-weight: 700;
        }

        .lessons-hero h1 {
            margin-bottom: 22px;
            color: #fff;
            font-size: clamp(2.5rem, 5vw, 4.4rem);
            font-weight: 800;
            line-height: 1.13;
        }

        .gold-text {
            color: var(--gold);
        }

        .lessons-hero p {
            max-width: 650px;
            margin-bottom: 28px;
            color: #e0e7f2;
            font-size: 1.05rem;
        }

        .btn-gold {
            display: inline-block;
            padding: 13px 23px;
            border: 2px solid var(--gold);
            border-radius: 8px;
            background: var(--gold);
            color: var(--navy-deep);
            font-weight: 800;
            transition: .25s;
        }

        .btn-gold:hover {
            border-color: var(--gold-hover);
            background: var(--gold-hover);
            color: var(--navy-deep);
            transform: translateY(-2px);
        }

        .btn-outline-light-custom {
            display: inline-block;
            padding: 13px 23px;
            border: 2px solid #fff;
            border-radius: 8px;
            color: #fff;
            font-weight: 700;
            transition: .25s;
        }

        .btn-outline-light-custom:hover {
            background: #fff;
            color: var(--navy);
        }

        .section-space {
            padding: 85px 0;
        }

        .section-title {
            margin-bottom: 15px;
            color: var(--navy);
            font-size: clamp(2rem, 3.5vw, 2.8rem);
            font-weight: 800;
            text-align: center;
        }

        .section-description {
            max-width: 680px;
            margin: 0 auto 45px;
            color: var(--text);
            text-align: center;
        }

        .lesson-card {
            height: 100%;
            overflow: hidden;
            border: 1px solid #e6eaf1;
            border-radius: 15px;
            background: #fff;
            box-shadow: 0 10px 32px rgba(16,29,53,.06);
            transition: transform .25s, box-shadow .25s;
        }

        .lesson-card:hover {
            transform: translateY(-7px);
            box-shadow: 0 20px 42px rgba(16,29,53,.12);
        }

        .lesson-card-body {
            padding: 28px 25px;
        }

        .lesson-icon {
            display: flex;
            width: 62px;
            height: 62px;
            align-items: center;
            justify-content: center;
            margin-bottom: 22px;
            border-radius: 14px;
            background: #fff3dc;
            color: #c98108;
            font-size: 1.8rem;
        }

        .lesson-card h3 {
            min-height: 58px;
            margin-bottom: 12px;
            font-size: 1.25rem;
            font-weight: 800;
        }

        .lesson-card p {
            min-height: 82px;
            margin-bottom: 20px;
            color: var(--text);
            font-size: .95rem;
        }

        .lesson-duration {
            color: #657188;
            font-size: .9rem;
        }

        .lesson-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 20px 25px;
            border-top: 1px solid #e8ebf1;
            background: #fbfcfe;
        }

        .lesson-price {
            font-size: 1.65rem;
            font-weight: 800;
        }

        .lesson-price small {
            display: block;
            color: #778196;
            font-size: .8rem;
            font-weight: 500;
        }

        .lesson-link {
            color: var(--blue);
            font-weight: 800;
            white-space: nowrap;
        }

        .lesson-link:hover {
            color: var(--navy);
        }

        .benefits-section {
            background: var(--light);
        }

        .benefit-card {
            height: 100%;
            padding: 28px;
            border: 1px solid #e7ebf2;
            border-radius: 14px;
            background: #fff;
        }

        .benefit-card i {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 52px;
            height: 52px;
            margin-bottom: 18px;
            border-radius: 12px;
            background: #fff3dc;
            color: #c98108;
            font-size: 1.5rem;
        }

        .benefit-card h3 {
            font-size: 1.15rem;
            font-weight: 800;
        }

        .benefit-card p {
            margin-bottom: 0;
            color: var(--text);
        }

        .steps-section {
            background: #fff;
        }

        .step-number {
            display: flex;
            width: 55px;
            height: 55px;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px;
            border-radius: 50%;
            background: var(--navy);
            color: var(--gold);
            font-size: 1.25rem;
            font-weight: 800;
        }

        .step-card {
            padding: 20px;
            text-align: center;
        }

        .step-card h3 {
            font-size: 1.15rem;
            font-weight: 800;
        }

        .step-card p {
            color: var(--text);
        }

        .lessons-cta {
            padding: 75px 0;
            background:
                radial-gradient(circle at 90% 20%, rgba(40,120,240,.25), transparent 30%),
                var(--navy-deep);
            color: #fff;
            text-align: center;
        }

        .lessons-cta h2 {
            margin-bottom: 15px;
            color: #fff;
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 800;
        }

        .lessons-cta p {
            max-width: 650px;
            margin: 0 auto 25px;
            color: #d8e0ed;
        }

        .lessons-footer {
            padding: 24px 0;
            background: #060e1b;
            color: #c8d2e0;
            text-align: center;
        }

        .lessons-footer p {
            margin: 0;
            font-size: .9rem;
        }

        @media (max-width: 767px) {
            .lessons-hero {
                padding: 125px 0 70px;
            }

            .section-space {
                padding: 60px 0;
            }

            .lesson-card h3,
            .lesson-card p {
                min-height: auto;
            }
        }

        @media (max-width: 420px) {
            .lesson-card-body {
                padding: 23px 19px;
            }

            .lesson-footer {
                padding: 18px;
            }

            .lesson-price {
                font-size: 1.4rem;
            }
        }
    </style>
</head>

<body>

<?php require_once __DIR__ . '/includes/navbar.php'; ?>

<!-- Hero -->
<section class="lessons-hero">
    <div class="container">
        <div class="hero-content">

            <span class="hero-label">
                <i class="bi bi-patch-check-fill me-2"></i>
                Your Driving Journey Starts Here
            </span>

            <h1>
                Learn to Drive.<br>
                <span class="gold-text">Drive with Confidence.</span>
            </h1>

            <p>
                Develop essential driving skills with practical lessons
                designed to help you become a safer and more confident driver.
                Find a lesson that fits your learning goals.
            </p>

            <div class="d-flex flex-wrap gap-3">
                <a href="#lessons" class="btn-gold">
                    Explore Lessons
                    <i class="bi bi-arrow-right ms-2"></i>
                </a>

                <a href="booking.php" class="btn-outline-light-custom">
                    <i class="bi bi-calendar-check me-2"></i>
                    Book a Lesson
                </a>
            </div>

        </div>
    </div>
</section>

<!-- Driving Lessons -->
<section class="section-space" id="lessons">
    <div class="container">

        <h2 class="section-title">
            Driving Lessons <span class="gold-text">&amp; Services</span>
        </h2>

        <p class="section-description">
            Explore our driving services and choose the option that matches
            your experience, schedule, and driving goals.
        </p>

        <div class="row g-4">
            <?php foreach ($lessons as $lesson): ?>
                <div class="col-md-6 col-xl-3">
                    <article class="lesson-card">

                        <div class="lesson-card-body">
                            <div class="lesson-icon">
                                <i class="bi <?= htmlspecialchars($lesson['icon'], ENT_QUOTES, 'UTF-8'); ?>"></i>
                            </div>

                            <h3>
                                <?= htmlspecialchars($lesson['title'], ENT_QUOTES, 'UTF-8'); ?>
                            </h3>

                            <p>
                                <?= htmlspecialchars($lesson['description'], ENT_QUOTES, 'UTF-8'); ?>
                            </p>

                            <div class="lesson-duration">
                                <i class="bi bi-clock me-2"></i>
                                <?= htmlspecialchars($lesson['duration'], ENT_QUOTES, 'UTF-8'); ?>
                            </div>
                        </div>

                        <div class="lesson-footer">
                            <div class="lesson-price">
                                <?= htmlspecialchars($lesson['price'], ENT_QUOTES, 'UTF-8'); ?>
                                <small>Starting price</small>
                            </div>

                            <a class="lesson-link"
                               href="<?= htmlspecialchars($lesson['link'], ENT_QUOTES, 'UTF-8'); ?>">
                                Explore
                                <i class="bi bi-arrow-up-right ms-1"></i>
                            </a>
                        </div>

                    </article>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>

<!-- Why Choose Us -->
<section class="benefits-section section-space">
    <div class="container">

        <h2 class="section-title">
            Why Choose <span class="gold-text">DriveN School?</span>
        </h2>

        <p class="section-description">
            We focus on practical learning, road awareness, and a clear
            booking experience to support your driving journey.
        </p>

        <div class="row g-4">

            <div class="col-md-6 col-lg-3">
                <div class="benefit-card">
                    <i class="bi bi-person-check-fill"></i>
                    <h3>Personalized Lessons</h3>
                    <p>
                        Learn at your pace with lessons focused on your
                        individual driving needs.
                    </p>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="benefit-card">
                    <i class="bi bi-shield-check"></i>
                    <h3>Safety First</h3>
                    <p>
                        Build awareness and responsible driving habits
                        through practical instruction.
                    </p>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="benefit-card">
                    <i class="bi bi-wallet2"></i>
                    <h3>Clear Pricing</h3>
                    <p>
                        Review service prices before selecting your preferred
                        driving lesson.
                    </p>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="benefit-card">
                    <i class="bi bi-calendar-check"></i>
                    <h3>Online Booking</h3>
                    <p>
                        Submit your lesson request through the online booking
                        page at a convenient time.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- How It Works -->
<section class="steps-section section-space">
    <div class="container">

        <h2 class="section-title">
            How It <span class="gold-text">Works</span>
        </h2>

        <p class="section-description">
            Three simple steps to get started with your driving lessons.
        </p>

        <div class="row g-4">

            <div class="col-md-4">
                <div class="step-card">
                    <div class="step-number">01</div>
                    <h3>Choose Your Lesson</h3>
                    <p>
                        Compare our driving services and select an option
                        that suits your needs.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="step-card">
                    <div class="step-number">02</div>
                    <h3>Submit Your Booking</h3>
                    <p>
                        Complete the booking form with your contact details
                        and preferred appointment.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="step-card">
                    <div class="step-number">03</div>
                    <h3>Prepare to Learn</h3>
                    <p>
                        Follow up on your booking request and get ready for
                        your driving lesson.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="lessons-cta">
    <div class="container">

        <h2>
            Ready to Start Your<br>
            <span class="gold-text">Driving Journey?</span>
        </h2>

        <p>
            Choose a service and send your booking request to take the
            next step toward confident driving.
        </p>

        <a href="booking.php" class="btn-gold">
            Book Your Lesson
            <i class="bi bi-arrow-right ms-2"></i>
        </a>

    </div>
</section>

<!-- Footer -->
<footer class="lessons-footer">
    <div class="container">
        <p>
            &copy; <?= date('Y'); ?> DriveN School. All rights reserved.
        </p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
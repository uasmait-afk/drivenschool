
<?php
$packages = [
    'basic' => [
        'title' => 'Basic Package',
        'eyebrow' => 'YOUR FIRST STEP',
        'description' => 'Build a strong foundation and start your driving journey with confidence.',
        'price' => '149',
        'price_note' => 'per package',
        'lessons' => '3 lessons',
        'duration' => '60 minutes per lesson',
        'tag' => 'STARTER',
        'features' => [
            '3 practical driving lessons',
            'Vehicle controls and basic manoeuvres',
            'Traffic signs and road rules',
            'Beginner road awareness',
            'Instructor-guided practice',
        ],
        'faqs' => [
            ['Who is this package for?', 'It is designed for beginners who want to start learning driving fundamentals.'],
            ['How long is each lesson?', 'The demonstration duration is 60 minutes per lesson. Confirm the actual duration with the school.'],
            ['Can I book more lessons?', 'Yes. Contact the school to discuss additional lessons.'],
        ],
    ],
    'standard' => [
        'title' => 'Standard Package',
        'eyebrow' => 'BUILD YOUR CONFIDENCE',
        'description' => 'Improve your driving ability with structured practice and more time behind the wheel.',
        'price' => '279',
        'price_note' => 'per package',
        'lessons' => '6 lessons',
        'duration' => '60 minutes per lesson',
        'tag' => 'MOST POPULAR',
        'features' => [
            '6 practical driving lessons',
            'Vehicle control and turning practice',
            'Lane changes and road positioning',
            'Parking and reversing practice',
            'Road safety and hazard awareness',
        ],
        'faqs' => [
            ['Is this suitable for beginners?', 'It can suit beginners and learners who want more guided practice. Discuss your experience with the school.'],
            ['Does it include parking practice?', 'Parking and reversing practice are listed as learning topics in this demonstration package.'],
            ['Can I change my lesson schedule?', 'Contact the school to discuss available scheduling options.'],
        ],
    ],
    'individual' => [
        'title' => 'Individual Lessons',
        'eyebrow' => 'LEARN AT YOUR PACE',
        'description' => 'Choose individual lessons and focus on the driving skills you want to improve.',
        'price' => '59',
        'price_note' => 'per lesson',
        'lessons' => 'Flexible lessons',
        'duration' => '60 minutes per lesson',
        'tag' => 'FLEXIBLE',
        'features' => [
            'Book individual driving lessons',
            'Focus on specific driving skills',
            'Practice parking and manoeuvres',
            'Refresh road safety knowledge',
            'Discuss personal learning goals',
        ],
        'faqs' => [
            ['Can I book just one lesson?', 'Yes, this demonstration option is designed around individual lessons. Confirm availability before booking.'],
            ['Can I choose what to practise?', 'You can discuss your priorities with the instructor when arranging your lesson.'],
            ['Is the price for a complete course?', 'No. The placeholder price is shown per lesson, not for a full course.'],
        ],
    ],
    'custom' => [
        'title' => 'Custom Package',
        'eyebrow' => 'YOUR GOALS, YOUR PLAN',
        'description' => 'Discuss your experience, schedule and learning goals to plan a more personalized driving course.',
        'price' => '399',
        'price_note' => 'demo package price',
        'lessons' => 'Custom lesson plan',
        'duration' => 'To be agreed',
        'tag' => 'PERSONALIZED',
        'features' => [
            'Discuss your driving experience',
            'Choose your learning priorities',
            'Plan lessons around your goals',
            'Ask about scheduling options',
            'Request a personalized quote',
        ],
        'faqs' => [
            ['How is a custom package arranged?', 'Contact the school to discuss your experience and preferred learning plan.'],
            ['Is the price fixed?', 'No. The displayed amount is only a placeholder. A real quote must be confirmed by the school.'],
            ['Can I request a different lesson plan?', 'Yes. Describe your goals and ask the school what options are available.'],
        ],
    ],
];

$type = strtolower(trim($_GET['type'] ?? 'basic'));
$notFound = !isset($packages[$type]);

if ($notFound) {
    http_response_code(404);
    $type = 'basic';
}

$package = $packages[$type];

function e($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= e($package['title']) ?> | DriveN School</title>
    <meta name="description" content="<?= e($package['description']) ?>">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        :root {
            --ds-navy: #101c3a;
            --ds-blue: #174b8c;
            --ds-gold: #f5ae35;
            --ds-light: #f5f7fc;
            --ds-text: #46536b;
        }

        .package-page {
            color: var(--ds-navy);
            background: #fff;
            overflow: hidden;
        }

        .package-page a {
            text-decoration: none;
        }

        .package-hero {
            position: relative;
            padding: 95px 0 90px;
            color: #fff;
            background:
                radial-gradient(circle at 85% 15%,
                    rgba(245,174,53,.23), transparent 30%),
                linear-gradient(130deg, var(--ds-navy), var(--ds-blue));
        }

        .package-hero::after {
            content: "";
            position: absolute;
            width: 280px;
            height: 280px;
            right: -100px;
            bottom: -170px;
            border: 35px solid rgba(255,255,255,.07);
            border-radius: 50%;
            pointer-events: none;
        }

        .package-eyebrow {
            color: var(--ds-gold);
            font-size: .78rem;
            font-weight: 800;
            letter-spacing: 3px;
        }

        .package-hero h1 {
            max-width: 800px;
            margin: 18px 0;
            font-size: clamp(2.6rem, 6vw, 4.7rem);
            line-height: 1.08;
            font-weight: 850;
            letter-spacing: -1.5px;
        }

        .package-hero .lead-copy {
            max-width: 650px;
            color: #e0e8f6;
            line-height: 1.85;
        }

        .package-tag {
            display: inline-block;
            padding: 8px 13px;
            margin-bottom: 8px;
            border: 1px solid rgba(245,174,53,.45);
            border-radius: 30px;
            color: var(--ds-gold);
            font-size: .72rem;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .ds-btn {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            padding: 14px 23px;
            border: 0;
            border-radius: 9px;
            color: var(--ds-navy);
            background: var(--ds-gold);
            font-weight: 800;
            transition: .25s ease;
        }

        .ds-btn:hover {
            color: var(--ds-navy);
            background: #ffc65c;
            transform: translateY(-2px);
        }

        .ds-btn-outline {
            display: inline-flex;
            justify-content: center;
            padding: 13px 20px;
            border: 1px solid rgba(255,255,255,.45);
            border-radius: 9px;
            color: #fff;
            font-weight: 700;
        }

        .ds-btn-outline:hover {
            color: var(--ds-gold);
            border-color: var(--ds-gold);
        }

        .section-space {
            padding: 82px 0;
        }

        .section-title {
            margin-bottom: 14px;
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 850;
            letter-spacing: -.7px;
        }

        .section-description {
            max-width: 680px;
            margin: 0 auto;
            color: var(--ds-text);
            line-height: 1.8;
        }

        .lesson-section {
            background: var(--ds-light);
        }

        .lesson-card {
            height: 100%;
            padding: 27px;
            border: 1px solid #e5eaf3;
            border-radius: 17px;
            background: #fff;
            box-shadow: 0 10px 30px rgba(16,28,58,.045);
            transition: transform .25s ease, box-shadow .25s ease;
        }

        .lesson-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 18px 40px rgba(16,28,58,.10);
        }

        .lesson-icon {
            display: grid;
            place-items: center;
            width: 49px;
            height: 49px;
            margin-bottom: 20px;
            border-radius: 13px;
            background: #fff0cc;
            color: var(--ds-navy);
            font-size: 1.3rem;
        }

        .lesson-card h3 {
            font-size: 1.1rem;
            font-weight: 800;
        }

        .lesson-card p {
            margin: 0;
            color: var(--ds-text);
            line-height: 1.7;
        }

        .pricing-panel {
            position: relative;
            max-width: 800px;
            margin: 0 auto;
            padding: 42px;
            border: 1px solid rgba(245,174,53,.4);
            border-radius: 23px;
            background:
                radial-gradient(circle at 100% 0,
                    rgba(245,174,53,.12), transparent 35%),
                #fff;
            box-shadow: 0 22px 65px rgba(16,28,58,.09);
        }

        .price-amount {
            margin: 15px 0 0;
            font-size: clamp(3.2rem, 8vw, 5rem);
            font-weight: 850;
            letter-spacing: -2px;
            color: var(--ds-navy);
        }

        .price-note {
            color: var(--ds-text);
            font-size: .95rem;
        }

        .placeholder-note {
            padding: 12px 15px;
            margin-top: 23px;
            border-radius: 8px;
            background: #fff5df;
            color: #76501b;
            font-size: .88rem;
            line-height: 1.6;
        }

        .included-list {
            padding: 0;
            margin: 26px 0;
            list-style: none;
        }

        .included-list li {
            display: flex;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid #edf0f6;
            color: var(--ds-text);
        }

        .included-list li:last-child {
            border-bottom: 0;
        }

        .included-check {
            color: #13834c;
            font-weight: 900;
        }

        .faq-section {
            background: var(--ds-light);
        }

        .faq-wrap {
            max-width: 850px;
            margin: 0 auto;
        }

        .faq-wrap .accordion-item {
            margin-bottom: 12px;
            overflow: hidden;
            border: 1px solid #e5eaf3;
            border-radius: 12px;
            background: #fff;
        }

        .faq-wrap .accordion-button {
            padding: 20px;
            color: var(--ds-navy);
            font-weight: 750;
            box-shadow: none;
        }

        .faq-wrap .accordion-button:not(.collapsed) {
            background: #fff5df;
            color: var(--ds-navy);
        }

        .faq-wrap .accordion-body {
            color: var(--ds-text);
            line-height: 1.8;
        }

        .other-packages {
            padding: 75px 0;
            color: #fff;
            background: var(--ds-navy);
        }

        .other-package-link {
            display: block;
            height: 100%;
            padding: 21px;
            border: 1px solid rgba(255,255,255,.15);
            border-radius: 13px;
            color: #fff;
            background: rgba(255,255,255,.045);
            transition: .25s ease;
        }

        .other-package-link:hover,
        .other-package-link.active {
            color: #fff;
            border-color: var(--ds-gold);
            background: rgba(245,174,53,.11);
        }

        .other-package-link.active {
            box-shadow: inset 0 0 0 1px var(--ds-gold);
        }

        .other-package-link small {
            display: block;
            margin-top: 7px;
            color: #c7d2e4;
        }

        .package-footer {
            padding: 25px 0;
            color: #c7d2e4;
            background: #0a142b;
            font-size: .9rem;
        }

        @media (max-width: 767px) {
            .package-hero {
                padding: 68px 0;
            }

            .section-space {
                padding: 58px 0;
            }

            .pricing-panel {
                padding: 26px 22px;
            }

            .package-hero .ds-btn,
            .package-hero .ds-btn-outline {
                width: 100%;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .lesson-card,
            .ds-btn {
                transition: none;
            }
        }
    </style>
</head>

<body class="package-page">

<?php if ($notFound): ?>
    <div class="alert alert-warning text-center mb-0">
        Package not found. Showing the Basic Package.
    </div>
<?php endif; ?>

<?php include __DIR__ . '/includes/navbar.php'; ?>

<!-- HERO -->
<header class="package-hero">
    <div class="container position-relative">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <div class="package-eyebrow">
                    <?= e($package['eyebrow']) ?>
                </div>

                <h1><?= e($package['title']) ?></h1>

                <p class="lead-copy mb-4">
                    <?= e($package['description']) ?>
                </p>

                <span class="package-tag">
                    <?= e($package['tag']) ?>
                </span>

                <div class="d-flex flex-wrap gap-3 mt-4">
                    <a class="ds-btn"
                       href="index.php?package=<?= e($type) ?>#contact">
                        Enquire About This Package <span aria-hidden="true">&rarr;</span>
                    </a>

                    <a class="ds-btn-outline" href="#lessons">
                        Explore Lessons
                    </a>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="p-4 rounded-4"
                     style="background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.15)">
                    <div class="package-eyebrow mb-3">PACKAGE OVERVIEW</div>
                    <div class="mb-3">
                        <div class="fw-bold fs-5"><?= e($package['lessons']) ?></div>
                        <div class="text-white-50">Lesson plan</div>
                    </div>
                    <hr style="border-color:rgba(255,255,255,.2)">
                    <div class="mb-3">
                        <div class="fw-bold"><?= e($package['duration']) ?></div>
                        <div class="text-white-50">Demonstration duration</div>
                    </div>
                    <hr style="border-color:rgba(255,255,255,.2)">
                    <div class="fw-bold fs-5">
                        $<?= e($package['price']) ?>
                        <span class="text-white-50 fs-6 fw-normal">
                            <?= e($package['price_note']) ?>
                        </span>
                    </div>
                    <small class="text-white-50">
                        Editable placeholder price
                    </small>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- LESSON CARDS -->
<section class="lesson-section section-space" id="lessons">
    <div class="container">
        <div class="text-center mb-5">
            <div class="package-eyebrow">YOUR LEARNING JOURNEY</div>
            <h2 class="section-title mt-3">What you'll learn</h2>
            <p class="section-description">
                Explore the key skills and learning topics included in this
                demonstration package.
            </p>
        </div>

        <div class="row g-4">
            <?php foreach ($package['features'] as $index => $feature): ?>
                <div class="col-md-6 col-lg-4">
                    <article class="lesson-card">
                        <div class="lesson-icon" aria-hidden="true">
                            <?= ['↗', '✓', '⌖', '◉', '★'][$index % 5] ?>
                        </div>
                        <div class="package-eyebrow mb-2">
                            LESSON <?= sprintf('%02d', $index + 1) ?>
                        </div>
                        <h3><?= e($feature) ?></h3>
                        <p class="mt-2">
                            Build your knowledge through guided learning
                            and practice with an instructor.
                        </p>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- PRICING -->
<section class="section-space" id="pricing">
    <div class="container">
        <div class="text-center mb-5">
            <div class="package-eyebrow">SIMPLE & CLEAR</div>
            <h2 class="section-title mt-3">Package pricing</h2>
            <p class="section-description">
                Review the demonstration price and contact us to confirm
                actual pricing, availability and package terms.
            </p>
        </div>

        <div class="pricing-panel">
            <div class="row align-items-center g-4">
                <div class="col-md-7">
                    <span class="package-tag"><?= e($package['tag']) ?></span>
                    <h3 class="h3 fw-bold mt-3"><?= e($package['title']) ?></h3>

                    <div class="price-amount">
                        $<?= e($package['price']) ?>
                    </div>

                    <div class="price-note">
                        <?= e($package['price_note']) ?>
                    </div>

                    <div class="placeholder-note">
                        <strong>Demo price:</strong> This is an editable
                        placeholder, not a confirmed DriveN School price.
                        Update it before publishing the website.
                    </div>
                </div>

                <div class="col-md-5">
                    <h4 class="h6 fw-bold">PACKAGE HIGHLIGHTS</h4>

                    <ul class="included-list">
                        <?php foreach ($package['features'] as $feature): ?>
                            <li>
                                <span class="included-check" aria-hidden="true">✓</span>
                                <span><?= e($feature) ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <a class="ds-btn w-100"
                       href="index.php?package=<?= e($type) ?>#contact">
                        Enquire & Get Started
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ -->
<section class="faq-section section-space" id="faq">
    <div class="container">
        <div class="text-center mb-5">
            <div class="package-eyebrow">NEED TO KNOW MORE?</div>
            <h2 class="section-title mt-3">Frequently asked questions</h2>
            <p class="section-description">
                Helpful answers about the <?= e($package['title']) ?>.
            </p>
        </div>

        <div class="accordion faq-wrap" id="packageFaq">
            <?php foreach ($package['faqs'] as $index => $faq): ?>
                <div class="accordion-item">
                    <h3 class="accordion-header">
                        <button
                            class="accordion-button <?= $index !== 0 ? 'collapsed' : '' ?>"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#faq<?= $index ?>"
                            aria-expanded="<?= $index === 0 ? 'true' : 'false' ?>"
                            aria-controls="faq<?= $index ?>">
                            <?= e($faq[0]) ?>
                        </button>
                    </h3>

                    <div
                        id="faq<?= $index ?>"
                        class="accordion-collapse collapse <?= $index === 0 ? 'show' : '' ?>"
                        data-bs-parent="#packageFaq">
                        <div class="accordion-body">
                            <?= e($faq[1]) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- OTHER PACKAGES -->
<section class="other-packages">
    <div class="container">
        <div class="text-center mb-5">
            <div class="package-eyebrow">FIND YOUR BEST FIT</div>
            <h2 class="section-title mt-3">Explore other packages</h2>
            <p class="text-white-50">
                Compare the options and choose the learning plan that suits you.
            </p>
        </div>

        <div class="row g-3">
            <?php foreach ($packages as $key => $item): ?>
                <div class="col-sm-6 col-lg-3">
                    <a
                        href="package.php?type=<?= e($key) ?>"
                        class="other-package-link <?= $key === $type ? 'active' : '' ?>"
                        <?= $key === $type ? 'aria-current="page"' : '' ?>>
                        <span class="fw-bold"><?= e($item['title']) ?></span>
                        <small><?= e($item['lessons']) ?></small>
                        <span class="d-block mt-3" style="color:var(--ds-gold)">
                            View package &rarr;
                        </span>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="package-footer">
    <div class="container d-flex flex-wrap justify-content-between gap-3">
        <span>&copy; <?= date('Y') ?> DriveN School. All rights reserved.</span>
        <a href="index.php" class="text-white">Back to Home</a>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

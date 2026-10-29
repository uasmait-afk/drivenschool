<?php
declare(strict_types=1);

$pageTitle = '5-Hour Pre-Licensing Course | DriveN School';

require_once __DIR__ . '/includes/navbar.php';
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

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="assets/css/style.css">



    <style>
    /* ========================================
   DriveN School - 5 Hour Class Page
======================================== */

    .five-hour-page {
        --dn-navy: #101d35;
        --dn-deep: #091426;
        --dn-blue: #2878f0;
        --dn-gold: #f5a623;
        --dn-text: #526078;

        color: var(--dn-navy);
        background: #fff;
    }

    .five-hour-page *,
    .five-hour-page *::before,
    .five-hour-page *::after {
        box-sizing: border-box;
    }

    /* Hero */
    .five-hour-page .course-hero {
        position: relative;
        overflow: hidden;
        padding: 100px 0;
        color: #fff;
        background:
            linear-gradient(100deg,
                rgba(9, 20, 38, .97),
                rgba(16, 29, 53, .82)),
            url('https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?auto=format&fit=crop&w=1800&q=85') center / cover no-repeat;
    }

    .five-hour-page .eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 15px;
        border: 1px solid rgba(245, 166, 35, .45);
        border-radius: 30px;
        color: var(--dn-gold);
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .five-hour-page .course-hero h1 {
        max-width: 760px;
        margin: 24px 0 20px;
        font-size: clamp(38px, 5vw, 62px);
        font-weight: 800;
        line-height: 1.12;
    }

    .five-hour-page .course-hero h1 span {
        color: var(--dn-gold);
    }
    

    .five-hour-page .hero-description {
        max-width: 660px;
        color: #d9e1ef;
        font-size: 17px;
        line-height: 1.9;
    }

    .five-hour-page .course-price {
        display: inline-block;
        margin: 18px 0 24px;
        font-size: 46px;
        font-weight: 800;
    }

    .five-hour-page .course-price small {
        color: #d5deed;
        font-size: 15px;
        font-weight: 500;
    }

    /* Buttons */
    .five-hour-page .btn-gold {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        padding: 15px 25px;
        border: 0;
        border-radius: 8px;
        background: var(--dn-gold);
        color: var(--dn-deep);
        font-weight: 800;
        text-decoration: none;
        transition: .25s ease;
    }

    .five-hour-page .btn-gold:hover {
        background: #ffbb4c;
        color: var(--dn-deep);
        transform: translateY(-2px);
    }

    .five-hour-page .btn-outline-light-custom {
        display: inline-flex;
        justify-content: center;
        padding: 14px 23px;
        border: 1px solid rgba(255, 255, 255, .6);
        border-radius: 8px;
        color: #fff;
        font-weight: 700;
        text-decoration: none;
    }

    /* Sections */
    .five-hour-page .section-space {
        padding: 85px 0;
    }

    .five-hour-page .section-label {
        display: block;
        color: var(--dn-blue);
        text-align: center;
        font-size: 13px;
        font-weight: 800;
        letter-spacing: 1.5px;
        text-transform: uppercase;
    }

    /* FIX: All section H2 headings centered */
    .five-hour-page h2.section-heading {
        display: block;
        width: 100%;
        margin: 13px auto 18px;
        color: var(--dn-navy);
        font-size: clamp(30px, 4vw, 43px);
        font-weight: 800;
        line-height: 1.2;
        text-align: center !important;
    }

    /* Section descriptions */
    .five-hour-page .section-description {
        color: var(--dn-text);
        font-size: 16px;
        line-height: 1.9;
    }

    /* Feature and topic cards */
    .five-hour-page .feature-card,
    .five-hour-page .topic-card {
        height: 100%;
        padding: 28px;
        border: 1px solid #e7ebf2;
        border-radius: 14px;
        background: #fff;
        box-shadow: 0 8px 30px rgba(16, 29, 53, .045);
        transition: transform .25s, box-shadow .25s;
    }

    .five-hour-page .feature-card:hover,
    .five-hour-page .topic-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 16px 35px rgba(16, 29, 53, .09);
    }

    .five-hour-page .feature-icon {
        display: inline-flex;
        width: 54px;
        height: 54px;
        align-items: center;
        justify-content: center;
        margin-bottom: 19px;
        border-radius: 13px;
        background: #edf4ff;
        color: var(--dn-blue);
        font-size: 25px;
    }

    .five-hour-page .feature-card h3,
    .five-hour-page .topic-card h3 {
        margin-bottom: 12px;
        font-size: 19px;
        font-weight: 800;
    }

    .five-hour-page .feature-card p,
    .five-hour-page .topic-card p {
        margin-bottom: 0;
        color: var(--dn-text);
        font-size: 14px;
        line-height: 1.8;
    }

    /* Check list */
    .five-hour-page .check-list {
        padding: 0;
        margin: 24px 0 0;
        list-style: none;
    }

    .five-hour-page .check-list li {
        display: flex;
        gap: 12px;
        margin-bottom: 17px;
        color: var(--dn-text);
        line-height: 1.7;
    }

    .five-hour-page .check-list i {
        margin-top: 4px;
        color: #168b61;
    }

    /* Course information panel */
    .five-hour-page .info-panel {
        padding: 34px;
        border-radius: 18px;
        background: var(--dn-navy);
        color: #fff;
    }

    .five-hour-page .info-panel .section-label {
        color: var(--dn-gold);
    }

    .five-hour-page .info-row {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        padding: 17px 0;
        border-bottom: 1px solid rgba(255, 255, 255, .13);
    }

    .five-hour-page .info-row:last-child {
        border-bottom: 0;
    }

    .five-hour-page .info-row span:first-child {
        color: #c6d0df;
    }

    .five-hour-page .info-row strong {
        text-align: right;
    }

    /* Enrollment banner */
    .five-hour-page .enroll-banner {
        padding: 55px 35px;
        border-radius: 18px;
        background: linear-gradient(120deg, var(--dn-navy), #1b3d70);
        color: #fff;
    }

    .five-hour-page .enroll-banner .section-label {
        color: var(--dn-gold);
    }

    .five-hour-page .enroll-banner p {
        color: #d6dfed;
        line-height: 1.8;
    }

    /* FAQ */
    .five-hour-page .faq-item {
        margin-bottom: 12px;
        overflow: hidden;
        border: 1px solid #e5eaf1;
        border-radius: 10px;
    }

    .five-hour-page .faq-item .accordion-button {
        padding: 20px;
        color: var(--dn-navy);
        font-weight: 700;
        box-shadow: none;
    }

    .five-hour-page .faq-item .accordion-button:not(.collapsed) {
        background: #f0f5ff;
        color: var(--dn-blue);
    }

    .five-hour-page .faq-item .accordion-body {
        color: var(--dn-text);
        line-height: 1.8;
    }

    /* Background */
    .five-hour-page .soft-bg {
        background: #f6f8fc;
    }

    /* Responsive */
    @media (max-width: 767px) {
        .five-hour-page .course-hero {
            padding: 70px 0;
        }

        .five-hour-page .section-space {
            padding: 60px 0;
        }

        .five-hour-page .feature-card,
        .five-hour-page .topic-card {
            padding: 23px;
        }

        .five-hour-page .info-panel {
            padding: 24px;
        }

        .five-hour-page .enroll-banner {
            padding: 35px 24px;
        }

        .five-hour-page h2.section-heading {
            font-size: clamp(27px, 7vw, 35px);
            text-align: center !important;
        }
    }
    </style>

</head>

<body>

    <?php require_once __DIR__ . '/includes/navbar.php'; ?>

    <main class="five-hour-page">

        <!-- 1. Course Hero -->
        <section class="course-hero">
            <div class="container">
                <div class="row align-items-center g-5">
                    <div class="col-lg-8">
                        <span class="eyebrow">
                            <i class="bi bi-mortarboard-fill"></i>
                            Driver Education
                        </span>

                        <h1>
                            5-Hour Pre-Licensing
                            <span>Course</span>
                        </h1>

                        <p class="hero-description">
                            Prepare for your next step toward a driver's license.
                            Learn essential road safety principles, defensive driving
                            techniques and traffic rules through structured driver education.
                        </p>

                        <div class="course-price">
                            $50 <small>/ course</small>
                        </div>

                        <div class="d-flex flex-wrap gap-3">
                            <a href="booking.php" class="btn-gold">
                                Enroll Now
                                <i class="bi bi-arrow-right"></i>
                            </a>

                            <a href="#course-features" class="btn-outline-light-custom">
                                Explore Course
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="info-panel">
                            <span class="section-label">Course Overview</span>

                            <div class="info-row">
                                <span>Course length</span>
                                <strong>5 Hours</strong>
                            </div>

                            <div class="info-row">
                                <span>Format</span>
                                <strong>Confirm before enrollment</strong>
                            </div>

                            <div class="info-row">
                                <span>Price</span>
                                <strong>$50</strong>
                            </div>

                            <div class="info-row">
                                <span>Suitable for</span>
                                <strong>Eligible Learners</strong>
                            </div>

                            <p class="small mt-3 mb-0 text-white-50">
                                Course availability and eligibility depend on
                                the applicable local licensing requirements.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 2. Course Introduction -->
        <section class="section-space">
            <div class="container">
                <div class="row align-items-center g-5">
                    <div class="col-lg-6">
                        <span class="section-label">About The Course</span>

                        <h2 class="section-heading">
                            Build Safer Driving Habits Before Your Road Test
                        </h2>

                        <p class="section-description">
                            Driver education helps learners understand traffic
                            laws, recognize road hazards and make safer decisions.
                            This five-hour course page provides an overview of the
                            subjects learners should review before enrollment.
                        </p>

                        <p class="section-description">
                            If you need a course that satisfies a specific DMV
                            licensing requirement, verify the approved provider,
                            course format and certificate requirements before paying.
                        </p>

                        <ul class="check-list">
                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                Understand essential traffic rules and signs.
                            </li>
                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                Learn defensive driving and hazard awareness.
                            </li>
                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                Review safe and responsible driving practices.
                            </li>
                        </ul>
                    </div>

                    <div class="col-lg-6">
                        <img src="https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?auto=format&fit=crop&w=1000&q=85"
                            alt="Driving education and road safety" class="img-fluid rounded-4 shadow" loading="lazy">
                    </div>
                </div>
            </div>
        </section>

        <!-- 3. Course Features -->
        <section id="course-features" class="section-space soft-bg">
            <div class="container">
                <div class="text-center mb-5">
                    <span class="section-label">Why This Course</span>

                    <h2 class="section-heading">
                        Course Features
                    </h2>

                    <p class="section-description mx-auto" style="max-width:650px">
                        Review the essential benefits and learning areas
                        before choosing your driver education course.
                    </p>
                </div>

                <div class="row g-4">
                    <div class="col-md-6 col-lg-3">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-book-half"></i>
                            </div>
                            <h3>Structured Learning</h3>
                            <p>
                                Review key driving principles and responsible
                                road-use practices in an organized format.
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <h3>Defensive Driving</h3>
                            <p>
                                Understand how awareness, safe following distances
                                and planning can help reduce driving risks.
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-signpost-split"></i>
                            </div>
                            <h3>Road Rules</h3>
                            <p>
                                Review traffic signs, signals, right-of-way
                                principles and common road situations.
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-award"></i>
                            </div>
                            <h3>Course Completion</h3>
                            <p>
                                Check the provider's completion and certificate
                                requirements before enrolling.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 4. Course Breakdown -->
        <section class="section-space">
            <div class="container">
                <div class="text-center mb-5">
                    <span class="section-label">What You Will Review</span>
                    <h2 class="section-heading">Course Breakdown</h2>
                    <p class="section-description">
                        Explore the main topics covered in driver safety education.
                    </p>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="topic-card">
                            <div class="feature-icon">
                                <i class="bi bi-car-front-fill"></i>
                            </div>
                            <h3>01. Basics of Driving</h3>
                            <p>
                                Understand steering, turning, acceleration,
                                vehicle control and safe driving preparation.
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="topic-card">
                            <div class="feature-icon">
                                <i class="bi bi-shield-lock-fill"></i>
                            </div>
                            <h3>02. Defensive Driving</h3>
                            <p>
                                Learn hazard recognition, safe following distances,
                                observation and defensive driving decisions.
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="topic-card">
                            <div class="feature-icon">
                                <i class="bi bi-sign-turn-right-fill"></i>
                            </div>
                            <h3>03. Traffic Rules & Signs</h3>
                            <p>
                                Review road signs, traffic signals, right-of-way
                                and the importance of following traffic laws.
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="topic-card">
                            <div class="feature-icon">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                            </div>
                            <h3>04. Driving Risks</h3>
                            <p>
                                Understand the risks of distracted driving,
                                impaired driving, fatigue and unsafe decisions.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 5. Enrollment CTA -->
        <section class="section-space soft-bg">
            <div class="container">
                <div class="enroll-banner">
                    <div class="row align-items-center g-4">
                        <div class="col-lg-8">
                            <span class="section-label">Take The Next Step</span>

                            <h2 class="section-heading text-white">
                                Ready to Start Your Driver Education?
                            </h2>

                            <p class="mb-0">
                                Review your eligibility and course requirements,
                                then contact DriveN School to confirm availability
                                and enrollment details.
                            </p>
                        </div>

                        <div class="col-lg-4 text-lg-end">
                            <a href="booking.php" class="btn-gold">
                                Enroll Now
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 6. Course Information -->
        <section class="section-space">
            <div class="container">
                <div class="row g-5 align-items-start">
                    <div class="col-lg-6">
                        <span class="section-label">Important Details</span>
                        <h2 class="section-heading">Course Information</h2>

                        <p class="section-description">
                            Please confirm the current course schedule, delivery
                            method, provider approval and completion documents
                            before making a payment.
                        </p>

                        <ul class="check-list">
                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                Confirm that the course meets your licensing needs.
                            </li>
                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                Verify the official course price and availability.
                            </li>
                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                Ask about certificates and completion timelines.
                            </li>
                        </ul>
                    </div>

                    <div class="col-lg-6">
                        <div class="info-panel">
                            <h3 class="text-white mb-3">At a Glance</h3>

                            <div class="info-row">
                                <span>Course</span>
                                <strong>5-Hour Class</strong>
                            </div>

                            <div class="info-row">
                                <span>Listed reference price</span>
                                <strong>$50</strong>
                            </div>

                            <div class="info-row">
                                <span>Duration</span>
                                <strong>5 Hours</strong>
                            </div>

                            <div class="info-row">
                                <span>Booking</span>
                                <strong>Contact to Confirm</strong>
                            </div>

                            <a href="contact.php" class="btn-gold mt-4 w-100">
                                Ask a Question
                                <i class="bi bi-chat-dots"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 7. FAQ -->
        <section class="section-space soft-bg">
            <div class="container">
                <div class="text-center mb-5">
                    <span class="section-label">Need Help?</span>
                    <h2 class="section-heading">Frequently Asked Questions</h2>
                </div>

                <div class="accordion mx-auto" id="courseFaq" style="max-width:850px">

                    <div class="faq-item">
                        <h3 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faqOne" aria-expanded="true" aria-controls="faqOne">
                                What is a 5-hour pre-licensing course?
                            </button>
                        </h3>

                        <div id="faqOne" class="accordion-collapse collapse show" data-bs-parent="#courseFaq">
                            <div class="accordion-body">
                                It is a driver education course associated with
                                certain licensing requirements. Requirements vary
                                by jurisdiction, so confirm the rules that apply
                                to your licence.
                            </div>
                        </div>
                    </div>

                    <div class="faq-item">
                        <h3 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faqTwo" aria-expanded="false" aria-controls="faqTwo">
                                Can I complete the course online?
                            </button>
                        </h3>

                        <div id="faqTwo" class="accordion-collapse collapse" data-bs-parent="#courseFaq">
                            <div class="accordion-body">
                                Online availability depends on the approved
                                provider and local requirements. Contact DriveN
                                School to confirm the delivery format.
                            </div>
                        </div>
                    </div>

                    <div class="faq-item">
                        <h3 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faqThree" aria-expanded="false" aria-controls="faqThree">
                                How much does the course cost?
                            </button>
                        </h3>

                        <div id="faqThree" class="accordion-collapse collapse" data-bs-parent="#courseFaq">
                            <div class="accordion-body">
                                The reference page lists $50 per course.
                                Confirm DriveN School's actual price before
                                booking or making a payment.
                            </div>
                        </div>
                    </div>

                    <div class="faq-item">
                        <h3 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faqFour" aria-expanded="false" aria-controls="faqFour">
                                Will I receive a completion certificate?
                            </button>
                        </h3>

                        <div id="faqFour" class="accordion-collapse collapse" data-bs-parent="#courseFaq">
                            <div class="accordion-body">
                                Certificate eligibility depends on the course
                                provider and applicable licensing rules.
                                Ask the provider to confirm which certificate
                                is issued upon successful completion.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 8. Final CTA -->
        <section class="section-space">
            <div class="container text-center">
                <span class="section-label">DriveN School</span>

                <h2 class="section-heading">
                    Learn Smart. Drive Safe.
                </h2>

                <p class="section-description mx-auto mb-4" style="max-width:650px">
                    Contact our team to learn about course availability,
                    eligibility, enrollment and next steps.
                </p>

                <div class="d-flex justify-content-center flex-wrap gap-3">
                    <a href="booking.php" class="btn-gold">
                        Book Now <i class="bi bi-arrow-right"></i>
                    </a>

                    <a href="contact.php" class="btn btn-outline-primary px-4 py-3 fw-bold">
                        Contact Us
                    </a>
                </div>
            </div>
        </section>

    </main>

    <?php
// Bootstrap Icons and Bootstrap JavaScript must be loaded
// by the shared page layout for icons and FAQ accordion to work.
?>
</body>

</html>
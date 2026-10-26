<?php
session_start();

$success = $_SESSION["contact_success"] ?? "";
$error = $_SESSION["error"] ?? "";

unset($_SESSION["contact_success"], $_SESSION["error"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Contact Us | DriveN School</title>
    <meta name="description" content="Contact DriveN School for driving lessons, packages and road test assistance.">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Existing project stylesheet -->
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        :root {
            --navy: #101d35;
            --navy-deep: #091426;
            --blue: #2878f0;
            --gold: #f5a623;
            --gold-hover: #ffbb4c;
            --light-bg: #f5f7fb;
            --text: #596579;
        }

        body {
            font-family: "DM Sans", Arial, sans-serif;
            background: #fff;
            color: var(--navy);
        }

        /* Contact hero */
        .contact-hero {
            position: relative;
            overflow: hidden;
            padding: 150px 0 90px;
            background:
                radial-gradient(circle at 90% 15%, rgba(40,120,240,.25), transparent 30%),
                linear-gradient(135deg, var(--navy-deep), var(--navy));
            color: #fff;
        }

        .contact-hero::after {
            content: "";
            position: absolute;
            width: 280px;
            height: 280px;
            border: 45px solid rgba(245,166,35,.12);
            border-radius: 50%;
            right: -80px;
            bottom: -140px;
        }

        .contact-label {
            display: inline-block;
            color: var(--gold);
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 18px;
        }

        .contact-hero h1 {
            font-size: clamp(38px, 5vw, 60px);
            font-weight: 800;
            line-height: 1.12;
            margin-bottom: 20px;
        }

        .contact-hero p {
            max-width: 570px;
            color: #d2d9e6;
            font-size: 17px;
            line-height: 1.8;
        }

        .hero-line {
            width: 75px;
            height: 5px;
            background: var(--gold);
            border-radius: 10px;
            margin: 25px 0;
        }

        /* Main section */
        .contact-section {
            padding: 85px 0;
            background: var(--light-bg);
        }

        .section-label {
            color: var(--blue);
            font-weight: 800;
            font-size: 13px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .section-title {
            font-weight: 800;
            color: var(--navy);
            font-size: clamp(30px, 4vw, 42px);
            margin: 12px 0;
        }

        .contact-info-card,
        .contact-form-card {
            height: 100%;
            background: #fff;
            border-radius: 18px;
            padding: 35px;
            box-shadow: 0 12px 40px rgba(16,29,53,.07);
        }

        .contact-info-card {
            background: var(--navy);
            color: #fff;
        }

        .contact-info-card h3,
        .contact-form-card h3 {
            font-weight: 800;
            margin-bottom: 12px;
        }

        .info-intro {
            color: #c8d1e0;
            line-height: 1.8;
            margin-bottom: 30px;
        }

        .contact-info-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            margin: 25px 0;
        }

        .contact-icon {
            width: 48px;
            height: 48px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(245,166,35,.14);
            color: var(--gold);
            border-radius: 12px;
            font-size: 21px;
        }

        .contact-info-item h6 {
            font-weight: 700;
            margin: 2px 0 7px;
        }

        .contact-info-item p,
        .contact-info-item a {
            color: #c8d1e0;
            text-decoration: none;
            margin: 0;
            line-height: 1.7;
            overflow-wrap: anywhere;
        }

        .contact-info-item a:hover {
            color: var(--gold);
        }

        .contact-form-card > p {
            color: var(--text);
            line-height: 1.7;
            margin-bottom: 28px;
        }

        .form-label {
            font-weight: 700;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .form-control {
            min-height: 49px;
            border: 1px solid #dfe5ee;
            border-radius: 9px;
            padding: 12px 14px;
        }

        textarea.form-control {
            min-height: 145px;
            resize: vertical;
        }

        .form-control:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(40,120,240,.12);
        }

        .btn-contact {
            background: var(--gold);
            color: var(--navy-deep);
            border: 0;
            border-radius: 9px;
            padding: 14px 23px;
            font-weight: 800;
            transition: .2s ease;
        }

        .btn-contact:hover {
            background: var(--gold-hover);
            color: var(--navy-deep);
            transform: translateY(-2px);
        }

        .contact-bottom {
            padding: 55px 0;
            background: #fff;
        }

        .bottom-card {
            padding: 25px;
            border: 1px solid #e8edf4;
            border-radius: 14px;
            height: 100%;
        }

        .bottom-card i {
            font-size: 28px;
            color: var(--blue);
        }

        .bottom-card h5 {
            font-weight: 800;
            margin: 15px 0 8px;
        }

        .bottom-card p {
            color: var(--text);
            margin: 0;
            line-height: 1.7;
        }

        .contact-footer {
            background: var(--navy-deep);
            color: #c8d1e0;
            padding: 24px 0;
            text-align: center;
        }

        .contact-footer p {
            margin: 0;
        }

        @media (max-width: 767px) {
            .contact-hero {
                padding: 125px 0 65px;
            }

            .contact-section {
                padding: 55px 0;
            }

            .contact-info-card,
            .contact-form-card {
                padding: 25px;
            }
        }
    </style>
</head>

<body>

    <?php require_once __DIR__ . '/includes/navbar.php'; ?>

<!-- Hero -->
<section class="contact-hero">
    <div class="container position-relative" style="z-index: 1;">
        <span class="contact-label">We're Here to Help</span>

        <h1>Let's Get You<br>
            <span style="color: var(--gold);">On The Road.</span>
        </h1>

        <div class="hero-line"></div>

        <p>
            Have questions about driving lessons, packages or road test
            assistance? Contact our team and we'll help you find the
            right option for your driving journey.
        </p>

        <a href="#contact-form" class="btn btn-contact mt-3">
            Send Us a Message
            <i class="bi bi-arrow-right ms-2"></i>
        </a>
    </div>
</section>

<!-- Contact information and form -->
<section class="contact-section" id="contact-form">
    <div class="container">

        <div class="text-center mb-5">
            <span class="section-label">Get In Touch</span>
            <h2 class="section-title">We'd Love to Hear From You</h2>
            <p class="text-secondary">
                Send us your questions and our team will help you with the next step.
            </p>
        </div>

        <div class="row g-4">

            <!-- Contact information -->
            <div class="col-lg-5">
                <div class="contact-info-card">

                    <h3>Contact Information</h3>

                    <p class="info-intro">
                        Reach out to us for lesson details, package information
                        and help with your booking.
                    </p>

                    <div class="contact-info-item">
                        <div class="contact-icon">
                            <i class="bi bi-telephone"></i>
                        </div>
                        <div>
                            <h6>Call Us</h6>
                            <!-- Replace with your real business phone -->
                            <p>Add your business phone number</p>
                        </div>
                    </div>

                    <div class="contact-info-item">
                        <div class="contact-icon">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <div>
                            <h6>Email Us</h6>
                            <!-- Replace with your real business email -->
                            <p>Add your business email address</p>
                        </div>
                    </div>

                    <div class="contact-info-item">
                        <div class="contact-icon">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <div>
                            <h6>Our Location</h6>
                            <p>Add your driving school's business address</p>
                        </div>
                    </div>

                    <div class="contact-info-item">
                        <div class="contact-icon">
                            <i class="bi bi-clock"></i>
                        </div>
                        <div>
                            <h6>Office Hours</h6>
                            <p>Contact us for current availability.</p>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Contact form -->
            <div class="col-lg-7">
                <div class="contact-form-card">

                    <h3>Send Us a Message</h3>
                    <p>
                        Complete the form below. All fields marked with *
                        are required.
                    </p>

                    <?php if ($success !== ''): ?>
                        <div class="alert alert-success" role="alert">
                            <?= htmlspecialchars((string) $success, ENT_QUOTES, 'UTF-8') ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($error !== ''): ?>
                        <div class="alert alert-danger" role="alert">
                            <?= htmlspecialchars((string) $error, ENT_QUOTES, 'UTF-8') ?>
                        </div>
                    <?php endif; ?>

                    <form action="process-contact.php" method="POST">

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label for="name" class="form-label">
                                    Full Name *
                                </label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="name"
                                    name="name"
                                    maxlength="100"
                                    autocomplete="name"
                                    placeholder="Enter your full name"
                                    required
                                >
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">
                                    Email Address *
                                </label>
                                <input
                                    type="email"
                                    class="form-control"
                                    id="email"
                                    name="email"
                                    maxlength="150"
                                    autocomplete="email"
                                    placeholder="you@example.com"
                                    required
                                >
                            </div>

                            <div class="col-12">
                                <label for="phone" class="form-label">
                                    Phone Number *
                                </label>
                                <input
                                    type="tel"
                                    class="form-control"
                                    id="phone"
                                    name="phone"
                                    maxlength="30"
                                    autocomplete="tel"
                                    placeholder="Enter your phone number"
                                    required
                                >
                            </div>

                            <div class="col-12">
                                <label for="message" class="form-label">
                                    How Can We Help? *
                                </label>
                                <textarea
                                    class="form-control"
                                    id="message"
                                    name="message"
                                    maxlength="3000"
                                    placeholder="Tell us how we can help..."
                                    required
                                ></textarea>
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-contact w-100">
                                    Send Message
                                    <i class="bi bi-send ms-2"></i>
                                </button>
                            </div>

                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</section>

<!-- Helpful information -->
<section class="contact-bottom">
    <div class="container">
        <div class="row g-4">

            <div class="col-md-4">
                <div class="bottom-card">
                    <i class="bi bi-car-front"></i>
                    <h5>Driving Lessons</h5>
                    <p>Ask about lesson options and find a suitable package.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="bottom-card">
                    <i class="bi bi-calendar-check"></i>
                    <h5>Booking Support</h5>
                    <p>Contact us if you need help with your appointment.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="bottom-card">
                    <i class="bi bi-person-check"></i>
                    <h5>Personal Guidance</h5>
                    <p>Tell us about your driving goals and ask which option suits you.</p>
                </div>
            </div>

        </div>
    </div>
</section>

<footer class="contact-footer">
    <div class="container">
        <p>
            &copy; <?= date('Y') ?> DriveN School. All rights reserved.
        </p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

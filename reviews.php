
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Reviews | DriveN School</title>
    <meta name="description" content="Explore the DriveN School student review page and discover our driving lesson experience.">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="reviews-page">

    <?php require_once __DIR__ . '/includes/navbar.php'; ?>

    <main>
        <!-- Hero Section -->
        <section class="reviews-hero">
            <div class="container">
                <div class="reviews-hero-content">
                    <span class="reviews-eyebrow">THE DRIVEN EXPERIENCE</span>

                    <h1>
                        Confidence Starts<br>
                        <span>Behind the Wheel.</span>
                    </h1>

                    <p>
                        Discover what makes a great driving lesson.
                        Our focus is confidence, safety and learning at your pace.
                    </p>

                    <a href="booking.php" class="btn btn-gold reviews-main-btn">
                        Book Your First Lesson <span>↗</span>
                    </a>

                    <div class="reviews-hero-note">
                        <span class="note-dot"></span>
                        Student feedback showcase
                    </div>
                </div>
            </div>

            <div class="reviews-hero-decoration"></div>
        </section>

        <!-- Trust Section -->
        <section class="reviews-trust">
            <div class="container">
                <div class="reviews-trust-grid">
                    <div class="trust-item">
                        <span class="trust-icon">✓</span>
                        <div>
                            <h3>Safety First</h3>
                            <p>Learn responsible driving habits</p>
                        </div>
                    </div>

                    <div class="trust-item">
                        <span class="trust-icon">✦</span>
                        <div>
                            <h3>Personal Guidance</h3>
                            <p>Training suited to your progress</p>
                        </div>
                    </div>

                    <div class="trust-item">
                        <span class="trust-icon">↗</span>
                        <div>
                            <h3>Build Confidence</h3>
                            <p>Practice with clear guidance</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Reviews Section -->
        <section class="reviews-section">
            <div class="container">
                <div class="reviews-section-heading">
                    <span class="reviews-eyebrow">STUDENT STORIES</span>
                    <h2>Every Journey Has <span>a Story.</span></h2>
                    <p>
                        Explore our testimonial page design. Replace the sample
                        content below with genuine feedback from your students.
                    </p>
                </div>

                <div class="row g-4">
                    <div class="col-md-6 col-lg-4">
                        <article class="review-card">
                            <div class="review-card-top">
                                <span class="review-quote">“</span>
                                <span class="review-label">SAMPLE REVIEW</span>
                            </div>

                            <div class="review-stars" aria-label="Five stars">
                                ★★★★★
                            </div>

                            <blockquote>
                                “The instructor explained each step clearly
                                and helped me feel more comfortable learning
                                new driving skills.”
                            </blockquote>

                            <div class="review-author">
                                <div class="review-avatar">S1</div>
                                <div>
                                    <h3>Sample Student 01</h3>
                                    <p>Beginner Lessons</p>
                                </div>
                            </div>
                        </article>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <article class="review-card review-card-featured">
                            <div class="review-card-top">
                                <span class="review-quote">“</span>
                                <span class="review-label">SAMPLE REVIEW</span>
                            </div>

                            <div class="review-stars" aria-label="Five stars">
                                ★★★★★
                            </div>

                            <blockquote>
                                “The lessons were organized and easy to follow.
                                I could focus on improving my road awareness
                                one step at a time.”
                            </blockquote>

                            <div class="review-author">
                                <div class="review-avatar">S2</div>
                                <div>
                                    <h3>Sample Student 02</h3>
                                    <p>Road Practice</p>
                                </div>
                            </div>
                        </article>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <article class="review-card">
                            <div class="review-card-top">
                                <span class="review-quote">“</span>
                                <span class="review-label">SAMPLE REVIEW</span>
                            </div>

                            <div class="review-stars" aria-label="Five stars">
                                ★★★★★
                            </div>

                            <blockquote>
                                “A helpful learning experience with a focus
                                on safe driving, practical skills and
                                steady improvement.”
                            </blockquote>

                            <div class="review-author">
                                <div class="review-avatar">S3</div>
                                <div>
                                    <h3>Sample Student 03</h3>
                                    <p>Driving Refresher</p>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>

                <p class="reviews-disclaimer">
                    Note: These are sample testimonials for UI development,
                    not verified customer reviews. Replace them before publishing.
                </p>
            </div>
        </section>

        <!-- Call to Action -->
        <section class="reviews-cta">
            <div class="container">
                <div class="reviews-cta-box">
                    <div>
                        <span class="reviews-eyebrow">YOUR JOURNEY STARTS HERE</span>
                        <h2>Ready to Take the Driver’s Seat?</h2>
                        <p>
                            Start building your driving skills with a learning
                            plan designed around your needs.
                        </p>
                    </div>

                    <a href="booking.php" class="btn btn-gold reviews-main-btn">
                        Book a Lesson <span>↗</span>
                    </a>
                </div>
            </div>
        </section>
    </main>

    <footer class="reviews-footer">
        <div class="container">
            <p>© <?php echo date('Y'); ?> DriveN School. All rights reserved.</p>
            <a href="index.php">Back to Home ↑</a>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>

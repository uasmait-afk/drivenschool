
$(function () {
    // Smooth scrolling for internal links
    $('a[href^="#"]').on('click', function (event) {
        const target = $(this.getAttribute('href'));

        if (target.length) {
            event.preventDefault();

            $('html, body').animate({
                scrollTop: target.offset().top - 75
            }, 450);

            // Close mobile navigation after selecting a link
            const nav = document.querySelector('#mainNav');
            if (nav && nav.classList.contains('show')) {
                bootstrap.Collapse.getOrCreateInstance(nav).hide();
            }
        }
    });

    // Sample content for the review slider
    // Replace these samples with real, permission-approved testimonials.
    const reviews = [
        {
            text: '“A great learning experience starts with patience, clear guidance and time to practice.”',
            author: '— The DriveN School promise'
        },
        {
            text: '“Every learner deserves a supportive environment to develop safer driving habits.”',
            author: '— Our learning philosophy'
        },
        {
            text: '“Confidence grows one lesson, one skill and one safe decision at a time.”',
            author: '— The DriveN School approach'
        }
    ];

    let currentReview = 0;

    function showReview(index) {
        currentReview = (index + reviews.length) % reviews.length;

        $('#reviewText').fadeOut(120, function () {
            $(this).text(reviews[currentReview].text).fadeIn(180);
        });

        $('#reviewAuthor').text(reviews[currentReview].author);
    }

    $('#prevReview').on('click', function () {
        showReview(currentReview - 1);
    });

    $('#nextReview').on('click', function () {
        showReview(currentReview + 1);
    });

    // Basic front-end initialization message
    console.log('DriveN School homepage initialized successfully.');
});

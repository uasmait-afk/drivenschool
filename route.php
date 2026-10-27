
<?php

$routes = [
    'index' => 'index.php',
    'home' => 'index.php',
    'contact' => 'contact.php',
    'about' => 'about.php',
    'services' => 'services.php',
    'packages' => 'packages.php',
    'booking' => 'booking.php',
    'reviews' => 'reviews.php',
    '5-hour-class' => '5-hour-class.php',
    'login' => 'login.php',
    'admin' => 'admin.php',
    'lessons' => 'lessons.php',
    'basic-package' => 'basic-package.php',
    'standard-package' => 'standard-package.php',
    'individual-lessons' => 'individual-lessons.php',
    'custom-packages' => 'custom-packages.php',
    'student-register' => 'student-register.php',
    'student-login' => 'student-login.php',
];

// Get URL from query parameter
$url = trim($_GET['url'] ?? '', '/');

// Default page
if ($url === '' || $url === 'home') {
    $url = 'home';
}

// Check route
if (!isset($routes[$url])) {
    http_response_code(404);
    exit('404 - Page Not Found');
}

// Check PHP file
$page = __DIR__ . DIRECTORY_SEPARATOR . $routes[$url];

if (!is_file($page)) {
    http_response_code(404);
    exit('Page file not found: ' . htmlspecialchars($routes[$url]));
}

require $page;




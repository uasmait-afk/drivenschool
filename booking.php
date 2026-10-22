<?php
session_start();

require __DIR__ . '/config/db.php';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$lessons = [
    'Beginner Driving',
    'Road Test Preparation',
    'Defensive Driving'
];


if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$lessons = [
    'Beginner Driving',
    'Road Test Preparation',
    'Defensive Driving'
];

$packages = [
    'Starter',
    'Popular',
    'Complete'
];

$errors = [];
$success = '';

$fullName = '';
$email = '';
$phone = '';
$lessonType = '';
$packageName = '';
$bookingDate = '';
$bookingTime = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $lessonType = $_POST['lesson_type'] ?? '';
    $packageName = $_POST['package_name'] ?? '';
    $bookingDate = $_POST['booking_date'] ?? '';
    $bookingTime = $_POST['booking_time'] ?? '';
    $message = trim($_POST['message'] ?? '');

    $token = $_POST['csrf_token'] ?? '';

    if (!is_string($token) ||
        !hash_equals($_SESSION['csrf_token'], $token)) {
        $errors[] = 'Invalid form request. Please refresh and try again.';
    }

    if (strlen($fullName) < 2 || strlen($fullName) > 100) {
        $errors[] = 'Name must be between 2 and 100 characters.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) ||
        strlen($email) > 150) {
        $errors[] = 'Please enter a valid email address.';
    }

    if (!preg_match('/^[0-9+\s().-]{7,30}$/', $phone)) {
        $errors[] = 'Please enter a valid phone number.';
    }

    if (!in_array($lessonType, $lessons, true)) {
        $errors[] = 'Please select a valid lesson type.';
    }

    if (!in_array($packageName, $packages, true)) {
        $errors[] = 'Please select a valid package.';
    }

    $dateObject = DateTimeImmutable::createFromFormat(
        '!Y-m-d',
        $bookingDate
    );

    if (
        !$dateObject ||
        $dateObject->format('Y-m-d') !== $bookingDate ||
        $bookingDate < date('Y-m-d')
    ) {
        $errors[] = 'Please select a valid date that is not in the past.';
    }

    if (!preg_match('/^(?:[01]\d|2[0-3]):[0-5]\d$/', $bookingTime)) {
        $errors[] = 'Please select a valid lesson time.';
    }

    if (strlen($message) > 1000) {
        $errors[] = 'Message must be 1000 characters or fewer.';
    }

    if (!$errors) {
        try {
            $sql = "INSERT INTO bookings
                (full_name, email, phone, lesson_type, package_name,
                 booking_date, booking_time, message)
                VALUES
                (:full_name, :email, :phone, :lesson_type, :package_name,
                 :booking_date, :booking_time, :message)";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':full_name' => $fullName,
                ':email' => $email,
                ':phone' => $phone,
                ':lesson_type' => $lessonType,
                ':package_name' => $packageName,
                ':booking_date' => $bookingDate,
                ':booking_time' => $bookingTime,
                ':message' => $message !== '' ? $message : null,
            ]);

            $success = 'Your booking request has been submitted! '
                . 'Your request is pending confirmation.';

            $fullName = $email = $phone = '';
            $lessonType = $packageName = '';
            $bookingDate = $bookingTime = $message = '';

            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        } catch (PDOException $e) {
            error_log('Booking insert failed: ' . $e->getMessage());
            $errors[] = 'We could not save your request. Please try again.';
        }
    }
}

function e(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Book a Driving Lesson | DriveN School</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="booking-page">

<nav class="navbar navbar-dark driven-nav">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <span class="brand-mark">D</span> Drive<span>N</span>
        </a>
        <a href="index.php" class="btn btn-outline-light">← Back Home</a>
    </div>
</nav>

<main class="container py-5">
    <div class="booking-card mx-auto">
        <div class="eyebrow dark-eyebrow">YOUR NEXT JOURNEY STARTS HERE</div>
        <h1 class="mb-3">Request a <span>Lesson.</span></h1>
        <p class="text-secondary mb-4">
            Submit your preferred lesson details. Your request is not
            confirmed until the school approves it.
        </p>

        <?php if ($success): ?>
            <div class="alert alert-success" role="status">
                <?= e($success) ?>
            </div>
        <?php endif; ?>

        <?php if ($errors): ?>
            <div class="alert alert-danger" role="alert">
                <strong>Please correct the following:</strong>
                <ul class="mb-0 mt-2">
                    <?php foreach ($errors as $error): ?>
                        <li><?= e($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" action="booking.php">
            <input type="hidden" name="csrf_token"
                   value="<?= e($_SESSION['csrf_token']) ?>">

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label" for="full_name">Full name</label>
                    <input class="form-control" id="full_name"
                           name="full_name" maxlength="100"
                           autocomplete="name" required
                           value="<?= e($fullName) ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="email">Email address</label>
                    <input class="form-control" id="email" type="email"
                           name="email" maxlength="150"
                           autocomplete="email" required
                           value="<?= e($email) ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="phone">Phone number</label>
                    <input class="form-control" id="phone" type="tel"
                           name="phone" maxlength="30"
                           autocomplete="tel" required
                           value="<?= e($phone) ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="lesson_type">Lesson type</label>
                    <select class="form-select" id="lesson_type"
                            name="lesson_type" required>
                        <option value="">Choose a lesson</option>
                        <?php foreach ($lessons as $lesson): ?>
                            <option value="<?= e($lesson) ?>"
                                <?= $lessonType === $lesson ? 'selected' : '' ?>>
                                <?= e($lesson) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="package_name">Package</label>
                    <select class="form-select" id="package_name"
                            name="package_name" required>
                        <option value="">Choose a package</option>
                        <?php foreach ($packages as $package): ?>
                            <option value="<?= e($package) ?>"
                                <?= $packageName === $package ? 'selected' : '' ?>>
                                <?= e($package) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="booking_date">Preferred date</label>
                    <input class="form-control" id="booking_date"
                           type="date" name="booking_date"
                           min="<?= date('Y-m-d') ?>" required
                           value="<?= e($bookingDate) ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="booking_time">Preferred time</label>
                    <select class="form-select" id="booking_time"
                            name="booking_time" required>
                        <option value="">Choose a time</option>
                        <?php
                        for ($hour = 9; $hour < 17; $hour++) {
                            foreach ([0, 30] as $minute) {
                                $time = sprintf('%02d:%02d', $hour, $minute);
                                $label = date('g:i A', strtotime($time));
                                $selected = $bookingTime === $time ? 'selected' : '';
                                echo '<option value="' . e($time) . '" '
                                    . $selected . '>' . e($label) . '</option>';
                            }
                        }
                        ?>
                    </select>
                    <small class="text-secondary">
                        Demo schedule: 9:00 AM–4:30 PM. Actual availability
                        is not checked yet.
                    </small>
                </div>

                <div class="col-12">
                    <label class="form-label" for="message">
                        Additional message (optional)
                    </label>
                    <textarea class="form-control" id="message"
                              name="message" rows="4" maxlength="1000"
                              placeholder="Tell us about your learning goals..."><?= e($message) ?></textarea>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-gold btn-lg w-100">
                        Submit Booking Request ↗
                    </button>
                </div>
            </div>
        </form>
    </div>
</main>
</body>
</html>

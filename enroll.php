
<?php
require_once __DIR__ . '/config/db.php';

/*
|--------------------------------------------------------------------------
| Available Packages
|--------------------------------------------------------------------------
*/
$packages = [
    'FGZDMR' => [
        'name' => '1 Lesson',
        'price' => 225.00,
        'description' => 'One 45-minute driving lesson'
    ],
    'BP4ISN' => [
        'name' => '2 Lessons',
        'price' => 280.00,
        'description' => 'Two 45-minute driving lessons'
    ],
    '65147S' => [
        'name' => '3 Lessons',
        'price' => 335.00,
        'description' => 'Three 45-minute driving lessons'
    ],
    '5Q4SIR' => [
        'name' => '4 Lessons',
        'price' => 390.00,
        'description' => 'Four 45-minute driving lessons'
    ]
];

$selectedCode = $_POST['package_code']
    ?? $_GET['package']
    ?? '';

$selectedCode = strtoupper(trim((string) $selectedCode));

$errors = [];
$success = false;

$fullName = '';
$email = '';
$phone = '';
$preferredDate = '';
$preferredTime = '';
$message = '';

/*
|--------------------------------------------------------------------------
| Handle Form Submission
|--------------------------------------------------------------------------
*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $fullName = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $preferredDate = trim($_POST['preferred_date'] ?? '');
    $preferredTime = trim($_POST['preferred_time'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Validate package
    if (!isset($packages[$selectedCode])) {
        $errors[] = 'Please select a valid package.';
    }

    // Validate name
    if ($fullName === '' || strlen($fullName) > 120) {
        $errors[] = 'Enter your name (maximum 120 characters).';
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)
        || strlen($email) > 150) {
        $errors[] = 'Enter a valid email address.';
    }

    // Validate phone
    if (
        $phone === ''
        || strlen($phone) > 30
        || !preg_match('/^[0-9+\-().\s]{7,30}$/', $phone)
    ) {
        $errors[] = 'Enter a valid phone number.';
    }

    // Validate date
    $dateObject = DateTimeImmutable::createFromFormat(
        '!Y-m-d',
        $preferredDate
    );

    $validDate = $dateObject
        && $dateObject->format('Y-m-d') === $preferredDate;

    if (!$validDate || $preferredDate < date('Y-m-d')) {
        $errors[] = 'Choose a valid date today or in the future.';
    }

    // Validate time
    if (!preg_match('/^(?:[01]\d|2[0-3]):[0-5]\d$/', $preferredTime)) {
        $errors[] = 'Choose a valid appointment time.';
    } elseif (
        $validDate
        && $preferredDate === date('Y-m-d')
        && $preferredTime <= date('H:i')
    ) {
        $errors[] = 'Choose a future time for today.';
    }

    // Validate message
    if (strlen($message) > 2000) {
        $errors[] = 'Message must be 2000 characters or fewer.';
    }

    // Save booking
    if (empty($errors)) {
        $package = $packages[$selectedCode];

        try {
            $sql = "INSERT INTO enrollments
                (
                    full_name,
                    email,
                    phone,
                    package_code,
                    package_name,
                    package_price,
                    preferred_date,
                    preferred_time,
                    message
                )
                VALUES
                (
                    :full_name,
                    :email,
                    :phone,
                    :package_code,
                    :package_name,
                    :package_price,
                    :preferred_date,
                    :preferred_time,
                    :message
                )";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':full_name' => $fullName,
                ':email' => $email,
                ':phone' => $phone,
                ':package_code' => $selectedCode,
                ':package_name' => $package['name'],
                ':package_price' => $package['price'],
                ':preferred_date' => $preferredDate,
                ':preferred_time' => $preferredTime . ':00',
                ':message' => $message !== '' ? $message : null
            ]);

            $success = true;

            // Clear fields after successful submission
            $fullName = '';
            $email = '';
            $phone = '';
            $preferredDate = '';
            $preferredTime = '';
            $message = '';

        } catch (PDOException $e) {
            error_log('Enrollment save failed: ' . $e->getMessage());
            $errors[] = 'We could not save your booking. Please try again.';
        }
    }
}

$validPackage = $packages[$selectedCode] ?? null;

function e($value): string {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Enroll Now | DriveN School</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet"
    >

    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        .enrollment-section {
            min-height: 100vh;
            padding: 120px 0 80px;
            background: #f4f6fa;
        }

        .enrollment-heading {
            color: #142b59;
            font-weight: 800;
        }

        .enrollment-heading span {
            color: #f5a623;
        }

        .enrollment-card {
            background: #fff;
            border: 1px solid #e5eaf2;
            border-radius: 18px;
            padding: 30px;
            box-shadow: 0 15px 40px rgba(20, 43, 89, .08);
        }

        .selected-package {
            background: #142b59;
            color: #fff;
            padding: 24px;
            border-radius: 14px;
            margin-bottom: 28px;
        }

        .selected-package .package-price {
            color: #ffc04d;
            font-size: 32px;
            font-weight: 800;
        }

        .enrollment-card .form-label {
            color: #142b59;
            font-weight: 600;
        }

        .enrollment-card .form-control {
            padding: 12px 14px;
            border-radius: 9px;
        }

        .enrollment-card .form-control:focus {
            border-color: #f5a623;
            box-shadow: 0 0 0 .2rem rgba(245, 166, 35, .15);
        }

        .enrollment-submit {
            width: 100%;
            padding: 14px;
            background: #142b59;
            color: #fff;
            border: 0;
            border-radius: 9px;
            font-weight: 700;
        }

        .enrollment-submit:hover {
            background: #f5a623;
            color: #142b59;
        }

        @media (max-width: 575px) {
            .enrollment-section {
                padding: 100px 0 50px;
            }

            .enrollment-card {
                padding: 20px;
            }
        }
    </style>
</head>

<body>

<section class="enrollment-section">
    <div class="container">

        <div class="text-center mb-5">
            <div class="basic-eyebrow">START YOUR JOURNEY</div>

            <h1 class="enrollment-heading">
                Student <span>Enrollment</span>
            </h1>

            <p class="text-secondary">
                Complete the form to request your driving lesson.
            </p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">

                <div class="enrollment-card">

                    <?php if ($success): ?>
                        <div class="alert alert-success" role="alert">
                            <h5>
                                <i class="bi bi-check-circle-fill"></i>
                                Enrollment Request Submitted!
                            </h5>
                            Your request has been saved successfully.
                            Our team can review your request and confirm
                            the appointment.
                        </div>

                        <a href="basic-package.php"
                           class="btn btn-outline-primary">
                            <i class="bi bi-arrow-left"></i>
                            Back to Packages
                        </a>
                    <?php else: ?>

                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger" role="alert">
                                <strong>Please check the following:</strong>
                                <ul class="mb-0 mt-2">
                                    <?php foreach ($errors as $error): ?>
                                        <li><?= e($error) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <?php if ($validPackage): ?>
                            <div class="selected-package">
                                <div class="small text-uppercase mb-2">
                                    Your Selected Package
                                </div>

                                <h3 class="fw-bold">
                                    <?= e($validPackage['name']) ?>
                                </h3>

                                <p class="mb-2">
                                    <?= e($validPackage['description']) ?>
                                </p>

                                <div class="package-price">
                                    $<?= number_format(
                                        $validPackage['price'],
                                        2
                                    ) ?>
                                </div>

                                <div class="small">
                                    Per Package
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning">
                                Select a package before completing
                                your enrollment.
                            </div>

                            <a href="basic-package.php#packages"
                               class="btn btn-primary mb-4">
                                Choose a Package
                            </a>
                        <?php endif; ?>

                        <?php if ($validPackage): ?>
                            <form method="POST"
                                  action="enroll.php"
                                  novalidate>

                                <input
                                    type="hidden"
                                    name="package_code"
                                    value="<?= e($selectedCode) ?>"
                                >

                                <div class="mb-3">
                                    <label for="full_name"
                                           class="form-label">
                                        Full Name *
                                    </label>

                                    <input
                                        type="text"
                                        class="form-control"
                                        id="full_name"
                                        name="full_name"
                                        maxlength="120"
                                        autocomplete="name"
                                        value="<?= e($fullName) ?>"
                                        required
                                    >
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="email"
                                               class="form-label">
                                            Email Address *
                                        </label>

                                        <input
                                            type="email"
                                            class="form-control"
                                            id="email"
                                            name="email"
                                            maxlength="150"
                                            autocomplete="email"
                                            value="<?= e($email) ?>"
                                            required
                                        >
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="phone"
                                               class="form-label">
                                            Phone Number *
                                        </label>

                                        <input
                                            type="tel"
                                            class="form-control"
                                            id="phone"
                                            name="phone"
                                            maxlength="30"
                                            autocomplete="tel"
                                            value="<?= e($phone) ?>"
                                            required
                                        >
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="preferred_date"
                                               class="form-label">
                                            Preferred Date *
                                        </label>

                                        <input
                                            type="date"
                                            class="form-control"
                                            id="preferred_date"
                                            name="preferred_date"
                                            min="<?= date('Y-m-d') ?>"
                                            value="<?= e($preferredDate) ?>"
                                            required
                                        >
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="preferred_time"
                                               class="form-label">
                                            Preferred Time *
                                        </label>

                                        <select
                                            class="form-select form-control"
                                            id="preferred_time"
                                            name="preferred_time"
                                            required
                                        >
                                            <option value="">
                                                Select a time
                                            </option>

                                            <?php
                                            for (
                                                $minutes = 9 * 60;
                                                $minutes < 17 * 60;
                                                $minutes += 30
                                            ):
                                                $timeValue = sprintf(
                                                    '%02d:%02d',
                                                    intdiv($minutes, 60),
                                                    $minutes % 60
                                                );

                                                $timeLabel = date(
                                                    'g:i A',
                                                    strtotime($timeValue)
                                                );
                                            ?>
                                                <option
                                                    value="<?= e($timeValue) ?>"
                                                    <?= $preferredTime === $timeValue
                                                        ? 'selected'
                                                        : '' ?>
                                                >
                                                    <?= e($timeLabel) ?>
                                                </option>
                                            <?php endfor; ?>
                                        </select>

                                        <small class="text-secondary">
                                            Preferred time only; availability
                                            must be confirmed by the school.
                                        </small>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="message"
                                           class="form-label">
                                        Additional Message (Optional)
                                    </label>

                                    <textarea
                                        class="form-control"
                                        id="message"
                                        name="message"
                                        rows="4"
                                        maxlength="2000"
                                        placeholder="Tell us if you have any questions..."
                                    ><?= e($message) ?></textarea>
                                </div>

                                <button
                                    type="submit"
                                    class="enrollment-submit"
                                >
                                    Submit Enrollment
                                    <i class="bi bi-arrow-right ms-2"></i>
                                </button>

                                <p class="text-secondary text-center small mt-3 mb-0">
                                    Submitting this form requests an
                                    appointment. It does not confirm a
                                    booking or process a payment.
                                </p>

                            </form>
                        <?php endif; ?>

                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

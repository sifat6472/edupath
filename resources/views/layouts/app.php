<?php
/** @var array $sections */
/** @var string $content */
/** @var \App\Services\AuthService $auth */
/** @var string $csrf_token */
/** @var array $flash */
$title = $title ?? 'EduPath';
$showSuccess = $showSuccess ?? false;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= htmlspecialchars($csrf_token) ?>">
    <title><?= htmlspecialchars($title) ?></title>
    <!-- Favicon / EduPath icon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/favicon-192.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    <?php if (!empty($showSuccess) || !empty($flash['show_success_popup'])): ?>
    <script>window.__showSuccessPopup = true;</script>
    <?php endif; ?>
</head>
<body>
    <?php require BASE_PATH . '/resources/views/partials/navbar.php'; ?>

    <main>
        <?php if (!empty($flash['error'])): ?>
            <div class="container" style="padding-top: 20px;">
                <div class="flash flash-error"><?= htmlspecialchars(is_array($flash['error']) ? implode(', ', $flash['error']) : $flash['error']) ?></div>
            </div>
        <?php endif; ?>
        <?php if (!empty($flash['success'])): ?>
            <div class="container" style="padding-top: 20px;">
                <div class="flash flash-success"><?= htmlspecialchars($flash['success']) ?></div>
            </div>
        <?php endif; ?>
        <?php if (!empty($flash['errors']) && is_array($flash['errors'])): ?>
            <div class="container" style="padding-top: 20px;">
                <div class="flash flash-error">
                    <?php foreach ($flash['errors'] as $err): ?>
                        <div><?= htmlspecialchars($err) ?></div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <?= $content ?>
    </main>

    <?php require BASE_PATH . '/resources/views/partials/footer.php'; ?>

    <!-- Success Popup (iOS-style) -->
    <div class="success-popup-overlay" id="success-popup" onclick="if(event.target===this) hideSuccessPopup()">
        <div class="success-popup">
            <div class="success-icon">✓</div>
            <h3 class="success-title">Application Submitted!</h3>
            <p class="success-msg">Your application has been submitted successfully. Check notifications for updates.</p>
            <button class="btn btn-primary" onclick="hideSuccessPopup()">Continue</button>
        </div>
    </div>

    <script src="/js/app.js"></script>
</body>
</html>

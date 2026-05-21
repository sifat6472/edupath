<?php
$view_instance->extend('layouts.app');
$view_instance->startSection('content');
$old = $flash['old'] ?? [];
?>
<section class="auth-page">
    <div class="auth-card">
        <h1>Create your account</h1>
        <p class="auth-sub">Start your global education journey today</p>

        <form method="POST" action="/register" autocomplete="off">
            
            <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">

            <div class="form-group">
                <label class="form-label">Full Name <span class="required">*</span></label>
                <input type="text" name="name" class="form-control" required placeholder="Your full name" autocomplete="off" value="<?= htmlspecialchars($old['name'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label class="form-label">Email Address <span class="required">*</span></label>
                <input type="email" name="email" class="form-control" required placeholder="you@example.com" autocomplete="off" value="<?= htmlspecialchars($old['email'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label class="form-label">Password <span class="required">*</span></label>
                <input type="password" name="password" class="form-control" required minlength="6" placeholder="At least 6 characters" autocomplete="new-password">
            </div>

            <button type="submit" class="btn btn-primary btn-block btn-lg">Create Account</button>
        </form>

        <div class="auth-foot">
            Already have an account? <a href="/login">Log in</a>
        </div>
    </div>
</section>
<?php $view_instance->endSection(); ?>

<?php
$view_instance->extend('layouts.app');
$view_instance->startSection('content');
$old = $flash['old'] ?? [];
?>
<section class="auth-page">
    <div class="auth-card">
        <h1>Welcome back</h1>
        <p class="auth-sub">Log in to continue your application journey</p>

        <form method="POST" action="/login">
            <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">

            <div class="form-group">
                <label class="form-label">Email <span class="required">*</span></label>
                <input type="email" name="email" class="form-control" required placeholder="you@example.com" value="<?= htmlspecialchars($old['email'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label class="form-label">Password <span class="required">*</span></label>
                <input type="password" name="password" class="form-control" required placeholder="Enter your password">
            </div>

            <button type="submit" class="btn btn-primary btn-block btn-lg">Log In</button>
        </form>

        <div class="auth-foot">
            Don't have an account? <a href="/register">Sign up</a>
        </div>
        <!-- <div style="margin-top:18px;padding:14px;background:var(--bg-blue-soft);border-radius:8px;font-size:0.82rem;color:var(--text-secondary)">
            <strong>Demo accounts:</strong><br>
            Student: <code>nafis@edupath.com</code> / <code>password</code><br>
            Admin: <code>admin@edupath.com</code> / <code>admin123</code>
        </div> -->
    </div>
</section>
<?php $view_instance->endSection(); ?>

<?php
$view_instance->extend('layouts.app');
$view_instance->startSection('content');
?>
<section class="auth-page">
    <div style="text-align:center">
        <h1 style="font-size:5rem;color:var(--primary);margin-bottom:8px">404</h1>
        <h2 style="margin-bottom:12px">Page Not Found</h2>
        <p class="text-secondary" style="margin-bottom:20px">The page you're looking for doesn't exist.</p>
        <a href="/" class="btn btn-primary">Go Home</a>
    </div>
</section>
<?php $view_instance->endSection(); ?>

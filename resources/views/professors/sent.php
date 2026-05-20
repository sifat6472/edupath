<?php
/** @var array $professor */
/** @var string $mailto */
$view_instance->extend('layouts.app');
$view_instance->startSection('content');
?>
<section class="dashboard">
    <div class="container" style="max-width:520px">
        <div class="card" style="text-align:center;padding:40px">
            <div class="success-icon" style="margin: 0 auto 18px;">✓</div>
            <h2 style="margin-bottom:8px">Email Template Ready</h2>
            <p class="text-secondary" style="margin-bottom:20px">A professional email to <strong><?= htmlspecialchars($professor['name']) ?></strong> has been prepared. Click below to open it in your default email client.</p>

            <a href="<?= $mailto ?>" class="btn btn-primary btn-lg btn-block">📧 Open in Email Client</a>

            <div style="margin-top:16px;display:flex;gap:8px">
                <a href="/professors" class="btn btn-secondary btn-block">Back to Directory</a>
                <a href="/dashboard" class="btn btn-secondary btn-block">Dashboard</a>
            </div>

            <p style="font-size:0.8rem;color:var(--text-muted);margin-top:20px">
                If your email client doesn't open, copy this email address: <code><?= htmlspecialchars($professor['email']) ?></code>
            </p>
        </div>
    </div>
</section>
<?php $view_instance->endSection(); ?>

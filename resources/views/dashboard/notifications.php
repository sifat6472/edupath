<?php
$view_instance->extend('layouts.app');
$view_instance->startSection('content');
?>
<section class="dashboard">
    <div class="container">
        <div class="dashboard-header">
            <h1>Notifications</h1>
            <p>All your recent updates in one place</p>
        </div>

        <div class="card">
            <?php if (empty($notifications)): ?>
                <div class="empty-state">
                    <div class="empty-state-icon">🔕</div>
                    <p>No notifications yet.</p>
                </div>
            <?php else: foreach ($notifications as $n): ?>
                <div class="notif-item <?= $n['is_read'] ? '' : 'unread' ?>" data-id="<?= $n['id'] ?>" data-link="<?= htmlspecialchars($n['link'] ?? '#') ?>" style="border-bottom:1px solid var(--border)">
                    <div class="notif-title"><?= htmlspecialchars($n['title']) ?></div>
                    <div class="notif-msg"><?= htmlspecialchars($n['message']) ?></div>
                    <div class="notif-time"><?= htmlspecialchars(date('M d, Y · g:i A', strtotime($n['created_at']))) ?></div>
                </div>
            <?php endforeach; endif; ?>
        </div>
    </div>
</section>
<?php $view_instance->endSection(); ?>

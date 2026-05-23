<?php
/** @var array $applications */
/** @var bool $showSuccess */
$view_instance->extend('layouts.app');
$view_instance->startSection('content');
?>
<section class="dashboard">
    <div class="container">
        <div class="dashboard-header">
            <h1>My Applications</h1>
            <p>Track all your applications in one place</p>
        </div>

        <div class="card">
            <?php if (empty($applications)): ?>
                <div class="empty-state">
                    <div class="empty-state-icon">📭</div>
                    <p>No applications yet.</p>
                    <a href="/programs" class="btn btn-primary" style="margin-top:12px">Browse Programs</a>
                </div>
            <?php else: foreach ($applications as $app): ?>
                <div class="application-head">
                        <div>
                            <div class="application-title">
                                <?php
                                if ($app['type'] === 'lab') {
                                    echo htmlspecialchars($app['professor_name'] ?? 'Professor');
                                } else {
                                    echo htmlspecialchars($app['university_name'] ?? $app['scholarship_name'] ?? 'Application');
                                }
                                ?>
                            </div>
                            <div class="application-program">
                                <?php
                                if ($app['type'] === 'program') {
                                    echo htmlspecialchars($app['program_title'] ?? '—');
                                } elseif ($app['type'] === 'scholarship') {
                                    echo htmlspecialchars($app['scholarship_name'] ?? 'Scholarship Application');
                                } else {
                                    // Lab inquiry — show lab/department + university
                                    $labInfo = trim(($app['professor_department'] ?? '') . ' · ' . ($app['professor_university'] ?? ''), ' ·');
                                    echo '📧 Lab Inquiry — ' . htmlspecialchars($labInfo ?: ($app['professor_research'] ?? 'Research Lab'));
                                }
                                ?>
                            </div>
                        </div>
                        <span class="status-badge status-<?= htmlspecialchars($app['status']) ?>"><?= htmlspecialchars($app['status']) ?></span>
                    </div>
                    <div class="progress-meta">
                        <span>Type: <?= htmlspecialchars(ucfirst($app['type'])) ?></span>
                        <strong><?= (int)$app['progress'] ?>%</strong>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" data-progress="<?= (int)$app['progress'] ?>"></div>
                    </div>
                    <div class="app-foot">
                        <span>
                            <?php if ($app['submitted_at']): ?>
                                Submitted: <?= htmlspecialchars(date('M d, Y', strtotime($app['submitted_at']))) ?>
                            <?php else: ?>
                                Created: <?= htmlspecialchars(date('M d, Y', strtotime($app['created_at']))) ?>
                            <?php endif; ?>
                        </span>
                        <?php if ($app['deadline']): ?>
                            <span>Deadline: <?= htmlspecialchars(date('M d, Y', strtotime($app['deadline']))) ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; endif; ?>
        </div>
    </div>
</section>
<?php $view_instance->endSection(); ?>

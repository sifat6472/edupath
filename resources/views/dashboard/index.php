<?php
/** @var array $user */
/** @var array $stats */
/** @var array $applications */
/** @var array $upcomingDeadlines */
/** @var array $notifications */
$view_instance->extend('layouts.app');
$view_instance->startSection('content');
?>
<section class="dashboard">
    <div class="container">
        <div class="dashboard-header">
            <h1>Welcome back, <?= htmlspecialchars(explode(' ', $user['name'])[0]) ?>!</h1>
            <p>Track your application status and stay on top of your deadlines</p>
        </div>

        <!-- STATS -->
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-card-info">
                    <div class="label">Active Applications</div>
                    <div class="value"><?= $stats['active_applications'] ?></div>
                </div>
                <div class="stat-card-icon">📋</div>
            </div>
            <div class="stat-card">
                <div class="stat-card-info">
                    <div class="label">Upcoming Deadlines</div>
                    <div class="value"><?= $stats['upcoming_deadlines'] ?></div>
                </div>
                <div class="stat-card-icon">⏰</div>
            </div>
            <div class="stat-card">
                <div class="stat-card-info">
                    <div class="label">Scholarships Found</div>
                    <div class="value"><?= $stats['scholarships_found'] ?></div>
                </div>
                <div class="stat-card-icon">🎓</div>
            </div>
        </div>

        <div class="dashboard-grid">
            <!-- APPLICATION TRACKER -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Application Tracker</div>
                    <a href="/programs" class="btn btn-primary btn-sm">+ New Application</a>
                </div>

                <?php if (empty($applications)): ?>
                    <div class="empty-state">
                        <div class="empty-state-icon">📭</div>
                        <p>No applications yet. <a href="/programs">Browse programs</a> to start.</p>
                    </div>
                <?php else: foreach ($applications as $app): ?>
                    <div class="application-item">
                        <div class="application-head">
                            <div>
                                <div class="application-title">
                                    <?= htmlspecialchars($app['university_name'] ?? $app['scholarship_name'] ?? 'Application') ?>
                                </div>
                                <div class="application-program"><?= htmlspecialchars($app['program_title'] ?? $app['scholarship_name'] ?? '—') ?></div>
                            </div>
                            <span class="status-badge status-<?= htmlspecialchars($app['status']) ?>"><?= htmlspecialchars($app['status']) ?></span>
                        </div>
                        <div class="progress-meta">
                            <span>Progress</span>
                            <strong><?= (int)$app['progress'] ?>%</strong>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" data-progress="<?= (int)$app['progress'] ?>"></div>
                        </div>
                        <div class="app-foot">
                            <span>🗓 Deadline: <?= $app['deadline'] ? htmlspecialchars(date('m/d/Y', strtotime($app['deadline']))) : '—' ?></span>
                            <?php if ($app['program_id']): ?>
                                <a href="/programs/<?= $app['program_id'] ?>">View Details →</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; endif; ?>
            </div>

            <!-- UPCOMING DEADLINES -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title">🗓 Upcoming Deadlines</div>
                </div>

                <?php if (empty($upcomingDeadlines)): ?>
                    <div class="empty-state" style="padding: 24px 16px">
                        <p style="font-size:0.9rem;">No upcoming deadlines.</p>
                    </div>
                <?php else: foreach ($upcomingDeadlines as $i => $d):
                    $daysLeft = $d['deadline'] ? (int) ((strtotime($d['deadline']) - time()) / 86400) : null;
                    $isUrgent = $daysLeft !== null && $daysLeft < 14;
                ?>
                    <div class="deadline-item <?= $isUrgent ? 'urgent' : '' ?>">
                        <div class="deadline-head">
                            <div class="deadline-title">
                                <?= htmlspecialchars($d['university_name'] ?? 'Application') ?>
                            </div>
                            <?php if ($isUrgent): ?>
                                <span class="deadline-tag">Urgent</span>
                            <?php endif; ?>
                        </div>
                        <div class="deadline-meta">
                            <?= htmlspecialchars($d['program_title'] ?? '') ?><br>
                            <?= $d['deadline'] ? htmlspecialchars(date('M d, Y', strtotime($d['deadline']))) : '' ?>
                            <?php if ($daysLeft !== null && $daysLeft >= 0): ?>
                                — <strong><?= $daysLeft ?> days left</strong>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; endif; ?>

                <div style="margin-top:16px">
                    <a href="/applications" class="btn btn-outline btn-block">View All Applications</a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $view_instance->endSection(); ?>

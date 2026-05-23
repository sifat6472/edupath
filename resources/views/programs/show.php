<?php
/** @var array $program */
$view_instance->extend('layouts.app');
$view_instance->startSection('content');
$requirements = array_filter(array_map('trim', explode(';', $program['requirements'] ?? '')));
?>
<section class="dashboard">
    <div class="container">
        <a href="/programs" style="color:var(--text-secondary);font-size:0.9rem">← Back to Programs</a>

        <div class="detail-card" style="margin-top:16px">
            <div class="detail-card-head">
                <div>
                    <h2 style="font-size:1.6rem;margin-bottom:4px"><?= htmlspecialchars($program['title']) ?></h2>
                    <div class="text-secondary"><?= htmlspecialchars($program['university_name']) ?></div>
                </div>
                <?php if (!empty($hasApplied)): ?>
                    <span class="applied-badge">✓ Applied</span>
                <?php else: ?>
                    <a href="/programs/<?= $program['id'] ?>/apply" class="btn btn-primary">Apply Now</a>
                <?php endif; ?>
            </div>

            <div class="detail-grid-2">
                <div class="detail-item">
                    <div class="label">Location</div>
                    <div class="value"><?= htmlspecialchars($program['location'] ?? $program['city'] . ', ' . $program['country']) ?></div>
                </div>
                <div class="detail-item">
                    <div class="label">Duration</div>
                    <div class="value"><?= htmlspecialchars($program['duration']) ?></div>
                </div>
                <div class="detail-item">
                    <div class="label">Tuition</div>
                    <div class="value">$<?= number_format((float)$program['tuition_fee']) ?>/year</div>
                </div>
                <div class="detail-item">
                    <div class="label">World Ranking</div>
                    <div class="value">#<?= htmlspecialchars($program['ranking']) ?></div>
                </div>
                <div class="detail-item">
                    <div class="label">Application Deadline</div>
                    <div class="value"><?= $program['application_deadline'] ? date('M d, Y', strtotime($program['application_deadline'])) : '—' ?></div>
                </div>
                <div class="detail-item">
                    <div class="label">Scholarships</div>
                    <div class="value"><?= $program['scholarship_available'] ? '✓ Available' : '—' ?></div>
                </div>
            </div>

            <div class="detail-section">
                <h4>Program Overview</h4>
                <p><?= nl2br(htmlspecialchars($program['overview'] ?? '')) ?></p>
            </div>

            <?php if (!empty($requirements)): ?>
            <div class="detail-section">
                <h4>Requirements</h4>
                <ul>
                    <?php foreach ($requirements as $r): ?>
                        <li><?= htmlspecialchars($r) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>

            <div style="display:flex;gap:12px;margin-top:24px">
                <?php if (!empty($hasApplied)): ?>
                    <span class="applied-badge">✓ Applied</span>
                <?php else: ?>
                    <a href="/programs/<?= $program['id'] ?>/apply" class="btn btn-primary">Apply Now</a>
                <?php endif; ?>
                <?php $auth = \App\Services\AuthService::getInstance(); if ($auth->check()): ?>
                    <button class="btn btn-secondary save-btn <?= $isSaved ? 'active' : '' ?>" data-url="/programs/<?= $program['id'] ?>/save">
                        <?= $isSaved ? '★ Saved' : '☆ Save' ?>
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php $view_instance->endSection(); ?>

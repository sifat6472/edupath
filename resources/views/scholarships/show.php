<?php
/** @var array $scholarship */
$view_instance->extend('layouts.app');
$view_instance->startSection('content');
$benefits = array_filter(array_map('trim', explode(',', $scholarship['benefits'] ?? '')));
$requirements = array_filter(array_map('trim', explode(';', $scholarship['requirements'] ?? '')));
?>
<section class="dashboard">
    <div class="container">
        <a href="/scholarships" style="color:var(--text-secondary);font-size:0.9rem">← Back to Scholarships</a>

        <div class="detail-card" style="margin-top:16px">
            <div class="detail-card-head">
                <div>
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px">
                        <div style="width:36px;height:36px;border-radius:8px;background:var(--bg-blue-soft);display:grid;place-items:center;color:var(--accent);font-size:1.1rem">🎓</div>
                        <h2 style="font-size:1.6rem"><?= htmlspecialchars($scholarship['name']) ?></h2>
                    </div>
                    <div class="text-secondary"><?= htmlspecialchars($scholarship['provider']) ?></div>
                </div>
                <?php if (!empty($hasApplied)): ?>
                    <span class="applied-badge">✓ Applied</span>
                <?php else: ?>
                    <a href="/scholarships/<?= $scholarship['id'] ?>/apply" class="btn btn-primary">Apply Now</a>
                <?php endif; ?>
            </div>

            <div class="detail-grid-2">
                <div class="detail-item">
                    <div class="label">Award Amount</div>
                    <div class="value"><?= htmlspecialchars($scholarship['award_amount']) ?></div>
                </div>
                <div class="detail-item">
                    <div class="label">Application Deadline</div>
                    <div class="value"><?= $scholarship['deadline'] ? date('F d, Y', strtotime($scholarship['deadline'])) : '—' ?></div>
                </div>
                <div class="detail-item">
                    <div class="label">Study Level</div>
                    <div class="value"><?= htmlspecialchars($scholarship['study_level']) ?></div>
                </div>
                <div class="detail-item">
                    <div class="label">Country</div>
                    <div class="value"><?= htmlspecialchars($scholarship['country']) ?></div>
                </div>
                <div class="detail-item">
                    <div class="label">Scholarship Type</div>
                    <div class="value"><?= htmlspecialchars($scholarship['scholarship_type']) ?></div>
                </div>
                <div class="detail-item">
                    <div class="label">Eligibility</div>
                    <div class="value">International Students</div>
                </div>
            </div>

            <div class="detail-section">
                <h4>About the Scholarship</h4>
                <p><?= nl2br(htmlspecialchars($scholarship['description'] ?? '')) ?></p>
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

            <?php if (!empty($benefits)): ?>
            <div class="detail-section">
                <h4>Benefits</h4>
                <div class="scholarship-tags">
                    <?php foreach ($benefits as $b): ?>
                        <div class="scholarship-tag-row"><span class="icon">$</span> <?= htmlspecialchars($b) ?></div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <div style="margin-top:20px">
                <?php if (!empty($hasApplied)): ?>
                    <span class="applied-badge">✓ Applied</span>
                <?php else: ?>
                    <a href="/scholarships/<?= $scholarship['id'] ?>/apply" class="btn btn-primary btn-lg">Apply Now</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php $view_instance->endSection(); ?>

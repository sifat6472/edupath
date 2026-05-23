<?php
/** @var array $professor */
/** @var array $labs */
$view_instance->extend('layouts.app');
$view_instance->startSection('content');
?>
<section class="dashboard">
    <div class="container" style="max-width:760px">
        <a href="/professors" style="color:var(--text-secondary);font-size:0.9rem">← Back to Directory</a>

        <div class="detail-card" style="margin-top:16px">
            <div class="detail-card-head">
                <div style="display:flex;gap:16px;align-items:flex-start">
                    <div class="prof-avatar" style="width:60px;height:60px;font-size:1.2rem">
                        <?php
                        $initials = '';
                        foreach (explode(' ', $professor['name']) as $word) {
                            if (preg_match('/[A-Z]/', $word)) $initials .= $word[0];
                            if (strlen($initials) >= 2) break;
                        }
                        echo htmlspecialchars($initials);
                        ?>
                    </div>
                    <div>
                        <h2 style="font-size:1.5rem;margin-bottom:2px"><?= htmlspecialchars($professor['name']) ?></h2>
                        <div class="text-secondary"><?= htmlspecialchars($professor['title']) ?></div>
                        <div class="text-accent" style="font-weight:600;font-size:0.85rem;margin-top:2px"><?= htmlspecialchars($professor['university_name']) ?></div>
                    </div>
                </div>
                <span class="prof-status <?= $professor['accepting_students'] ? 'status-accepting' : 'status-not-accepting' ?>">
                    <?= $professor['accepting_students'] ? 'Accepting Students' : 'Not Accepting' ?>
                </span>
            </div>

            <h4 style="margin: 24px 0 12px;">Overview</h4>
            <div class="detail-grid-2">
                <div class="detail-item">
                    <div class="label">Location</div>
                    <div class="value"><?= htmlspecialchars($professor['city'] . ', ' . $professor['country']) ?></div>
                </div>
                <div class="detail-item">
                    <div class="label">Academic Metric</div>
                    <div class="value">Publications: <?= (int)$professor['publications'] ?>+</div>
                </div>
                <div class="detail-item">
                    <div class="label">Research Area</div>
                    <div class="value"><?= htmlspecialchars($professor['research_area']) ?></div>
                </div>
                <div class="detail-item">
                    <div class="label">Department</div>
                    <div class="value"><?= htmlspecialchars($professor['department']) ?></div>
                </div>
            </div>

            <?php if (!empty($professor['bio'])): ?>
            <div class="detail-section">
                <h4>Biography</h4>
                <p><?= nl2br(htmlspecialchars($professor['bio'])) ?></p>
            </div>
            <?php endif; ?>

            <?php if (!empty($labs)): ?>
            <div class="detail-section">
                <h4>Research Labs</h4>
                <?php foreach ($labs as $lab): ?>
                    <div class="card" style="margin-bottom:12px;padding:16px">
                        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:8px">
                            <strong><?= htmlspecialchars($lab['name']) ?></strong>
                            <?php if ($lab['funded']): ?>
                                <span class="scholarship-tag">💰 Funded</span>
                            <?php endif; ?>
                        </div>
                        <p style="font-size:0.9rem;color:var(--text-secondary);margin-bottom:8px"><?= htmlspecialchars($lab['description']) ?></p>
                        <div style="font-size:0.82rem;color:var(--text-muted)">
                            <strong>Focus:</strong> <?= htmlspecialchars($lab['research_focus']) ?>
                            <?php if ($lab['open_positions'] > 0): ?>
                                · <strong style="color:var(--success)"><?= $lab['open_positions'] ?> open position<?= $lab['open_positions'] === 1 ? '' : 's' ?></strong>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <div style="margin-top:24px">
                <?php if ($professor['accepting_students']): ?>
                    <a href="/professors/<?= $professor['id'] ?>/contact" class="btn btn-primary btn-lg">Contact Now</a>
                <?php else: ?>
                    <span class="btn btn-disabled btn-lg" title="Not accepting students">Not Accepting Students</span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php $view_instance->endSection(); ?>

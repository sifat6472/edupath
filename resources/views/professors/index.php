<?php
/** @var array $professors */
$view_instance->extend('layouts.app');
$view_instance->startSection('content');
?>
<section class="dashboard">
    <div class="container">
        <div class="dashboard-header">
            <h1>Professor &amp; Lab Directory</h1>
            <p>Connect with faculty members and explore labs according to your interest</p>
        </div>

        <form method="GET" action="/professors" class="search-bar">
            <input type="text" name="q" class="search-input" placeholder="Search name, research topic or university..." value="<?= htmlspecialchars($filters['q']) ?>">
            <label class="filter-btn" style="display:inline-flex;align-items:center;gap:6px;cursor:pointer">
                <input type="checkbox" name="accepting" value="1" <?= $filters['accepting'] ? 'checked' : '' ?>>
                Accepting Students Only
            </label>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>

        <p class="text-secondary" style="margin-bottom:16px"><?= count($professors) ?> professor<?= count($professors) === 1 ? '' : 's' ?> found</p>

        <div class="prof-grid">
            <?php if (empty($professors)): ?>
                <div class="empty-state" style="grid-column:1/-1">
                    <div class="empty-state-icon">👨‍🏫</div>
                    <p>No professors match your search.</p>
                </div>
            <?php else: foreach ($professors as $p): ?>
                <div class="prof-card">
                    <div class="prof-head">
                        <div class="prof-avatar">
                            <?php
                            $initials = '';
                            foreach (explode(' ', $p['name']) as $word) {
                                if (preg_match('/[A-Z]/', $word)) $initials .= $word[0];
                                if (strlen($initials) >= 2) break;
                            }
                            echo htmlspecialchars($initials);
                            ?>
                        </div>
                        <div class="prof-info">
                            <h4><?= htmlspecialchars($p['name']) ?></h4>
                            <div class="role"><?= htmlspecialchars($p['title']) ?></div>
                            <div class="uni"><?= htmlspecialchars($p['university_name']) ?></div>
                        </div>
                        <span class="prof-status <?= $p['accepting_students'] ? 'status-accepting' : 'status-not-accepting' ?>">
                            <?= $p['accepting_students'] ? 'Accepting' : 'Not Accepting' ?>
                        </span>
                    </div>

                    <div class="prof-meta">
                        <div class="prof-meta-row"><span class="icon">📍</span> <?= htmlspecialchars($p['city'] . ', ' . $p['country']) ?></div>
                        <div class="prof-meta-row"><span class="icon">🔬</span> Research Area: <?= htmlspecialchars($p['research_area']) ?></div>
                        <div class="prof-meta-row"><span class="icon">🏛</span> Lab: <?= htmlspecialchars($p['department']) ?></div>
                        <div class="prof-meta-row"><span class="icon">📄</span> Publications: <?= (int)$p['publications'] ?>+</div>
                    </div>

                    <div class="prof-actions">
                        <a href="/professors/<?= $p['id'] ?>/contact" class="btn btn-primary <?= $p['accepting_students'] ? '' : 'btn-secondary' ?>" <?= $p['accepting_students'] ? '' : 'aria-disabled="true"' ?>>Contact Now</a>
                        <a href="/professors/<?= $p['id'] ?>" class="btn btn-secondary">Profile</a>
                    </div>
                </div>
            <?php endforeach; endif; ?>
        </div>
    </div>
</section>
<?php $view_instance->endSection(); ?>

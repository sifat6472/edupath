<?php
/** @var array $programs */
/** @var array $filters */
$view_instance->extend('layouts.app');
$view_instance->startSection('content');
?>
<section class="dashboard">
    <div class="container">
        <div class="dashboard-header">
            <h1>Explore Programs</h1>
            <p>Discover and compare programs from universities around the world</p>
        </div>

        <form method="GET" action="/programs" class="search-bar">
            <input type="text" name="q" class="search-input" placeholder="Search programs, universities or fields of study..." value="<?= htmlspecialchars($filters['q']) ?>">
            <select name="country" class="filter-btn">
                <option value="">All Countries</option>
                <?php foreach (['USA', 'UK', 'Canada', 'Germany', 'Switzerland', 'Singapore'] as $c): ?>
                    <option value="<?= $c ?>" <?= $filters['country'] === $c ? 'selected' : '' ?>><?= $c ?></option>
                <?php endforeach; ?>
            </select>
            <select name="degree_level" class="filter-btn">
                <option value="">All Levels</option>
                <option value="Masters" <?= $filters['degree_level'] === 'Masters' ? 'selected' : '' ?>>Masters</option>
                <option value="Bachelors" <?= $filters['degree_level'] === 'Bachelors' ? 'selected' : '' ?>>Bachelors</option>
                <option value="PhD" <?= $filters['degree_level'] === 'PhD' ? 'selected' : '' ?>>PhD</option>
            </select>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>

        <div>
            <?php if (empty($programs)): ?>
                <div class="empty-state">
                    <div class="empty-state-icon">🔍</div>
                    <p>No programs match your search. Try adjusting filters.</p>
                </div>
            <?php else: foreach ($programs as $p): ?>
                <div class="list-card">
                    <div>
                        <div class="list-card-title"><?= htmlspecialchars($p['title']) ?></div>
                        <div class="list-card-sub"><?= htmlspecialchars($p['university_name']) ?></div>
                        <div class="list-card-meta">
                            <span>📍 <?= htmlspecialchars($p['location'] ?? ($p['city'] . ', ' . $p['country'])) ?></span>
                            <span>⏱ <?= htmlspecialchars($p['duration']) ?></span>
                            <span>💰 $<?= number_format((float)$p['tuition_fee']) ?>/year</span>
                            <?php if (!empty($p['application_deadline'])): ?>
                                <span>🗓 Deadline: <?= htmlspecialchars(date('m/d/Y', strtotime($p['application_deadline']))) ?></span>
                            <?php endif; ?>
                        </div>
                        <?php if ($p['scholarship_available']): ?>
                            <span class="scholarship-tag">✓ Scholarship Available</span>
                        <?php endif; ?>
                    </div>
                    <div class="list-card-actions">
                        <a href="/programs/<?= $p['id'] ?>/apply" class="btn btn-primary">Apply Now</a>
                        <a href="/programs/<?= $p['id'] ?>" class="btn btn-secondary">View Details</a>
                    </div>
                </div>
            <?php endforeach; endif; ?>
        </div>
    </div>
</section>
<?php $view_instance->endSection(); ?>

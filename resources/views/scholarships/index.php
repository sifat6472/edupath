<?php
/** @var array $scholarships */
$view_instance->extend('layouts.app');
$view_instance->startSection('content');
?>
<section class="dashboard">
    <div class="container">
        <div class="dashboard-header">
            <h1>Scholarships</h1>
            <p>Find funding opportunities for your studies abroad</p>
        </div>

        <form method="GET" action="/scholarships" class="search-bar">
            <input type="text" name="q" class="search-input" placeholder="Search scholarships..." value="<?= htmlspecialchars($filters['q']) ?>">
            <select name="country" class="filter-btn">
                <option value="">All Countries</option>
                <?php foreach (['United States', 'United Kingdom', 'Germany'] as $c): ?>
                    <option value="<?= $c ?>" <?= $filters['country'] === $c ? 'selected' : '' ?>><?= $c ?></option>
                <?php endforeach; ?>
            </select>
            <select name="study_level" class="filter-btn">
                <option value="">All Levels</option>
                <option value="Graduate" <?= $filters['study_level'] === 'Graduate' ? 'selected' : '' ?>>Graduate</option>
                <option value="Masters" <?= $filters['study_level'] === 'Masters' ? 'selected' : '' ?>>Masters</option>
            </select>
            <button type="submit" class="btn btn-primary">Filter</button>
            <?php if (!empty($filters['q']) || !empty($filters['country']) || !empty($filters['study_level'])): ?>
                <a href="/scholarships" class="btn btn-secondary">Reset Filters</a>
            <?php endif; ?>
        </form>

        <div>
            <?php if (empty($scholarships)): ?>
                <div class="empty-state">
                    <div class="empty-state-icon">🎓</div>
                    <p>No scholarships found.</p>
                </div>
            <?php else: foreach ($scholarships as $s): ?>
                <div class="list-card">
                    <div>
                        <div class="list-card-title"><?= htmlspecialchars($s['name']) ?></div>
                        <div class="list-card-sub"><?= htmlspecialchars($s['provider']) ?></div>
                        <div class="list-card-meta">
                            <span>🌍 <?= htmlspecialchars($s['country']) ?></span>
                            <span>💰 <?= htmlspecialchars($s['award_amount']) ?></span>
                            <span>🎓 <?= htmlspecialchars($s['study_level']) ?></span>
                            <?php if (!empty($s['deadline'])): ?>
                                <span>🗓 <?= htmlspecialchars(date('M d, Y', strtotime($s['deadline']))) ?></span>
                            <?php endif; ?>
                        </div>
                        <span class="scholarship-tag"><?= htmlspecialchars($s['scholarship_type']) ?></span>
                    </div>
                    <div class="list-card-actions">
                        <a href="/scholarships/<?= $s['id'] ?>/apply" class="btn btn-primary">Apply Now</a>
                        <a href="/scholarships/<?= $s['id'] ?>" class="btn btn-secondary">View Details</a>
                    </div>
                </div>
            <?php endforeach; endif; ?>
        </div>
    </div>
</section>
<?php $view_instance->endSection(); ?>

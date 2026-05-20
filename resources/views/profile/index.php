<?php
/** @var array $user */
/** @var ?array $preferences */
/** @var array $savedItems */
$view_instance->extend('layouts.app');
$view_instance->startSection('content');
?>
<section class="dashboard">
    <div class="container">
        <div class="dashboard-header">
            <h1>My Profile</h1>
            <p>Manage your account, preferences, and saved opportunities</p>
        </div>

        <div class="dashboard-grid">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Personal Information</div>
                </div>
                <div style="display:flex;align-items:center;gap:16px;margin-bottom:20px">
                    <div class="prof-avatar" style="width:60px;height:60px;font-size:1.4rem">
                        <?= strtoupper(substr($user['name'], 0, 1)) ?>
                    </div>
                    <div>
                        <h3 style="font-size:1.2rem"><?= htmlspecialchars($user['name']) ?></h3>
                        <p class="text-secondary" style="font-size:0.9rem"><?= htmlspecialchars($user['email']) ?></p>
                        <span class="status-badge status-submitted" style="margin-top:6px;display:inline-block"><?= htmlspecialchars(ucfirst($user['role'])) ?></span>
                    </div>
                </div>

                <div class="detail-grid-2" style="border:none;padding:0;margin:0">
                    <div class="detail-item">
                        <div class="label">Phone</div>
                        <div class="value"><?= htmlspecialchars($user['phone'] ?? '—') ?></div>
                    </div>
                    <div class="detail-item">
                        <div class="label">Joined</div>
                        <div class="value"><?= htmlspecialchars(date('M Y', strtotime($user['created_at']))) ?></div>
                    </div>
                </div>

                <?php if ($preferences): ?>
                <div style="margin-top:20px">
                    <h4 style="font-size:1rem;margin-bottom:10px">Preferences</h4>
                    <div class="detail-grid-2" style="border:none;padding:0;margin:0">
                        <div class="detail-item">
                            <div class="label">Country</div>
                            <div class="value"><?= htmlspecialchars($preferences['preferred_country'] ?: 'Any') ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="label">Field</div>
                            <div class="value"><?= htmlspecialchars($preferences['preferred_field'] ?: 'Any') ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="label">Degree</div>
                            <div class="value"><?= htmlspecialchars($preferences['preferred_degree'] ?: 'Any') ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="label">Budget</div>
                            <div class="value"><?= htmlspecialchars($preferences['budget_range'] ?: 'Any') ?></div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <a href="/preferences" class="btn btn-secondary" style="margin-top:16px">Update Preferences</a>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="card-title">⭐ Saved Opportunities</div>
                </div>

                <?php if (empty($savedItems)): ?>
                    <div class="empty-state" style="padding:24px 0">
                        <p style="font-size:0.9rem">No saved items yet.</p>
                    </div>
                <?php else: foreach ($savedItems as $item): ?>
                    <div class="application-item" style="margin-bottom:8px">
                        <div class="application-head">
                            <div>
                                <div class="application-title">
                                    <?= htmlspecialchars($item['title'] ?? $item['name']) ?>
                                </div>
                                <div class="application-program">
                                    <?= htmlspecialchars($item['uni'] ?? $item['provider'] ?? $item['research_area'] ?? '') ?>
                                </div>
                            </div>
                            <span class="status-badge status-pending"><?= htmlspecialchars($item['_type']) ?></span>
                        </div>
                    </div>
                <?php endforeach; endif; ?>
            </div>
        </div>
    </div>
</section>
<?php $view_instance->endSection(); ?>

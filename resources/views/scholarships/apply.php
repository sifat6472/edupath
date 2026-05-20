<?php
/** @var array $scholarship */
$view_instance->extend('layouts.app');
$view_instance->startSection('content');
$old = $flash['old'] ?? [];
$user = $auth->user();
?>
<section class="dashboard">
    <div class="container" style="max-width:720px">
        <a href="/scholarships/<?= $scholarship['id'] ?>" style="color:var(--text-secondary);font-size:0.9rem">← Back</a>

        <div class="card" style="margin-top:16px">
            <h2 style="margin-bottom:4px"><?= htmlspecialchars($scholarship['name']) ?></h2>
            <p class="text-secondary" style="margin-bottom:24px"><?= htmlspecialchars($scholarship['provider']) ?></p>

            <form method="POST" action="/scholarships/<?= $scholarship['id'] ?>/apply">
                <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">

                <div class="form-group">
                    <label class="form-label">Full Name <span class="required">*</span></label>
                    <input type="text" name="full_name" class="form-control" required value="<?= htmlspecialchars($old['full_name'] ?? $user['name']) ?>">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Email Address <span class="required">*</span></label>
                        <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($old['email'] ?? $user['email']) ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Phone Number <span class="required">*</span></label>
                        <input type="text" name="phone" class="form-control" required value="<?= htmlspecialchars($old['phone'] ?? $user['phone'] ?? '') ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Current Education <span class="required">*</span></label>
                    <input type="text" name="current_education" class="form-control" required placeholder="e.g., BSc Computer Science, University XYZ" value="<?= htmlspecialchars($old['current_education'] ?? '') ?>">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">GPA <span class="required">*</span></label>
                        <input type="text" name="gpa" class="form-control" required placeholder="e.g., 3.8" value="<?= htmlspecialchars($old['gpa'] ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Test Score</label>
                        <input type="text" name="test_score" class="form-control" placeholder="GRE: 320" value="<?= htmlspecialchars($old['test_score'] ?? '') ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Proof of Achievements</label>
                    <input type="text" class="form-control" placeholder="Software Engineer at companyX 2 years" disabled>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Recommendation Letters</label>
                        <input type="text" class="form-control" placeholder="Attached" disabled>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Language Test Score</label>
                        <input type="text" class="form-control" placeholder="IELTS: 6.5" disabled>
                    </div>
                </div>

                <div style="display:flex;gap:12px;justify-content:flex-end;margin-top:8px">
                    <a href="/scholarships/<?= $scholarship['id'] ?>" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Apply Now</button>
                </div>
            </form>
        </div>
    </div>
</section>
<?php $view_instance->endSection(); ?>

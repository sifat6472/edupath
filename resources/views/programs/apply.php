<?php
/** @var array $program */
$view_instance->extend('layouts.app');
$view_instance->startSection('content');
$old = $flash['old'] ?? [];
$user = $auth->user();
?>
<section class="dashboard">
    <div class="container" style="max-width:720px">
        <a href="/programs/<?= $program['id'] ?>" style="color:var(--text-secondary);font-size:0.9rem">← Back to Program</a>

        <div class="card" style="margin-top:16px">
            <h2 style="margin-bottom:6px">Apply to <?= htmlspecialchars($program['title']) ?></h2>
            <p class="text-secondary" style="margin-bottom:24px"><?= htmlspecialchars($program['university_name']) ?> · Application Form</p>

            <form method="POST" action="/programs/<?= $program['id'] ?>/apply">
                <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">

                <div class="form-group">
                    <label class="form-label">Full Name <span class="required">*</span></label>
                    <input type="text" name="full_name" class="form-control" required value="<?= htmlspecialchars($old['full_name'] ?? $user['name'] ?? '') ?>" placeholder="Enter your full name">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Email Address <span class="required">*</span></label>
                        <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($old['email'] ?? $user['email'] ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Phone Number <span class="required">*</span></label>
                        <input type="text" name="phone" class="form-control" required value="<?= htmlspecialchars($old['phone'] ?? $user['phone'] ?? '') ?>" placeholder="+880 1555000000">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Current Education <span class="required">*</span></label>
                    <input type="text" name="current_education" class="form-control" required value="<?= htmlspecialchars($old['current_education'] ?? '') ?>" placeholder="e.g., BSc Computer Science, University XYZ">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">GPA <span class="required">*</span></label>
                        <input type="text" name="gpa" class="form-control" required value="<?= htmlspecialchars($old['gpa'] ?? '') ?>" placeholder="e.g., 3.8">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Test Score</label>
                        <input type="text" name="test_score" class="form-control" value="<?= htmlspecialchars($old['test_score'] ?? '') ?>" placeholder="GRE: 320">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Work Experience</label>
                    <textarea name="work_experience" class="form-control" placeholder="Software Engineer at company X — 2 years"><?= htmlspecialchars($old['work_experience'] ?? '') ?></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Statement of Purpose <span class="required">*</span></label>
                    <textarea name="statement_of_purpose" class="form-control" required minlength="20" style="min-height:140px" placeholder="Explain your motivation for applying to this program..."><?= htmlspecialchars($old['statement_of_purpose'] ?? '') ?></textarea>
                </div>

                <div style="display:flex;gap:12px;justify-content:flex-end;margin-top:8px">
                    <a href="/programs/<?= $program['id'] ?>" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Apply Now</button>
                </div>
            </form>
        </div>
    </div>
</section>
<?php $view_instance->endSection(); ?>

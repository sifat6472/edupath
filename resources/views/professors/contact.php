<?php
/** @var array $professor */
$view_instance->extend('layouts.app');
$view_instance->startSection('content');
$old = $flash['old'] ?? [];
$user = $auth->user();
?>
<section class="dashboard">
    <div class="container" style="max-width:520px">
        <a href="/professors/<?= $professor['id'] ?>" style="color:var(--text-secondary);font-size:0.9rem">← Back</a>

        <div class="card" style="margin-top:16px">
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:6px">
                <div class="prof-avatar" style="width:36px;height:36px;font-size:0.85rem">SA</div>
                <div>
                    <h3 style="font-size:1.05rem"><?= htmlspecialchars($professor['name']) ?></h3>
                    <div style="font-size:0.8rem;color:var(--text-secondary)"><?= htmlspecialchars($professor['university_name']) ?></div>
                </div>
            </div>
            <p class="text-secondary" style="margin-bottom:20px;font-size:0.88rem">Send a personalized message expressing your interest in their research</p>

            <form method="POST" action="/professors/<?= $professor['id'] ?>/contact">
                <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">

                <div class="form-group">
                    <label class="form-label">Full Name <span class="required">*</span></label>
                    <input type="text" name="full_name" class="form-control" required value="<?= htmlspecialchars($old['full_name'] ?? $user['name']) ?>">
                </div>

                <div class="form-group">
                    <label class="form-label">Email Address <span class="required">*</span></label>
                    <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($old['email'] ?? $user['email']) ?>">
                </div>

                <div class="form-group">
                    <label class="form-label">Phone Number <span class="required">*</span></label>
                    <input type="text" name="phone" class="form-control" required value="<?= htmlspecialchars($old['phone'] ?? $user['phone'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label class="form-label">Current Education <span class="required">*</span></label>
                    <textarea name="current_education" class="form-control" required placeholder="Dear Professor, I'm writing to..."><?= htmlspecialchars($old['current_education'] ?? '') ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Send Email</button>
            </form>
        </div>
    </div>
</section>
<?php $view_instance->endSection(); ?>

<?php
$view_instance->extend('layouts.app');
$view_instance->startSection('content');
?>
<section class="auth-page">
    <div class="auth-card" style="max-width: 560px">
        <h1>Set Your Preferences</h1>
        <p class="auth-sub">Help us personalize program recommendations for you</p>

        <form method="POST" action="/preferences">
            <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Preferred Country</label>
                    <select name="preferred_country" class="form-control">
                        <option value="">Any Country</option>
                        <option>USA</option>
                        <option>UK</option>
                        <option>Canada</option>
                        <option>Germany</option>
                        <option>Australia</option>
                        <option>Singapore</option>
                        <option>Switzerland</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Preferred Field</label>
                    <select name="preferred_field" class="form-control">
                        <option value="">Any Field</option>
                        <option>Computer Science</option>
                        <option>Engineering</option>
                        <option>Business</option>
                        <option>Bio Informatics</option>
                        <option>Data Science</option>
                        <option>AI</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Degree Level</label>
                    <select name="preferred_degree" class="form-control">
                        <option value="">Any Level</option>
                        <option>Bachelors</option>
                        <option>Masters</option>
                        <option>PhD</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Budget Range</label>
                    <select name="budget_range" class="form-control">
                        <option value="">No Limit</option>
                        <option>Under $20,000</option>
                        <option>$20,000 - $40,000</option>
                        <option>$40,000 - $60,000</option>
                        <option>$60,000+</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Research Interests</label>
                <textarea name="interests" class="form-control" placeholder="e.g., Machine Learning, NLP, Robotics..."></textarea>
            </div>

            <div style="display:flex;gap:12px;margin-top:8px">
                <a href="/dashboard" class="btn btn-secondary btn-block">Skip for Now</a>
                <button type="submit" class="btn btn-primary btn-block">Save &amp; Continue</button>
            </div>
        </form>
    </div>
</section>
<?php $view_instance->endSection(); ?>

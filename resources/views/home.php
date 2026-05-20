<?php
/** @var \App\Core\View $view_instance */
/** @var array $stats */
$view_instance->extend('layouts.app');
$view_instance->startSection('content');
?>
<!-- HERO -->
<section class="hero">
    <div class="container hero-grid">
        <div>
            <div class="hero-badge">⭐ Trusted by 1000+ Students</div>
            <h1>Your Path to <span class="accent">Global<br>Education</span> Starts Here</h1>
            <p>Discover, compare, and apply to universities worldwide. Get personalized guidance, track deadlines, and find scholarships — all in one place.</p>
            <div class="hero-cta">
                <a href="/programs" class="btn btn-primary btn-lg">Explore Programs</a>
                <a href="/scholarships" class="btn btn-secondary btn-lg">Find Scholarships</a>
            </div>
            <div class="hero-stats">
                <div class="hero-stat">
                    <div class="hero-stat-value">10,000+</div>
                    <div class="hero-stat-label">Programs</div>
                </div>
                <div class="hero-stat">
                    <div class="hero-stat-value">150+</div>
                    <div class="hero-stat-label">Universities</div>
                </div>
                <div class="hero-stat">
                    <div class="hero-stat-value">$2M+</div>
                    <div class="hero-stat-label">In Scholarships</div>
                </div>
            </div>
        </div>
        <div class="hero-image">
            <div class="hero-image-main" style="background-image: linear-gradient(135deg, rgba(30,58,138,0.4), rgba(59,130,246,0.4)), url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=800&q=80')"></div>
            <div class="hero-image-sub" style="background-image: linear-gradient(135deg, rgba(251,191,36,0.3), rgba(245,158,11,0.3)), url('https://images.unsplash.com/photo-1532012197267-da84d127e765?w=600&q=80')"></div>
        </div>
    </div>
</section>

<!-- FEATURES -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <h2>Everything You Need to Succeed</h2>
            <p>Comprehensive tools and resources to simplify your university application journey</p>
        </div>
        <div class="feature-grid">
            <div class="feature-card">
                <div class="feature-icon">🌐</div>
                <h3>Global Search</h3>
                <p>Search thousands of programs across 50+ countries with advanced filters.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🎓</div>
                <h3>Scholarship Finder</h3>
                <p>Find merit-based and need-based scholarships matched to your profile.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">⏰</div>
                <h3>Deadline Tracking</h3>
                <p>Never miss a deadline with smart reminders and a personalized calendar.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">👨‍🏫</div>
                <h3>Professor Connect</h3>
                <p>Discover funded labs and connect directly with professors via email.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📋</div>
                <h3>Application Guideline</h3>
                <p>Step-by-step guidance through every stage of your application.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📈</div>
                <h3>Progress Tracking</h3>
                <p>Visualize your application progress in real-time with intuitive dashboards.</p>
            </div>
        </div>
    </div>
</section>

<!-- HOW IT WORKS -->
<section class="section" style="background: var(--bg-soft);">
    <div class="container">
        <div class="section-header">
            <h2>How EduPath Works</h2>
            <p>Four simple steps to your dream university</p>
        </div>
        <div class="steps">
            <div class="step">
                <div class="step-icon">👤</div>
                <h4>Create Profile</h4>
                <p>Sign up and set your academic preferences</p>
            </div>
            <div class="step">
                <div class="step-icon">🧭</div>
                <h4>Explore Programs</h4>
                <p>Discover matching opportunities worldwide</p>
            </div>
            <div class="step">
                <div class="step-icon">📝</div>
                <h4>Apply</h4>
                <p>Submit applications with guided forms</p>
            </div>
            <div class="step">
                <div class="step-icon">✅</div>
                <h4>Track &amp; Succeed</h4>
                <p>Monitor your progress to acceptance</p>
            </div>
        </div>
        <div style="text-align: center; margin-top: 40px;">
            <a href="/register" class="btn btn-primary btn-lg">Get Started Today</a>
        </div>
    </div>
</section>

<!-- CTA -->
<section>
    <div class="cta-section">
        <h2>Ready to Start Your Journey?</h2>
        <p>Join thousands of students who have successfully secured admissions and scholarships at top universities worldwide.</p>
        <a href="/register" class="btn btn-primary btn-lg">Sign Up Free</a>
    </div>
</section>

<?php $view_instance->endSection(); ?>

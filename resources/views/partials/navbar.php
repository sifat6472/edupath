<?php
/** @var \App\Services\AuthService $auth */
/** @var string $csrf_token */
$auth = \App\Services\AuthService::getInstance();
$user = $auth->user();
$currentUri = $_SERVER['REQUEST_URI'] ?? '/';

$unreadCount = 0;
$recentNotifs = [];
if ($auth->check()) {
    $notifRepo = new \App\Repositories\NotificationRepository();
    $unreadCount = $notifRepo->countUnread($auth->id());
    $recentNotifs = $notifRepo->getUserNotifications($auth->id(), 6);
}

function isActive($path, $currentUri) {
    return strpos($currentUri, $path) === 0 ? 'active' : '';
}
?>
<header class="navbar">
    <div class="container navbar-inner">
        <a href="/" class="navbar-brand">
            <img src="/images/edupath-logo.png" alt="EduPath" class="navbar-logo">
        </a>

        <nav>
            <ul class="navbar-nav">
                <li><a href="/programs" class="<?= isActive('/programs', $currentUri) ?>">Programs</a></li>
                <li><a href="/scholarships" class="<?= isActive('/scholarships', $currentUri) ?>">Scholarships</a></li>
                <li><a href="/professors" class="<?= isActive('/professors', $currentUri) ?>">Professors</a></li>
                <?php if ($auth->check()): ?>
                    <li><a href="/dashboard" class="<?= isActive('/dashboard', $currentUri) ?>">Dashboard</a></li>
                <?php endif; ?>
            </ul>
        </nav>

        <div class="navbar-actions">
            <?php if ($auth->check()): ?>
                <div class="notif-wrap desktop-only">
                    <button class="notif-bell" aria-label="Notifications">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/></svg>
                        <?php if ($unreadCount > 0): ?>
                            <span class="notif-badge"><?= $unreadCount ?></span>
                        <?php endif; ?>
                    </button>
                    <div class="notif-panel">
                        <div class="notif-head">
                            <strong>Notifications</strong>
                            <?php if ($unreadCount > 0): ?>
                                <form method="POST" action="/notifications/mark-all-read" style="margin:0">
                                    <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
                                    <button type="submit" class="btn btn-sm btn-secondary">Mark all read</button>
                                </form>
                            <?php endif; ?>
                        </div>
                        <?php if (empty($recentNotifs)): ?>
                            <div class="empty-state" style="padding:30px 16px">No notifications yet</div>
                        <?php else: foreach ($recentNotifs as $n): ?>
                            <div class="notif-item <?= $n['is_read'] ? '' : 'unread' ?>" data-id="<?= $n['id'] ?>" data-link="<?= htmlspecialchars($n['link'] ?? '#') ?>">
                                <div class="notif-title"><?= htmlspecialchars($n['title']) ?></div>
                                <div class="notif-msg"><?= htmlspecialchars($n['message']) ?></div>
                                <div class="notif-time"><?= htmlspecialchars(date('M d, Y', strtotime($n['created_at']))) ?></div>
                            </div>
                        <?php endforeach; endif; ?>
                    </div>
                </div>

                <a href="/profile" class="user-avatar desktop-only" title="<?= htmlspecialchars($user['name']) ?>">
                    <?= strtoupper(substr($user['name'], 0, 1)) ?>
                </a>
                <form method="POST" action="/logout" class="desktop-only" style="margin:0">
                    <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
                    <button type="submit" class="btn btn-secondary btn-sm">Logout</button>
                </form>
            <?php else: 
                $onAuthPage = in_array($currentUri, ['/login', '/register']);
            ?>
                <?php if (!$onAuthPage): ?>
                    <a href="/login" class="btn btn-secondary btn-sm desktop-only">Log In</a>
                    <a href="/register" class="btn btn-primary btn-sm">Get Started</a>
                <?php elseif ($currentUri === '/login'): ?>
                    <a href="/register" class="btn btn-primary btn-sm">Get Started</a>
                <?php else: ?>
                    <a href="/login" class="btn btn-secondary btn-sm desktop-only">Log In</a>
                <?php endif; ?>
            <?php endif; ?>

            <button class="mobile-toggle" aria-label="Menu">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>
</header>
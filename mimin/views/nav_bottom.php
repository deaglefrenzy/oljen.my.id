<?php
$current_page = $_GET['page'] ?? 'iuran';
$count = 0;

$menu_items = [
    'members' => [
        'label' => 'MEMBERS',
        'color' => 'blue',
        'href' => '?page=members',
        'icon' => 'fa-solid fa-children',
    ],
    'orders' => [
        'label' => 'ORDERS',
        'color' => 'green',
        'href' => '?page=orders',
        'icon' => 'fa-solid fa-hand-holding-dollar',
    ],
    'report' => [
        'label' => 'REPORT',
        'color' => 'yellow',
        'href' => 'report.php',
        'icon' => 'fa-solid fa-chart-line',
        'blank' => true,
    ],
    'user' => [
        'label' => $login_name,
        'color' => 'red',
        'href' => '?page=user',
        'icon' => 'fa-solid fa-user-gear',
    ],
];
?>
<div class="bottom-nav">
    <?php foreach ($menu_items as $item): ?>
        <?php
        $count++;
        if ($count > 5)
            break;
        parse_str(parse_url($item['href'], PHP_URL_QUERY), $params);
        $is_active = ($current_page ?? '') == ($params['page'] ?? '');
        ?>
        <a href="<?= $item['href'] ?>" class="<?= $item['color'] ?> <?= $is_active ? 'active' : '' ?>" <?= ($item['blank'] ?? false) ? 'target="_blank" rel="noopener noreferrer"' : '' ?>>
            <i class="<?= $item['icon'] ?>"></i>
            <span class="reddit">
                <?= $item['label'] ?>
            </span>
        </a>
    <?php endforeach; ?>
</div>
<style>
    .bottom-nav {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background: #000;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        display: flex;
        align-items: center;
        padding: 2px 0 calc(2px + env(safe-area-inset-bottom));
        z-index: 9999;
    }

    .bottom-nav a {
        flex: 1 1 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 2px;
        text-decoration: none;
        color: #fff;
        font-size: 10px;
        padding: 4px 0;
        transition: 0.2s ease;
        text-align: center;
        min-width: 0;
    }

    /* smaller icon area */
    .bottom-nav a i {
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
        flex-shrink: 0;
    }

    /* tighter text */
    .bottom-nav a span {
        height: 12px;
        line-height: 12px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .bottom-nav a.green.active {
        color: #22c55e;
    }

    .bottom-nav a.red.active {
        color: #ef4444;
    }

    .bottom-nav a.blue.active {
        color: #3b82f6;
    }

    .bottom-nav a.yellow.active {
        color: #facc15;
    }

    .bottom-nav a.purple.active {
        color: #a855f7;
    }

    /* smaller bottom spacing */
    body {
        padding-bottom: 60px;
    }
</style>

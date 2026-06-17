<?php
$data_items = [
    [
        'label' => 'STOK',
        'color' => 'amber',
        'href' => '?page=stock_data',
        'icon' => 'fa-solid fa-boxes-stacked',
    ],
    [
        'label' => 'PRODUK',
        'color' => 'aqua',
        'href' => '?page=products',
        'icon' => 'fa-solid fa-fish',
    ],
    [
        'label' => 'USER',
        'color' => 'light-gray',
        'href' => '?page=user',
        'icon' => 'fa-solid fa-user',
    ],
];
?>
<div class="main-menu">
    <?php
    foreach ($data_items as $item):
        ?>
        <a href="<?= $item['href'] ?>" class="menu-btn">
            <div class="menu-icon <?= 'w3-text-' . $item['color'] ?>"><i class="<?= $item['icon'] ?>"></i></div>
            <span><?= $item['label'] ?></span>
        </a>
    <?php endforeach; ?>
</div>

<style>
    .main-menu {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;

        padding: 15px;
    }

    .menu-btn {
        background: #444;
        color: #fff;
        text-decoration: none;

        border-radius: 18px;

        min-height: 110px;

        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;

        font-size: 15px;

        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);

        transition: 0.2s;
    }

    .menu-icon {
        font-size: 40px;
        line-height: 1;
    }

    .menu-btn:hover {
        background: #555;
        transform: translateY(-2px);
    }

    .menu-btn span {
        margin-top: 8px;
    }

    .logout-btn {
        background: #a94442;
    }

    .logout-btn:hover {
        background: #c55350;
    }

    /* desktop */
    @media(min-width:768px) {

        .main-menu {
            grid-template-columns: repeat(3, 1fr);
            max-width: 900px;
            margin: auto;
        }

        .menu-btn {
            min-height: 140px;
            font-size: 17px;
        }

    }
</style>

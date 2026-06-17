<style>
    :root {
        --topbar-bg: #111;
        --topbar-text: #fff;
        --topbar-muted: rgba(255, 255, 255, 0.75);
    }

    .topbar {
        background: rgba(0, 0, 0, 1);
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 9999;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
    }

    .topbar-inner {
        height: 42px;
        max-width: 520px;
        margin: auto;

        display: flex;
        align-items: center;
        justify-content: space-between;

        padding: 0 14px;
        gap: 12px;
    }

    /* LEFT */
    .topbar-title {
        min-width: 0;

        display: flex;
        align-items: center;
        gap: 10px;

        color: var(--topbar-text);

        font-size: 15px;

        overflow: hidden;
    }

    .topbar-title span {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .topbar-title i {
        font-size: 16px;
        flex-shrink: 0;
    }

    /* RIGHT */
    .topbar-actions {
        display: flex;
        align-items: center;
        gap: 4px;

        flex-shrink: 0;
    }

    .topbar-btn {
        width: 38px;
        height: 38px;

        border: none;
        border-radius: 12px;

        background: transparent;

        color: var(--topbar-muted);

        display: flex;
        align-items: center;
        justify-content: center;

        cursor: pointer;

        transition: 0.2s ease;
    }

    .topbar-btn i {
        font-size: 18px;
    }

    .topbar-btn:hover {
        background: rgba(255, 255, 255, 0.08);
        color: #fff;
    }

    .topbar-btn:active {
        transform: scale(0.92);
    }

    /* refresh animation */
    #refreshBtn.spin i {
        transform: rotate(360deg);
        transition: transform 0.5s ease;
    }
</style>

<div class="topbar">
    <div class="topbar-inner">

        <!-- LEFT -->
        <div class="topbar-title reddit">
            <span>
                <a href="<?= $menu_items[$page]['href'] ?>">
                    <i class="<?= $menu_items[$page]['icon'] ?> w3-text-<?= $menu_items[$page]['color'] ?>"></i>
                    <?= $menu_items[$page]['label'] ?>
                </a> • <?= $admin_page_title ?>
            </span>
        </div>

        <!-- RIGHT -->
        <div class="topbar-actions">
            <?php
            if (count($top_items) > 0) {
                foreach ($top_items as $item): ?>
                    <button type="button" class="topbar-btn" onclick="<?= $item['href'] ?>">
                        <i class="<?= $item['icon'] ?>"></i>
                    </button>
                    <?php
                endforeach;
            } ?>
            <button class="topbar-btn" id="refreshBtn" aria-label="Refresh">
                <i class="fa-solid fa-rotate"></i>
            </button>
        </div>

    </div>
</div>

<script>
    const topbar = document.querySelector('.topbar');

    let lastScroll = 0;

    window.addEventListener('scroll', () => {
        const currentScroll = window.scrollY;

        if (currentScroll > 20) {
            topbar.classList.add('shrink');
        } else {
            topbar.classList.remove('shrink');
        }

        lastScroll = currentScroll;
    });
</script>

<script>
    const refreshBtn = document.getElementById('refreshBtn');

    refreshBtn.addEventListener('click', () => {
        // trigger spin
        refreshBtn.classList.add('spin');

        // remove class after animation (so it can replay)
        setTimeout(() => {
            refreshBtn.classList.remove('spin');
        }, 400);

        // refresh page (slight delay for UX)
        setTimeout(() => {
            location.reload();
        }, 300);
    });
</script>

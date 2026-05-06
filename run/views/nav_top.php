<div class="topbar">
    <div class="topbar-inner">

        <!-- LEFT (logo) -->
        <div class="topbar-left">
            <a href="https://<?= $urlwebsite ?>">
                <img src="../images/logo1.png" class="topbar-logo" alt="Logo">
            </a>
        </div>

        <!-- CENTER (title) -->
        <div class="topbar-center font4">
            <?= $website_name ?>
        </div>

        <!-- RIGHT (actions) -->
        <div class="topbar-right">
            <button id="refreshBtn" aria-label="Refresh">
                <i class="fa-solid fa-rotate font4"></i>
            </button>
        </div>

    </div>
</div>

<style>
    :root {
        --nav-accent:
            <?= $color4 ?>
        ;
        --nav-muted: rgba(255, 255, 255, 0.65);
    }

    /* DEFAULT (expanded) */
    .topbar-inner {
        position: relative;
        height: 56px;
        max-width: 520px;
        margin: 0 auto;

        display: flex;
        align-items: center;
        justify-content: space-between;

        padding: 0 12px;
        transition: height 0.25s ease;
    }

    /* SHRUNK STATE */

    .topbar.shrink {
        background: color-mix(in srgb, var(--nav-bg) 92%, transparent);
    }

    .topbar.shrink .topbar-inner {
        height: 44px;
    }

    /* logo animation */
    .topbar-logo {
        height: 28px;
        border-radius: 6px;
        transition: height 0.25s ease;
    }

    .topbar.shrink .topbar-logo {
        height: 22px;
    }

    /* title animation */
    .topbar-center {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);

        font-size: 15px;
        font-weight: 600;
        letter-spacing: 0.2px;

        color: var(--nav-accent);

        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 70%;
        text-align: center;

        transition: all 0.25s ease;
    }

    .topbar.shrink .topbar-center {
        font-size: 13px;
        opacity: 0.9;
    }

    /* optional: tighten right icons */
    .topbar-right a {
        font-size: 18px;
        transition: transform 0.25s ease;
    }

    .topbar.shrink .topbar-right a {
        transform: scale(0.9);
    }

    /* reset button style */
    #refreshBtn {
        background: none;
        border: none;
        padding: 6px;
        cursor: pointer;

        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* icon style */
    #refreshBtn i {
        font-size: 18px;
        color: var(--nav-accent);
        transition: transform 0.4s ease;
    }

    /* spin animation */
    #refreshBtn.spin i {
        transform: rotate(360deg);
    }

    /* tap feedback */
    #refreshBtn:active {
        transform: scale(0.85);
    }
</style>

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

<?php
/* ============================================================
   BOTTOM NAVIGATION  —  bottom-nav.php
   Include anywhere with: <?php include 'bottom-nav.php'; ?>

   EDIT YOUR MENU ITEMS BELOW.
   Each item accepts:
     label  => text under the icon (string)
     href   => link URL (string)
     icon   => Font Awesome class string e.g. 'fa-solid fa-house'
     fab    => center action button style (bool)
============================================================ */

$nav_items = [
  [
    'label' => 'Home',
    'href' => '/run',
    'icon' => 'fa-solid fa-house',
  ],
  [
    'label' => 'Klasemen',
    'href' => '?page=klasemen',
    'icon' => 'fa-solid fa-list-ol',
  ],
  [
    'label' => 'Setor',
    'href' => '?page=setor',
    'icon' => 'fa-solid fa-circle-plus',
  ],
  // [
  //   'label' => 'Matches',
  //   'href' => '?page=matches',
  //   'icon' => 'fa-solid fa-clock',
  //   'fab' => true,
  // ],
  // [
  //   'label' => 'Pools',
  //   'href' => '?page=pools',
  //   'icon' => 'fa-solid fa-square-poll-horizontal',
  //   'fab' => true,
  // ],
  // [
  //   'label' => 'Knockout',
  //   'href' => '?page=knockout',
  //   'icon' => 'fa-solid fa-trophy',
  // ],
];

/* Auto-detect active item from current filename */
$current_page = basename($_SERVER['PHP_SELF']);
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<nav id="bottom-nav" aria-label="Main navigation">
  <ul>
    <?php foreach ($nav_items as $item):
      $href = $item['href'];

      // Improved active detection
      $is_active = false;

      if (strpos($href, '?') !== false) {
        // handle query-based links like ?page=klasemen
        parse_str(parse_url($href, PHP_URL_QUERY), $query);
        $is_active = isset($query['page']) && ($_GET['page'] ?? '') === $query['page'];
      } else {
        // handle normal links
        $is_active = basename($href) === basename($_SERVER['PHP_SELF']);
      }
      ?>
      <li>
        <a href="<?= htmlspecialchars($href) ?>" <?= $is_active ? 'class="is-active" aria-current="page"' : '' ?>
          aria-label="<?= htmlspecialchars($item['label']) ?>">

          <span class="nav-icon">
            <i class="<?= htmlspecialchars($item['icon']) ?> font3"></i>
          </span>

          <span class="font4"><?= htmlspecialchars($item['label']) ?></span>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
</nav>
<button id="goTopBtn" aria-label="Go to top">
  <i class="fa-solid fa-arrow-up"></i>
</button>

<style>
  :root {
    --nav-accent: #fff;
    --nav-muted: rgba(255, 255, 255, 0.65);
  }

  /* BOTTOM NAV */
  #bottom-nav {
    position: fixed;
    left: 50%;
    transform: translateX(-50%);
    bottom: calc(16px + env(safe-area-inset-bottom));
    z-index: 999;

    padding: 10px 16px;
    border-radius: 24px;

    /* SOLID background (no transparency) */
    background: #121212;

    /* remove blur */
    backdrop-filter: none;
    -webkit-backdrop-filter: none;

    border: 1px solid rgba(255, 255, 255, 0.08);
    transition: border-color 0.2s ease, box-shadow 0.2s ease;

    /* subtle depth instead of blur */
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.35);

    transform: translateX(-50%) translateY(4px) scale(0.98);
    opacity: 0.95;

    transition:
      transform 0.25s ease,
      opacity 0.25s ease,
      box-shadow 0.25s ease,
      border-color 0.25s ease;
  }

  /* active while scrolling */
  #bottom-nav.is-scrolling {
    transform: translateX(-50%) translateY(0) scale(1);
    opacity: 1;

    border-color: rgba(255, 255, 255, 0.35);

    box-shadow:
      0 10px 22px rgba(0, 0, 0, 0.45),
      0 0 10px rgba(255, 255, 255, 0.12);
  }

  /* NAV LAYOUT */
  #bottom-nav ul {
    margin: 0;
    padding: 0;
    list-style: none;

    display: flex;
    gap: 24px;
    align-items: center;
    justify-content: center;
  }

  #bottom-nav a {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;

    padding: 6px 6px;
    min-width: 52px;

    color: var(--nav-muted);
    font-size: 11px;
    text-decoration: none;

    transition: 0.2s ease;
  }

  #bottom-nav a.is-active {
    color: var(--nav-accent);
  }

  #bottom-nav a:active {
    transform: scale(0.9);
  }

  .nav-icon i {
    font-size: 18px;
  }

  /* remove expensive gradient overlay */
  #bottom-nav::before {
    display: none;
  }

  /* GO TOP BUTTON */
  #goTopBtn {
    position: fixed;
    right: 16px;
    bottom: calc(90px + env(safe-area-inset-bottom));
    z-index: 998;

    width: 46px;
    height: 46px;
    border-radius: 50%;

    /* SOLID */
    background: #121212;

    backdrop-filter: none;
    -webkit-backdrop-filter: none;

    border: 1px solid rgba(255, 255, 255, 0.08);

    color: var(--nav-accent);
    font-size: 16px;

    display: flex;
    align-items: center;
    justify-content: center;

    /* subtle shadow instead */
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.35);

    opacity: 0;
    pointer-events: none;
    transform: translateY(12px);

    transition: all 0.3s ease;
  }

  #goTopBtn.show {
    opacity: 1;
    pointer-events: auto;
    transform: translateY(0);
  }

  #goTopBtn:active {
    transform: scale(0.9);
  }
</style>

<script>
  const goTopBtn = document.getElementById('goTopBtn');

  // Show button after scrolling down
  window.addEventListener('scroll', () => {
    if (window.scrollY > 300) {
      goTopBtn.classList.add('show');
    } else {
      goTopBtn.classList.remove('show');
    }
  });

  // Smooth scroll to top (iOS-safe)
  goTopBtn.addEventListener('click', () => {
    // iOS Safari fallback
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;

    // modern smooth scroll
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });
</script>

<script id="scrollglow">
  document.addEventListener("DOMContentLoaded", function () {
    let scrollTimer;
    const nav = document.getElementById('bottom-nav');

    if (!nav) return;

    window.addEventListener('scroll', () => {
      nav.classList.add('is-scrolling');

      clearTimeout(scrollTimer);
      scrollTimer = setTimeout(() => {
        nav.classList.remove('is-scrolling');
      }, 180); // slightly smoother delay
    });
  });
</script>

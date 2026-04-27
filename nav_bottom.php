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
    'href'  => '${urlwebsite}',
    'icon'  => 'fa-solid fa-house',
  ],
  [
    'label' => 'Setor',
    'href'  => '?page=setor',
    'icon'  => 'fa-solid fa-plus',
    'fab'   => true,
  ],
  [
    'label' => 'Klasemen',
    'href'  => '?page=klasemen',
    'icon'  => 'fa-solid fa-user',
  ],
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
        <a href="<?= htmlspecialchars($href) ?>"
          <?= $is_active ? 'class="is-active" aria-current="page"' : '' ?>
          aria-label="<?= htmlspecialchars($item['label']) ?>">

          <span class="nav-icon">
            <i class="<?= htmlspecialchars($item['icon']) ?>"></i>
          </span>

          <span><?= htmlspecialchars($item['label']) ?></span>
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
    --nav-bg: #ffffff;
    --nav-accent: #111111;
    --nav-muted: #888888;
    --nav-border: rgba(0, 0, 0, 0.08);
  }

  @media (prefers-color-scheme: dark) {
    :root {
      --nav-bg: #111111;
      --nav-accent: #ffffff;
      --nav-muted: #aaaaaa;
      --nav-border: rgba(255, 255, 255, 0.08);
    }
  }

  #bottom-nav {
    position: fixed;
    left: 50%;
    transform: translateX(-50%);
    bottom: calc(16px + env(safe-area-inset-bottom));
    z-index: 999;

    padding: 8px 14px;
    border-radius: 20px;

    background: color-mix(in srgb, var(--nav-bg) 80%, transparent);
    backdrop-filter: blur(18px);
    -webkit-backdrop-filter: blur(18px);

    border: 1px solid var(--nav-border);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
  }

  #bottom-nav ul {
    margin: 0;
    padding: 0;
    list-style: none;

    display: flex;
    gap: 22px;
    align-items: center;
    justify-content: center;
  }

  #bottom-nav li {
    flex: none;
  }

  #bottom-nav a {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;

    padding: 6px 4px;
    min-width: 52px;

    color: var(--nav-muted);
    font-size: 11px;
    text-decoration: none;
    transition: all 0.2s ease;
  }

  #bottom-nav a.is-active {
    color: var(--nav-accent);
  }

  #bottom-nav a:active {
    transform: scale(0.9);
  }

  #bottom-nav a:focus-visible {
    outline: 2px solid var(--nav-accent);
    outline-offset: 2px;
    border-radius: 8px;
  }

  .nav-icon i {
    font-size: 18px;
    transition: transform 0.2s ease;
  }

  #bottom-nav a.is-active i {
    transform: translateY(-1px);
    filter: drop-shadow(0 0 6px rgba(255, 255, 255, 0.4));
  }

  #goTopBtn {
    position: fixed;
    right: 16px;
    bottom: calc(90px + env(safe-area-inset-bottom));
    /* above your nav */
    z-index: 998;

    width: 44px;
    height: 44px;
    border: none;
    border-radius: 50%;

    background: color-mix(in srgb, var(--nav-bg) 85%, transparent);
    backdrop-filter: blur(18px);
    -webkit-backdrop-filter: blur(18px);

    border: 1px solid var(--nav-border);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);

    color: var(--nav-accent);
    font-size: 16px;
    cursor: pointer;

    display: flex;
    align-items: center;
    justify-content: center;

    opacity: 0;
    pointer-events: none;
    transform: translateY(10px);
    transition: all 0.25s ease;
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

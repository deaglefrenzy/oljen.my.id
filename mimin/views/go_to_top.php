<button class="scroll-top-btn">
  <i class="fa-solid fa-arrow-up"></i>
</button>

<style>
  .scroll-top-btn {
    position: fixed;
    right: 16px;
    bottom: 90px;

    width: 48px;
    height: 48px;

    border: none;
    border-radius: 999px;

    background: #111;
    color: #fff;

    display: flex;
    align-items: center;
    justify-content: center;

    font-size: 18px;

    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.35);

    cursor: pointer;

    z-index: 99999;

    opacity: 0;
    visibility: hidden;

    transition:
      opacity 0.25s ease,
      visibility 0.25s ease,
      transform 0.25s ease;
  }

  .scroll-top-btn.show-btn {
    opacity: 1;
    visibility: visible;
  }

  .scroll-top-btn:active {
    transform: scale(0.92);
  }
</style>

<script>
  (function () {

    const scrollButton = document.querySelector('.scroll-top-btn');

    function checkScrollPosition() {

      const currentScroll =
        window.pageYOffset ||
        document.documentElement.scrollTop;

      if (currentScroll > 200) {
        scrollButton.classList.add('show-btn');
      } else {
        scrollButton.classList.remove('show-btn');
      }

    }

    window.addEventListener('scroll', checkScrollPosition);

    scrollButton.onclick = function () {

      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });

    };

    checkScrollPosition();

  })();
</script>

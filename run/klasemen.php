<style>
    .hero-banner {
        display: flex;
        align-items: center;
        gap: 14px;

        padding: 14px;

        border-radius: 18px;

        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
    }

    .hero-logo {
        width: 90px;
        flex-shrink: 0;
    }

    .hero-info {
        flex: 1;

        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;

        border-bottom: 1px solid rgba(255, 255, 255, 0.25);

        padding-bottom: 6px;
        padding-left: 20px;
    }

    .info-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .info-label {
        font-size: 12px;
        color: #fff;
    }

    .info-value {
        font-size: 20px;
        font-weight: bold;
        color: #111;
    }
</style>
<?php
$q = mysqli_query($conn, "SELECT sum(distance) as distance FROM runs WHERE distance > 0 AND deleted_at IS NULL");
$row = mysqli_fetch_assoc($q);
$totalDistance = $row['distance'];
?>
<div class="w3-content w3-center" style="width: 90%; max-width: 480px; text-align: center;">
    <div class="hero-banner">

        <img src="images/runkmc.png" class="hero-logo" alt="RUNKMC Logo">

        <div class="hero-info">

            <div class="info-item">
                <div class="info-label">Total Jarak</div>
                <div class="info-value">
                    <span id="distance">0</span><?= unit('km', 'small') ?></span>
                </div>
            </div>

            <div class="info-item">
                <div class="info-label">Waktu Tersisa</div>
                <div class="info-value" id="countdown">
                    00:00:00
                </div>
            </div>

        </div>

    </div>
    <div class="w3-padding"></div>
    <?php include('entry.php') ?>
    <div style="height: 50px;"></div>
</div>

<script>
    // ======================
    // DISTANCE ANIMATION
    // ======================

    const targetDistance = <?= (float) $totalDistance ?>;

    const duration = 2000;

    const distanceEl = document.getElementById("distance");

    let startTime = null;

    function animateDistance(timestamp) {

        if (!startTime)
            startTime = timestamp;

        const progress = Math.min((timestamp - startTime) / duration, 1);

        const current = progress * targetDistance;

        distanceEl.textContent =
            current.toLocaleString('id-ID', {
                minimumFractionDigits: 1,
                maximumFractionDigits: 1
            });

        if (progress < 1)
            requestAnimationFrame(animateDistance);
    }

    requestAnimationFrame(animateDistance);


    // ======================
    // COUNTDOWN
    // ======================

    const targetDate = new Date("2026-05-24T23:59:59").getTime();

    function updateCountdown() {

        const now = new Date().getTime();

        const diff = targetDate - now;

        if (diff <= 0) {
            document.getElementById("countdown").innerHTML = "Selesai";
            return;
        }

        const days = Math.floor(diff / (1000 * 60 * 60 * 24));

        const hours = Math.floor((diff / (1000 * 60 * 60)) % 24);

        const minutes = Math.floor((diff / (1000 * 60)) % 60);

        const seconds = Math.floor((diff / 1000) % 60);

        document.getElementById("countdown").innerHTML =
            days + "h " +
            String(hours).padStart(2, '0') + ":" +
            String(minutes).padStart(2, '0') + ":" +
            String(seconds).padStart(2, '0');
    }

    updateCountdown();

    setInterval(updateCountdown, 1000);
</script>

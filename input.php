<?php

$dis = "";
$now = strtotime(date("Y-m-d"));
$your_date = strtotime("2025-03-08");
$your_date2 = strtotime("2025-04-30");
$datediff = $your_date - $now;
$diff = round($datediff / (60 * 60 * 24));
if ($diff < 0) $dis = "disabled";
//echo $diff;

?>
<form action="https://oljen.my.id" method="post" onsubmit="return confirm('Setor Ride Ini?');">
	<select name="idorang">
		<option value="" disabled selected>Pilih Oljener...</option>
		<?php
		$q = mysqli_query($conn, "SELECT * FROM orang ORDER BY name");
		while ($qq = mysqli_fetch_array($q)) {
			$idorang = $qq['id'];
			$dis = "";
			$r = mysqli_fetch_array(mysqli_query($conn, "SELECT sum(distance) as tot FROM rides WHERE orang_id='$idorang'"));
			if ($r['tot'] >= 1000) $dis = "disabled";
		?>
			<option value="<?php echo $idorang; ?>" <?php echo $dis; ?>><?php echo $qq['name']; ?></option>
		<?php
		}
		?>
	</select>
	<p>
		<textarea style="width: 85%;" rows="2" name="link" placeholder="Link ride dari STRAVA&#10;Contoh :&#10;https://strava.app.link/mZhDrxSOaBb"></textarea>
	</p>

	<p>
		<button type="submit" class="cool-button small" name="action" value="inputride" <?php echo $dis; ?>>
			<i class="fa fa-plus"></i> <i class="fa-solid fa-person-biking"></i> Setor</button>
	</p>
</form>

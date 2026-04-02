<?php
if ($success): ?>
    <div class="success">Data saved successfully</div>
<?php endif; ?>
<div class="card">
    <form method="post">
        <input type="hidden" name="action" value="add orang">
        <label>Nama:</label>
        <input type="text" name="name" required>
        <br>
        <button type="submit" class="button">Add Orang</button>
    </form>
</div>

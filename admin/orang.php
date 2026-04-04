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

<div class="card">
    <h3>Existing Orang</h3>
    <table>
        <?php
        if (empty($orang) || !is_array($orang)) {
            echo "<tr><td colspan='2'>No orang found.</td></tr>";
        } else {
            foreach ($orang as $o): ?>
                <tr>
                    <td><?= htmlspecialchars($o['name']) ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="action" value="activate orang">
                            <input type="hidden" name="id" value="<?= $o['id'] ?>">
                            <input type="hidden" name="active" value="<?= $o['active'] ?>">
                            <?php
                            if ($o['active']) {
                                echo "<button type='submit' class='button w3-gray w3-small'>Disable</button>";
                            } else {
                                echo "<button type='submit' class='button w3-green w3-small'>Activate</button>";
                            }
                            ?>
                        </form>
                    </td>
                </tr>
        <?php endforeach;
        }
        ?>
    </table>
</div>

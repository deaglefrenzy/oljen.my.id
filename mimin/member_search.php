<div class="w3-row-padding w3-stretch">
    <div class="w3-col s12 m8">
        <form method="post" autocomplete="off">
            <div class="autocomplete">
                <input type="text" id="memberInput" name="name" placeholder="🔍 Cari Member" class="w3-input w3-border"
                    required>
                <div id="suggestions" class="suggestions"></div>
            </div>
        </form>
    </div>
</div>
<?php
$members = getData('members', 'active = 1', 'name ASC');
?>
<script>
    const members = <?= json_encode(array_values($members)) ?>;

    initAutocomplete({
        inputId: "memberInput",
        suggestionId: "suggestions",
        data: members,
        searchField: "name",
        idField: "id",
        paramName: "member_id"
    });
</script>

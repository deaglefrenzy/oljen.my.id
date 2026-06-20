<?php
function getData($table, $where = '', $order = '')
{
    global $conn;
    $data = [];
    $query = "SELECT * FROM $table";
    if ($where) {
        $query .= " WHERE $where";
    }
    if ($order) {
        $query .= " ORDER BY $order";
    }
    $q = mysqli_query($conn, $query) or die(mysqli_error($conn));
    while ($row = mysqli_fetch_assoc($q)) {
        $data[$row['id']] = $row;
    }
    return $data;
}

function getRow($table, $where)
{
    global $conn;

    $query = "SELECT * FROM $table WHERE $where LIMIT 1";
    $q = mysqli_query($conn, $query) or die(mysqli_error($conn));

    return mysqli_fetch_assoc($q);
}

function getValue($table, $field, $where = '')
{
    global $conn;

    $query = "SELECT $field FROM $table";
    if ($where) {
        $query .= " WHERE $where";
    }

    $query .= " LIMIT 1";

    $q = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $row = mysqli_fetch_assoc($q);

    return $row[$field] ?? null;
}

function getCount($table, $where = '')
{
    global $conn;

    $query = "SELECT COUNT(*) as total FROM $table";

    if ($where) {
        $query .= " WHERE $where";
    }

    $q = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $row = mysqli_fetch_assoc($q);

    return (int) $row['total'];
}

function insert($table, $data)
{
    global $conn;

    $fields = array_keys($data);

    $columns = implode(',', $fields);
    $placeholders = implode(',', array_fill(0, count($data), '?'));

    $sql = "INSERT INTO `$table` ($columns) VALUES ($placeholders)";

    $stmt = mysqli_prepare($conn, $sql);

    $types = str_repeat('s', count($data));
    $values = array_values($data);

    $params = array_merge([$types], refValues($values));

    call_user_func_array([$stmt, 'bind_param'], $params);

    mysqli_stmt_execute($stmt);

    return mysqli_insert_id($conn);
}

function update($table, $data, $where)
{
    global $conn;

    $set = [];

    foreach ($data as $field => $value) {
        $value = mysqli_real_escape_string($conn, $value);
        $set[] = "$field = '$value'";
    }

    $set = implode(', ', $set);

    $query = "UPDATE $table SET $set WHERE $where";

    return mysqli_query($conn, $query);
}

function delete($table, $where)
{
    global $conn;

    $query = "DELETE FROM $table WHERE $where";

    return mysqli_query($conn, $query);
}

function softDelete($table, $where)
{
    global $conn;
    global $now;

    $query = "UPDATE $table SET deleted_at = $now WHERE $where";

    return mysqli_query($conn, $query);
}

function refValues($arr)
{
    $refs = [];

    foreach ($arr as $key => $value) {
        $refs[$key] = &$arr[$key];
    }

    return $refs;
}

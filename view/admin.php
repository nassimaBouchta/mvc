<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.html');
    exit();
}

try {
    $dbh = new PDO('mysql:host=localhost;dbname=test_db', 'root', '');
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection error: " . $e->getMessage());
}

$message = '';

// ── DELETE ──────────────────────────────────────────────────────
if (isset($_POST['action']) && $_POST['action'] === 'delete') {
    $stm = $dbh->prepare("DELETE FROM user WHERE email = ?");
    $stm->execute([$_POST['email']]);
    $message = "User <strong>" . htmlspecialchars($_POST['email']) . "</strong> deleted.";
}

// ── UPDATE ──────────────────────────────────────────────────────
if (isset($_POST['action']) && $_POST['action'] === 'update') {
    $visibilityMap = ['visible' => 1, 'visible to friends' => 2, 'invisible' => 3];
    $visibilityInt = isset($visibilityMap[$_POST['visibility']]) ? $visibilityMap[$_POST['visibility']] : 1;

    $stm = $dbh->prepare(
        "UPDATE user SET email=?, name=?, telephone=?, website=?, birthday=?, description=?, visibility=?
         WHERE email=?"
    );
    $stm->execute([
        $_POST['email'], $_POST['name'], $_POST['phone'],
        $_POST['website'], $_POST['birthday'], $_POST['description'],
        $visibilityInt, $_POST['orig_email']
    ]);
    $message = "User <strong>" . htmlspecialchars($_POST['email']) . "</strong> updated.";
}

$stm = $dbh->prepare("SELECT * FROM user");
$stm->execute();
$users = $stm->fetchAll(PDO::FETCH_ASSOC);

$visibilityLabel = [1 => 'visible', 2 => 'visible to friends', 3 => 'invisible'];
$editing = isset($_GET['edit']) ? $_GET['edit'] : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
</head>
<body>
<h1>Admin Panel – User Management</h1>
<a href="../view/bienvenue.php">← Back</a>

<?php if ($message): ?>
    <p><?= $message ?></p>
<?php endif; ?>

<?php if (empty($users)): ?>
    <p>No users found.</p>
<?php else: ?>
<table border="1" cellpadding="6" cellspacing="0">
    <thead>
        <tr>
            <th>Email</th><th>Name</th><th>Phone</th><th>Website</th>
            <th>Birthday</th><th>Visibility</th><th>Description</th><th>Role</th><th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($users as $user): ?>
        <?php $visStr = $visibilityLabel[$user['visibility']] ?? 'visible'; ?>

        <?php if ($editing === $user['email']): ?>
        <tr>
            <form method="post" action="admin.php">
            <input type="hidden" name="action"     value="update">
            <input type="hidden" name="orig_email" value="<?= htmlspecialchars($user['email']) ?>">
            <td><input type="email" name="email"    value="<?= htmlspecialchars($user['email'])    ?>"></td>
            <td><input type="text"  name="name"     value="<?= htmlspecialchars($user['name'])     ?>"></td>
            <td><input type="tel"   name="phone"    value="<?= htmlspecialchars($user['telephone'])?>"></td>
            <td><input type="url"   name="website"  value="<?= htmlspecialchars($user['website'])  ?>"></td>
            <td><input type="date"  name="birthday" value="<?= htmlspecialchars($user['birthday']) ?>"></td>
            <td>
                <select name="visibility">
                    <option value="visible"            <?= $visStr==='visible'            ? 'selected':'' ?>>Visible</option>
                    <option value="visible to friends" <?= $visStr==='visible to friends' ? 'selected':'' ?>>Visible to friends</option>
                    <option value="invisible"          <?= $visStr==='invisible'          ? 'selected':'' ?>>Invisible</option>
                </select>
            </td>
            <td><textarea name="description"><?= htmlspecialchars($user['description']) ?></textarea></td>
            <td><?= htmlspecialchars($user['role']) ?></td>
            <td><button type="submit">Save</button> <a href="admin.php">Cancel</a></td>
            </form>
        </tr>
        <?php else: ?>
        <tr>
            <td><?= htmlspecialchars($user['email'])       ?></td>
            <td><?= htmlspecialchars($user['name'])        ?></td>
            <td><?= htmlspecialchars($user['telephone'])   ?></td>
            <td><?= htmlspecialchars($user['website'])     ?></td>
            <td><?= htmlspecialchars($user['birthdate'])    ?></td>
            <td><?= htmlspecialchars($visStr)              ?></td>
            <td><?= htmlspecialchars($user['description']) ?></td>
            <td><?= htmlspecialchars($user['role'])        ?></td>
            <td>
                <a href="admin.php?edit=<?= urlencode($user['email']) ?>">
                    <button type="button">Modify</button>
                </a>
                <form method="post" action="admin.php" style="display:inline;"
                      onsubmit="return confirm('Delete <?= htmlspecialchars($user['name'], ENT_QUOTES) ?>?')">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="email"  value="<?= htmlspecialchars($user['email']) ?>">
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
        <?php endif; ?>
    <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>
</body>
</html>
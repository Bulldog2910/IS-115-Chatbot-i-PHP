
<h1>Users</h1>
<table>
    <tr class="tableHead">
        <th>Username:</th>
        <th>First Name:</th>
        <th>Last Name:</th>
        <th>Mail:</th>
        <th>Role:</th>
        <th>New password (optional):</th>
        <th>Action:</th>
    </tr>

<?php while ($row = $selectViews->resultChat->fetch_assoc()): ?>
    <tr>
        <form method="POST" action="<?= htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES, 'UTF-8') ?>">
            <td>
                <input type="text" name="username"
                       value="<?= htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8') ?>">
            </td>
            <td>
                <input type="text" name="firstName"
                       value="<?= htmlspecialchars($row['firstName'], ENT_QUOTES, 'UTF-8') ?>">
            </td>
            <td>
                <input type="text" name="lastName"
                       value="<?= htmlspecialchars($row['lastName'], ENT_QUOTES, 'UTF-8') ?>">
            </td>
            <td>
                <input type="email" name="mail"
                       value="<?= htmlspecialchars($row['mail'], ENT_QUOTES, 'UTF-8') ?>">
            </td>
            <td>
                <select name="role">
                    <option value="standard" <?= $row['role'] === 'standard' ? 'selected' : '' ?>>standard</option>
                    <option value="admin" <?= $row['role'] === 'admin' ? 'selected' : '' ?>>admin</option>
                </select>
            </td>
            <td>
                <input type="password" name="newPassword" placeholder="Leave blank to keep password">
            </td>
            <td>
                <input type="hidden" name="identificatorTable" value="user">
                <input type="hidden" name="identificatorId" value="<?= (int)$row['userId'] ?>">

                <button type="submit" name="identificatorAction" value="update">
                    Update
                </button>

                <button type="submit" name="identificatorAction" value="delete"
                        onclick="return confirm('Delete this user?');">
                    Delete
                </button>
            </td>
        </form>
    </tr>
<?php endwhile; ?>
</table>


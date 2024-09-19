<?php
// Przykładowa tablica użytkowników
$users = [
    ['id' => 1, 'first_name' => 'Jan', 'last_name' => 'Kowalski', 'role' => 'Admin', 'preferences' => 'Preferencja 1'],
    ['id' => 2, 'first_name' => 'Anna', 'last_name' => 'Nowak', 'role' => 'Pracownik', 'preferences' => 'Preferencja 2'],
    ['id' => 3, 'first_name' => 'Piotr', 'last_name' => 'Wiśniewski', 'role' => 'Pracownik', 'preferences' => 'Preferencja 3'],
    ['id' => 4, 'first_name' => 'Ewa', 'last_name' => 'Zielińska', 'role' => 'Admin', 'preferences' => 'Preferencja 4'],
    ['id' => 5, 'first_name' => 'Krzysztof', 'last_name' => 'Szymański', 'role' => 'Pracownik', 'preferences' => 'Preferencja 5'],
    ['id' => 6, 'first_name' => 'Maria', 'last_name' => 'Wójcik', 'role' => 'Admin', 'preferences' => 'Preferencja 6'],
    ['id' => 7, 'first_name' => 'Andrzej', 'last_name' => 'Dąbrowski', 'role' => 'Pracownik', 'preferences' => 'Preferencja 7'],
    ['id' => 8, 'first_name' => 'Jolanta', 'last_name' => 'Kaczmarek', 'role' => 'Pracownik', 'preferences' => 'Preferencja 8'],
    ['id' => 9, 'first_name' => 'Tomasz', 'last_name' => 'Bąk', 'role' => 'Admin', 'preferences' => 'Preferencja 9'],
    ['id' => 10, 'first_name' => 'Agnieszka', 'last_name' => 'Górska', 'role' => 'Pracownik', 'preferences' => 'Preferencja 10'],
    ['id' => 11, 'first_name' => 'Michał', 'last_name' => 'Jankowski', 'role' => 'Admin', 'preferences' => 'Preferencja 11'],
    ['id' => 12, 'first_name' => 'Karolina', 'last_name' => 'Pawlak', 'role' => 'Pracownik', 'preferences' => 'Preferencja 12'],
    ['id' => 13, 'first_name' => 'Jakub', 'last_name' => 'Sikora', 'role' => 'Pracownik', 'preferences' => 'Preferencja 13'],
    ['id' => 14, 'first_name' => 'Aleksandra', 'last_name' => 'Biel', 'role' => 'Admin', 'preferences' => 'Preferencja 14'],
    ['id' => 15, 'first_name' => 'Marcin', 'last_name' => 'Czarnecki', 'role' => 'Pracownik', 'preferences' => 'Preferencja 15'],
    ['id' => 16, 'first_name' => 'Elżbieta', 'last_name' => 'Borkowska', 'role' => 'Pracownik', 'preferences' => 'Preferencja 16'],
    ['id' => 17, 'first_name' => 'Kamil', 'last_name' => 'Michalak', 'role' => 'Admin', 'preferences' => 'Preferencja 17'],
    ['id' => 18, 'first_name' => 'Natalia', 'last_name' => 'Kołodziej', 'role' => 'Pracownik', 'preferences' => 'Preferencja 18'],
    ['id' => 19, 'first_name' => 'Łukasz', 'last_name' => 'Żak', 'role' => 'Admin', 'preferences' => 'Preferencja 19'],
    ['id' => 20, 'first_name' => 'Joanna', 'last_name' => 'Jóźwiak', 'role' => 'Pracownik', 'preferences' => 'Preferencja 20'],
];

// Pagination settings
$limit = 10;
$page = isset($_GET['site']) ? (int)$_GET['site'] : 1;
$start = ($page - 1) * $limit;

// Slice the array for pagination
$paginatedUsers = array_slice($users, $start, $limit);

// Calculate total pages
$total = count($users);
$totalPages = ceil($total / $limit);

// Function to build URLs with existing query parameters
function buildUrlWithParams($params)
{
    $currentUrl = $_SERVER['REQUEST_URI'];
    $query = parse_url($currentUrl, PHP_URL_QUERY);
    parse_str($query, $queryParams);
    $queryParams = array_merge($queryParams, $params);
    $newQuery = http_build_query($queryParams);
    return strtok($currentUrl, '?') . '?' . $newQuery;
}
?>

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>


<h1>Lista Użytkowników</h1>

<form method="GET" action="">
    <input type="text" name="search" value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>" placeholder="Szukaj...">
    <button type="submit">Szukaj</button>
</form>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Imię</th>
            <th>Nazwisko</th>
            <th>Opcje</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($paginatedUsers as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['id']); ?></td>
                <td><?php echo htmlspecialchars($user['first_name']); ?></td>
                <td><?php echo htmlspecialchars($user['last_name']); ?></td>
                <td>
                    <button onclick="openModal(<?php echo htmlspecialchars($user['id']); ?>)">Ustawienia</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="<?php echo buildUrlWithParams(['site' => $page - 1]); ?>">&laquo; Poprzednia</a>
    <?php endif; ?>
    <?php if ($page < $totalPages): ?>
        <a href="<?php echo buildUrlWithParams(['site' => $page + 1]); ?>">Następna &raquo;</a>
    <?php endif; ?>
</div>

<!-- Modal -->
<div id="userModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div id="modal-body"></div>
    </div>
</div>

<script>
    var users = <?php echo json_encode($users); ?>;

    function openModal(userId) {
        var modal = document.getElementById("userModal");
        var modalBody = document.getElementById("modal-body");
        var user = users.find(user => user.id === userId);

        if (user) {
            modalBody.innerHTML = `
                <h2>Ustawienia Użytkownika</h2>
                <p>ID: ${user.id}</p>
                <p>Imię: ${user.first_name}</p>
                <p>Nazwisko: ${user.last_name}</p>
                <p>Rola: ${user.role}</p>
                <p>Preferencje: ${user.preferences}</p>
            `;
        }
        modal.style.display = "block";
    }

    var modal = document.getElementById("userModal");
    var span = document.getElementsByClassName("close")[0];

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

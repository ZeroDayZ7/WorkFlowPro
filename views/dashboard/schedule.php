<style>
    body {
        font-family: Arial, sans-serif;
    }

    .calendar {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 10px;
        margin-top: 20px;
    }

    .day {
        border: 1px solid #ccc;
        padding: 2px;
        min-height: 100px;
        position: relative;
    }

    .day-number {
        position: absolute;
        top: 5px;
        left: 5px;
        font-weight: bold;
    }

    .employee {
        font-size: 14px;
        color: #333;
    }

    .employee-div-up {
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .navigation {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .navigation a {
        text-decoration: none;
        font-size: 18px;
        color: #007bff;
    }

    .navigation a:hover {
        text-decoration: underline;
    }

    /* Modal Style */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
        background-color: #fff;
        padding: 20px;
        border: 1px solid #888;
        width: 50%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        position: relative;
        transform: translate(-50%, -50%);
        top: 50%;
        left: 50%;
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
<?php
// Ustawienie domyślnych wartości (miesiąc, rok)
$month = isset($_GET['month']) ? (int)$_GET['month'] : date('m');
$year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');

// Funkcja generująca liczbę dni w miesiącu
function daysInMonth($month, $year)
{
    return cal_days_in_month(CAL_GREGORIAN, $month, $year);
}

// Przykładowe dane pracowników
$employees = [
    ['name' => 'Joe', 'shift' => '10:00-18:00', 'day' => 3, 'details' => 'Dodatkowe informacje o Joe'],
    ['name' => 'Anna', 'shift' => '09:00-17:00', 'day' => 10, 'details' => 'Anna specjalizuje się w projektach IT'],
    ['name' => 'Chris', 'shift' => '12:00-20:00', 'day' => 15, 'details' => 'Chris jest kierownikiem projektu'],
    ['name' => 'Jane', 'shift' => '08:00-16:00', 'day' => 22, 'details' => 'Jane zajmuje się analizą danych'],
    ['name' => 'Mike', 'shift' => '14:00-22:00', 'day' => 3, 'details' => 'Mike pracuje w dziale HR'],
    ['name' => 'Sarah', 'shift' => '06:00-14:00', 'day' => 5, 'details' => 'Sarah prowadzi zespół sprzedaży'],
];

// Obliczenie pierwszego dnia miesiąca
$firstDayOfMonth = date('N', strtotime("$year-$month-01"));
$daysInCurrentMonth = daysInMonth($month, $year);

// Obliczenie poprzedniego i następnego miesiąca
$prevMonth = $month - 1 > 0 ? $month - 1 : 12;
$nextMonth = $month + 1 < 13 ? $month + 1 : 1;
$prevYear = $month - 1 > 0 ? $year : $year - 1;
$nextYear = $month + 1 < 13 ? $year : $year + 1;

// Funkcja do generowania linków z zachowaniem istniejących parametrów
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


<h1>Kalendarz - <?php echo date('F Y', strtotime("$year-$month-01")); ?></h1>

<div class="navigation">
    <a href="<?php echo buildUrlWithParams(['month' => $prevMonth, 'year' => $prevYear]); ?>">&larr; Poprzedni miesiąc</a>
    <a href="<?php echo buildUrlWithParams(['month' => $nextMonth, 'year' => $nextYear]); ?>">Następny miesiąc &rarr;</a>
</div>

<div class="calendar">
    <?php
    // Wypełnianie pustymi polami przed pierwszym dniem miesiąca
    for ($i = 1; $i < $firstDayOfMonth; $i++) {
        echo '<div class="day"></div>';
    }

    // Wyświetlanie dni miesiąca z danymi pracowników
    for ($day = 1; $day <= $daysInCurrentMonth; $day++) {
        echo '<div class="day">';
        echo '<div class="day-number">' . $day . '</div>';

        // Wyświetlanie pracowników na dany dzień
        $hasEmployee = false; // Flaga, czy dany dzień ma pracowników
        echo '<div class="employee-div-up"><div class="employee-div">';
        foreach ($employees as $employee) {
            if ($employee['day'] == $day) {
                $hasEmployee = true;
                echo '<div class="employee">';
                echo $employee['name'] . '-' . $employee['shift'];
                echo '</div>';
            }
        }
        echo '</div>';

        // Jeśli są pracownicy w danym dniu, dodaj przycisk do modala
        if ($hasEmployee) {
            echo '
            <div class="panel-btn">
                <button onclick="openModal(' . $day . ')">Rozwiń</button>
                <button title="Edytuj">E</button>
                <button title="Usuń">U</button>
            </div>
            ';
        }

        echo '</div></div>';
    }
    ?>
</div>

<!-- Modal -->
<div id="employeeModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <div>Godziny pracy 08-20</div>
        <div id="modal-body"></div>
    </div>
</div>

<script>
    // Przykładowe dane do modala
    const employees = <?php echo json_encode($employees); ?>;

    // Funkcja otwierająca modal
    function openModal(day) {
        let modalBody = document.getElementById('modal-body');
        modalBody.innerHTML = ''; // Czyszczenie modala

        // Wyświetlanie danych pracowników na dany dzień
        employees.forEach(employee => {
            if (employee.day === day) {
                modalBody.innerHTML += `<h3>${employee.name}</h3><p>${employee.details}</p><p>Zmiana: ${employee.shift}</p><hr>`;
            }
        });

        document.getElementById('employeeModal').style.display = "block";
    }

    // Funkcja zamykająca modal
    function closeModal() {
        document.getElementById('employeeModal').style.display = "none";
    }

    // Zamknięcie modala, gdy kliknie się poza jego treść
    window.onclick = function(event) {
        if (event.target === document.getElementById('employeeModal')) {
            closeModal();
        }
    }
</script>
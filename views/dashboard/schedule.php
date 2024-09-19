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
            padding: 10px;
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
            margin-top: 20px;
            font-size: 14px;
            color: #333;
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
    </style>
<?php
// Ustawienie domyślnych wartości (miesiąc, rok)
$month = isset($_GET['month']) ? (int)$_GET['month'] : date('m');
$year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');

// Funkcja generująca liczbę dni w miesiącu
function daysInMonth($month, $year) {
    return cal_days_in_month(CAL_GREGORIAN, $month, $year);
}

// Przykładowe dane pracowników
$employees = [
    ['name' => 'Joe', 'shift' => '10:00-18:00', 'day' => 3],
    ['name' => 'Anna', 'shift' => '09:00-17:00', 'day' => 10],
    ['name' => 'Chris', 'shift' => '12:00-20:00', 'day' => 15],
    ['name' => 'Jane', 'shift' => '08:00-16:00', 'day' => 22],
];

// Obliczenie pierwszego dnia miesiąca
$firstDayOfMonth = date('N', strtotime("$year-$month-01"));
$daysInCurrentMonth = daysInMonth($month, $year);

// Obliczenie poprzedniego i następnego miesiąca
$prevMonth = $month - 1 > 0 ? $month - 1 : 12;
$nextMonth = $month + 1 < 13 ? $month + 1 : 1;
$prevYear = $month - 1 > 0 ? $year : $year - 1;
$nextYear = $month + 1 < 13 ? $year : $year + 1;

// Renderowanie kalendarza w HTML
?>

<h1>Kalendarz - <?php echo date('F Y', strtotime("$year-$month-01")); ?></h1>

<div class="navigation">
    <a href="?month=<?php echo $prevMonth; ?>&year=<?php echo $prevYear; ?>">&larr; Poprzedni miesiąc</a>
    <a href="?month=<?php echo $nextMonth; ?>&year=<?php echo $nextYear; ?>">Następny miesiąc &rarr;</a>
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
        foreach ($employees as $employee) {
            if ($employee['day'] == $day) {
                echo '<div class="employee">';
                echo $employee['name'] . '<br>';
                echo 'Zmiana: ' . $employee['shift'];
                echo '</div>';
            }
        }

        echo '</div>';
    }
    ?>
</div>
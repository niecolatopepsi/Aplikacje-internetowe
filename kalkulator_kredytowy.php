<?php

// Funkcja do obliczania miesięcznej raty kredytu
function obliczRate($kwota, $oprocentowanie, $okres) {
    $oprocentowanie_miesieczne = $oprocentowanie / 100 / 12;
    $mianownik = pow(1 + $oprocentowanie_miesieczne, $okres) - 1;
    $rata = ($kwota * $oprocentowanie_miesieczne * pow(1 + $oprocentowanie_miesieczne, $okres)) / $mianownik;
    return $rata;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pobranie danych z formularza
    $kwota = $_POST['kwota'];
    $oprocentowanie = $_POST['oprocentowanie'];
    $okres = $_POST['okres'];

    // Obliczenie miesięcznej raty
    $rata = obliczRate($kwota, $oprocentowanie, $okres);
    // Całkowita kwota do spłaty
    $calkowita_kwota = $rata * $okres;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Kalkulator kredytowy</title>
</head>
<body>

<h2>Kalkulator kredytowy</h2>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Kwota kredytu: <input type="text" name="kwota" value="<?php if(isset($kwota)) echo $kwota; ?>"><br><br>
    Oprocentowanie (w %): <input type="text" name="oprocentowanie" value="<?php if(isset($oprocentowanie)) echo $oprocentowanie; ?>"><br><br>
    Okres kredytowania (w latach): <input type="text" name="okres" value="<?php if(isset($okres)) echo $okres; ?>"><br><br>
    <input type="submit" name="submit" value="Oblicz">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Wyświetlenie wyników
    echo "<h3>Wyniki</h3>";
    echo "Miesięczna rata: " . round($rata, 2) . " PLN<br>";
    echo "Całkowita kwota do spłaty: " . round($calkowita_kwota, 2) . " PLN<br>";
}
?>

</body>
</html>
<?php
// Sprawdzamy, czy dane zostały przesłane metodą POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // ------------------------------------------------------------------
    // KONFIGURACJA (Zmień adres email poniżej na właściwy!)
    // ------------------------------------------------------------------
    $to = "kontakt@gabivet.pl"; // Tutaj wpisz adres mailowy gabinetu
    // ------------------------------------------------------------------

    // Zbieranie i czyszczenie danych z formularza
    $name = strip_tags(trim($_POST['name'] ?? ''));
    $tel = strip_tags(trim($_POST['tel'] ?? ''));
    $animal = strip_tags(trim($_POST['animal'] ?? ''));
    $service = strip_tags(trim($_POST['service'] ?? ''));
    $message = strip_tags(trim($_POST['message'] ?? ''));

    // Temat maila
    $subject = "Nowe zgłoszenie ze strony GabiVet od: $name";

    // Budowanie treści maila
    $body = "Otrzymano nową wiadomość z formularza na stronie gabivet.pl:\n\n";
    $body .= "==============================\n";
    $body .= "Imię i nazwisko: $name\n";
    $body .= "Telefon: $tel\n";
    $body .= "Zwierzę: $animal\n";
    $body .= "Cel wizyty: $service\n";
    $body .= "==============================\n\n";
    $body .= "Wiadomość / Opis:\n$message\n";

    // Ustawienie nagłówków (ważne dla serwerów Hostido)
    // Aby maile nie trafiały do SPAMu, adres "From" powinien być w domenie gabivet.pl
    $headers = "From: strona@gabivet.pl\r\n";
    $headers .= "Reply-To: no-reply@gabivet.pl\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Próba wysłania maila
    if(mail($to, $subject, $body, $headers)) {
        http_response_code(200);
        echo "Sukces";
    } else {
        http_response_code(500);
        echo "Błąd poczty";
    }
} else {
    // Odmowa dostępu, jeśli ktoś wejdzie bezpośrednio na send.php w przeglądarce
    http_response_code(403);
    echo "Brak dostępu";
}
?>
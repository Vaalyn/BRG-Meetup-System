# Brony Radio Germany - Meetup System

## Server

Der Web-Root muss auf das `public` Verzeichnis verweisen.

## Installation

1. Im `config` ordner die `config.example.php` duplizieren mit dem Namen `config.php` und die Werte eintragen
2. `composer install` ausführen
3. `./vendor/bin/phinx migrate -c config/phinx.php` ausführen

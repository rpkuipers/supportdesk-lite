# SupportDesk Lite

SupportDesk Lite is een klein Laravel leerproject waarin ik een IT-support/ticketingsysteem heb gebouwd. Het project is bedoeld om Laravel, PHP, Eloquent, migrations, seeders, Blade views, authenticatie en database-relaties beter te begrijpen.

## Functionaliteiten

- Handmatige registratie en login
- Tickets aanmaken, bekijken, bewerken en verwijderen
- Tickets koppelen aan klanten en categorieën
- Tickets koppelen aan gebruikers:
  - aangemaakt door
  - toegewezen aan
- Ticket oppakken vanaf het dashboard
- Ticketstatussen zoals open, in behandeling en opgelost
- Statusgeschiedenis per ticket
- Notities toevoegen aan tickets
- Interne notities
- Zoekfunctie op titel en referentie
- Optioneel zoeken in omschrijving
- Filters op status en prioriteit
- Database migrations en seeders

## Gebruikte technieken

- PHP
- Laravel
- MySQL/MariaDB
- Eloquent ORM
- Blade
- Laravel migrations
- Laravel seeders
- Laravel validation
- Laravel authentication via eigen controller
- Git

## Installatie

## Ontwikkelomgeving

Dit project is lokaal ontwikkeld en getest met Laragon op Windows, met PHP, Composer en MySQL/MariaDB. Andere lokale omgevingen zoals XAMPP, Docker of een losse MySQL-installatie zouden ook kunnen werken, zolang PHP, Composer en een database beschikbaar zijn.

### 1. Repository clonen

```bash
git clone https://github.com/rpkuipers/supportdesk-lite
cd supportdesk-lite
```

### 2. Dependencies installeren

```bash
composer install
```

### 3. Environment bestand aanmaken

Voor macOS/Linux/Git Bash:

```bash
cp .env.example .env
```

Voor Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

### 4. App key genereren

```bash
php artisan key:generate
```

### 5. Database aanmaken

Maak een MySQL/MariaDB database aan:

```sql
CREATE DATABASE supportdesk_lite CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Controleer daarna je database-instellingen in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=supportdesk_lite
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Migrations en seeders draaien

```bash
php artisan migrate --seed
```

### 7. Lokale server starten

```bash
php artisan serve
```

Open daarna:

```text
http://127.0.0.1:8000
```

## Doel

Leerdoel

Dit project is gebouwd als leerproject. Ik heb gekozen voor een ticketingsysteem, omdat ik dit ken vanuit op mijn achtergrond in IT-support en tegelijk veel webdevelopment-concepten bevat.

Tijdens het bouwen heb ik gebruikgemaakt van Laravel-documentatie, voorbeelden en externe uitleg. Ik heb niet alleen geprobeerd code werkend te krijgen, maar vooral geprobeerd te begrijpen wat elk onderdeel doet, zoals routes, controllers, services, Eloquent-relaties, migrations, enums, middleware, CSRF, Blade views en databasekoppelingen.

Opmerking

Dit project is geen productieapplicatie, maar een leerproject. Er zijn nog verbeteringen mogelijk, zoals uitgebreidere autorisatie, tests, betere UI-componenten en verdere validatie.

## Verdere leerdoelen en geplande uitbreidingen

Dit project is nog in ontwikkeling. De volgende onderdelen wil ik nog toevoegen of verder verbeteren om mijn Laravel- en backendkennis verder uit te breiden:

- Rollen en rechten toevoegen, bijvoorbeeld admin en supportmedewerker
- Laravel policies gebruiken om acties te beveiligen, zoals verwijderen, bewerken en categoriebeheer
- Een betere "Mijn tickets" pagina maken met aanvullende filters
- Klantenbeheer uitbreiden met volledige CRUD-functionaliteit
- Categoriebeheer verder afmaken en netter beveiligen
- Zoekfunctie uitbreiden met zoeken op klantnaam, assignee en creator
- Dashboard uitbreiden met meer statistieken, zoals tickets zonder assignee, verlopen SLA’s en recent opgeloste tickets
- Formuliervalidatie en foutmeldingen gebruiksvriendelijker maken
- Blade components maken voor herbruikbare onderdelen zoals knoppen, badges, formulieren en meldingen
- Tests toevoegen voor belangrijke flows, zoals login, ticket aanmaken, ticket oppakken, status wijzigen en notities toevoegen
- Code verder opschonen en consistentere naamgeving toepassens
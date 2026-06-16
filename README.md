# Strona Maciej Rudzin — instrukcja

Strona z treścią czytaną na żywo z folderu `content/`. Wrzucasz pliki na serwer →
pojawiają się na stronie automatycznie. Nie trzeba nic przebudowywać.

## Wymagania
- Hosting z obsługą **PHP** (dowolna wersja 7.4+ — ma ją praktycznie każdy hosting współdzielony).
- To wszystko. Bez bazy danych, bez konfiguracji.

## Co gdzie wgrać
Wgraj całą zawartość tego folderu do katalogu swojej strony na serwerze
(przez FTP, np. FileZilla, albo przez menedżer plików w panelu hostingu):

```
index.html              ← strona
api.php                 ← skrypt czytający foldery (nie ruszaj)
content/
  about.md              ← Twoje bio (edytuj ten plik)
  works/                ← wrzucaj tu zdjęcia/filmy do sekcji WORKS
  inspirations/         ← wrzucaj tu zdjęcia/filmy do sekcji Inspirations
  notes/                ← wrzucaj tu pliki .md lub .txt — każdy to jedna notatka
  wallpaper/            ← wrzuć tu zdjęcie — najnowsze staje się tapetą strony
  menu/
    file/ edit/ view/ go/ window/ help/   ← wiersze do rozwijanych menu (pliki .txt)
```

## Jak dodawać/edytować treści (bez niczyjej pomocy)
- **Nowa praca w WORKS / Inspirations** → wrzuć plik graficzny lub film
  (`.jpg .png .webp .gif .mp4 .webm` …) do `content/works/` lub `content/inspirations/`.
  Najnowsze pliki pokazują się na górze.
- **Bio (about_me.txt)** → otwórz `content/about.md` i edytuj.
  Możesz używać Markdown: `# nagłówek`, `**pogrubienie**`, `[link](https://…)`, obrazki.
- **Notatki** → dodaj plik `.md` lub `.txt` do `content/notes/`.
  Nazwa pliku staje się tytułem notatki (np. `wystawa-2026.md` → „Wystawa 2026").
- **Tapeta** → wrzuć obraz (`.jpg .png .webp`) do `content/wallpaper/`. Najnowszy plik
  staje się tłem pulpitu. Bez pliku strona pokazuje wbudowaną scenę kosmiczną.
- **Wiersze w menu (File, Edit, View, Go, Window, Help)** → każdy plik `.txt`
  w `content/menu/<nazwa menu>/` to jedna pozycja rozwijanego menu.
  Nazwa pliku = tytuł wiersza. Kolejność ustawiasz prefiksami `01 `, `02 `…
  Pliki zaczynające się od `_` są pomijane. Kliknięcie tytułu otwiera wiersz w okienku.
- Żeby coś usunąć — po prostu skasuj plik z folderu.

## Ustawienia do podmiany w index.html
- Link do Instagrama: znajdź `https://instagram.com/twoj_profil` i wstaw swój profil.
- `kot.jpg` na pulpicie to placeholder (ładuje losowego kota z internetu) — możesz zmienić lub usunąć ten wpis.

## Podgląd lokalnie (opcjonalnie)
- Samo otwarcie `index.html` z dysku pokaże stronę, ale sekcje WORKS/Notes/About
  będą puste/placeholder, bo nie ma serwera PHP.
- Z PHP: w tym folderze uruchom `php -S localhost:8000` i wejdź na `http://localhost:8000`.

## Bezpieczeństwo
`api.php` pozwala czytać tylko foldery `works`, `inspirations`, `notes`, `wallpaper`, `menu/...` i plik `about.md`
— nie ma dostępu do innych miejsc na serwerze.

# Postawienie strony za darmo na GitHub Pages

Ta wersja działa na GitHub Pages bez PHP. Po każdej zmianie automat (GitHub Action)
skanuje folder `content/` i buduje `content/manifest.json`, z którego strona czyta treści.
Adres będzie darmowy: `https://TWOJANAZWA.github.io/NAZWA-REPO/`.

(Ten sam komplet plików działa też na hostingu z PHP — strona sama wykrywa, gdzie stoi.)

## Krok po kroku (wszystko klikasz na stronie github.com)

1. **Załóż konto** na https://github.com (jeśli nie masz).

2. **Utwórz repozytorium**: przycisk „New" (zielony) → nazwa np. `portfolio`
   → zaznacz **Public** → „Create repository".
   (Jeśli chcesz adres bez podkatalogu — `https://TWOJANAZWA.github.io/` — nazwij repo
   dokładnie `TWOJANAZWA.github.io`.)

3. **Wgraj pliki strony**: na stronie repozytorium kliknij „Add file" → „Upload files".
   Przeciągnij zawartość folderu `site`: `index.html`, `api.php`, `build_manifest.py`,
   `README.md` oraz cały folder `content`. Na dole kliknij „Commit changes".
   (Folder `.github` jest ukryty — dodasz go w następnym kroku.)

4. **Dodaj automat (workflow)**: kliknij „Add file" → „Create new file".
   W polu nazwy wpisz dokładnie:
   ```
   .github/workflows/deploy.yml
   ```
   (ukośniki same utworzą foldery). W pole treści wklej zawartość pliku
   `deploy.yml` (jest w paczce, w `site/.github/workflows/deploy.yml`),
   a następnie „Commit changes".

5. **Włącz GitHub Pages**: Settings (w repo) → w menu po lewej „Pages” →
   sekcja „Build and deployment” → **Source: „GitHub Actions”**.

6. **Gotowe.** Wejdź w zakładkę „Actions” — zobaczysz, jak strona się buduje
   (~1 minuta). Po zakończeniu adres strony pojawi się w „Settings → Pages”
   (i przy zielonym znaczku w Actions). To Twój publiczny adres.

## Jak dodawać/zmieniać treści (bez mojej pomocy)

Wszystko robisz na stronie repozytorium na github.com:

- **Zdjęcia/filmy do WORKS lub Inspirations** → wejdź w `content/works`
  (lub `content/inspirations`) → „Add file” → „Upload files” → przeciągnij pliki →
  „Commit changes”.
- **Bio (about)** → wejdź w `content/about.md` → ikona ołówka (Edit) → popraw tekst →
  „Commit changes”.
- **Notatki** → dodaj plik `.txt` lub `.md` do `content/notes/`.
- **Wiersze w menu** (File, Edit, View, Go, Window, Help) → dodaj plik `.txt`
  do `content/menu/<nazwa>/`. Nazwa pliku = tytuł w menu.
  Prefiks `01 `, `02 `… ustawia kolejność i nie jest pokazywany w tytule.
- **Tapeta** → wgraj obraz do `content/wallpaper/`. Trzymaj tam jeden plik
  (na GitHubie aktywny jest ostatni alfabetycznie — najprościej mieć jeden).

Po każdym „Commit changes” automat przebudowuje stronę i po ~minucie zmiana jest widoczna
(odśwież stronę). To jedyna różnica względem hostingu z PHP, gdzie zmiana jest natychmiastowa.

## Uwagi
- Repozytorium na darmowym planie jest **publiczne** — pliki (w tym zdjęcia) są dostępne
  publicznie. Dla portfolio zwykle nie jest to problem (i tak mają być widoczne).
- Plik `api.php` na GitHubie nie jest uruchamiany (leży nieużywany) — zostaje tylko po to,
  żeby ten sam komplet działał też na hostingu z PHP, gdyby kiedyś przenosić.
- Własną domenę (np. `.pl`) możesz podpiąć później w „Settings → Pages → Custom domain”.

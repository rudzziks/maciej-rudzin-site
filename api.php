<?php
/*
 * api.php — prosty backend czytający folder content/.
 * Nie wymaga bazy danych ani konfiguracji. Działa na każdym hostingu z PHP.
 *
 *   api.php?action=gallery&dir=works         -> lista zdjęć/filmów (JSON)
 *   api.php?action=gallery&dir=inspirations  -> jw.
 *   api.php?action=notes                     -> lista notatek (JSON)
 *   api.php?action=about                     -> treść about.md (tekst)
 */

header('Cache-Control: no-store');

$BASE = __DIR__ . '/content';
$IMG  = ['jpg','jpeg','png','gif','webp','avif','svg'];
$VID  = ['mp4','webm','mov','m4v'];
// foldery galerii, do których wolno zaglądać (zabezpieczenie przed path traversal)
$GALLERIES = ['works', 'inspirations'];

$action = $_GET['action'] ?? '';

function send_json($data) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

if ($action === 'gallery') {
    $dir = $_GET['dir'] ?? '';
    if (!in_array($dir, $GALLERIES, true)) send_json(['files' => []]);
    $path = "$BASE/$dir";
    $files = [];
    if (is_dir($path)) {
        foreach (scandir($path) as $f) {
            if ($f[0] === '.') continue;
            $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));
            $type = in_array($ext, $IMG) ? 'image' : (in_array($ext, $VID) ? 'video' : null);
            if (!$type) continue;
            $files[] = ['name' => $f, 'url' => "content/$dir/" . rawurlencode($f), 'type' => $type, 'mtime' => filemtime("$path/$f")];
        }
    }
    // najnowsze pliki na górze
    usort($files, fn($a, $b) => $b['mtime'] <=> $a['mtime']);
    foreach ($files as &$x) unset($x['mtime']);
    send_json(['files' => $files]);
}

if ($action === 'notes') {
    $path = "$BASE/notes";
    $notes = [];
    if (is_dir($path)) {
        foreach (scandir($path) as $f) {
            if ($f[0] === '.') continue;
            $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));
            if (!in_array($ext, ['md', 'txt'])) continue;
            $title = pathinfo($f, PATHINFO_FILENAME);
            $title = preg_replace('/^\d+[\s._-]+/', '', $title);
            $title = ucfirst(str_replace(['_', '-'], ' ', $title));
            $notes[] = ['title' => $title, 'content' => file_get_contents("$path/$f"), 'mtime' => filemtime("$path/$f")];
        }
    }
    usort($notes, fn($a, $b) => $b['mtime'] <=> $a['mtime']);
    foreach ($notes as &$x) unset($x['mtime']);
    send_json(['notes' => $notes]);
}

if ($action === 'menu') {
    $MENUS = ['file', 'edit', 'view', 'go', 'window', 'help'];
    $dir = $_GET['dir'] ?? '';
    if (!in_array($dir, $MENUS, true)) send_json(['poems' => []]);
    $path = "$BASE/menu/$dir";
    $poems = [];
    if (is_dir($path)) {
        foreach (scandir($path) as $f) {
            if ($f[0] === '.' || $f[0] === '_') continue;
            $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));
            if (!in_array($ext, ['txt', 'md'])) continue;
            $title = pathinfo($f, PATHINFO_FILENAME);
            $title = preg_replace('/^\d+[\s._-]+/', '', $title);
            $title = str_replace(['_', '-'], ' ', $title);
            $poems[] = ['title' => $title, 'body' => file_get_contents("$path/$f"), 'name' => $f];
        }
    }
    // alphabetical by file name → you control order with names like "01 ...", "02 ..."
    usort($poems, fn($a, $b) => strnatcasecmp($a['name'], $b['name']));
    foreach ($poems as &$x) unset($x['name']);
    send_json(['poems' => $poems]);
}

if ($action === 'wallpaper') {
    $path = "$BASE/wallpaper";
    $best = null; $bestT = 0;
    if (is_dir($path)) {
        foreach (scandir($path) as $f) {
            if ($f[0] === '.') continue;
            $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));
            if (!in_array($ext, $IMG)) continue;
            $t = filemtime("$path/$f");
            if ($t > $bestT) { $bestT = $t; $best = $f; }
        }
    }
    send_json(['url' => $best ? "content/wallpaper/" . rawurlencode($best) : null]);
}

if ($action === 'about') {
    header('Content-Type: text/plain; charset=utf-8');
    foreach (['about.md', 'about.txt'] as $name) {
        if (is_file("$BASE/$name")) { echo file_get_contents("$BASE/$name"); exit; }
    }
    echo "# About Me\n\n[Tu wpisz swoje bio — edytuj plik content/about.md]";
    exit;
}

http_response_code(400);
send_json(['error' => 'unknown action']);

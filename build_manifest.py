#!/usr/bin/env python3
"""
Skanuje folder content/ i zapisuje content/manifest.json.
Uruchamiane automatycznie przez GitHub Action przy każdej zmianie.
Nie wymaga żadnych dodatkowych bibliotek.
"""
import os, json, urllib.parse, re

BASE = "content"
IMG = {"jpg", "jpeg", "png", "gif", "webp", "avif", "svg"}
VID = {"mp4", "webm", "mov", "m4v"}
GALLERIES = ["works", "inspirations"]
MENUS = ["file", "edit", "view", "go", "window", "help"]


def ext(name):
    return name.rsplit(".", 1)[-1].lower() if "." in name else ""


def listing(folder):
    """Pliki w folderze, pomijając ukryte i zaczynające się od _, posortowane po nazwie."""
    path = os.path.join(BASE, folder)
    if not os.path.isdir(path):
        return []
    files = [f for f in os.listdir(path) if f[:1] not in (".", "_")]
    return sorted(files, key=str.lower)


def url_for(*parts):
    return "/".join([BASE] + [urllib.parse.quote(p) for p in parts])


def title_from(filename):
    stem = filename.rsplit(".", 1)[0]
    stem = re.sub(r"^\d+[\s._-]+", "", stem)  # drop ordering prefix like "01 "
    return stem.replace("_", " ").replace("-", " ").strip()


def read(folder, name):
    with open(os.path.join(BASE, folder, name), "r", encoding="utf-8", errors="replace") as fh:
        return fh.read()


manifest = {"galleries": {}, "notes": [], "about": "", "menu": {}, "wallpaper": None}

# galleries
for g in GALLERIES:
    items = []
    for f in listing(g):
        e = ext(f)
        t = "image" if e in IMG else ("video" if e in VID else None)
        if not t:
            continue
        items.append({"name": f, "url": url_for(g, f), "type": t})
    manifest["galleries"][g] = items

# notes
for f in listing("notes"):
    if ext(f) in ("md", "txt"):
        manifest["notes"].append({"title": title_from(f), "content": read("notes", f)})

# about
for name in ("about.md", "about.txt"):
    p = os.path.join(BASE, name)
    if os.path.isfile(p):
        with open(p, "r", encoding="utf-8", errors="replace") as fh:
            manifest["about"] = fh.read()
        break

# menu poems
for m in MENUS:
    poems = []
    for f in listing(os.path.join("menu", m)):
        if ext(f) in ("md", "txt"):
            poems.append({"title": title_from(f), "body": read(os.path.join("menu", m), f)})
    manifest["menu"][m] = poems

# wallpaper: alphabetically last image (name it 'z-...' or keep one file to control it)
wall = [f for f in listing("wallpaper") if ext(f) in IMG]
if wall:
    manifest["wallpaper"] = url_for("wallpaper", wall[-1])

with open(os.path.join(BASE, "manifest.json"), "w", encoding="utf-8") as fh:
    json.dump(manifest, fh, ensure_ascii=False, separators=(",", ":"))

print("manifest.json written:",
      {k: (len(v) if isinstance(v, (list, dict)) else v) for k, v in manifest.items()})

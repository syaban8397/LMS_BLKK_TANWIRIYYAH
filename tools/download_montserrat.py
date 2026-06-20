import urllib.request
from pathlib import Path

out = Path(r"D:/PROJECT-KP/lms_blkk/storage/fonts/certificates")
out.mkdir(parents=True, exist_ok=True)
base = "https://github.com/google/fonts/raw/main/ofl/montserrat/static"
files = [
    "Montserrat-Black.ttf",
    "Montserrat-Bold.ttf",
    "Montserrat-Regular.ttf",
    "Montserrat-Italic.ttf",
    "Montserrat-BoldItalic.ttf",
]
for name in files:
    url = f"{base}/{name}"
    dest = out / name
    print(f"Downloading {name}...")
    urllib.request.urlretrieve(url, dest)
    print(f"  -> {dest.stat().st_size} bytes")

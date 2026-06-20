"""Restore / sync Logo.png from bundled YMT CreatorBase asset."""
from pathlib import Path
from shutil import copy2

ROOT = Path(__file__).resolve().parents[1]
OUT_DIR = ROOT / "storage" / "app" / "public" / "images"
YMT = ROOT / "public" / "images" / "certificates" / "logo-ymt-creatorbase.png"

OUT_DIR.mkdir(parents=True, exist_ok=True)
copy2(YMT, OUT_DIR / "Logo.png")
print(f"Restored {OUT_DIR / 'Logo.png'} from YMT CreatorBase")

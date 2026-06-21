"""Analyze page-2 table lines in reference vs generated PDF."""
import sys
import fitz
from pathlib import Path

PT = 25.4 / 72.0
REF = Path(r"C:/Users/Sya'ban/Downloads/RAIHAN TAUVIQUL HADY IFDAL.pdf")
GEN = Path(sys.argv[1]) if len(sys.argv) > 1 else Path(__file__).resolve().parents[1] / "storage/app/test-cert-peserta1.pdf"


def page2_lines(path: Path, label: str) -> None:
    doc = fitz.open(path)
    page = doc[1]
    print(f"\n=== {label} ({path.name}) PAGE 2 ===")

    drawings = page.get_drawings()
    horiz = []
    vert = []
    for d in drawings:
        for item in d.get("items", []):
            kind = item[0]
            if kind == "l":
                p1, p2 = item[1], item[2]
                if abs(p1.y - p2.y) < 0.5:
                    horiz.append((min(p1.x, p2.x) * PT, max(p1.x, p2.x) * PT, p1.y * PT))
                elif abs(p1.x - p2.x) < 0.5:
                    vert.append((p1.x * PT, min(p1.y, p2.y) * PT, max(p1.y, p2.y) * PT))

    print(f"  full horizontal lines: {len([h for h in horiz if h[1]-h[0] > 200])}")
    for x0, x1, y in sorted(horiz, key=lambda t: t[2]):
        if x1 - x0 > 200:
            print(f"    y={y:6.2f} x={x0:6.2f}-{x1:6.2f}")

    print(f"  full vertical lines: {len([v for v in vert if v[2]-v[1] > 100])}")
    for x, y0, y1 in sorted(vert, key=lambda t: t[0]):
        if y1 - y0 > 100:
            print(f"    x={x:6.2f} y={y0:6.2f}-{y1:6.2f}")

    doc.close()


page2_lines(REF, "REF")
page2_lines(GEN, "GEN")

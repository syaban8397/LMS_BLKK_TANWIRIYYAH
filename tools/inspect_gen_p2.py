import fitz
from pathlib import Path

PT = 25.4 / 72
root = Path(__file__).resolve().parents[1] / "storage/app"
files = ["test-cert-raihan.pdf", "test-cert-peserta1.pdf"]
for name in files:
    p = root / name
    doc = fitz.open(p)
    page = doc[1]
    print(f"=== {name} ===")
    rects = 0
    for d in page.get_drawings():
        for item in d.get("items", []):
            if item[0] == "re":
                rects += 1
                r = item[1]
                w = (r.x1 - r.x0) * PT
                h = (r.y1 - r.y0) * PT
                if w > 50 or h > 50:
                    print(
                        f"  rect x={r.x0*PT:.1f} y={r.y0*PT:.1f} "
                        f"w={w:.1f} h={h:.1f}"
                    )
    print(f"  small rects total: {rects}")
    for block in page.get_text("dict")["blocks"]:
        if block.get("type") != 0:
            continue
        for line in block["lines"]:
            t = "".join(s["text"] for s in line["spans"]).strip()
            if t:
                print(f"  text y={line['bbox'][1]*PT:.2f} x={line['bbox'][0]*PT:.2f} | {t[:50]}")
    doc.close()

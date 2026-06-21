import fitz
from pathlib import Path

PT = 25.4 / 72
REF = Path(r"C:/Users/Sya'ban/Downloads/RAIHAN TAUVIQUL HADY IFDAL.pdf")
GEN = Path(__file__).resolve().parents[1] / "storage/app/test-cert-raihan.pdf"


def imgs(path):
    doc = fitz.open(path)
    page = doc[0]
    out = []
    for block in page.get_text("dict")["blocks"]:
        if block.get("type") == 1:
            b = block["bbox"]
            out.append((b[0] * PT, b[1] * PT, (b[2] - b[0]) * PT, (b[3] - b[1]) * PT))
    doc.close()
    return sorted(out, key=lambda i: (round(i[1], 1), round(i[0], 1)))


ref = imgs(REF)
gen = imgs(GEN)
print("REF layers:", len(ref), "GEN layers:", len(gen))
for i, g in enumerate(gen):
    if i == 0:
        print(f"GEN[{i}] bg {g[2]:.0f}x{g[3]:.0f}mm")
        continue
    label = "?"
    if 100 < g[0] < 110 and 45 < g[1] < 50:
        label = "name"
    elif 80 < g[0] < 90 and 75 < g[1] < 82:
        label = "prog1"
    elif 120 < g[0] < 130 and 85 < g[1] < 92:
        label = "prog2"
    elif 120 < g[0] < 125 and 118 < g[1] < 125:
        label = "degree"
    print(f"GEN[{i}] {label:6} x={g[0]:6.2f} y={g[1]:6.2f} w={g[2]:5.1f} h={g[3]:4.1f}")

print("\nREF text anchors:")
doc = fitz.open(REF)
for block in doc[0].get_text("dict")["blocks"]:
    if block.get("type") != 0:
        continue
    for line in block["lines"]:
        t = "".join(s["text"] for s in line["spans"]).strip()
        if t.startswith("RAIHAN") or t.startswith("Telah") or t.startswith("Skema") or t.startswith("C.DM"):
            b = line["bbox"]
            print(f"  {t[:40]:40} x={b[0]*PT:.2f} y={b[1]*PT:.2f}")
doc.close()

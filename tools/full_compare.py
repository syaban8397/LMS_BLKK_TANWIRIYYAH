"""Full REF vs GEN comparison for certificate page 1."""
import fitz
from pathlib import Path

PT = 25.4 / 72.0
REF = Path(r"C:/Users/Sya'ban/Downloads/RAIHAN TAUVIQUL HADY IFDAL.pdf")
GEN = Path(r"D:/PROJECT-KP/lms_blkk/storage/app/test-cert-peserta1.pdf")


def analyze(path):
    doc = fitz.open(path)
    page = doc[0]
    lines = []
    imgs = []
    for block in page.get_text("dict")["blocks"]:
        if block.get("type") == 0:
            for line in block["lines"]:
                txt = "".join(s["text"] for s in line["spans"]).strip()
                if not txt:
                    continue
                b = line["bbox"]
                spans = line["spans"]
                lines.append({
                    "y": b[1] * PT, "x": b[0] * PT, "x1": b[2] * PT, "y1": b[3] * PT,
                    "w": (b[2] - b[0]) * PT, "h": (b[3] - b[1]) * PT,
                    "cx": (b[0] + b[2]) / 2 * PT,
                    "sz": spans[0]["size"], "font": spans[0].get("font", ""),
                    "color": spans[0].get("color", 0), "flags": spans[0].get("flags", 0),
                    "t": txt,
                })
        elif block.get("type") == 1:
            b = block["bbox"]
            imgs.append({
                "x0": b[0] * PT, "y0": b[1] * PT,
                "x1": b[2] * PT, "y1": b[3] * PT,
                "w": (b[2] - b[0]) * PT, "h": (b[3] - b[1]) * PT,
            })
    doc.close()
    return lines, imgs


def match_line(ref_lines, gen_lines, ref_idx):
    """Match REF line to closest GEN line by y position and text prefix."""
    r = ref_lines[ref_idx]
    best = None
    best_score = 999
    for g in gen_lines:
        dy = abs(g["y"] - r["y"])
        # same first word bonus
        rw = r["t"].split()[0][:8].lower() if r["t"] else ""
        gw = g["t"].split()[0][:8].lower() if g["t"] else ""
        word_pen = 0 if rw == gw or rw in g["t"].lower() or gw in r["t"].lower() else 20
        score = dy + word_pen
        if score < best_score:
            best_score = score
            best = g
    return r, best


ref_lines, ref_imgs = analyze(REF)
gen_lines, gen_imgs = analyze(GEN)

ref_lines.sort(key=lambda l: (l["y"], l["x"]))
gen_lines.sort(key=lambda l: (l["y"], l["x"]))

print("=== LINE-BY-LINE MATCH (sorted by y) ===")
print(f"{'REF y':>7} {'GEN y':>7} {'dY':>6} {'dX':>6} {'REF sz':>7} {'GEN sz':>7} | REF text")
print("-" * 100)
for r in ref_lines:
    if r["y"] < 30:
        continue
    _, g = match_line(ref_lines, gen_lines, ref_lines.index(r))
    if g is None:
        print(f"{r['y']:7.2f}   MISS   | {r['t'][:65]}")
        continue
    dy = g["y"] - r["y"]
    dx = g["x"] - r["x"]
    if abs(dy) > 2 or abs(dx) > 2 or abs(g["sz"] - r["sz"]) > 2:
        flag = " ***"
    else:
        flag = ""
    print(f"{r['y']:7.2f} {g['y']:7.2f} {dy:+6.2f} {dx:+6.2f} {r['sz']:7.1f} {g['sz']:7.1f} | {r['t'][:55]}{flag}")

print("\n=== GEN EXTRA LINES (no REF match within 3mm y) ===")
for g in gen_lines:
    if g["y"] < 30:
        continue
    close = any(abs(g["y"] - r["y"]) < 3 and g["t"][:10] in r["t"][:20] or r["t"][:10] in g["t"][:20] for r in ref_lines if r["y"] > 30)
    if not close:
        print(f"  y={g['y']:6.2f} x={g['x']:6.2f} sz={g['sz']:.1f} | {g['t'][:60]}")

print("\n=== IMAGES ===")
print("REF:")
for i, im in enumerate(sorted(ref_imgs, key=lambda x: (x["y0"], x["x0"]))):
    print(f"  {i}: x0={im['x0']:.2f} y0={im['y0']:.2f} w={im['w']:.2f} h={im['h']:.2f}")
print("GEN:")
for i, im in enumerate(sorted(gen_imgs, key=lambda x: (x["y0"], x["x0"]))):
    print(f"  {i}: x0={im['x0']:.2f} y0={im['y0']:.2f} w={im['w']:.2f} h={im['h']:.2f}")

print("\n=== REF FONTS USED ===")
fonts = set(l["font"] for l in ref_lines)
for f in sorted(fonts):
    print(f"  {f}")

print("\n=== REF FONT SIZES ===")
sizes = {}
for l in ref_lines:
    key = l["t"][:40]
    sizes.setdefault(round(l["sz"], 1), []).append(key)
for sz in sorted(sizes):
    print(f"  sz={sz:.1f}: {sizes[sz][0][:50]}")

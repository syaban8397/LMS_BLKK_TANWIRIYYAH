"""Compare only dynamic overlay fields: GEN vs REF."""
import fitz
from pathlib import Path

PT = 25.4 / 72.0
REF = Path(r"C:/Users/Sya'ban/Downloads/RAIHAN TAUVIQUL HADY IFDAL.pdf")
GEN = Path(r"D:/PROJECT-KP/lms_blkk/storage/app/test-cert-peserta1.pdf")

PAIRS = [
    ("name", lambda t: t.isupper() and len(t.split()) <= 5 and "TELAH" not in t),
    ("program L1", lambda t: t.startswith("Telah Berpartisipasi") or t.startswith("Telah berpartisipasi")),
    ("program L2", lambda t: "Tahun" in t and "Skema" not in t and "berlaku" not in t.lower()),
    ("degree", lambda t: t.startswith("C.")),
    ("validity ID", lambda t: t.startswith("Sertifikat ini berlaku")),
    ("validity EN", lambda t: t.startswith("This Certificate is valid")),
    ("cert number", lambda t: "-" in t and "Issued" not in t and "YMTCB" in t),
    ("issued date", lambda t: t.startswith("Issued Date:")),
]


def lines(path):
    doc = fitz.open(path)
    out = []
    for block in doc[0].get_text("dict")["blocks"]:
        if block.get("type") != 0:
            continue
        for line in block["lines"]:
            t = "".join(s["text"] for s in line["spans"]).strip()
            if not t:
                continue
            b = line["bbox"]
            sp = line["spans"][0]
            out.append(
                {
                    "y": b[1] * PT,
                    "x": b[0] * PT,
                    "x1": b[2] * PT,
                    "sz": sp["size"],
                    "t": t,
                }
            )
    doc.close()
    return out


def pick(lines, pred):
    for line in lines:
        if pred(line["t"]):
            return line
    return None


ref = lines(REF)
gen = lines(GEN)

print(f"{'Field':<14} {'REF y':>7} {'GEN y':>7} {'dY':>6} {'REF x':>7} {'GEN x':>7} {'dX':>6} {'REF sz':>7} {'GEN sz':>7}")
print("-" * 90)
for label, pred in PAIRS:
    r = pick(ref, pred)
    g = pick(gen, pred)
    if not r or not g:
        print(f"{label:<14} MISSING  r={bool(r)} g={bool(g)}")
        continue
    print(
        f"{label:<14} {r['y']:7.2f} {g['y']:7.2f} {g['y']-r['y']:+6.2f} "
        f"{r['x']:7.2f} {g['x']:7.2f} {g['x']-r['x']:+6.2f} "
        f"{r['sz']:7.1f} {g['sz']:7.1f}"
    )

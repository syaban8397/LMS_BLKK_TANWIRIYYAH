"""Compare reference vs generated certificate PDF layout."""
import sys
from pathlib import Path

import fitz

ROOT = Path(__file__).resolve().parents[1]
REF = Path(r"C:\Users\Sya'ban\Downloads\RAIHAN TAUVIQUL HADY IFDAL.pdf")
GEN = Path(r"C:\Users\Sya'ban\Downloads\PESERTA 2.pdf")
PT = 25.4 / 72.0


def mm(v):
    return v * PT


def extract_page(page):
    texts, imgs = [], []
    for block in page.get_text("dict")["blocks"]:
        if block.get("type") == 0:
            for line in block["lines"]:
                y0 = mm(line["bbox"][1])
                x0 = mm(line["bbox"][0])
                txt = "".join(s["text"] for s in line["spans"]).strip()
                if txt:
                    sz = line["spans"][0]["size"]
                    texts.append({"y": y0, "x": x0, "sz": sz, "t": txt})
        elif block.get("type") == 1:
            b = block["bbox"]
            imgs.append(
                {
                    "y0": mm(b[1]),
                    "y1": mm(b[3]),
                    "x0": mm(b[0]),
                    "x1": mm(b[2]),
                }
            )
    return texts, imgs


def match_key(t):
    s = t[:40].lower()
    for k in [
        "sertifikat ini menerangkan",
        "this certificate explains",
        "yang diselenggarakan",
        "kementerian ketenagakerjaan",
        "telah berpartisipasi",
        "skema ",
        "organized by",
        "serta berhak",
        "as well as the rights",
        "certified digital marketing",
        "sertifikat ini berlaku",
        "this certificate is valid",
        "diverifikasi",
        "zaid ahmad",
        "direktur ymt",
        "certified number",
        "issued date",
        "no",
        "materi pelatihan",
        "kode unit",
    ]:
        if k in s:
            return k
    if t.strip().isdigit() and len(t.strip()) <= 2:
        return f"rowno:{t.strip()}"
    return s[:25]


def compare_texts(ref_texts, gen_texts, page_label):
    print(f"\n=== {page_label} TEXT DELTA (gen - ref) ===")
    ref_map = {}
    for t in ref_texts:
        k = match_key(t["t"])
        if k not in ref_map:
            ref_map[k] = t

    used = set()
    for gt in gen_texts:
        k = match_key(gt["t"])
        rt = ref_map.get(k)
        if rt is None:
            # try name match uppercase
            continue
        used.add(k)
        dy = gt["y"] - rt["y"]
        dx = gt["x"] - rt["x"]
        ds = gt["sz"] - rt["sz"]
        flag = " ***" if abs(dy) > 1.5 or abs(dx) > 3 or abs(ds) > 1 else ""
        print(
            f"y {dy:+5.1f} x {dx:+5.1f} sz {ds:+4.1f} | {gt['t'][:65]}{flag}"
        )

    for k, rt in ref_map.items():
        if k not in used and page_label.startswith("PAGE 1"):
            print(f"MISSING in gen: {rt['t'][:65]}")


def main():
    gen_path = Path(sys.argv[1]) if len(sys.argv) > 1 else GEN
    for label, path in [("REF", REF), ("GEN", gen_path)]:
        if not path.exists():
            print(f"MISSING: {path}")
            sys.exit(1)

    ref_doc = fitz.open(REF)
    gen_doc = fitz.open(gen_path)

    for pi in range(min(2, ref_doc.page_count, gen_doc.page_count)):
        rt, ri = extract_page(ref_doc[pi])
        gt, gi = extract_page(gen_doc[pi])
        compare_texts(rt, gt, f"PAGE {pi + 1}")
        print(f"\n=== PAGE {pi + 1} IMAGES ===")
        print("REF:", ri[:8])
        print("GEN:", gi[:8])

    ref_doc.close()
    gen_doc.close()


if __name__ == "__main__":
    main()

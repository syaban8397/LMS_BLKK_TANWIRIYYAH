import fitz
PT = 25.4 / 72
doc = fitz.open(r"C:/Users/Sya'ban/Downloads/RAIHAN TAUVIQUL HADY IFDAL.pdf")
page = doc[0]
rows = []
for block in page.get_text("dict")["blocks"]:
    if block.get("type") != 0:
        continue
    for line in block["lines"]:
        txt = "".join(s["text"] for s in line["spans"]).strip()
        if not txt:
            continue
        b = line["bbox"]
        s0 = line["spans"][0]
        rows.append({
            "y": round(b[1] * PT, 1),
            "x": round(b[0] * PT, 1),
            "sz": round(s0["size"], 1),
            "font": s0.get("font", ""),
            "flags": s0.get("flags", 0),
            "t": txt[:60],
        })
rows.sort(key=lambda r: (r["y"], r["x"]))
for r in rows:
    if r["y"] >= 30:
        print(f"y={r['y']:6.1f} x={r['x']:6.1f} sz={r['sz']:4.1f} {r['font'][:22]:22} | {r['t']}")
doc.close()

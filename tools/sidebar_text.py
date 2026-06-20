import fitz
PT = 25.4 / 72
doc = fitz.open(r"C:/Users/Sya'ban/Downloads/RAIHAN TAUVIQUL HADY IFDAL.pdf")
page = doc[0]
for block in page.get_text("dict")["blocks"]:
    if block.get("type") != 0:
        continue
    for line in block["lines"]:
        t = "".join(s["text"] for s in line["spans"]).strip()
        if t in ("SERTIFIKAT", "CERTIFICATE OF TRAINING", "Indonesia", "Skills"):
            b = line["bbox"]
            print(t, "bbox", [round(x * PT, 2) for x in b], "size", line["spans"][0]["size"])
doc.close()

doc = fitz.open(r"C:/Users/Sya'ban/Downloads/PESERTA 1.pdf")
page = doc[0]
print("\nPESERTA 1 sidebar/logo text:")
for block in page.get_text("dict")["blocks"]:
    if block.get("type") != 0:
        continue
    for line in block["lines"]:
        t = "".join(s["text"] for s in line["spans"]).strip()
        b = line["bbox"]
        x = b[0] * PT
        if x < 55 or (200 < x < 220 and b[1] * PT < 25):
            print(t, [round(x * PT, 2) for x in b])
doc.close()

import fitz
PT = 25.4 / 72
doc = fitz.open(r"D:/PROJECT-KP/lms_blkk/storage/app/test-cert-peserta1.pdf")
page = doc[0]
print("ALL GEN TEXT:")
for block in page.get_text("dict")["blocks"]:
    if block.get("type") != 0:
        continue
    for line in block["lines"]:
        txt = "".join(s["text"] for s in line["spans"]).strip()
        if not txt:
            continue
        b = line["bbox"]
        print(f"y={b[1]*PT:6.2f} x={b[0]*PT:6.2f} sz={line['spans'][0]['size']:.1f} | {txt}")
doc.close()

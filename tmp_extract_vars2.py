import zipfile
import re
import os

templates_dir = r'c:\laragon\www\SistemaBancario\CrediAgil\Templates'

all_vars = set()
per_template = {}

for fname in sorted(os.listdir(templates_dir)):
    if not fname.endswith('.docx'):
        continue
    path = os.path.join(templates_dir, fname)
    full_xml = ""
    with zipfile.ZipFile(path, 'r') as docx:
        for name in docx.namelist():
            if name.startswith('word/') and name.endswith('.xml'):
                full_xml += docx.read(name).decode('utf-8', errors='ignore')
    
    # Extract ${...} style variables - reassemble split w:t content
    # First strip XML tags to get plain text
    plain = re.sub(r'<[^>]+>', ' ', full_xml)
    plain = re.sub(r'\s+', ' ', plain)
    
    vars_found = re.findall(r'\$\{\s*([A-Z_0-9]+(?:\s+[A-Z_0-9]+)*)\s*\}', plain)
    vars_found = [v.strip().replace(' ', '_') for v in vars_found]
    vars_found = list(dict.fromkeys(vars_found))  # deduplicate preserving order
    
    per_template[fname] = vars_found
    all_vars.update(vars_found)

print("=== PER TEMPLATE ===")
for fname, vars_ in per_template.items():
    print(f"\n{fname}:")
    for v in vars_:
        print(f"  - {v}")

print("\n=== ALL UNIQUE VARS ===")
for v in sorted(all_vars):
    print(v)

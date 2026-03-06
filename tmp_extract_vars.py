import zipfile
import re
import json
import os

templates_dir = r'c:\laragon\www\SistemaBancario\CrediAgil\Templates'

def extract_vars(docx_path):
    with zipfile.ZipFile(docx_path, 'r') as docx:
        for name in docx.namelist():
            if name.startswith('word/') and name.endswith('.xml'):
                content = docx.read(name).decode('utf-8', errors='ignore')
                yield content

all_templates = {}
for fname in os.listdir(templates_dir):
    if fname.endswith('.docx'):
        path = os.path.join(templates_dir, fname)
        all_text = ""
        for xml_content in extract_vars(path):
            all_text += xml_content
        # Extract ${VAR} or ${ VAR } patterns
        vars_ = re.findall(r'\$\{\s*([A-Z0-9_]+(?:\s+[A-Z0-9_]+)?)\s*\}', all_text)
        vars_ = list(dict.fromkeys([v.strip().replace(' ', '_') for v in vars_]))
        all_templates[fname] = vars_
        print(f"\n=== {fname} ===")
        for v in vars_:
            print(f"  ${{{v}}}")

print("\n=== ALL UNIQUE VARS ===")
all_vars = set()
for k, v in all_templates.items():
    all_vars.update(v)
for v in sorted(all_vars):
    print(v)

# Save JSON for reference
with open(r'c:\laragon\www\SistemaBancario\tmp_vars.json', 'w') as f:
    json.dump(all_templates, f, indent=2)
print("\nSaved to tmp_vars.json")

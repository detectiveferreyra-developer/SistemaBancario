"""
patch3_nuevo_cliente.py
Line-based targeted replacements for nuevo-cliente.php.
This script addresses specific line ranges to insert/replace form fields.
"""

src = r'c:\laragon\www\SistemaBancario\CrediAgil\vista\Administradores\nuevo-cliente.php'

# Use latin-1 to read and write to preserve original accents and bytes without crashing
with open(src, 'r', encoding='latin-1') as f:
    lines = f.readlines()

def replace_lines(lines, start, end, new_content):
    """Replace lines[start-1 : end] (1-indexed inclusive) with new_content (list of strings)."""
    before = lines[:start-1]
    after  = lines[end:]
    return before + new_content + after

print(f"Starting lines: {len(lines)}")

# Note: Patches 1 and 2 were already applied in the previous run.
# Let's search for Joyas block to find its dynamic position for Patch 3.
content = ''.join(lines)
joyas_marker = '<!-- Campos para Prenda JOYAS -->'
j_pos = content.find(joyas_marker)

if j_pos != -1:
    j_line_start = content.count('\n', 0, j_pos) + 1
    # Find the end of campos_joyas div
    closing_div_pos = content.find('</div>', j_pos)
    # Actually, we need to find the matching closing div for the whole block.
    # It contains 3 internal <div class="row">...
    # Let's just do a reliable string replacement for Patch 3, 4, 5 instead of strict lines
    # since we have the full content string.

# ─────────────────────────────────────────
# PATCH 3: Replace Joyas block — add kilates + estado, keep peso + descripcion
# ─────────────────────────────────────────
old_joyas = """                                        <!-- Campos para Prenda JOYAS -->
                                        <div id="campos_joyas" style="display: none;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="required-field">Material / Ley</label>
                                                        <input type="text" class="form-control" id="joyas_material_ley"
                                                            name="joyas_material_ley" placeholder="Ej: Oro 18k">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="required-field">Valorizaci&#243;n (S/.)</label>
                                                        <input type="number" class="form-control" id="joyas_valorizacion"
                                                            name="joyas_valorizacion" placeholder="Ej: 5000" step="0.01">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="required-field">Peso Bruto (gramos)</label>
                                                        <input type="number" class="form-control" id="joyas_peso_bruto"
                                                            name="joyas_peso_bruto" placeholder="Ej: 25.5" step="0.01">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="required-field">Peso Neto (gramos)</label>
                                                        <input type="number" class="form-control" id="joyas_peso_neto"
                                                            name="joyas_peso_neto" placeholder="Ej: 24.0" step="0.01">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="required-field">Descripci&#243;n Detallada</label>
                                                        <textarea class="form-control" id="joyas_descripcion"
                                                            name="joyas_descripcion" rows="3"
                                                            placeholder="Ej: Anillo de oro 18k con diamante central de 0.5ct y 6 diamantes laterales"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>"""

new_joyas = """                                        <!-- Campos para Prenda JOYAS -->
                                        <div id="campos_joyas" style="display: none;">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="required-field">Quilates (Ley)</label>
                                                        <input type="text" class="form-control" id="joya_kilates" name="joya_kilates" placeholder="Ej: 18k, 24k">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="required-field">Peso Bruto (gramos)</label>
                                                        <input type="number" class="form-control" id="joyas_peso_bruto" name="joyas_peso_bruto" placeholder="Ej: 25.5" step="0.01">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="required-field">Peso Neto (gramos)</label>
                                                        <input type="number" class="form-control" id="joyas_peso_neto" name="joyas_peso_neto" placeholder="Ej: 24.0" step="0.01">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="required-field">Estado de la Joya</label>
                                                        <select class="form-control" id="joya_estado" name="joya_estado">
                                                            <option value="">Seleccione...</option>
                                                            <option value="NUEVO">Nuevo</option>
                                                            <option value="BUENO">Buen estado</option>
                                                            <option value="REGULAR">Regular</option>
                                                            <option value="CON_DESGASTE">Con desgaste</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Valorizaci&#243;n Referencial (S/)</label>
                                                        <input type="number" class="form-control" id="joyas_valorizacion" name="joyas_valorizacion" placeholder="Ej: 5000" step="0.01">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="required-field">Descripci&#243;n Detallada</label>
                                                        <textarea class="form-control" id="joyas_descripcion" name="joyas_descripcion" rows="3" placeholder="Ej: Anillo de oro 18k con diamante central de 0.5ct"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>"""

# Try matching with exact spaces or simple string replacement ignoring varied spaces
import re
def normalize_spaces(text):
    return re.sub(r'\s+', ' ', text)

content_norm = normalize_spaces(content)
old_joyas_norm = normalize_spaces(old_joyas)
# Since the exact exact text might be slightly different due to encoding we recorded, let's use regex to find limits
match = re.search(r'<!-- Campos para Prenda JOYAS -->.*?id="campos_joyas".*?id="joyas_descripcion".*?</div>\s*</div>\s*</div>\s*</div>', content, re.DOTALL)
if match:
    content = content[:match.start()] + new_joyas + content[match.end():]
    print("PATCH 3 done")
else:
    print("PATCH 3 SKIP: regex didn't match")

# ─────────────────────────────────────────
# PATCH 4: Add ELECTRO extra fields (color, fabric, descripcion) BEFORE closing div
# ─────────────────────────────────────────
match_electro = re.search(r'id="electro_accesorios".*?</textarea>\s*</div>\s*</div>\s*</div>', content, re.DOTALL)
if match_electro:
    new_electro_extras = """                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Color</label>
                                                        <input type="text" class="form-control" id="electro_color" name="electro_color" placeholder="Ej: Negro, Plateado">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Fabricante / A&#241;o</label>
                                                        <input type="text" class="form-control" id="electro_fabric" name="electro_fabric" placeholder="Ej: Samsung / 2022">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Descripci&#243;n / Estado</label>
                                                        <textarea class="form-control" id="electro_descripcion" name="electro_descripcion" rows="2" placeholder="Ej: Equipo en buen estado de funcionamiento."></textarea>
                                                    </div>
                                                </div>
                                            </div>"""
    content = content[:match_electro.end()] + '\n' + new_electro_extras + content[match_electro.end():]
    print("PATCH 4 done")
else:
    print("PATCH 4 SKIP")

# ─────────────────────────────────────────
# PATCH 5: Step 3 — replace fixed "plazo" field with editable + add monto_tasacion
# ─────────────────────────────────────────
match_plazo = re.search(r'<div class="row">\s*<div class="col-md-6">\s*<div class="form-group">\s*<label class="required-field">Monto del Pr&#233;stamo \(S/\)</label>.*?<small class="form-text text-muted">Plazo fijo del sistema</small>\s*</div>\s*</div>\s*</div>', content, re.DOTALL)

if match_plazo:
    new_plazo = """                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="required-field">Monto del Pr&#233;stamo (S/)</label>
                                                    <input type="number" class="form-control" id="monto_prestamo" name="monto_prestamo" placeholder="Ej: 10000" step="0.01" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="required-field">Plazo (d&#237;as)</label>
                                                    <input type="number" class="form-control" id="plazo_dias" name="plazo_dias" value="30" min="1" max="365" required>
                                                    <small class="form-text text-muted">D&#237;as calendario</small>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="required-field">Valor Tasaci&#243;n (S/)</label>
                                                    <input type="number" class="form-control" id="monto_tasacion" name="monto_tasacion" placeholder="Ej: 15000" step="0.01" required>
                                                    <small class="form-text text-muted">Valor del bien garantizado</small>
                                                </div>
                                            </div>
                                        </div>"""
    content = content[:match_plazo.start()] + new_plazo + content[match_plazo.end():]
    print("PATCH 5 done")
else:
    print("PATCH 5 SKIP")

# ─────────────────────────────────────────
# PATCH 6: Remove the duplicate garante block
# ─────────────────────────────────────────
g1 = content.find('<!-- Garante Mobiliario (Opcional) -->')
if g1 != -1:
    g2 = content.find('<!-- Garante Mobiliario (Opcional) -->', g1 + 10)
    if g2 != -1:
        # found duplicate! Find end (before <div class="step-content" data-step="4"> )
        g_end = content.find('<div class="step-content" data-step="4">', g2)
        if g_end != -1:
            content = content[:g2] + content[g_end:]
            print("PATCH 6 done: duplicate removed")

# ─────────────────────────────────────────
# PATCH 7: Fix the submit handler to use AJAX
# ─────────────────────────────────────────
match_submit = re.search(r'// Por ahora solo mostrar alerta.*?alert\(.*?\);', content, re.DOTALL)
if match_submit:
    new_submit = """// Enviar datos al generador de contratos v&#237;a AJAX
                    const formData = new FormData(this);
                    const $btn = $('#btn_submit');
                    const originalHtml = $btn.html();
                    $btn.html('<i class="fa fa-spinner fa-spin mr-2"></i> Generando...').prop('disabled', true);

                    $.ajax({
                        url: '../controlador/cGenerarContrato.php',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            $btn.html(originalHtml).prop('disabled', false);
                            try {
                                const res = typeof response === 'string' ? JSON.parse(response) : response;
                                if (res.status === 'ok') {
                                    fillContratoModal(res.preview, res.docx_filename);
                                    $('#contratoModal').modal('show');
                                } else {
                                    alert('Error: ' + (res.message || 'Error al generar el contrato.'));
                                }
                            } catch(ex) {
                                alert('Error al procesar la respuesta del servidor.');
                                console.error(ex);
                            }
                        },
                        error: function(xhr) {
                            $btn.html(originalHtml).prop('disabled', false);
                            alert('Error de conexion: ' + xhr.status + ' ' + xhr.statusText);
                        }
                    });"""
    content = content[:match_submit.start()] + new_submit + content[match_submit.end():]
    print("PATCH 7 done")
else:
    print("PATCH 7 SKIP (might be already applied)")

# ─────────────────────────────────────────
# PATCH 8: Add fillContratoModal function
# ─────────────────────────────────────────
if 'fillContratoModal' not in content:
    match_closing = re.search(r'\s*}\);\s*</script>', content)
    if match_closing:
        new_closing = """            });

            // === FUNCIONES DEL MODAL DE CONTRATO ===
            function fillContratoModal(preview, docxFile) {
                const p = preview || {};
                $('#modal_num_contrato').html('N&#176; ' + (p.num_contrato || ''));
                $('#preview_num_contrato').html(p.num_contrato || '');
                $('#preview_fecha_ciudad').html((p.ciudad || 'Lima') + ', ' + (p.fecha || ''));
                $('#modal_tipo_contrato').html('CONTRATO DE GARANT&#205;A MOBILIARIA | ' + (p.tipo_contrato || '').toUpperCase());
                $('#preview_bien_title').html((p.tipo_contrato || 'Bien en Garant&#237;a'));

                const c = p.cliente || {};
                let clienteHtml = rowPrev('Nombre', c.nombre || '') + rowPrev('DNI / RUC', c.id || '') + rowPrev('Direcci&#243;n', c.direccion || '') + rowPrev('Tipolog&#237;a', p.tipo_personeria || '');
                $('#preview_cliente_rows').html(clienteHtml);

                const b = p.bien || {};
                let bienHtml = '';
                for (const [key, val] of Object.entries(b)) {
                    if (!val) continue;
                    const lbl = key.replace(/_/g, ' ').replace(/\\b\\w/g, c => c.toUpperCase());
                    bienHtml += rowPrev(lbl, val);
                }
                $('#preview_bien_rows').html(bienHtml || '<em class="text-muted">Sin datos del bien</em>');

                const g = p.garante || {};
                if (g.nombre) {
                    $('#preview_garante_rows').html(rowPrev('Nombre', g.nombre) + (g.dni ? rowPrev('DNI', g.dni) : '') + (g.domicilio ? rowPrev('Domicilio', g.domicilio) : ''));
                    $('#preview_garante_section').show();
                } else {
                    $('#preview_garante_section').hide();
                }

                const pr = p.prestamo || {};
                let prestamoHtml = rowPrev('Monto Pr&#233;stamo', pr.monto || '') + rowPrev('En letras', (pr.letras_prestamo || '') + ' Y 00/100 SOLES') + rowPrev('Valor de Tasaci&#243;n', pr.tasacion || '') + rowPrev('Plazo', pr.plazo || '') + rowPrev('Comisi&#243;n', pr.comision || '');
                $('#preview_prestamo_rows').html(prestamoHtml);
                $('#preview_total_highlight').text(pr.total || 'S/ 0.00');

                const printData = encodeURIComponent(JSON.stringify(p));
                $('#btn_imprimir').attr('href', '../vista/Administradores/contrato-preview-print.php?data=' + printData);
            }

            function rowPrev(label, value) {
                return '<div style="display:flex;justify-content:space-between;padding:5px 0;border-bottom:1px solid #e0e0e0;font-size:0.88rem;"><span style="color:#555;font-weight:600;width:40%;">' + label + '</span><span style="color:#222;width:58%;text-align:right;">' + value + '</span></div>';
            }

            $('#btn_modificar').on('click', function() {
                $('#contratoModal').modal('hide');
            });

        </script>"""
        content = content[:match_closing.start()] + new_closing + content[match_closing.end():]
        print("PATCH 8 done")

# ─────────────────────────────────────────
# PATCH 9: Add the preview modal HTML before the footer
# ─────────────────────────────────────────
if 'contratoModal' not in content:
    footer_pos = content.find('<div class="footer">')
    if footer_pos != -1:
        modal_html = """<!-- MODAL PREVIEW CONTRATO -->
<div class="modal fade" id="contratoModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content" style="border:none;border-radius:12px;overflow:hidden;">
            <div class="modal-header" style="background:linear-gradient(135deg,#184897,#1a6bc7);color:#fff;border:none;padding:1.5rem 2rem;">
                <div>
                    <h5 class="modal-title" style="font-weight:700;margin:0;">&#10003; Contrato Generado</h5>
                    <div style="font-size:0.85rem;opacity:0.85;margin-top:4px;" id="modal_num_contrato">N&#176; &mdash;</div>
                </div>
                <button type="button" class="close" data-dismiss="modal" style="color:#fff;opacity:1;">&times;</button>
            </div>
            <div class="modal-body p-0">
                <div style="background:#e8f5e9;border-bottom:1px solid #c8e6c9;padding:12px 2rem;display:flex;align-items:center;gap:10px;">
                    <span style="font-size:1.4rem;color:#388e3c;">&#10004;</span>
                    <div><strong style="color:#388e3c;">Contrato completado con los datos ingresados.</strong>
                        <div style="font-size:0.85rem;color:#555;">Revise antes de imprimir. Use "Modificar" si hay errores.</div>
                    </div>
                </div>
                <div style="padding:2rem;">
                    <div style="text-align:center;border-bottom:3px solid #184897;padding-bottom:14px;margin-bottom:18px;">
                        <div style="font-size:1.05rem;font-weight:800;color:#184897;">INVERSIONES CREDI&#193;GIL DEL PER&#218; E.I.R.L.</div>
                        <div style="font-size:0.8rem;color:#777;">RUC 20601767920 | +51 998 277 396</div>
                        <div style="margin-top:10px;font-size:1rem;font-weight:700;color:#333;" id="modal_tipo_contrato">CONTRATO DE GARANT&#205;A MOBILIARIA</div>
                        <div style="font-size:0.9rem;color:#555;margin-top:4px;">
                            N&#176; <span id="preview_num_contrato" style="font-weight:700;color:#184897;">&mdash;</span>
                            &nbsp;|&nbsp;<span id="preview_fecha_ciudad">Lima, &mdash;</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div style="background:#f8f9fa;border-radius:8px;padding:1.2rem;margin-bottom:1rem;">
                                <div style="font-weight:700;color:#184897;font-size:0.85rem;text-transform:uppercase;border-bottom:2px solid #184897;padding-bottom:6px;margin-bottom:10px;">Datos del Cliente</div>
                                <div id="preview_cliente_rows"></div>
                            </div>
                            <div id="preview_garante_section" style="background:#fff3e0;border-radius:8px;padding:1.2rem;margin-bottom:1rem;display:none;">
                                <div style="font-weight:700;color:#F5812A;font-size:0.85rem;text-transform:uppercase;border-bottom:2px solid #F5812A;padding-bottom:6px;margin-bottom:10px;">Garante</div>
                                <div id="preview_garante_rows"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div style="background:#f8f9fa;border-radius:8px;padding:1.2rem;margin-bottom:1rem;">
                                <div style="font-weight:700;color:#184897;font-size:0.85rem;text-transform:uppercase;border-bottom:2px solid #184897;padding-bottom:6px;margin-bottom:10px;" id="preview_bien_title">Bien en Garant&#237;a</div>
                                <div id="preview_bien_rows"></div>
                            </div>
                            <div style="background:#f8f9fa;border-radius:8px;padding:1.2rem;">
                                <div style="font-weight:700;color:#184897;font-size:0.85rem;text-transform:uppercase;border-bottom:2px solid #184897;padding-bottom:6px;margin-bottom:10px;">Condiciones del Pr&#233;stamo</div>
                                <div id="preview_prestamo_rows"></div>
                                <div style="background:#184897;color:#fff;border-radius:6px;padding:10px 14px;margin-top:10px;display:flex;justify-content:space-between;align-items:center;">
                                    <span style="font-weight:700;">TOTAL A DEVOLVER</span>
                                    <span id="preview_total_highlight" style="font-size:1.2rem;font-weight:800;">S/ 0.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background:#f8f9fa;border-top:1px solid #e0e0e0;padding:1rem 2rem;display:flex;justify-content:space-between;">
                <button type="button" id="btn_modificar" class="btn btn-outline-secondary" style="font-weight:600;">Modificar</button>
                <a id="btn_imprimir" href="#" target="_blank" class="btn" style="background:#F5812A;color:#fff;font-weight:700;padding:0.7rem 1.8rem;border-radius:6px;text-decoration:none;">
                    Imprimir Contrato
                </a>
            </div>
        </div>
    </div>
</div>

"""
        content = content[:footer_pos] + modal_html + content[footer_pos:]
        print("PATCH 9 done")

# Write back in latin-1 so it matches what we read and doesn't get messed up when PHP includes it
with open(src, 'w', encoding='latin-1', errors='replace') as f:
    f.write(content)

print(f"\nAll patches applied. Final length: {len(content)}")

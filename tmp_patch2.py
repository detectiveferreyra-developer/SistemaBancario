"""
patch2_nuevo_cliente.py
Line-based targeted replacements for nuevo-cliente.php.
This script addresses specific line ranges to insert/replace form fields.
"""

src = r'c:\laragon\www\SistemaBancario\CrediAgil\vista\Administradores\nuevo-cliente.php'

with open(src, 'r', encoding='latin-1') as f:
    lines = f.readlines()

def replace_lines(lines, start, end, new_content):
    """Replace lines[start-1 : end] (1-indexed inclusive) with new_content (list of strings)."""
    before = lines[:start-1]
    after  = lines[end:]
    return before + new_content + after

# ─────────────────────────────────────────
# PATCH 1: Replace old domicilio section + conyuge (lines 361-428)
# with: domicilio (direccion+distrito+provincia+departamento) + conyuge with full address
# ─────────────────────────────────────────
new_block_1 = [
    '                                            <!-- Domicilio del Cliente -->\r\n',
    '                                            <div class="row">\r\n',
    '                                                <div class="col-12">\r\n',
    '                                                    <h6 class="mt-3 mb-3" style="color: #6c757d; font-weight: 600;">Domicilio del Cliente</h6>\r\n',
    '                                                </div>\r\n',
    '                                            </div>\r\n',
    '                                            <div class="row">\r\n',
    '                                                <div class="col-md-12">\r\n',
    '                                                    <div class="form-group">\r\n',
    '                                                        <label class="required-field">Direcci&#243;n Completa</label>\r\n',
    '                                                        <input type="text" class="form-control" id="direccion_cliente" name="direccion_cliente" placeholder="Ej: Av. Los Pinos 123, Urb. Las Flores">\r\n',
    '                                                    </div>\r\n',
    '                                                </div>\r\n',
    '                                            </div>\r\n',
    '                                            <div class="row">\r\n',
    '                                                <div class="col-md-4">\r\n',
    '                                                    <div class="form-group">\r\n',
    '                                                        <label class="required-field">Distrito</label>\r\n',
    '                                                        <input type="text" class="form-control" id="distrito_cliente" name="distrito_cliente" placeholder="Ej: Miraflores">\r\n',
    '                                                    </div>\r\n',
    '                                                </div>\r\n',
    '                                                <div class="col-md-4">\r\n',
    '                                                    <div class="form-group">\r\n',
    '                                                        <label class="required-field">Provincia</label>\r\n',
    '                                                        <input type="text" class="form-control" id="provincia_cliente" name="provincia_cliente" placeholder="Ej: Lima">\r\n',
    '                                                    </div>\r\n',
    '                                                </div>\r\n',
    '                                                <div class="col-md-4">\r\n',
    '                                                    <div class="form-group">\r\n',
    '                                                        <label class="required-field">Departamento</label>\r\n',
    '                                                        <input type="text" class="form-control" id="departamento_cliente" name="departamento_cliente" placeholder="Ej: Lima">\r\n',
    '                                                    </div>\r\n',
    '                                                </div>\r\n',
    '                                            </div>\r\n',
    '\r\n',
    '                                            <!-- C&#243;nyuge del Cliente (Opcional) -->\r\n',
    '                                            <div class="row">\r\n',
    '                                                <div class="col-12">\r\n',
    '                                                    <h6 class="mt-3 mb-3" style="color: #6c757d; font-weight: 600;">\r\n',
    '                                                        Datos del C&#243;nyuge <small class="text-muted">(Opcional)</small>\r\n',
    '                                                    </h6>\r\n',
    '                                                </div>\r\n',
    '                                            </div>\r\n',
    '                                            <div class="row">\r\n',
    '                                                <div class="col-md-6">\r\n',
    '                                                    <div class="form-group">\r\n',
    '                                                        <label>Nombre del C&#243;nyuge</label>\r\n',
    '                                                        <input type="text" class="form-control" id="nombre_conyuge" name="nombre_conyuge" placeholder="Ej: Mar&#237;a Elena Garc&#237;a">\r\n',
    '                                                    </div>\r\n',
    '                                                </div>\r\n',
    '                                                <div class="col-md-6">\r\n',
    '                                                    <div class="form-group">\r\n',
    '                                                        <label>DNI del C&#243;nyuge</label>\r\n',
    '                                                        <input type="text" class="form-control" id="dni_conyuge" name="dni_conyuge" placeholder="Ej: 98765432" maxlength="8">\r\n',
    '                                                    </div>\r\n',
    '                                                </div>\r\n',
    '                                            </div>\r\n',
    '                                            <div class="row">\r\n',
    '                                                <div class="col-md-12">\r\n',
    '                                                    <div class="form-group">\r\n',
    '                                                        <label>Direcci&#243;n del C&#243;nyuge</label>\r\n',
    '                                                        <input type="text" class="form-control" id="direccion_conyuge" name="direccion_conyuge" placeholder="Ej: Av. Principal 456 (si es diferente)">\r\n',
    '                                                    </div>\r\n',
    '                                                </div>\r\n',
    '                                            </div>\r\n',
    '                                            <div class="row">\r\n',
    '                                                <div class="col-md-4">\r\n',
    '                                                    <div class="form-group">\r\n',
    '                                                        <label>Distrito del C&#243;nyuge</label>\r\n',
    '                                                        <input type="text" class="form-control" id="distrito_conyuge" name="distrito_conyuge" placeholder="Ej: San Isidro">\r\n',
    '                                                    </div>\r\n',
    '                                                </div>\r\n',
    '                                                <div class="col-md-4">\r\n',
    '                                                    <div class="form-group">\r\n',
    '                                                        <label>Provincia del C&#243;nyuge</label>\r\n',
    '                                                        <input type="text" class="form-control" id="provincia_conyuge" name="provincia_conyuge" placeholder="Ej: Lima">\r\n',
    '                                                    </div>\r\n',
    '                                                </div>\r\n',
    '                                                <div class="col-md-4">\r\n',
    '                                                    <div class="form-group">\r\n',
    '                                                        <label>Departamento del C&#243;nyuge</label>\r\n',
    '                                                        <input type="text" class="form-control" id="departamento_conyuge" name="departamento_conyuge" placeholder="Ej: Lima">\r\n',
    '                                                    </div>\r\n',
    '                                                </div>\r\n',
    '                                            </div>\r\n',
    '                                        </div>\r\n',
]
lines = replace_lines(lines, 361, 428, new_block_1)
print(f"PATCH 1 done. Lines now: {len(lines)}")

# Recalculate line positions after patch 1 shift
# Original lines 430-484 (empresa block) is now shifted by (len(new_block_1) - 68) lines
shift1 = len(new_block_1) - 68  # 68 = original 428-361+1
print(f"Shift after patch 1: {shift1}")

# ─────────────────────────────────────────
# PATCH 2: Replace Empresa block — add rep legal address + registral fields
# Original lines 430-484 → now at 430+shift1 to 484+shift1
# ─────────────────────────────────────────
s = shift1
e_start = 430 + s
e_end   = 484 + s

new_block_2 = [
    '                                        <!-- Campos para Empresa -->\r\n',
    '                                        <div id="campos_empresa" style="display: none;">\r\n',
    '                                            <div class="row">\r\n',
    '                                                <div class="col-md-6">\r\n',
    '                                                    <div class="form-group">\r\n',
    '                                                        <label class="required-field">Raz&#243;n Social</label>\r\n',
    '                                                        <input type="text" class="form-control" id="razon_social" name="razon_social" placeholder="Ej: Inversiones ABC E.I.R.L.">\r\n',
    '                                                    </div>\r\n',
    '                                                </div>\r\n',
    '                                                <div class="col-md-6">\r\n',
    '                                                    <div class="form-group">\r\n',
    '                                                        <label class="required-field">RUC</label>\r\n',
    '                                                        <input type="text" class="form-control" id="ruc" name="ruc" placeholder="Ej: 20601767920" maxlength="11">\r\n',
    '                                                    </div>\r\n',
    '                                                </div>\r\n',
    '                                            </div>\r\n',
    '                                            <div class="row">\r\n',
    '                                                <div class="col-md-12">\r\n',
    '                                                    <div class="form-group">\r\n',
    '                                                        <label class="required-field">Domicilio Fiscal</label>\r\n',
    '                                                        <input type="text" class="form-control" id="domicilio_fiscal" name="domicilio_fiscal" placeholder="Ej: Jr. Las Ale&#241;as 200, Lima">\r\n',
    '                                                    </div>\r\n',
    '                                                </div>\r\n',
    '                                            </div>\r\n',
    '                                            <div class="row"><div class="col-12"><h6 class="mt-3 mb-2" style="color:#6c757d;font-weight:600;">Representante Legal</h6></div></div>\r\n',
    '                                            <div class="row">\r\n',
    '                                                <div class="col-md-6">\r\n',
    '                                                    <div class="form-group">\r\n',
    '                                                        <label class="required-field">Nombre del Representante Legal</label>\r\n',
    '                                                        <input type="text" class="form-control" id="representante_legal" name="representante_legal" placeholder="Ej: Carlos Mart&#237;nez">\r\n',
    '                                                    </div>\r\n',
    '                                                </div>\r\n',
    '                                                <div class="col-md-6">\r\n',
    '                                                    <div class="form-group">\r\n',
    '                                                        <label class="required-field">DNI del Representante</label>\r\n',
    '                                                        <input type="text" class="form-control" id="dni_representante" name="dni_representante" placeholder="Ej: 12345678" maxlength="8">\r\n',
    '                                                    </div>\r\n',
    '                                                </div>\r\n',
    '                                            </div>\r\n',
    '                                            <div class="row">\r\n',
    '                                                <div class="col-md-12">\r\n',
    '                                                    <div class="form-group">\r\n',
    '                                                        <label class="required-field">Direcci&#243;n del Representante Legal</label>\r\n',
    '                                                        <input type="text" class="form-control" id="direccion_rep_legal" name="direccion_rep_legal" placeholder="Ej: Av. Los Pinos 123">\r\n',
    '                                                    </div>\r\n',
    '                                                </div>\r\n',
    '                                            </div>\r\n',
    '                                            <div class="row">\r\n',
    '                                                <div class="col-md-4">\r\n',
    '                                                    <div class="form-group">\r\n',
    '                                                        <label class="required-field">Distrito Rep. Legal</label>\r\n',
    '                                                        <input type="text" class="form-control" id="distrito_rep_legal" name="distrito_rep_legal" placeholder="Ej: La Victoria">\r\n',
    '                                                    </div>\r\n',
    '                                                </div>\r\n',
    '                                                <div class="col-md-4">\r\n',
    '                                                    <div class="form-group">\r\n',
    '                                                        <label class="required-field">Provincia Rep. Legal</label>\r\n',
    '                                                        <input type="text" class="form-control" id="provincia_rep_legal" name="provincia_rep_legal" placeholder="Ej: Lima">\r\n',
    '                                                    </div>\r\n',
    '                                                </div>\r\n',
    '                                                <div class="col-md-4">\r\n',
    '                                                    <div class="form-group">\r\n',
    '                                                        <label class="required-field">Departamento Rep. Legal</label>\r\n',
    '                                                        <input type="text" class="form-control" id="departamento_rep_legal" name="departamento_rep_legal" placeholder="Ej: Lima">\r\n',
    '                                                    </div>\r\n',
    '                                                </div>\r\n',
    '                                            </div>\r\n',
    '                                            <div class="row"><div class="col-12"><h6 class="mt-3 mb-2" style="color:#6c757d;font-weight:600;">Datos Registrales</h6></div></div>\r\n',
    '                                            <div class="row">\r\n',
    '                                                <div class="col-md-4">\r\n',
    '                                                    <div class="form-group">\r\n',
    '                                                        <label class="required-field">Partida Electr&#243;nica N&#176;</label>\r\n',
    '                                                        <input type="text" class="form-control" id="partida_electronica" name="partida_electronica" placeholder="Ej: 13782080">\r\n',
    '                                                    </div>\r\n',
    '                                                </div>\r\n',
    '                                                <div class="col-md-4">\r\n',
    '                                                    <div class="form-group">\r\n',
    '                                                        <label class="required-field">Zona Registral N&#176;</label>\r\n',
    '                                                        <input type="text" class="form-control" id="zona_registral" name="zona_registral" placeholder="Ej: IX">\r\n',
    '                                                    </div>\r\n',
    '                                                </div>\r\n',
    '                                                <div class="col-md-4">\r\n',
    '                                                    <div class="form-group">\r\n',
    '                                                        <label class="required-field">Ciudad de Registro</label>\r\n',
    '                                                        <input type="text" class="form-control" id="ciudad_registro" name="ciudad_registro" placeholder="Ej: Lima">\r\n',
    '                                                    </div>\r\n',
    '                                                </div>\r\n',
    '                                            </div>\r\n',
    '                                        </div>\r\n',
]
lines = replace_lines(lines, e_start, e_end, new_block_2)
shift2 = shift1 + len(new_block_2) - 55  # 55 = original 484-430+1
print(f"PATCH 2 done. Shift now: {shift2}, total lines: {len(lines)}")

# ─────────────────────────────────────────
# PATCH 3: Replace Joyas block — add kilates + estado, keep peso + descripcion
# Original lines 589-633 → now at 589+shift2 to 633+shift2
# ─────────────────────────────────────────
j_start = 589 + shift2
j_end   = 633 + shift2
new_block_3 = [
    '                                        <!-- Campos para Prenda JOYAS -->\r\n',
    '                                        <div id="campos_joyas" style="display: none;">\r\n',
    '                                            <div class="row">\r\n',
    '                                                <div class="col-md-4">\r\n',
    '                                                    <div class="form-group">\r\n',
    '                                                        <label class="required-field">Quilates (Ley)</label>\r\n',
    '                                                        <input type="text" class="form-control" id="joya_kilates" name="joya_kilates" placeholder="Ej: 18k, 24k">\r\n',
    '                                                    </div>\r\n',
    '                                                </div>\r\n',
    '                                                <div class="col-md-4">\r\n',
    '                                                    <div class="form-group">\r\n',
    '                                                        <label class="required-field">Peso Bruto (gramos)</label>\r\n',
    '                                                        <input type="number" class="form-control" id="joyas_peso_bruto" name="joyas_peso_bruto" placeholder="Ej: 25.5" step="0.01">\r\n',
    '                                                    </div>\r\n',
    '                                                </div>\r\n',
    '                                                <div class="col-md-4">\r\n',
    '                                                    <div class="form-group">\r\n',
    '                                                        <label class="required-field">Peso Neto (gramos)</label>\r\n',
    '                                                        <input type="number" class="form-control" id="joyas_peso_neto" name="joyas_peso_neto" placeholder="Ej: 24.0" step="0.01">\r\n',
    '                                                    </div>\r\n',
    '                                                </div>\r\n',
    '                                            </div>\r\n',
    '                                            <div class="row">\r\n',
    '                                                <div class="col-md-6">\r\n',
    '                                                    <div class="form-group">\r\n',
    '                                                        <label class="required-field">Estado de la Joya</label>\r\n',
    '                                                        <select class="form-control" id="joya_estado" name="joya_estado">\r\n',
    '                                                            <option value="">Seleccione...</option>\r\n',
    '                                                            <option value="NUEVO">Nuevo</option>\r\n',
    '                                                            <option value="BUENO">Buen estado</option>\r\n',
    '                                                            <option value="REGULAR">Regular</option>\r\n',
    '                                                            <option value="CON_DESGASTE">Con desgaste</option>\r\n',
    '                                                        </select>\r\n',
    '                                                    </div>\r\n',
    '                                                </div>\r\n',
    '                                                <div class="col-md-6">\r\n',
    '                                                    <div class="form-group">\r\n',
    '                                                        <label>Valorizaci&#243;n Referencial (S/)</label>\r\n',
    '                                                        <input type="number" class="form-control" id="joyas_valorizacion" name="joyas_valorizacion" placeholder="Ej: 5000" step="0.01">\r\n',
    '                                                    </div>\r\n',
    '                                                </div>\r\n',
    '                                            </div>\r\n',
    '                                            <div class="row">\r\n',
    '                                                <div class="col-12">\r\n',
    '                                                    <div class="form-group">\r\n',
    '                                                        <label class="required-field">Descripci&#243;n Detallada</label>\r\n',
    '                                                        <textarea class="form-control" id="joyas_descripcion" name="joyas_descripcion" rows="3" placeholder="Ej: Anillo de oro 18k con diamante central de 0.5ct"></textarea>\r\n',
    '                                                    </div>\r\n',
    '                                                </div>\r\n',
    '                                            </div>\r\n',
    '                                        </div>\r\n',
]
lines = replace_lines(lines, j_start, j_end, new_block_3)
shift3 = shift2 + len(new_block_3) - 45
print(f"PATCH 3 done. Shift now: {shift3}, total lines: {len(lines)}")

# ─────────────────────────────────────────
# PATCH 4: Add ELECTRO extra fields (color, fabric, descripcion) BEFORE closing div
# Original electro block ends at line 682 (</div> after accesorios)
# Now at 682+shift3. We'll insert 3 new field rows before lines 673+shift3..682+shift3
# ─────────────────────────────────────────
el_insert_after = 672 + shift3  # after the accesorios row closing div at line 681+shift3
el_end = 682 + shift3

new_electro_extras = [
    '                                            <div class="row">\r\n',
    '                                                <div class="col-md-4">\r\n',
    '                                                    <div class="form-group">\r\n',
    '                                                        <label>Color</label>\r\n',
    '                                                        <input type="text" class="form-control" id="electro_color" name="electro_color" placeholder="Ej: Negro, Plateado">\r\n',
    '                                                    </div>\r\n',
    '                                                </div>\r\n',
    '                                                <div class="col-md-4">\r\n',
    '                                                    <div class="form-group">\r\n',
    '                                                        <label>Fabricante / A&#241;o</label>\r\n',
    '                                                        <input type="text" class="form-control" id="electro_fabric" name="electro_fabric" placeholder="Ej: Samsung / 2022">\r\n',
    '                                                    </div>\r\n',
    '                                                </div>\r\n',
    '                                                <div class="col-md-4">\r\n',
    '                                                    <div class="form-group">\r\n',
    '                                                        <label>Accesorios</label>\r\n',
    '                                                        <input type="text" class="form-control" id="electro_accesorios" name="electro_accesorios" placeholder="Ej: Cargador, Mouse">\r\n',
    '                                                    </div>\r\n',
    '                                                </div>\r\n',
    '                                            </div>\r\n',
    '                                            <div class="row">\r\n',
    '                                                <div class="col-12">\r\n',
    '                                                    <div class="form-group">\r\n',
    '                                                        <label>Descripci&#243;n / Estado</label>\r\n',
    '                                                        <textarea class="form-control" id="electro_descripcion" name="electro_descripcion" rows="2" placeholder="Ej: Equipo en buen estado de funcionamiento."></textarea>\r\n',
    '                                                    </div>\r\n',
    '                                                </div>\r\n',
    '                                            </div>\r\n',
]

# Insert after the accesorios textarea block, before closing </div> of campos_electro
# The accesorios block spans lines 673-681 (old). Let's replace the old accesorios rows + closing divs
old_electro_tail_lines = 682 + shift3 - (672 + shift3) + 1  # = 11
new_electro_tail = new_electro_extras + [
    '                                        </div>\r\n',  # close campos_electro
]
lines = replace_lines(lines, 672 + shift3, 682 + shift3, new_electro_tail)
shift4 = shift3 + len(new_electro_tail) - 11
print(f"PATCH 4 done. Shift now: {shift4}, total lines: {len(lines)}")

# ─────────────────────────────────────────
# PATCH 5: Step 3 — replace fixed "plazo" field with editable + add monto_tasacion
# Original line 697-704 (Monto col-md-6 + Plazo col-md-6) → now shifted
# ─────────────────────────────────────────
p_start = 690 + shift4
p_end   = 705 + shift4
new_block_5 = [
    '                                        <div class="row">\r\n',
    '                                            <div class="col-md-6">\r\n',
    '                                                <div class="form-group">\r\n',
    '                                                    <label class="required-field">Monto del Pr&#233;stamo (S/)</label>\r\n',
    '                                                    <input type="number" class="form-control" id="monto_prestamo" name="monto_prestamo" placeholder="Ej: 10000" step="0.01" required>\r\n',
    '                                                </div>\r\n',
    '                                            </div>\r\n',
    '                                            <div class="col-md-3">\r\n',
    '                                                <div class="form-group">\r\n',
    '                                                    <label class="required-field">Plazo (d&#237;as)</label>\r\n',
    '                                                    <input type="number" class="form-control" id="plazo_dias" name="plazo_dias" value="30" min="1" max="365" required>\r\n',
    '                                                    <small class="form-text text-muted">D&#237;as calendario</small>\r\n',
    '                                                </div>\r\n',
    '                                            </div>\r\n',
    '                                            <div class="col-md-3">\r\n',
    '                                                <div class="form-group">\r\n',
    '                                                    <label class="required-field">Valor Tasaci&#243;n (S/)</label>\r\n',
    '                                                    <input type="number" class="form-control" id="monto_tasacion" name="monto_tasacion" placeholder="Ej: 15000" step="0.01" required>\r\n',
    '                                                    <small class="form-text text-muted">Valor del bien en garant&#237;a</small>\r\n',
    '                                                </div>\r\n',
    '                                            </div>\r\n',
    '                                        </div>\r\n',
]
lines = replace_lines(lines, p_start, p_end, new_block_5)
shift5 = shift4 + len(new_block_5) - 16
print(f"PATCH 5 done. Shift now: {shift5}, total lines: {len(lines)}")

# ─────────────────────────────────────────
# PATCH 6: Remove the duplicate garante block that was inserted by patch 7 before
# (lines 786-xxx after all shifts). The file now has TWO garante blocks.
# Find the second occurrence of "nombre_garante" and remove that duplicate block.
# ─────────────────────────────────────────
content = ''.join(lines)
# Find 2nd occurrence of nombre_garante
first = content.find('id="nombre_garante"')
second = content.find('id="nombre_garante"', first + 1)
if second != -1:
    # Find the start of that garante section (back-track to <!-- Garante Mobiliario)
    marker = '<!-- Garante Mobiliario (Opcional) -->'
    # Find which occurrence comes before second
    g1 = content.find(marker)
    g2 = content.find(marker, g1 + 1)
    if g2 != -1:
        # Find end of second garante block (ending </div>\n before calculator)
        calc_marker = '<!-- Calculadora en Tiempo Real -->'
        calc_pos = content.find(calc_marker, g2)
        if calc_pos != -1:
            # Remove from g2 back a few chars to calc_pos
            # Find the start of the line containing g2
            line_start = content.rfind('\n', 0, g2) + 1
            content = content[:line_start] + content[calc_pos:]
            lines = content.splitlines(keepends=True)
            print(f"PATCH 6 done: removed duplicate garante block. Lines now: {len(lines)}")
        else:
            print("PATCH 6 SKIP: calc marker not found")
    else:
        print("PATCH 6 SKIP: second garante marker not found")
else:
    print("PATCH 6 SKIP: no duplicate nombre_garante")

# ─────────────────────────────────────────
# PATCH 7: Fix the submit handler to use AJAX (replace the old alert-based one)
# ─────────────────────────────────────────
content = ''.join(lines)

old_submit_marker = "// Por ahora solo mostrar alerta (sin backend)"
new_submit_body = """// Enviar datos al generador de contratos v&#237;a AJAX
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

if old_submit_marker in content:
    # Replace 3 lines starting from old marker to end of alert()
    old_alert_block = "// Por ahora solo mostrar alerta (sin backend)\n                    alert('? Formulario completado correctamente!\\n\\nEn la siguiente fase se conectar&#225; con la base de datos para guardar el cliente y generar los documentos legales.');"
    content = content.replace(old_alert_block, new_submit_body)
    # Also try with the original encoding
    content = content.replace(
        "// Por ahora solo mostrar alerta (sin backend)\r\n                    alert('? Formulario completado correctamente!\\n\\nEn la siguiente fase se conectar\xe1 con la base de datos para guardar el cliente y generar los documentos legales.');",
        new_submit_body
    )
    print("PATCH 7: submit handler replacement attempted")
else:
    print("PATCH 7 SKIP: old submit marker not found")

# ─────────────────────────────────────────
# PATCH 8: Add fillContratoModal function and btn_modificar before closing });
# ─────────────────────────────────────────
old_closing = "            });\r\n        </script>"
new_closing = """            });

            // === FUNCIONES DEL MODAL DE CONTRATO ===
            function fillContratoModal(preview, docxFile) {
                const p = preview || {};
                $('#modal_num_contrato').text('N&#176; ' + (p.num_contrato || ''));
                $('#preview_num_contrato').text(p.num_contrato || '');
                $('#preview_fecha_ciudad').text((p.ciudad || 'Lima') + ', ' + (p.fecha || ''));
                $('#modal_tipo_contrato').text('CONTRATO DE GARANT&#205;A MOBILIARIA | ' + (p.tipo_contrato || '').toUpperCase());
                $('#preview_bien_title').text('\uD83D\uDD12 ' + (p.tipo_contrato || 'Bien en Garant&#237;a'));

                const c = p.cliente || {};
                let clienteHtml = rowPrev('Nombre', c.nombre || '\u2014') + rowPrev('DNI / RUC', c.id || '\u2014') + rowPrev('Direcci&#243;n', c.direccion || '\u2014') + rowPrev('Tipologa', p.tipo_personeria || '\u2014');
                $('#preview_cliente_rows').html(clienteHtml);

                const b = p.bien || {};
                let bienHtml = '';
                for (const [key, val] of Object.entries(b)) {
                    if (!val) continue;
                    const lbl = key.replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase());
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
                let prestamoHtml = rowPrev('Monto Pr&#233;stamo', pr.monto || '\u2014') + rowPrev('En letras', (pr.letras_prestamo || '') + ' Y 00/100 SOLES') + rowPrev('Valor de Tasaci&#243;n', pr.tasacion || '\u2014') + rowPrev('Plazo', pr.plazo || '\u2014') + rowPrev('Comisi&#243;n', pr.comision || '\u2014');
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

if old_closing in content:
    content = content.replace(old_closing, new_closing)
    print("PATCH 8 done: fillContratoModal function added")
else:
    print("PATCH 8 SKIP: closing tag not found, trying alternative...")
    # Try with LF only
    alt_closing = "            });\n        </script>"
    if alt_closing in content:
        content = content.replace(alt_closing, new_closing.replace('\r\n', '\n'))
        print("PATCH 8 done (LF variant)")
    else:
        print("PATCH 8 FAILED")

# ─────────────────────────────────────────
# PATCH 9: Add the preview modal HTML before the footer
# ─────────────────────────────────────────
footer_marker = '            <div class="footer">'
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
                    <span style="font-size:1.4rem;">&#10004;</span>
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
                                <div style="font-weight:700;color:#184897;font-size:0.85rem;text-transform:uppercase;border-bottom:2px solid #184897;padding-bottom:6px;margin-bottom:10px;">&#128203; Datos del Cliente</div>
                                <div id="preview_cliente_rows"></div>
                            </div>
                            <div id="preview_garante_section" style="background:#fff3e0;border-radius:8px;padding:1.2rem;margin-bottom:1rem;display:none;">
                                <div style="font-weight:700;color:#F5812A;font-size:0.85rem;text-transform:uppercase;border-bottom:2px solid #F5812A;padding-bottom:6px;margin-bottom:10px;">&#128100; Garante</div>
                                <div id="preview_garante_rows"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div style="background:#f8f9fa;border-radius:8px;padding:1.2rem;margin-bottom:1rem;">
                                <div style="font-weight:700;color:#184897;font-size:0.85rem;text-transform:uppercase;border-bottom:2px solid #184897;padding-bottom:6px;margin-bottom:10px;" id="preview_bien_title">&#128274; Bien en Garant&#237;a</div>
                                <div id="preview_bien_rows"></div>
                            </div>
                            <div style="background:#f8f9fa;border-radius:8px;padding:1.2rem;">
                                <div style="font-weight:700;color:#184897;font-size:0.85rem;text-transform:uppercase;border-bottom:2px solid #184897;padding-bottom:6px;margin-bottom:10px;">&#128176; Condiciones del Pr&#233;stamo</div>
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
                <button type="button" id="btn_modificar" class="btn btn-outline-secondary" style="font-weight:600;">&#9999;&#65039; Modificar Datos</button>
                <a id="btn_imprimir" href="#" target="_blank" class="btn" style="background:#F5812A;color:#fff;font-weight:700;padding:0.7rem 1.8rem;border-radius:6px;text-decoration:none;">
                    &#128424;&#65039; Imprimir Contrato
                </a>
            </div>
        </div>
    </div>
</div>

"""

if footer_marker in content:
    content = content.replace(footer_marker, modal_html + footer_marker, 1)
    print("PATCH 9 done: modal HTML added before footer")
else:
    print("PATCH 9 SKIP: footer marker not found")

# ─────────────────────────────────────────
# WRITE RESULT
# ─────────────────────────────────────────
with open(src, 'w', encoding='utf-8') as f:
    f.write(content)

print(f"\nAll patches applied. Final file size: {len(content)} chars")

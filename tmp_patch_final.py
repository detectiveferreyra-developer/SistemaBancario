"""
patch_final_nuevo_cliente.py
Uses exact string replacement in latin-1 to safely patch html blocks in nuevo-cliente.php
"""
import re

src = r'c:\laragon\www\SistemaBancario\CrediAgil\vista\Administradores\nuevo-cliente.php'

with open(src, 'r', encoding='latin-1') as f:
    content = f.read()

# ─────────────────────────────────────────
# PATCH 1: Domicilio y Conyuge (Persona Natural)
# ─────────────────────────────────────────
old_domicilio = """                                            <!-- Domicilio -->
                                            <div class="row">
                                                <div class="col-12">
                                                    <h6 class="mt-3 mb-3" style="color: #6c757d; font-weight: 600;">
                                                        Domicilio</h6>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="required-field">Calle / Avenida</label>
                                                        <input type="text" class="form-control" id="domicilio_calle"
                                                            name="domicilio_calle" placeholder="Ej: Calle Principal">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Urbanizaci&#243;n / Colonia</label>
                                                        <input type="text" class="form-control" id="domicilio_urbanizacion"
                                                            name="domicilio_urbanizacion" placeholder="Ej: Colonia Escal&#243;n">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Manzana</label>
                                                        <input type="text" class="form-control" id="domicilio_manzana"
                                                            name="domicilio_manzana" placeholder="Ej: A">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Lote</label>
                                                        <input type="text" class="form-control" id="domicilio_lote"
                                                            name="domicilio_lote" placeholder="Ej: 15">
                                                    </div>
                                                </div>
                                            </div>"""

new_domicilio = """                                            <!-- Domicilio del Cliente -->
                                            <div class="row">
                                                <div class="col-12">
                                                    <h6 class="mt-3 mb-3" style="color: #6c757d; font-weight: 600;">Domicilio del Cliente</h6>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="required-field">Direcci&#243;n Completa</label>
                                                        <input type="text" class="form-control" id="direccion_cliente" name="direccion_cliente" placeholder="Ej: Av. Los Pinos 123, Urb. Las Flores">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="required-field">Distrito</label>
                                                        <input type="text" class="form-control" id="distrito_cliente" name="distrito_cliente" placeholder="Ej: Miraflores">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="required-field">Provincia</label>
                                                        <input type="text" class="form-control" id="provincia_cliente" name="provincia_cliente" placeholder="Ej: Lima">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="required-field">Departamento</label>
                                                        <input type="text" class="form-control" id="departamento_cliente" name="departamento_cliente" placeholder="Ej: Lima">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- C&#243;nyuge del Cliente (Opcional) -->
                                            <div class="row">
                                                <div class="col-12">
                                                    <h6 class="mt-3 mb-3" style="color: #6c757d; font-weight: 600;">
                                                        Datos del C&#243;nyuge <small class="text-muted">(Opcional)</small>
                                                    </h6>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Nombre del C&#243;nyuge</label>
                                                        <input type="text" class="form-control" id="nombre_conyuge" name="nombre_conyuge" placeholder="Ej: Mar&#237;a Elena Garc&#237;a">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>DNI del C&#243;nyuge</label>
                                                        <input type="text" class="form-control" id="dni_conyuge" name="dni_conyuge" placeholder="Ej: 98765432" maxlength="8">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Direcci&#243;n del C&#243;nyuge</label>
                                                        <input type="text" class="form-control" id="direccion_conyuge" name="direccion_conyuge" placeholder="Ej: Av. Principal 456 (si es diferente)">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Distrito del C&#243;nyuge</label>
                                                        <input type="text" class="form-control" id="distrito_conyuge" name="distrito_conyuge" placeholder="Ej: San Isidro">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Provincia del C&#243;nyuge</label>
                                                        <input type="text" class="form-control" id="provincia_conyuge" name="provincia_conyuge" placeholder="Ej: Lima">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Departamento del C&#243;nyuge</label>
                                                        <input type="text" class="form-control" id="departamento_conyuge" name="departamento_conyuge" placeholder="Ej: Lima">
                                                    </div>
                                                </div>
                                            </div>"""

def normalize_space(s):
    return re.sub(r'\s+', ' ', s.replace('&#243;', 'ó').replace('&#237;', 'í'))

def search_and_replace_block(text, title_regex, closing_regex, new_block):
    match = re.search(f"{title_regex}.*?{closing_regex}", text, re.DOTALL | re.IGNORECASE)
    if match:
        return text[:match.start()] + new_block + '\n' + text[match.end():], True
    return text, False

# Using strict text replacement for Domicilio since old tags match backup
# Actually, the original backup txt doesn't have HTML entities encoded! It might have literal 'ó'.
# We can use regex.
content, ok1 = search_and_replace_block(content, r'<!-- Domicilio -->', r'name="domicilio_lote".*?</div>\s*</div>\s*</div>\s*</div>', new_domicilio + "\n" + '                                        </div>')
# Wait, removing the previous Conyuge block is also needed.
# The original code has: <!-- Datos del Cónyuge (Opcionales) --> BEFORE Domicilio
match_old_conyuge = re.search(r'<!-- Datos del C[\xf3o]nyuge \(Opcionales\) -->.*?name="dni_conyuge".*?</div>\s*</div>\s*</div>', content, re.DOTALL)
if match_old_conyuge:
    content = content[:match_old_conyuge.start()] + content[match_old_conyuge.end():]
print("PATCH 1 (Domicilio/Conyuge):", ok1)


# ─────────────────────────────────────────
# PATCH 2: Empresa Block
# ─────────────────────────────────────────
new_empresa = """                                        <!-- Campos para Empresa -->
                                        <div id="campos_empresa" style="display: none;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="required-field">Raz&#243;n Social</label>
                                                        <input type="text" class="form-control" id="razon_social" name="razon_social" placeholder="Ej: Inversiones ABC E.I.R.L.">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="required-field">RUC</label>
                                                        <input type="text" class="form-control" id="ruc" name="ruc" placeholder="Ej: 20601767920" maxlength="11">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="required-field">Domicilio Fiscal</label>
                                                        <input type="text" class="form-control" id="domicilio_fiscal" name="domicilio_fiscal" placeholder="Ej: Jr. Las Ale&#241;as 200, Lima">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row"><div class="col-12"><h6 class="mt-3 mb-2" style="color:#6c757d;font-weight:600;">Representante Legal</h6></div></div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="required-field">Nombre del Representante Legal</label>
                                                        <input type="text" class="form-control" id="representante_legal" name="representante_legal" placeholder="Ej: Carlos Mart&#237;nez">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="required-field">DNI del Representante</label>
                                                        <input type="text" class="form-control" id="dni_representante" name="dni_representante" placeholder="Ej: 12345678" maxlength="8">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="required-field">Direcci&#243;n del Representante Legal</label>
                                                        <input type="text" class="form-control" id="direccion_rep_legal" name="direccion_rep_legal" placeholder="Ej: Av. Los Pinos 123">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="required-field">Distrito Rep. Legal</label>
                                                        <input type="text" class="form-control" id="distrito_rep_legal" name="distrito_rep_legal" placeholder="Ej: La Victoria">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="required-field">Provincia Rep. Legal</label>
                                                        <input type="text" class="form-control" id="provincia_rep_legal" name="provincia_rep_legal" placeholder="Ej: Lima">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="required-field">Departamento Rep. Legal</label>
                                                        <input type="text" class="form-control" id="departamento_rep_legal" name="departamento_rep_legal" placeholder="Ej: Lima">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row"><div class="col-12"><h6 class="mt-3 mb-2" style="color:#6c757d;font-weight:600;">Datos Registrales</h6></div></div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="required-field">Partida Electr&#243;nica N&#176;</label>
                                                        <input type="text" class="form-control" id="partida_electronica" name="partida_electronica" placeholder="Ej: 13782080">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="required-field">Zona Registral N&#176;</label>
                                                        <input type="text" class="form-control" id="zona_registral" name="zona_registral" placeholder="Ej: IX">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="required-field">Ciudad de Registro</label>
                                                        <input type="text" class="form-control" id="ciudad_registro" name="ciudad_registro" placeholder="Ej: Lima">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>"""
content, ok2 = search_and_replace_block(content, r'<!-- Campos para Empresa -->', r'name="domicilio_fiscal".*?</div>\s*</div>\s*</div>\s*</div>', new_empresa)
print("PATCH 2 (Empresa):", ok2)

# ─────────────────────────────────────────
# PATCH 3: Joyas Block
# ─────────────────────────────────────────
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
content, ok3 = search_and_replace_block(content, r'<!-- Campos para Prenda JOYAS -->', r'name="joyas_descripcion".*?</textarea>\s*</div>\s*</div>\s*</div>\s*</div>', new_joyas)
print("PATCH 3 (Joyas):", ok3)

# ─────────────────────────────────────────
# PATCH 4: Electro Extras
# ─────────────────────────────────────────
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
                                            </div>
                                        </div>"""
content, ok4 = search_and_replace_block(content, r'<!-- Campos para Prenda ELECTRO -->.*?id="electro_accesorios".*?</textarea>\s*</div>\s*</div>\s*</div>', r'</div>', new_electro_extras, ) # manual fix for electro since we need to append
# wait search_and_replace_block returns the block. Let's do it manually for electro to avoid eating the next block:
match_electro = re.search(r'id="electro_accesorios".*?</textarea>\s*</div>\s*</div>\s*</div>', content, re.DOTALL)
if match_electro:
    content = content[:match_electro.end()] + '\n' + new_electro_extras.replace('                                        </div>', '') + content[match_electro.end():]
    print("PATCH 4 (Electro): True")
else:
    print("PATCH 4 (Electro): False")

# ─────────────────────────────────────────
# PATCH 5: Configuracion Prestamo (monto, plazo, tasacion)
# ─────────────────────────────────────────
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
content, ok5 = search_and_replace_block(content, r'<div class="row">\s*<div class="col-md-6">\s*<div class="form-group">\s*<label class="required-field">Monto del Pr.*?</label>', r'<small class="form-text text-muted">Plazo fijo del sistema</small>\s*</div>\s*</div>\s*</div>', new_plazo)
print("PATCH 5 (Prestamo):", ok5)

# ─────────────────────────────────────────
# PATCH 6: Add Garante Block
# ─────────────────────────────────────────
garante_html = """
                                        <!-- Garante Mobiliario (Opcional) -->
                                        <div class="row mt-4">
                                            <div class="col-12">
                                                <h6 style="color: #6c757d; font-weight: 600; border-top: 1px solid #e0e0e0; padding-top: 1rem;">
                                                    Garante Mobiliario <small class="text-muted">(Solo si el bien NO pertenece al cliente)</small>
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nombre del Garante</label>
                                                    <input type="text" class="form-control" id="nombre_garante" name="nombre_garante" placeholder="Ej: Juan P&#233;rez Rodr&#237;guez">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>DNI del Garante</label>
                                                    <input type="text" class="form-control" id="dni_garante" name="dni_garante" placeholder="Ej: 45678901" maxlength="8">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nombre del C&#243;nyuge del Garante</label>
                                                    <input type="text" class="form-control" id="conyuge_garante" name="conyuge_garante" placeholder="Ej: Rosa Garc&#237;a">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>DNI del C&#243;nyuge del Garante</label>
                                                    <input type="text" class="form-control" id="dni_conyuge_garante" name="dni_conyuge_garante" placeholder="Ej: 45678902" maxlength="8">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Domicilio del Garante</label>
                                                    <input type="text" class="form-control" id="domicilio_garante" name="domicilio_garante" placeholder="Ej: Av. Lima 456, Dist. Surco, Lima">
                                                </div>
                                            </div>
                                        </div>"""
# Insert before <!-- Calculadora en Tiempo Real -->
c_pos = content.find('<!-- Calculadora en Tiempo Real -->')
if c_pos != -1:
    content = content[:c_pos] + garante_html + '\n                                        ' + content[c_pos:]
    print("PATCH 6 (Garante): True")
else:
    print("PATCH 6 (Garante): False")

# ─────────────────────────────────────────
# PATCH 7: AJAX Submit handler
# ─────────────────────────────────────────
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
content, ok7 = search_and_replace_block(content, r'// Por ahora solo mostrar alerta', r'alert\(.*?\);', new_submit)
print("PATCH 7 (Submit):", ok7)

# ─────────────────────────────────────────
# PATCH 8: Modal JS functions
# ─────────────────────────────────────────
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
                    const lbl = key.replace(/_/g, ' ').replace(/\\b\\w/g, ch => ch.toUpperCase());
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
# Find closing script
match_closing = re.search(r'\s*}\);\s*</script>', content)
if match_closing:
    content = content[:match_closing.start()] + new_closing + content[match_closing.end():]
    print("PATCH 8 (Modal JS): True")
else:
    print("PATCH 8 (Modal JS): False")

# ─────────────────────────────────────────
# PATCH 9: Modal HTML snippet
# ─────────────────────────────────────────
modal_html = """<!-- MODAL PREVIEW CONTRATO -->
<div class="modal fade" id="contratoModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content" style="border:none;border-radius:12px;overflow:hidden;">
            <div class="modal-header" style="background:linear-gradient(135deg,#184897,#1a6bc7);color:#fff;border:none;padding:1.5rem 2rem;">
                <div>
                    <h5 class="modal-title" style="font-weight:700;margin:0;">Contrato Generado</h5>
                    <div style="font-size:0.85rem;opacity:0.85;margin-top:4px;" id="modal_num_contrato">N&#176; &mdash;</div>
                </div>
                <button type="button" class="close" data-dismiss="modal" style="color:#fff;opacity:1;">&times;</button>
            </div>
            <div class="modal-body p-0">
                <div style="background:#e8f5e9;border-bottom:1px solid #c8e6c9;padding:12px 2rem;display:flex;align-items:center;gap:10px;">
                    <span style="font-size:1.4rem;color:#388e3c;">OK</span>
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
footer_pos = content.find('<div class="footer">')
if footer_pos != -1:
    content = content[:footer_pos] + modal_html + content[footer_pos:]
    print("PATCH 9 (Modal HTML): True")
else:
    print("PATCH 9 (Modal HTML): False")

# ─────────────────────────────────────────
# Guardar Resultado
# ─────────────────────────────────────────
with open(src, 'w', encoding='latin-1') as f:
    f.write(content)

print("Todas las patches procesadas. Archivo actualizado.")

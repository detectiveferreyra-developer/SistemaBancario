"""
patch_nuevo_cliente.py
Applies targeted text replacements to nuevo-cliente.php to add all missing template fields.
"""
import re

src = r'c:\laragon\www\SistemaBancario\CrediAgil\vista\Administradores\nuevo-cliente.php'

with open(src, 'r', encoding='utf-8', errors='replace') as f:
    content = f.read()

# ──────────────────────────────────────────────────────────
# PATCH 1: Replace the Domicilio + Conyuge section (Persona Natural)
# The original has a calle/urbanizacion/manzana/lote structure.
# We replace it with proper direccion/distrito/provincia/departamento fields.
# ──────────────────────────────────────────────────────────
old_conyuge_domicilio = '''                                            <!-- Datos del Cónyuge (Opcionales) -->
                                            <div class="row">
                                                <div class="col-12">
                                                    <h6 class="mt-3 mb-3" style="color: #6c757d; font-weight: 600;">
                                                        Datos del Cónyuge <small class="text-muted">(Opcional - dejar vacío
                                                            si no aplica)</small>
                                                    </h6>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Nombre del Cónyuge</label>
                                                        <input type="text" class="form-control" id="nombre_conyuge"
                                                            name="nombre_conyuge"
                                                            placeholder="Ej: María Elena García Rodríguez">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>DNI del Cónyuge</label>
                                                        <input type="text" class="form-control" id="dni_conyuge"
                                                            name="dni_conyuge" placeholder="Ej: 98765432-1" maxlength="10">
                                                        <small class="form-text text-muted">Formato: 98765432-1</small>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Domicilio -->
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
                                                        <label>Urbanización / Colonia</label>
                                                        <input type="text" class="form-control" id="domicilio_urbanizacion"
                                                            name="domicilio_urbanizacion" placeholder="Ej: Colonia Escalón">
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
                                            </div>
                                        </div>'''

new_conyuge_domicilio = '''                                            <!-- Domicilio del Cliente -->
                                            <div class="row">
                                                <div class="col-12">
                                                    <h6 class="mt-3 mb-3" style="color: #6c757d; font-weight: 600;">Domicilio del Cliente</h6>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="required-field">Dirección Completa</label>
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

                                            <!-- Datos del Cónyuge (Opcionales) -->
                                            <div class="row">
                                                <div class="col-12">
                                                    <h6 class="mt-3 mb-3" style="color: #6c757d; font-weight: 600;">
                                                        Datos del Cónyuge <small class="text-muted">(Opcional)</small>
                                                    </h6>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Nombre del Cónyuge</label>
                                                        <input type="text" class="form-control" id="nombre_conyuge" name="nombre_conyuge" placeholder="Ej: María Elena García">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>DNI del Cónyuge</label>
                                                        <input type="text" class="form-control" id="dni_conyuge" name="dni_conyuge" placeholder="Ej: 98765432" maxlength="8">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Dirección del Cónyuge</label>
                                                        <input type="text" class="form-control" id="direccion_conyuge" name="direccion_conyuge" placeholder="Ej: Av. Principal 456 (si es diferente)">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Distrito del Cónyuge</label>
                                                        <input type="text" class="form-control" id="distrito_conyuge" name="distrito_conyuge" placeholder="Ej: San Isidro">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Provincia del Cónyuge</label>
                                                        <input type="text" class="form-control" id="provincia_conyuge" name="provincia_conyuge" placeholder="Ej: Lima">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Departamento del Cónyuge</label>
                                                        <input type="text" class="form-control" id="departamento_conyuge" name="departamento_conyuge" placeholder="Ej: Lima">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>'''

if old_conyuge_domicilio in content:
    content = content.replace(old_conyuge_domicilio, new_conyuge_domicilio)
    print("PATCH 1 OK: Domicilio+Conyuge fields added.")
else:
    print("PATCH 1 SKIP: target not found (already patched?).")

# ──────────────────────────────────────────────────────────
# PATCH 2: Replace Empresa section — add missing REP_LEGAL address + registral fields
# ──────────────────────────────────────────────────────────
old_empresa = '''                                        <!-- Campos para Empresa -->
                                        <div id="campos_empresa" style="display: none;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="required-field">Razón Social</label>
                                                        <input type="text" class="form-control" id="razon_social"
                                                            name="razon_social"
                                                            placeholder="Ej: Comercial ABC S.A. de C.V.">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="required-field">RUC</label>
                                                        <input type="text" class="form-control" id="ruc" name="ruc"
                                                            placeholder="Ej: 0614-123456-001-2" maxlength="20">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="required-field">Representante Legal</label>
                                                        <input type="text" class="form-control" id="representante_legal"
                                                            name="representante_legal"
                                                            placeholder="Ej: Carlos Alberto Martínez">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="required-field">DNI del Representante</label>
                                                        <input type="text" class="form-control" id="dni_representante"
                                                            name="dni_representante" placeholder="Ej: 12345678-9"
                                                            maxlength="10">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="required-field">Partida Electrónica</label>
                                                        <input type="text" class="form-control" id="partida_electronica"
                                                            name="partida_electronica" placeholder="Ej: 123456789">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="required-field">Domicilio Fiscal</label>
                                                        <input type="text" class="form-control" id="domicilio_fiscal"
                                                            name="domicilio_fiscal"
                                                            placeholder="Ej: Av. Principal #123, San Salvador">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>'''

new_empresa = '''                                        <!-- Campos para Empresa -->
                                        <div id="campos_empresa" style="display: none;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="required-field">Razón Social</label>
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
                                                        <input type="text" class="form-control" id="domicilio_fiscal" name="domicilio_fiscal" placeholder="Ej: Jr. Las Aleñas 200, Urb. San Ignacio, Lima">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12"><h6 class="mt-3 mb-3" style="color:#6c757d;font-weight:600;">Representante Legal</h6></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="required-field">Nombre del Representante Legal</label>
                                                        <input type="text" class="form-control" id="representante_legal" name="representante_legal" placeholder="Ej: Carlos Alberto Martínez">
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
                                                        <label class="required-field">Dirección del Representante Legal</label>
                                                        <input type="text" class="form-control" id="direccion_rep_legal" name="direccion_rep_legal" placeholder="Ej: Av. Los Pinos 123">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="required-field">Distrito</label>
                                                        <input type="text" class="form-control" id="distrito_rep_legal" name="distrito_rep_legal" placeholder="Ej: La Victoria">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="required-field">Provincia</label>
                                                        <input type="text" class="form-control" id="provincia_rep_legal" name="provincia_rep_legal" placeholder="Ej: Lima">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="required-field">Departamento</label>
                                                        <input type="text" class="form-control" id="departamento_rep_legal" name="departamento_rep_legal" placeholder="Ej: Lima">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12"><h6 class="mt-3 mb-3" style="color:#6c757d;font-weight:600;">Datos Registrales de la Empresa</h6></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="required-field">Partida Electrónica N°</label>
                                                        <input type="text" class="form-control" id="partida_electronica" name="partida_electronica" placeholder="Ej: 13782080">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="required-field">Zona Registral N°</label>
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
                                        </div>'''

if old_empresa in content:
    content = content.replace(old_empresa, new_empresa)
    print("PATCH 2 OK: Empresa fields added (Rep Legal address + registral).")
else:
    print("PATCH 2 SKIP: Empresa target not found.")

# ──────────────────────────────────────────────────────────
# PATCH 3: Add AUTO_DESCRIPCION after auto_oficina_registral block
# ──────────────────────────────────────────────────────────
old_auto_end = '''                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="required-field">Oficina Registral</label>
                                                        <input type="text" class="form-control" id="auto_oficina_registral"
                                                            name="auto_oficina_registral" placeholder="Ej: San Salvador">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Campos para Prenda JOYAS -->'''

new_auto_end = '''                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="required-field">Oficina Registral</label>
                                                        <input type="text" class="form-control" id="auto_oficina_registral" name="auto_oficina_registral" placeholder="Ej: Lima">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="required-field">Descripción / Estado del Vehículo</label>
                                                        <textarea class="form-control" id="auto_descripcion" name="auto_descripcion" rows="3" placeholder="Ej: Vehículo en buen estado, pintura original, sin choques visibles. Llantas en buen estado."></textarea>
                                                        <small class="form-text text-muted">Describe el estado estético y mecánico del vehículo al momento de la entrega.</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Campos para Prenda JOYAS -->'''

if old_auto_end in content:
    content = content.replace(old_auto_end, new_auto_end)
    print("PATCH 3 OK: auto_descripcion added.")
else:
    print("PATCH 3 SKIP: auto end block not found.")

# ──────────────────────────────────────────────────────────
# PATCH 4: Enhance JOYAS section — add joya_kilates and joya_estado
# ──────────────────────────────────────────────────────────
old_joyas = '''                                        <!-- Campos para Prenda JOYAS -->
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
                                                        <label class="required-field">Valorización (S/.)</label>
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
                                                        <label class="required-field">Descripción Detallada</label>
                                                        <textarea class="form-control" id="joyas_descripcion"
                                                            name="joyas_descripcion" rows="3"
                                                            placeholder="Ej: Anillo de oro 18k con diamante central de 0.5ct y 6 diamantes laterales"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>'''

new_joyas = '''                                        <!-- Campos para Prenda JOYAS -->
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
                                                        <label class="required-field">Valorización Referencial (S/)</label>
                                                        <input type="number" class="form-control" id="joyas_valorizacion" name="joyas_valorizacion" placeholder="Ej: 5000" step="0.01">
                                                        <small class="form-text text-muted">Referencia interna (el monto de tasación va en el Paso 3)</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="required-field">Descripción Detallada</label>
                                                        <textarea class="form-control" id="joyas_descripcion" name="joyas_descripcion" rows="3" placeholder="Ej: Anillo de oro 18k con diamante central de 0.5ct, 6 diamantes laterales. Sin grabados."></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>'''

if old_joyas in content:
    content = content.replace(old_joyas, new_joyas)
    print("PATCH 4 OK: Joyas fields enhanced.")
else:
    print("PATCH 4 SKIP: Joyas block not found.")

# ──────────────────────────────────────────────────────────
# PATCH 5: Add ELECTRO extra fields (color, descripcion, fabricante)
# ──────────────────────────────────────────────────────────
old_electro_end = '''                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Accesorios</label>
                                                        <textarea class="form-control" id="electro_accesorios"
                                                            name="electro_accesorios" rows="2"
                                                            placeholder="Ej: Cargador original, mouse inalámbrico, funda protectora"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Step 3:'''

new_electro_end = '''                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Color</label>
                                                        <input type="text" class="form-control" id="electro_color" name="electro_color" placeholder="Ej: Negro, Plateado">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Fabricante / Año</label>
                                                        <input type="text" class="form-control" id="electro_fabric" name="electro_fabric" placeholder="Ej: Samsung / 2022">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Accesorios Incluidos</label>
                                                        <input type="text" class="form-control" id="electro_accesorios" name="electro_accesorios" placeholder="Ej: Cargador, Mouse">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Descripción / Estado</label>
                                                        <textarea class="form-control" id="electro_descripcion" name="electro_descripcion" rows="2" placeholder="Ej: Equipo en buen estado de funcionamiento, sin golpes visibles."></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Step 3:'''

if old_electro_end in content:
    content = content.replace(old_electro_end, new_electro_end)
    print("PATCH 5 OK: Electro extra fields added.")
else:
    print("PATCH 5 SKIP: Electro block not found.")

# ──────────────────────────────────────────────────────────
# PATCH 6: Step 3 — Add monto_tasacion, make plazo editable, add garante section
# ──────────────────────────────────────────────────────────
old_step3_plazo = '''                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Plazo</label>
                                                    <input type="text" class="form-control" value="30 días calendario"
                                                        readonly style="background: #f8f9fa;">
                                                    <small class="form-text text-muted">Plazo fijo del sistema</small>
                                                </div>
                                            </div>'''

new_step3_plazo = '''                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="required-field">Plazo (días)</label>
                                                    <input type="number" class="form-control" id="plazo_dias" name="plazo_dias" value="30" min="1" max="365" required>
                                                    <small class="form-text text-muted">Días calendario</small>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="required-field">Valor Tasación (S/)</label>
                                                    <input type="number" class="form-control" id="monto_tasacion" name="monto_tasacion" placeholder="Ej: 15000" step="0.01" required>
                                                    <small class="form-text text-muted">Valor del bien en garantía</small>
                                                </div>
                                            </div>'''

if old_step3_plazo in content:
    content = content.replace(old_step3_plazo, new_step3_plazo)
    print("PATCH 6 OK: Plazo editable + monto_tasacion added.")
else:
    print("PATCH 6 SKIP: Plazo block not found.")

# ──────────────────────────────────────────────────────────
# PATCH 7: Add Garante section before calculator result
# ──────────────────────────────────────────────────────────
old_calculator = '''                                        <!-- Calculadora en Tiempo Real -->
                                        <div class="calculator-result" id="calculator_result" style="display: none;">'''

new_calculator = '''                                        <!-- Garante Mobiliario (Opcional) -->
                                        <div class="row mt-4">
                                            <div class="col-12">
                                                <h6 style="color: #6c757d; font-weight: 600; border-top: 1px solid #e0e0e0; padding-top: 1rem;">
                                                    👤 Garante Mobiliario <small class="text-muted">(Solo si el bien NO pertenece al cliente)</small>
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nombre del Garante</label>
                                                    <input type="text" class="form-control" id="nombre_garante" name="nombre_garante" placeholder="Ej: Juan Pérez Rodríguez">
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
                                                    <label>Nombre del Cónyuge del Garante</label>
                                                    <input type="text" class="form-control" id="conyuge_garante" name="conyuge_garante" placeholder="Ej: Rosa García">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>DNI del Cónyuge del Garante</label>
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
                                        </div>

                                        <!-- Calculadora en Tiempo Real -->
                                        <div class="calculator-result" id="calculator_result" style="display: none;">'''

if old_calculator in content:
    content = content.replace(old_calculator, new_calculator)
    print("PATCH 7 OK: Garante section added.")
else:
    print("PATCH 7 SKIP: Calculator block not found.")

# ──────────────────────────────────────────────────────────
# PATCH 8: Add the preview modal HTML before </div> end of main col-12
# and after the stepper-container closing div
# ──────────────────────────────────────────────────────────
old_modal_anchor = '''                        </div>
                    </div>

                </div>
            </div>
            <!--**********************************
            Content body end
        ***********************************-->'''

new_modal_anchor = '''                        </div>
                    </div>

                </div>
            </div>
            <!--**********************************
            Content body end
        ***********************************-->

<!-- ========================================================
     MODAL: CONTRATO GENERADO — PREVIEW + IMPRIMIR + MODIFICAR
     ======================================================== -->
<div class="modal fade" id="contratoModal" tabindex="-1" role="dialog" aria-labelledby="contratoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content" style="border: none; border-radius: 12px; overflow: hidden;">
            <!-- Header -->
            <div class="modal-header" style="background: linear-gradient(135deg, #184897, #1a6bc7); color: #fff; border: none; padding: 1.5rem 2rem;">
                <div>
                    <h5 class="modal-title" id="contratoModalLabel" style="font-weight: 700; font-size: 1.2rem; margin: 0;">
                        <i class="lni lni-checkmark-circle mr-2"></i> Contrato Generado Exitosamente
                    </h5>
                    <div style="font-size: 0.85rem; opacity: 0.85; margin-top: 4px;" id="modal_num_contrato">N° —</div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar" style="color: #fff; opacity: 1; font-size: 1.5rem;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Body -->
            <div class="modal-body p-0">
                <!-- Banner de éxito -->
                <div style="background: #e8f5e9; border-bottom: 1px solid #c8e6c9; padding: 12px 2rem; display: flex; align-items: center; gap: 10px;">
                    <span style="font-size: 1.5rem;">✅</span>
                    <div>
                        <strong style="color: #388e3c;">El contrato ha sido completado con todos los datos ingresados.</strong>
                        <div style="font-size: 0.85rem; color: #555;">Revise la información antes de imprimir. Si hay algún error, use "Modificar".</div>
                    </div>
                </div>

                <!-- Preview del contrato -->
                <div style="padding: 2rem;" id="modal_preview_content">

                    <!-- Cabecera del contrato -->
                    <div style="text-align:center; border-bottom: 3px solid #184897; padding-bottom: 16px; margin-bottom: 20px;">
                        <div style="font-size: 1.1rem; font-weight: 800; color: #184897; letter-spacing: 1px;">INVERSIONES CREDIÁGIL DEL PERÚ E.I.R.L.</div>
                        <div style="font-size: 0.8rem; color: #777;">RUC 20601767920 | Av. Próceres 2517, SJL | +51 998 277 396</div>
                        <div style="margin-top: 12px; font-size: 1.05rem; font-weight: 700; color: #333; text-transform: uppercase;" id="modal_tipo_contrato">CONTRATO DE PRÉSTAMO CON GARANTÍA MOBILIARIA</div>
                        <div style="font-size: 0.9rem; color: #555; margin-top: 4px;">
                            N° <span id="preview_num_contrato" style="font-weight: 700; color: #184897;">—</span>
                            &nbsp;|&nbsp;
                            <span id="preview_fecha_ciudad">Lima, —</span>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Columna izquierda -->
                        <div class="col-md-6">
                            <!-- Datos del cliente -->
                            <div style="background: #f8f9fa; border-radius: 8px; padding: 1.2rem; margin-bottom: 1rem;">
                                <div style="font-weight: 700; color: #184897; font-size: 0.9rem; text-transform: uppercase; border-bottom: 2px solid #184897; padding-bottom: 6px; margin-bottom: 12px;">📋 Datos del Cliente</div>
                                <div id="preview_cliente_rows"></div>
                            </div>
                            <!-- Garante -->
                            <div id="preview_garante_section" style="background: #fff3e0; border-radius: 8px; padding: 1.2rem; margin-bottom: 1rem; display: none;">
                                <div style="font-weight: 700; color: #F5812A; font-size: 0.9rem; text-transform: uppercase; border-bottom: 2px solid #F5812A; padding-bottom: 6px; margin-bottom: 12px;">👤 Garante Mobiliario</div>
                                <div id="preview_garante_rows"></div>
                            </div>
                        </div>
                        <!-- Columna derecha -->
                        <div class="col-md-6">
                            <!-- Datos del bien -->
                            <div style="background: #f8f9fa; border-radius: 8px; padding: 1.2rem; margin-bottom: 1rem;">
                                <div style="font-weight: 700; color: #184897; font-size: 0.9rem; text-transform: uppercase; border-bottom: 2px solid #184897; padding-bottom: 6px; margin-bottom: 12px;" id="preview_bien_title">🔒 Bien en Garantía</div>
                                <div id="preview_bien_rows"></div>
                            </div>
                            <!-- Datos del préstamo -->
                            <div style="background: #f8f9fa; border-radius: 8px; padding: 1.2rem;">
                                <div style="font-weight: 700; color: #184897; font-size: 0.9rem; text-transform: uppercase; border-bottom: 2px solid #184897; padding-bottom: 6px; margin-bottom: 12px;">💰 Condiciones del Préstamo</div>
                                <div id="preview_prestamo_rows"></div>
                                <!-- Total destacado -->
                                <div style="background: #184897; color: #fff; border-radius: 6px; padding: 10px 14px; margin-top: 10px; display: flex; justify-content: space-between; align-items: center;">
                                    <span style="font-weight: 700;">TOTAL A DEVOLVER</span>
                                    <span id="preview_total_highlight" style="font-size: 1.2rem; font-weight: 800;">S/ 0.00</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Nota legal -->
                    <div style="background: #fff8e1; border: 1px solid #ffe082; border-radius: 6px; padding: 12px 16px; margin-top: 16px; font-size: 0.82rem; color: #555; line-height: 1.5;">
                        <strong>⚠️ Nota:</strong> Este es un resumen visual del contrato. El documento DOCX completo con todas las cláusulas legales ha sido generado y puede descargarse o imprimirse haciendo clic en "Imprimir Contrato".
                    </div>
                </div>
            </div>
            <!-- Footer con botones -->
            <div class="modal-footer" style="background: #f8f9fa; border-top: 1px solid #e0e0e0; padding: 1rem 2rem; display: flex; justify-content: space-between;">
                <button type="button" id="btn_modificar" class="btn btn-outline-secondary" style="padding: 0.7rem 1.5rem; font-weight: 600; border-radius: 6px;">
                    ✏️ Modificar Datos
                </button>
                <div style="display: flex; gap: 10px;">
                    <a id="btn_imprimir" href="#" target="_blank" class="btn" style="background: #F5812A; color: #fff; padding: 0.7rem 1.8rem; font-weight: 700; border-radius: 6px; text-decoration: none;">
                        🖨️ Imprimir Contrato
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>'''

if old_modal_anchor in content:
    content = content.replace(old_modal_anchor, new_modal_anchor, 1)
    print("PATCH 8 OK: Preview modal added.")
else:
    print("PATCH 8 SKIP: modal anchor not found.")

# ──────────────────────────────────────────────────────────
# PATCH 9: Replace the submit handler with AJAX + modal logic
# ──────────────────────────────────────────────────────────
old_submit = '''                // Submit form
                $('#nuevo-cliente-form').submit(function (e) {
                    e.preventDefault();

                    // Por ahora solo mostrar alerta (sin backend)
                    alert('? Formulario completado correctamente!\\n\\nEn la siguiente fase se conectará con la base de datos para guardar el cliente y generar los documentos legales.');

                    // Opcional: resetear formulario
                    // this.reset();
                    // currentStep = 1;
                    // showStep(1);
                });'''

new_submit = '''                // ─── SUBMIT HANDLER: AJAX → generar contrato → mostrar modal ───
                $('#nuevo-cliente-form').submit(function (e) {
                    e.preventDefault();

                    const formData = new FormData(this);

                    // Mostrar spinner en btn_submit
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
                                    alert('❌ Error: ' + (res.message || 'Error desconocido al generar el contrato.'));
                                }
                            } catch(ex) {
                                alert('❌ Error al procesar la respuesta del servidor.');
                                console.error(ex);
                            }
                        },
                        error: function(xhr) {
                            $btn.html(originalHtml).prop('disabled', false);
                            alert('❌ Error de conexión: ' + xhr.status + ' ' + xhr.statusText);
                        }
                    });
                });

                // ─── RELLENA EL MODAL con los datos del preview ───
                function fillContratoModal(preview, docxFile) {
                    const p = preview;

                    // Título y número
                    $('#modal_num_contrato').text('N° ' + (p.num_contrato || ''));
                    $('#preview_num_contrato').text(p.num_contrato || '');
                    $('#preview_fecha_ciudad').text((p.ciudad || 'Lima') + ', ' + (p.fecha || ''));
                    $('#modal_tipo_contrato').text('CONTRATO DE PRÉSTAMO CON GARANTÍA MOBILIARIA — ' + (p.tipo_contrato || '').toUpperCase());
                    $('#preview_bien_title').text('🔒 ' + (p.tipo_contrato || 'Bien en Garantía'));

                    // Cliente
                    const c = p.cliente || {};
                    let clienteHtml = rowPreview('Nombre / Razón Social', c.nombre || '—') +
                                      rowPreview('DNI / RUC', c.id || '—') +
                                      rowPreview('Dirección', c.direccion || '—') +
                                      rowPreview('Personería', p.tipo_personeria || '—');
                    $('#preview_cliente_rows').html(clienteHtml);

                    // Bien
                    const b = p.bien || {};
                    let bienHtml = '';
                    for (const [key, val] of Object.entries(b)) {
                        if (!val) continue;
                        const label = key.replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase());
                        bienHtml += rowPreview(label, val);
                    }
                    $('#preview_bien_rows').html(bienHtml || '<em class="text-muted">Sin datos del bien</em>');

                    // Garante
                    const g = p.garante || {};
                    if (g.nombre) {
                        let garanteHtml = rowPreview('Nombre', g.nombre) +
                                          (g.dni ? rowPreview('DNI', g.dni) : '') +
                                          (g.domicilio ? rowPreview('Domicilio', g.domicilio) : '');
                        $('#preview_garante_rows').html(garanteHtml);
                        $('#preview_garante_section').show();
                    } else {
                        $('#preview_garante_section').hide();
                    }

                    // Préstamo
                    const pr = p.prestamo || {};
                    let prestamoHtml = rowPreview('Monto del Préstamo', pr.monto || '—') +
                                       rowPreview('En letras', (pr.letras_prestamo || '') + ' Y 00/100 SOLES') +
                                       rowPreview('Valor de Tasación', pr.tasacion || '—') +
                                       rowPreview('Plazo', pr.plazo || '—') +
                                       rowPreview('Comisión / Interés', pr.comision || '—');
                    $('#preview_prestamo_rows').html(prestamoHtml);
                    $('#preview_total_highlight').text(pr.total || 'S/ 0.00');

                    // Botón imprimir
                    const printData = encodeURIComponent(JSON.stringify(p));
                    $('#btn_imprimir').attr('href', '../vista/Administradores/contrato-preview-print.php?data=' + printData);
                }

                function rowPreview(label, value) {
                    return `<div style="display:flex;justify-content:space-between;padding:5px 0;border-bottom:1px solid #e0e0e0;font-size:0.88rem;">
                                <span style="color:#555;font-weight:600;width:40%;">${label}</span>
                                <span style="color:#222;width:58%;text-align:right;">${value}</span>
                            </div>`;
                }

                // ─── BOTÓN MODIFICAR: cierra modal ───
                $('#btn_modificar').on('click', function() {
                    $('#contratoModal').modal('hide');
                });'''

if old_submit in content:
    content = content.replace(old_submit, new_submit)
    print("PATCH 9 OK: Submit handler replaced with AJAX + modal logic.")
else:
    print("PATCH 9 SKIP: Submit handler not found.")

# Save the modified file
with open(src, 'w', encoding='utf-8') as f:
    f.write(content)

print("\nAll patches applied and file saved.")

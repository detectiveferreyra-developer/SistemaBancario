-- ============================================================
-- SCRIPT DE RESET COMPLETO DE BASE DE DATOS CREDIAGIL
-- Vacía todas las tablas y crea el usuario administrador
-- Usuario: admin / Contraseña: crediagil2026
-- ============================================================

SET FOREIGN_KEY_CHECKS = 0;

TRUNCATE TABLE accesos;
TRUNCATE TABLE codigostransferencias;
TRUNCATE TABLE cuotas;
TRUNCATE TABLE historicocuotascreditos;
TRUNCATE TABLE historicotransacciones;
TRUNCATE TABLE transacciones;
TRUNCATE TABLE transaccionescuentasclientes;
TRUNCATE TABLE transferencias;
TRUNCATE TABLE referenciaspersonales;
TRUNCATE TABLE datosvehiculoscreditos;
TRUNCATE TABLE historicocreditos;
TRUNCATE TABLE creditos;
TRUNCATE TABLE cuentas;
TRUNCATE TABLE detalleusuarios;
TRUNCATE TABLE mensajeria;
TRUNCATE TABLE notificaciones;
TRUNCATE TABLE recuperacion;
TRUNCATE TABLE reporteproblemasplataforma;
TRUNCATE TABLE usuarios;
TRUNCATE TABLE roles;
TRUNCATE TABLE productos;

SET FOREIGN_KEY_CHECKS = 1;

-- ============================================================
-- ROLES BASE
-- ============================================================
INSERT INTO `roles` (`idrol`, `nombrerol`, `descripcionrol`) VALUES
(1, 'administrador', 'Usuarios administradores, encargados del mantenimiento del sistema CrediÁgil.'),
(2, 'presidencia', 'Usuarios del departamento de presidencia CrediÁgil, incluido CEO general de la empresa.'),
(3, 'gerencia', 'Todo el personal operativo del departamento de gerencia CrediÁgil.'),
(4, 'atencionclientes', 'Todo el personal operativo del departamento de atención al cliente.'),
(5, 'clientes', 'Clientes CrediÁgil los cuáles poseen al menos un producto asociado con la empresa.');

-- ============================================================
-- PRODUCTOS BASE
-- ============================================================
INSERT INTO `productos` (`idproducto`, `codigo`, `nombreproducto`, `descripcionproducto`, `requisitosproductos`, `estado`) VALUES
(1, 'CAhorrosPe-CHSA', 'Cuentas de Ahorro Personales', 'Cuentas de ahorro personales simples, sin libreta express.', 'Mayor de 18 años, apertura mínima de $25.00 USD, DUI o NIT.\r\nPoseer un crédito activo o bien tener un histórico de crédito anterior con la empresa.', 'activo'),
(2, 'PrPersonal-CHSA', 'Préstamos Personales', 'Préstamo pago en ventanilla, orientado a la consolidación de deudas, traslado de préstamos o gastos personales. Aplica para asalariados o profesional independiente.', 'Plazo máximo hasta 6 años,\r\nMontos desde $1,500 hasta $50,000.\r\nEdad desde 21 hasta 70 años. Fotocopia de DUI Y NIT.', 'activo'),
(3, 'PrHipoteca-CHSA', 'Préstamos Hipotecarios', 'Préstamos hipotecarios con tasas de interés competitivas, se financia hasta un 90% del valor total del inmueble.', '', 'activo'),
(4, 'PrVehiculo-CHSA', 'Préstamos de Vehículos', 'Préstamo orientado a financiar la compra de vehículo nuevo exclusivamente (No aplica vehículos comerciales; Camiones, Buses, Microbuses).', 'Asalariados', 'activo');

-- ============================================================
-- USUARIO ADMINISTRADOR
-- Contraseña: crediagil2026
-- Encriptada con SHA1 + crypt tal como lo hace el sistema:
--   $cifrado = sha1('crediagil2026')
--   $contrasenia = crypt('crediagil2026', $cifrado)
-- El hash se genera con PHP en el script reset_generar_hash.php
-- ============================================================
-- NOTA: Se inserta sin contraseña encriptada primero para luego
-- actualizar con el hash correcto generado por PHP.
INSERT INTO `usuarios` 
  (`idusuarios`, `nombres`, `apellidos`, `codigousuario`, `contrasenia`, `correo`, 
   `fotoperfil`, `idrol`, `estado_usuario`, `completoperfil`, `habilitarsistema`, 
   `nuevousuario`, `poseecuenta`, `poseecredito`, `habilitarnuevoscreditos`, `quienregistro`) 
VALUES 
  (1, 'Administrador', 'Sistema', 'admin', 'PLACEHOLDER_HASH', 'admin@crediagil.com', 
   'foto_usuarios_nuevos.png', 1, 'activo', 'si', 'si', 
   'no', 'no', 'no', 'si', 'admin');

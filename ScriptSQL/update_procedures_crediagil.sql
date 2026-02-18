DELIMITER $$

DROP PROCEDURE IF EXISTS RegistroPagoCuotasCreditosClientes_OrdenPagosCrediAgil$$
DROP PROCEDURE IF EXISTS RegistroPagoCuotasCreditosClientes_OrdenPagosCashManHa$$
CREATE PROCEDURE RegistroPagoCuotasCreditosClientes_OrdenPagosCrediAgil (IN _idusuarios INT, IN _idproducto INT, IN _idcreditos INT, IN _idcuotas INT, IN _referencia VARCHAR(255), IN _monto DECIMAL(9,2), IN _dias_incumplimiento INT, IN _empleado_gestion VARCHAR(255))   INSERT INTO transacciones (idusuarios,idproducto,idcreditos,idcuotas,referencia,monto,dias_incumplimiento,empleado_gestion) VALUES (_idusuarios,_idproducto,_idcreditos,_idcuotas,_referencia,_monto,_dias_incumplimiento,_empleado_gestion)$$

DROP PROCEDURE IF EXISTS MostrarDetallesDatosClientes_FacturacionCreditosCrediAgil$$
DROP PROCEDURE IF EXISTS MostrarDetallesDatosClientes_FacturacionCreditosCashManHa$$
CREATE PROCEDURE MostrarDetallesDatosClientes_FacturacionCreditosCrediAgil (IN _idcuotas INT, IN _idusuarios INT)   SELECT * FROM vista_detallesfacturacioncreditosclientes WHERE idcuotas=_idcuotas AND idusuarios=_idusuarios$$


DROP PROCEDURE IF EXISTS RegistroNuevasCuentasAhorroClientesCrediAgil$$
DROP PROCEDURE IF EXISTS RegistroNuevasCuentasAhorroClientesCashmanha$$
CREATE PROCEDURE RegistroNuevasCuentasAhorroClientesCrediAgil (IN _numerocuenta INT, IN _montocuenta DECIMAL(9,2), IN _idproducto INT, IN _idusuarios INT)   INSERT INTO cuentas (numerocuenta,montocuenta,idproducto,idusuarios) VALUES (_numerocuenta,_montocuenta,_idproducto,_idusuarios)$$

DROP PROCEDURE IF EXISTS ConsultaEspecificaDatosCuentasAhorroClientesCrediAgil$$
DROP PROCEDURE IF EXISTS ConsultaEspecificaDatosCuentasAhorroClientesCashmanha$$
CREATE PROCEDURE ConsultaEspecificaDatosCuentasAhorroClientesCrediAgil (IN _idusuarios INT)   SELECT * FROM vista_consultalistadogeneralcuentasahorrosregistradas WHERE idusuarios=_idusuarios$$

DROP PROCEDURE IF EXISTS RegistroDepositoCuentasAhorrosClientesCrediAgil$$
DROP PROCEDURE IF EXISTS RegistroDepositoCuentasAhorrosClientesCashManHa$$
CREATE PROCEDURE RegistroDepositoCuentasAhorrosClientesCrediAgil (IN _idusuarios INT, IN _idproducto INT, IN _idcuentas INT, IN _referencia VARCHAR(255), IN _monto DECIMAL(9,2), IN _empleado_gestion VARCHAR(255), IN _tipotransaccion VARCHAR(50), IN _estadotransaccion VARCHAR(50), IN _saldonuevocuenta_transaccion DECIMAL(9,2))   INSERT INTO transaccionescuentasclientes (idusuarios,idproducto,idcuentas,referencia,monto,empleado_gestion,tipotransaccion,estadotransaccion,saldonuevocuenta_transaccion) VALUES (_idusuarios,_idproducto,_idcuentas,_referencia,_monto,_empleado_gestion,_tipotransaccion,_estadotransaccion,_saldonuevocuenta_transaccion)$$

DROP PROCEDURE IF EXISTS RegistroRetiroCuentasAhorrosClientesCrediAgil$$
DROP PROCEDURE IF EXISTS RegistroRetiroCuentasAhorrosClientesCashManHa$$
CREATE PROCEDURE RegistroRetiroCuentasAhorrosClientesCrediAgil (IN _idusuarios INT, IN _idproducto INT, IN _idcuentas INT, IN _referencia VARCHAR(255), IN _monto DECIMAL(9,2), IN _empleado_gestion VARCHAR(255), IN _tipotransaccion VARCHAR(50), IN _estadotransaccion VARCHAR(50), IN _saldonuevocuenta_transaccion DECIMAL(9,2))   INSERT INTO transaccionescuentasclientes (idusuarios,idproducto,idcuentas,referencia,monto,empleado_gestion,tipotransaccion,estadotransaccion,saldonuevocuenta_transaccion) VALUES (_idusuarios,_idproducto,_idcuentas,_referencia,_monto,_empleado_gestion,_tipotransaccion,_estadotransaccion,_saldonuevocuenta_transaccion)$$

DELIMITER ;

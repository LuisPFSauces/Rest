<?php

/**
 * Clase que se encargará de hacer las consultas a la base de datos
 * @author Luis
 * @version 0.1 Primera version de la clase
 */
class DBPDO {

    private static $miDB;
    private static $transIniciada = 0;

    public static function ejecutaConsulta($sentenciaSQL, $parametros, $transaccion = 0) {
        try {
            if (is_null(self::$miDB)) {
                self::$miDB = new PDO(DSN, USER, PASSWORD);
                self::$miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            if ($transaccion) {
                self::transaccion();
            }
            $consulta = self::$miDB->prepare($sentenciaSQL); //Preparamos la consulta.
            if (!$consulta->execute($parametros)) {
                throw new Exception();
            } //Ejecutamos la consulta.
        } catch (PDOException $exception) {
            $consulta = null; //Destruimos la consulta.
            echo $exception->getMessage();
        } finally {
            if (!$transaccion) {
                self::$miDB = null;
            }
            return $consulta;
        }
    }

    //La contraseña se pasará ya 
    public static function transaccion($estado = 1) {
        switch ($estado) {
            case 0:
                if (!is_null(self::$miDB) && self::$transIniciada) {
                    self::$miDB->commit();
                    self::$transIniciada = 0;
                    self::$miDB = null;
                }
                break;
            case 1:
                if (!self::$transIniciada) {
                    self::$miDB->beginTransaction();
                    self::$transIniciada = 1;
                }
                break;
            case 2:
                if (!is_null(self::$miDB) && self::$transIniciada) {
                    self::$miDB->rollBack();
                    self::$transIniciada = 0;
                    self::$miDB = null;
                }
                break;
        }
    }

}

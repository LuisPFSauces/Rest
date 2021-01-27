<?php

/**
 * Clase que se encargará de hacer las consultas a la base de datos
 * @author Luis
 * @version 0.1 Primera version de la clase
 */
class DBPDO {

    public static function ejecutaConsulta($sentenciaSQL, $parametros) {
        try {
            $miDB = new PDO(DSN, USER, PASSWORD);
            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $consulta = $miDB->prepare($sentenciaSQL); //Preparamos la consulta.
            $consulta->execute($parametros); //Ejecutamos la consulta.
        } catch (PDOException $exception) {
            $consulta = null; //Destruimos la consulta.
            //echo $exception->getMessage();
        } finally {
            unset($miDB);
            return $consulta;
        }
    }

    //La contraseña se pasará ya 
    public static function usuarioExiste($usuario, $contrasena) {
        try {
            $miDB = new PDO(DSN, USER, PASSWORD);
            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $consulta = $miDB->prepare("Select * from Usuario where CodUsuario= ? and Password=?");
            $consulta->execute([$usuario, $contrasena]);
            if ($consulta  && $consulta ->rowCount() > 0) {
                return 1;
            } else {
                return 0;
            }
        } catch (Exception $e) {
            return 0;
        } finally {
            unset($miDB);
        }
    }

}

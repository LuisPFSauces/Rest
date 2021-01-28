<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UsuarioPDO
 *
 * @author Luis
 */
class UsuarioPDO {

    public static function validadUsuario($usuario, $contrasena) {
        $statement = "Select * from Usuario where CodUsuario= ? and Password=?";
        $consulta = DBPDO::ejecutaConsulta($statement, [$usuario, $contrasena]);
        if (!is_null($consulta) && $consulta->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function buscar() {
        $statement = "Select * from Persona";
        $consulta = DBPDO::ejecutaConsulta($statement, []);
        if (!is_null($consulta) && $consulta->rowCount() > 0) {
            $personas = [];
            while ($oPersona = $consulta->fetchObject()) {
                $persona = [
                    "id" => $oPersona->ID,
                    "nombre" => $oPersona->Nombre,
                    "descripcion" => $oPersona->Descripcion,
                    "edad" => $oPersona->Edad
                ];
                $personas[] = $persona;
            }
            return $personas;
        } else {
            return [];
        }
    }

    public static function buscarPorId($id) {
        $statement = "Select * from Persona where ID=?";
        $consulta = DBPDO::ejecutaConsulta($statement, [$id]);
        if (!is_null($consulta) && $consulta->rowCount() > 0) {
            $oPersona = $consulta->fetchObject();
            return[
                "id" => $oPersona->ID,
                "nombre" => $oPersona->Nombre,
                "descripcion" => $oPersona->Descripcion,
                "edad" => $oPersona->Edad
            ];
        } else {
            return [];
        }
    }

    public static function buscarPorArgumentos($argumentos) {
        $statement = "Select * from Persona";
        if (count($argumentos) == 1) {
            if (array_key_exists("limite", $argumentos)) {
                $statement .= " limit " . $argumentos["limite"];
            } else {
                $statement .= " where " . array_key_first($argumentos) . "=:" . array_key_first($argumentos);
            }
        } else {
            $statement .= " where ";
            if (array_key_exists("limite", $argumentos)) {
                $limite = $argumentos["limite"];
                unset($argumentos["limite"]);
            }

            foreach (array_keys($argumentos) as $clave) {
                $statement .= " $clave=:$clave";
                if (array_key_last($argumentos) != $clave) {
                    $statement .= " and";
                }
            }
            if (isset($limite)) {
                $statement .= " limit " . $limite;
                unset($limite);
            }
        }
        $consulta = DBPDO::ejecutaConsulta($statement, $argumentos);
        if (!is_null($consulta) && $consulta->rowCount() > 0) {
            $personas = [];
            while ($oPersona = $consulta->fetchObject()) {
                $persona = [
                    "id" => $oPersona->ID,
                    "nombre" => $oPersona->Nombre,
                    "descripcion" => $oPersona->Descripcion,
                    "edad" => $oPersona->Edad
                ];
                $personas[] = $persona;
            }
            return $personas;
        } else {
            return [];
        }
    }

    private static function actualizarStatement($argumentos) {
        $statement = "Update Persona set ";
        $id = $argumentos["ID"];
        unset($argumentos["ID"]);
        foreach (array_keys($argumentos) as $clave) {
            $statement .= " $clave=:$clave";
            if (array_key_last($argumentos) != $clave) {
                $statement .= ",";
            }
        }
        $statement .= " where ID=:ID";
        $argumentos['ID'] = $id;
        return $statement;
    }

    public static function actualizar($argumentos) {
        if (array_key_exists("ID", $argumentos)) {
            $statement = self::actualizarStatement($argumentos);
            $consulta = DBPDO::ejecutaConsulta($statement, $argumentos);
            if (is_null($consulta)) {
                return false;
            }
        } else {
            return null;
        }
        return true;
    }

    public static function actualizarVarios($argumentos) {
        foreach ($argumentos as $valor) {
            if (array_key_exists("ID", $valor)) {
                $statement = self::actualizarStatement($valor);
                $consulta = DBPDO::ejecutaConsulta($statement, $valor, 1);
                if (is_null($consulta)) {
                    DBPDO::transaccion(2);
                    return false;
                }
            } else {
                DBPDO::transaccion(2);
                return false;
            }
        }
        DBPDO::transaccion(0);
        return true;
    }

    public static function borrar($id) {
        $statement = "Delete from Persona where ID=?";
        $consulta = DBPDO::ejecutaConsulta($statement, [$id]);
        if (!is_null($consulta)) {
            return true;
        } else {
            return false;
        }
    }

    public static function borrarVarios($argumentos) {
        for ($posicion = 0; $posicion < count($argumentos); $posicion++) {
            if (isset($argumentos[$posicion]["ID"])) {
                $statement = "Delete from Persona where ID=?";
                $consulta = DBPDO::ejecutaConsulta($statement, [$argumentos[$posicion]["ID"]], 1);
                if (is_null($consulta)) {
                    DBPDO::transaccion(2);
                    return false;
                }
            } else {
                DBPDO::transaccion(2);
                return false;
            }
        }
        DBPDO::transaccion(0);
        return true;
    }

    private static function crearStatement($argumentos) {
        $statement = "Insert into Persona ( ";
        foreach (array_keys($argumentos) as $clave) {
            $statement .= "$clave";
            if (array_key_last($argumentos) != $clave) {
                $statement .= ", ";
            }
        }
        $statement .= " ) VALUES (";
        foreach (array_keys($argumentos) as $clave) {
            $statement .= ":$clave";
            if (array_key_last($argumentos) != $clave) {
                $statement .= ", ";
            }
        }
        $statement .= " )";
        return $statement;
        //return DBPDO::ejecutaConsulta($statement, $argumentos, 1);
    }

    private static function comprobarID($id) {
        $statement = "Select * from Persona where ID=?";
        $consulta = DBPDO::ejecutaConsulta($statement, [$id]);
        if (!is_null($consulta) && $consulta->rowCount() == 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function crear($argumentos) {
        if (array_key_exists("ID", $argumentos) && self::comprobarID($argumentos["ID"])) {
            $statement = self::crearStatement($argumentos);
            $consulta = DBPDO::ejecutaConsulta($statement, $argumentos);
            if (!is_null($consulta)) {
                return true;
            } else {
                 return true;
            }
        } else {
            return false;
        }
    }

    public static function crearVarios($argumentos) {
        foreach ($argumentos as $valor) {
            if (array_key_exists("ID", $valor) && self::comprobarID($valor["ID"])) {
                $statement = self::crearStatement($valor);
                $consulta = DBPDO::ejecutaConsulta($statement, $valor, 1);
                if (is_null($consulta)) {
                    DBPDO::transaccion();
                    return false;
                }
            } else {
                DBPDO::transaccion(2);
                return false;
            }
        }
        DBPDO::transaccion(0);
        return true;
    }

}

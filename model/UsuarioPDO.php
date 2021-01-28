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

    public static function buscarPorId($id) {
        $statement = "Select * from Persona where ID=?";
        $consulta = DBPDO::ejecutaConsulta($statement, [$id]);
        if (!is_null($consulta) && $consulta && $consulta->rowCount() > 0) {
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
                $statement .= " where " . array_key_first($pruebas) . "=?";
            }
        } else {
            $statement .= " where ";
            if (array_key_exists("limite", $argumentos)) {
                $limite = $argumentos["limite"];
                unset($argumentos["limite"]);
            }

            foreach (array_keys($argumentos) as $llave) {
                $statement .= " $llave=:$llave";
                if (array_key_last($argumentos) != $llave) {
                    $statement .= " and";
                }
            }
            if (isset($limite)) {
                $statement .= " limit " . $limite;
                unset($limite);
            }
        }
        $consulta = DBPDO::ejecutaConsulta($statement, $argumentos);

        if (!is_null($consulta) && $consulta && $consulta->rowCount() > 0) {
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
        var_dump($argumentos);
        $statement = "Update Persona set ";
        $id = $argumentos["ID"];
        unset($argumentos["ID"]);
        foreach (array_keys($argumentos) as $llave) {
            $statement .= " $llave=:$llave";
            if (array_key_last($argumentos) != $llave) {
                $statement .= ",";
            }
        }
        $statement .= " where ID=:id";
        $argumentos['ID'] = $id;
        return $statement;
    }

    public static function actualizar($argumentos) {
        if (array_key_exists("ID", $argumentos)) {
            echo self::actualizarStatement($argumentos);
        } else {
            return null;
        }
    }

    public static function actualizarVarios($argumentos) {
        foreach ($argumentos as $valor) {
            if (array_key_exists("ID", $valor)) {
                echo self::actualizarStatement($valor);
            } else {
                return null;
            }
        }
    }
    
    public static function borrar() {
        
    }

}

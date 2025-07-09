<?php
class Conexion
{
    private $mysqlConexion;
    private $resultado;

    public function abrirConexion()
    {
        $this->mysqlConexion = new mysqli("localhost", "root", "", "saludhoy");
        $this->mysqlConexion->set_charset("utf8");

        //Verificar si hay errores de conexion
        if ($this->mysqlConexion->connect_error) {
            die("Error de conexion: " . $this->mysqlConexion->connect_error);
        }
    }

    public function ejecutarConsulta($sentenciaSQL)
    {
        try {
            $this->resultado = $this->mysqlConexion->query($sentenciaSQL);

            if ($this->resultado === false) {
                throw new Exception("Error en la consulta" . $this->mysqlConexion->error . " | Consulta: " . $sentenciaSQL);
            }
            return $this->resultado;
        } catch (PDOException $e) {
            throw new Exception("Error al ejecutar la consulta: " . $e->getMessage());
        }
    }

    public function siguienteRegistro()
    {
        // Devuelve el siguiente registro, o null si no hay más registros
        return $this->resultado ? $this->resultado->fetch_row() : null;
    }

    public function obtenerLlaveAutonumerica()
    {
        return $this->mysqlConexion->insert_id;
    }

    public function cerrarConexion()
    {
        $this->mysqlConexion->close();
    }

    public function numeroFilas()
    {
        return $this->resultado ? $this->resultado->num_rows : 0;
    }

    public function ejecutarConsultaConId($sql)
    {
        $resultado = $this->mysqlConexion->query($sql);
        if ($resultado) {
            return $this->mysqlConexion->insert_id;
        }
        return false;
    }
}
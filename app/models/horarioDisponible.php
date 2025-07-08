<?php
require_once(__DIR__ . '/../config/conexion.php');
require_once(__DIR__ . '/../dao/HorarioDisponibleDAO.php');

class HorarioDisponible
{
    private $idHorarioDisponible;
    private $idPersona;
    private $fechaHorario;

    public function getIdHorarioDisponible()
    {
        return $this->idHorarioDisponible;
    }
    public function setIdHorarioDisponible($idHorarioDisponible)
    {
        $this->idHorarioDisponible = $idHorarioDisponible;
    }

    public function getIdPersona()
    {
        return $this->idPersona;
    }
    public function setIdPersona($idPersona)
    {
        $this->idPersona = $idPersona;
    }

    public function getFechaHorario()
    {
        return $this->fechaHorario;
    }
    public function setFechaHorario($fechaHorario)
    {
        $this->fechaHorario = $fechaHorario;
    }

    public function __construct($idHorarioDisponible = 0, $idPersona = 0, $fechaHorario = "")
    {
        $this->idHorarioDisponible = $idHorarioDisponible;
        $this->idPersona = $idPersona;
        $this->fechaHorario = $fechaHorario;
    }

    public function consultarPorId()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $dao = new HorarioDisponibleDAO($this->idHorarioDisponible);
        $conexion->ejecutarConsulta($dao->consultarPorId());

        if ($conexion->numeroFilas() == 0) {
            $conexion->cerrarConexion();
            return false;
        }

        $registro = $conexion->siguienteRegistro();
        $this->idPersona = $registro[0];
        $this->fechaHorario = $registro[1];
        $conexion->cerrarConexion();
        return true;
    }

    public function consultarTodos()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $dao = new HorarioDisponibleDAO();
        $conexion->ejecutarConsulta($dao->consultarTodos());

        $lista = array();
        while ($registro = $conexion->siguienteRegistro()) {
            $obj = new HorarioDisponible($registro[0], $registro[1], $registro[2]);
            array_push($lista, $obj);
        }
        $conexion->cerrarConexion();
        return $lista;
    }
    public function comprobacionDisponibilidad($fecha, $id_medico)
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $dao = new HorarioDisponibleDAO();

        // Obtener disponibilidad
        $rs1 = $conexion->ejecutarConsulta($dao->consultarPorFecha($fecha, $id_medico)); // Disponibles
        $rs2 = $conexion->ejecutarConsulta($dao->consultarYa($fecha, $id_medico)); // Citas

        $lista = array();

        // Convertir a arrays de búsqueda rápida
        $disponibles = array();
        if (!empty($rs1)) {
            foreach ($rs1 as $fila1) {
                $hora = substr($fila1['fecha_horario'], 11, 8); // Extrae HH:MM:SS
                $disponibles[$hora] = true;
            }
        }

        $ocupadas = array();
        if (!empty($rs2)) {
            foreach ($rs2 as $fila2) {
                $hora = substr($fila2['fecha_cita'], 11, 8);
                $ocupadas[$hora] = true;
            }
        }

        // Generar las 24 horas con su estado
        for ($h = 0; $h < 24; $h++) {
            $hora = str_pad($h, 2, '0', STR_PAD_LEFT) . ':00:00';

            if (isset($ocupadas[$hora])) {
                $estado = 1; // Ocupada (rojo)
            } elseif (isset($disponibles[$hora])) {
                $estado = 2; // Disponible (verde)
            } else {
                $estado = 0; // No habilitada (gris)
            }

            $lista[] = ['hora' => $hora, 'estado' => $estado];
        }

        $conexion->cerrarConexion();
        return $lista;
    }
    
    public function guardarFranjaHoraria($horas, $fecha, $id_medico) {
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $dao = new HorarioDisponibleDAO();

        foreach ($horas as $hora) {
            $hora_inicio = $hora['hora'];
            $estado = $hora['estado'];

            if ($estado == 1) {
                // Si es habilitado (o modificado a habilitado), INSERT o UPDATE
                $conexion->ejecutarConsulta($dao->insertar($fecha, $hora_inicio, $id_medico));
            } else {
                // Si está deshabilitado, verificar primero si existía en la base de datos
                $existe = $conexion->ejecutarConsulta($dao->franjaHorariaEspecifica($fecha, $hora_inicio, $id_medico));

                if (!empty($existe)) {
                    // Si existe, eliminarla
                    $conexion->ejecutarConsulta($dao->eliminar($fecha, $hora_inicio, $id_medico));
                }
                // Si no existe, no hace nada
            }

        }

        $conexion->cerrarConexion();
        return true;
    }


}
?>

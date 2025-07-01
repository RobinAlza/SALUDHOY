<?php
require_once(__DIR__ . '/../config/conexion.php');
require_once(__DIR__ . '/../dao/medicoDAO.php');
require_once(__DIR__ . '/../models/persona.php');


class Medico extends Persona
{
    private $idEspecializacion;
    private $id_medico=0;

    public function getIdEspecializacion()
    {
        return $this->idEspecializacion;
    }
    public function setIdEspecializacion($idEspecializacion)
    {
        $this->idEspecializacion = $idEspecializacion;
    }
    public function getIdMedico()
    {
        return $this->id_medico;
    }
    public function setIdMedico($id_medico)
    {
        $this->id_medico = $id_medico;
    }


    public function __construct($numeroIdentificacion = 0, $idTipoIdentificacion = 0, $nombre = "", $apellido = "", $direccion = "", $idMunicipioResidencia = 0, $fechaNacimiento = "", $clave = "", $idEspecializacion = 0, $id_medico = 0)
    {
        parent::__construct($numeroIdentificacion, $idTipoIdentificacion, $nombre, $apellido, $direccion, $idMunicipioResidencia, $fechaNacimiento, $clave);
        $this->idEspecializacion = $idEspecializacion;
        $this->id_medico = $id_medico;
    }



    public function autenticar()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $medicoDAO = new MedicoDAO(null, null, $this->nombre, null, null, null, null, $this->clave, null);
        $conexion->ejecutarConsulta($medicoDAO->autenticar());
        if ($conexion->numeroFilas() == 0) {
            $conexion->cerrarConexion();
            return false;
        }
        $registro = $conexion->siguienteRegistro();
        $this->numeroIdentificacion = $registro[0];
        $this->consultar();
        $conexion->cerrarConexion();
        return true;
    }
    public function consultar()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $medicoDAO = new MedicoDAO($this->numeroIdentificacion);
        $conexion->ejecutarConsulta($medicoDAO->consultar());

        $registro = $conexion->siguienteRegistro();

        if ($registro) {
            // tipo_identificacion
            $tipoIdentificacion = new TipoIdentificacion($registro[1]);
            $tipoIdentificacion->consultarPorId();

            // municipio_residencia
            $municipio = new MunicipioResidencia($registro[5]);
            $municipio->consultarPorId();

            // especializacion
            $especializacion = new Especializacion($registro[8]);
            $especializacion->consultarPorId();

            // teléfonos
            $telefonos = (new TelefonoPersona($registro[0], null))->consultarNumeros();

            // Asignar atributos al objeto actual
            $this->numeroIdentificacion = $registro[0];
            $this->idTipoIdentificacion = $tipoIdentificacion;
            $this->nombre = $registro[2];
            $this->apellido = $registro[3];
            $this->direccion = $registro[4];
            $this->idMunicipioResidencia = $municipio;
            $this->fechaNacimiento = $registro[6];
            $this->clave = $registro[7];
            $this->idEspecializacion = $especializacion;
            $this->id_medico = $registro[9];
        }
        $conexion->cerrarConexion();

        $medicoDAO->__construct(
            $this->numeroIdentificacion,
            $this->idTipoIdentificacion->getIdTipoIdentificacion(),
            $this->nombre,
            $this->apellido,
            $this->direccion,
            $this->idMunicipioResidencia->getIdMunicipioResidencia(),
            $this->fechaNacimiento,
            $this->clave,
            $this->idEspecializacion->getIdEspecializacion(),
            $this->id_medico
        );


    }


    public function consultarPorId()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $dao = new MedicoDAO($this->numeroIdentificacion);
        $conexion->ejecutarConsulta($dao->consultarPorId());

        if ($conexion->numeroFilas() == 0) {
            $conexion->cerrarConexion();
            return false;
        }

        $registro = $conexion->siguienteRegistro();
        $this->idTipoIdentificacion = $registro[0];
        $this->nombre = $registro[1];
        $this->apellido = $registro[2];
        $this->direccion = $registro[3];
        $this->idMunicipioResidencia = $registro[4];
        $this->fechaNacimiento = $registro[5];
        $this->clave = $registro[6];
        $this->id_medico= $registro[7];
        $conexion->cerrarConexion();
        return true;
    }

    public static function listarMedicos()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $dao = new MedicoDAO();
        $conexion->ejecutarConsulta($dao->listarMedicos());

        $medicos = [];

        while ($registro = $conexion->siguienteRegistro()) {
            $medico = new Medico();
            $medico->setNumeroIdentificacion($registro[0]);
            $medico->setIdTipoIdentificacion($registro[1]);
            $medico->setNombre($registro[2]);
            $medico->setApellido($registro[3]);
            $medico->setDireccion($registro[4]);
            $medico->setIdMunicipioResidencia($registro[5]);
            $medico->setFechaNacimiento($registro[6]);
            $medicos[] = $medico;
        }

        $conexion->cerrarConexion();
        return $medicos;
    }


    public static function listarPorEspecialidad($idEspecializacion)
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $dao = new MedicoDAO(null, null, null, null, null, null, null, null, $idEspecializacion);
        $conexion->ejecutarConsulta($dao->listarPorEspecialidad());

        $medicos = [];

        while ($registro = $conexion->siguienteRegistro()) {
            $medico = new Medico();
            $medico->setNumeroIdentificacion($registro[0]);
            $medico->setNombre($registro[1]);
            $medico->setApellido($registro[2]);
            $medicos[] = $medico;
        }


        $conexion->cerrarConexion();
        return $medicos;
    }

    public function consultarTodos()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $dao = new MedicoDAO();
        $conexion->ejecutarConsulta($dao->consultarTodos());

        $lista = array();
        while ($registro = $conexion->siguienteRegistro()) {
            $obj = new Medico(
                $registro[0],
                $registro[1],
                $registro[2],
                $registro[3],
                $registro[4],
                $registro[5],
                $registro[6],
                $registro[7],

            );
            array_push($lista, $obj);
        }
        $conexion->cerrarConexion();
        return $lista;
    }

    public function consultarPorNombre()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $medicoDAO = new MedicoDAO(null, null, $this->nombre);
        $conexion->ejecutarConsulta($medicoDAO->consultarPorNombre());

        $tiposIdentificacion = [];
        $municipios = [];
        $especializaciones = [];
        $medicos = [];

        while ($registro = $conexion->siguienteRegistro()) {
            // tipo_identificacion
            $tipoIdentificacion = null;
            if (array_key_exists($registro[1], $tiposIdentificacion)) {
                $tipoIdentificacion = $tiposIdentificacion[$registro[1]];
            } else {
                $tipoIdentificacion = new TipoIdentificacion($registro[1]);
                $tipoIdentificacion->consultarPorId();
                $tiposIdentificacion[$registro[1]] = $tipoIdentificacion;
            }

            // municipio_residencia
            $municipio = null;
            if (array_key_exists($registro[5], $municipios)) {
                $municipio = $municipios[$registro[5]];
            } else {
                $municipio = new MunicipioResidencia($registro[5]);
                $municipio->consultarPorId();
                $municipios[$registro[5]] = $municipio;
            }

            // especializacion
            $especializacion = null;
            if (array_key_exists($registro[8], $especializaciones)) {
                $especializacion = $especializaciones[$registro[8]];
            } else {
                $especializacion = new Especializacion($registro[8]);
                $especializacion->consultarPorId();
                $especializaciones[$registro[8]] = $especializacion;
            }

            // teléfonos
            $telefonos = (new TelefonoPersona($registro[0], null))->consultarNumeros();

            // crear paciente
            $medico = new Medico(
                $registro[0], // numero_identificacion
                $tipoIdentificacion,
                $registro[2], // nombre
                $registro[3], // apellido
                $registro[4], // direccion
                $municipio,
                $registro[6], // fecha_nacimiento
                $registro[7], // clave
                $especializacion,
                $registro[9] // id_medico
            );

            array_push($medicos, $medico);
        }

        $conexion->cerrarConexion();
        return $medicos;
    }
    public function guardar()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();

        $medicoDAO = new MedicoDAO(
            $this->numeroIdentificacion,
            $this->idTipoIdentificacion,
            $this->nombre,
            $this->apellido,
            $this->direccion,
            $this->idMunicipioResidencia,
            $this->fechaNacimiento,
            $this->clave,
            $this->idEspecializacion,
        );
        $conexion->ejecutarConsulta($medicoDAO->guardarPersona());
        $conexion->ejecutarConsulta($medicoDAO->guardarMedico());
        $conexion->cerrarConexion();

        return $this->numeroIdentificacion;
    }

    public function actualizar()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();

        $medicoDAO = new MedicoDAO(
            $this->numeroIdentificacion,
            $this->idTipoIdentificacion,
            $this->nombre,
            $this->apellido,
            $this->direccion,
            $this->idMunicipioResidencia,
            $this->fechaNacimiento,
            $this->clave,
            $this->idEspecializacion,
        );
        $conexion->ejecutarConsulta($medicoDAO->ActualizarPersona());
        $conexion->ejecutarConsulta($medicoDAO->ActualizarMedico());
        $conexion->cerrarConexion();

        return $this->numeroIdentificacion;
    }
    //funcion para velificar la fecha minima posible de egendacioncion de citas 
    public function fechaMin(){ 
        $feachaMin=0;
        $conexion=new Conexion();
        $conexion->abrirConexion();
        $medicoDAO=new MedicoDAO();
        $conexion->ejecutarConsulta($medicoDAO->fechaMinima());
        $registro=$conexion->siguienteRegistro();
        if($registro){
            $feachaMin=$registro[0];
        }else{
            $feachaMin=date('Y')+1;
        }
        $conexion->cerrarConexion();

        return $feachaMin;

    }

}


    <?php
    require_once(__DIR__ . '/../config/conexion.php');
    require_once(__DIR__ . '/../dao/TelefonoPersonaDAO.php');

    class TelefonoPersona
    {
        private $idPersona;
        private $telefono;

        public function getIdPersona()
        {
            return $this->idPersona;
        }
        public function setIdPersona($idPersona)
        {
            $this->idPersona = $idPersona;
        }

        public function getTelefono()
        {
            return $this->telefono;
        }
        public function setTelefono($telefono)
        {
            $this->telefono = $telefono;
        }

        public function __construct($idPersona = 0, $telefono = "")
        {
            $this->idPersona = $idPersona;
            $this->telefono = $telefono;
        }

        public function consultarPorId()
        {
            $conexion = new Conexion();
            $conexion->abrirConexion();
            $dao = new TelefonoPersonaDAO($this->idPersona, $this->telefono);
            $conexion->ejecutarConsulta($dao->consultarPorId());

            if ($conexion->numeroFilas() == 0) {
                $conexion->cerrarConexion();
                return false;
            }

            $registro = $conexion->siguienteRegistro();
            // Aquí solo hay dos campos: id_persona y telefono
            $this->idPersona = $registro[0];
            $this->telefono = $registro[1];
            $conexion->cerrarConexion();
            return true;
        }

        public function consultarTodos()
        {
            $conexion = new Conexion();
            $conexion->abrirConexion();
            $dao = new TelefonoPersonaDAO();
            $conexion->ejecutarConsulta($dao->consultarTodos());

            $lista = array();
            while ($registro = $conexion->siguienteRegistro()) {
                $obj = new TelefonoPersona($registro[0], $registro[1]);
                array_push($lista, $obj);
            }
            $conexion->cerrarConexion();
            return $lista;
        }
        public function consultarNumeros()
        {
            $numeros = array();
            $conexion = new Conexion();
            $conexion->abrirConexion();
            $telefonoDAO = new TelefonoPersonaDAO($this->idPersona, null);
            $conexion->ejecutarConsulta($telefonoDAO->consultarNumeros());
            if ($conexion->numeroFilas() == 0) {
                $conexion->cerrarConexion();
                return $numeros;
            }

            while ($resultado = $conexion->siguienteRegistro()) {
                array_push($numeros, $resultado[0]);
            }
            $conexion->cerrarConexion();
            return $numeros;
        }
        public function guardarNumeros()
        {
            $conexion = new Conexion();
            $telefonoDAO = new TelefonoPersonaDAO($this->idPersona, $this->telefono);
            $conexion->abrirConexion();
            $conexion->ejecutarConsulta($telefonoDAO->guardarNumeros());
            $conexion->cerrarConexion();
        }

        public function actualizarNumeros()
        {
            $conexion = new Conexion();
            $telefonoDAO = new TelefonoPersonaDAO($this->idPersona, $this->telefono);
            $conexion->abrirConexion();
            $conexion->ejecutarConsulta($telefonoDAO->actualizarNumeros());
            $conexion->cerrarConexion();
        }
    }
    ?>
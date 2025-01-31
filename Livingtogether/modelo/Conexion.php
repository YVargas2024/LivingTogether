<?php
// Creamos la clase conexion
class Conexion
{
    // Atributos
    private $host;
    private $user;
    private $pass;
    private $bd;
    private $conexion;

    // Constructor
    public function __construct()
    {
        $this->host = "localhost";
        $this->user = "root";
        $this->pass = "";
        $this->bd = "living_together";

        // Se crea la conexión
        $this->conexion = mysqli_connect($this->host, $this->user, $this->pass, $this->bd);

        // Verificar la conexión
        if (!$this->conexion) {
            die("Error de conexión: " . mysqli_connect_error());
        }
    }

    // Obtener la conexión
    public function getConexion()
    {
        return $this->conexion;
    }

    // Ejecutar consulta sin retorno
    public function consultaSimple($sql)
    {
        mysqli_query($this->conexion, $sql);
    }

    // Ejecutar consulta con retorno
    public function consultaRetorno($sql)
    {
        $resultado = $this->conexion->query($sql); // $this->conexion debe ser tu conexión a la base de datos
        if (!$resultado) {
            die("Error en la consulta: " . $this->conexion->error);
        }
        return $resultado; // Debe devolver un mysqli_result
    }

    // Método para cerrar la conexión
    public function cerrarConexion()
    {
        mysqli_close($this->conexion);
    }

    // Obtener el último ID insertado
    public function ultimoId()
    {
        return mysqli_insert_id($this->conexion);
    }
}

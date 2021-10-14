<?php
require_once dirname(__FILE__) . '/conexion.php';


class Operaciones
{
    private $con;

    public function __construct()
    {
        $db = new Conexion();
        $this->con = $db->connect();
    }

    private function closeCon()
    {
        $this->con = null;
    }

    private function closeStmt(PDOStatement $stmt)
    {
        $stmt->closeCursor();
        $stmt = null;
    }

    private function printError(array $errorInfo)
    {
        //print_r($errorInfo);
    }

    public function loginApoderado($correo, $password)
    {
        $stmt = $this->con->prepare('call loginApoderado(?,?)');
        $stmt->bindParam(1, $correo, PDO::PARAM_STR);
        $stmt->bindParam(2, $password, PDO::PARAM_STR);
        $stmt->execute();
        $this->printError($stmt->errorInfo());
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->closeStmt($stmt);
        return $data;
    }

    public function loginEstudiante($correo, $password)
    {
        $stmt = $this->con->prepare('call loginEstudiante(?,?)');
        $stmt->bindParam(1, $correo, PDO::PARAM_STR);
        $stmt->bindParam(2, $password, PDO::PARAM_STR);
        $stmt->execute();
        $this->printError($stmt->errorInfo());
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->closeStmt($stmt);
        return $data;
    }

    public function apoderados($index, $limit)
    {
        $stmt = $this->con->prepare('call apoderados(?,?)');
        $stmt->bindParam(1, $index, PDO::PARAM_INT);
        $stmt->bindParam(2, $limit, PDO::PARAM_INT);
        $stmt->execute();
        $this->printError($stmt->errorInfo());
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->closeStmt($stmt);
        return $data;
    }

    public function estudiantes($index, $limit)
    {
        $stmt = $this->con->prepare('call estudiantes(?,?)');
        $stmt->bindParam(1, $index, PDO::PARAM_INT);
        $stmt->bindParam(2, $limit, PDO::PARAM_INT);
        $stmt->execute();
        $this->printError($stmt->errorInfo());
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->closeStmt($stmt);
        return $data;
    }

    public function crearNotificacion($idApoderado, $idEstudiante, $titulo, $mensaje)
    {
        $stmt = $this->con->prepare('call crearNotificacion(?,?,?,?)');
        $stmt->bindParam(1, $idApoderado, PDO::PARAM_INT);
        $stmt->bindParam(2, $idEstudiante, PDO::PARAM_INT);
        $stmt->bindParam(3, $titulo, PDO::PARAM_STR);
        $stmt->bindParam(4, $mensaje, PDO::PARAM_STR);
        $stmt->execute();
        $this->printError($stmt->errorInfo());
        if ($stmt->rowCount() > 0) {
            $this->closeStmt($stmt);
            return true;
        }
        return false;
    }

    public function estudiantesApoderado($idApoderado)
    {
        $stmt = $this->con->prepare('call estudiantesApoderado(?)');
        $stmt->bindParam(1, $idApoderado, PDO::PARAM_INT);
        $stmt->execute();
        $this->printError($stmt->errorInfo());
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->closeStmt($stmt);
        return $data;
    }

    public function tfcmEstudianteSubNivel($idSubNivel)
    {
        $stmt = $this->con->prepare('call tfcmEstudianteSubNivel(?)');
        $stmt->bindParam(1, $idSubNivel, PDO::PARAM_INT);
        $stmt->execute();
        $this->printError($stmt->errorInfo());
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->closeStmt($stmt);
        return $data;
    }

    public function tfcmApoderadosSubNivel($idSubNivel, $idapoderado)
    {
        $stmt = $this->con->prepare('call tfcmApoderadosSubNivel(?,?)');
        $stmt->bindParam(1, $idSubNivel, PDO::PARAM_INT);
        $stmt->bindParam(2, $idapoderado, PDO::PARAM_INT);
        $stmt->execute();
        $this->printError($stmt->errorInfo());
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->closeStmt($stmt);
        return $data;
    }

    public function tfcmEstudianteNivel($idNivel)
    {
        $stmt = $this->con->prepare('call tfcmEstudianteNivel(?)');
        $stmt->bindParam(1, $idNivel, PDO::PARAM_INT);
        $stmt->execute();
        $this->printError($stmt->errorInfo());
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->closeStmt($stmt);
        return $data;
    }

    public function tfcmApoderadoNivel($idNivel, $idapoderado)
    {
        $stmt = $this->con->prepare('call tfcmApoderadoNivel(?)');
        $stmt->bindParam(1, $idNivel, PDO::PARAM_INT);
        $stmt->bindParam(2, $idapoderado, PDO::PARAM_INT);
        $stmt->execute();
        $this->printError($stmt->errorInfo());
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->closeStmt($stmt);
        return $data;
    }

    public function notificacionesEstudiante($idEstudiante)
    {
        $stmt = $this->con->prepare('call notificacionesEstudiante(?)');
        $stmt->bindParam(1, $idEstudiante, PDO::PARAM_INT);
        $stmt->execute();
        $this->printError($stmt->errorInfo());
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->closeStmt($stmt);
        return $data;
    }

    public function getNiveles()
    {
        $stmt = $this->con->prepare('call getNiveles()');
        $stmt->execute();
        $this->printError($stmt->errorInfo());
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->closeStmt($stmt);
        return $data;
    }

    public function getSubNiveles($idNivel)
    {
        $stmt = $this->con->prepare('call getSubNiveles(?)');
        $stmt->bindParam(1, $idNivel, PDO::PARAM_INT);
        $stmt->execute();
        $this->printError($stmt->errorInfo());
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->closeStmt($stmt);
        return $data;
    }
}
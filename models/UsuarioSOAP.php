<?php
class Usuario extends Conectar {

    // Insertar un nuevo usuario
    public function insert_usuario($usu_nom, $usu_ape, $usu_correo) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO usuarios (usu_id, usu_nom, usu_ape, usu_correo, est) VALUES (NULL, ?, ?, ?, '1')";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $usu_nom);
        $stmt->bindValue(2, $usu_ape);
        $stmt->bindValue(3, $usu_correo);
        $stmt->execute();
    }

    // Obtener todos los usuarios activos
    public function get_usuarios() {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM usuarios WHERE est = '1'";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function update_usuario($id, $nombre, $apellido, $correo) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE usuarios SET usu_nom = ?, usu_ape = ?, usu_correo = ? WHERE usu_id = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $nombre);
        $stmt->bindValue(2, $apellido);
        $stmt->bindValue(3, $correo);
        $stmt->bindValue(4, $id);
        $stmt->execute();
    }
    
    public function delete_usuario($id) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "DELETE FROM usuarios WHERE usu_id = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
    }

    public function buscar_usuario($nombre) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM usuarios WHERE usu_nom LIKE ? AND est = '1'";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, "%$nombre%");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna un solo usuario que coincida
    }
    


}
?>

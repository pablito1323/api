<?php
class clientes extends Conectar {
    public function get_cliente() {
        $conectar= parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `clientes` ;";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado=$sql->fetchAll();
    }
    public function get_cliente_x_id($cat_id) {
        $conectar= parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `clientes` where id_cliente  = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $cat_id);
        $sql->execute();
        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert_cliente($nombre_cliente, $correo, $telefono, $direccion) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO `clientes` (`id_cliente`, `nombre_cliente`, `correo`, `telefono`, `direccion`) 
                VALUES (NULL, ?, ?, ?, ?);";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $nombre_cliente);
        $sql->bindValue(2, $correo);
        $sql->bindValue(3, $telefono);
        $sql->bindValue(4, $direccion);
        $sql->execute();
        return $sql->rowCount(); // Devuelve el número de filas afectadas
    }
    

    public function update_cliente($id_cliente, $nombre_cliente, $correo, $telefono, $direccion) {
        $conectar= parent::conexion();
        parent::set_names();
        $sql = "UPDATE clientes set
          nombre_cliente = ?, 
            correo = ?, 
            telefono = ?, 
            direccion = ?
            WHERE id_cliente = ?";
       
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $nombre_cliente);
        $sql->bindValue(2, $correo);
        $sql->bindValue(3, $telefono);
        $sql->bindValue(4, $direccion);
        $sql->bindValue(5, $id_cliente);
        $sql->execute();
        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function delete_cliente($id_cliente) {
        $conectar = parent::conexion();
        parent::set_names();
    
        // Eliminar la categoría de la base de datos
        $sql = "DELETE FROM clientes WHERE id_cliente = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_cliente);
        $sql->execute();
    
        // Comprobamos si la eliminación afectó alguna fila
        if ($sql->rowCount() > 0) {
            return ["mensaje" => "Categoría eliminada correctamente"];
        } else {
            return ["error" => "No se pudo eliminar la categoría, no existe o ya fue eliminada"];
        }
    }


}
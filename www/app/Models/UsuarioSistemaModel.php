<?php
declare(strict_types=1);
namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class UsuarioSistemaModel extends BaseDbModel
{
    public function getByUsername(string $username):array | false
    {
        $sql = "SELECT * FROM usuario_sistema WHERE nombre = :username AND baja = 0 ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['username' => $username]);
        return $stmt->fetch();
    }

    public function updateDate(string $username):bool
    {
        $sql = " UPDATE usuario_sistema SET last_date = NOW() WHERE nombre = :username";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['username' => $username]);
    }

    public function getAllUsers():array
    {
        $sql = "SELECT us.*, r.rol
                FROM usuario_sistema us 
                LEFT JOIN rol r ON r.id_rol = us.id_rol ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function cambiarCampoBaja(int $idUsuario):bool
    {
        $sql = " UPDATE usuario_sistema SET baja = NOT baja WHERE id_usuario = :idUsuario";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['idUsuario' => $idUsuario]);
    }

    public function deleteUser(int $idUsuario):bool
    {
        $sql = "DELETE FROM usuario_sistema WHERE id_usuario = :idUsuario";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['idUsuario' => $idUsuario]);
    }

    public function getById(int $idUsuario):array | false
    {
        $sql = "SELECT * FROM usuario_sistema WHERE id_usuario = :idUsuario";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['idUsuario' => $idUsuario]);
        return $stmt->fetch();
    }


    public function getByName(string $nombre):array | false
    {
        $sql = "SELECT * FROM usuario_sistema WHERE nombre = :nombre";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['nombre' => $nombre]);
        return $stmt->fetch();
    }

    public function getByEmail(string $email):array | false
    {
        $sql = "SELECT * FROM usuario_sistema WHERE nombre = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    public function insertarUsuario(array $data):bool
    {
        $sql = " INSERT INTO usuario_sistema (nombre, email, pass, id_rol, idioma,baja) VALUES (:nombre, :email, :pass, :id_rol, :idioma,:baja)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'nombre' => $data['username'],
            'email' => $data['email'],
            'pass' => password_hash($data['pass'], PASSWORD_DEFAULT),
            'id_rol' => $data['id_rol'],
            'idioma' => $data['idioma'],
            'baja'=>0
            ]);
    }

    public function actualizarUsuario(array $data, int $idUsuario):bool
    {
        $sql = "UPDATE usuario_sistema SET nombre = :nombre, email = :email, pass = :pass, id_rol = :id_rol, idioma = :idioma  WHERE id_usuario = :idUsuario";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'nombre' => $data['username'],
            'email' => $data['email'],
            'pass' => password_hash($data['pass'], PASSWORD_DEFAULT),
            'id_rol' => $data['id_rol'],
            'idioma' => $data['idioma'],
            'idUsuario' => $idUsuario
        ]);
    }
}
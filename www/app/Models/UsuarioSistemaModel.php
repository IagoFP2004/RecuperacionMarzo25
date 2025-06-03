<?php
declare(strict_types=1);
namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class UsuarioSistemaModel extends BaseDbModel
{
    public function getByNombre(string $nombre):array | false
    {
        $sql = "SELECT * FROM usuario_sistema WHERE nombre = :nombre AND baja = 0 ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['nombre' => $nombre]);
        return $stmt->fetch();
    }

    public function getAllUsuarios():array
    {
        $sql = "SELECT us.*,r.*
                FROM usuario_sistema us 
                LEFT JOIN rol r ON r.id_rol = us.id_rol ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getByUsername(string $username):array | false
    {
        $sql = "SELECT * FROM usuario_sistema WHERE nombre = :username ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['username' => $username]);
        return $stmt->fetch();
    }

    public function getByEmail(string $email):array | false
    {
        $sql = "SELECT * FROM usuario_sistema WHERE email = :email ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    public function insertarUsuario(array $data): bool
    {
        $sql = "INSERT INTO usuario_sistema (nombre, email, pass, id_rol, idioma)
            VALUES (:nombre, :email, :pass, :id_rol, :idioma)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'nombre' => $data['username'],
            'email' => $data['email'],
            'pass' => password_hash($data['pass'], PASSWORD_DEFAULT),
            'id_rol' => $data['id_rol'],
            'idioma' => $data['idioma']
        ]);
    }
}
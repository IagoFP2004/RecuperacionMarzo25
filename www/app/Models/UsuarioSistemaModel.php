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
}
<?php
declare(strict_types=1);
namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class RolModel extends BaseDbModel
{
    public function getAll():array
    {
        $sql = "SELECT r.* FROM rol r";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getByRol(int $idRol):array | false
    {
        $sql = "SELECT r.* FROM rol r WHERE r.id_rol = :idRol";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':idRol' => $idRol]);
        return $stmt->fetch();
    }
}
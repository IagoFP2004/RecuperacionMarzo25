<?php
declare(strict_types=1);
namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class RolModel extends BaseDbModel
{
    public function getAll():array
    {
        $sql = "SELECT * FROM rol";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById(int $id):array | false
    {
        $sql = "SELECT * FROM rol WHERE id_rol = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
}
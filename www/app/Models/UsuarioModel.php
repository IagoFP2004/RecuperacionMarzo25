<?php
declare(strict_types=1);
namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class UsuarioModel extends BaseDbModel
{
    public function getByUserName(string $nombre): array | false
    {
        $sql = "SELECT * FROM usuario_sistema WHERE nombre = :nombre AND baja = 0";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':nombre', $nombre, \PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
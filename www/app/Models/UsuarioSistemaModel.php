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
}
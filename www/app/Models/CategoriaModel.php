<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

class CategoriaModel extends \Com\Daw2\Core\BaseDbModel
{
    private const SEPARADOR = ' > ';

    function getAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM categoria');
        return $stmt->fetchAll();
    }

    function size(): int
    {
        $stmt = $this->pdo->query('SELECT COUNT(*) FROM categoria');
        return $stmt->fetchColumn(0);
    }

    function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM categoria WHERE id_categoria=?');
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }

    function add(int $id, string $nombre, ?int $idPadre): bool
    {
        try {
            $stmt = $this->pdo->prepare('INSERT INTO categoria(id_categoria, nombre_categoria, id_padre) values (?,?,?)');
            $stmt->execute([
                $id, $nombre, $idPadre]);
            return $stmt->rowCount() > 0;
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    function find(int $id, bool $full = false): false|array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM categoria WHERE id_categoria=?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if($row && $full){
            $row['fullName'] = $row['nombre_categoria'];
            $idpadre = $row['id_padre'];
            while ($idpadre !== null) {
                $padre = $this->find($idpadre, false);
                $row['fullName'] = $padre['nombre_categoria'] . self::SEPARADOR . $row['fullName'];
                $idpadre = $padre['id_padre'];
            }
        }
        return $row;
    }

    function edit(int $id, string $nombre, ?int $id_padre, int $idOriginal): bool
    {
        $stmt = $this->pdo->prepare('UPDATE categoria SET id_categoria=?, nombre_categoria=?, id_padre=? WHERE id_categoria=?');
        return $stmt->execute([$id, $nombre, $id_padre, $idOriginal]);
    }

    /*
     * Con arrays
     */
    public function getAllCategorias() : array{
        $_res = array();
        $stmt = $this->pdo->prepare("SELECT * FROM categoria WHERE id_padre is NULL ORDER BY nombre_categoria");
        $stmt->execute();
        $_categorias = $stmt->fetchAll();
        foreach($_categorias as $c){
            //Si tiene padre lo añadimos a la posición padre del array.
            $c['fullName'] = $c['nombre_categoria'];
            $_res[] = $c;
            $_res = array_merge($_res, $this->getAllCategoriasHijas($c['id_categoria']));
        }
        return $_res;
    }

    private function getAllCategoriasHijas(int $id_padre): array
    {
        $_res = array();
        $stmt = $this->pdo->prepare("SELECT * FROM categoria WHERE id_padre = ? ORDER BY nombre_categoria");
        $stmt->execute([$id_padre]);
        $_cats = $stmt->fetchAll();
        foreach ($_cats as $c) {
            //Si tiene padre lo añadimos a la posición padre del array.
            $categoria = $this->find($c['id_categoria'], true);
            $_res[] = $categoria;
            $_res = array_merge($_res, $this->getAllCategoriasHijas($c['id_categoria']));
        }
        return $_res;
    }

}

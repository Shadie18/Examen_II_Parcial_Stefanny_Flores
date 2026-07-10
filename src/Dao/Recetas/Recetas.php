<?php
namespace Dao\Recetas;
use Dao\Table;

class Recetas extends Table {
    public static function getRecetasRapidas() {
        $sqlstr = "SELECT r.id_receta as idReceta, r.nombre, r.ingrediente_principal as ingredientePrincipal, r.tiempo_preparacion_min as tiempoPreparacionMin, r.tipo_cocina as tipoCocina, r.dificultad FROM RecetasComida r ORDER BY r.tiempo_preparacion_min ASC LIMIT 3";
        $params = [];
        $registros = self::obtenerRegistros($sqlstr, $params);
        return $registros;
    }

    public static function getRecetasDestacadas() {
        $sqlstr = "SELECT r.id_receta as idReceta, r.nombre, r.ingrediente_principal as ingredientePrincipal, r.tiempo_preparacion_min as tiempoPreparacionMin, r.tipo_cocina as tipoCocina, r.dificultad FROM RecetasComida r WHERE r.dificultad = 'DIF'";
        $params = [];
        $registros = self::obtenerRegistros($sqlstr, $params);
        return $registros;
    }

    public static function getRecetasNuevas() {
        $sqlstr = "SELECT r.id_receta as idReceta, r.nombre, r.ingrediente_principal as ingredientePrincipal, r.tiempo_preparacion_min as tiempoPreparacionMin, r.tipo_cocina as tipoCocina, r.dificultad FROM RecetasComida r ORDER BY r.id_receta DESC LIMIT 3";
        $params = [];
        $registros = self::obtenerRegistros($sqlstr, $params);
        return $registros;
    }

    public static function getRecetas(
        string $partialNombre = "",
        string $dificultad = "",
        string $orderBy = "",
        bool $orderDescending = false,
        int $page = 0,
        int $itemsPerPage = 10
    ) {
        $sqlstr = "SELECT r.id_receta as idReceta, r.nombre, r.ingrediente_principal as ingredientePrincipal, r.tiempo_preparacion_min as tiempoPreparacionMin, r.tipo_cocina as tipoCocina, r.dificultad, CASE WHEN r.dificultad = 'FAC' THEN 'Fácil' WHEN r.dificultad = 'MED' THEN 'Media' WHEN r.dificultad = 'DIF' THEN 'Difícil' ELSE 'Sin Asignar' END as dificultadDsc FROM RecetasComida r";
        $sqlstrCount = "SELECT COUNT(*) as count FROM RecetasComida r";
        $conditions = [];
        $params = [];

        if ($partialNombre != "") {
            $conditions[] = "r.nombre LIKE :partialNombre";
            $params["partialNombre"] = "%" . $partialNombre . "%";
        }

        if (!in_array($dificultad, ["FAC", "MED", "DIF", ""])) {
            throw new \Exception("Error Processing Request Dificultad has invalid value");
        }
        if ($dificultad != "") {
            $conditions[] = "r.dificultad = :dificultad";
            $params["dificultad"] = $dificultad;
        }

        if (count($conditions) > 0) {
            $sqlstr .= " WHERE " . implode(" AND ", $conditions);
            $sqlstrCount .= " WHERE " . implode(" AND ", $conditions);
        }

        if (!in_array($orderBy, ["idReceta", "nombre", "tiempoPreparacionMin", ""])) {
            throw new \Exception("Error Processing Request OrderBy has invalid value");
        }
        if ($orderBy != "") {
            $orderColumn = $orderBy;
            if ($orderBy === "idReceta") {
                $orderColumn = "id_receta";
            } elseif ($orderBy === "tiempoPreparacionMin") {
                $orderColumn = "tiempo_preparacion_min";
            }
            $sqlstr .= " ORDER BY " . $orderColumn;
            if ($orderDescending) {
                $sqlstr .= " DESC";
            }
        }

        $numeroDeRegistros = self::obtenerUnRegistro($sqlstrCount, $params)["count"];
        $pagesCount = $itemsPerPage > 0 ? ceil($numeroDeRegistros / $itemsPerPage) : 1;

        if ($pagesCount > 0 && $page > $pagesCount - 1) {
            $page = $pagesCount - 1;
        }
        if ($page < 0) {
            $page = 0;
        }

        $offset = $page * $itemsPerPage;
        $sqlstr .= " LIMIT " . $offset . ", " . $itemsPerPage;

        $registros = self::obtenerRegistros($sqlstr, $params);

        return [
            "recetas" => $registros,
            "total" => $numeroDeRegistros,
            "page" => $page,
            "itemsPerPage" => $itemsPerPage
        ];
    }

    public static function getRecetaById(int $idReceta) {
        $sqlstr = "SELECT r.id_receta as idReceta, r.nombre, r.ingrediente_principal as ingredientePrincipal, r.tiempo_preparacion_min as tiempoPreparacionMin, r.tipo_cocina as tipoCocina, r.dificultad FROM RecetasComida r WHERE r.id_receta = :idReceta";
        $params = ["idReceta" => $idReceta];
        return self::obtenerUnRegistro($sqlstr, $params);
    }

    public static function insertReceta(
        string $nombre,
        string $ingredientePrincipal,
        int $tiempoPreparacionMin,
        string $tipoCocina,
        string $dificultad
    ) {
        $sqlstr = "INSERT INTO RecetasComida (nombre, ingrediente_principal, tiempo_preparacion_min, tipo_cocina, dificultad) VALUES (:nombre, :ingredientePrincipal, :tiempoPreparacionMin, :tipoCocina, :dificultad)";
        $params = [
            "nombre" => $nombre,
            "ingredientePrincipal" => $ingredientePrincipal,
            "tiempoPreparacionMin" => $tiempoPreparacionMin,
            "tipoCocina" => $tipoCocina,
            "dificultad" => $dificultad,
        ];

        return self::executeNonQuery($sqlstr, $params);
    }

    public static function updateReceta(
        int $idReceta,
        string $nombre,
        string $ingredientePrincipal,
        int $tiempoPreparacionMin,
        string $tipoCocina,
        string $dificultad
    ) {
        $sqlstr = "UPDATE RecetasComida SET nombre = :nombre, ingrediente_principal = :ingredientePrincipal, tiempo_preparacion_min = :tiempoPreparacionMin, tipo_cocina = :tipoCocina, dificultad = :dificultad WHERE id_receta = :idReceta";
        $params = [
            "idReceta" => $idReceta,
            "nombre" => $nombre,
            "ingredientePrincipal" => $ingredientePrincipal,
            "tiempoPreparacionMin" => $tiempoPreparacionMin,
            "tipoCocina" => $tipoCocina,
            "dificultad" => $dificultad,
        ];

        return self::executeNonQuery($sqlstr, $params);
    }

    public static function deleteReceta(int $idReceta) {
        $sqlstr = "DELETE FROM RecetasComida WHERE id_receta = :idReceta";
        $params = ["idReceta" => $idReceta];

        return self::executeNonQuery($sqlstr, $params);
    }
}
?>
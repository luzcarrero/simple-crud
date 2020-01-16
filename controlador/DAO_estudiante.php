<?php

class Bd
{

    private $conexion;
    private $bulk;
   
    public function __construct()
    {
        $this->conexion = new MongoDB\Driver\Manager("mongodb://localhost:27017");
        $this->bulk = new MongoDB\Driver\BulkWrite;
    }
    public static function getInstance()
    {
        return new Bd();
    }

    public function insert(Estudiante $estudiante)
    {
        $bulk = new MongoDB\Driver\BulkWrite;
        $arr = array(
            'nombre' => $estudiante->getNombre(),
            'telefono' => $estudiante->getTelefono(),
            'mail' => $estudiante->getMail(),
            'comentario' => $estudiante->getComentario()
        );
        $bulk->insert($arr);
        $this->conexion->executeBulkWrite('Universidad.estudiante', $bulk);
    }

    public function obtenerEstudiantes()
    {

        try {
            $conexion = new MongoDB\Driver\Manager("mongodb://localhost:27017");
            $query = new MongoDB\Driver\Query([], []);
            $rows = $conexion->executeQuery("Universidad.estudiante", $query);
            $arr = [];
            foreach ($rows as $row) {
                $estudiante = new Estudiante($row->nombre, $row->telefono, $row->mail, $row->comentario, $row->_id);
                array_push($arr, $estudiante);
            }
            $l = new ListaEstudiantes($arr);
            return $arr;
        } catch (MongoDB\Driver\Exception\Exception $e) {

            $filename = basename(__FILE__);

            echo "The $filename script has experienced an error.\n";
            echo "It failed with the following exception:\n";

            echo "Exception:", $e->getMessage(), "\n";
            echo "In file:", $e->getFile(), "\n";
            echo "On line:", $e->getLine(), "\n";
        }
    }
    public function delete($id)
    {
        $flag = 0;
        if ($id) {
            $this->bulk->delete(['_id' => new MongoDB\BSON\ObjectID($id)], ['limit' => 1]);
            $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);
            $result = $this->conexion->executeBulkWrite('Universidad.estudiante', $this->bulk, $writeConcern);

            if ($result->getDeletedCount()) {
                $flag = 1;
            } else {
                $flag = 2;
            }
        }
    }

    public function obtenerID($id)
    {
        try {
            $mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");
            $query = new MongoDB\Driver\Query([], ["_id" => $id]);
            $rows =  $mng->executeQuery("Universidad.estudiante", $query);

            foreach ($rows as $row) {
                $estudiante = new Estudiante($row->nombre, $row->telefono, $row->mail, $row->comentario, $row->_id);
            }

            return $estudiante;

        } catch (MongoDB\Driver\Exception\Exception $e) {
            $filename = basename(__FILE__);

            echo "The $filename script has experienced an error.\n";
            echo "It failed with the following exception:\n";

            echo "Exception:", $e->getMessage(), "\n";
            echo "In file:", $e->getFile(), "\n";
            echo "On line:", $e->getLine(), "\n";
        }
    }

    public function update($estudiante, $new)
    {

        $filtro = [
            '_id' => $estudiante->getId()
        ];

        $nuevo = [
            '$set' =>
            [
                'nombre' => $new['nombre'],
                'telefono' => $new['telefono'],
                'mail' => $new['mail'],
                'comentario' => $new['comentario']
            ]
        ];

        $mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");
        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->update($filtro, $nuevo);
        $mng->executeBulkWrite('Universidad.estudiante', $bulk);
    }
}

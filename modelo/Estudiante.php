<?php

class Estudiante
{

    private $id;
    private $nombre;
    private $telefono;
    private $mail;
    private $comentario;
    private $tabla;

    public function __construct($nombre = "", $telefono = "", $mail = "", $comentario = "", $id = "")
    {

        $this->nombre = $nombre;
        $this->telefono = $telefono;
        $this->mail = $mail;
        $this->comentario = $comentario;
        $this->id = $id;
        $this->tabla = "estudiante";
    }


    public function setNombre($nombre)
    {
        return $this->nombre = $nombre;
    }

    public function setMail($mail)
    {
        return $this->mail = $mail;
    }

    public function setComentario($comentario)
    {
        return $this->comentario = $comentario;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getMail()
    {
        return $this->mail;
    }
    public function getTelefono()
    {
        return $this->telefono;
    }
    public function getComentario()
    {
        return $this->comentario;
    }
    public function getId()
    {
        return $this->id;
    }

    public function insertar()
    {

        Bd::getInstance()->insert($this);
    }
    public function delete()
    {

        Bd::getInstance()->delete($this->id);
    }
    public function obtenerID($id)
    {
        Bd::getInstance()->obtenerID($id);
    }
    public function update($id, $estudiante)
    {

        Bd::getInstance()->update($id, $estudiante);
    }
}


class ListaEstudiantes
{

    private $lista = [];

    public function __construct($lista = [])
    {
        $this->lista = $lista;
    }
    public static function getInstance()
    {
        return new listaEstudiantes();
    }
    public static function listaEstudiantes()
    {
        return Bd::obtenerEstudiantes();
    }
    public function getLista()
    {
        return $this->lista;
    }
    public function setLista($lista)
    {
        $this->lista = $lista;
    }
    public  function pintaListaEstudiantes()
    {
        $this->lista = $this->listaEstudiantes();
        $txt = "";
        $txt .= "<tr>";

        foreach ($this->lista as $r) {

            $txt .= "<td>" . $r->getNombre() . "</td>" .
                "<td>" . $r->getTelefono() . "</td> " .
                "<td>" . $r->getMail() . "</td> " .
                "<td>" . $r->getComentario() . "</td> " .
                "<td>" . "<a href='index.php?id=" . $r->getId() . "'>Edit</a>" . "</td> " .
                "<td>" . "<a href='eliminar.php?id=" . $r->getId() . "'>Borrar</a>" . "</td> " . "</tr>";
        }
        return $txt;
    }
}

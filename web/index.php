<?php
require_once '../controlador/DAO_estudiante.php';
require_once '../modelo/Estudiante.php';
$id = "";
$estudiante = new Estudiante();
if (isset($_GET['id']) && !empty($_GET['id'])) {

    $id = $_GET['id'];
    $estudiante = Bd::obtenerID($_GET['id']);

    if (isset($_POST) && !empty($_POST)) {

        BD::update($estudiante, $_POST);
        header("Location: index.php");
    }
} else {
    if (isset($_POST) && !empty($_POST)) {
        $modelo = new Estudiante($_POST['nombre'], $_POST['telefono'], $_POST['mail'], $_POST['comentario']);
        $modelo->insertar();
    }
}

$lista = new ListaEstudiantes();
$lista->listaEstudiantes();

?>
<!DOCTYPE html>


<html>

<head>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
</head>

<body>

    <div class="container">
        <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">Registros MongoDB</div>
                </div>

                <div style="padding-top:30px" class="panel-body">

                    <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>

                    <form action="" method="POST" class=" me form-horizontal " role="form ">


                        <div style="margin-bottom: 25px " class="input-group ">
                            <span class="input-group-addon "><i class="glyphicon glyphicon-user "></i></span>
                            <input id="login-username " type="text " class="form-control " name="nombre" value=" <?php echo $estudiante->getNombre() ?> " placeholder="nombre ">
                        </div>
                        <div style="margin-bottom: 25px " class="input-group ">
                            <span class="input-group-addon "><i class="glyphicon glyphicon-phone "></i></span>
                            <input id="login-username " type="text " class="form-control " name="telefono" value="<?php echo $estudiante->getTelefono() ?> " placeholder="telefono ">
                        </div>
                        <div style="margin-bottom: 25px " class="input-group ">
                            <span class="input-group-addon "><i class="glyphicon glyphicon-envelope "></i></span>
                            <input id="login-username " type="text " class="form-control " name="mail" value="<?php echo $estudiante->getMail() ?> " placeholder="e-mail ">
                        </div>
                        <div style="margin-bottom: 25px " class="input-group ">
                            <span class="input-group-addon "><i class="glyphicon glyphicon-send "></i></span>
                            <textarea type="text " class="form-control " name="comentario" placeholder="comentario "><?php echo $estudiante->getComentario() ?></textarea>
                        </div>

                        <div style="margin-top:10px " class="form-group ">
                            <!-- Button -->

                            <div class="col-sm-12 controls ">
                                <button type="submit " class="btn btn-primary ">Enviar</button>

                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>

    </div>
    <div class="container">
        <table class='main-container table table-bordered'>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Telefono</th>
                    <th>Mail</th>
                    <th>Comentario</th>
                    <th>Editar</th>
                    <th>Borrar</th>
                </tr>
            </thead>
            <?php
            echo $lista->pintaListaEstudiantes();
            ?>
        </table>
    </div>

</body>

</html>
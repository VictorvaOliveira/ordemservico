<!DOCTYPE html>
<html>

<head>
    <title>Ordem de Serviço</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <!--<script type="text/javascript" scr="conteudo/js/sortTable.js"></script>
   <link rel="stylesheet" href="conteudo/css/mainpage.css"> -->
</head>

<body>
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/ordemservico">Ordem de serviço</a>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-1"> </div>
            <?php
            echo $this->session->flashdata('atualizar-ok');
            ?>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="panel panel-default">
                    <div class="panel-heading">Editar ordem de serviço</div>
                    <div class="panel-body">
                        <?php
                        echo validation_errors(
                            "<div class='alert alert-danger alert-dismissible'>
              <a href='#'class='close' data-dismiss='alert' aria-label='close'>&times;</a>",
                            "</div>"
                        );
                        ?>
                        <form action="/ordemservico/projeto/atualizar_os" class="form-horizontal" method="post" id="form">
                            <?php foreach ($getone as $os) { ?>
                                <div class="form-group">
                                    <label for="id" class="control-label col-sm-2">Identificador:</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" name="id" id="id" value="<?php echo $os->id ?>" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="equipamento" class="control-label col-sm-2">Equipamento:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="equipamento" value="<?php echo $os->equipamento ?>" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="describe" class="control-label col-sm-2">Serviço:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="describe" required value="<?php echo $os->servico ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="dateOpen" class="control-label col-sm-2">Data abertura da ordem de serviço:</label>
                                    <div class="col-sm-10">
                                        <input type="date" class="form-control" name="dateOpen" id="dateOpen" required value="<?php echo $os->data_pedido ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="periodo" class="control-label col-sm-2">Periodicidade do serviço:</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="periodo" name="periodo">
                                            <option value="d">Diário</option>
                                            <option value="s">Semanal</option>
                                            <option value="m">Mensal</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-success">Salvar</button>
                                        <a href="/ordemservico" class="btn btn-danger">Cancelar</a>
                                    </div>
                                </div>
                            <?php } ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>

</html>
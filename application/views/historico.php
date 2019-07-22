<!DOCTYPE html>
<html>

<head>
    <title>Ordem de Serviço</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <!--<script type="text/javascript" scr="conteudo/js/sortTable.js"></script>
   <link rel="stylesheet" href="conteudo/css/mainpage.css"> -->
</head>
<style>
    footer {
        background-color: #2d2d30;
        color: #f5f5f5;
        padding: 10px;
    }
</style>

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
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <form method="post" action="<?php echo base_url(); ?>projeto/exportarDados">
<!--                    <input type="submit" id="btnexport" class="btn btn-info" value="Exportar histórico"> -->
                </form>
            </div>
            <div class="col-md-1">
                <p></p>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-1">
                <p></p>
            </div>
            <div class="col-md-10">
                <div class="table-responsive">
                    <table class="table table-striped" id="tableOS">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Equipamento</th>
                                <th>Serviço</th>
                                <th>Data realização</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($historicoOs)) {
                                foreach ($historicoOs as $lista) {
                                    ?>
                                    <tr>
                                        <td><?php echo $lista->id ?></td>
                                        <td><?php echo $lista->equipamento ?></td>
                                        <td><?php echo $lista->servico ?></td>
                                        <td><?php echo date("d/m/Y", strtotime($lista->data_realizacao)); ?></td>
                                    </tr>
                                <?php }
                            } else {
                                echo "<tr><td class='text-center'>Não manutenção prevista para hoje !</td></tr>";
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    $(document).ready(function() {
        $('#tableOS').DataTable({
            "language": {
                "lengthMenu": "_MENU_ Ordens de serviço por página",
                "zeroRecords" : "Menu registro encontrado !",
                "info": "Página _PAGE_ de _PAGES_",
                "search":"Pesquisar:",
                "paginate":{
                    "first":"Primeiro",
                    "last": "Último",
                    "next":"Próximo",
                    "previous":"Anterior"
                }
            }
        });
    });
</script>

</html>
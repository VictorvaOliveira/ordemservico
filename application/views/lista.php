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
<style>
  thead {
    background-color: lightgreen;
  }

  footer {
    background-color: #2d2d30;
    color: white;
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
        <a href="projeto/cadastro" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Nova Ordem de Serviço</a>
      </div>
      <div class="col-md-2">
        <p />
      </div>
      <div class="col-md-3">
        <div class="input-group">
          <span class="input-group-addon">Código OS</span>
          <input type="text" name="inputID" id="inputID" onkeyup="pesquisaID()" class="form-control" placeholder="Exemplo: 1, 2, 3">
        </div>
      </div>
    </div>
  </div>
  </div>
  <br /><br />
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-1"> </div>
      <?php
      echo $this->session->flashdata('cadastro-ok');
      echo $this->session->flashdata('atualizar-ok');
      ?>
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
                <th>Data pedido</th>
                <th>Data realização</th>
                <th onclick="ordenarStatus(5)">Status</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php
              if (!empty($listaos)) {
                foreach ($listaos as $lista) {
                  ?>
                  <tr>
                    <td><?php echo $lista->id ?></td>
                    <td><?php echo $lista->equipamento ?></td>
                    <td><?php echo $lista->servico ?></td>
                    <td><?php echo $lista->data_pedido ?></td>
                    <td><?php echo $lista->data_servico_update ?></td>
                    <td><?php echo $lista->status ?></td>
                    <td><?php echo "<a href='projeto/atualizar/$lista->id' class='btn btn-success' data-toggle='tooltip' title='Confirmar'><span class='glyphicon glyphicon-ok'></span></a>"; ?></td>
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

  <footer class="text-center">Ordem de Serviço</footer>

</body>
<script>
  function ordenarStatus(n) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById("tableOS");
    switching = true;
    //Set the sorting direction to ascending:
    dir = "asc";
    /*Make a loop that will continue until
    no switching has been done:*/
    while (switching) {
      //start by saying: no switching is done:
      switching = false;
      rows = table.rows;
      /*Loop through all table rows (except the
      first, which contains table headers):*/
      for (i = 1; i < (rows.length - 1); i++) {
        //start by saying there should be no switching:
        shouldSwitch = false;
        console.log(rows);
        /*Get the two elements you want to compare,
        one from current row and one from the next:*/
        x = rows[i].getElementsByTagName("TD")[n];
        y = rows[i + 1].getElementsByTagName("TD")[n];
        /*check if the two rows should switch place,
        based on the direction, asc or desc:*/
        if (dir == "asc") {
          if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
            //if so, mark as a switch and break the loop:
            shouldSwitch = true;
            break;
          }
        } else if (dir == "desc") {
          if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
            //if so, mark as a switch and break the loop:
            shouldSwitch = true;
            break;
          }
        }
      }
      if (shouldSwitch) {
        /*If a switch has been marked, make the switch
        and mark that a switch has been done:*/
        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
        switching = true;
        //Each time a switch is done, increase this count by 1:
        switchcount++;
      } else {
        /*If no switching has been done AND the direction is "asc",
        set the direction to "desc" and run the while loop again.*/
        if (switchcount == 0 && dir == "asc") {
          dir = "desc";
          switching = true;
        }
      }
    }
  }

  function pesquisaID() {

    var input, filter, table, tr, td, i, txtValue;

    input = document.getElementById("inputID");
    filter = input.value.toUpperCase();
    table = document.getElementById("tableOS");
    tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td")[0];
      if (td) {
        txtValue = td.textContent || td.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none"
        }
      }
    }
  }

  $(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>

</html>
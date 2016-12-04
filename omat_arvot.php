<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Omat arvaukset</title>
<link rel="stylesheet" href="css/theme.css" />
</head>

<?php
include('menu.php');
?>

<script type="text/javascript">
function checkall(el){
  var ip = document.getElementsByTagName('input'), i = ip.length - 1;
  for (i; i > -1; --i){
    if(ip[i].type && ip[i].type.toLowerCase() === 'checkbox'){
      ip[i].checked = el.checked;
    }
  }
}
</script>

<body>
  <div style="width:100%; float:left">
      <div class="form-row w90 form-header">Nro</div>
        <div class="form-row w100 form-header">Koti</div>
        <div class="form-row w100 form-header">Vieras</div>
        <div class="form-row w90 form-header">1</div>
        <div class="form-row w90 form-header">X</div>
        <div class="form-row w90 form-header last">2</div>
    </div>

    <?php
    include('js/menu.js');
    include('mysql.php');
    $i = 1;
    ?>
    <form action="save.php" method="POST">
    <?php

    while ($i < 14) {
      # code...

    $query_pelit = "SELECT id, home, away FROM `pelit` WHERE id=$i";
    //$res_pelit = mysql_query($query_pelit) or die(mysql_error());
    $res_pelit = mysqli_query($conn, $query_pelit) ;

    $query_arvaus = "SELECT yksi, risti, kaksi FROM `arvaukset` WHERE id=$i";
    //$res_arvaus = mysql_query($query_arvaus) or die(mysql_error());
    $res_arvaus = mysqli_query($conn, $query_arvaus) ;

    //echo $res_pelit['home'];
    $result_1 = mysqli_fetch_array($res_pelit);
    $result_2 = mysqli_fetch_array($res_arvaus);
    //var_dump($result_2);
      ?>
        <div style="clear: left" class="form-row w90">
        <?php echo $result_1["id"]; ?>
        </div>
        <div class="form-row w100">
        <?php echo $result_1["home"]; ?>
        </div>
        <div class="form-row w100">
        <?php echo $result_1["away"]; ?>
        </div>
        <div class="form-row w90">
        <input type="checkbox" name="<?php echo "yksi_" . $i ?>" value="valittu"  <?php
        if ($result_2["yksi"] === '1') { ?> checked <?php } else { }; ?> />
        </div>
        <div class="form-row w90">
        <input type="checkbox" name="<?php echo "risti_" . $i ?>" value="valittu" <?php
        if ($result_2["risti"] === '1') { ?> checked <?php } else { }; ?> />
        </div>
        <div class="form-row w90 last">
        <input type="checkbox" name="<?php echo "kaksi_" . $i ?>" value="valittu" <?php
        if ($result_2["kaksi"] === '1') { ?> checked <?php } else { }; ?> />
        </div>
      <?php

      $i++;
      } ?>
        <div style="clear: left" class="form-row w120 new-row">
        <a href="omat_arvot.php">Peruuta</a>
        </div>
        <div  class="form-row w120 last new-row">
        <input type="submit" value="Tallenna" />
        </div>
        <div  class="form-row w120 last new-row">
        <label>Valitse/poista kaikki: <input type="checkbox" value="" onclick="checkall(this);"></label><br>
        </div>
        </form>
      <?php
?>

</body>
</html>


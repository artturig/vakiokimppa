<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Tilanne</title>
<link rel="stylesheet" href="css/theme.css" />
</head>

<?php
include('menu.php');
?>

<script>

</script>

<body>
  <div style="float:left;">Sivu päivittyy automaattisesti &nbsp</div>
  <div id="timer">1:00</div>
  <div style="width:100%; float:left">
      <div class="form-row w90 form-header">Nro</div>
        <div class="form-row w100 form-header">Koti</div>
        <div class="form-row w100 form-header">Vieras</div>
        <div class="form-row w80 form-header">Alkaa</div>
        <div class="form-row w70 form-header">Tilanne</div>
        <div class="form-row w90 form-header">1</div>
        <div class="form-row w90 form-header">X</div>
        <div class="form-row w90 form-header">2</div>
        <div class="form-row w140 form-header last">Tila</div>
    </div>

    <?php
    include('js/menu.js');
    include('mysql.php');
    $i = 1;
    $osumat = 0;
    ?>

    <?php

    while ($i < 14) {
      # code...

    $query_pelit = "SELECT id, home, away, starts, tila, result FROM `pelit` WHERE id=$i";
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
        <div class="form-row w80">
        <?php
        if ($result_1["starts"] == 'NULL') {
        }
        else {
          echo $result_1["starts"];
        }
        ?>
        </div>
        <div class="form-row w70">
        <?php
        // jos null niin peli ei ole alkanut
        if ($result_1["result"] == 'NULL') {
        }
        else {
          echo $result_1["result"];
        }
        ?>
        </div>

        <div id="d_yksi_<?php echo $i; ?>" class="form-row w90">
        <?php
        if ($result_2["yksi"] === '1')
          { ?> x <?php }
        else { }; ?>
        </div>

        <div id="d_risti_<?php echo $i; ?>" class="form-row w90">
        <?php
        if ($result_2["risti"] === '1') { ?> x <?php }
          else { }; ?>
        </div>

        <div id="d_kaksi_<?php echo $i; ?>" class="form-row w90">
        <?php
        if ($result_2["kaksi"] === '1') { ?> x <?php }
          else { }; ?>
        </div>

        <div id="d_tila_<?php echo $i; ?>" class="form-row w140 last">
        <?php
        // jos null niin peli ei ole alkanut
        if ($result_1["tila"] == 'NULL') {
        }
        elseif ($result_1["tila"] == '[tgre]') {
          echo "Päättynyt";
        }
        else {
          echo "Käynnissä";
        }
        ?>
        </div>
      <?php

      // lasketaan osumien määrä
      if ($result_1["result"] != 'NULL') {
      // erotetaan tulos omiksi muuttujiksi
      list($home_goals, $away_goals) = explode("-", $result_1["result"]);
      //print($home_goals); // ferry
      //print($away_goals); // ferry
        // selvitetään tulostilanne ja värjätään osumat
        if( ( $home_goals - $away_goals ) > '0' ) {
          //echo "ykkönen";
          if ($result_2["yksi"] == '1') {
            //echo "osuma";

            echo '<style type="text/css">
                  #d_yksi_' . $i . ' {
                  background-color: lightgreen;
                  }
                  </style>';

            $osumat++;
          }
        }
        elseif ( ( $home_goals - $away_goals ) == '0') {
          // echo "risti";
          if ($result_2["risti"] == '1') {
            echo '<style type="text/css">
                  #d_risti_' . $i . ' {
                  background-color: lightgreen;
                  }
                  </style>';
            // echo "osuma";
            $osumat++;
          }
        }
        else {
          // echo "kakkonen";
          if ($result_2["kaksi"] == '1') {
            echo '<style type="text/css">
                  #d_kaksi_' . $i . ' {
                  background-color: lightgreen;
                  }
                  </style>';
            // echo "osuma";
            $osumat++;
          }
        }
      }
      else {
      }
      // kasvatetaan ottelunumroa
      $i++;
      } ?>

        <div style="clear: left" class="form-row w200 new-row">
        </div>
        <div  class="form-row w75 new-row">
        <?php echo "Oikein " . $osumat ?>
        </div>
        <div  class="form-row w210 last new-row">
        </div>

      <?php
      include('js/timer.js');
      ?>

</body>
</html>


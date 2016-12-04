<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Omat arvaukset</title>
<link rel="stylesheet" href="css/theme.css" />
</head>
<body>

  <?php
  include('mysql.php');

#  if ($_SERVER['REQUEST_METHOD'] == 'POST')

  $i = 1;
  $sql = "";
  $j = 1;
  $sqlx = "";
  $k = 1;
  $sql2 = "";

// ykkösten läpikäynti alkaa
  while ( $i < 14) {
    //looppaa läpi ykköset ne arvot joissa on alaviiva
    if (isset($_POST["yksi_" . $i]) ) {
      //echo $_POST["yksi_" . $i];
      if ( strcmp($_POST["yksi_" . $i], "valittu" )) {
        //echo "yksi, mutta ei valittu";
      }
      else {
        // päivitä 1 eli valittu jos on valittu
        $sql = "UPDATE arvaukset SET yksi='1' WHERE id='"  . $i . "'  ";
      }
    }
  // ne $i:it joita ei ole eli ei valittu
  else {
        // päivitä 0 jos ei valittu
        $sql = "UPDATE arvaukset SET yksi='0' WHERE id='"  . $i . "'  ";
  }
  $res_name_query = mysqli_query($conn, $sql) ;
  $i++;
}
// ykkösten läpikäynti loppuu

// ristien läpikäynti alkaa
  while ( $j < 14) {
    //looppaa läpi ristit ne arvot joissa on alaviiva
    if (isset($_POST["risti_" . $j]) ) {
      //echo $_POST["risti_" . $j];
      if ( strcmp($_POST["risti_" . $j], "valittu" )) {
        //echo "risti, mutta ei valittu";
      }
      else {
        // päivitä 1 eli valittu jos on valittu
        $sqlx = "UPDATE arvaukset SET risti='1' WHERE id='"  . $j . "'  ";
      }
    }
  // ne $j:it joita ei ole eli ei valittu
  else {
        // päivitä 0 jos ei valittu
        $sqlx = "UPDATE arvaukset SET risti='0' WHERE id='"  . $j . "'  ";
  }
  $res_name_query = mysqli_query($conn, $sqlx) ;
  $j++;
}
// ristien läpikäynti loppuu

// kakkosten läpikäynti alkaa
  while ( $k < 14) {
    //looppaa läpi kakkoset ne arvot joissa on alaviiva
    if (isset($_POST["kaksi_" . $k]) ) {
      //echo $_POST["kaksi_" . $k];
      if ( strcmp($_POST["kaksi_" . $k], "valittu" )) {
        //echo "kaksi, mutta ei valittu";
      }
      else {
        // päivitä 1 eli valittu jos on valittu
        $sqlx = "UPDATE arvaukset SET kaksi='1' WHERE id='"  . $k . "'  ";
      }
    }
  // ne $k:it joita ei ole eli ei valittu
  else {
        // päivitä 0 jos ei valittu
        $sqlx = "UPDATE arvaukset SET kaksi='0' WHERE id='"  . $k . "'  ";
  }
  $res_name_query = mysqli_query($conn, $sqlx) ;
  $k++;
}
// kakkosten läpikäynti loppuu

include('menu.php');
include('js/menu.js');

?>

        <div class="form-row w120 last new-row">
        <div class="btn"><a href="/omat_arvot.php">Palaa takaisin</a></div>
        </div>
</body>
</html>

<?php
$json = json_decode( file_get_contents("http://beta.yle.fi/api/ttvcontent/?a=API_KEY_HERE&p=671&c=true") );

$page = $json->pages[0]->subpages[0]->content;
// Printtaa jsonin content
//print_r( $page );
//echo "<pre>";
// poista [xxx] värikoodit
//$page = preg_replace( "/(\[.+?\])/", "", $page );
// erottele rivivaihdon mukaan
$rows = explode( "\n", $page );

include('mysql.php');

// jos haluaa palauttaa selaimelle
$return = [];
// tulokset array otteluille jotka ovat käynnissä tai päättyneet
$tulos = [];
// peli käynnissä,puoliajalla [tcya] tai loppunut [tgre]
$tila = [];
// ei käynnissä array
$peli_ei_kaynnissa = [];
// pelinumero käytetään id:nä
$i = 1;

foreach ( $rows as $row ) {

  $row = preg_replace("/(\s+)/", " ", trim( $row ) );
  //var_dump($row);

  if ( preg_match("/(\d{1,2}) (.+?)\s?- (.+?)\s?(\d+)-(\d+) ([1X2])/", $row, $matches) ) {
    unset( $matches[0] );
    //echo $i . " ";
    $i++;
    //var_dump($matches);
    $return[] = array_values( $matches );
  }
  // Peli ei ole vielä alkanut
  else if ( preg_match("/(.+?)\s?- (.+?)\s?(\d{2}\.\d{2})/", $row, $matches) ) {

    // käy läpi matches array ja laita ne peli_ei_kaynnissa
    foreach ($matches as $key => $val) {
      $peli_ei_kaynnissa[] = $val;
    }
    // tulosta home, away, start
    /*
    echo $peli_ei_kaynnissa[1];
    echo "<pre>";
    echo $peli_ei_kaynnissa[2];


    echo $peli_ei_kaynnissa[3];
    echo "<pre>";
    */

    // aseta home, away, alkuaika + tulos NULL
    $sql = "UPDATE pelit SET home='" . $peli_ei_kaynnissa[1] . "', away='" . $peli_ei_kaynnissa[2] . "', starts='" . $peli_ei_kaynnissa[3] . "', result='NULL' , tila='NULL' WHERE id='"  . $i . "'  ";
    //echo $sql;
    // päivitä tulokset
    //$res_name_query = mysql_query($sql);
    $res_name_query = mysqli_query($conn, $sql) ;


    unset($GLOBALS['peli_ei_kaynnissa']);
    unset( $matches[0]);
    //echo $i . " ";
    $i++;
    $return[] = array_values( $matches );
  }
   // tulokset
  ##else if ( preg_match("/(.+?)\s?- (.+?)\s?(\d{1}\-\d{1})/", $row, $matches) ) {
  else if ( preg_match("/(.+?)\s?- (.+?)\s?(\[.+?\])(\d{1}\-\d{1})/", $row, $matches) ) {
    // käy läpi matches array ja laita ne tulokseen
    foreach ($matches as $key => $val) {
      $tulos[] = $val;
    }
    //echo $tulos[3];
    // aseta tulos ja väri pelille ja NULL starts
    $sql = "UPDATE pelit SET result= '" . $tulos[4] . "', tila= '" . $tulos[3] . "', starts='NULL' WHERE id='" . $i . "' ";

    //echo $sql;

    //$res_name_query = mysql_query($sql);
    $res_name_query = mysqli_query($conn, $sql) ;
    //print_r($res_name_query);
    //echo "<pre>";
    // nollaa tulokset looppia varten
    unset($GLOBALS['tulos']);
    unset( $matches[0] );
    // printtaa pelin id
    //echo $i  . " ";
    // kasvata pelin id nroa
    $i++;
    //var_dump($matches);
    // lisää palautettavaan arrayhyn
    $return[] = array_values( $matches );
  }
}
// tulosta array
print_r( $return );

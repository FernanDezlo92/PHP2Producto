<?php
  $id_acto = $_GET['id'];
  $actoCo = new ActoCo($conn);

  if(isset($_GET['a']) && $_GET['a'] == 'get') {
    $tDate = $_GET['tDate'] ?? null;
    $fDate = $_GET['fDate'] ?? null;
    $actos = $actoCo->getFiltered($tDate, $fDate, $id_persona);
  } else {
    $actos = $actoCo->getNonFiltered($id_persona);
  }
?>

    
    
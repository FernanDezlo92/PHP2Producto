<?php
  session_start();
  require_once $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/php/initUser.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/ActoCo.php';
  $id_acto = $_GET['id'];
  $actoCo = new ActoCo($conn);
  $inscritos = $actoCo->getInscritosAnonimizado($id_acto);
  $return = "";
  foreach ($inscritos as $ins) {
    $return .= "<tr><td align='left' style='padding-left: 15px; padding-right: 15px;'>" . $ins["Nombre_completo"] . "</td></tr>";
  }
  echo $return;
?>

    
    
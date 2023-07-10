<?php
  session_start();
  require_once $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/php/initUser.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/ActoCo.php';
  $id_acto = $_GET['id'];
  $actoCo = new ActoCo($conn);
  $acto = $actoCo->getByIdRow($id_acto);
  $return = "";
  foreach ($acto as $reg) {
    $return = "<div class=\"form-group\">
                    <div class=\"row\">
                        <div class=\"col\">
                        <label class=\"form-label\" for=\"Fecha\">Fecha</label>
                        <input class=\"form-control\" type=\"date\" placeholder=\"Fecha\" id=\"i-Fecha\" name=\"Fecha\" readonly value=\"" . $reg["Fecha"] . "\"/>
                        </div>
                        <div class=\"col\">
                        <label class=\"form-label\" for=\"Hora\">Hora</label>
                        <input class=\"form-control\" type=\"time\" placeholder=\"Hora\" id=\"i-Hora\" name=\"Hora\" readonly value=\"" . $reg["Hora"] . "\"/>
                        </div>
                    </div>
                </div>
                <div class=\"form-group\">
                    <label class=\"form-label\" for=\"Titulo\">Titulo</label>
                    <input class=\"form-control\" type=\"text\" id=\"i-Titulo\" name=\"Titulo\" readonly value=\"" . $reg["Titulo"] . "\"/>
                </div>
                <div class=\"form-group\">
                    <label class=\"form-label\" for=\"Descripcion_corta\">Descripción corta</label>
                    <textarea class=\"form-control\" rows=\"3\" id=\"i-Descripcion_corta\" name=\"Descripcion_corta\" resize=\"none\" readonly>" . $reg["Descripcion_corta"] . "</textarea>
                </div>
                <div class=\"form-group\">
                    <label class=\"form-label\" for=\"Descripcion_corta\">Descripción larga</label>
                    <textarea class=\"form-control\" rows=\"6\" id=\"i-Descripcion_larga\" name=\"Descripcion_larga\" resize=\"none\" readonly>" . $reg["Descripcion_larga"] . "</textarea>
                </div>
                <div class=\"form-group\">
                    <div class=\"row\">
                        <div class=\"col\">
                            <label class=\"form-label\" for=\"Num_asistentes\">Número de asistentes</label>
                            <input class=\"form-control\" type=\"number\" id=\"i-Num_asistentes\" name=\"Num_asistentes\" readonly value=\"" . $reg["Num_asistentes"] . "\"/>
                        </div>
                        <div class=\"col\">
                            <label class=\"form-label\" for=\"Tipo_acto\">Tipo de acto</label>
                            <input class=\"form-control\" type=\"text\" id=\"i-Tipo_acto\" name=\"Tipo_acto\" readonly value=\"" . $reg["Tipo_acto"] . "\"/>
                        </div>
                    </div>
                </div>";
  }
  echo $return;
?>

    
    
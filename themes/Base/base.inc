<?php

require_once("view-controller.inc");

$app->view(new ViewController());

$app->view()->addCSS("themes/Base" . "/css/bootstrap.css");
$app->view()->addCSS("themes/Base" . "/css/bootstrap.theme.css");
$app->view()->addCSS("themes/Base" . "/css/grid.css");
$app->view()->addCSS("themes/Base" . "/css/override.css");

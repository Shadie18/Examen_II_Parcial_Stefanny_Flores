<?php
namespace Controllers;
use \Dao\Recetas\Recetas as RecetasDao;
use \Views\Renderer as Renderer;
use \Utilities\Site as Site;

class HomeController extends PublicController
{
  public function run(): void
  {
    Site::addLink("public/css/recetas.css");
    $viewData = [];
    $viewData["recetasRapidas"] = RecetasDao::getRecetasRapidas();
    $viewData["recetasDestacadas"] = RecetasDao::getRecetasDestacadas();
    $viewData["recetasNuevas"] = RecetasDao::getRecetasNuevas();
    Renderer::render("home", $viewData);
  }
}
?>
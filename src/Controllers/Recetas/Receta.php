<?php

namespace Controllers\Recetas;

use Controllers\PublicController;
use Views\Renderer;
use Dao\Recetas\Recetas as RecetasDao;
use Utilities\Site;
use Utilities\Validators;

class Receta extends PublicController
{
  private $viewData = [];
  private $mode = "DSP";
  private $modeDescriptions = [
    "DSP" => "Detalle de %s %s",
    "INS" => "Nueva Receta",
    "UPD" => "Editar %s %s",
    "DEL" => "Eliminar %s %s"
  ];
  private $readonly = "";
  private $showCommitBtn = true;
  private $receta = [
    "idReceta" => 0,
    "nombre" => "",
    "ingredientePrincipal" => "",
    "tiempoPreparacionMin" => 0,
    "tipoCocina" => "",
    "dificultad" => "FAC"
  ];
  private $receta_xss_token = "";

  public function run(): void
  {
    try {
      $this->getData();
      if ($this->isPostBack()) {
        if ($this->validateData()) {
          $this->handlePostAction();
        }
      }
      $this->setViewData();
      Renderer::render("Recetas/receta", $this->viewData);
    } catch (\Exception $ex) {
      Site::redirectToWithMsg(
        "index.php?page=Recetas_Recetas",
        $ex->getMessage()
      );
    }
  }

  private function getData()
  {
    $this->mode = $_GET["mode"] ?? "NOF";
    if (isset($this->modeDescriptions[$this->mode])) {
      $this->readonly = $this->mode === "DEL" ? "readonly" : "";
      $this->showCommitBtn = $this->mode !== "DSP";
      if ($this->mode !== "INS") {
        $this->receta = RecetasDao::getRecetaById(intval($_GET["idReceta"]));
        if (!$this->receta) {
          throw new \Exception("No se encontró la Receta", 1);
        }
      }
    } else {
      throw new \Exception("Formulario cargado en modalidad invalida", 1);
    }
  }

  private function validateData()
  {
    $errors = [];
    $this->receta_xss_token = $_POST["receta_xss_token"] ?? "";
    $this->receta["idReceta"] = intval($_POST["idReceta"] ?? "");
    $this->receta["nombre"] = strval($_POST["nombre"] ?? "");
    $this->receta["ingredientePrincipal"] = strval($_POST["ingredientePrincipal"] ?? "");
    $this->receta["tiempoPreparacionMin"] = intval($_POST["tiempoPreparacionMin"] ?? "");
    $this->receta["tipoCocina"] = strval($_POST["tipoCocina"] ?? "");
    $this->receta["dificultad"] = strval($_POST["dificultad"] ?? "");

    if (Validators::IsEmpty($this->receta["nombre"])) {
      $errors["nombre_error"] = "El nombre de la receta es requerido";
    }

    if (Validators::IsEmpty($this->receta["ingredientePrincipal"])) {
      $errors["ingredientePrincipal_error"] = "El ingrediente principal es requerido";
    }

    if (Validators::IsEmpty($this->receta["tiempoPreparacionMin"]) && $this->receta["tiempoPreparacionMin"] <= 0) {
      $errors["tiempoPreparacionMin_error"] = "El tiempo de preparación es requerido y debe ser un valor mayor a cero";
    }

    if (Validators::IsEmpty($this->receta["tipoCocina"])) {
      $errors["tipoCocina_error"] = "El tipo de cocina es requerido";
    }

    if (!in_array($this->receta["dificultad"], ["FAC", "MED", "DIF"])) {
      $errors["dificultad_error"] = "La dificultad de la receta es invalida";
    }

    if (count($errors) > 0) {
      foreach ($errors as $key => $value) {
        $this->receta[$key] = $value;
      }
      return false;
    }
    return true;
  }

  private function handlePostAction()
  {
    switch ($this->mode) {
      case "INS":
        $this->handleInsert();
        break;
      case "UPD":
        $this->handleUpdate();
        break;
      case "DEL":
        $this->handleDelete();
        break;
      default:
        throw new \Exception("Modo invalido", 1);
        break;
    }
  }

  private function handleInsert()
  {
    $result = RecetasDao::insertReceta(
      $this->receta["nombre"],
      $this->receta["ingredientePrincipal"],
      $this->receta["tiempoPreparacionMin"],
      $this->receta["tipoCocina"],
      $this->receta["dificultad"]
    );
    if ($result > 0) {
      Site::redirectToWithMsg(
        "index.php?page=Recetas_Recetas",
        "Receta creada exitosamente"
      );
    }
  }

  private function handleUpdate()
  {
    $result = RecetasDao::updateReceta(
      $this->receta["idReceta"],
      $this->receta["nombre"],
      $this->receta["ingredientePrincipal"],
      $this->receta["tiempoPreparacionMin"],
      $this->receta["tipoCocina"],
      $this->receta["dificultad"]
    );
    if ($result > 0) {
      Site::redirectToWithMsg(
        "index.php?page=Recetas_Recetas",
        "Receta actualizada exitosamente"
      );
    }
  }

  private function handleDelete()
  {
    $result = RecetasDao::deleteReceta($this->receta["idReceta"]);
    if ($result > 0) {
      Site::redirectToWithMsg(
        "index.php?page=Recetas_Recetas",
        "Receta Eliminada exitosamente"
      );
    }
  }
  private function setViewData(): void
  {
    $this->viewData["mode"] = $this->mode;
    $this->viewData["receta_xss_token"] = $this->receta_xss_token;
    $this->viewData["FormTitle"] = sprintf(
      $this->modeDescriptions[$this->mode],
      $this->receta["idReceta"],
      $this->receta["nombre"]
    );
    $this->viewData["showCommitBtn"] = $this->showCommitBtn;
    $this->viewData["readonly"] = $this->readonly;

    $dificultadKey = "dificultad_" . strtolower($this->receta["dificultad"]);
    $this->receta[$dificultadKey] = "selected";

    $this->viewData["receta"] = $this->receta;
  }
}
?>
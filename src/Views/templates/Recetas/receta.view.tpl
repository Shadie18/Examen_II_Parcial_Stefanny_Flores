<section class="container-m row px-4 py-4">
  <h1>{{FormTitle}}</h1>
</section>
<section class="container-m row px-4 py-4">
  {{with receta}}
  <form action="index.php?page=Recetas_Receta&mode={{~mode}}&idReceta={{idReceta}}" method="POST" class="col-12 col-m-8 offset-m-2">
    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="idRecetaD">Código</label>
      <input class="col-12 col-m-9" readonly disabled type="text" name="idRecetaD" id="idRecetaD" placehoder="Código" value="{{idReceta}}" />
      <input type="hidden" name="mode" value="{{~mode}}" />
      <input type="hidden" name="idReceta" value="{{idReceta}}" />
      <input type="hidden" name="token" value="{{~receta_xss_token}}" />
    </div>
    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="nombre">Receta</label>
      <input class="col-12 col-m-9" {{~readonly}} type="text" name="nombre" id="nombre" placehoder="Nombre de la Receta" value="{{nombre}}" />
      {{if nombre_error}}
      <div class="col-12 col-m-9 offset-m-3 error">
        {{nombre_error}}
      </div>
      {{endif nombre_error}}
    </div>
    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="ingredientePrincipal">Ingrediente Principal</label>
      <textarea class="col-12 col-m-9"  {{~readonly}} name="ingredientePrincipal" id="ingredientePrincipal" placehoder="Ingrediente Principal de la Receta">{{ingredientePrincipal}}</textarea>
      {{if ingredientePrincipal_error}}
      <div class="col-12 col-m-9 offset-m-3 error">
        {{ingredientePrincipal_error}}
      </div>
      {{endif ingredientePrincipal_error}}
    </div>
    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="tiempoPreparacionMin">Tiempo de Preparación (min)</label>
      <input class="col-12 col-m-9" {{~readonly}} type="number" name="tiempoPreparacionMin" id="tiempoPreparacionMin" placehoder="" value="{{tiempoPreparacionMin}}" />
      {{if tiempoPreparacionMin_error}}
      <div class="col-12 col-m-9 offset-m-3 error">
        {{tiempoPreparacionMin_error}}
      </div>
      {{endif tiempoPreparacionMin_error}}
    </div>
    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="tipoCocina">Tipo de Cocina</label>
      <input class="col-12 col-m-9" {{~readonly}} type="text" name="tipoCocina" id="tipoCocina" placehoder="Tipo de Cocina" value="{{tipoCocina}}" />
      {{if tipoCocina_error}}
      <div class="col-12 col-m-9 offset-m-3 error">
        {{tipoCocina_error}}
      </div>
      {{endif tipoCocina_error}}
    </div>
    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="dificultad">Dificultad</label>
      <select name="dificultad" id="dificultad" class="col-12 col-m-9" {{if ~readonly}} readonly disabled {{endif ~readonly}}>
        <option value="FAC" {{dificultad_fac}}>Fácil</option>
        <option value="MED" {{dificultad_med}}>Media</option>
        <option value="DIF" {{dificultad_dif}}>Difícil</option>
      </select>
    </div>
    {{endwith receta}}
    <div class="row my-4 align-center flex-end">
      {{if showCommitBtn}}
      <button class="primary col-12 col-m-2" type="submit" name="btnConfirmar">Confirmar</button>
      &nbsp;
      {{endif showCommitBtn}}
      <button class="col-12 col-m-2"type="button" id="btnCancelar">
        {{if showCommitBtn}}
        Cancelar
        {{endif showCommitBtn}}
        {{ifnot showCommitBtn}}
        Regresar
        {{endifnot showCommitBtn}}
      </button>
    </div>
    </div>
  </form>
</section>

<script>
  document.addEventListener("DOMContentLoaded", ()=>{
    const btnCancelar = document.getElementById("btnCancelar");
    btnCancelar.addEventListener("click", (e)=>{
      e.preventDefault();
      e.stopPropagation();
      window.location.assign("index.php?page=Recetas_Recetas");
    });
  });
</script>

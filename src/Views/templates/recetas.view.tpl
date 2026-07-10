<h1>Trabajar con Recetas</h1>
<section class="grid">
  <div class="row">
    <form class="col-12 col-m-8" action="index.php" method="get">
      <div class="flex align-center">
        <div class="col-8 row">
          <input type="hidden" name="page" value="Recetas_Recetas">
          <label class="col-3" for="partialNombre">Nombre</label>
          <input class="col-9" type="text" name="partialNombre" id="partialNombre" value="{{partialNombre}}" />
          <label class="col-3" for="dificultad">Dificultad</label>
          <select class="col-9" name="dificultad" id="dificultad">
              <option value="EMP" {{dificultad_EMP}}>Todos</option>
              <option value="FAC" {{dificultad_FAC}}>Fácil</option>
              <option value="MED" {{dificultad_MED}}>Media</option>
              <option value="DIF" {{dificultad_DIF}}>Difícil</option>
          </select>
        </div>
        <div class="col-4 align-end">
          <button type="submit">Filtrar</button>
        </div>
      </div>
    </form>
  </div>
</section>
<section class="WWList">
  <table>
    <thead>
      <tr>
        <th>
          {{ifnot OrderByIdReceta}}
          <a href="index.php?page=Recetas_Recetas&orderBy=idReceta&orderDescending=0">Id <i class="fas fa-sort"></i></a>
          {{endifnot OrderByIdReceta}}
          {{if OrderIdRecetaDesc}}
          <a href="index.php?page=Recetas_Recetas&orderBy=clear&orderDescending=0">Id <i class="fas fa-sort-down"></i></a>
          {{endif OrderIdRecetaDesc}}
          {{if OrderIdReceta}}
          <a href="index.php?page=Recetas_Recetas&orderBy=idReceta&orderDescending=1">Id <i class="fas fa-sort-up"></i></a>
          {{endif OrderIdReceta}}
        </th>
        <th class="left">
          {{ifnot OrderByNombre}}
          <a href="index.php?page=Recetas_Recetas&orderBy=nombre&orderDescending=0">Nombre <i class="fas fa-sort"></i></a>
          {{endifnot OrderByNombre}}
          {{if OrderNombreDesc}}
          <a href="index.php?page=Recetas_Recetas&orderBy=clear&orderDescending=0">Nombre <i class="fas fa-sort-down"></i></a>
          {{endif OrderNombreDesc}}
          {{if OrderNombre}}
          <a href="index.php?page=Recetas_Recetas&orderBy=nombre&orderDescending=1">Nombre <i class="fas fa-sort-up"></i></a>
          {{endif OrderNombre}}
        </th>
        <th>
          {{ifnot OrderByTiempoPreparacionMin}}
          <a href="index.php?page=Recetas_Recetas&orderBy=tiempoPreparacionMin&orderDescending=0">Tiempo Prep. (min) <i class="fas fa-sort"></i></a>
          {{endifnot OrderByTiempoPreparacionMin}}
          {{if OrderTiempoPreparacionMinDesc}}
          <a href="index.php?page=Recetas_Recetas&orderBy=clear&orderDescending=0">Tiempo Prep. (min) <i class="fas fa-sort-down"></i></a>
          {{endif OrderTiempoPreparacionMinDesc}}
          {{if OrderTiempoPreparacionMin}}
          <a href="index.php?page=Recetas_Recetas&orderBy=tiempoPreparacionMin&orderDescending=1">Tiempo Prep. (min) <i class="fas fa-sort-up"></i></a>
          {{endif OrderTiempoPreparacionMin}}
        </th>
        <th>Dificultad</th>
        <th><a href="index.php?page=Recetas-Receta&mode=INS">Nueva</a></th>
      </tr>
    </thead>
    <tbody>
      {{foreach recetas}}
      <tr>
        <td>{{idReceta}}</td>
        <td> <a class="link" href="index.php?page=Recetas-Receta&mode=DSP&idReceta={{idReceta}}">{{nombre}}</a>
        </td>
        <td class="right">
          {{tiempoPreparacionMin}}
        </td>
        <td class="center">{{dificultadDsc}}</td>
        <td class="center">
          <a href="index.php?page=Recetas-Receta&mode=UPD&idReceta={{idReceta}}">Editar</a>
          &nbsp;
          <a href="index.php?page=Recetas-Receta&mode=DEL&idReceta={{idReceta}}">Eliminar</a>
        </td>
      </tr>
      {{endfor recetas}}
    </tbody>
  </table>
  {{pagination}}
</section>
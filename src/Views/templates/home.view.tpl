<h1>Recetas Rápidas</h1>
    <div class="product-list">
        {{foreach recetasRapidas}}
        <div class="product" data-idReceta="{{idReceta}}">
            <h2>{{nombre}}</h2>
            <p>{{ingredientePrincipal}}</p>
            <span class="price">{{tiempoPreparacionMin}} min</span>
            <span class="tipoCocina">{{tipoCocina}}</span>
        </div>
        {{endfor recetasRapidas}}
    </div>
    <h1>Destacadas</h1>
    <div class="product-list">
        {{foreach recetasDestacadas}}
        <div class="product" data-idReceta="{{idReceta}}">
            <h2>{{nombre}}</h2>
            <p>{{ingredientePrincipal}}</p>
            <span class="price">{{tiempoPreparacionMin}} min</span>
            <span class="tipoCocina">{{tipoCocina}}</span>
        </div>
        {{endfor recetasDestacadas}}
    </div>
    <h1>Novedades</h1>
    <div class="product-list">
        {{foreach recetasNuevas}}
        <div class="product" data-idReceta="{{idReceta}}">
            <h2>{{nombre}}</h2>
            <p>{{ingredientePrincipal}}</p>
            <span class="price">{{tiempoPreparacionMin}} min</span>
            <span class="tipoCocina">{{tipoCocina}}</span>
        </div>
        {{endfor recetasNuevas}}
    </div>

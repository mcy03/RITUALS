document.addEventListener('DOMContentLoaded', function() {
    // Selecciona todos los checkboxes
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');

    // Itera sobre cada checkbox y agrega un evento de cambio
    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            // Verifica si el checkbox actual está seleccionado o no
            if (checkbox.checked) {
                console.log('Checkbox ' + checkbox.id + ' está seleccionado');
            } else {
                console.log('Checkbox ' + checkbox.id + ' no está seleccionado');
            }
        });
    });
});  

    //getProductosCategoriaApi();
    getProductosApi();

function eliminarProductos() {

    // Obtén una NodeList de todos los elementos con la clase 'tu-clase'
    var elementosConClase = document.querySelectorAll('.producto');

    // Convierte la NodeList en un array para poder iterar
    var arrayElementos = Array.from(elementosConClase);

    // Itera sobre los elementos y elimina cada uno
    arrayElementos.forEach(function(elemento) {
        elemento.remove();
    });
    
}

function mostrarProductos(productos) {
    const contenedoresProductos = document.getElementsByClassName("producto");

    for (let i = 0; i < productos.length; i++) {
        //codigo para generar la las etiquetas y contenido necesarios para la imagen del producto
        let div_img = document.createElement("div");
        div_img.className = 'cont-img-product';
        
        let img = document.createElement("img");
        img.src = productos[i]["IMG"];
        img.className = "card-img-top";
        img.alt = "imagen producto";
        
        div_img.appendChild(img);

        contenedoresProductos[i].appendChild(div_img);
        //---------------------------------------------------------------------------------------

        //codigo para generar la las etiquetas y contenido necesarios para el resto de información del producto
        let div_info = document.createElement("div");
        div_info.className = 'card-body';

        let h3 = document.createElement("h3");
        h3.className = 'card-title';
        h3.textContent = productos[i]["NOMBRE_PRODUCTO"];

        let p_desc = document.createElement("p");
        p_desc.className = 'card-text';
        p_desc.textContent = productos[i]["DESCRIPCION"];

        let p_price = document.createElement("p");
        p_price.className = 'price';
        p_price.textContent = productos[i]["PRECIO_UNIDAD"] + " €";

        let form_add = document.createElement("form");
        form_add.className = 'form-add';
        const urlAction = 'https://testcaler.com/testCaler/RITUALS/?controller=producto&action=sel';
        const metodo = 'post'; // o 'get', según tus necesidades
        form_add.action = urlAction;
        form_add.method = metodo;

        let input_id = document.createElement('input');
        input_id.type = 'hidden';
        input_id.name = 'id';
        input_id.value = productos[i]["PRODUCTO_ID"];

        let input_page = document.createElement('input');
        input_page.type = 'hidden';
        input_page.name = 'page';
        input_page.value = 'carta';

        let button = document.createElement('button');
        button.className = 'btn btn-primary';
        button.type = 'submit';
        button.innerHTML = 'AÑADIR A LA CESTA';

        form_add.appendChild(input_id);
        form_add.appendChild(input_page);
        form_add.appendChild(button);

        div_info.appendChild(h3);
        div_info.appendChild(p_desc);
        div_info.appendChild(p_price);
        div_info.appendChild(form_add);

        contenedoresProductos[i].appendChild(div_info);
        //---------------------------------------------------------------------------------------
        /*
        <div class="cont-img-product">
            <img src="<?= $a_productos->getImg() ?>" class="card-img-top" alt="imagen producto">
        </div>
        <div class="card-body">
            <h3 class="card-title"><?= $a_productos->getName() ?></h3>
            <p class="card-text"><?= $a_productos->getDesc() ?></p>
            <p class="price"><?= $a_productos->getPrice()?> €</p>
            <form class="form-add" action=<?=url.'?controller=producto&action=sel'?> method='post'>
                <input type='hidden' name='id' value= <?=$a_productos->getId()?>>
                <input type='hidden' name='page' value='carta'>
                <button class="btn btn-primary" type="submit">AÑADIR A LA CESTA</button>
            </form>
        </div>
        */
    }
}

function categoriasApi() {
    return new Promise( async(res, rej) => {
        let formData = new FormData();
        formData.append('accion', 'get_categories');

    const url = 'https://testcaler.com/testCaler/RITUALS/?controller=ApiCategoria&action=api';

    try {
        const response = await axios.post(url, formData);

        res(response.data);
        
    } catch (error) {
        rej();
        console.error('Error:', error.message);
    }
    

    })

   
    
}

async function getProductosApi() {
    let formData = new FormData();
    formData.append('accion', 'get_all_products');

    const url = 'https://testcaler.com/testCaler/RITUALS/?controller=ApiCategoria&action=api';

    try {
        const response = await axios.post(url, formData);
        
        generarContenedoresProductos(await response.data);
        mostrarProductos(await response.data);
    } catch (error) {
        console.error('Error:', error.message);
    }
}
const categoriasSeleccionadas = [];
async function getProductosCategoriaApi(categoria) {
    // Obtener las categorías seleccionadas
    categoriasSeleccionadas.push(categoria);

    let formData = new FormData();
    formData.append('accion', 'get_products_category');
    formData.append('categoria', categoriasSeleccionadas);

    const url = 'https://testcaler.com/testCaler/RITUALS/?controller=ApiCategoria&action=api';

    try {
        const response = await axios.post(url, formData);
        console.log(await response.data);
        eliminarProductos();
        generarContenedoresProductos(await response.data, "categoria");
        mostrarProductos(await response.data);
    } catch (error) {
        console.error('Error:', error.message);
    }
}
/*
function mostrarBotonesCategorias(categorias) {
    return new Promise( async(res, rej) => {
        const contenedorBotones = document.getElementsByClassName("botones-categorias")[0];

        for (let i = 0; i < categorias.length; i++) {
            const divCheck = document.createElement('divCheck');
            divCheck.className = "divCheck";

            const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.id = `checkbox${i + 1}`;
                checkbox.className = `checkboxes`;
                checkbox.name = `opciones${i + 1}`;
                checkbox.value = categorias[i]["NOMBRE_CATEGORIA"];

            const label = document.createElement('label');
                label.htmlFor = `checkbox${i + 1}`;
                label.appendChild(document.createTextNode(categorias[i]["NOMBRE_CATEGORIA"]));

            divCheck.appendChild(checkbox);
            divCheck.appendChild(label);
            contenedorBotones.appendChild(divCheck);
        }
        res();
    })

}

/*
    for (let i = 0; i < categorias.length; i++) {
        const boton = document.createElement('a');
        boton.className = 'btn-cat btn btn-primary';
        
        boton.href = 'https://testcaler.com/testCaler/RITUALS/?controller=producto&action=carta&cat='+categorias[i]["NOMBRE_CATEGORIA"];

        boton.textContent = categorias[i]["NOMBRE_CATEGORIA"];

        contenedorBotones.appendChild(boton);
        
    }


function listenerCheckedCategorias() {
    let checkboxes = document.getElementsByClassName("checkBoxes");
    console.log(checkboxes);

    for(let i = 0; i < checkboxes.length; i++) {
       console.log(checkboxes)
        // Agrega un evento de cambio a cada checkbox
        checkboxes[""].addEventListener('change', function () {
       
            console.log("listener");
            if (checkboxes[i].checked) {
                console.log("checked");
                
                getProductosCategoriaApi(checkboxes[i].value);
            }else{
                console.log("no checked");
            }
            console.log("mimi");
       });
    }

}
*/




function generarContenedoresProductos(productos, category = "") {
    const contenedorProductos = document.getElementById('row-productos');
        let col = 1;
        let contador = 0;
        let auxiliar = 0;
        let suma = 0;

        if (category != "") {
            if (productos.length % 2 != 0) {
                contador = 1;
            } else {
                contador = 2;
            }
            suma = 1;
        }

        productos.forEach((a_producto, index) => {
            let columna = document.getElementsByClassName('masonry-column');
            if (productos.length < 5 && col === 1) {
                col++;
                // Cerrar la columna actual
                contenedorProductos.innerHTML += '</div>';  
                // Abrir una nueva columna
                contenedorProductos.innerHTML += '<div class="col-12 col-sm-6 col-md-4 col-lg-4 masonry-column">';
            }

            contador++;

            // Añadir contenido de producto

            let tarjeta = document.createElement('div');
            tarjeta.className = "producto card";
            
            columna[col-1].appendChild(tarjeta);

            if ((col === 1 && contador > productos.length / 3 - 2) || (col === 2 && contador - auxiliar > (productos.length - auxiliar) / 2 + suma)) {
                auxiliar = contador;
                col++;
                // Cerrar la columna actual
                contenedorProductos.innerHTML += '</div>';  
                // Abrir una nueva columna
                contenedorProductos.innerHTML += '<div class="col-12 col-sm-6 col-md-4 col-lg-4 masonry-column">';

            }
        });

        // Cerrar la última columna
        contenedorProductos.innerHTML += '</div>';
        
    }
/*
if (isset($_GET['cat'])) {
    $name_cat = " / ".$_GET['cat']; // Obtiene el nombre de la categoría para mostrar en la vista
    $cat_filtro = Categoria::getCatIdByName($_GET['cat']); // Obtiene el id de la categoria por su nombre
    $productos = Producto::getProductByIdCat($cat_filtro); // Obtiene productos por la categoría

    // Determina un contador y una suma basada en el número de productos para el diseño de la vista
    if (sizeof($productos) % 2 != 0) {
        $contador = 1;
    } else {
        $contador = 2;
    }
    $suma = 1;
} else {
    // Si no se especifica una categoría, obtiene todos los productos disponibles
    $productos = Producto::getProducts();
    $contador = 0;
    $suma = 0;
}
*/


/*
// Texto que deseas codificar en el QR
const textoQR = "www.google.es";

// Configuración del QR
const configuracionQR = {
    typeNumber: 4,
    errorCorrectLevel: 'L'
};

// Generar el código QR
const qr = qrcode(configuracionQR.typeNumber || 4, configuracionQR.errorCorrectLevel || 'L');
qr.addData(textoQR);
qr.make();

// Obtener la imagen del código QR como un objeto Data URL
const imagenQR = qr.createImgTag();

// Mostrar la imagen del código QR en el elemento con ID "qrcode"
document.getElementById("qrcode").innerHTML = imagenQR;

*/



// Escuchar cambios en los checkboxes
var checkboxes = document.querySelectorAll('.categoria');
checkboxes.forEach(function(checkbox) {
    checkbox.addEventListener('change', mostrarProductos);
});
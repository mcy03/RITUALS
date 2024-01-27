window.addEventListener("load", function() {
    categoriasApi();
    
    //getProductosCategoriaApi();
    getProductosApi();
});

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

async function categoriasApi() {
    let formData = new FormData();
        formData.append('accion', 'get_categories');

    const url = 'https://testcaler.com/testCaler/RITUALS/?controller=ApiCategoria&action=api';

    try {
        const response = await axios.post(url, formData);

        mostrarBotonesCategorias(await response.data);
    } catch (error) {
        console.error('Error:', error.message);
    }
}

async function getProductosApi() {
    let formData = new FormData();
    formData.append('accion', 'get_all_products');

    const url = 'https://testcaler.com/testCaler/RITUALS/?controller=ApiCategoria&action=api';

    try {
        const response = await axios.post(url, formData);

        mostrarProductos(await response.data);
    } catch (error) {
        console.error('Error:', error.message);
    }
}

async function getProductosCategoriaApi(nameCategory) {
    let formData = new FormData();
    formData.append('accion', 'get_products_category');
    formData.append('categoria', "\""+nameCategory+"\"");

    const url = 'https://testcaler.com/testCaler/RITUALS/?controller=ApiCategoria&action=api';

    try {
        const response = await axios.post(url, formData);

        console.log(await response.data);
    } catch (error) {
        console.error('Error:', error.message);
    }
}

function mostrarBotonesCategorias(categorias) {
    const contenedorBotones = document.getElementsByClassName("botones-categorias")[0];

    for (let i = 0; i < categorias.length; i++) {
        const divCheck = document.createElement('div');
        divCheck.className = "divCheck";

        const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.id = `checkbox${i + 1}`;
            checkbox.name = 'opciones';
            checkbox.value = categorias[i]["NOMBRE_CATEGORIA"];

        const label = document.createElement('label');
            label.htmlFor = `checkbox${i + 1}`;
            label.appendChild(document.createTextNode(categorias[i]["NOMBRE_CATEGORIA"]));

        divCheck.appendChild(checkbox);
        divCheck.appendChild(label);
        contenedorBotones.appendChild(divCheck);

        // Agrega un evento de cambio a cada checkbox
        checkbox.addEventListener('change', function () {
            if (checkbox.checked) {
                getProductosCategoriaApi(checkbox.value);
            }
        });
    }
/*
    for (let i = 0; i < categorias.length; i++) {
        const boton = document.createElement('a');
        boton.className = 'btn-cat btn btn-primary';
        
        boton.href = 'https://testcaler.com/testCaler/RITUALS/?controller=producto&action=carta&cat='+categorias[i]["NOMBRE_CATEGORIA"];

        boton.textContent = categorias[i]["NOMBRE_CATEGORIA"];

        contenedorBotones.appendChild(boton);
        
    }
*/
}

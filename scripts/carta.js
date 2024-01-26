window.addEventListener("load", function() {
    categoriasApi();
});

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

function mostrarBotonesCategorias(categorias) {
    const contenedorBotones = document.getElementsByClassName("botones-categorias")[0];

    for (let i = 0; i < categorias.length; i++) {
        const boton = document.createElement('a');
        boton.className = 'btn-cat btn btn-primary';
        
        boton.href = 'https://testcaler.com/testCaler/RITUALS/?controller=producto&action=carta&cat='+categorias[i]["NOMBRE_CATEGORIA"];

        boton.textContent = categorias[i]["NOMBRE_CATEGORIA"];

        contenedorBotones.appendChild(boton);
        
    }
}
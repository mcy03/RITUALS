window.addEventListener("load", function() {
    resenasApi();
    //obtenerUserApi();
});
/*
async function obtenerUserApi() {      
    
    const url = 'https://testcaler.com/testCaler/RITUALS/?controller=ApiUser&action=api';
    let formData = new FormData();
        formData.append('accion', 'get_user');
    try {
        const response = await axios.post(url, formData);

        console.log(response.data);
    } catch (error) {
        console.error('get user Error:', error.message);
    }
}*/
const selectElement = document.getElementById('orden');

selectElement.addEventListener('change', obtenerSelect); 


function obtenerSelect() {
    // Obtener el valor seleccionado
    const valorSeleccionado = selectElement.value;

    // Imprimir el valor seleccionado en la consola
    resenasApi(valorSeleccionado);

    // Aquí puedes realizar cualquier otra acción con el valor seleccionado
};






async function resenasApi(valorSeleccionado = "ASC") {
    const contenedor = document.getElementById('contApi');
    

    let formData = new FormData();
        formData.append('accion', 'get_reviews');
        formData.append('orden', 'valorSeleccionado');
    
    const url = 'https://testcaler.com/testCaler/RITUALS/?controller=ApiResena&accion=get_reviews';

    try {
        const response = await axios.post(url, formData);

        console.log(response.data);
    } catch (error) {
        console.error('Error:', error.message);
    }
   
}

// Función para crear las estrellas
function crearEstrellas(puntuacion, id) {
    const estrellasContainer = document.getElementById(id);

    // Crea un ícono de estrella para cada punto de puntuación
    for (let i = 0; i < puntuacion; i++) {
        const estrella = document.createElement('i');
        estrella.className = 'fas fa-star'; // Clase de FontAwesome para la estrella resaltada
        estrellasContainer.appendChild(estrella);
    }

    // Crea un ícono de estrella vacía para el resto
    for (let i = puntuacion; i < 5; i++) {
        const estrellaVacia = document.createElement('i');
        estrellaVacia.className = 'far fa-star'; // Clase de FontAwesome para la estrella vacía
        estrellasContainer.appendChild(estrellaVacia);
    }
}

function crearTablaResenas(data) {
    const contenedorTabla = document.getElementById('resenas');
    const tabla = document.createElement('table');
    tabla.className = 'tabla_resenas';
    let cont = 1;
    for (let index = 0; index < data.length; index++) {
    
        const trNombre = document.createElement('tr');
        trNombre.className = 'tr_resenas';

        const tdIcono = document.createElement('td');
        tdIcono.className = 'td_resenas_icon';
        const icono = document.createElement('img');
        icono.src = './img/user-icon-black.png';
        icono.width = '50';
        tdIcono.appendChild(icono);

        const tdNombre = document.createElement('td');
        tdNombre.className = 'td_resenas_name';
        tdNombre.textContent = data[index].EMAIL;

        trNombre.appendChild(tdIcono);
        trNombre.appendChild(tdNombre);

        const trPuntuacion = document.createElement('tr');
        const tdEspacio = document.createElement('td');
        tdEspacio.rowSpan = '3';
        tdEspacio.className = 'td_space';
        trPuntuacion.appendChild(tdEspacio);

        const tdPuntuacion = document.createElement('td');
        tdPuntuacion.id = 'td_resenas_puntuacion'+cont;
        tdPuntuacion.className = 'td_resenas_estrellas';
        trPuntuacion.appendChild(tdPuntuacion);

        const trPedido = document.createElement('tr');
        const tdPedido = document.createElement('td');
        tdPedido.id = 'td_resenas_pedido'+cont;
        tdPedido.className = 'td_resenas_estrellas';
        tdPedido.textContent = "Pedido: " + data[index].PEDIDO_ID;
        trPedido.appendChild(tdPedido);

        const trComentario = document.createElement('tr');
        const tdComentario = document.createElement('td');
        tdComentario.className = 'td_resenas_comentario';
        const textarea = document.createElement('textarea');
        textarea.disabled = true;
        textarea.textContent = data[index].COMENTARIO;
        tdComentario.appendChild(textarea);
        trComentario.appendChild(tdComentario);

        const trEspacio = document.createElement('tr');
        trEspacio.className = 'tr_space';

        tabla.appendChild(trNombre);
        tabla.appendChild(trPuntuacion);
        tabla.appendChild(trPedido);
        tabla.appendChild(trComentario);
        tabla.appendChild(trEspacio);

        
        cont++;
        
    }

    contenedorTabla.appendChild(tabla);
    for (let index = 0; index < data.length; index++) {
        crearEstrellas(data[index].VALORACION, 'td_resenas_puntuacion'+(index+1));
    }
}


let formulario = document.getElementById("formularioValoracion");
formulario.addEventListener("submit", insertResena);
formulario.addEventListener("submit", resetEstrellas);

function insertResena(event) {
    event.preventDefault();
    const pedido = document.getElementById('pedido').value;
    if (pedido == "undefined") {
        console.log("error");
    }else{
        const nombre = document.getElementById('nombre').value;
        let puntuacion = 0;
        let b_checked = false;
        let radios = document.getElementsByName('estrellas');

        for (var i = 0; i < radios.length; i++) {
            if (radios[i].checked) {
                puntuacion = i;
                b_checked = true;
                break;
            }
        }

        if (puntuacion == 0 && b_checked) {
            puntuacion = 5;
        }else if(puntuacion > 0 && puntuacion < 5){
            puntuacion = 5 - puntuacion;
        }

        

        const comentario = document.getElementById('comentario').value;

        const fecha = new Date();
        
        let formData = new FormData();
        formData.append('accion', 'add_reviews');

        formData.append('PEDIDO_ID', pedido);
        formData.append('ASUNTO', "\"prueba insertar api\"");
        formData.append('COMENTARIO', "\""+comentario+"\"");
        formData.append('FECHA_RESENA', "\""+fecha+"\"");
        formData.append('VALORACION', puntuacion);

        insertarResenaApi(formData);

        const contenedorTabla = document.getElementById('resenas');
        contenedorTabla.innerHTML = "";
        
        document.getElementById('comentario').value = "";

        resenasApi();
    }
}

async function insertarResenaApi(formData) {      
    
    const url = 'https://testcaler.com/testCaler/RITUALS/?controller=ApiResena&action=add_review';

    const fecha = new Date();

    try {
        const response = await axios.post(url, formData);

        console.log(response.data);
    } catch (error) {
        console.error('Error:', error.message);
    }
}

function resetEstrellas(event) {
    event.preventDefault();
    let radios = document.getElementsByName('estrellas');

    for (let i = 0; i < radios.length; i++) {
        if (radios[i].checked) {
            radios[i].checked = false;
        }
        
    }
}



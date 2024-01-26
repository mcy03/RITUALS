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
}
*/

async function resenasApi() {
    const contenedor = document.getElementById('contApi');
    
    let formData = new FormData();
        formData.append('accion', 'get_reviews');

    const url = 'https://testcaler.com/testCaler/RITUALS/?controller=ApiResena&action=api';

    try {
        const response = await axios.post(url, formData);

        console.log(response.data);
        crearTablaResenas(response.data);
    } catch (error) {
        console.error('Error:', error.message);
    }
}

const selectElement = document.getElementById('orden');

selectElement.addEventListener('change', obtenerSelect); 


function obtenerSelect() {
    // Obtener el valor seleccionado
    const valorSeleccionado = selectElement.value;

    resenasApiOrden(valorSeleccionado);
};

// Obtenemos el elemento input por su id
const inputElement = document.getElementById('filtro-input');

// Agregamos un evento 'input' al input
inputElement.addEventListener('blur', obtenerInputFiltro);

function obtenerInputFiltro() {

        // Obtener el valor introducido
        let valorInput = inputElement.value;
            
        // Validar el valor para asegurarse de que esté dentro del rango
        if (valorInput < 0) {
            inputElement.value = 0;  // Establecer el valor mínimo si es menor que 1
            valorInput = 0;
        } else if (valorInput > 5) {
            inputElement.value = 5;  // Establecer el valor máximo si es mayor que 5
            valorInput = 5;
        }

    resenasApiOrden(valorSeleccionado = "", valorInput);
};

async function resenasApiOrden(valorSeleccionado = "", valorInput  = "") {
    const contenedor = document.getElementById('contApi');
    
    let formData = new FormData();
        formData.append('accion', 'get_reviews');
        if (valorSeleccionado != "") {
            formData.append('orden', valorSeleccionado);
        }else if(valorInput != ""){
            formData.append('filtro', valorInput);
        }
        
    
    const url = 'https://testcaler.com/testCaler/RITUALS/?controller=ApiResena&action=api';

    try {
        const response = await axios.post(url, formData);

        const contenedorTabla = document.getElementById('resenas');
        contenedorTabla.innerHTML = "";
        console.log(response.data);
        if (response.data.length < 1) {
            mensajeSinResenas(valorInput);
        }else{
            crearTablaResenas(response.data);
        }
        
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
        crearEstrellas(parseInt(data[index].VALORACION), 'td_resenas_puntuacion'+(index+1));
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
        const asunto = document.getElementById('input-asunto').value;
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

        // Obtener la fecha actual
        const fechaActual = new Date();

        // Obtener los componentes de la fecha
        const año = fechaActual.getFullYear();
        const mes = (fechaActual.getMonth() + 1).toString().padStart(2, '0'); // Agregar ceros iniciales si es necesario
        const dia = fechaActual.getDate().toString().padStart(2, '0'); // Agregar ceros iniciales si es necesario

        // Formatear la fecha como "año-mes-día"
        const fechaFormateada = `${año}-${mes}-${dia}`;

        let formData = new FormData();
        formData.append('accion', 'add_review');

        formData.append('PEDIDO_ID', pedido);
        formData.append('ASUNTO', "\""+asunto+"\"");
        formData.append('COMENTARIO', "\""+comentario+"\"");
        formData.append('FECHA_RESENA', "\""+fechaFormateada+"\"");
        formData.append('VALORACION', puntuacion);

        insertarResenaApi(formData);

        const contenedorTabla = document.getElementById('resenas');
        contenedorTabla.innerHTML = "";
        
        document.getElementById('comentario').value = "";

        resenasApi();
    }
}

async function insertarResenaApi(formData) {      
    
    const url = 'https://testcaler.com/testCaler/RITUALS/?controller=ApiResena&action=api';

    const fecha = new Date();

    try {
        const response = await axios.post(url, formData);
        resenasApi();
        success("Reseña insertada correctamente");
        console.log(response.data);
    } catch (error) {
        console.error('Error:', error.message);
    }
}

function success (mensaje) {
    notie.setOptions({
        alertTime: 2
      })
    notie.alert({ type: 1, text: mensaje, time: 2 })
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

function mensajeSinResenas(puntuacion){
    const contenedorTabla = document.getElementById('resenas');
    const p = document.createElement('p');
    p.className = 'mensaje-sin-resenas';

    p.innerHTML = "No hay reseñas con "+puntuacion+" puntos de valoración";

    contenedorTabla.appendChild(p);
}



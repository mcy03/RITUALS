window.addEventListener("load", async function() {
    let result = '';
    if (localStorage.getItem('propina')) {
        result = await addPropina(parseFloat(localStorage.getItem('propina')));
        
        localStorage.removeItem('propina');
    }

    if (localStorage.getItem('puntos')) {
        let puntos = localStorage.getItem('puntos');
        result = await addPuntos(puntos);

        await updatePuntos(obtenerPuntosUser() - puntos);

        localStorage.removeItem('puntos');
    }
    
    const pedido = await getUltimoPedido();

    await mostrarPedido(pedido[0]);

    await sumarPuntos(pedido[0].COSTE_PEDIDO);
    const imgQr = this.document.getElementById('imgQr'); 
    //console.log(await generarQr('www.google.es'));
});

async function addPropina(propina){
    let formData = new FormData();
        formData.append('accion', 'add_propina');
        formData.append('propina', propina);

    const url = 'https://testcaler.com/testCaler/RITUALS/?controller=ApiPedido&action=api';

    try {
        const response = await axios.post(url, formData);

        return await response.data;
    } catch (error) {
        console.error('Error:', error.message);
    }
}

async function addPuntos(puntos){
    let formData = new FormData();
        formData.append('accion', 'add_puntos');
        formData.append('puntos', puntos);

    const url = 'https://testcaler.com/testCaler/RITUALS/?controller=ApiPedido&action=api';

    try {
        const response = await axios.post(url, formData);

        return await response.data;
    } catch (error) {
        console.error('Error:', error.message);
    }
}

async function updatePuntos(puntos){
    let user = JSON.parse(localStorage.getItem('user'));
    let formData = new FormData();
        formData.append('accion', 'update_puntos');
        formData.append('puntos', puntos);
        formData.append('user', user[0].USUARIO_ID);

    const url = 'https://testcaler.com/testCaler/RITUALS/?controller=ApiUser&action=api';

    try {
        const response = await axios.post(url, formData);

        return await response.data;
    } catch (error) {
        console.error('Error:', error.message);
    }
}

async function sumarPuntos(costePedido){
    console.log((costePedido*10).toFixed(0));
    let user = JSON.parse(localStorage.getItem('user'));

    let formData = new FormData();
        formData.append('accion', 'update_puntos');
        formData.append('puntos', (costePedido*10).toFixed(0));
        formData.append('user', user[0].USUARIO_ID);

    const url = 'https://testcaler.com/testCaler/RITUALS/?controller=ApiUser&action=api';

    try {
        const response = await axios.post(url, formData);

        return await response.data;
    } catch (error) {
        console.error('Error:', error.message);
    }
}

async function getUltimoPedido(){
    let formData = new FormData();
        formData.append('accion', 'get_last_command');

    const url = 'https://testcaler.com/testCaler/RITUALS/?controller=ApiPedido&action=api';

    try {
        const response = await axios.post(url, formData);

        return await response.data;
    } catch (error) {
        console.error('Error:', error.message);
    }
}

async function mostrarPedido(pedido){
    const etiquetas = document.getElementsByClassName("valor");

    let index = 0;
    for (var key in pedido) {
        if (etiquetas[index].parentNode.id == key) {
            if(key != 'USUARIO_ID'){
                etiquetas[index].innerHTML = pedido[key];
            }else{
                let user = await getUser(pedido[key]);
                etiquetas[index].innerHTML = user[0].EMAIL;
                //etiquetas[index].innerHTML = await getEmailUser(pedido[key]);
            }
        }
        index++;
    }
    etiquetas[etiquetas.length-1].innerHTML = calcularCosteFinal(pedido)+' €';
}

function calcularCosteFinal(pedido) {
    const costeInicial = pedido.COSTE_PEDIDO;
    const propina = pedido.PROPINA;
    const puntos = pedido.PUNTOS_APLICADOS;


    const valorPuntos = parseFloat(puntos / 100);

    const costeFinal = parseFloat(costeInicial) + parseFloat(propina) - parseFloat(valorPuntos);
    return costeFinal.toFixed(2);
}

async function getUser(id) {
    let formData = new FormData();
        formData.append('accion', 'get_user');
        formData.append('USUARIO_ID', id);

    const url = 'https://testcaler.com/testCaler/RITUALS/?controller=ApiUser&action=api';

    try {
        const response = await axios.post(url, formData);

        return await response.data;
    } catch (error) {
        console.error('Error:', error.message);
    }
}

async function obtenerPuntosUser() {
    if (localStorage.getItem('user')) {
        const user = JSON.parse(localStorage.getItem('user'));
        let formData = new FormData();
        formData.append('accion', 'get_points_user');
        formData.append('user_id', user[0].USUARIO_ID);

        const url = 'https://testcaler.com/testCaler/RITUALS/?controller=ApiUser&action=api';

        try {
            const response = await axios.post(url, formData);

            return await response.data;
        } catch (error) {
            console.error('Error:', error.message);
        }
    }else{
        return 0;
    }
}
window.addEventListener("load", function() {
    obtenerUser();

    if (localStorage.getItem('propina')) {
        console.log(localStorage.getItem('propina'));
        addPropina(parseFloat(localStorage.getItem('propina')));
    }
    
    /*
    pedidosApi();
    pedidosUserApi();
    productosPedidoApi();
    */
});

async function obtenerUser() {
    let id_user = document.getElementsByName("id_user_js")[0].value;
    let formData = new FormData();
        formData.append('accion', 'get_user');
        formData.append('USUARIO_ID', id_user);

    const url = 'https://testcaler.com/testCaler/RITUALS/?controller=ApiUser&action=api';

    try {
        const response = await axios.post(url, formData);

        guardarUser(await response.data);
    } catch (error) {
        console.error('Error:', error.message);
    }
}

function guardarUser(user) {
    console.log(user);
    localStorage.setItem("user", JSON.stringify(user));

}


async function pedidosApi() {
    let formData = new FormData();
        formData.append('accion', 'get_pedidos');

    const url = 'https://testcaler.com/testCaler/RITUALS/?controller=ApiPedido&action=api';

    try {
        const response = await axios.post(url, formData);

        console.log(await response.data);
    } catch (error) {
        console.error('Error:', error.message);
    }
}

async function pedidosUserApi() {
    let formData = new FormData();
        formData.append('accion', 'get_pedidos_user');
        formData.append('USUARIO_ID', 1);

    const url = 'https://testcaler.com/testCaler/RITUALS/?controller=ApiPedido&action=api';

    try {
        const response = await axios.post(url, formData);

        console.log(await response.data);
    } catch (error) {
        console.error('Error:', error.message);
    }
}

async function productosPedidoApi() {
    let formData = new FormData();
        formData.append('accion', 'get_products_pedido');
        formData.append('PEDIDO_ID', 52);

    const url = 'https://testcaler.com/testCaler/RITUALS/?controller=ApiPedido&action=api';

    try {
        const response = await axios.post(url, formData);

        console.log(await response.data);
    } catch (error) {
        console.error('Error:', error.message);
    }
}

async function addPropina(propina){
    let formData = new FormData();
        formData.append('accion', 'add_propina');
        formData.append('propina', propina);

    const url = 'https://testcaler.com/testCaler/RITUALS/?controller=ApiPedido&action=api';

    try {
        const response = await axios.post(url, formData);

        console.log(await response.data);
    } catch (error) {
        console.error('Error:', error.message);
    }
}
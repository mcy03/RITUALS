window.addEventListener("load", async function() {
    obtenerUser();

    const cerrarSesion = document.getElementById('cerrar-sesion');

    cerrarSesion.addEventListener('click', borrarSesion);
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
    if (!localStorage.getItem('user') || localStorage.getItem('user') != user) {
        localStorage.setItem("user", JSON.stringify(user));
    }
}

function borrarSesion() {
    if (localStorage.getItem('user')) {
        localStorage.removeItem("user");
    }
}



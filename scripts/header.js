window.addEventListener("load", async function() {
    const puntos = document.getElementsByClassName('puntos-user')[0];

    puntos.innerHTML = await puntosUser();
});

async function puntosUser() {
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
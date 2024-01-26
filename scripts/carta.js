window.addEventListener("load", function() {
    categoriasApi();
    //obtenerUserApi();
});

async function categoriasApi() {
    let formData = new FormData();
        formData.append('accion', 'get_categories');

    const url = 'https://testcaler.com/testCaler/RITUALS/?controller=ApiCategoria&action=api';

    try {
        const response = await axios.post(url, formData);

        console.log(response.data);
    } catch (error) {
        console.error('Error:', error.message);
    }
}
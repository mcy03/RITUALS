$(document).ready(function () {
    // Llama a la función para obtener los productos al cargar la página
    getProducts();
    
    // Manejar el cambio en los checkboxes
    $('.category-checkbox').change(function () {
        filterProducts();
    });
    
    function filterProducts() {
        var selectedCategories = [];
        
        // Obtener las categorías seleccionadas
        $('.category-checkbox:checked').each(function () {
            selectedCategories.push($(this).attr('id'));
        });
        
        // Mostrar u ocultar productos según las categorías seleccionadas
        $('.allproducts .col-12').each(function () {
            var productCategories = $(this).data('categories').toString();
            
            if (selectedCategories.length === 0 || containsAny(productCategories.split(','), selectedCategories)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }
});
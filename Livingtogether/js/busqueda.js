function searchItems() {
    var input, filter, ul, li, i, txtValue;
    input = document.getElementById('searchInput');
    filter = input.value.toUpperCase(); // No sensible a mayúsculas
    ul = document.getElementById("itemsList");
    li = ul.getElementsByTagName('li');

    // Iterar sobre los elementos de la lista y esconder los que no coincidan con la búsqueda
    for (i = 0; i < li.length; i++) {
        txtValue = li[i].textContent || li[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].classList.remove('hidden'); // Mostrar si coincide
        } else {
            li[i].classList.add('hidden'); // Esconder si no coincide
        }
    }
}
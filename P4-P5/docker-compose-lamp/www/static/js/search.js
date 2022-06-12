window.onload = function (){
    document.getElementById("search-input").addEventListener("keyup", search);
    document.getElementById("search-icon").addEventListener("click", search);
};

function search() {
    clearSearch();
    var search_input = document.getElementById("search-input");

    if(search_input.value != ""){
        var ajax = new XMLHttpRequest();
        var asynchronous = true;
        
        ajax.open("GET", "/src/items.php?search=" + search_input.value, asynchronous);
        ajax.send();

        ajax.onreadystatechange = function() {
            if(this.readyState == 4 && this.status == 200){
                var resultados = JSON.parse(this.responseText);
                for(var i = 0; i < resultados.length; i++)
                    addResult(resultados[i]['id'], resultados[i]['name'], search_input.value)
            }
        }
    }
}

function clearSearch() {
    var resultados = document.getElementById("search-result");
    resultados.innerText = "";
}

function addResult(id, name, query) {
    var resultados = document.getElementById("search-result");
    var nombre = document.createElement("div");
    nombre.classList.add("wrap-nombre");
    var re = new RegExp(query, "ig");
    name = name.replace(re, "<strong>" + name.match(re) + "</strong>");
    nombre.innerHTML = name;
    var enlace = document.createElement("a");
    enlace.classList.add("link-product");
    enlace.href = "producto.php?id=" + id;
    enlace.append(nombre);
    resultados.append(enlace);
}
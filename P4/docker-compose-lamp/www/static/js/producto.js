window.onload = function (){
    document.getElementById("id-comment-link").addEventListener("click", displayCommentsForm);
    document.getElementById("input-submit").addEventListener("click", addComment);
    document.getElementById("input-comment").addEventListener("keypress", checkWord);
};

function generateComment(autor, comment) {
    // Crear autor
    var spanAutor = createComponent("span", "autor");
    spanAutor.innerText = autor;

    // Crear fecha
    var spanFecha = getSpanFecha();
    var divAutorFecha = createComponent("div", "autor-fecha");

    // Añadir autor y fecha
    divAutorFecha.append(spanAutor);
    divAutorFecha.append(spanFecha);

    // Crear resena
    var resena = createComponent("span", "resena");
    var divResena = createComponent("div", "div-resena");
    resena.innerText = comment;
    divResena.append(resena);

    // Crear comentario
    var comentario = createComponent("div", "comentario");
    comentario.append(divAutorFecha);
    comentario.append(divResena);

    // Crear li
    var commentLi = createComponent("li", "li-list-comment");
    commentLi.append(comentario);

    // Add comment
    var commentUl = document.getElementById("id-ul-list-comment");
    commentUl.prepend(commentLi);
}

function createComponent(component, classname) {
    var element = document.createElement(component);
    element.classList.add(classname);
    return element;
}

function clearInput(id) {
    document.getElementById(id).value = "";
}

function setOutlineBorderText(component, color) {
    component.style.outlineColor = color;
    component.style.borderColor = color;
    component.style.color = color;
}

function isInputEmpty(id) {
    var component = document.getElementById(id);
    var bool = false;

    if(component.value === ""){
        bool = true;   
    }

    return bool;
}

function getSpan(id, classname, alerta) {
    var input = document.getElementById(id);

    if(isInputEmpty(id)){
        alert(alerta);
        setOutlineBorderText(input, "red");
    }
    else{
        setOutlineBorderText(input, "var(--primary-color)");
        var span = createComponent("span", classname);
        span.innerText = input.value;

        return span
    }
}

function getFecha() {
    var fecha = new Date();
    return (parseFecha(fecha.getUTCDate()) + "-" + (parseFecha(fecha.getUTCMonth() + 1)) + "-" + parseFecha(fecha.getFullYear()));
}

function parseFecha(date){
    if(date < 10){
        return "0" + date;
    }
    return date;
}

function displayCommentsForm() {
    var button = document.getElementById("id-comment-link");
    var arrow = document.getElementById("comment-arrow")
    var divContainer = document.getElementById("id-comment-form-container");

    if (divContainer.style.display === "") {
        button.style.color = "var(--primary-color)";
        arrow.style.transform = "rotate(90deg)";
        divContainer.style.display = "block";
    }
    else {
        button.style.color = "black";
        arrow.style.transform = "rotate(0deg)";
        divContainer.style.display = "";
    }
}

function getSpanFecha() {
    var spanFecha = createComponent("span", "fecha");
    spanFecha.innerText = getFecha();

    return spanFecha;
}

function getDivAutorFecha() {
    var divAutorFecha = createComponent("div", "autor-fecha");
    divAutorFecha.append(getSpan("input-name", "autor", "Introduzca su nombre"));
    divAutorFecha.append(getSpanFecha());

    return divAutorFecha;
}

function getDivResena() {
    var divResena = createComponent("div", "div-resena");
    divResena.append(getSpan("input-comment", "resena", "Introduzca su comentario"));

    return divResena;
}

function getDivComentario() {
    var divComentario = createComponent("div", "comentario");
    divComentario.append(getDivAutorFecha());
    divComentario.append(getDivResena());

    return divComentario;
}

function checkEmail() {
    var email = document.getElementById("input-mail");
    var result = /^\w+([\.-]?\w+)*@(gmail|hotmail|correo\.ugr)\.(com|es|org)/.test(email.value);

    if(!result){
        if(isInputEmpty("input-mail")){
            alert("Introduzca su correo");
        }
        else{
            alert("Introduzca un correo valido");
        }
        setOutlineBorderText(email, "red");
    }
    else
        setOutlineBorderText(email, "var(--primary-color)");

    return result;
}

function canAddComment() {
    // · Autor, correo o comentario incorrecto return false
    if(isInputEmpty("input-comment")){
        return false;
    }

    return true;
}

function addComment() {
    var list = document.getElementById("id-ul-list-comment");
    var li = document.createElement("li");
    li.classList.add("li-list-comment");
    
    li.append(getDivComentario());

    if(canAddComment()){
        list.prepend(li);
        uploadComment();
        clearInput("input-name");
        clearInput("input-comment");
    }
}

function uploadComment() {
    var user_id = document.getElementById("user-id").value;
    var comment = document.getElementById("input-comment").value;
    var fecha = getFecha();
    var id_sneaker = document.getElementById("id-sneaker").value

    var newComment = [id_sneaker, user_id, comment, fecha];

    var comment = JSON.stringify(newComment);

    var ajax = new XMLHttpRequest();
    var asynchronous = true;
    
    ajax.open("POST", "add_comment.php", asynchronous);
    ajax.setRequestHeader("Content-type", "application/json")
    ajax.send(comment);
}

function checkRudeWord() {
    var comment = document.getElementById("input-comment");

    var ajax = new XMLHttpRequest();
    var asynchronous = true;
    
    ajax.open("GET", "/src/badwords.php", asynchronous);
    ajax.send();

    ajax.onreadystatechange = function() {
        if(this.readyState == 4 && this.status == 200){
            var rudeWords = JSON.parse(this.responseText);

            var wordArray = comment.value.split(" ");
            var lastWord = wordArray[wordArray.length - 2];
            var bannedWord = "";

            for(var i = 0; i < rudeWords.length; i++){
                if(rudeWords[i].toLowerCase() === lastWord.toLowerCase()){
                    for(var j = 0; j < lastWord.length; j++)
                        bannedWord += "*";

                    wordArray[wordArray.length - 2] = bannedWord;
                    comment.value = "";

                    for(var j = 0; j < wordArray.length - 1; j++)
                        comment.value += wordArray[j] + " ";
                }
            }
        }
    }
}

function checkWord(key) {
    if(key.key == " " || key.key == "," || key.key == ".")
        checkRudeWord();
}
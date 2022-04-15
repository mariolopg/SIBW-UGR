window.onload = function (){
    document.getElementById("id-comment-link").addEventListener("click", displayCommentsForm);
    document.getElementById("input-submit").addEventListener("click", addComment);
    document.getElementById("input-comment").addEventListener("keypress", checkWord);

    // Generate comments
    generateComment("Juan", "Estas zapatillas son muy cómodas.");
    generateComment("Pablo", "Me llegaron a tiempo. Un poco caras.");
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
    return (fecha.getUTCDate() + "/" + (fecha.getUTCMonth() + 1) + "/" + fecha.getFullYear());
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
    if(!checkEmail() || isInputEmpty("input-name") || isInputEmpty("input-comment")){
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
        clearInput("input-name");
        clearInput("input-mail");
        clearInput("input-comment");
    }
}

function checkRudeWord() {
    var comment = document.getElementById("input-comment");
    var rudeWords = ["tonto", "gilipollas", "capullo", "mierda", "cipote", "puta"];

    var wordArray = comment.value.split(" ");
    var lastWord = wordArray[wordArray.length - 1];
    var bannedWord = "";

    if(rudeWords.includes(lastWord)){
        for(var i = 0; i < lastWord.length; i++)
            bannedWord += "*";

        wordArray[wordArray.length - 1] = bannedWord;
        comment.value = "";

        for(var i = 0; i < wordArray.length - 1; i++)
            comment.value += wordArray[i] + " ";

        comment.value += wordArray[wordArray.length - 1];
    }

}

function checkWord(key) {
    if(key.key == " " || key.key == "," || key.key == ".")
        checkRudeWord();
}
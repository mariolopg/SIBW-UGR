window.onload = function (){
    document.getElementById("id-comment-link").addEventListener("click", displayCommentsForm);
    document.getElementById("input-submit").addEventListener("click", addComment);
    document.getElementById("input-comment").addEventListener("keypress", checkWord);
};

function clearInput(id) {
    document.getElementById(id).value = "";
}

function setOutline(component, color) {
    component.style.outlineColor = color;
}

function isInputEmpty(id) {
    var component = document.getElementById(id);
    var bool = false;

    if(component.value === ""){
        bool = true;   
    }

    return bool;
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

function getSpanAutor() {

    var autor = document.getElementById("input-name");

    if(isInputEmpty("input-name")){
        alert("Introduzca su nombre");
        setOutline(autor, "red");
    }
    else{
        setOutline(autor, "var(--primary-color)");
        var spanAutor = document.createElement("span");
        spanAutor.innerText = autor.value;
        spanAutor.classList.add("autor");

        return spanAutor;
    }
}

function getSpanFecha() {
    var spanFecha = document.createElement("span");
    spanFecha.innerText = getFecha();
    spanFecha.classList.add("fecha");

    return spanFecha;
}

function getDivAutorFecha() {
    var divAutorFecha = document.createElement("div");
    divAutorFecha.classList.add("autor-fecha");
    divAutorFecha.append(getSpanAutor());
    divAutorFecha.append(getSpanFecha());

    return divAutorFecha;
}

function getSpanResena() {
    
    var comentario = document.getElementById("input-comment");

    if(isInputEmpty("input-comment")){
        alert("Introduzca su comentario");
        setOutline(comentario, "red");
    }
    else{
        setOutline(comentario, "var(--primary-color)");
        var spanResena = document.createElement("span");
        spanResena.innerText = comentario.value;
        spanResena.classList.add("resena");

        return spanResena;
    }
}

function getDivResena() {
    var divResena = document.createElement("div");
    divResena.classList.add("div-resena");
    divResena.append(getSpanResena());

    return divResena;
}

function getDivComentario() {
    var divComentario = document.createElement("div");
    divComentario.classList.add("comentario");
    divComentario.append(getDivAutorFecha());
    divComentario.append(getDivResena());

    return divComentario;
}

function checkEmail() {
    var email = document.getElementById("input-mail");
    var result = /^\w+([\.-]?\w+)*@(gmail|hotmail|correo\.ugr)\.(com|es|org)/.test(email.value);

    if(!result){
        alert("Introduzca un correo valido");
        setOutline(email, "red");
    }
    else
        setOutline(email, "var(--primary-color)");

    return result;
}

function canAddComment() {
    // · Autor, correo o comentario incorrecto return false
    if(!checkEmail() || isInputEmpty("input-name") || isInputEmpty("input-mail") || isInputEmpty("input-comment")){
        return false;
    }

    return true;
}

function addComment() {
    var list = document.getElementById("id-ul-list-comment");
    var li = document.createElement("li");
    li.classList.add("li-list-comment")
    
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

        for(var i = 0; i < wordArray.length; i++)
            comment.value += wordArray[i] + " ";
    }

}

function checkWord(key) {
    if(key.key == " ")
        checkRudeWord();
}
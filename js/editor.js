import { exec, init } from '../pell-master/src/pell.js';

const editor = init({
    element: document.getElementById('editor'),
    defaultParagraphSeparator: 'p',
    styleWithCSS: true,
    actions: [
        'bold',
        'underline',
        'italic',
        'paragraph',
        'heading2',
        'heading3',
        'olist',
        'ulist',
        {
            name: "justifyLeft",
            icon: '<img src="img/left.svg"/>',
            title: 'left',
            result: () => exec("justifyLeft")
        },
        {
            name: "justifyCenter",
            icon: '<img src="img/center.svg"/>',
            title: 'center',
            result: () => exec("justifyCenter")
        }
        ,
        {
            name: "justifyRight",
            icon: '<img src="img/right.svg"/>',
            title: 'right',
            result: () => exec("justifyRight")
        }
    ],
    classes: {
        actionbar: 'pell-actionbar',
        button: 'pell-button',
        content: 'pell-content',
        selected: 'pell-button-selected'
    }
});


editor.content.innerHTML ="<p>Votre texte ici...</p>";

// editor.content<HTMLElement>
// To change the editor's content:
console.clear();


var bouton = document.getElementsByName("submitArticle")[0];
var content = document.getElementsByClassName("pell-content")[0];


//Placeholder fait maison
content.addEventListener("focus",function () {
    if(content.textContent === "Votre texte ici..."){
        content.textContent = "";
    }
});


bouton.addEventListener("click",function (event) {
    event.preventDefault();
    var texte = content.innerHTML;
    $.ajax({
        type: "post",
        data: "title="+$("#inputTitle").val()+"&content="+texte,
        url: "php/controller.php",
        success: function () {
            console.log("wesh ca marche");
        },
        error: function(e){
            console.log(e);
        },
        dataType: "html"
    });
});


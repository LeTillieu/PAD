import { exec, init } from '../pell-master/src/pell.js';

//'tool' bar
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



console.clear();



//initialization of variables
var addArticleButton = document.getElementsByName("submitComment")[0];
var content = document.getElementsByClassName("pell-content")[0];
var id = 0;
content.innerHTML = "<p>Votre texte ici...</p>";

//Placeholder fait maison
content.addEventListener("focus",function () {
    if(content.textContent === "Votre texte ici..."){
        content.textContent = "";
    }
});

//add article to db
addArticleButton.addEventListener("click",function (event) {
    event.preventDefault();
    var comment = content.innerHTML;
    var articleId = $("#article").val();

    $.ajax({
        type: "POST",
        url: "php/controller.php",
        data: {comment: comment, articleId: articleId},
        success: function () {
            //redirection
            window.location.replace("article.php?article="+articleId);
        },
        error: function(e){
            console.log("Impossible d'ajouter cet article");
            console.log(e);
        },
        dataType: "html"
    });

});




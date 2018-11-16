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
            icon: '<',
            title: 'left',
            result: () => exec("justifyLeft")
        },
        {
            name: "justifyCenter",
            icon: '-',
            title: 'center',
            result: () => exec("justifyCenter")
        }
        ,
        {
            name: "justifyRight",
            icon: '>',
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

// editor.content<HTMLElement>
// To change the editor's content:
editor.content.innerHTML = '<p style="text-align: left;">Ecrivez ici</p>'
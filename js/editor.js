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
        'heading1',
        'heading2',
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
        actionbar: 'pell-actionbar-custom-name',
        button: 'pell-button-custom-name',
        content: 'pell-content-custom-name',
        selected: 'pell-button-selected-custom-name'
    }
});

// editor.content<HTMLElement>
// To change the editor's content:
editor.content.innerHTML = 'your message'
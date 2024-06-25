// web/js/copy.js

function copyToClipboard(element) {
    var content = element.getAttribute('data-content');

    var textarea = document.createElement('textarea');
    textarea.value = content;
    document.body.appendChild(textarea);
    textarea.select();
    var successful = document.execCommand('copy');
    document.body.removeChild(textarea);

    if (successful) {
        alert('Successful');
        window.location.href = element.href;
    } else {
        alert('Error');
    }
}

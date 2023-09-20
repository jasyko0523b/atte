var type = js_type;

let start = document.getElementById('start');
let finish = document.getElementById('finish');
let break_start = document.getElementById('break_start');
let break_finish = document.getElementById('break_finish');

switch (type) {
    case 0:
        start.disabled = true;
        finish.disabled = false;
        break_start.disabled = false;
        break_finish.disabled = true;
        break;
    case 1:
        start.disabled = false;
        finish.disabled = true;
        break_start.disabled = true;
        break_finish.disabled = true;
        break;
    case 2:
        start.disabled = true;
        finish.disabled = true;
        break_start.disabled = true;
        break_finish.disabled = false;
        break;
    case 3:
        start.disabled = true;
        finish.disabled = false;
        break_start.disabled = false;
        break_finish.disabled = true;
        break;
    default:
        finish.disabled = true;
        break_start.disabled = true;
        break_finish.disabled = true;
        break;
};
// get object
function O(i) {
    if (typeof i == 'object') {
        return i
    }
    return document.getElementById(i)
}

function S(i) {
    return O(i).style
}

function C(i) {
    return document.getElementsByClassName(i)
}

window.onload = function () {

    var search = document.getElementById("search");
    search.onkeyup = function (event) {
        if(event.keyCode === 13){
            document.write(search.value);
        }
    }

};
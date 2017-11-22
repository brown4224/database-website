
function toggle(id_1, id_2){
    if(document.getElementById(id_1).classList.contains('hide')){
        document.getElementById(id_1).className = "row jumbotron";
        document.getElementById(id_2).className = "row jumbotron";
    } else{
        document.getElementById(id_1).className = "hide";
        document.getElementById(id_2).className = "hide";
    }
}
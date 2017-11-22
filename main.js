
function toggle(id_1, id_2){
    if(document.getElementById(id_1).classList.contains('hide')){
        document.getElementById(id_1).className = "row jumbotron";
        document.getElementById(id_2).className = "row jumbotron";
    } else{
        document.getElementById(id_1).className = "hide";
        document.getElementById(id_2).className = "hide";
    }
}


function filter(query){
    console.log("start filter");
    if(query.length > 0){

        var list = document.getElementsByName('results');
        var sublist = document.getElementsByName('results-sublist');
        for (var i = 0; i< list.length; i++){
            if(list[i].id == query){
                if(!list[i].classList.contains('hide')){
                    list[i].className = "";
                }
            } else{
                list[i].className = "hide";
            }
        }
        for(var i = 0; i< sublist.length; i++){
            sublist[i].className = "hide"
        }
    } else{
        console.log("show all");
        var list = document.getElementsByName('results');
        for (var i = 0; i< list.length; i++){
            console.log(list);
            console.log('true');
            list[i].className = ""
        }
    }
}
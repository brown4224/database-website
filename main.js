function toggle(row, num){
    row++;
    num--;  // Remove first row.

    if(document.getElementById(row).classList.contains('hide')){
        var $val = "row jumbotron";
    } else{
        var $val = "hide";
    }

    for(var i = 0; i< num; i++){
        document.getElementById(row + i).className = $val;
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
        var list = document.getElementsByName('results');
        for (var i = 0; i< list.length; i++){
              list[i].className = ""
        }
    }
}
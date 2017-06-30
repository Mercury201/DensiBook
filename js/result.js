function changeElement(element){
    var selectMember = element.parentNode;
    // alert(element.innerHTML);
    selectMember.parentNode.parentNode.firstChild.nextSibling.innerHTML = element.innerHTML + ' <span class="caret"></span>';
    selectMember.parentNode.nextSibling.nextSibling.value = selectMember.value;
}

//セレクトボックスが選択されているかチェックする
function checkSelect(){
    var selectMember = document.getElementById("selectUserId");
    if(selectMember.value.match(/\S/g)){
        return true;
    }else{
        alert("選手を選択してください");
        return false;
    }
}
var benchMemberNum = new Array();
var startMemberNum = new Array(9);

function setHanded(nameList){
    var number = nameList.parentNode.value;
    // alert(number);
    // テーブル取得
    var table = document.getElementById("myOrder");
    // alert(nameList.parentNode.parentNode.parentNode.innerHTML);
    
    var orderNum = nameList.parentNode.parentNode.parentNode.parentNode.parentNode.sectionRowIndex;
    // alert(orderNum);
    if(number == "0"){
        if(orderNum > 9){
            // alert(benchMemberNum);
            
            benchMemberNum.splice(orderNum - 10, 1);
            // alert(orderNum);
            
            var memberNum = table.rows.length - 1;
            // alert(memberNum);
            if(memberNum != orderNum){
                removeBench(orderNum, table, nameList);
            }
            
            return;
        }else{
            delete startMemberNum[orderNum - 1];
            var batting = "";
        
            var pitching = "";
        }
        
    }else{
        if(orderNum > 9){
            benchMemberNum[orderNum - 10] = number;
            addBench(orderNum, table);
        }else{
            startMemberNum[orderNum - 1] = number;
        }
        var batting = eval("batting" + number);
    
        var pitching = eval("pitching" + number);
    }
    
    // alert(bat);
    
    
    //var abc = num;
    
    document.getElementsByName("batting" + orderNum)[0].innerHTML=batting;
    document.getElementsByName("pitching" + orderNum)[0].innerHTML=pitching;
    
    
    
    //var_dump($member);
}

function addBench(orderNum, table){
    
    //行数を取得
    var row_len = table.rows.length;
    
    if(row_len - 1 == orderNum){
        // 行を行末に追加
        var row = table.insertRow(-1);
        
        var cell1 = row.insertCell(-1);
        var cell2 = row.insertCell(-1);
        var cell3 = row.insertCell(-1);
        var cell4 = row.insertCell(-1);
        var cell5 = row.insertCell(-1);
        
        var count = memberCount;
        // var drop = '<select name="membername' + row_len + '"onChange="setHanded(value, this);">';
        // drop = drop + '<option value="blank"></option>';
        // for(var i = 0; i < count; i++){
        //     var num = eval("userNo" + i);
        //     var name = eval("userName" + i);
            
        //     drop = drop + '<option value="' + num + '">' + name + '</option>'
            
            
        // }
        // drop = drop + '</select>';
        
        var drop = '<div class="dropdown"><button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">';
        drop = drop + '選手選択<span class="caret"></span>';
        drop = drop + '</button>';
        drop = drop + '<ol class="dropdown-menu">';
        drop = drop + '<li value="0"><a href="#" onclick="changeBenchMemberElement(this),setHanded(this);return false;">　</a></li>';
        // alert(count);
        for(var i = 0; i < count; i++){
            var num = eval("userNo" + i);
            var name = eval("userName" + i);
            drop = drop + '<li value="' + num + '"><a href="#" data-value="' + name + 
            '" onclick="changeBenchMemberElement(this),setHanded(this);return false;">' + name + '</a></li>';
        }
        
        drop = drop + '</ol>';
        drop = drop + '<input type="hidden" name="member' + row_len + '" value="">';
        drop = drop + '</div>';
        
        var drop2 = '<p name="batting' + row_len + '"></p>';
        
        
        cell1.innerHTML = "控え";
        cell2.innerHTML = drop;
        cell4.innerHTML = drop2;
        cell5.innerHTML = '<p name="pitching' + row_len + '"></p>';
        
    }
    
    
    
}

function removeBench(orderNum, table, nameList){
    
    
    //行数を取得
    var row_len = table.rows.length;
    
    for(var i = 0; i < row_len - orderNum - 1; i++){
        var changeRow = i + orderNum;
        var collection = table.rows;
        
        var tr = collection.item(changeRow + 1);
        
        //var td = tr.cells.item(1);
        
        // alert(td.firstChild.name);
        //td.firstChild.name = "membername" + changeRow;
        // alert(td.firstChild.name);
        
        var td = tr.cells.item(1);
        
        //alert(td.firstChild.name);
        // td.firstChild.name = "membername" + changeRow;
        td.firstChild.lastChild.name = "member" + changeRow;
        
        
        var wBatting = document.getElementsByName("batting" + tr.sectionRowIndex)[0].innerHTML;
        var td = tr.cells.item(3);
        //alert(wBatting);
        td.firstChild.parentNode.innerHTML = '<p name="batting' + changeRow + '">' + wBatting + '</p>';
        
        var wPitching = document.getElementsByName("pitching" + tr.sectionRowIndex)[0].innerHTML;
        var td = tr.cells.item(4);
        //alert(wPitching);
        td.firstChild.parentNode.innerHTML = '<p name="pitching' + changeRow + '">' + wPitching + '</p>';
        
    }
    
    
    // 変更された行を取得
    // tr = nameList.parentNode.parentNode;
    tr = nameList.parentNode.parentNode.parentNode.parentNode.parentNode;
    // alert(tr.innerHTML);
    // trのインデックスを取得して行を削除する
    tr.parentNode.deleteRow(tr.sectionRowIndex);
    
    
}

function changeOpponentBench(textarea){
    // alert(textarea.value);
    // alert(textarea.parentNode.parentNode.sectionRowIndex);
    var orderNum = textarea.parentNode.parentNode.sectionRowIndex;
    var table = document.getElementById("opponentOrder");
    var row_len = table.rows.length;
    
    if(textarea.value.match(/\S/g)){
        
        if(orderNum == (row_len - 1)){
            addOpponentBench(table, row_len, orderNum);
        }
        
    }else{
        
        if(orderNum != (row_len - 1)){
            removeOpponentBench(orderNum, table, textarea, row_len);
        }
    }
}

function addOpponentBench(table, row_len, orderNum){
    // alert("add");
    
    var row = table.insertRow(-1);
        
    var cell1 = row.insertCell(-1);
    var cell2 = row.insertCell(-1);
    var cell3 = row.insertCell(-1);
    var cell4 = row.insertCell(-1);
    var cell5 = row.insertCell(-1);
    
    
    
    var drop1 = '<input type="text" name="name' + row_len + '" onblur="changeOpponentBench(this)">'
    
    var drop2 = '<input type="radio" id="bat' + row_len + '" name="opponentBattingHanded' + row_len + '" value="右"checked> 右 ' +
                '<input type="radio" name="opponentBattingHanded' + row_len + '" value="左"> 左';
                
    var drop3 = '<input type="radio" id="throw' + row_len + '" name="opponentThrowHanded' + row_len + '" value="右"checked> 右 ' +
                '<input type="radio" name="opponentThrowHanded' + row_len + '" value="左"> 左';
                
            
    cell1.innerHTML = "控え";
    cell2.innerHTML = drop1;
    cell4.innerHTML = drop2;
    cell5.innerHTML = drop3;
}

function removeOpponentBench(orderNum, table, textarea, row_len){
    // alert("remove");
    
    
    for(var i = 0; i < row_len - orderNum - 1; i++){
        var changeRow = i + orderNum;
        var collection = table.rows;
        
        var tr = collection.item(changeRow + 1);
        
        //var td = tr.cells.item(1);
        
        // alert(td.firstChild.name);
        //td.firstChild.name = "membername" + changeRow;
        // alert(td.firstChild.name);
        
        var td = tr.cells.item(1);
        
        //alert(td.firstChild.name);
        // td.firstChild.name = "membername" + changeRow;
        td.firstChild.name = "name" + changeRow;
        
        
        // var wBatting = document.getElementsByName("opponentBattingHanded" + tr.sectionRowIndex)[0].innerHTML;
        var wBatting = document.getElementsByName("opponentBattingHanded" + tr.sectionRowIndex)[0].checked;
        // alert(wBatting);
        var td = tr.cells.item(3);
        //alert(wBatting);
        // td.firstChild.parentNode.innerHTML = '<p name="batting' + changeRow + '">' + wBatting + '</p>';
        if(wBatting){
            td.innerHTML = '<input type="radio" name="opponentBattingHanded' + changeRow + '" value="右" checked>右'+
                           '<input type="radio" name="opponentBattingHanded' + changeRow + '" value="左">左'
        }else{
            td.innerHTML = '<input type="radio" name="opponentBattingHanded' + changeRow + '" value="右">右'+
                           '<input type="radio" name="opponentBattingHanded' + changeRow + '" value="左" checked>左'
        }
        
        var wPitching = document.getElementsByName("opponentThrowHanded" + tr.sectionRowIndex)[0].checked;
        var td = tr.cells.item(4);
        //alert(wPitching);
        // td.firstChild.parentNode.innerHTML = '<p name="pitching' + changeRow + '">' + wPitching + '</p>';
        if(wPitching){
            td.innerHTML = '<input type="radio" name="opponentThrowHanded' + changeRow + '" value="右" checked>右'+
                           '<input type="radio" name="opponentThrowHanded' + changeRow + '" value="左">左'
        }else{
            td.innerHTML = '<input type="radio" name="opponentThrowHanded' + changeRow + '" value="右">右'+
                           '<input type="radio" name="opponentThrowHanded' + changeRow + '" value="左" checked>左'
        }
        
        
    }
    
    // 変更された行を取得
    // tr = nameList.parentNode.parentNode;
    var tr = textarea.parentNode.parentNode;
    // alert(tr.innerHTML);
    // trのインデックスを取得して行を削除する
    tr.parentNode.deleteRow(tr.sectionRowIndex);
}

function setFormData(f){
    if(f.action.match(/GroupMenu/)){
        return true;
    }
    
    var intend = true;
    var opponent = f.opponent.value;
    var red = "#800000";
    var green = "#dff0d8";
    var white = "#ffffff";
    
    if(f.top.checked){
        // document.getElementById("top").parentNode.className = "bg-success";
        document.getElementById("top").parentNode.style.backgroundColor = green;
        document.getElementById("top").parentNode.style.color = "#000000";
    }else if(f.bottom.checked){
        // document.getElementById("top").parentNode.className = "bg-success";
        document.getElementById("top").parentNode.style.backgroundColor = green;
        document.getElementById("top").parentNode.style.color = "#000000";
    }else{
        // document.getElementById("top").parentNode.className = "bg-danger";
        document.getElementById("top").parentNode.style.backgroundColor = "#800000";
        document.getElementById("top").parentNode.style.color = "#ffffff";
        intend = false;
    }
    
    
    if(!opponent.match(/\S/g)){
        // document.getElementsByName("opponent")[0].parentNode.className = "bg-danger";
        document.getElementsByName("opponent")[0].parentNode.style.backgroundColor = "#800000";
        document.getElementsByName("opponent")[0].parentNode.style.color = "#ffffff";
        document.getElementsByName("opponent")[0].style.color = "#000000";
        intend = false;
    }else{
        // document.getElementsByName("opponent")[0].parentNode.className = "bg-success";
        document.getElementsByName("opponent")[0].parentNode.style.backgroundColor = green;
        document.getElementsByName("opponent")[0].parentNode.style.color = "#000000";
    }
    
    var location = f.location.value;
    if(!location.match(/\S/g)){
        
        // document.getElementsByName("location")[0].parentNode.className = "bg-danger";
        document.getElementsByName("location")[0].parentNode.style.backgroundColor = "#800000";
        document.getElementsByName("location")[0].parentNode.style.color = "#ffffff";
        document.getElementsByName("location")[0].style.color = "#000000";
        intend = false;
    }else{
        // document.getElementsByName("location")[0].parentNode.className = "bg-success";
        document.getElementsByName("location")[0].parentNode.style.backgroundColor = green;
        document.getElementsByName("location")[0].parentNode.style.color = "#000000";
    }
    
    //return false;
    var playerNum = startMemberNum.concat(benchMemberNum);
    var startPosition = new Array(9);
    var opponentPlayer = new Array();
    var opponentPosition = new Array();
    var opponentBattingHanded = new Array();
    var opponentThrowHanded = new Array();
    
    var table = document.getElementById("opponentOrder");
    
    var opponentMembers = table.rows.length - 2;
    
    for(var i = 0; i < opponentMembers; i++){
        var j = i + 1;
        if(eval("f.name" + j + ".value").match(/\S/g)){
            opponentPlayer[i] = eval("f.name" + j + ".value");
            // alert(eval("f.bat" + j).checked);
            // alert(document.forms.eval(bat+j).checked);
            if(eval("f.bat" + j).checked){
                opponentBattingHanded[i] = "右";
            }else{
                opponentBattingHanded[i] = "左";
            }
            
            if(eval("f.throw" + j).checked){
                opponentThrowHanded[i] = "右";
            }else{
                opponentThrowHanded[i] = "左";
            }
            
        }else{
            opponentPlayer[i] = undefined;
        }
        
        
        
    }
    
    for(var i = 0; i < 9; i++){
        var j = i + 1;
        
        startPosition[i] = eval("f.position" + j + ".value");
        
        if(eval("f.opponentPosition" + j + ".value").match(/\S/g)){
            opponentPosition[i] = eval("f.opponentPosition" + j + ".value");
        }else{
            opponentPosition[i] = 0;
        }
        // alert(opponentPosition);
    }
    // alert(opponentPosition);
    // alert(opponentPlayer);
    // if(1 == 1){
    //     return false;
    // }
    // alert(playerNum.length);
    // alert(playerNum);
    for(var i = 0; i < playerNum.length; i++){
        if(playerNum[i] == undefined){
            //alert((i + 1) + '番が空');
            changeBackgroundColor("member" + (i + 1), red);
            intend = false;
        }else{
            if(playerNum.indexOf(playerNum[i]) !== playerNum.lastIndexOf(playerNum[i])) {
                
                changeBackgroundColor("member" + (i + 1), red);
                intend = false;
            }else{
                changeBackgroundColor("member" + (i + 1), white);
            }
        }
        
        
        
    }
    
    for(var i = 0; i < opponentMembers; i++){
        // alert(opponentPlayer[i]);
        if(opponentPlayer[i] == undefined){
            changeTextboxColor("name" + (i + 1), red);
        }else{
            changeTextboxColor("name" + (i + 1), white);
        }
    }
    
    for(var i = 0; i < 9; i++){
        if(startPosition.indexOf(startPosition[i]) !== startPosition.lastIndexOf(startPosition[i])) {
            // alert(startPosition[i]);
            
            changeBackgroundColor("position" + (i + 1), red);
            intend = false;
        }else{
            changeBackgroundColor("position" + (i + 1), white);
        }
        
        if(opponentPosition.indexOf(opponentPosition[i]) !== opponentPosition.lastIndexOf(opponentPosition[i])) {
            
            changeBackgroundColor("opponentPosition" + (i + 1), red);
            
        }else if(opponentPosition[i] == 0){
            
            changeBackgroundColor("opponentPosition" + (i + 1), red);
            
        }else{
            
            changeBackgroundColor("opponentPosition" + (i + 1), white);
            
        }
    }
    //benchMemberNum.filter()
    //f.bench.value = benchMemberNum;
    //return intend;
    
    if(intend){
        // alert("ab");
        // f.bench.value = benchMemberNum;
        // f.bench.value = "2";
        // alert(f.benchNum.value);
        f.benchNum.value = benchMemberNum;
        f.opponentName.value = opponentPlayer;
        f.opponentPosition.value = opponentPosition;
        f.opponentBattingHanded.value = opponentBattingHanded;
        f.opponentThrowHanded.value = opponentThrowHanded;
    }
    return intend;
}

function changeBackgroundColor(name, color){
    // document.getElementsByName(name)[0].parentNode.parentNode.className = color;
    document.getElementsByName(name)[0].parentNode.parentNode.style.backgroundColor = color;
}

function changeTextboxColor(name, color){
    // document.getElementsByName(name)[0].parentNode.className = color;
    document.getElementsByName(name)[0].parentNode.style.backgroundColor = color;
}


function changeElement(element){
    var selectPosition = element.parentNode;
    selectPosition.parentNode.parentNode.firstChild.nextSibling.innerHTML = element.innerHTML + ' <span class="caret"></span>';
    selectPosition.parentNode.nextSibling.nextSibling.value = element.innerHTML;
    
    // element.parents('.dropdown').find('.dropdown-toggle').html($(element).text() + ' <span class="caret"></span>');
    // $(element).parents('.dropdown').find('input[name="dropdown-value"]').val($(element).attr("data-value"));
    
}

function changeMemberElement(element){
    var selectMember = element.parentNode;
    // alert(element.innerHTML);
    selectMember.parentNode.parentNode.firstChild.nextSibling.innerHTML = element.innerHTML + ' <span class="caret"></span>';
    selectMember.parentNode.nextSibling.nextSibling.value = selectMember.value;
    // alert(selectMember.value);
}

function changeBenchMemberElement(element){
    var selectMember = element.parentNode;
    // alert(selectMember.parentNode.parentNode.firstChild.innerHTML);
    selectMember.parentNode.parentNode.firstChild.innerHTML = element.innerHTML + ' <span class="caret"></span>';
    selectMember.parentNode.nextSibling.value = selectMember.value;
}
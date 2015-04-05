function loginPopup() {
	document.getElementById('login_form_outer').style.display = 'block';
	document.getElementById('login_cover').style.display = 'block';
}

function registerPopup() {
	document.getElementById('register_form_outer').style.display = 'block';
	document.getElementById('login_cover').style.display = 'block';
}

function registerGooglePopup() {
	document.getElementById('registergoogle_form_outer').style.display = 'block';
	document.getElementById('login_cover').style.display = 'block';
}

function popupOff() {
	document.getElementById('login_form_outer').style.display = 'none';
	document.getElementById('register_form_outer').style.display = 'none';
        document.getElementById('login_cover').style.display = 'none';
        if(document.getElementById('registergoogle_form_outer') != null)
            document.getElementById('registergoogle_form_outer').style.display = 'none';
}

/*
var ajaxRequest;
function ajaxFunction(){
    try{
        ajaxRequest = New XMLHttpRequest();
    }catch (e){
        try{
        ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
        }catch (e){
            alert("You fucked up");
            return false;
        }
    }
}
function processRequest(){
    if (req.readyState == 4){
        if (req.status == 200){
            if(event.data == "messageNewPost")
                displayMessageNewPosts(3000);
        }
    }
}*/

 
// -------------------- DATA PUSHING ---------------------------- 
 
/**
 * Kui eventsource saab vastuse, siis peaks:
 *                                  if(event.data == "messageNewPost")
                                        displayMessage"Teemasse lisati uus kommentaar", 3000);
 * @param {type} url - controlleri funktsioon, mida hakatakse kuulama
 */
function createEventSource(url){
    if(typeof(EventSource) !== "undefined") {
        var source = new EventSource(url);
        source.addEventListener("message", function(e) {
            if(e.data == "messageNewPost")
                displayMessage("Teemasse lisati uus kommentaar", 3000);
        }, false);
    }else{
        alert("Sinu brauser ei toeta Server-sent sündmusi! Palun uuenda!");
    }
}

/**
 * 
 * @param {type} timeout in milliseconds
 * @returns {undefined}
 */
function displayMessage(message, timeout){
    document.getElementById('messageNewPosts_outer').style.display = 'block';
    $('#messageNewPosts_inner').html(message);
    setTimeout(function(){
        $('#messageNewPosts_outer').fadeOut('slow');
    }, timeout);
}


// ----------------------------------- AJAX CALLS ----------------------------------

/**
 * base_url - lehekülje baas url. nt http://ksm.cs.ut.ee/
 * tid - topic id
 * page_nr - lehekülje number
 * root_post_id - kommentaari id, mille vastuseid selle meetodiga peab tagastama
 * offset - mitu kommentaari jäetakse vahele. nt Kui offset 0 korral tagastatakse kommentaarid 1 kuni 10,
 * siis offset 5 korral tagastatakse kommentaarid 6 kuni 15
 * disable_hash, kas argumendid jäetakse urli hashi meelde või mitte?
 */
function loadPostContent(base_url, tid, page_nr, root_post_id, offset, disable_hash, replace_with_id, extradepth, prev_url){
    if(disable_hash != 'undefined' && (!disable_hash  || disable_hash == "0")){
        addHash({a: base_url,b: tid,c: page_nr,d: root_post_id,e: offset, f: replace_with_id, g: extradepth, h: prev_url});
    }
    //get xml and xslt
    var xml;
    $.ajax({
        method: "GET",
        url: base_url+"ajax/posts_content/"+tid+"/"+page_nr+"/"+root_post_id+"/"+offset+"/"+extradepth+"/"+prev_url,
        async: false
    }).done(function(data) {
        xml = data;
    });
    var xsl;
    $.ajax({
        method: "GET",
        url: base_url+"assets/xslt/posts.xsl",
        async: false
    }).done(function(data) {
        xsl = data;
    });
    
    var xsltProcessor = new XSLTProcessor();
    xsltProcessor.importStylesheet(xsl);
    var resultDocument = xsltProcessor.transformToFragment(xml, document);
    if(page_nr != "1"){
        var postContainer = $('.post_container[id="'+replace_with_id+'-'+page_nr+'"]');
    }else{
        var postContainer = $('.post_container[id="'+replace_with_id+'"]');
    }
    
    postContainer.removeClass("post_container");
    postContainer.empty().append(resultDocument); 
}

//------------------------------------------ AJAX BOOKMARKS ----------------------------
function addHash(data){
    if(window.location.hash.match("^#d=")){
        var base64encoded = window.location.hash.substring(3);
        var current_data = JSON.parse(atob(base64encoded));
        
        var in_array = false;
        for(var i = 0;i<current_data.length;i++){
            var data_val = current_data[i];
            if(data_val.a === data.a &&
               data_val.b === data.b &&
               data_val.c === data.c &&
               data_val.d === data.d &&
               data_val.e === data.e &&
               data_val.f === data.f &&
               data_val.g === data.g &&
               data_val.h === data.h){
                in_array = true;
                break;
            }
        }
        
        if(!in_array){
            current_data.push(data);
            
            window.location.hash = "d="+btoa(JSON.stringify(current_data));
        }
    }else{
        current_data = [data];
        
        window.location.hash = "d="+btoa(JSON.stringify(current_data));
    }
}


function checkHash() {
    if(window.location.hash.match("^#d=")){
        var base64encoded = window.location.hash.substring(3);
        var hashes = JSON.parse(atob(base64encoded));
        
        for(var i = 0;i<hashes.length;i++){
            var ti = hashes[i];
            loadPostContent(ti.a, ti.b, ti.c, ti.d, ti.e, true, ti.f, ti.g, ti.h);
        }
    }
}

// -------------------- OFFLINE DATABASE AND ADD POST ----------------------------

function setCookie(name,value,days) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime()+(days*24*60*60*1000));
        var expires = "; expires="+date.toGMTString();
    }
    else var expires = "";
    document.cookie = name+"="+value+expires+"; path=/";
}

function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}

function delCookie(name) {
    createCookie(name,"",-1);
}

function checkOnline(){
    if(typeof(EventSource) !== "undefined") {
        var source = new EventSource(location.origin+'/serversend/upload_posts');
        source.addEventListener("message", function(e) {
            //console.log(e.data);
        }, false);

        source.addEventListener("open", function(e) {
            console.log("Connection was opened. ");
            handleOfflinePosting(true);
        }, false);

        source.addEventListener("error", function(e) {
            if(e.target.readyState != 2){
                console.log("Error - connection was lost. ");
                handleOfflinePosting(false);
            }
        }, false);
    }else{
        alert("Sinu brauser ei toeta Server-sent sündmusi! Palun uuenda!");
    }
}

function handleOfflinePosting(online){
    //delCookie("online");
    if(getCookie("online1") != online){ //state changed
        if(online){
            setCookie("online1", "1", 1);
            console.log("NOW ONLINE!");
            uploadOfflinePosts();
        }else{
            setCookie("online1", "0", 1);
            console.log("NOW OFFLINE");
        }
    }else{
        console.log("Status check, is online?:" + online);
    }
}

function clickedAddPost(id){
    if(getCookie("online1") == "0"){
        var timer = 3000;
        //disable nupp
        $('form button[class="ajax_button"]').attr('disabled', 'disabled');
        
        //form validation
        var content = $('#addPostContentWrapper textarea').val();
        if(content.length < 1){
            $('#messageNewPosts_inner').css("color", "red");
            displayMessage("Kommentaar ei tohi olla tühi!", timer);
            return;
        }else if(content.length > 5000){
            $('#messageNewPosts_inner').css("color", "red");
            displayMessage("Kommentaar ei tohi ületada 5000 tähemärki! Hetkel on " + content.length + " tähemärki.", timer);
            return;
        }
        console.log("Storing post to DB");
        //add to DB
        storePostToDB(id, content);
        
        displayMessage("Teie kommentaar jäeti meelde. Taasühendusel pannakse see üles.", timer);
        return;
    }
    $('form[value="addpost"]').submit();
}

//STORE
function storePostToDB(id, content){
    var db = openDatabase("clientdb", "1.0", "Client-Side Database", 2 *1024 * 1024);
    
    db.transaction(function(tx){
        tx.executeSql('CREATE TABLE IF NOT EXISTS Posts(p_pid INTEGER, content TEXT, time TIMESTAMP)', []);
        tx.executeSql('INSERT INTO Posts VALUES(?, ?, ?)', [id, content, new Date().getTime()],
          function(tx, rs) {
            //console.log("dunno " + rs)
          },
          function(tx, error) {
            //console.log("error: " + error.message)
          });
    });
}

//UPLOAD STORED
function uploadOfflinePosts(){
    var db = openDatabase("clientdb", "1.0", "Client-Side Database", 2 *1024 * 1024);
    db.transaction(function(tx){
        tx.executeSql('CREATE TABLE IF NOT EXISTS Posts(p_pid INTEGER, content TEXT, time TIMESTAMP)', []);
        tx.executeSql('SELECT * FROM Posts ORDER BY time', [], function(tx, rs) {
          console.log("Found " + rs.rows.length + " rows")
          if(rs.rows.length > 0)
               displayMessage("Oled nüüd võrgus. Sinu kommentaare laetakse üles.", 3000);
          for(var i = 0; i < rs.rows.length; i++) {
                var item = rs.rows.item(i);
                uploadOfflineClosure(db, item);
          }
        });
    });
}

function uploadOfflineClosure(db, item){
    var p_pid = item.p_pid;
    var content = item.content;
    db.transaction(function(tx){
        tx.executeSql('DELETE FROM Posts WHERE p_pid="'+p_pid+'" AND content="'+content+'"', [],
        function(tx, rs){
            console.log('DELETE FROM Posts WHERE p_pid="'+p_pid+'" AND content="'+content+'"');
            ajaxPostComment(p_pid, content, 0);
         });
    });
    
}

function ajaxPostComment(id, content, i){
    if(i > 5)
        return;
    console.log("Posting: " + id + " " + content);
    var postUrl = location.origin + "/main/addpost/"+id;
    console.log(postUrl);
    $.ajax({
        type: "POST",
        url: postUrl,
        data: {form: "addpost", content: content}
    }).done(function(data){
        console.log("Posting succcess!");
    }).fail(function(data){
        console.log("Posting failed!");
        ajaxPostComment(id, content, i+1);
    });
}

// -------------------- START ----------------------------

function beginCode(){
    checkHash();
    checkOnline(); 
}

$(document).ready(beginCode);




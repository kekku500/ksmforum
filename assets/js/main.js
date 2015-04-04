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

/* Teeb sama, mis jquery get
var ajaxRequest;
 function ajaxFunction(url,cfunc){   //url ja funktsioon, mida readystate muutudes tegema peab
     try{
         ajaxRequest=new XMLHttpRequest();
     }catch (e){
         try{
         ajaxRequest=new ActiveXObject("Microsoft.XMLHTTP");
         }catch (e){
             alert("You fucked up");
             return false;
         }
     }
     ajaxRequest.onreadystatechange=cfunc;
     ajaxRequest.open("GET",url,true);
     ajaxRequest.send();
 }
 */
/**
 * 
 * @param {type} timeout in milliseconds
 * @returns {undefined}
 */
function displayMessageNewPosts(timeout){
    document.getElementById('messageNewPosts_outer').style.display = 'block';
    setTimeout(function(){
        $('#messageNewPosts_outer').fadeOut('slow');
    }, timeout);
}

/**
 * Kui eventsource saab vastuse, siis peaks:
 *                                  if(event.data == "messageNewPost")
                                        displayMessageNewPosts(3000);
 * @param {type} url - controlleri funktsioon, mida hakatakse kuulama
 */
function createEventSource(url){
    $.get(url,function(){
        if(event.data == "messageNewPost"){
            displayMessageNewPosts(3000);
        }
    });
}



/**
 * base_url - lehekülje baas url. nt http://ksm.cs.ut.ee/
 * tid - topic id
 * page_nr - lehekülje number
 * root_post_id - kommentaari id, mille vastuseid selle meetodiga peab tagastama
 * offset - mitu kommentaari jäetakse vahele. nt Kui offset 0 korral tagastatakse kommentaarid 1 kuni 10,
 * siis offset 5 korral tagastatakse kommentaarid 6 kuni 15
 * disable_hash, kas argumendid jäetakse urli hashi meelde või mitte?
 */
function loadPostContent(base_url, tid, page_nr, root_post_id, offset, disable_hash){
    if(disable_hash != 'undefined' && !disable_hash){
        addHash({a: base_url,b: tid,c: page_nr,d: root_post_id,e: offset});
    }
    var new_url = base_url + 'ajax/posts/' + tid+ '/' + page_nr+ '/' + root_post_id ++ '/'+ offset:
    $.get(new_url,function(data){
    addHash(data)
    });

    //peaks kutsuma välja get request, url: baseurl+ajax/posts_content/tid/page_nr/root_post_id/offset
    
}

//AJAX BOOKMARKS
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
               data_val.e === data.e){
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
        var data = JSON.parse(atob(base64encoded));
        
        for(var i = 0;i<data.length;i++){
            ti = data[i];
            loadPostContent(ti.a, ti.b, ti.c, ti.d, ti.e, true);
        }
    }
}

$(document).ready(checkHash);


function myFunction() {
    
}

$(document).ready(myFunction);


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
    //pole implemeneeritud
}



/**
 * base_url - lehekülje baas url. nt http://ksm.cs.ut.ee/
 * tid - topic id
 * page_nr - lehekülje number
 * root_post_id - kommentaari id, mille vastuseid selle meetodiga peab tagastama
 * offset - mitu kommentaari jäetakse vahele. nt Kui offset 0 korral tagastatakse kommentaarid 1 kuni 10,
 * siis offset 5 korral tagastatakse kommentaarid 6 kuni 15
 */
function loadPostContent(base_url, tid, page_nr, root_post_id, offset){
    alert("pole implementeeritud ("+ base_url + tid + page_nr + root_post_id +"-"+ offset +")");
    //peaks kutsuma välja get request, url: baseurl+ajax/posts_content/tid/page_nr/root_post_id/offset
}

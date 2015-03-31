
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


function loadPostContent(base_url, tid, page_nr, root_post_id){
    alert("pole implementeeritud");
    //peaks kutsuma välja baseurl+ajax/posts_content/tid/page_nr/root_post_id
}

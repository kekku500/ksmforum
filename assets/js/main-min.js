function loginPopup(){document.getElementById("login_form_outer").style.display="block";document.getElementById("login_cover").style.display="block"}function registerPopup(){document.getElementById("register_form_outer").style.display="block";document.getElementById("login_cover").style.display="block"}function registerGooglePopup(){document.getElementById("registergoogle_form_outer").style.display="block";document.getElementById("login_cover").style.display="block"}function popupOff(){document.getElementById("login_form_outer").style.display="none";document.getElementById("register_form_outer").style.display="none";document.getElementById("login_cover").style.display="none";if(document.getElementById("registergoogle_form_outer")!=null){document.getElementById("registergoogle_form_outer").style.display="none"}}function createEventSource(a){if(typeof(EventSource)!=="undefined"){var b=new EventSource(a);b.addEventListener("message",function(c){if(c.data=="messageNewPost"){displayMessage("Teemasse lisati uus kommentaar",3000)}},false)}else{alert("Sinu brauser ei toeta Server-sent sündmusi! Palun uuenda!")}}function displayMessage(a,b){document.getElementById("messageNewPosts_outer").style.display="block";$("#messageNewPosts_inner").html(a);setTimeout(function(){$("#messageNewPosts_outer").fadeOut("slow")},b)}function loadPostContent(n,c,i,a,e,f,m,j,l){if(f!="undefined"&&(!f||f=="0")){addHash({a:n,b:c,c:i,d:a,e:e,f:m,g:j,h:l})}var g;$.ajax({method:"GET",url:n+"ajax/posts_content/"+c+"/"+i+"/"+a+"/"+e+"/"+j+"/"+l,async:false}).done(function(o){g=o});var d;$.ajax({method:"GET",url:n+"assets/xslt/posts.xsl",async:false}).done(function(o){d=o});var h=new XSLTProcessor();h.importStylesheet(d);var b=h.transformToFragment(g,document);if(i!="1"){var k=$('.post_container[id="'+m+"-"+i+'"]')}else{var k=$('.post_container[id="'+m+'"]')}k.removeClass("post_container");k.empty().append(b)}function addHash(d){if(window.location.hash.match("^#d=")){var b=window.location.hash.substring(3);var e=JSON.parse(atob(b));var a=false;for(var c=0;c<e.length;c++){var f=e[c];if(f.a===d.a&&f.b===d.b&&f.c===d.c&&f.d===d.d&&f.e===d.e&&f.f===d.f&&f.g===d.g&&f.h===d.h){a=true;break}}if(!a){e.push(d);window.location.hash="d="+btoa(JSON.stringify(e))}}else{e=[d];window.location.hash="d="+btoa(JSON.stringify(e))}}function checkHash(){if(window.location.hash.match("^#d=")){var a=window.location.hash.substring(3);var b=JSON.parse(atob(a));for(var c=0;c<b.length;c++){var d=b[c];loadPostContent(d.a,d.b,d.c,d.d,d.e,true,d.f,d.g,d.h)}}}function setCookie(c,d,e){if(e){var b=new Date();b.setTime(b.getTime()+(e*24*60*60*1000));var a="; expires="+b.toGMTString()}else{var a=""}document.cookie=c+"="+d+a+"; path=/"}function getCookie(b){var e=b+"=";var a=document.cookie.split(";");for(var d=0;d<a.length;d++){var f=a[d];while(f.charAt(0)==" "){f=f.substring(1,f.length)}if(f.indexOf(e)==0){return f.substring(e.length,f.length)}}return null}function delCookie(a){createCookie(a,"",-1)}function checkOnline(){if(typeof(EventSource)!=="undefined"){var a=new EventSource(location.origin+"/serversend/upload_posts");a.addEventListener("message",function(b){},false);a.addEventListener("open",function(b){console.log("Connection was opened. ");handleOfflinePosting(true)},false);a.addEventListener("error",function(b){if(b.target.readyState!=2){console.log("Error - connection was lost. ");handleOfflinePosting(false)}},false)}else{alert("Sinu brauser ei toeta Server-sent sündmusi! Palun uuenda!")}}function handleOfflinePosting(a){if(getCookie("online1")!=a){if(a){setCookie("online1","1",1);console.log("NOW ONLINE!");uploadOfflinePosts()}else{setCookie("online1","0",1);console.log("NOW OFFLINE")}}else{console.log("Status check, is online?:"+a)}}function clickedAddPost(c){if(getCookie("online1")=="0"){var b=3000;$('form button[class="ajax_button"]').attr("disabled","disabled");var a=$("#addPostContentWrapper textarea").val();if(a.length<1){$("#messageNewPosts_inner").css("color","red");displayMessage("Kommentaar ei tohi olla tühi!",b);return}else{if(a.length>5000){$("#messageNewPosts_inner").css("color","red");displayMessage("Kommentaar ei tohi ületada 5000 tähemärki! Hetkel on "+a.length+" tähemärki.",b);return}}console.log("Storing post to DB");storePostToDB(c,a);displayMessage("Teie kommentaar jäeti meelde. Taasühendusel pannakse see üles.",b);return}$('form[value="addpost"]').submit()}function storePostToDB(c,b){var a=openDatabase("clientdb","1.0","Client-Side Database",2*1024*1024);a.transaction(function(d){d.executeSql("CREATE TABLE IF NOT EXISTS Posts(p_pid INTEGER, content TEXT, time TIMESTAMP)",[]);d.executeSql("INSERT INTO Posts VALUES(?, ?, ?)",[c,b,new Date().getTime()],function(e,f){},function(e,f){})})}function uploadOfflinePosts(){var a=openDatabase("clientdb","1.0","Client-Side Database",2*1024*1024);a.transaction(function(b){b.executeSql("CREATE TABLE IF NOT EXISTS Posts(p_pid INTEGER, content TEXT, time TIMESTAMP)",[]);b.executeSql("SELECT * FROM Posts ORDER BY time",[],function(c,d){console.log("Found "+d.rows.length+" rows");if(d.rows.length>0){displayMessage("Oled nüüd võrgus. Sinu kommentaare laetakse üles.",3000)}for(var e=0;e<d.rows.length;e++){var f=d.rows.item(e);uploadOfflineClosure(a,f)}})})}function uploadOfflineClosure(a,d){var b=d.p_pid;var c=d.content;a.transaction(function(e){e.executeSql('DELETE FROM Posts WHERE p_pid="'+b+'" AND content="'+c+'"',[],function(f,g){console.log('DELETE FROM Posts WHERE p_pid="'+b+'" AND content="'+c+'"');ajaxPostComment(b,c,0)})})}function ajaxPostComment(d,b,a){if(a>5){return}console.log("Posting: "+d+" "+b);var c=location.origin+"/main/addpost/"+d;console.log(c);$.ajax({type:"POST",url:c,data:{form:"addpost",content:b}}).done(function(e){console.log("Posting succcess!")}).fail(function(e){console.log("Posting failed!");ajaxPostComment(d,b,a+1)})}function beginCode(){checkHash();checkOnline()}$(document).ready(beginCode);
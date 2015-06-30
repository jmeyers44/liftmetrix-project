$('document').ready(function(){
var submitButton = document.querySelector('input[type="submit"]');
if(submitButton){
submitButton.addEventListener("click", function(event){
        localStorage.clear();
        event.preventDefault()
        $url = document.querySelector('input[type="text"]').value;
        $url = $url.substring($url.lastIndexOf("/") + 1);
        localStorage.setItem('url', $url);
        window.location.replace("/login");  
    });
  }
})
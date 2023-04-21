$(document).ready(function(){
    document.getElementById('odp').style.opacity=0;
    $('#form').submit(function(){

        $.ajax({
            type: 'POST',
            url: 'script.php',
            data: $('#form').serialize(),

        }).done(function(data){
                console.log(data);
                document.getElementById( 'odp' ).textContent=data.toString();
                document.getElementById('odp').style.opacity=1;
                fadeOutEffect();
            })
        event.preventDefault();
    })

})
function fadeOutEffect() {
    var fadeTarget = document.getElementById("odp");
    var fadeEffect = setInterval(function () {
        if (!fadeTarget.style.opacity) {
            fadeTarget.style.opacity = 1;
        }
        if (fadeTarget.style.opacity > 0) {
            fadeTarget.style.opacity -= 0.1;
        } else {
            clearInterval(fadeEffect);
        }
    }, 200);
}
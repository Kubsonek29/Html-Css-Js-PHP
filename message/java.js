$(document).ready(function(){
       document.getElementById( 'good' ).style.display = 'none';
       document.getElementById( 'bad' ).style.display = 'none';
          $('#form').submit(function(){
              $.ajax({
                  type: 'POST',
                  url: 'script.php',
                  data: $('#form').serialize(),
              }).done(function(data){

                  if(data==1)
                  {
                      document.getElementById( 'good' ).style.display = 'block';
                      document.getElementById( 'good' ).textContent="Twoja Wiadomość została wysłana";
                  }
                  if(data==2)
                  {
                      document.getElementById( 'bad' ).style.display = 'block';
                      document.getElementById( 'bad' ).textContent="Wystąpił błąd podczas wysyłania wiadomości";
                  }
                  })
              event.preventDefault();
          })
        })

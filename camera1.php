
<?php
  require_once 'includes/bootstrap.php';
  App::getAuth()->restrict();
?>

<!DOCTYPE html>
<html>
  <head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="picture.js"></script>
    <script type="text/javascript" src="gallery.js"></script>
  </head>
 
  <body>
  <?php require 'includes/header.php';?>  
<!-- Partie centrale avec les masques, photos et bouton -->
  <div class = "flexbox">
    <div class="mask"> <p class="pager">Choisissez un element a ajouter !</p> </div>
    <div> <p class="pager">Faites votre plus beau sourire !</p>
          <div id="webcam"><img src="no_webcam.png" width= 400></div>
          <video id="video"></video>
    </div>
    <div>
      <p class="pager">Il ne vous reste plus qu'a prendre la photo !</p>
      <button id="startbutton">Prendre une photo</button></div>
    </div>
  </div>

<!-- Partie Gallerie -->
<div id='gallery'></div>
<script> load_gallery();</script>
<!-- Modal de confirmation de sauvegarde de la photo -->
  <div id="confirm_img" class="modal">
    <div class="modal-content">
    <canvas id="canvas"></canvas>
    <p>Voulez-vous sauvegarder la photo ?</p>
    <button id="confirm_yes">Sauvegarder ce montage</button>
    <button id="confirm_no">Ne pas sauvegarder et refaire une photo</button>
  </div>
</div>

<script>picture()</script>
<?php require 'includes/footer.php';?>  
</body>
</html>

<?php
  require_once 'includes/bootstrap.php';
  App::getAuth()->restrict();
?>

<!DOCTYPE html>
<html>
  <head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  </head>
  <body>
  <video id="video"></video>
  <button id="startbutton">Prendre une photo</button>
  <canvas id="canvas"></canvas>
  <img src="http://placekitten.com/g/320/261" id="photo" alt="photo"> </img>
  </body>
</html>

<script>
(function() {

var streaming = false,
    video        = document.querySelector('#video'),
    cover        = document.querySelector('#cover'),
    canvas       = document.querySelector('#canvas'),
    photo        = document.querySelector('#photo'),
    startbutton  = document.querySelector('#startbutton'),
    width = 640,
    height = 0;

navigator.getMedia = ( navigator.getUserMedia ||
                       navigator.webkitGetUserMedia ||
                       navigator.mozGetUserMedia ||
                       navigator.msGetUserMedia);

navigator.getMedia(
  {
    video: true,
    audio: false
  },
  function(stream) {
    // if (navigator.mozGetUserMedia) {
    //   video.mozSrcObject = stream;
    // } 
    //  else {
    //   var vendorURL = window.URL |k| window.webkitURL;
      // video.src = vendorURL.createObjectURL(stream);
      video.srcObject = stream;
    // }
    video.play();
  },
  function(err) {
    console.log("An error occured! " + err);
  }
);

video.addEventListener('canplay', function(ev){
  if (!streaming) {
    height = video.videoHeight / (video.videoWidth/width);
    video.setAttribute('width', width);
    video.setAttribute('height', height);
    canvas.setAttribute('width', width);
    canvas.setAttribute('height', height);
    streaming = true;
  }
}, false);

function takepicture() {
// definit la taille du canvas qui ne l'etait pas et cela l'efface
  canvas.width = width;
  canvas.height = height;
//copie l'image de la video sur le canvas
  canvas.getContext('2d').drawImage(video, 0, 0, width, height);
//transforme les données du canvas en une URI de données avec un entête PNG, et positionner l'attribut src de la photo à cette URL.
  var miniature = canvas.toDataURL('image/png');

// ajoute la miniature dans la div "photo"
  photo.setAttribute('src', miniature);
//Requete Ajax pour sauver la photo
  if (confirm('Voulez-vous sauvegarder cette photo ?!')){
    $.ajax({
      type: "POST",
      url: "save_image.php",
      // datatype: "html",
      // success: function (data){alert(data)},
      data: { 
        image: miniature
        }
      })
    .done(function(o) {
    alert("Image sauvegardee");
    console.log('saved'); 
    });
  }
}

startbutton.addEventListener('click', function(ev){
    takepicture();
  ev.preventDefault();
}, false);

})();</script>
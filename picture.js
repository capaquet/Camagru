function picture() {
var streaming = false,
    video        = document.querySelector('#video'),
    // cover        = document.querySelector('#cover'),
    canvas       = document.querySelector('#canvas'),
    // photo        = document.querySelector('#photo'),
    startbutton  = document.querySelector('#startbutton'),
    width = 400,
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
    webcam = document.querySelector('#webcam');
    webcam.style.display = 'block'; 
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
  canvas.width = width;
  canvas.height = height;
  canvas.getContext('2d').drawImage(video, 0, 0, width, height);
//transforme les données du canvas en une URI de données avec un entête PNG, et positionner l'attribut src de la photo à cette URL.
  var miniature = canvas.toDataURL('image/png');
// photo.setAttribute('src', miniature);

  var modal = document.getElementById('confirm_img');
  modal.style.display = "block";
  document.getElementById("confirm_no").onclick = function() {
    modal.style.display = "none";
  }
  document.getElementById("confirm_yes").onclick = function() {
    $.ajax({
      type: "POST",
      url: "save_image.php",
      data: { 
        image: miniature
        },
        success: function (data){
          data = JSON.parse(data);
          if (data.status == "success"){
            add_image_to_gallery(data.username, data.img_id)
            alert("Votre montage a ete sauvegarde !");}
          else{alert("Une erreur est intervenue pendant la sauvegarde de votre montage.");}
        },
      })
    .done(function(o) {
    modal.style.display = "none"
    });
  }
}
startbutton.addEventListener('click', function(ev){
    takepicture();
  ev.preventDefault();
}, false);
}
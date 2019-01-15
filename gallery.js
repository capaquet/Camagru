function load_gallery(){
    $.ajax({
        type: "POST",
        url: "search_photo.php",
        success: function (data){
            var tab_img = [];
            tab_img = data.split('#');
            for (var i = 1; i < tab_img.length; i++){
                add_image_to_gallery(tab_img[0], tab_img[i]);
            }
        },
    })
}

function add_image_to_gallery(owner_name, img_id){
    var gallery_block = document.createElement("div");
    gallery_block.className = "gallery_block";
    var gallery_img = document.createElement("img");
    gallery_img.className = "gallery_img";             
    gallery_img.setAttribute("src", "./images/" + img_id + '.png');
    // gallery_img.setAttribute("height", "768");
    gallery_img.setAttribute("width", "400");
    gallery_img.setAttribute("alt", 'Camagru of ' + owner_name + ' #' + img_id);
    gallery_block.appendChild(gallery_img);
    var gallery_btn = document.createElement("button");
    gallery_btn.className = "gallery_btn";
    gallery_btn.setAttribute("id", img_id);
    gallery_btn.setAttribute("onClick", "delete_picture(this.id)");
    gallery_btn.innerHTML = "Supprimer le montage";
    gallery_block.appendChild(gallery_btn);
    document.getElementById('gallery').appendChild(gallery_block);
}

function delete_picture(id){
    if (confirm("Etes-vous sur de vouloir la supprimmer ?")){
        var div_btn = document.getElementById(id);
        div_btn.parentNode.parentNode.removeChild(div_btn.parentNode);
        $.ajax({
            type: "POST",
            url: "delete_photo.php",
            data: {img_id : id},
        })
    }
}
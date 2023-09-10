
$(document).on("click",".ticket-on-sale", function(evt){
    $(this).toggleClass("active");
})


$(document).on("click",".cart-item-remove", function(evt){
    $(this).closest("li.cart-item").remove();
})


var slide_images = [
    "banner1.jpg",
    "banner2.png",
    "banner3.jpg",
    "banner4.jpg"
];

$(document).ready(function(){
    var slidetotal = slide_images.length;
    var randomslide =  Math.floor((Math.random() * slidetotal));
    $("#sliderbox").find(".slide").html('<img alt="" src="img/slider/'+slide_images[randomslide]+'">');
});



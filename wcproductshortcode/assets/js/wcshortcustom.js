jQuery(function ($){
   $(document).ready(function(){
        $(".multiple-items").slick({
		  slidesToShow:3,
		  slidesToScroll: 1,
		  autoplay:false,
		  arrows:true,
		  dots:true,
		  autoplaySpeed: 2000,
	   });
   });
});
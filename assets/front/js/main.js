$(document).ready(function(){
    

    $(document).mouseup(e => {
        if (!$(".search").is(e.target) // if the target of the click isn't the container...
        && $(".search").has(e.target).length === 0) // ... nor a descendant of the container
        {
            $(".search").removeClass('active');
       }
      });
     
      $(".search .toggle-trigger").click(function(){
        $(".search").addClass("active");
        $(".search input").focus();
    });

    $(".burger").click(function(){
        $($(this).children("i")).toggleClass("fa-bars fa-times")
        $(".mob-nav-wrapper").toggleClass("active");
    });
});
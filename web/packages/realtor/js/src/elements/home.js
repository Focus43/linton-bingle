var Home = function () {

    this.initBlockLinks = function () {

        $(".nav-blocks div.row > div").on('click', function(){
            console.log("click");
            window.location.href = $(this).attr('data-url');
        })

    }


    this.onloadFunc = function () {
        this.initBlockLinks();
    }
}
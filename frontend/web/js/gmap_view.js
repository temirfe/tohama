$(window).load(function(){
    loadScript();
});
    function initialize()
    {
        var latit="25.2063427";
        var longit="55.2709694";
        var mylocation=new google.maps.LatLng(latit, longit);
        var myOptions =
        {
            center:mylocation,
            zoom: 17,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            streetViewControl:false
        };
        var map = new google.maps.Map(document.getElementById("map_view"), myOptions);

        var marker = new google.maps.Marker({
            position: mylocation,
            map: map,
            title:"Tohama Travel & Tourism"
        });
    }//initialize();

//key is from kivanoprice account
    function loadScript() {
        var script = document.createElement("script");
        script.type = "text/javascript";
        script.src = "http://maps.google.com/maps/api/js?key=AIzaSyAhh1wqN2rKGeA1UJjpCfWRiKRQzhrguLM&sensor=false&callback=initialize";
        document.body.appendChild(script);
        }
@if(!empty(config('services.facebook.app_id')))
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId      : '{{ config('services.facebook.app_id') }}',
                xfbml      : true,
                version    : 'v2.7'
            });
        };

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/de_DE/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
@endif
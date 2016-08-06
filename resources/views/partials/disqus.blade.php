<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">{{ __('Kommentare') }}</h3>
    </div>
    <div class="panel-body">
        <div id="disqus_thread"></div>
        <script type="application/javascript">
            /**
             *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
             *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables
             */
            var disqus_config = function () {
                this.page.url = '{{ $url }}';  // Replace PAGE_URL with your page's canonical URL variable
                this.page.identifier = '{{ $slug }}'; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
            };
            (function() { // DON'T EDIT BELOW THIS LINE
                var d = document, s = d.createElement('script');
                s.src = '//photo-wiki.disqus.com/embed.js';
                s.setAttribute('data-timestamp', + new Date());
                (d.head || d.body).appendChild(s);
            })();
        </script>
        <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
    </div>
</div>


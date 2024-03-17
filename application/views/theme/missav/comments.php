
<?php   
    $comments_method 			= ovoo_config('comments_method');
    $facebook_comment_appid 	= ovoo_config('facebook_comment_appid');
    $disqus_short_name 			= ovoo_config('disqus_short_name');
    if(($comments_method =='both' || $comments_method =='facebook') && $facebook_comment_appid !='') :
?>
<!-- facebook comments -->
<div class="row">
    <div class="col-md-12">                        
    	<h2 class="border"><?php echo trans('facebook_comments'); ?></h2>
    	<div class="fb-comments" data-href="<?php echo $PAGE_URL;?>.html" data-width="800" data-numposts="30"></div>
		<div id="fb-root"></div>
	    <script>
	        (function(d, s, id) {
	            var js, fjs = d.getElementsByTagName(s)[0];
	            if (d.getElementById(id)) return;
	            js = d.createElement(s);
	            js.id = id;
	            js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8&appId=<?php echo ovoo_config('facebook_comment_appid'); ?>";
	            fjs.parentNode.insertBefore(js, fjs);
	        }(document, 'script', 'facebook-jssdk'));
	    </script>                        
    </div>
</div>
<!-- END facebook comments -->
<?php endif; ?>
<?php if($comments_method =='both' || $comments_method =='disqus'): ?>
<!-- disqus comments -->
<div class="row">
    <div class="col-md-12">
        <div id="disqus_thread"></div>
        <script>
            var disqus_config = function () {
                this.page.url = "<?php echo $PAGE_URL;?>";  // Replace PAGE_URL with your page's canonical URL variable
                this.page.identifier = "<?php echo $PAGE_IDENTIFIER;?>"; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
            };

            (function() { // DON'T EDIT BELOW THIS LINE
                var d = document, s = d.createElement('script');
                s.src = 'https://<?php echo $disqus_short_name; ?>.disqus.com/embed.js';
                s.setAttribute('data-timestamp', +new Date());
                (d.head || d.body).appendChild(s);
            })();
        </script>
        <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
        <script id="dsq-count-scr" src="//<?php echo $disqus_short_name; ?>.disqus.com/count.js" async></script>
    </div>
</div>
<!-- END disqus comments -->
<?php endif; ?>
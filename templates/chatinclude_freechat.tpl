{if $vars.zichat_itype == 'iframe'}
<iframe src="{getbaseurl}{$vars.vendor_url}/zichat.php?{$vars1|@http_build_query}" width="100%" height="{$vars1.height+200}px" border="0" frameborder="0">
</iframe>
{else}
<div id="zichat_freechat">
    <a href="http://www.phpfreechat.net">phpFreeChat: simple Web chat</a>
</div>
<script type="text/javascript">
    {{if $vars.freechat_development}}var less = { env: 'development' };{{/if}}
    $('#zichat_freechat').phpfreechat({ 
        serverUrl: '{{$vars.server_url}}',
        refresh_delay: {{$vars.freechat_refresh_delay}},
        focus_on_connect: {{if $vars.freechat_focus_on_connect}}true{{else}}false{{/if}}
    });
</script>
{/if}
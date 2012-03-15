{foreach $rtlist as $rtid => $rtmsg}
<option value="{$rtid}"{if $rtype == $rtid} selected="selected"{/if}>{message name=$rtmsg}</option>
{/foreach}
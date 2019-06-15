{foreach $res as $book}
<div style="margin-left: auto;margin-right: auto; width: 50%; color:gray; margin-bottom: 10px; margin-top: 10px;">
{if $book.image != ""}<center><img src='https://www.litmir.me{$book.image}' max-width='216' max-height='335'></center>{/if}
{if $book.title !=""}<center><h2>-- {$book.title} --</h2></center>{/if}
{if $book.description == ""}
<br/> <br/> <br/>
{/if}
{if $book.description != ""}
<div style='text-align:center;'>{$book.description}</div>
<center><h2>-- -- -- -- -- --</h2></center>
<br/> <br/> <br/>
{/if}
</div>
{foreachelse}
<center>Not found</center>
{/foreach}

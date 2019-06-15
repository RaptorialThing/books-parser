{foreach $res as $book}
<div style="margin-left: auto;margin-right: auto; width: 50%; color:gray; margin-bottom: 20px;">
{if $book.image != ""}<center><img src='https://www.litmir.me/{$book.image}' max-width='216' max-height='335'>
<h2>-- {$book.title} --</h2></center>{/if}
{if $book.description != ""}
<p style='text-align:center;'>{$book.description}</p>
<br/> <br/>
{/if}
</div>
{foreachelse}
<center>Not found</center>
{/foreach} 	
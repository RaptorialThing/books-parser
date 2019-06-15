<!DOCTYPE>
<html>
<head>
	<meta charset="utf-8">
	<script type="text/javascript" src="https://code.jquery.com/jquery-git.min.js"></script>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div style="margin-left:auto;margin-right: auto; width: 50%; text-align: center;">
    <form id="filter"  action="">
    	 <input type="text" name="book_name" id="title" placeholder="название книги">
    	 <input type="submit" name="Update" id="search" value="search" />
    	 <br/>
    	 <br/>	
   <!-- <fieldset>
    	<div class="spoiler"> <a class="spoiler-head" href="#">	<legend>Жанры</legend></a> 
    	<div class="spoiler-body">
    <input type="checkbox" id="fantastic" name="genre" value="fantastic">
    <label for="fantastic">Fantastic</label>
    <input type="checkbox" id="classic" name="genre" value="classic">
    <label for="fantastic">Classic</label>
	</fieldset>
	<div class="clear"></div>
	<fieldset>
    	<div class="spoiler"> <a class="spoiler-head" href="#">	<legend>Авторы</legend></a> 
    	<div class="spoiler-body">
    <input type="checkbox" id="Rowling" name="author" value="Rowling">
    <label for="fantastic">Rowling</label>
    <input type="checkbox" id="Astafiev" name="author" value="Astafiev">
    <label for="fantastic">Astafiev</label>
	</fieldset>
	 <div class="clear"></div>
     -->
    <fieldset>
        <div class="spoiler"> <a class="spoiler-head" href="#"> <legend>Litmir.me</legend></a> 
        <div class="spoiler-body">
    <label for="scrapper">Включить парсер с litmir.me</label>
    <input for="scrapper" type="button" name="scrapper" id="scrapper" value="run">
    </fieldset>
     <div class="clear"></div>
</form>
</div>
<div style="margin-left: auto;margin-right: auto; width: 50%; color:gray; margin-bottom: 20px;" id="results">
</div>
<div id="books">
</div>
{literal}
<script type="text/javascript">
	$(document).ready(function() {
		$('a.spoiler-head').click(function()
			{ 
				$(this).next().toggle(200); return false; });
	});

	$(document).ready(function() {

	function showValues() {
    var str = $( "form" ).serialize();
    var str = decodeURIComponent(str);
    $( "#results" ).text( str );
    var str = encodeURIComponent(str);
    return str;
  }


  $( "input[type='checkbox'], input[type='text']" ).on( "click", showValues );
  $( "select" ).on( "change", showValues );
  $( "#search" ).focusout(showValues);
  showValues();


function updateBooks(something) {
    $("#books").html(something);
}


$("#search").click(function (callback){    


    var query  = $( "form" ).serialize();
    $.ajax({type:"post", url:"index.php", data: query,success: function callback(response){
    updateBooks(response);
    }, error:function() {
    res = 'error: search not send to server'   
    $( "#results" ).text( res );
    }});   
    return false;


});

$('#scrapper').click(function(){
   document.location.href = 'scrapper.php';
});


document.body.onmouseover = document.body.onmouseout = handler;
    
function handler(event) {
	  if (event.type == 'mouseout') {
    showValues();
  }
}

	});


</script>
{/literal}
</body>
</html>
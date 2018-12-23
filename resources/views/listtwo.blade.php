<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Ajax to do list project</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />{{--jquery ui css cdn--}}


</head>
<body>
<br>
<br>
<br>
<div class="container">
	<div class="row">
		<div class="col-lg-offset-3 col-lg-6">

			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Ajax todo list <a href="#" class="pull-right" data-toggle="modal"   data-target="#myModal"><i class="fa fa-plus" id="addNew" aria-hidden="true"></i></a></h3>
				</div>
				<div class="panel-body" id="itemsDropdown">
				    <ul class="list-group">
				    	@foreach($item as $items)
					  <li class="list-group-item ourItem" data-toggle="modal"   data-target="#myModal">{{$items->item}}
					  	<input type="hidden" id="itemId" value="{{$items->id}}" >
					  </li>
					  @endforeach
					</ul>
				</div>
			</div>
		</div>

		<div class="col-lg-2">
			<input type="text" name="item" class="form-control" name="searchItem" id="searchItem" placeholder="Search">
		</div>

</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="title">Add New Item</h4>
      </div>
      <div class="modal-body">
      	<input type="hidden" id="id">
        <p><input type="text" placeholder="write item here" id="addItem" class="form-control"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" id="delete" data-dismiss="modal" style="display:none" >Delete</button>
        <button type="button" class="btn btn-success" id="saveChanges" data-dismiss="modal" style="display:none" >Save Changes</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" id="addButton">Add Items</button>
      </div>
    </div>

  </div>
</div>

	
</div>

{{csrf_field()}}

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script> 
{{--jquery ui js cdn--}}

<script>
$(document).ready(function(){
	$(document).on('click', '.ourItem', function(event){
	//$('.ourItem').each(function(){     //loops through the selected items
		//$(this).click(function(event){
			var text = $(this).text();  //grabs the text of the clicked items 
			var id = $(this).find('#itemId').val();//getting id of clicked item
			$
			$('#title').text('Edit Item');
			var text = $.trim(text);
			$('#addItem').val(text);
			$('#delete').show('400');
			$('#saveChanges').show('400');
			$('#addButton').hide('400');
			$('#id').val(id);//setting id of the various list items
			console.log(text);
		
		});	
	$(document).on('click', '#addNew', function(event){ //to connect our events to the modification of the DOM ie
		//on the change of events, the DOM should change too.
			$('#title').text('Add Item');
			$('#addItem').val('');
			$('#delete').hide('400');
			$('#saveChanges').hide('400');
			$('#addButton').show('400');
			//console.log(text);
		});	

	$('#addButton').click(function(event){
		var item = $('#addItem').val(); //this picks up the value of the input
		if (item == "") { //
			alert('Please enter item');
		}else{
				//var cate = "men";//this is to test if a second variable can be stored in the db from here: success.
				$.post('list',{'text1': item,/*'cate1': cate,*/'_token':$('input[name=_token]').val()}, function(data){
	            console.log(item);
	             $('#itemsDropdown').load(location.href + ' #itemsDropdown' );//this refreshes and updates the div as soon as a new item is added. always ensure to give a space before the auto refresh return page id to avoid div from misbehaving
			});
		}
		
	});
	//passing data directly to the ajax.
	$('#delete').click(function(event){
		var id = $("#id").val();
		$.post('delete',{'id':id,'_token':$('input[name=_token]').val()}, function(data){
			 $('#itemsDropdown').load(location.href + ' #itemsDropdown' );
			console.log(data);
		});
		
	});


//passing items as an array to the ajax
	$('#saveChanges').click(function(event){
		formData = {
			'id': $("#id").val(),
			'items' : $('#addItem').val(),
			'_token' : $('input[name=_token]').val(),
		}
		$.post('listupdate', formData, function(data){
         console.log(data);
         $('#itemsDropdown').load(location.href + ' #itemsDropdown' );
		});
	});



	//this is the search $ autocomplete function from jquery library
	$( function() {
    $( "#searchItem" ).autocomplete({
      source: 'http://localhost:8000/search'
    });
  } );


});
	
</script>

</body>
</html>
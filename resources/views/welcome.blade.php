@extends('layouts.app')
<link href="/css/styles.css" rel="stylesheet">

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="card col-12" style="zoom:70%">
            <div id="response"></div>
            <div class="card-header">
              Manage Your Properties
            </div>
            <div class="card-body">
                <blockquote class="blockquote mb-0">
                <p>
                    <div style="display:flex; align-items:center;">
                        <form action="{{route('deleteProperty')}}">
                            <button type="submit" class="btn btn-icon" id="addselected" title="delete selected property">
                                <i style="font-size: 1.5rem" class="bi bi-trash"></i>
                            </button>
                        </form>
                        <form>
                            <a type="button" class="mr-2 btn btn-icon" data-toggle="modal" data-target="#exampleModal-2" title="add a property">
                                <i style="font-size: 2rem" class="bi bi-plus"></i>
                            </a>
                        </form>
                        <form>
                            <a type="button" class="mr-2 btn btn-icon" data-toggle="modal" data-target=".bd-example-modal-lg" title="search for a property on maps">
                                <i style="font-size: 1.5rem" class="bi bi-map"></i>
                            </a>
                        </form>
                    </div>
                    
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Enter a search Phrase in the input field below</label>
                            <input type="text" class="form-control" name="searchWord" id="search" aria-describedby="search" placeholder="Enter a search key word here">
                            <span class="text-danger error-text searchWord_error"></span>
                            <small id="" class="form-text text-muted">Select a criteria to search by in the input field below:</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="address">Search Criteria</label>
                            <select class="form-control" id="searchCriteria" name="searchCriteria">
                                <option value="country">Search By - Country </option>
                                <option value="numberofBedrooms">Search By - Number of Bedrooms</option>
                                <option value="price">Search By - Price</option>
                                <option value="propertyTypeId">Search By - Property Type</option>
                                <option value="forSaleOrRent">Search By - Price - For Sale / For Rent</option>
                            </select>
                            <span class="text-danger error-text bathrooms_error"></span>
                        </div>
                    </form>
                </p>
                <footer class="blockquote-footer">Make sure you enter <cite title="Source Title">RELEVANT FIELDS</cite></footer>
                </blockquote>
            </div>
        </div>

         <!--Add Property Modal -->
        <div class="modal fade" style="zoom:90%" id="exampleModal-2"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{route('addProperty')}}" method="POST" id="propertyForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add a Property</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                    </div>
                    <div class="modal-body">
                        <div id=addedResponse></div>
                        <div class="form-group">
                          <label for="county">County</label>
                          <input type="text" class="form-control" id="county" aria-describedby="county" name="county" placeholder="Enter county">
                          <span class="text-danger error-text county_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="county">Country</label>
                            <input type="text" class="form-control" id="country" aria-describedby="country" name="country" placeholder="Enter country">
                            <span class="text-danger error-text country_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="town">Town</label>
                            <input type="text" class="form-control" id="town" aria-describedby="town" name="town" placeholder="Enter town">
                            <span class="text-danger error-text town_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea  type="text-area" class="form-control" id="description" aria-describedby="description" name="description" row="3" placeholder="Enter description"></textarea>
                            <span class="text-danger error-text description_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="address">Displayable Address</label>
                            <input type="text-area" class="form-control" id="address" aria-describedby="address" name="address" placeholder="Enter displayable address">
                            <span class="text-danger error-text address_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" class="form-control-file" name="image" id="image">
                            <span class="text-danger error-text image_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="address">Number of Bedrooms</label>
                                <select class="form-control" id="bedrooms" name="bedrooms">
                                </select>
                                <span class="text-danger error-text bedrooms_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="address">Number of Bathrooms</label>
                            <select class="form-control" id="bathrooms" name="bathrooms">
                            </select>
                            <span class="text-danger error-text bathrooms_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="address">Price</label>
                            <input type="number" min="0" class="form-control" name="price" id="price" aria-describedby="price" placeholder="price">
                            <span class="text-danger error-text price_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="address">Property Type</label>
                            <select class="form-control" id="type" name="type">
                            </select>
                            <span class="text-danger error-text type_error"></span>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="saleOrRent" id="inlineRadio1" value="forSale" checked>
                            <label class="form-check-label" for="inlineRadio1">For Sale</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="saleOrRent" id="inlineRadio2" value="forRent">
                            <label class="form-check-label" for="inlineRadio2">For Rent</label>
                        </div>
                        <span class="text-danger error-text saleOrRent_error"></span>
                   
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
            </div>
            </div>
        </div>

        <!--Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <span id="editData"></span>
                    <form action="" method="POST" id="propertyFormEdit">
                        @csrf
                        <input type="hidden" id="propertyId" name="propertyId">
                        <div id=updatedResponse></div>
                        <div class="form-group">
                          <label for="county">County</label>
                          <input type="text" class="form-control" id="editCounty" aria-describedby="county" name="editCounty" placeholder="Enter county">
                          <span class="text-danger error-text editCounty_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="county">Country</label>
                            <input type="text" class="form-control" id="editCountry" aria-describedby="country" name="editCountry" placeholder="Enter country">
                            <span class="text-danger error-text editCountry_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="town">Town</label>
                            <input type="text" class="form-control" id="editTown" aria-describedby="town" name="editTown" placeholder="Enter town">
                            <span class="text-danger error-text editTown_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea type="text-area" class="form-control" id="editDescription" aria-describedby="description" name="editDescription" row="3" placeholder="Enter description"></textarea>
                            <span class="text-danger error-text editDescription_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="address">Displayable Address</label>
                            <input type="text-area" class="form-control" id="editAddress" aria-describedby="address" name="editAddress" placeholder="Enter displayable address">
                            <span class="text-danger error-text editAddress_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Image</label>
                            <input type="file" class="form-control-file" name="editImage" id="image">
                            <span class="text-danger error-text editImage_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="address">Number of Bedrooms</label>
                                <select class="form-control" id="editBedrooms" name="editBedrooms">
                                </select>
                                <span class="text-danger error-text editBedrooms_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="address">Number of Bathrooms</label>
                            <select class="form-control" id="editBathrooms" name="editBathrooms">
                            </select>
                            <span class="text-danger error-text editBathrooms_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="address">Price</label>
                            <input type="number" min="0" class="form-control" name="editPrice" id="editPrice" aria-describedby="price" placeholder="price">
                            <span class="text-danger error-text editPrice_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="address">Property Type</label>
                            <select class="form-control" id="editType" name="editType">
                            </select>
                            <span class="text-danger error-text editType_error"></span>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="editSaleOrRent" id="editSale" value="forSale">
                            <label class="form-check-label" for="inlineRadio1">For Sale</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="editSaleOrRent" id="editRent" value="forRent">
                            <label class="form-check-label" for="inlineRadio2">For Rent</label>
                        </div>
                        <span class="text-danger error-text editSaleOrRent_error"></span>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update changes</button>
                    </form>
                </div>
            </div>
            </div>
        </div>

        {{-- Google Maps Modal --}}
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div style="height: 400px;">
                    <div style="height:100%;">
                        <div id="map"></div>
                        <div class="form-check">
                            <div class="mt-3" style="align-items: center;">
                                <input class="" type="text" placeholder="Type Here" name="addressSearch" id="addressSearch">
                                <span class="text-danger error-text addressSearch_error"></span>
                                <div class="" style="" id="addressList"></div>
                              
                                @csrf
                        
                            </div>
                        </div>
                    </div>
                </div> 
              </div>
            </div>
          </div>

        <div class="table-responsive">
            <table class="table table-striped mt-4" style="zoom:70%">
                <thead>
                    <tr>
                        <th scope="col">County</th>
                        <th scope="col">Country</th>
                        <th scope="col">Town</th>
                        <th scope="col">Description</th>
                        <th scope="col">Displayable Address</th>
                        <th scope="col">Number of Bedrooms</th>
                        <th scope="col">Number of Bathrooms</th>
                        <th scope="col">Price</th>
                        <th scope="col">Property Type</th>
                        <th scope="col">For Sale/ For Rent</th>
                        <th scope="col">Select All<input type="checkbox" id="checkall" class="" ></th>
                        <th scope="col">Edit</th>
                    </tr>
                </thead>
                <tbody id="searchTable">
                    @if(!empty($properties))
                        @foreach($properties as $property)
                            <tr class="row1" data-id="{{ $property->id }}">
                                <td class="text-center">{{ $property->county }}</td>
                                <td class="text-center">{{ $property->country }}</td>
                                <td class="text-center">{{ $property->town }}</td>
                                <td class="text-center"><p>{{ substr(strip_tags($property->description), 0, 20) }} {{ strlen(strip_tags($property->description)) > 20 ? '...' : "" }}</p></td>
                                <td class="text-center">{{ substr(strip_tags($property->displayableAddress), 0, 20) }} {{ strlen(strip_tags($property->displayableAddress)) > 20 ? '...' : "" }}</td>
                                <td class="text-center">{{ $property->numberofBedrooms }}</td>
                                <td class="text-center">{{ $property->numberofBathrooms }}</td>
                                <td class="text-center">{{ $property->price }}</td>
                                <td class="text-center">{{ $property->propertyTypeId }}</td>
                                <td class="text-center">{{ $property->forSaleOrRent }}</td>
                                <td class="text-center"><input type="checkbox" name="ids" value={{ $property->id }} class="deleteCheckInputs" aria-label="Checkbox for following text input"></td>
                                <td class="text-center"><a type="button" id="{{ $property->id }}" class="btn btn-icon editProperty"><i style="font-size: 1rem" class="bi bi-pen"></i></a></td>
                            </tr>
                        @endforeach	
                    @endif
                </tbody>
            </table>
            <div> 
                @if(!empty($properties->links()))
                    {{ $properties->links() }}
                @endif
            </div>
        </div>
    </div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key={{ config('myconfig.config.google_maps_api_key')  }}&libraries=places&v=weekly" async></script>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">

<script>
//Google Maps Address search calls
$(document).ready(function(){
        $('#addressSearch').keyup(function(){
            var query = $(this).val();
            var searchCriteria = $('input[name="searchMapCriteria"]:checked').val();
            
            if (query.length != 0)
            {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('fetchAutoComplete') }}",
                    method: "POST",
                    data: {query: query,
                        searchCriteria: searchCriteria,
                        _token: _token
                        },
                    success: function(data){
                        $('#addressList').fadeIn();
                        $('#addressList').html(data);
                    }
                });
            }else{
                $('#addressList').fadeOut(); 
            }
        });
        
        $(document).on('click', 'li', function(){  
        $('#addressSearch').val($(this).text());
        $('#addressList').fadeOut();  
    }); 
});

//Delete Property Calls
$(function(e){
    $("#checkall").click(function(){
            $(".deleteCheckInputs").prop('checked',$(this).prop('checked'));
        });
        $("#addselected").click(function(e){
        e.preventDefault();
        var allids = [];

    $("input:checkbox[name=ids]:checked").each(function(){
        allids.push($(this).val());
    });

        $.ajax({
            url: "{{route('deleteProperty')}}",
            method: "POST",
            data: {
                        _token:'{!! csrf_token() !!}',
                        ids: allids,
                    },
            success:function(res){
                    console.log(res);
                        res.status == 1 ?  $("#response").addClass("alert alert-danger") : $("#response").addClass("alert alert-success");
                    var div = document.getElementById('response');
                    div.innerHTML += res.msg;
                    setTimeout(function(){
                        location.reload();
                }, 5000);     
            }
        });
    })
});
 
//Home Page Search functionality calls
$('body').on('keyup', '#search', function(){
var query = $(this).val();
var searchCriteria = $("#searchCriteria option:selected").val();

$.ajax({
    method:'POST',
    url:"{{ route('search') }}",
    dataType:'json',
    data:{
        '_token':'{{ csrf_token() }}',
        query:query,
        searchCriteria: searchCriteria,
    },
    
    success:function(res){
                var tableRow = '';

                $('#searchTable').html('');
                
                $.each(res, function(index, value){
                tableRow = '<tr><td class="text-center">'
                    +value.county+'</td><td class="text-center">'
                    +value.country+'</td><td class="text-center">'
                    +value.town+'</td><td class="text-center">'
                    +value.description.substring(0,20)+'...'+'</td><td class="text-center">'
                    +value.displayableAddress.substring(0,20)+'...'+'</td><td class="text-center">'
                    +value.numberofBedrooms+'</td><td class="text-center">'
                    +value.numberofBathrooms+'</td><td class="text-center">'
                    +value.price+'</td><td class="text-center">'
                    +value.propertyTypeId+'</td><td class="text-center">'
                    +value.forSaleOrRent+'</td><td class="text-center"><input type="checkbox" name="ids" value='
                    +value.id+' class="deleteCheckInputs" aria-label="Checkbox for following text input"></td><td class="text-center"><a type="button" id="{{ $property->id }}" class="btn btn-icon editProperty"><i style="font-size: 1rem" class="bi bi-pen"></i></a></td></td></tr>';
                
                $('#searchTable').append(tableRow);
            });
        }
    });
});
  
//Select Box Populate functionalities
//no of Bedrooms        
var select = '';
for (i=1;i<=20;i++){
    select += '<option val=' + i + '>' + i + '</option>';
}
$('#bedrooms').html(select);

//No of Bathrooms
var select = '';
for (i=1;i<=20;i++){
    select += '<option val=' + i + '>' + i + '</option>';
}
$('#bathrooms').html(select);

//property type
for (i=1;i<=20;i++){
    select += '<option val=' + i + '>' + i + '</option>';
}
$('#type').html(select);

//Add Property submission
$(function(){
$("#propertyForm").on('submit', function(e){
        e.preventDefault();

        $.ajax({
            url:"{{ route('addProperty') }}",
            method:"POST",
            data:new FormData(this),
            dataType:'json',
            processData: false,
            contentType: false,
            beforeSend:function(){
                $(document).find('span.error-text').text('');
            },
            success:function(data){
                if(data.status == 0){
                    $.each(data.error, function(prefix, val){
                        $('span.'+prefix+'_error').text(val[0]);
                    });
                }else{
                    $('#propertyForm')[0].reset();
                    $("#addedResponse").addClass("alert alert-success");
                    var div = document.getElementById('addedResponse');
                    div.innerHTML += 'The property as been successfuly Added';
                }
            }
        });
    });
});

//Edit property form submission calls
$(document).on('click', '.editProperty', function(){
    var id = $(this).attr('id');
    $('#editData').html('');
    $.ajax({
        url: "/editProperty/"+id,
        method: 'POST',
        dataType:'json',
        data:{
            '_token':'{{ csrf_token() }}',
            data: id,
        },
        success: function(res){
            $.each(res, function(index, value){
                $('#propertyId').val(value.id);
                $('#editCounty').val(value.county);
                $('#editCountry').val(value.country);
                $('#editTown').val(value.town);
                $('#editDescription').val(value.description);
                $('#editPrice').val(value.price);
                $('#editAddress').val(value.displayableAddress);
                $('#editImage').append("<input type='hidden' name='hiddenImage' value='"+value.image+"' />");
                (value.propertyTypeId == "sale") ? $("#editSale").attr('checked', 'checked'): $("#editRent").attr('checked', 'checked')
                var select = '';
                
                for (i=0;i<=20;i++){
                    select += '<option val=' + i + '>' + i + '</option>';
                }
                $('#editBedrooms').html(select);
                $('#editBedrooms').val(value.numberofBedrooms)

                for (i=1;i<=20;i++){
                    select += '<option val=' + i + '>' + i + '</option>';
                }
                $('#editBathrooms').html(select);
                $('#editBathrooms').val(value.numberofBathrooms)

                for (i=1;i<=20;i++){
                    select += '<option val=' + i + '>' + i + '</option>';
                }
                $('#editType').html(select);
                $('#editType').val(value.propertyTypeId)
            });
            $('#editModal').modal('show');
        }
    })
});

//Update property submission calls
$(function(){
    $("#propertyFormEdit").on('submit', function(e){
            e.preventDefault();

            var id = $('#propertyId').val();
    
            $.ajax({
                url:"/updateProperty/"+id,
                method:"POST",
                data:new FormData(this),
                processData: false,
                contentType: false,
                dataType:'json',
                beforeSend:function(){
                    $(document).find('span.error-text').text('');
                },
                success:function(data){
                    if(data.status == 0){
                        $.each(data.error, function(prefix, val){
                            $('span.'+prefix+'_error').text(val[0]);
                        });
                    }else{
                        $('#propertyFormEdit')[0].reset();
                        $("#updatedResponse").addClass("alert alert-success");
                        var div = document.getElementById('updatedResponse');
                        div.innerHTML += 'The property as been successfuly Updated';
                    }
                }
            });
        });
    });
</script>
@endsection

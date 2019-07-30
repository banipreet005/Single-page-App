@extends('body')

@section('content')
    <div class="container">
        <div class="mt-5">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="d-inline">Registered animals</h4>
                    <button class="btn btn-success d-inline float-right" type="button" data-toggle="collapse"
                            data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                        Filters
                    </button>
                </div>

                <div class="card-body mt-0 pt-0">
                    <div id="searchErrors" class="alert alert-danger mt-2" role="alert" style="display: none"></div>

                    <div class="collapse" id="collapseExample">
                        <form id="searchFilters" method="get" action="{{route('findAnimals')}}">
                            <div class="mt-3 mb-5">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p>Order by</p>
                                        <div class="form-group">
                                            <select name="sortKey" class="form-control" autocomplete="off">
                                                <option></option>
                                                <option value="id">Id</option>
                                                <option value="name">Name</option>
                                                <option value="createdAt">Created At</option>
                                                <option value="updatedAt">Updated At</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <select name="sortDir" class="form-control" autocomplete="off">
                                                <option></option>
                                                <option value="asc">Ascendant</option>
                                                <option value="desc">Descendant</option>
                                            </select>
                                        </div>

                                        <p>Hide Animals</p>

                                        <div class="form-check">
                                            <input name="hideDogs" class="form-check-input" type="checkbox" value="1" id="hideDogs">
                                            <label class="form-check-label" for="displayDogs">
                                                Hide dogs
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input name="hideCats" class="form-check-input" type="checkbox" value="1" id="hideCats">
                                            <label class="form-check-label" for="displayCats">
                                                Hide cats
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input name="hideDucks" class="form-check-input" type="checkbox" value="1" id="hideDucks">
                                            <label class="form-check-label" for="displayDucks">
                                                Hide ducks
                                            </label>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <p>Specific display order</p>
                                        <div class="form-group">
                                            <select id="updateType" name="orderFirst" class="form-control" autocomplete="off">
                                                <option></option>
                                                <option value="0">Dog</option>
                                                <option value="1">Cat</option>
                                                <option value="2">Duck</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <select id="updateType" name="orderSecond" class="form-control" autocomplete="off">
                                                <option></option>
                                                <option value="0">Dog</option>
                                                <option value="1">Cat</option>
                                                <option value="2">Duck</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <select id="updateType" name="orderThird" class="form-control" autocomplete="off">
                                                <option></option>
                                                <option value="0">Dog</option>
                                                <option value="1">Cat</option>
                                                <option value="2">Duck</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button class="btn btn-success">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <table class="table">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                            <th>Options</th>
                        </tr>
                        </thead>
                        <tbody id="animalList">

                        </tbody>
                    </table>
                </div>

                <div class="text-center card-footer">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#createModal">Create Animal
                    </button>
                </div>
            </div>
        </div>


        <!-- Create animal Modal -->
        <div class="modal modal-lg fade" id="createModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">Create new animal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="createForm" method="post" enctype="multipart/form-data"
                          action="{{route('createAnimal')}}">
                        <div class="modal-body">

                            <div id="createErrors" class="alert alert-danger" role="alert" style="display: none"></div>

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input name="name" type="text" class="form-control" id="name" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="type">Type</label>
                                <select name="type" class="form-control" autocomplete="off">
                                    <option value="0">Dog</option>
                                    <option value="1">Cat</option>
                                    <option value="2">Duck</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="photo">Photo</label>
                                <input name="photo" type="file" class="form-control-file" id="photo" autocomplete="off">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete animal Modal -->
        <div class="modal modal-lg fade" id="deleteModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">Are you sure you want to delete this animal?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="deleteForm" enctype="multipart/form-data" action="{{route('deleteAnimal')}}">
                        <input name="id" id="deleteId" value="" autocomplete="off" hidden>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Update animal Modal -->
        <div class="modal modal-lg fade" id="updateModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">Update animal <span id="updatedAnimalId"></span>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="updateForm" method="post" enctype="multipart/form-data"
                          action="{{route('updateAnimal')}}">
                        <input name="id" id="updateId" value="" autocomplete="off" hidden>
                        <div class="modal-body">

                            <div id="updateErrors" class="alert alert-danger" role="alert" style="display: none"></div>

                            <div class="text-center">
                                <img class="img-thumbnail" id="updatePhotoPreview" src="" style="width: 250px">
                            </div>
                            <div class="form-group">
                                <label for="updateName">Name</label>
                                <input id="updateName" name="name" type="text" class="form-control" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="updateType">Type</label>
                                <select id="updateType" name="type" class="form-control" autocomplete="off">
                                    <option value="0">Dog</option>
                                    <option value="1">Cat</option>
                                    <option value="2">Duck</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="photo">New Photo</label>
                                <input name="photo" type="file" class="form-control-file" id="updatePhoto"
                                       autocomplete="off">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script>
        findAnimals();
        /* Csrf Tokens Were disabled on the server since they are not needed */
        /* Disabling Csrf only requires to comment \App\Http\Middleware\VerifyCsrfToken::class from
        /* Laravel Http\Kernel.php
         */
        // We ask our server for all the animals
        function findAnimals(formData = '') {
            /* Store the search error DOM element on a variable */
            const errorDisplay = $('#searchErrors');
            /* Clear the current errors and hide the element*/
            errorDisplay.html('');
            errorDisplay.hide();
            /* Store page params on a variable */
            const searchParams = new URLSearchParams(window.location.search);
            /* Store our search route on a variable*/
            let route = "{{route('findAnimals')}}";
            /* If there are searchParams present, we add them to our search route*/
            if (searchParams.toString() != null){
                route += "?"+searchParams.toString();
            }

            /* We make a GET request to our server */
            $.get(route, function (response) {
                /* We store the tbody element on a variable */
                const tBody = $('#animalList');
                /* We clear the content of tbody */
                tBody.html('');
                /* We store all our animals on a variable */
                const animals = JSON.parse(response);
                /* For each animal */
                $.each(animals, function (index, animal) {
                    /* We create a new table row with the required content */
                    let tr = '<tr>';
                    tr += '<td>' + animal.id + ' </td>';
                    if (animal.photo !== undefined) {
                        /* We will use a extra variable to avoid browser cache */
                        let d = new Date();
                        tr += '<td> <img id="animal-photo-' + animal.id + '" class="img-thumbnail" style="width: 200px;" src="{{url('photos')}}/' + animal.photo + '?' + d.getTime() + '"></td>';
                    } else {
                        tr += '<td></td>';
                    }
                    tr += '<td id ="animal-name-' + animal.id + '"> ' + animal.name + '</td>';

                    let type;
                    switch (animal.type) {
                        case 0:
                            type = 'Dog';
                            break;
                        case 1:
                            type = 'Cat';
                            break;
                        case 2:
                            type = 'Duck';
                            break;
                        default:
                            type = '';
                    }

                    let createdAt = new Date(animal.created_at);
                    let updatedAt = new Date(animal.updated_at);

                    tr += '<td> ' + type + '</td>';
                    tr += '<td> ' + createdAt.toLocaleDateString() + ' - '+ createdAt.toLocaleTimeString()+'</td>';
                    tr += '<td> ' + updatedAt.toLocaleDateString() + ' - '+ updatedAt.toLocaleTimeString()+'</td>';
                    tr += '<td> ' +
                        '<button class="btn btn-primary mr-2" type="button" onclick="updateAnimal(' + animal.id + ')">Update</button>' +
                        '<button class="btn btn-danger" type="button" onclick="deleteAnimal(' + animal.id + ')">Delete</button>' +
                        '</td>';
                    /* Finally we append the newly made tr to our tbody*/
                    tBody.append(tr);
                });
            }).fail(function(data) {
                const errorDisplay = $('#searchErrors');
                /* Clear older errors */
                errorDisplay.html('');
                /* If the error response contains the responseText*/
                if(data.responseText) {
                    /* We parse the errors and store it on a variable */
                    const errors = JSON.parse(data.responseText);
                    /* For each error in the response, we create a new p element to display it */
                    $.each(errors, function (index, error) {
                        errorDisplay.append('<p>'+error+'</p>');
                    });
                    /* Finally we display the error DOM element */
                    errorDisplay.show();
                }
                console.log('An error occurred.');
                console.log(data);
            });
        }

        $('#searchFilters').submit(function (e) {
            e.preventDefault();
            /* This will return the form params excluding empty inputs */
            /* This way we can avoid unnecessary params in our URL */
            const formData = $("#searchFilters :input").filter(function(index, element) {
                    return $(element).val() != '';
                }).serialize();

            console.log(formData);
            /* We change the params of the current URL */
            /* First argument is the status object you can store anything here like a JSON object,
            /* second argument its the page title some explorers like firefox don't even use it
            /* Third argument its the new URL, in this case we keep the same one and just add the
            form params in our route*/
            history.pushState( {}, "Laravel", "?"+formData);
            /* We call the animal search now, knowing that the newly added url params will be considered on the next request*/
            findAnimals();
        });

        function updateAnimal(animalId) {
            /* Get the animal name from the table content */
            const name = $('#animal-name-' + animalId).html();
            /* Get the photo src from the table content */
            const photoUrl = $('#animal-photo-' + animalId).attr('src');
            /* Update the update modal to display the ID */
            $('#updatedAnimalId').html(animalId);
            /* Update the hidden id input with the animal to update */
            $('#updateId').attr('value', animalId);
            /* Populate the name with the current one*/
            $('#updateName').attr('value', name);
            /* Display the current photo of the animal*/
            $('#updatePhotoPreview').attr('src', photoUrl);
            /* Finally we display the modal*/
            $('#updateModal').modal('show');
        }

        /* Update animal AJAX Request */
        $('#updateForm').submit(function (e) {
                // avoid to execute the actual submit of the form.
                e.preventDefault();
                console.log('update form executed');
                const form = $(this);
                const url = form.attr('action');
                const formData = new FormData($(this)[0]);
                const errorDisplay = $('#updateErrors');
                /* Clear current Errors */
                errorDisplay.html('');
                /* Hide DOM element*/
                errorDisplay.hide();
                /*Make our update AJAX Call*/
                $.ajax({
                    type: "post",
                    url: url,
                    data: formData, // serializes the form's elements.
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        /* Hide update modal */
                        $('#updateModal').modal('hide');
                        /* Clear form content */
                        form.trigger("reset");
                        /* Ask animals from server*/
                        findAnimals();
                    },
                    error: function (data) {
                        if(data.responseText) {
                            const errors = JSON.parse(data.responseText);
                            $.each(errors, function (index, error) {
                                errorDisplay.append('<p>'+error+'</p>');
                            });
                            errorDisplay.show();
                        }
                        console.log('An error occurred.');
                        console.log(data);
                    },
                });
            }
        );

        function deleteAnimal(animalId) {
            /* Update the hidden id input with the animal to delete */
            $('#deleteId').attr('value', animalId);
            /* Display the modal */
            $('#deleteModal').modal('show');
        }

        /* Delete animal AJAX Request */
        $('#deleteForm').submit(function (e) {
                // avoid to execute the actual submit of the form.
                e.preventDefault();
                console.log('delete form executed');
                const form = $(this);
                const url = form.attr('action');
                /* Make our delete AJAX Call */
                $.ajax({
                    type: "delete",
                    url: url,
                    data: form.serialize(), // serializes the form's elements.
                    success: function (data) {
                        findAnimals();
                        $('#deleteModal').modal('hide');
                    },
                    error: function (data) {
                        console.log('An error occurred.');
                        console.log(data);
                    },
                });
            }
        );

        /* Create new animal AJAX Request*/
        /* When the #createForm its submit we will execute the following AJAX request*/
        $('#createForm').submit(function (e) {
                // avoid to execute the actual submit of the form.
                e.preventDefault();
                console.log('create form executed');
                const form = $(this);
                const url = form.attr('action');
                /* We used FormData instead of form.serialize() because FormData supports both files and data POST actions */
                /* When form.serialize() doesn't */
                const formData = new FormData($(this)[0]);
                const errorDisplay = $('#createErrors');
                /* We clear the errors and hide the alert */
                errorDisplay.html('');
                errorDisplay.hide();
                $.ajax({
                    type: "post",
                    url: url,
                    data: formData, // serializes the form's elements.
                    /* Form data requires processData and contentType specified to work */
                    /* if they are not present an error will pop on the console*/
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        findAnimals();
                        $('#createModal').modal('hide');
                        form.trigger("reset");
                    },
                    error: function (data) {
                        $('#createErrors');
                        if(data.responseText) {
                            const errors = JSON.parse(data.responseText);
                            $.each(errors, function (index, error) {
                                errorDisplay.append('<p>'+error+'</p>');
                            });
                            errorDisplay.show();
                        }
                        console.log('An error occurred.');
                        console.log(data);
                    },
                });
            }
        );
    </script>
@endsection

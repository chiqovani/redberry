<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Costum CSS -->
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet"/>
    <link href="{{asset('assets/css/fontawesome.css')}}" rel="stylesheet"/>
    <link href="{{asset('assets/css/bootstrap-tagsinput.css')}}" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>
<div class="container table-responsive py-5">
    <div class="row">
            <div class="btn-group mr-2" id="filter" role="group" aria-label="First group">
                <button type="button" class="btn btn-secondary ml-2">1</button>
                <button type="button" class="btn btn-secondary mb-2">2</button>
                <button type="button" class="btn btn-secondary mb-2">3</button>
                <button type="button" class="btn btn-secondary mb-2">4</button>
            </div>
    </div>
    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
        <tr>
            <th>Candidate</th>
            <th>Position</th>
            <th>Salary Range</th>
            <th>Skills</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody id="candidates">
        </tbody>
    </table>

    <div class="modal fade "  id="candidateModal"  role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content applicant-modal">
                <div class="modal-header">
                    <div class="row">
                        <div class="col-7">
                            <h5 class="modal-title" id="candidate_name"></h5>
                        </div>
                        <div class="col-3">
                            <button type="button" class="remove_candidate btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
                        </div>
                    </div>
                    <h5 class="modal-title" id="candidate_name"></h5>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Select Candidate Status</label>
                        <select class="form-control" id="statuses">
                        </select>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="col-8">
                        <div class="d-flex bd-highlight">
                            <div class="p-2 flex-fill bd-highlight">
                                <p class="text-muted">Position</p>
                                <input id="position" class="userinfo border-0" value="Developer"/>
                                <i href="#" data-target="position" class="edit pointer fas fa-pencil text-danger"></i>
                            </div>
                            <div class="p-2 flex-fill bd-highlight">
                                <p class="text-muted">Linkedin Url</p>
                                <input id="linkedin_url" class="userinfo border-0" value="https://www.linkedin.com"/>
                                <i href="#" data-target="linkedin_url" class="edit pointer fas fa-pencil text-danger"></i>
                            </div>
                        </div>
                        <div class="d-flex bd-highlight w-50">
                            <div class="p-2 flex-fill bd-highlight w-50">
                                <p class="text-muted">Salary Range</p>
                                <input id="min_salary" class="userinfo border-0 w-25" value=""/>
                                <input id="max_salary" class="userinfo border-0 w-25" value=""/>
                                <i href="#" data-target="min_salary" class="edit pointer fas fa-pencil text-danger"></i>
                            </div>
                        </div>
                        <div class="d-flex bd-highlight">
                            <div class="p-2 flex-fill bd-highlight">
                                <p class="text-muted">Skillset</p>
                                <input  id="tags" class="w-100" value="" data-role="tagsinput" multiple/>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class=" bd-highlight">
                            <div class="panel panel-white no-radius">
                                <div class="panel-body">
                                    <ul id="status_change_timeline" class="time timeline-xs margin-top-20 margin-bottom-20">

                                    </ul>
                                    <div  class="input-group">
                                        <textarea id="comment" class="form-control" aria-label="With textarea"></textarea>
                                    </div>
                                    <button id="submit_comment" type="button"  class="btn btn-danger mt-2 float-end">Comment</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script>
    var csrf = "{{csrf_token()}}";
    var url = '{{config('app.url')}}'
</script>
<script src="{{ asset('assets/js/main.js') }}"></script>

<script src="{{ asset('assets/js/bootstrap-tagsinput.min.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
</html>


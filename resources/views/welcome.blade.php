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
        <div class="row col-8">
            <div class="input-group mb-5">
                <input id="search-input" type="search" class="form-control" placeholder="Search anything...">
            </div>

        </div>
        <div class="row col-4">
            <span>

            </span>
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
                    <h5 class="modal-title" id="exampleModalLongTitle">Applicant Information</h5>
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
                                <input id="position" class="border-0" value="Developer"/>
                                <i href="#" data-target="position" class="edit pointer fas fa-pencil text-danger"></i>
                            </div>
                            <div class="p-2 flex-fill bd-highlight">
                                <p class="text-muted">Linkedin Url</p>
                                <input id="linkedin" class="border-0" value="https://www.linkedin.com"/>
                                <i href="#" data-target="linkedin" class="edit pointer fas fa-pencil text-danger"></i>
                            </div>
                        </div>
                        <div class="d-flex bd-highlight w-50">
                            <div class="p-2 flex-fill bd-highlight w-50">
                                <p class="text-muted">Salary Range</p>
                                <input id="min_salary" class="border-0 w-25" value=""/>
                                <input id="max_salary" class="border-0 w-25" value=""/>
                                <i href="#" data-target="min_salary" class="edit pointer fas fa-pencil text-danger"></i>
                            </div>
                        </div>
                        <div class="d-flex bd-highlight">
                            <div class="p-2 flex-fill bd-highlight">
                                <p class="text-muted">Skillset</p>
                                <input  class="w-100" value="PHP, JAVA, JS" data-role="tagsinput"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="d-flex bd-highlight">
                            <div class="panel panel-white no-radius">
                                <div class="panel-body">
                                    <ul class="timeline-xs margin-top-20 margin-bottom-20">
                                        <li class="timeline-item success list-group-item-warning">
                                            <div class="margin-left-15">
                                                <div class="text-muted text-small">
                                                    2 minutes ago
                                                </div>
                                                <p>
                                                    <a class="text-info" href="">
                                                        Steven
                                                    </a>
                                                    has completed his account.
                                                </p>
                                            </div>
                                        </li>
                                        <li class="timeline-item info">
                                            <div class="margin-left-15">
                                                <div class="text-muted text-small">
                                                    Thu, 12 Jun
                                                </div>
                                                <p>
                                                    Contacted
                                                    <a class="text-info" href="">
                                                        Microsoft
                                                    </a>
                                                    for license upgrades.
                                                </p>
                                            </div>
                                        </li>
                                        <div  class="input-group">
                                            <textarea id="comment" class="form-control" aria-label="With textarea"></textarea>
                                        </div>
                                        <button id="submit_comment" type="button"  class="btn btn-danger mt-2 float-end">Comment</button>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
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


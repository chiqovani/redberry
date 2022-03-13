var statuses = [];
var selectedCandidate = [];
$(document).ready(function () {
    $('input, select').on('change', function(event) {
        var $element = $(event.target),
            $container = $element.closest('.example');

        if (!$element.data('tagsinput'))
            return;

        var val = $element.val();
        if (val === null)
            val = "null";
        $('code', $('pre.val', $container)).html( ($.isArray(val) ? JSON.stringify(val) : "\"" + val.replace('"', '\\"') + "\"") );
        $('code', $('pre.items', $container)).html(JSON.stringify($element.tagsinput('items')));
    }).trigger('change');

    $(".edit").click(function () {
        var target = $(this).data('target');
        $("#" + target).focus();
    })

    $("#submit_comment").click(function () {
        updateStatus()
    })

    $('#statuses').on('change',function () {
        $("#comment").focus();
    })

    $('body').on('focusout','.userinfo',function() {
        updateUserInfo($(this).prop('id'), $(this).val())
    })

    $('#candidateModal').on('hidden.bs.modal', function() {
        loadViewData()
    });

    $('#tags').on('itemAdded', function(event) {
        if(event.options != 'prefill') updateUserInfo('add_tag', event.item)
    });

    $('#tags').on('itemRemoved', function(event) {
        console.log(event.item)
        updateUserInfo('remove_tag', event.item);
    });

    $('.remove_candidate').on('click', function(event) {
        removeCandidate();
    });

    getStatuses()
    loadViewData()
});

function loadViewData(status_id = null) {
    $.ajax({
        type: "GET",
        url: url + 'api/candidates',
        data: {'status' : status_id},
        success: function (data) {
            $('#candidates').html('')
            $('#filter').html('')
            var filters = [ 'Initial',
                'First Contact',
                'Interview',
                'Tech Assignment',
                'Rejected',
                'Hired']

            statuses.forEach(function (status, inxdex){
                var div =   '<div class="col-2">' +
                                '<button type="button" class="status_filter btn btn-light"  onClick="loadViewData('+status.id +')"  value="' +  status.id + '">' +  filters[inxdex]+ '<span class="badge rounded-pill bg-info text-dark">0</span>' + '</button>'
                            '</div>'
                $('#filter').append(div)
            })
            data.forEach(function (candidate) {
                var tr = '<tr>' +
                            '<td class="pointer" onClick="getCandidateInfo('+candidate.id +')" >'+candidate.first_name +'  '+candidate.last_name +'</td>' +
                            '<td>'+candidate.position +'</td>' +
                            '<td>'+candidate.min_salary +' - '+candidate.max_salary +'</td>'+
                            '<td>' + 'PHP' + '</td>' +
                            '<td><span class="badge bg-primary">'+candidate.status.name +'</span></td>' +
                    '</tr>'
                $('#candidates').append(tr)
            })
        }
    });
}

function updateStatus() {
    let selected_status = $("#statuses option:selected").val()
    if(selectedCandidate.status_id != selected_status) {
        $.ajax({
            type: "PUT",
            url: url + 'api/candidates/' + selectedCandidate.id,
            data: {
                status_id : selected_status,
                status_comment : $('#comment').val(),
            },
            success: function (data) {
            }
        })
    }
}

function removeCandidate(){
    $.ajax({
        type: "DELETE",
        url: url + 'api/candidates/' + selectedCandidate.id,
        success: function (data) {
            $("#candidateModal").modal('hide');
        }
    })
}


function getCandidateInfo(id) {
    $.ajax({
        type: "GET",
        url: url + 'api/candidates/' + id,
        success: function (candidate) {
            selectedCandidate = candidate;
            $('#statuses').html("")
            statuses.forEach(function (status) {
                if(status.id == candidate.status_id) {
                    $('#statuses').append('<option selected value="'+ status.id +'">'+ status.name +'</option>')
                }else{
                    $('#statuses').append('<option  value="'+ status.id +'">'+ status.name +'</option>')
                }
            })
            $('#status_change_timeline').html("")
            var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            options.timeZone = 'UTC';
            options.timeZoneName = 'short';
            candidate.status_change_timeline.forEach(function (record) {
                date = new Date(record.created_at).toLocaleDateString("en-US", options);
                var li =  '<li class="timeline-item info">' +
                            ' <div class="margin-left-15">' +
                                '<div class="text-muted text-small">'
                                 + date  +
                                '</div>' +
                                '<span class="badge bg-warning">' + record.status.name + '</span>' +
                                '<p class="text-muted">'
                                    + (record.comment ? record.comment :  '')  +
                                '</p>' +
                            '</div>' +
                        '</li>'
                $('#status_change_timeline').append(li)
             })

            var tags = []
            $('#tags').tagsinput('refresh');
            candidate.tags.forEach(function (tag,index) {
                $('#tags').tagsinput('add', tag.name.en, 'prefill');
            })
            $('#candidate_name').text(candidate.first_name + ' ' + candidate.last_name)
            $('#linkedin').val(candidate.linkedin_url)
            $('#min_salary').val(candidate.min_salary)
            $('#max_salary').val(candidate.max_salary)
            $('#position').val(candidate.position)
            $("#candidateModal").modal('show');
        }
    })
}

function getStatuses() {
    $.ajax({
        type: "GET",
        url: url + 'statuses/',
        success: function (data) {
           statuses = data;
        }
    })
}

function updateUserInfo(field, value) {
    var data = []
    data[field] = value
    $.ajax({
        type: "PUT",
        dataType: "json",
        contentType: "application/json",
        url: url + 'api/candidates/' + selectedCandidate.id,
        data: JSON.stringify(Object.assign({}, data)),
        success: function (data) {
        }
    })
}




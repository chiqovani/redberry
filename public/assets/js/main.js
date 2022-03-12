const statuses = null;
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
    getStatuses()
    loadViewData()
});

function loadViewData() {
    $.ajax({
        type: "GET",
        url: url + 'api/candidates',
        success: function (data) {
            $('#candidates').html('')
            data.forEach(function (candidate) {
                var tr = '<tr>' +
                            '<td class="pointer" onClick="getCandidateInfo('+candidate.id +')" >'+candidate.first_name +'  '+candidate.first_name +'</td>' +
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

function getCandidateInfo(id) {
    self = this
    $.ajax({
        type: "GET",
        url: url + 'api/candidates/' + id,
        success: function (candidate) {
            console.log(self.statuses)
            $('#linkedin').val(candidate.linkedin_url)
            $('#min_salary').val(candidate.min_salary)
            $('#max_salary').val(candidate.max_salary)
            $('#position').val(candidate.position)
            $("#candidateModal").modal('show');
        }
    })
}

function getStatuses() {
    self = this
    $.ajax({
        type: "GET",
        url: url + 'statuses/',
        success: function (statuses) {
           self.statuses = statuses;
        }
    })
}




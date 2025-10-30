<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appraisal Admin</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.6.0/fonts/remixicon.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <link href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css" rel="stylesheet" />
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>

    <style></style>
</head>
<body class="m-4">
    <div class="row">
        <button type="button" class="btn btn-primary mb-2 w-25 open-modal d-none" data-bs-toggle="modal" data-bs-target="#openModal">Open Modal</button>
        <div class="modal fade" id="openModal" tabindex="-1"	aria-labelledby="openModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #575653; color: white;">
                        <h6 class="modal-title" id="openModalLabel1">#</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">#</div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center">
        <div class='fw-bold fs-3'><img src="{{url('/')}}/westrac_icon.png" alt="westrac" style="width: 40px;"> Westrac Appraisal Admin</div>
        <div class="d-flex justify-content-center align-items-center">
            <a href="{{url('/')}}/appraisal/history" target="_blank"><button class="btn btn-primary me-2"><i class="ri-history-line me-2"></i>History</button></a>
            <form action="{{ url('/logout') }}" method="post" role="form">
                @csrf
                <button class="btn btn-danger"><i class="ri-logout-box-line me-2"></i>Log out</button>
            </form>
        </div>
    </div>

    <table class="table table-striped table-hover app-table">
        <thead>
            <tr>
                <th class="text-center">Employee</th>
                <th class="text-center">Supervisor</th>
                <th class="text-center">Branch</th>
                <th class="text-center"></th>
            </tr>
        </thead>
        <tbody class="tbl-body"></tbody>
    </table>

    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="toastAlert" class="toast colored-toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toastHead toast-header text-fixed-white">
                <img class="bd-placeholder-img rounded me-2" src="{{url('/')}}/westrac_icon.png" alt="..." style="width: 20px;">
                <strong class="me-auto toastAlertTitle text-white"></strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
            <div class="toast-body toastAlertBody text-fixed-white"></div>
        </div>
    </div>
</body>
<script>
    let display_alert = (title, text, class_name) => {
        if (0 == class_name) {
            class_name = 'bg-danger-subtle';
            class_head = 'bg-danger';
        }
        else if (1 == class_name) {
            class_name = 'bg-success-subtle';
            class_head = 'bg-success';
        }
        else if (2 == class_name) {
            class_name = 'bg-info-subtle';
            class_head = 'bg-info';
        }
        else if (3 == class_name) {
            class_name = 'bg-warning-subtle';
            class_head = 'bg-warning';
        }

        $('#toastAlert').addClass(class_name);
        $('.toastHead').addClass(class_head);
        $('.toastAlertTitle').html(title);
        $('.toastAlertBody').html(text);

        const _toast = document.getElementById('toastAlert')
        const toast = new bootstrap.Toast(_toast);
        toast.show();
    }

    $(document)
        .ready(function(e) {
            $.ajax({
				type		: 'POST',
				url		: "{{url ('/')}}/getAll-employee-data",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
				dataType	: 'json',
				success	: function (data) {
                    $(".tbl-body").html("");
                    let finalHTML = '';

                    $.each(data, function(key, val) {
                        finalHTML += ` 
                            <tr> 
                                <td class="text-start">${val.employee}</td> 
                                <td class="text-start">${val.supervisor}</td> 
                                <td class="text-start">${val.department}</td> 
                                <td class="text-start"><button class='btn btn-success send-app' id='${val.id}'><i class="ri-send-plane-fill me-2"></i>Send Appraisal</button></td> 
                            </tr> 
                        `;                    });

                    $(".tbl-body").append(finalHTML);
                    $('.app-table').DataTable({ 
                        order: [],
                    });
				},
				error		: function (request, status, error) {
					console.log (request.status, request.responseText);
				},
				async		: false
			});
        })
        .on('click', '.send-app', function(e) {
            let id = this.id;
            // retrieve the data in the database
            $.ajax({
                url: "{{url ('/')}}/get-employee-data",
                headers: {'X-CSRF-TOKEN':$ ('meta[name="csrf-token"]').attr ('content')},
                type: "POST",
                data: {
                    "id": id,
                },
                dataType: "json",
                error(xhr,status,error) {
                        console.log("Enter appraisal error: ",xhr.responseText);
                    },
                success: function(data, status){
                    // display_alert ('Add Record', 'Appraisal was succesfully done.', 1);
                    // setTimeout("location.reload();", 1500);
                    
                    let link = '';
                    data[0].is_sup ? link = 'http://apps.westrac.lan/appraisal/supervisor' : link = 'http://apps.westrac.lan/appraisal/direct-report';
                    let emp = data[0].employee;
                    let sup = data[0].supervisor;
                    let sup_email = data[0].supervisor_email;
                    let period = '1 year';

                    const inputDate = new Date(data[0].employment_date);
                    const currentDate = new Date();

                    // Calculate the 3- and 4-month marks
                    const threeMonthsLater = new Date(inputDate);
                    threeMonthsLater.setMonth(inputDate.getMonth() + 3);

                    const fourMonthsLater = new Date(inputDate);
                    fourMonthsLater.setMonth(inputDate.getMonth() + 4);

                    // Check if current date is >= 3 months but < 4 months
                    if (currentDate >= threeMonthsLater && currentDate < fourMonthsLater) { period = 'Probation'; }

                    link += `?employee=${emp}&employeeNumber=${data[0].employee_number}&period=${period}&supervisor=${sup}&employmentDate=${data[0].employment_date}&jobTitle=${data[0].job_title}`;

                    link = encodeURI(link);

                    $.ajax({
                        url: "{{url ('/')}}/send-app-email",
                        headers: {'X-CSRF-TOKEN':$ ('meta[name="csrf-token"]').attr ('content')},
                        type: "POST",
                        data: {
                            "link"       : link,
                            "employee"   : emp,
                            "supervisor" : sup,
                            "sup_email"  : sup_email,
                        },
                        dataType: "json",
                        error(xhr,status,error) {
                                console.log("Enter appraisal error: ",xhr.responseText);
                            },
                        success: function(data, status){
                            if(data.trim() == 'y') {
                                display_alert ('Send Email', 'Email was sent succesfully.', 1);
                                setTimeout("location.reload();", 1500);
                            } else {
                                display_alert ('Send Email', 'Something went wrong when sending email, try again.', 0);
                                setTimeout("location.reload();", 1500);
                            }
                            
                        }
                    });
                }
            });
        })
</script>
</html>
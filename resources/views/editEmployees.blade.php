<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employees</title>
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

    <style>
    </style>
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
        <div class='fw-bold fs-3'><img src="{{url('/')}}/westrac_icon.png" alt="westrac" style="width: 40px;"> Westrac Employees</div>
        <div>
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
        .ready(function(e){
            $.ajax({
				type		: 'POST',
				url		: "{{url ('/')}}/getAll-employees",
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
                                <td class="text-start"><button class='ms-2 btn btn-warning edit-btn' id='${val.id}'><i class="ri-edit-line me-2"></i>Edit</button></td> 
                            </tr> 
                        `; 
                    });

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
        .on('click', '.edit-btn', function(e) {
            let id = this.id;

            $.ajax({
				type		: 'POST',
				url		: "{{url ('/')}}/get-employee-data",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data : { 'id' : id, },
				dataType	: 'json',
				success	: function (data) {
                    $('.open-modal').trigger('click');
                    $('.modal-title').html(`Edit Employee`);
                    $('.modal-body').html(`
                        <div class="">
                            <div class="row mb-2">
                                <div class="col-xl-4">
                                    <label>Employee Name: </label>
                                    <input class="form-control" type='text' id='employee' name='employee' value="${data[0].employee}"/>
                                </div>
                                <div class="col-xl-4">
                                    <label>Employee Number: </label>
                                    <input class="form-control" type='text' id='employeeNumber' name='employeeNumber' value="${data[0].employee_number}"/>
                                </div>
                                <div class="col-xl-4">
                                    <label>Supervisor: </label>
                                    <input class="form-control" type='text' id='supervisor' name='supervisor' value="${data[0].supervisor}"/>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-xl-4">
                                    <label>Employment Date: </label>
                                    <input class="form-control" type='date' id='employmentDate' name='employmentDate' value="${data[0].employment_date}"/>
                                </div>
                                <div class="col-xl-4">
                                    <label>Job Title: </label>
                                    <input class="form-control" type='text' id='jobTitle' name='jobTitle' value="${data[0].job_title}"/>
                                </div>
                                <div class="col-xl-4">
                                    <label>Department: </label>
                                    <select id="departmentID" class="form-control department">
                                        <option value="HQ">HQ</option>
                                        <option value="SPL">SPL</option>
                                        <option value="BMP">BMP</option>
                                        <option value="BZE">BZE</option>
                                        <option value="JD SRVC">JD SRVC</option>
                                        <option value="MDW">MDW</option>
                                        <option value="OW">OW</option>
                                        <option value="SPL T-A">SPL T-A</option>
                                        <option value="BZE T-A">BZE T-A</option>
                                        <option value="DGA">DGA</option>
                                        <option value="PG">PG</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-xl-4">
                                    <label>Supervisor Email: </label>
                                    <input class="form-control" type='text' id='supervisorEmail' name='supervisorEmail' value="${data[0].supervisor_email}"/>
                                </div>
                                <div class="col-xl-4">
                                    <label>Is a Supervisor? </label>
                                    <select id="supID" class="form-control is-sup"><option value="false">No</option><option value="true">Yes</option></select>
                                </div>
                                <div class="col-xl-4">
                                    <label>Is a Manager? </label>
                                    <select id="managerID" class="form-control is-manager"><option value="false">No</option><option value="true">Yes</option></select>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-xl-4">
                                    <label>Is active? </label>
                                    <select id="activeID" class="form-control is-active"><option value="false">No</option><option value="true">Yes</option></select>
                                </div>
                            </div>
                        </div>
                        <div class="text-end mt-3">
                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary edit-employee">Edit</button>
                        </div>
                    `);
                    document.getElementById("departmentID").value = data[0].department;
                    document.getElementById("supID").value = data[0].is_sup;
                    document.getElementById("managerID").value = data[0].is_manager;
                    document.getElementById("activeID").value = data[0].is_active;

                    $('.edit-employee').prop({id: id});
				},
				error		: function (request, status, error) {
					console.log (request.status, request.responseText);
				},
				async		: false
			});
        })
        .on('click', '.edit-employee', function(e) {
            let id = this.id;

            $.ajax({
                url: "{{url ('/')}}/edit-employee",
                headers: {'X-CSRF-TOKEN':$ ('meta[name="csrf-token"]').attr ('content')},
                type: "POST",
                data: {
                    "id"                : id,
                    "employee"          : $('#employee').val(),
                    "employee-number"   : $('#employeeNumber').val(),
                    "supervisor"        : $('#supervisor').val(),
                    "employment-date"   : $('#employmentDate').val(),
                    "job-title"         : $('#jobTitle').val(),
                    "department"        : $('.department').val(),
                    "supervisor-email"  : $('#supervisorEmail').val(),
                    "is-sup"            : $('.is-sup').val(),
                    "is-manager"        : $('.is-manager').val(),
                    "is-active"         : $('.is-active').val(),
                },
                dataType: "json",
                error(xhr,status,error) {
                        console.log("Edit employee error: ",xhr.responseText);
                    },
                success: function(data, status){
                    if(data.trim() == 'y') {
                        display_alert ('Edit Employee', 'Employee was edited succesfully.', 1);
                        setTimeout("location.reload();", 1500);
                    } else {
                        display_alert ('Edit Employee', 'Something went wrong when editing employee, try again.', 0);
                        setTimeout("location.reload();", 1500);
                    }
                    
                }
            });
        })
</script>
</html>
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
            <button class="btn btn-warning me-2 add-emp"><i class="ri-add-fill me-2"></i>Add Employee</button>
            <a href="{{url('/')}}/appraisal/editEmployees" target="_blank"><button class="btn btn-info me-2"><i class="ri-edit-line me-2"></i>Edit Employees</button></a>
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
        .on('click', '.add-emp', function(e) {
            $('.open-modal').trigger('click');
            $('.modal-title').html(`Add Employee`);
            $('.modal-body').html(`
                <div class="">
                    <div class="row mb-2">
                        <div class="col-xl-4">
                            <label>Employee Name: </label>
                            <input class="form-control" type='text' id='employee' name='employee'/>
                        </div>
                        <div class="col-xl-4">
                            <label>Employee Number: </label>
                            <input class="form-control" type='text' id='employeeNumber' name='employeeNumber'/>
                        </div>
                        <div class="col-xl-4">
                            <label>Supervisor: </label>
                            <select class="form-control" id='supervisor'>
                                <option value="">-</option>
                                <option data-dept="HQ" data-email="albertpenner@westracbelize.com" value="Albert Penner">Albert Penner</option>
                                <option data-dept="HQ" data-email="allanreimer@westracbelize.com" value="Allan Reimer">Allan Reimer</option>
                                <option data-dept="HQ" data-email="andymolina@westracbelize.com" value="Andy Molina">Andy Molina</option>
                                <option data-dept="HQ" data-email="conroypenner@westracbelize.com" value="Conroy Penner">Conroy Penner</option>
                                <option data-dept="HQ" data-email="dannyku@westracbelize.com" value="Danny Ku">Danny Ku</option>
                                <option data-dept="HQ" data-email="dianacastillo@westracbelize.com" value="Diana Castillo">Diana Castillo</option>
                                <option data-dept="HQ" data-email="glenkornelsen@westracbelize.com" value="Glen Kornelsen">Glen Kornelsen</option>
                                <option data-dept="HQ" data-email="henrywiebe@westracbelize.com" value="Heinrich Wiebe">Heinrich Wiebe</option>
                                <option data-dept="HQ" data-email="jacobpenner@westracbelize.com" value="Jacob Penner">Jacob Penner</option>
                                <option data-dept="HQ" data-email="jakewolfe@westracbelize.com" value="Jake Wolfe">Jake Wolfe</option>
                                <option data-dept="HQ" data-email="lisbethpena@westracbelize.com" value="Lisbeth Pena">Lisbeth Pena</option>
                                <option data-dept="HQ" data-email="milliepulido@westracbelize.com" value="Millie Pulido">Millie Pulido</option>
                                <option data-dept="HQ" data-email="johnnypetkau@westracbelize.com" value="Johan petkau">Johan petkau</option>
                                <option data-dept="HQ" data-email="erwinthiessen@westracbelize.com" value="Erwin Thiessen">Erwin Thiessen</option>
                                <option data-dept="HQ" data-email="peterthiessen@westracbelize.com" value="Peter Thiessen">Peter Thiessen</option>
                                <option data-dept="HQ" data-email="rainiercorrea@westracbelize.com" value="Rainier Correa">Rainier Correa</option>
                                <option data-dept="HQ" data-email="wendygregorio@westracbelize.com" value="Wendy Gregorio Reyes">Wendy Gregorio Reyes</option>
                                <option data-dept="SPL" data-email="anthonyjimenez@westracbelize.com" value="Anthony Jimenez">Anthony Jimenez</option>
                                <option data-dept="SPL" data-email="gerardorempel@westracbelize.com" value="Gerardo Rempel">Gerardo Rempel</option>
                                <option data-dept="SPL" data-email="hughdelleysaguirre@westracbelize.com" value="Hughdelle Ysaguirre">Hughdelle Ysaguirre</option>
                                <option data-dept="SPL" data-email="jacobwiebe@westracbelize.com" value="Jacob Wiebe">Jacob Wiebe</option>
                                <option data-dept="SPL" data-email="walterthiessen@westracbelize.com" value="Walter Thiessen">Walter Thiessen</option>
                                <option data-dept="SPL" data-email="sandrahernandez@westracbelize.com" value="Sandra Romero">Sandra Romero</option>
                                <option data-dept="BMP" data-email="agnesitza@westracbelize.com" value="Agnes Itza Gongora">Agnes Itza Gongora</option>
                                <option data-dept="BMP" data-email="eliaschoc@westracbelize.com" value="Elias Choc">Elias Choc</option>
                                <option data-dept="BMP" data-email="esvinbautista@westracbelize.com" value="Esvin Bautista">Esvin Bautista</option>
                                <option data-dept="BMP" data-email="ingmarerazo@westracbelize.com" value="Ingmar Erazo">Ingmar Erazo</option>
                                <option data-dept="BMP" data-email="kcdunn@westracbelize.com" value="Kenneth Dunn">Kenneth Dunn</option>
                                <option data-dept="BZE" data-email="cristinarios@westracbelize.com" value="Cristina Rios">Cristina Rios</option>
                                <option data-dept="BZE" data-email="elisamatzib@westracbelize.com" value="Elisama Tzib">Elisama Tzib</option>
                                <option data-dept="BZE" data-email="josehamilton@westracbelize.com" value="Jose Hamilton">Jose Hamilton</option>
                                <option data-dept="BZE" data-email="rolandocamal@westracbelize.com" value="Rolando Camal">Rolando Camal</option>
                                <option data-dept="BZE" data-email="davidbueckert@westracbelize.com" value="David Bueckert">David Bueckert</option>
                                <option data-dept="JD SRVC" data-email="bernhardpenner@westracbelize.com" value="Bernhard Penner">Bernhard Penner</option>
                                <option data-dept="JD SRVC" data-email="jessicamontepeque@westracbelize.com" value="Jessica Montepeque">Jessica Montepeque</option>
                                <option data-dept="JD SRVC" data-email="trevorthiessen@westracbelize.com" value="Trevor Thiessen">Trevor Thiessen</option>
                                <option data-dept="MDW" data-email="arlinbautista@westracbelize.com" value="Arlin Bautista Sarceno">Arlin Bautista Sarceno</option>
                                <option data-dept="MDW" data-email="hugosalazar@westracbelize.com" value="Hugo Salazar Jr.">Hugo Salazar Jr.</option>
                                <option data-dept="MDW" data-email="darsonpenner@westracbelize.com" value="Darson Penner">Darson Penner</option>
                                <option data-dept="MDW" data-email="orlandowolfe@westracbelize.com" value="Orlando Wolfe">Orlando Wolfe</option>
                                <option data-dept="MDW" data-email="rigziportillo@westracbelize.com" value="Rigzi Portillo">Rigzi Portillo</option>
                                <option data-dept="MDW" data-email="ronaldvillas@westracbelize.com" value="Ronald Villas">Ronald Villas</option>
                                <option data-dept="MDW" data-email="shennycalderon@westracbelize.com" value="Shenny Calderon">Shenny Calderon</option>
                                <option data-dept="OW" data-email="abramfriesen@westracbelize.com" value="Abram Friesen">Abram Friesen</option>
                                <option data-dept="OW" data-email="donnatillett@westracbelize.com" value="Donna Tillett">Donna Tillett</option>
                                <option data-dept="OW" data-email="enriquetzul@westracbelize.com" value="Enrique Tzul">Enrique Tzul</option>
                                <option data-dept="OW" data-email="jesseochoa@westracbelize.com" value="Jesse Ochoa">Jesse Ochoa</option>
                                <option data-dept="OW" data-email="johanpetkau@westracbelize.com" value="Johan Petkau">Johan Petkau</option>
                                <option data-dept="SPL T-A" data-email="darienarevalo@westracbelize.com" value="Darien Arevalo">Darien Arevalo</option>
                                <option data-dept="SPL T-A" data-email="hugoescobar@westracbelize.com" value="Hugo Méndez Escobar">Hugo Méndez Escobar</option>
                                <option data-dept="BZE T-A" data-email="nayeli.bustillos@westracbelize.com" value="Nayeli Bustillos Guemez">Nayeli Bustillos Guemez</option>
                                <option data-dept="BZE T-A" data-email="normanmunoz@westracbelize.com" value="Norman Munoz">Norman Munoz</option>
                                <option data-dept="DGA" data-email="cindyvillafranco@westracbelize.com" value="Cindy Villafranco">Cindy Villafranco</option>
                                <option data-dept="DGA" data-email="jonboehmer@westracbelize.com" value="Jon Boehmer">Jon Boehmer</option>
                                <option data-dept="DGA" data-email="rudypadilla@westracbelize.com" value="Rudy Padilla">Rudy Padilla</option>
                                <option data-dept="DGA" data-email="marloncalderon@westracbelize.com" value="Marlon Calderon">Marlon Calderon</option>
                                <option data-dept="PG" data-email="waynemoore@westracbelize.com" value="Wayne Moore">Wayne Moore</option>
                                <option data-dept="PG" data-email="aislynnjuarez@westracbelize.com" value="Aislynn Juarez Kus">Aislynn Juarez Kus</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-xl-4">
                            <label>Employment Date: </label>
                            <input class="form-control" type='date' id='employmentDate' name='employmentDate'/>
                        </div>
                        <div class="col-xl-4">
                            <label>Job Title: </label>
                            <input class="form-control" type='text' id='jobTitle' name='jobTitle'/>
                        </div>
                        <div class="col-xl-4">
                            <label>Department: </label>
                            <input class="form-control department" type='text' id='department' name='department' readonly/>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-xl-4">
                            <label>Supervisor Email: </label>
                            <input class="form-control" type='text' id='supervisorEmail' name='supervisorEmail' readonly/>
                        </div>
                        <div class="col-xl-4">
                            <label>Is a Supervisor? </label>
                            <select class="form-control is-sup"><option value="false">No</option><option value="true">Yes</option></select>
                        </div>
                        <div class="col-xl-4">
                            <label>Is a Manager? </label>
                            <select class="form-control is-manager"><option value="false">No</option><option value="true">Yes</option></select>
                        </div>
                    </div>
                </div>
                <div class="text-end mt-3">
                    <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary add-employee">Add</button>
                </div>
            `);
            $('#supervisor').select2({dropdownParent: $("#openModal"), width: '100%'});
            // $('.add-attachment').prop({name: name});
        })
        .on('click', '.add-employee', function(e) {
            $.ajax({
                url: "{{url ('/')}}/add-employee",
                headers: {'X-CSRF-TOKEN':$ ('meta[name="csrf-token"]').attr ('content')},
                type: "POST",
                data: {
                    "employee"          : $('#employee').val(),
                    "employee-number"   : $('#employeeNumber').val(),
                    "supervisor"        : $('#supervisor').val(),
                    "employment-date"   : $('#employmentDate').val(),
                    "job-title"         : $('#jobTitle').val(),
                    "department"        : $('#department').val(),
                    "supervisor-email"  : $('#supervisorEmail').val(),
                    "is-sup"            : $('.is-sup').val(),
                    "is-manager"        : $('.is-manager').val(),
                },
                dataType: "json",
                error(xhr,status,error) {
                        console.log("Enter employee error: ",xhr.responseText);
                    },
                success: function(data, status){
                    if(data.trim() == 'y') {
                        display_alert ('Add Employee', 'Employee was added succesfully.', 1);
                        setTimeout("location.reload();", 1500);
                    } else {
                        display_alert ('Add Employee', 'Something went wrong when adding employee, try again.', 0);
                        setTimeout("location.reload();", 1500);
                    }
                    
                }
            });
        })
        .on('change', '#supervisor', function(e) {
            $('#department').val($('#supervisor option:selected').data('dept'));
            $('#supervisorEmail').val($('#supervisor option:selected').data('email'));
        })
</script>
</html>
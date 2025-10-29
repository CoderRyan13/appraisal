<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appraisal History</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
        .form-container {
            margin-left: 40px;
            margin-right: 40px;
        }
        .logo {
            text-align: center;
            font-weight: bold;
            font-size: 50px;
        }
        .title-block {
            background-color: grey;
            padding: 10px;
            margin-bottom: 20px;
        }
        .title {
            text-align: center;
            font-weight: bold;
            color: white;
            font-size: 40px;
        }
        .type {
            text-align: center;
            color: white;
        }
        .info {
            width: 100%;
        }
        th, td {
            padding: 8px;
        }
        .purpose {
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .job-resp {
            width: 100%;
        }
        .inp {
            width: 100%;
        }
        .performance-category {
            width: 100%;
            margin-top: 40px;
            /* table-layout: fixed; */
        }
        td {
            vertical-align: top;
        }
        .star {
            width: 120px;
            margin-top: -6px;
        }
        .input, .others {
            width: 100%;
        }
        .slider-container {
            width: 100%;
        }
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
        <div class='fw-bold fs-3'><img src="{{url('/')}}/westrac_icon.png" alt="westrac" style="width: 40px;"> Westrac Appraisal History</div>
        <div>
            <form action="{{ url('/logout') }}" method="post" role="form">
                @csrf
                <button class="btn btn-danger">Log out</button>
            </form>
        </div>
    </div>

    <table class="table table-striped table-hover app-table">
        <thead>
            <tr>
                <th class="text-center">Appraisal Date</th>
                <th class="text-center">Employee</th>
                <th class="text-center">Date Employed</th>
                <th class="text-center">Supervisor</th>
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

    function checkInputs() {
        var allFilled = true;
        $('.myform .input').each(function() {
            if ($(this).val() === '') {
                allFilled = false;
                return false; // Exit the loop early
            }
        });

        // Enable or disable the submit button based on allFilled
        if (allFilled) {
            $('.myform .submit').prop('disabled', false);
        } else {
            $('.myform .submit').prop('disabled', true);
        }
    }

    let average_ratings = 0;

    $(document)
        .ready(function(e){
            $.ajax({
				type		: 'POST',
				url		: "{{url ('/')}}/getAll-appraisal-data",
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
                                <td class="text-start">${val.appraisal_date}</td> 
                                <td class="text-start">${val.employee}</td> 
                                <td class="text-start">${val.employment_date}</td> 
                                <td class="text-start">${val.supervisor}</td> 
                                <td class="text-start"><button class='btn btn-success view-btn' id='${val.id}'>View</button> <button class='ms-2 btn btn-warning edit-btn' id='${val.id}'>Edit</button></td> 
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

            // Check inputs on page load
            checkInputs();
        })
        .on('change', '.myform .input', function(e) {
            checkInputs();
            
            // allows the stars to display based on input and also updates on change
            for(let i = 1; i <= 30; i++) {
            // $(`.val${i}`).html(`<img src="{{ url('/') }}/ratings_images/star-${$(`.slider${i}`).val()}.png" class="star">`);
            $(`.val${i}`).html(`${$(`.slider${i}`).val()}`);

                $(`.slider${i}`).on("change", function() {
                    // $(`.val${i}`).html(`<img src="{{ url('/') }}/ratings_images/star-${$(`.slider${i}`).val()}.png" class="star">`);
                    $(`.val${i}`).html(`${$(`.slider${i}`).val()}`);
                }) 
            }
        })
        .on('click', '.view-btn', function(e) {
            let id = this.id;

            $.ajax({
				type      : 'POST',
				url		  : "{{url ('/')}}/get-appraisal-data",
                headers   : {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
				dataType  : 'json',
                data      : {
                    'id' : id,
                },
				success	  : function (data) {
                    let supClass = '';
                    let appType = '';
                    let rating = Number(data[0].average_rating);
                    let wordRating = '';
                    if(rating >= 1 && rating < 1.5) { wordRating='Poor' }
                    else if(rating >= 1.5 && rating < 2) { wordRating='Poor - Fair' }
                    else if(rating >= 2 && rating < 2.5) { wordRating='Fair' }
                    else if(rating >= 2.5 && rating < 3) { wordRating='Fair - Good' }
                    else if(rating >= 3 && rating < 3.5) { wordRating='Good' }
                    else if(rating >= 3.5 && rating < 4) { wordRating='Good - Very Good' }
                    else if(rating >= 4 && rating < 4.5) { wordRating='Very Good' }
                    else if(rating >= 4.5 && rating < 5) { wordRating='Very Good - Excellent' }
                    else {wordRating='Excellent'};

                    data[0].organize_rating_1 ? supClass = '' : supClass = 'd-none'; 
                    data[0].organize_rating_1 ? appType = 'Supervisor' : appType = 'Direct Report'; 

                    let name = data[0].employee;
                    $('.open-modal').trigger('click');
                    $('.modal-title').html(`View ${name}'s Appraisal`);
                    $('.modal-body').html(`
                        <div class="form-container myform">
                            <div class="logo text-center"><img src="{{ url('/') }}/westraclogo.jpeg" width="450px;"></div>
                            <div class="title-block d-flex flex-column align-items-center justify-content-center" style="background-color: grey; padding: 10px; margin-bottom: 20px;">
                                <div class="title">Employee Performance Appraisal</div>
                                <div class="type">(${appType})</div>
                            </div>
                            <table class="info col-xs-12">
                                <tr>
                                    <th class="col-xs-2">Employee: </th>
                                    <td><input type="text" class="employee input col-xs-10" value="${data[0].employee}" readonly></td>
                                    <th class="col-xs-2">Employment Date: </th>
                                    <td><input type="date" class="employment-date input col-xs-10" value="${data[0].employment_date}" readonly></td>
                                </tr>
                                <tr>
                                    <th>Employee Number: </th>
                                    <td><input type="text" class="employee-number input" value="${data[0].employee_number}" readonly></td>
                                    <th>Job Title: </th>
                                    <td><input type="text" class="job-title input" value="${data[0].job_title}" readonly></td>
                                </tr>
                                <tr>
                                    <th>Period of Evaluation: </th>
                                    <td><input type="text" class="evaluation-period input" value="${data[0].evaluation_period}" readonly></td>
                                    <th>Date: </th>
                                    <td><input type="text" class="appraisal-date input" value="${data[0].appraisal_date}" readonly></td>
                                </tr>
                                <tr>
                                    <th>Supervisor: </th>
                                    <td><input type="text" class="supervisor input" value="${data[0].supervisor}" readonly></td>
                                </tr>
                            </table>
                            <div class="purpose">
                                <b>Purpose: </b> The purpose of conducting this Performance Appraisal is to: develop better communication between the employee and the supervisor,
                                improve the quality of work, increase productivity, and promote employee development.
                            </div>
                            <table class="job-resp col-xs-12">
                                <div><b>Job Responsibilities:</b></div>
                                <tr><td class="col-xs-1">1.</td> <td><input type="text" class="job-resp1 inp" value="${data[0].job_resp1 ? data[0].job_resp1 : ''}" readonly></td></tr>
                                <tr><td class="col-xs-1">2.</td> <td><input type="text" class="job-resp2 inp" value="${data[0].job_resp2 ? data[0].job_resp2 : ''}" readonly></td></tr>
                                <tr><td class="col-xs-1">3.</td> <td><input type="text" class="job-resp3 inp" value="${data[0].job_resp3 ? data[0].job_resp3 : ''}" readonly></td></tr>
                                <tr><td class="col-xs-1">4.</td> <td><input type="text" class="job-resp4 inp" value="${data[0].job_resp4 ? data[0].job_resp4 : ''}" readonly></td></tr>
                                <tr><td class="col-xs-1">5.</td> <td><input type="text" class="job-resp5 inp" value="${data[0].job_resp5 ? data[0].job_resp5 : ''}" readonly></td></tr>
                            </table>
                            <table>
                                <tr>
                                    <th>Excellent (5):</th>
                                    <td>Employee ensured extremely effective performance. Surpassed expectations.</td>
                                </tr>
                                <tr>
                                    <th>Very Good (4):</th>
                                    <td>Employee ensured more than adequate and effective performance. Generally, exceeded expectations for successful job performance. Consistently demonstrated better than average level of performance. </td>
                                </tr>
                                <tr>
                                    <th>Good (3):</th>
                                    <td>Employee ensured adequate performance. Met criteria required for successful job performance. Some deficiencies existed in the areas assessed but none of major concern. </td>
                                </tr>
                                <tr>
                                    <th>Fair (2):</th>
                                    <td>At times, did not meet criteria for effective performance. A concern existed.</td>
                                </tr>
                                <tr>
                                    <th>Poor (1):</th>
                                    <td>Below criteria required for successful job performance. A problem existed. Demonstrated counter-productive behaviors that had negative outcomes or consequences. </td>
                                </tr>
                            </table>
                            <table class="performance-category table">
                                <tr>
                                    <th style="width:30%;">Performance Category</th>
                                    <th style="width:15%;">Rating</th>
                                    <th style="width:55%;">Comments and Examples</th>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <table class="table col-xs-12">
                                            <tr>
                                                <td class="col-xs-8"><b>Attendance:</b><br><br>Consider the number of absences and requests for personal time off.</td>
                                                <td><br><br>
                                                    <div class="slidecontainer">
                                                        <div class="val1">${data[0].attendance_rating_1}</div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>    
                                    <td><br>
                                        <textarea rows="6" cols="50" class="form-control attendance-memo" readonly>${data[0].attendance_memo ? data[0].attendance_memo : ''}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <table class="table col-xs-12">
                                            <tr>
                                                <td class="col-xs-8"><b>Punctuality:</b><br><br>Consider the arrival time and departure time lunch periods and breaks.</td>
                                                <td><br><br>
                                                    <div class="slidecontainer">
                                                        <div class="val2">${data[0].punctuality_rating_1}</div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Consider if employee begins to work promptly upon arrival.</td>
                                                <td>
                                                    <div class="slidecontainer">
                                                        <div class="val3">${data[0].punctuality_rating_2}</div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>    
                                    <td><br>
                                        <textarea rows="6" cols="50" class="form-control punctuality-memo" readonly>${data[0].punctuality_memo ? data[0].punctuality_memo : ''}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <table class="table col-xs-12">
                                            <tr>
                                                <td class="col-xs-8"><b>Productivity:</b><br><br>Consider how the employee uses available time:<br>
                                                Does the employee complete work quickly and efficiently?</td>
                                                <td><br><br>
                                                    <div class="slidecontainer">
                                                        <div class="val4">${data[0].productivity_rating_1}</div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Does the employee act without prompting to get assigned work done?</td>
                                                <td>
                                                    <div class="slidecontainer">
                                                        <div class="val5">${data[0].productivity_rating_2}</div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Does the employee look for "work" when assigned tasks are completed if there is available time?</td>
                                                <td>
                                                    <div class="slidecontainer">
                                                        <div class="val6">${data[0].productivity_rating_3}</div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Consider how well the employee handles digital distractions (personal phone, internet browsing).</td>
                                                <td>
                                                    <div class="slidecontainer">
                                                        <div class="val7">${data[0].productivity_rating_4}</div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>    
                                    <td><br>
                                        <textarea rows="6" cols="50" class="form-control productivity-memo" readonly>${data[0].productivity_memo ? data[0].productivity_memo : ''}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <table class="table col-xs-12">
                                            <tr>
                                                <td class="col-xs-8"><b>Quality work:</b><br><br>Consider if work is thorough, accurate and precise. Consider the extent to which the employee ensures the work is well done.</td>
                                                <td><br><br>
                                                    <div class="slidecontainer">
                                                        <div class="val8">${data[0].qualitywork_rating_1}</div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>    
                                    <td><br>
                                        <textarea rows="6" cols="50" class="form-control qualitywork-memo" readonly>${data[0].qualitywork_memo ? data[0].qualitywork_memo : ''}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <table class="table col-xs-12">
                                            <tr>
                                                <td class="col-xs-8"><b>Team player:</b><br><br>Consider the ability and willingness to cooperate and be helpful with other employees.</td>
                                                <td><br><br>
                                                    <div class="slidecontainer">
                                                        <div class="val9">${data[0].teamplayer_rating_1}</div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Consider how well the employee builds a good and beneficial rapport with fellow team members.</td>
                                                <td>
                                                    <div class="slidecontainer">
                                                        <div class="val10">${data[0].teamplayer_rating_2}</div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Consider how well the employee cooperates with employees from other branches.</td>
                                                <td>
                                                    <div class="slidecontainer">
                                                        <div class="val11">${data[0].teamplayer_rating_3}</div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Consider if the employee values team success over individual success.</td>
                                                <td>
                                                    <div class="slidecontainer">
                                                        <div class="val12">${data[0].teamplayer_rating_4}</div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>    
                                    <td><br>
                                        <textarea rows="6" cols="50" class="form-control teamplayer-memo" readonly>${data[0].teamplayer_memo ? data[0].teamplayer_memo : ''}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <table class="table col-xs-12">
                                            <tr>
                                                <td class="col-xs-8"><b>Communication:</b><br><br>Consider how effectively the employee communicates with supervisor, co-workers, and customers.</td>
                                                <td><br><br>
                                                    <div class="slidecontainer">
                                                        <div class="val13">${data[0].communication_rating_1}</div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Consider how well the employee communicates with co-workers when dealing with a difficult situation. Ability to communicate in a non-blaming manner.</td>
                                                <td>
                                                    <div class="slidecontainer">
                                                        <div class="val14">${data[0].communication_rating_2}</div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>    
                                    <td><br>
                                        <textarea rows="6" cols="50" class="form-control communication-memo" readonly>${data[0].communication_memo ? data[0].communication_memo : ''}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <table class="table col-xs-12">
                                            <tr>
                                                <td class="col-xs-8"><b>People/Human Relations:</b><br><br>Consider the ability of the employee to call the attention to a co-worker's mistake in a way that makes co-worker willing to cooperate. Consider how well the employee offers constructive criticism.</td>
                                                <td><br><br>
                                                    <div class="slidecontainer">
                                                        <div class="val15">${data[0].peoplerelations_rating_1}</div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Consider how well the employee accepts criticism. Is the employee willing to make corrections?</td>
                                                <td>
                                                    <div class="slidecontainer">
                                                        <div class="val16">${data[0].peoplerelations_rating_2}</div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Consider the ability and willingness of the employee to ensure that customers' requests are fully satisfied. Follow up if neccessary.</td>
                                                <td>
                                                    <div class="slidecontainer">
                                                        <div class="val17">${data[0].peoplerelations_rating_3}</div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>    
                                    <td><br>
                                        <textarea rows="6" cols="50" class="form-control peoplerelations-memo" readonly>${data[0].peoplerelations_memo ? data[0].peoplerelations_memo : ''}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <table class="table col-xs-12">
                                            <tr>
                                                <td class="col-xs-8"><b>Ability to take Ownership:</b><br><br>Consider the ability of the employee to take ownership of assigned tasks and figure how to get things done. How well the employee accepts responsibility?</td>
                                                <td><br><br>
                                                    <div class="slidecontainer">
                                                        <div class="val18">${data[0].ownership_rating_1}</div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Consider the ability of the employee to recognize and admit mistakes and take action to correct it.</td>
                                                <td>
                                                    <div class="slidecontainer">
                                                        <div class="val19">${data[0].ownership_rating_2}</div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>    
                                    <td><br>
                                        <textarea rows="6" cols="50" class="form-control ownership-memo" readonly>${data[0].ownership_memo ? data[0].ownership_memo : ''}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <table class="table col-xs-12">
                                            <tr>
                                                <td class="col-xs-8"><b>Job Attitude:</b><br><br>Consider if employee sustains motivation to do the best job possible?</td>
                                                <td><br><br>
                                                    <div class="slidecontainer">
                                                        <div class="val20">${data[0].jobattitude_rating_1}</div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>    
                                    <td><br>
                                        <textarea rows="6" cols="50" class="form-control jobattitude-memo" readonly>${data[0].jobattitude_memo ? data[0].jobattitude_memo : ''}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <table class="table col-xs-12">
                                            <tr>
                                                <td class="col-xs-8"><b>Consistent Impovement:</b><br><br>Does employee take initiative to learn? Consider the desire of the employee to become better.</td>
                                                <td><br><br>
                                                    <div class="slidecontainer">
                                                        <div class="val21">${data[0].improvement_rating_1}</div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>    
                                    <td><br>
                                        <textarea rows="6" cols="50" class="form-control improvement-memo" readonly>${data[0].improvement_memo ? data[0].improvement_memo : ''}</textarea>
                                    </td>
                                </tr>         
                                <tr>
                                    <td colspan="2">
                                        <table class="table col-xs-12">
                                            <tr>
                                                <td class="col-xs-8"><b>Safety:</b><br><br>Consider how well employee follows safety practices to avoid accidents and damage to company property. Does employee reports damage to company proporty?</td>
                                                <td><br><br>
                                                    <div class="slidecontainer">
                                                        <div class="val22">${data[0].safety_rating_1}</div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>    
                                    <td><br>
                                        <textarea rows="6" cols="50" class="form-control safety-memo" readonly>${data[0].safety_memo ? data[0].safety_memo : ''}</textarea>
                                    </td>
                                </tr>
                                <tr class='isSup ${supClass}'><th colspan="12" class="text-center">Leadership</th></tr>
                                <tr class='isSup ${supClass}'>
                                    <td colspan="2">
                                        <table class="table col-xs-12">
                                            <tr>
                                                <td class="col-xs-8"><b>Organize:</b><br><br>Consider how well the employee organizes work in the department to ensure efficient operation.</td>
                                                <td><br><br>
                                                    <div class="slidecontainer">
                                                        <div class="val23">${data[0].organize_rating_1}</div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Consider how well the employee gives clear direction in assigning tasks to ensure understanding of purpose, expected results and the timing of the tasks.</td>
                                                <td>
                                                    <div class="slidecontainer">
                                                        <div class="val24">${data[0].organize_rating_2}</div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Consider how well employee ensures the adherence of company's policies and procedure by his direct reports.</td>
                                                <td>
                                                    <div class="slidecontainer">
                                                        <div class="val25">${data[0].organize_rating_3}</div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b>Work Ethics:</b><br><br>Consider how well the employee leads by example.</td>
                                                <td><br><br>
                                                    <div class="slidecontainer">
                                                        <div class="val26">${data[0].workethics_rating_1}</div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b>Communication:</b><br><br>Consider how well the employee delivers spoken and written communications. When and how to pass information?</td>
                                                <td><br><br>
                                                    <div class="slidecontainer">
                                                        <div class="val27">${data[0].leadership_communication_rating_1}</div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b>Personal Development:</b><br><br>Consider how well the employee demonstrates mature judgment in addressing unacceptable behavior or performance.</td>
                                                <td><br><br>
                                                    <div class="slidecontainer">
                                                        <div class="val28">${data[0].personaldev_rating_1}</div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Consider how well the employee provides honest feedback and recognition to his/her direct reports.</td>
                                                <td>
                                                    <div class="slidecontainer">
                                                        <div class="val29">${data[0].personaldev_rating_2}</div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>    
                                    <td><br>
                                        <textarea rows="6" cols="50" class="form-control leadership-memo" readonly>${data[0].leadership_memo ? data[0].leadership_memo : ''}</textarea>
                                    </td>
                                </tr>         
                                <tr>
                                    <td colspan="2">
                                        <table class="table col-xs-12">
                                            <tr>
                                                <td class="col-xs-8"><b>Overall Performance:</b></td>
                                                <td><br><br>
                                                    <div class="slidecontainer">
                                                        <div class="val30">${data[0].overall_rating}</div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>    
                                    <td><br>
                                        <textarea rows="6" cols="50" class="form-control overall-memo" readonly>${data[0].overall_memo ? data[0].overall_memo : ''}</textarea>
                                    </td>
                                </tr>
                            </table>
                            <div class="h3"><b>By signing below, the employee acknowledges discussion of this document.</b></div><br><br>
                            <table class="table">
                                <tr>
                                    <td>
                                        <b>Employee Name and Signature:</b> <br><br>
                                        <input type="text" class="employee-sig input" value="${data[0].employee_sig}" readonly><br><br>
                                        <b>Date:</b> <br><br>
                                        <input type="date" class="employee-sig-date input" value="${data[0].employee_sig_date}" readonly>                  
                                    </td>
                                    <td><br>
                                        Comment: <br>
                                        <textarea rows="6" cols="50" class="form-control employee-memo" readonly>${data[0].employee_memo ? data[0].employee_memo : ''}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>Supervisor Name and Signature:</b> <br><br>
                                        <input type="text" class="supervisor-sig input" value="${data[0].supervisor_sig}" readonly><br><br>
                                        <b>Date:</b> <br><br>
                                        <input type="date" class="supervisor-sig-date input" value="${data[0].supervisor_sig_date}" readonly>                  
                                    </td>
                                    <td><br>
                                        Comment: <br> 
                                        <textarea rows="6" cols="50" class="form-control supervisor-memo" readonly>${data[0].supervisor_memo ? data[0].supervisor_memo : ''}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>Manager Name and Signature:</b> <br><br>
                                        <input type="text" class="manager-sig others" readonly><br><br>
                                        <b>Date:</b> <br><br>
                                        <input type="text" class="manager-sig-date others" readonly>                  
                                    </td>
                                    <td><br>
                                        Comment: <br>
                                        <textarea rows="6" cols="50" class="form-control" readonly></textarea>
                                    </td>
                                </tr>
                            </table>
                            <div class="average-rating h4 text-right f-rating"></div>      
                            <div class="fw-bold fs-4 text-center">Average Rating: ${rating} ( ${wordRating} )</div>
                        </div>
                        <div class="text-end mt-3">
                            <button type="button" class="btn btn-primary print-app">Print</button>
                            <button type="button" class="btn btn-success me-2" data-bs-dismiss="modal">Done</button>
                        </div>
                    `);
                    // $('.add-attachment').prop({name: name});

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
				type      : 'POST',
				url		  : "{{url ('/')}}/get-appraisal-data",
                headers   : {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
				dataType  : 'json',
                data      : {
                    'id' : id,
                },
				success	  : function (data) {
                    let supClass = '';
                    let appType = '';
                    let rating = Number(data[0].average_rating);
                    let wordRating = '';
                    if(rating >= 1 && rating < 1.5) { wordRating='Poor' }
                    else if(rating >= 1.5 && rating < 2) { wordRating='Poor - Fair' }
                    else if(rating >= 2 && rating < 2.5) { wordRating='Fair' }
                    else if(rating >= 2.5 && rating < 3) { wordRating='Fair - Good' }
                    else if(rating >= 3 && rating < 3.5) { wordRating='Good' }
                    else if(rating >= 3.5 && rating < 4) { wordRating='Good - Very Good' }
                    else if(rating >= 4 && rating < 4.5) { wordRating='Very Good' }
                    else if(rating >= 4.5 && rating < 5) { wordRating='Very Good - Excellent' }
                    else {wordRating='Excellent'};

                    data[0].organize_rating_1 ? supClass = '' : supClass = 'd-none'; 
                    data[0].organize_rating_1 ? appType = 'Supervisor' : appType = 'Direct Report'; 

                    let name = data[0].employee;
                    $('.open-modal').trigger('click');
                    $('.modal-title').html(`Edit ${name}'s Appraisal`);
                    $('.modal-body').html(`
                        <div class="form-container myform">
                            <div class="logo text-center"><img src="{{ url('/') }}/westraclogo.jpeg" width="450px;"></div>
                            <div class="title-block d-flex flex-column align-items-center justify-content-center" style="background-color: grey; padding: 10px; margin-bottom: 20px;">
                                <div class="title">Employee Performance Appraisal</div>
                                <div class="type">(${appType})</div>
                            </div>
                            <table class="info col-xs-12">
                                <tr>
                                    <th class="col-xs-2">Employee: </th>
                                    <td><input type="text" class="employee input col-xs-10" value="${data[0].employee}" readonly></td>
                                    <th class="col-xs-2">Employment Date: </th>
                                    <td><input type="date" class="employment-date input col-xs-10" value="${data[0].employment_date}" readonly></td>
                                </tr>
                                <tr>
                                    <th>Employee Number: </th>
                                    <td><input type="text" class="employee-number input" value="${data[0].employee_number}" readonly></td>
                                    <th>Job Title: </th>
                                    <td><input type="text" class="job-title input" value="${data[0].job_title}" readonly></td>
                                </tr>
                                <tr>
                                    <th>Period of Evaluation: </th>
                                    <td><input type="text" class="evaluation-period input" value="${data[0].evaluation_period}" readonly></td>
                                    <th>Date: </th>
                                    <td><input type="text" class="appraisal-date input" value="${data[0].appraisal_date}" readonly></td>
                                </tr>
                                <tr>
                                    <th>Supervisor: </th>
                                    <td><input type="text" class="supervisor input" value="${data[0].supervisor}" readonly></td>
                                </tr>
                            </table>
                            <div class="purpose">
                                <b>Purpose: </b> The purpose of conducting this Performance Appraisal is to: develop better communication between the employee and the supervisor,
                                improve the quality of work, increase productivity, and promote employee development.
                            </div>
                            <table class="job-resp col-xs-12">
                                <div><b>Job Responsibilities:</b></div>
                                <tr><td class="col-xs-1">1.</td> <td><input type="text" class="job-resp1 inp" value="${data[0].job_resp1 ? data[0].job_resp1 : ''}"></td></tr>
                                <tr><td class="col-xs-1">2.</td> <td><input type="text" class="job-resp2 inp" value="${data[0].job_resp2 ? data[0].job_resp2 : ''}"></td></tr>
                                <tr><td class="col-xs-1">3.</td> <td><input type="text" class="job-resp3 inp" value="${data[0].job_resp3 ? data[0].job_resp3 : ''}"></td></tr>
                                <tr><td class="col-xs-1">4.</td> <td><input type="text" class="job-resp4 inp" value="${data[0].job_resp4 ? data[0].job_resp4 : ''}"></td></tr>
                                <tr><td class="col-xs-1">5.</td> <td><input type="text" class="job-resp5 inp" value="${data[0].job_resp5 ? data[0].job_resp5 : ''}"></td></tr>
                            </table>
                            <table>
                                <tr>
                                    <th>Excellent (5):</th>
                                    <td>Employee ensured extremely effective performance. Surpassed expectations.</td>
                                </tr>
                                <tr>
                                    <th>Very Good (4):</th>
                                    <td>Employee ensured more than adequate and effective performance. Generally, exceeded expectations for successful job performance. Consistently demonstrated better than average level of performance. </td>
                                </tr>
                                <tr>
                                    <th>Good (3):</th>
                                    <td>Employee ensured adequate performance. Met criteria required for successful job performance. Some deficiencies existed in the areas assessed but none of major concern. </td>
                                </tr>
                                <tr>
                                    <th>Fair (2):</th>
                                    <td>At times, did not meet criteria for effective performance. A concern existed.</td>
                                </tr>
                                <tr>
                                    <th>Poor (1):</th>
                                    <td>Below criteria required for successful job performance. A problem existed. Demonstrated counter-productive behaviors that had negative outcomes or consequences. </td>
                                </tr>
                            </table>
                            <table class="performance-category table">
                                <tr>
                                    <th style="width:30%;">Performance Category</th>
                                    <th style="width:15%;">Rating</th>
                                    <th style="width:55%;">Comments and Examples</th>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <table class="table col-xs-12">
                                            <tr>
                                                <td class="col-xs-8"><b>Attendance:</b><br><br>Consider the number of absences and requests for personal time off.</td>
                                                <td><br><br>
                                                    <div class="slidecontainer">
                                                        <input type="range" min="1" max="5" value="${data[0].attendance_rating_1}" step="0.5" class="slider1">
                                                        <div class="val1"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>    
                                    <td><br>
                                        <textarea rows="6" cols="50" class="form-control attendance-memo">${data[0].attendance_memo ? data[0].attendance_memo : ''}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <table class="table col-xs-12">
                                            <tr>
                                                <td class="col-xs-8"><b>Punctuality:</b><br><br>Consider the arrival time and departure time lunch periods and breaks.</td>
                                                <td><br><br>
                                                    <div class="slidecontainer">
                                                        <input type="range" min="1" max="5" value="${data[0].punctuality_rating_1}" step="0.5" class="slider2">
                                                        <div class="val2"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Consider if employee begins to work promptly upon arrival.</td>
                                                <td>
                                                    <div class="slidecontainer">
                                                        <input type="range" min="1" max="5" value="${data[0].punctuality_rating_2}" step="0.5" class="slider3">
                                                        <div class="val3"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>    
                                    <td><br>
                                        <textarea rows="6" cols="50" class="form-control punctuality-memo">${data[0].punctuality_memo ? data[0].punctuality_memo : ''}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <table class="table col-xs-12">
                                            <tr>
                                                <td class="col-xs-8"><b>Productivity:</b><br><br>Consider how the employee uses available time:<br>
                                                Does the employee complete work quickly and efficiently?</td>
                                                <td><br><br>
                                                    <div class="slidecontainer">
                                                        <input type="range" min="1" max="5" value="${data[0].productivity_rating_1}" step="0.5" class="slider4">
                                                        <div class="val4"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Does the employee act without prompting to get assigned work done?</td>
                                                <td>
                                                    <div class="slidecontainer">
                                                        <input type="range" min="1" max="5" value="${data[0].productivity_rating_2}" step="0.5" class="slider5">
                                                        <div class="val5"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Does the employee look for "work" when assigned tasks are completed if there is available time?</td>
                                                <td>
                                                    <div class="slidecontainer">
                                                        <input type="range" min="1" max="5" value="${data[0].productivity_rating_3}" step="0.5" class="slider6">
                                                        <div class="val6"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Consider how well the employee handles digital distractions (personal phone, internet browsing).</td>
                                                <td>
                                                    <div class="slidecontainer">
                                                        <input type="range" min="1" max="5" value="${data[0].productivity_rating_4}" step="0.5" class="slider7">
                                                        <div class="val7"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>    
                                    <td><br>
                                        <textarea rows="6" cols="50" class="form-control productivity-memo">${data[0].productivity_memo ? data[0].productivity_memo : ''}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <table class="table col-xs-12">
                                            <tr>
                                                <td class="col-xs-8"><b>Quality work:</b><br><br>Consider if work is thorough, accurate and precise. Consider the extent to which the employee ensures the work is well done.</td>
                                                <td><br><br>
                                                    <div class="slidecontainer">
                                                        <input type="range" min="1" max="5" value="${data[0].qualitywork_rating_1}" step="0.5" class="slider8">
                                                        <div class="val8"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>    
                                    <td><br>
                                        <textarea rows="6" cols="50" class="form-control qualitywork-memo">${data[0].qualitywork_memo ? data[0].qualitywork_memo : ''}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <table class="table col-xs-12">
                                            <tr>
                                                <td class="col-xs-8"><b>Team player:</b><br><br>Consider the ability and willingness to cooperate and be helpful with other employees.</td>
                                                <td><br><br>
                                                    <div class="slidecontainer">
                                                        <input type="range" min="1" max="5" value="${data[0].teamplayer_rating_1}" step="0.5" class="slider9">
                                                        <div class="val9"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Consider how well the employee builds a good and beneficial rapport with fellow team members.</td>
                                                <td>
                                                    <div class="slidecontainer">
                                                        <input type="range" min="1" max="5" value="${data[0].teamplayer_rating_2}" step="0.5" class="slider10">
                                                        <div class="val10"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Consider how well the employee cooperates with employees from other branches.</td>
                                                <td>
                                                    <div class="slidecontainer">
                                                        <input type="range" min="1" max="5" value="${data[0].teamplayer_rating_3}" step="0.5" class="slider11">
                                                        <div class="val11"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Consider if the employee values team success over individual success.</td>
                                                <td>
                                                    <div class="slidecontainer">
                                                        <input type="range" min="1" max="5" value="${data[0].teamplayer_rating_4}" step="0.5" class="slider12">
                                                        <div class="val12"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>    
                                    <td><br>
                                        <textarea rows="6" cols="50" class="form-control teamplayer-memo">${data[0].teamplayer_memo ? data[0].teamplayer_memo : ''}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <table class="table col-xs-12">
                                            <tr>
                                                <td class="col-xs-8"><b>Communication:</b><br><br>Consider how effectively the employee communicates with supervisor, co-workers, and customers.</td>
                                                <td><br><br>
                                                    <div class="slidecontainer">
                                                        <input type="range" min="1" max="5" value="${data[0].communication_rating_1}" step="0.5" class="slider13">
                                                        <div class="val13"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Consider how well the employee communicates with co-workers when dealing with a difficult situation. Ability to communicate in a non-blaming manner.</td>
                                                <td>
                                                    <div class="slidecontainer">
                                                        <input type="range" min="1" max="5" value="${data[0].communication_rating_2}" step="0.5" class="slider14">
                                                        <div class="val14"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>    
                                    <td><br>
                                        <textarea rows="6" cols="50" class="form-control communication-memo">${data[0].communication_memo ? data[0].communication_memo : ''}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <table class="table col-xs-12">
                                            <tr>
                                                <td class="col-xs-8"><b>People/Human Relations:</b><br><br>Consider the ability of the employee to call the attention to a co-worker's mistake in a way that makes co-worker willing to cooperate. Consider how well the employee offers constructive criticism.</td>
                                                <td><br><br>
                                                    <div class="slidecontainer">
                                                        <input type="range" min="1" max="5" value="${data[0].peoplerelations_rating_1}" step="0.5" class="slider15">
                                                        <div class="val15"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Consider how well the employee accepts criticism. Is the employee willing to make corrections?</td>
                                                <td>
                                                    <div class="slidecontainer">
                                                        <input type="range" min="1" max="5" value="${data[0].peoplerelations_rating_2}" step="0.5" class="slider16">
                                                        <div class="val16"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Consider the ability and willingness of the employee to ensure that customers' requests are fully satisfied. Follow up if neccessary.</td>
                                                <td>
                                                    <div class="slidecontainer">
                                                        <input type="range" min="1" max="5" value="${data[0].peoplerelations_rating_3}" step="0.5" class="slider17">
                                                        <div class="val17"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>    
                                    <td><br>
                                        <textarea rows="6" cols="50" class="form-control peoplerelations-memo">${data[0].peoplerelations_memo ? data[0].peoplerelations_memo : ''}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <table class="table col-xs-12">
                                            <tr>
                                                <td class="col-xs-8"><b>Ability to take Ownership:</b><br><br>Consider the ability of the employee to take ownership of assigned tasks and figure how to get things done. How well the employee accepts responsibility?</td>
                                                <td><br><br>
                                                    <div class="slidecontainer">
                                                        <input type="range" min="1" max="5" value="${data[0].ownership_rating_1}" step="0.5" class="slider18">
                                                        <div class="val18"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Consider the ability of the employee to recognize and admit mistakes and take action to correct it.</td>
                                                <td>
                                                    <div class="slidecontainer">
                                                        <input type="range" min="1" max="5" value="${data[0].ownership_rating_2}" step="0.5" class="slider19">
                                                        <div class="val19"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>    
                                    <td><br>
                                        <textarea rows="6" cols="50" class="form-control ownership-memo">${data[0].ownership_memo ? data[0].ownership_memo : ''}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <table class="table col-xs-12">
                                            <tr>
                                                <td class="col-xs-8"><b>Job Attitude:</b><br><br>Consider if employee sustains motivation to do the best job possible?</td>
                                                <td><br><br>
                                                    <div class="slidecontainer">
                                                        <input type="range" min="1" max="5" value="${data[0].jobattitude_rating_1}" step="0.5" class="slider20">
                                                        <div class="val20"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>    
                                    <td><br>
                                        <textarea rows="6" cols="50" class="form-control jobattitude-memo">${data[0].jobattitude_memo ? data[0].jobattitude_memo : ''}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <table class="table col-xs-12">
                                            <tr>
                                                <td class="col-xs-8"><b>Consistent Impovement:</b><br><br>Does employee take initiative to learn? Consider the desire of the employee to become better.</td>
                                                <td><br><br>
                                                    <div class="slidecontainer">
                                                        <input type="range" min="1" max="5" value="${data[0].improvement_rating_1}" step="0.5" class="slider21">
                                                        <div class="val21"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>    
                                    <td><br>
                                        <textarea rows="6" cols="50" class="form-control improvement-memo">${data[0].improvement_memo ? data[0].improvement_memo : ''}</textarea>
                                    </td>
                                </tr>         
                                <tr>
                                    <td colspan="2">
                                        <table class="table col-xs-12">
                                            <tr>
                                                <td class="col-xs-8"><b>Safety:</b><br><br>Consider how well employee follows safety practices to avoid accidents and damage to company property. Does employee reports damage to company proporty?</td>
                                                <td><br><br>
                                                    <div class="slidecontainer">
                                                        <input type="range" min="1" max="5" value="${data[0].safety_rating_1}" step="0.5" class="slider22">
                                                        <div class="val22"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>    
                                    <td><br>
                                        <textarea rows="6" cols="50" class="form-control safety-memo">${data[0].safety_memo ? data[0].safety_memo : ''}</textarea>
                                    </td>
                                </tr>
                                <tr class='isSup ${supClass}'><th colspan="12" class="text-center">Leadership</th></tr>
                                <tr class='isSup ${supClass}'>
                                    <td colspan="2">
                                        <table class="table col-xs-12">
                                            <tr>
                                                <td class="col-xs-8"><b>Organize:</b><br><br>Consider how well the employee organizes work in the department to ensure efficient operation.</td>
                                                <td><br><br>
                                                    <div class="slidecontainer">
                                                        <input type="range" min="1" max="5" value="${data[0].organize_rating_1}" step="0.5" class="slider23">
                                                        <div class="val23"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Consider how well the employee gives clear direction in assigning tasks to ensure understanding of purpose, expected results and the timing of the tasks.</td>
                                                <td>
                                                    <div class="slidecontainer">
                                                        <input type="range" min="1" max="5" value="${data[0].organize_rating_2}" step="0.5" class="slider24">
                                                        <div class="val24"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Consider how well employee ensures the adherence of company's policies and procedure by his direct reports.</td>
                                                <td>
                                                    <div class="slidecontainer">
                                                        <input type="range" min="1" max="5" value="${data[0].organize_rating_3}" step="0.5" class="slider25">
                                                        <div class="val25"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b>Work Ethics:</b><br><br>Consider how well the employee leads by example.</td>
                                                <td><br><br>
                                                    <div class="slidecontainer">
                                                        <input type="range" min="1" max="5" value="${data[0].workethics_rating_1}" step="0.5" class="slider26">
                                                        <div class="val26"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b>Communication:</b><br><br>Consider how well the employee delivers spoken and written communications. When and how to pass information?</td>
                                                <td><br><br>
                                                    <div class="slidecontainer">
                                                        <input type="range" min="1" max="5" value="${data[0].leadership_communication_rating_1}" step="0.5" class="slider27">
                                                        <div class="val27"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b>Personal Development:</b><br><br>Consider how well the employee demonstrates mature judgment in addressing unacceptable behavior or performance.</td>
                                                <td><br><br>
                                                    <div class="slidecontainer">
                                                        <input type="range" min="1" max="5" value="${data[0].personaldev_rating_1}" step="0.5" class="slider28">
                                                        <div class="val28"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Consider how well the employee provides honest feedback and recognition to his/her direct reports.</td>
                                                <td>
                                                    <div class="slidecontainer">
                                                        <input type="range" min="1" max="5" value="${data[0].personaldev_rating_2}" step="0.5" class="slider29">
                                                        <div class="val29"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>    
                                    <td><br>
                                        <textarea rows="6" cols="50" class="form-control leadership-memo">${data[0].leadership_memo ? data[0].leadership_memo : ''}</textarea>
                                    </td>
                                </tr>         
                                <tr>
                                    <td colspan="2">
                                        <table class="table col-xs-12">
                                            <tr>
                                                <td class="col-xs-8"><b>Overall Performance:</b></td>
                                                <td><br><br>
                                                    <div class="slidecontainer">
                                                        <input type="range" min="1" max="5" value="${data[0].overall_rating}" step="0.5" class="slider30">
                                                        <div class="val30"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>    
                                    <td><br>
                                        <textarea rows="6" cols="50" class="form-control overall-memo">${data[0].overall_memo ? data[0].overall_memo : ''}</textarea>
                                    </td>
                                </tr>
                            </table>
                            <div class="h3"><b>By signing below, the employee acknowledges discussion of this document.</b></div><br><br>
                            <table class="table">
                                <tr>
                                    <td>
                                        <b>Employee Name and Signature:</b> <br><br>
                                        <input type="text" class="employee-sig input" value="${data[0].employee_sig}"><br><br>
                                        <b>Date:</b> <br><br>
                                        <input type="date" class="employee-sig-date input" value="${data[0].employee_sig_date}">                  
                                    </td>
                                    <td><br>
                                        Comment: <br>
                                        <textarea rows="6" cols="50" class="form-control employee-memo">${data[0].employee_memo ? data[0].employee_memo : ''}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>Supervisor Name and Signature:</b> <br><br>
                                        <input type="text" class="supervisor-sig input" value="${data[0].supervisor_sig}"><br><br>
                                        <b>Date:</b> <br><br>
                                        <input type="date" class="supervisor-sig-date input" value="${data[0].supervisor_sig_date}">                  
                                    </td>
                                    <td><br>
                                        Comment: <br> 
                                        <textarea rows="6" cols="50" class="form-control supervisor-memo">${data[0].supervisor_memo ? data[0].supervisor_memo : ''}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>Manager Name and Signature:</b> <br><br>
                                        <input type="text" class="manager-sig others" readonly><br><br>
                                        <b>Date:</b> <br><br>
                                        <input type="text" class="manager-sig-date others" readonly>                  
                                    </td>
                                    <td><br>
                                        Comment: <br>
                                        <textarea rows="6" cols="50" class="form-control" readonly></textarea>
                                    </td>
                                </tr>
                            </table>
                            <div class="average-rating h4 text-right f-rating"></div>      
                            <div class="fw-bold fs-4 text-center">Average Rating: ${rating} ( ${wordRating} )</div>
                        </div>
                        <div class="text-end mt-3">
                            <button type="button" class="btn btn-success edit-app" id="${id}">Update</button>
                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Done</button>
                        </div>
                    `);
                    $('.edit-app').prop({appType: appType});

				},
				error		: function (request, status, error) {
					console.log (request.status, request.responseText);
				},
				async		: false
			});
        })
        .on('click', '.print-app', function(e) {
            var modalContent = $('.modal-body').html(); // get modal content

            var printWindow = window.open('', '', 'height=600,width=800');

            printWindow.document.write('<html><head><title>Print Appraisal</title>');

            // Optionally include styles
            $('link[rel=stylesheet]').each(function() {
                printWindow.document.write('<link rel="stylesheet" href="' + $(this).attr('href') + '" type="text/css" />');
            });

            printWindow.document.write('</head><body>');
            printWindow.document.write(modalContent);
            printWindow.document.write('</body></html>');

            printWindow.document.close();
            printWindow.focus();

            // Wait for content to load before printing
            setTimeout(function () {
                printWindow.print();
                printWindow.close();
            }, 500);
        })
        .on('click', '.edit-app', function(e) {
            let id = this.id;
            let appType = this.appType;

            if(appType = 'Supervisor') {
                for(let i = 1; i <= 30; i++) {
                    average_ratings += parseFloat($(`.slider${i}`).val());
                }
                $(".average-rating").html("<b><u>Average Total Rating: " + (average_ratings*5/150).toFixed(1) + "/5</u></b>");
            } else {
                for(let i = 1; i <= 22; i++) {
                    average_ratings += parseFloat($(`.slider${i}`).val());
                }
                $(".average-rating").html("<b><u>Average Total Rating: " + ((average_ratings + parseFloat($(`.slider30`).val())) * 5 / 115).toFixed(1) + "/5</u></b>")
            }
      
            $.ajax({
                url: "{{url ('/')}}/edit-appraisal-data",
                headers: {'X-CSRF-TOKEN':$ ('meta[name="csrf-token"]').attr ('content')},
                type: "POST",
                data: {
                    "id" : id,
                    "employee": $(".employee").val(),
                    "employee-number": $(".employee-number").val(),
                    "employment-date": $(".employment-date").val(),
                    "job-title": $(".job-title").val(),
                    "evaluation-period": $(".evaluation-period").val(),
                    "appraisal-date": $(".appraisal-date").val(),
                    "supervisor": $(".supervisor").val(),
                    "job-resp1": $(".job-resp1").val(),
                    "job-resp2": $(".job-resp2").val(),
                    "job-resp3": $(".job-resp3").val(),
                    "job-resp4": $(".job-resp4").val(),
                    "job-resp5": $(".job-resp5").val(),
                    "attendance-rating-1": parseFloat($(`.slider1`).val()),
                    "attendance-memo": $(".attendance-memo").val(),
                    "punctuality-rating-1": parseFloat($(`.slider2`).val()),
                    "punctuality-rating-2": parseFloat($(`.slider3`).val()),
                    "punctuality-memo": $(".punctuality-memo").val(),
                    "productivity-rating-1": parseFloat($(`.slider4`).val()),
                    "productivity-rating-2": parseFloat($(`.slider5`).val()),
                    "productivity-rating-3": parseFloat($(`.slider6`).val()),
                    "productivity-rating-4": parseFloat($(`.slider7`).val()),
                    "productivity-memo": $(".productivity-memo").val(),
                    "qualitywork-rating-1": parseFloat($(`.slider8`).val()),
                    "qualitywork-memo": $(".qualitywork-memo").val(),
                    "teamplayer-rating-1": parseFloat($(`.slider9`).val()),
                    "teamplayer-rating-2": parseFloat($(`.slider10`).val()),
                    "teamplayer-rating-3": parseFloat($(`.slider11`).val()),
                    "teamplayer-rating-4": parseFloat($(`.slider12`).val()),
                    "teamplayer-memo": $(".teamplayer-memo").val(),
                    "communication-rating-1": parseFloat($(`.slider13`).val()),
                    "communication-rating-2": parseFloat($(`.slider14`).val()),
                    "communication-memo": $(".communication-memo").val(),
                    "peoplerelations-rating-1": parseFloat($(`.slider15`).val()),
                    "peoplerelations-rating-2": parseFloat($(`.slider16`).val()),
                    "peoplerelations-rating-3": parseFloat($(`.slider17`).val()),
                    "peoplerelations-memo": $(".peoplerelations-memo").val(),
                    "ownership-rating-1": parseFloat($(`.slider18`).val()),
                    "ownership-rating-2": parseFloat($(`.slider19`).val()),
                    "ownership-memo": $(".ownership-memo").val(),
                    "jobattitude-rating-1": parseFloat($(`.slider20`).val()),
                    "jobattitude-memo": $(".jobattitude-memo").val(),
                    "improvement-rating-1": parseFloat($(`.slider21`).val()),
                    "improvement-memo": $(".improvement-memo").val(),
                    "safety-rating-1": parseFloat($(`.slider22`).val()),
                    "safety-memo": $(".safety-memo").val(),
                    "organize-rating-1": parseFloat($(`.slider23`).val()),
                    "organize-rating-2": parseFloat($(`.slider24`).val()),
                    "organize-rating-3": parseFloat($(`.slider25`).val()),
                    "workethics-rating-1": parseFloat($(`.slider26`).val()),
                    "leadership-communication-rating-1": parseFloat($(`.slider27`).val()),
                    "personaldev-rating-1": parseFloat($(`.slider28`).val()),
                    "personaldev-rating-2": parseFloat($(`.slider29`).val()),
                    "leadership-memo": $(".leadership-memo").val(),
                    "overall-rating": parseFloat($(`.slider30`).val()),
                    "overall-memo": $(".overall-memo").val(),
                    "employee-sig": $(".employee-sig").val(),
                    "employee-sig-date": $(".employee-sig-date").val(),
                    "employee-memo": $(".employee-memo").val(),
                    "supervisor-sig": $(".supervisor-sig").val(),
                    "supervisor-sig-date": $(".supervisor-sig-date").val(),
                    "supervisor-memo": $(".supervisor-memo").val(),
                    "average-rating": (average_ratings*5/150).toFixed(1)
                },
                dataType: "json",
                error(xhr,status,error) {
                        console.log("Edit appraisal error: ",xhr.responseText);
                    },
                success: function(data, status){
                    display_alert ('Edit Record', 'Appraisal was updated succesfully.', 1);
                    setTimeout("location.reload();", 1500);
                    // alert("Successfully added appraisal data to database.");
                }
            });
            average_ratings = 0;
        })
</script>
</html>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Direct Report Appraisal</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- CDN link for html2pdf -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>


    <style>
        .form-container {
            margin-left: 150px; /* 40px; */
            margin-right: 150px;
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
        .btn {
            background-color: #04AA6D;
            border: none;
            color: white;
            padding: 3px 20px;
            text-align: center;
            font-size: 30px;
            cursor: pointer;
            width: 30%;
        }
        .btn-container {
            text-align: center;
            margin-bottom: 30px;
        }
        .input, .others {
            width: 100%;
        }
        .slider-container {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="form-container myform">
        <div class="logo"><img src="{{ url('/') }}/westraclogo.jpeg" width="450px;"></div>
        <div class="title-block">
            <div class="title">Employee Performance Appraisal</div>
            <div class="type">(Direct Report)</div>
        </div>
        <table class="info col-xs-12">
            <tr>
                <th class="col-xs-2">Employee: </th>
                <td><input type="text" class="employee input col-xs-10" readonly></td>
                <th class="col-xs-2">Employment Date: </th>
                <td><input type="date" class="employment-date input col-xs-10" readonly></td>
            </tr>
            <tr>
                <th>Employee Number: </th>
                <td><input type="text" class="employee-number input" readonly></td>
                <th>Job Title: </th>
                <td><input type="text" class="job-title input" readonly></td>
            </tr>
            <tr>
                <th>Period of Evaluation: </th>
                <td><input type="text" class="evaluation-period input" readonly></td>
                <th>Date: </th>
                <td><input type="date" class="appraisal-date input" value="<?php echo date('Y-m-d') ?>"></td>
            </tr>
            <tr>
                <th>Supervisor: </th>
                <td><input type="text" class="supervisor input" readonly></td>
            </tr>
        </table>
        <div class="purpose">
            <b>Purpose: </b> The purpose of conducting this Performance Appraisal is to: develop better communication between the employee and the supervisor,
            improve the quality of work, increase productivity, and promote employee development.
        </div>
        <table class="job-resp col-xs-12">
            <div><b>Job Responsibilities:</b></div>
            <tr><td class="col-xs-1">1.</td> <td><input type="text" class="job-resp1 inp"></td></tr>
            <tr><td class="col-xs-1">2.</td> <td><input type="text" class="job-resp2 inp"></td></tr>
            <tr><td class="col-xs-1">3.</td> <td><input type="text" class="job-resp3 inp"></td></tr>
            <tr><td class="col-xs-1">4.</td> <td><input type="text" class="job-resp4 inp"></td></tr>
            <tr><td class="col-xs-1">5.</td> <td><input type="text" class="job-resp5 inp"></td></tr>
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
                                    <input type="range" min="1" max="5" value="3" step="0.5" class="slider1">
                                    <div class="val1"></div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>    
                <td><br>
                    <textarea rows="6" cols="50" class="form-control attendance-memo"></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <table class="table col-xs-12">
                        <tr>
                            <td class="col-xs-8"><b>Punctuality:</b><br><br>Consider the arrival time and departure time lunch periods and breaks.</td>
                            <td><br><br>
                                <div class="slidecontainer">
                                    <input type="range" min="1" max="5" value="3" step="0.5" class="slider2">
                                    <div class="val2"></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Consider if employee begins to work promptly upon arrival.</td>
                            <td>
                                <div class="slidecontainer">
                                    <input type="range" min="1" max="5" value="3" step="0.5" class="slider3">
                                    <div class="val3"></div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>    
                <td><br>
                    <textarea rows="6" cols="50" class="form-control punctuality-memo"></textarea>
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
                                    <input type="range" min="1" max="5" value="3" step="0.5" class="slider4">
                                    <div class="val4"></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Does the employee act without prompting to get assigned work done?</td>
                            <td>
                                <div class="slidecontainer">
                                    <input type="range" min="1" max="5" value="3" step="0.5" class="slider5">
                                    <div class="val5"></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Does the employee look for "work" when assigned tasks are completed if there is available time?</td>
                            <td>
                                <div class="slidecontainer">
                                    <input type="range" min="1" max="5" value="3" step="0.5" class="slider6">
                                    <div class="val6"></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Consider how well the employee handles digital distractions (personal phone, internet browsing).</td>
                            <td>
                                <div class="slidecontainer">
                                    <input type="range" min="1" max="5" value="3" step="0.5" class="slider7">
                                    <div class="val7"></div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>    
                <td><br>
                    <textarea rows="6" cols="50" class="form-control productivity-memo"></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <table class="table col-xs-12">
                        <tr>
                            <td class="col-xs-8"><b>Quality work:</b><br><br>Consider if work is thorough, accurate and precise. Consider the extent to which the employee ensures the work is well done.</td>
                            <td><br><br>
                                <div class="slidecontainer">
                                    <input type="range" min="1" max="5" value="3" step="0.5" class="slider8">
                                    <div class="val8"></div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>    
                <td><br>
                    <textarea rows="6" cols="50" class="form-control qualitywork-memo"></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <table class="table col-xs-12">
                        <tr>
                            <td class="col-xs-8"><b>Team player:</b><br><br>Consider the ability and willingness to cooperate and be helpful with other employees.</td>
                            <td><br><br>
                                <div class="slidecontainer">
                                    <input type="range" min="1" max="5" value="3" step="0.5" class="slider9">
                                    <div class="val9"></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Consider how well the employee builds a good and beneficial rapport with fellow team members.</td>
                            <td>
                                <div class="slidecontainer">
                                    <input type="range" min="1" max="5" value="3" step="0.5" class="slider10">
                                    <div class="val10"></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Consider how well the employee cooperates with employees from other branches.</td>
                            <td>
                                <div class="slidecontainer">
                                    <input type="range" min="1" max="5" value="3" step="0.5" class="slider11">
                                    <div class="val11"></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Consider if the employee values team success over individual success.</td>
                            <td>
                                <div class="slidecontainer">
                                    <input type="range" min="1" max="5" value="3" step="0.5" class="slider12">
                                    <div class="val12"></div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>    
                <td><br>
                    <textarea rows="6" cols="50" class="form-control teamplayer-memo"></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <table class="table col-xs-12">
                        <tr>
                            <td class="col-xs-8"><b>Communication:</b><br><br>Consider how effectively the employee communicates with supervisor, co-workers, and customers.</td>
                            <td><br><br>
                                <div class="slidecontainer">
                                    <input type="range" min="1" max="5" value="3" step="0.5" class="slider13">
                                    <div class="val13"></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Consider how well the employee communicates with co-workers when dealing with a difficult situation. Ability to communicate in a non-blaming manner.</td>
                            <td>
                                <div class="slidecontainer">
                                    <input type="range" min="1" max="5" value="3" step="0.5" class="slider14">
                                    <div class="val14"></div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>    
                <td><br>
                    <textarea rows="6" cols="50" class="form-control communication-memo"></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <table class="table col-xs-12">
                        <tr>
                            <td class="col-xs-8"><b>People/Human Relations:</b><br><br>Consider the ability of the employee to call the attention to a co-worker's mistake in a way that makes co-worker willing to cooperate. Consider how well the employee offers constructive criticism.</td>
                            <td><br><br>
                                <div class="slidecontainer">
                                    <input type="range" min="1" max="5" value="3" step="0.5" class="slider15">
                                    <div class="val15"></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Consider how well the employee accepts criticism. Is the employee willing to make corrections?</td>
                            <td>
                                <div class="slidecontainer">
                                    <input type="range" min="1" max="5" value="3" step="0.5" class="slider16">
                                    <div class="val16"></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Consider the ability and willingness of the employee to ensure that customers' requests are fully satisfied. Follow up if neccessary.</td>
                            <td>
                                <div class="slidecontainer">
                                    <input type="range" min="1" max="5" value="3" step="0.5" class="slider17">
                                    <div class="val17"></div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>    
                <td><br>
                    <textarea rows="6" cols="50" class="form-control peoplerelations-memo"></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <table class="table col-xs-12">
                        <tr>
                            <td class="col-xs-8"><b>Ability to take Ownership:</b><br><br>Consider the ability of the employee to take ownership of assigned tasks and figure how to get things done. How well the employee accepts responsibility?</td>
                            <td><br><br>
                                <div class="slidecontainer">
                                    <input type="range" min="1" max="5" value="3" step="0.5" class="slider18">
                                    <div class="val18"></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Consider the ability of the employee to recognize and admit mistakes and take action to correct it.</td>
                            <td>
                                <div class="slidecontainer">
                                    <input type="range" min="1" max="5" value="3" step="0.5" class="slider19">
                                    <div class="val19"></div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>    
                <td><br>
                    <textarea rows="6" cols="50" class="form-control ownership-memo"></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <table class="table col-xs-12">
                        <tr>
                            <td class="col-xs-8"><b>Job Attitude:</b><br><br>Consider if employee sustains motivation to do the best job possible?</td>
                            <td><br><br>
                                <div class="slidecontainer">
                                    <input type="range" min="1" max="5" value="3" step="0.5" class="slider20">
                                    <div class="val20"></div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>    
                <td><br>
                    <textarea rows="6" cols="50" class="form-control jobattitude-memo"></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <table class="table col-xs-12">
                        <tr>
                            <td class="col-xs-8"><b>Consistent Impovement:</b><br><br>Does employee take initiative to learn? Consider the desire of the employee to become better.</td>
                            <td><br><br>
                                <div class="slidecontainer">
                                    <input type="range" min="1" max="5" value="3" step="0.5" class="slider21">
                                    <div class="val21"></div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>    
                <td><br>
                    <textarea rows="6" cols="50" class="form-control improvement-memo"></textarea>
                </td>
            </tr>         
            <tr>
                <td colspan="2">
                    <table class="table col-xs-12">
                        <tr>
                            <td class="col-xs-8"><b>Safety:</b><br><br>Consider how well employee follows safety practices to avoid accidents and damage to company property. Does employee reports damage to company proporty?</td>
                            <td><br><br>
                                <div class="slidecontainer">
                                    <input type="range" min="1" max="5" value="3" step="0.5" class="slider22">
                                    <div class="val22"></div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>    
                <td><br>
                    <textarea rows="6" cols="50" class="form-control safety-memo"></textarea>
                </td>
            </tr>         
            <tr>
                <td colspan="2">
                    <table class="table col-xs-12">
                        <tr>
                            <td class="col-xs-8"><b>Overall Performance:</b></td>
                            <td><br><br>
                                <div class="slidecontainer">
                                    <input type="range" min="1" max="5" value="3" step="0.5" class="slider30">
                                    <div class="val30"></div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>    
                <td><br>
                    <textarea rows="6" cols="50" class="form-control overall-memo"></textarea>
                </td>
            </tr>
        </table>
        <div class="h3"><b>By signing below, the employee acknowledges discussion of this document.</b></div><br><br>
        <table class="table">
            <tr>
                <td>
                    <b>Employee Name and Signature:</b> <br><br>
                    <input type="text" class="employee-sig input"><br><br>
                    <b>Date:</b> <br><br>
                    <input type="date" class="employee-sig-date input" value="<?php echo date('Y-m-d') ?>">                  
                </td>
                <td><br>
                    Comment: <br>
                    <textarea rows="6" cols="50" class="form-control employee-memo"></textarea>
                </td>
            </tr>
            <tr>
                <td>
                    <b>Supervisor Name and Signature:</b> <br><br>
                    <input type="text" class="supervisor-sig input"><br><br>
                    <b>Date:</b> <br><br>
                    <input type="date" class="supervisor-sig-date input" value="<?php echo date('Y-m-d') ?>">                  
                </td>
                <td><br>
                    Comment: <br> 
                    <textarea rows="6" cols="50" class="form-control supervisor-memo"></textarea>
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
        <div class="btn-container"><button type="submit" class="submit btn" disabled>Submit</button></div>
    </div>

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
    // Utility to parse URL parameters
    function getUrlParams() {
        const params = {};
        const queryString = window.location.search.slice(1);
        const pairs = queryString.split("&");

        for (const pair of pairs) {
            if (!pair) continue;
            const [key, value] = pair.split("=");
            params[decodeURIComponent(key)] = decodeURIComponent(value || '');
        }

        return params;
    }
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
    function downloadPDF(invoiceNo){
        var elementHTML = document.querySelector(".myform");

        html2pdf(elementHTML, {
            margin:       0.3,
            filename:     invoiceNo + '.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { dpi: 192, letterRendering: true },
            jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
        });
    }

    let average_ratings = 0;

    var element = document.querySelector(".myform");

    $(document)
        .ready(function(e) {
            // allows the stars to display based on input and also updates on change
            for(let i = 1; i <= 30; i++) {
            $(`.val${i}`).html(`<img src="{{ url('/') }}/ratings_images/star-${$(`.slider${i}`).val()}.png" class="star">`);

                $(`.slider${i}`).on("change", function() {
                    $(`.val${i}`).html(`<img src="{{ url('/') }}/ratings_images/star-${$(`.slider${i}`).val()}.png" class="star">`);
                }) 
            }

            // Check inputs on page load
            checkInputs();

            const params = getUrlParams();

            // Check and fill fields by class name
            if (params.employee) { $('.employee').val(params.employee); }

            if (params.employeeNumber) { $('.employee-number').val(params.employeeNumber); }

            if (params.period) { $('.evaluation-period').val(params.period); }

            if (params.supervisor) { $('.supervisor').val(params.supervisor); }

            if (params.employmentDate) { $('.employment-date').val(params.employmentDate); }

            if (params.jobTitle) { $('.job-title').val(params.jobTitle); }

        })
        .on('change', '.myform .input', function(e) {
            checkInputs();
        })
        .on('click', '.submit', function(e) {
            for(let i = 1; i <= 22; i++) {
                average_ratings += parseFloat($(`.slider${i}`).val());
            }
            $(".average-rating").html("<b><u>Average Total Rating: " + ((average_ratings + parseFloat($(`.slider30`).val())) * 5 / 115).toFixed(1) + "/5</u></b>")
        
            // downloadPDF($(".employee").val() + " Appraisal");

            // sends the pdf base64 string to the controller to attach with email       
            // html2pdf().from(element).set({
            //             margin:       0.3,
            //             image:        { type: 'jpeg', quality: 0.98 },
            //             html2canvas:  { dpi: 192, letterRendering: true },
            //             jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
            //         }).toPdf().output('datauristring').then(function (pdfAsString) {
            //             // The PDF has been converted to a Data URI string and passed to this function.
            //             // Use pdfAsString however you like (send as email, etc)! For instance:
            //             // console.log(pdfAsString); 
            //             $.ajax({
            //                 url: "{{ url('/') }}/send-appraisal-email",
            //                 headers: {
            //                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //                 },
            //                 type: "POST",
            //                 data: {
            //                     "employee": $(".employee").val(),
            //                     "supervisor": $(".supervisor").val(),
            //                     "myform": pdfAsString
            //                 },
            //                 dataType: "json",
            //                 error: function(xhr, status, error) {
            //                     console.error('Error sending appraisal email: ', error);
            //                 },
            //                 success: function(data, status) {
            //                     console.log("Successfully sent appraisal email.");
            //                     alert("Appraisal has been sent!");
            //                     // window.location.replace("http://hrm.westrac.lan/employee/myprofile");
            //                 }
            //             }); 
            //     });

            // enters the data in the database
            $.ajax({
                url: "{{url ('/')}}/enter-appraisal-data",
                headers: {'X-CSRF-TOKEN':$ ('meta[name="csrf-token"]').attr ('content')},
                type: "POST",
                data: {
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
                    "organize-rating-1": null,
                    "organize-rating-2": null,
                    "organize-rating-3": null,
                    "workethics-rating-1": null,
                    "leadership-communication-rating-1": null,
                    "personaldev-rating-1": null,
                    "personaldev-rating-2": null,
                    "leadership-memo": null,
                    "overall-rating": parseFloat($(`.slider30`).val()),
                    "overall-memo": $(".overall-memo").val(),
                    "employee-sig": $(".employee-sig").val(),
                    "employee-sig-date": $(".employee-sig-date").val(),
                    "employee-memo": $(".employee-memo").val(),
                    "supervisor-sig": $(".supervisor-sig").val(),
                    "supervisor-sig-date": $(".supervisor-sig-date").val(),
                    "supervisor-memo": $(".supervisor-memo").val(),
                    "average-rating": ((average_ratings + parseFloat($(`.slider30`).val())) * 5 / 115).toFixed(1)
                },
                dataType: "json",
                error(xhr,status,error) {
                        console.log("Enter appraisal error: ",xhr.responseText);
                    },
                success: function(data, status){
                    display_alert ('Add Record', 'Appraisal was succesfully done.', 1);
                    setTimeout("location.reload();", 1500);
                    // alert("Successfully added appraisal data to database.");
                }
            });
            average_ratings = 0;
        })
</script>
</html>
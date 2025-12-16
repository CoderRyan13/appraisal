<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use DB;

class AppraisalCtrl extends Controller
{
    public function enterAppraisalData(Request $request) {   
        $fields = [
            'employee'                              => $request -> input("employee"),
            'employee_number'                       => $request -> input("employee-number"),
            'employment_date'                       => $request -> input("employment-date"),
            'job_title'                             => $request -> input("job-title"),
            'evaluation_period'                     => $request -> input("evaluation-period"),
            'appraisal_date'                        => $request -> input("appraisal-date"),
            'supervisor'                            => $request -> input("supervisor"),
            'job_resp1'                             => $request -> input("job-resp1"),
            'job_resp2'                             => $request -> input("job-resp2"),
            'job_resp3'                             => $request -> input("job-resp3"),
            'job_resp4'                             => $request -> input("job-resp4"),
            'job_resp5'                             => $request -> input("job-resp5"),
            'attendance_rating_1'                   => $request -> input("attendance-rating-1"),
            'attendance_memo'                       => $request -> input("attendance-memo"),
            'punctuality_rating_1'                  => $request -> input("punctuality-rating-1"),
            'punctuality_rating_2'                  => $request -> input("punctuality-rating-2"),
            'punctuality_memo'                      => $request -> input("punctuality-memo"),
            'productivity_rating_1'                 => $request -> input("productivity-rating-1"),
            'productivity_rating_2'                 => $request -> input("productivity-rating-2"),
            'productivity_rating_3'                 => $request -> input("productivity-rating-3"),
            'productivity_rating_4'                 => $request -> input("productivity-rating-4"),
            'productivity_memo'                     => $request -> input("productivity-memo"),
            'qualitywork_rating_1'                  => $request -> input("qualitywork-rating-1"),
            'qualitywork_memo'                      => $request -> input("qualitywork-memo"),
            'teamplayer_rating_1'                   => $request -> input("teamplayer-rating-1"),
            'teamplayer_rating_2'                   => $request -> input("teamplayer-rating-2"),
            'teamplayer_rating_3'                   => $request -> input("teamplayer-rating-3"),
            'teamplayer_rating_4'                   => $request -> input("teamplayer-rating-4"),
            'teamplayer_memo'                       => $request -> input("teamplayer-memo"),
            'communication_rating_1'                => $request -> input("communication-rating-1"),
            'communication_rating_2'                => $request -> input("communication-rating-2"),
            'communication_memo'                    => $request -> input("communication-memo"),
            'peoplerelations_rating_1'              => $request -> input("peoplerelations-rating-1"),
            'peoplerelations_rating_2'              => $request -> input("peoplerelations-rating-2"),
            'peoplerelations_rating_3'              => $request -> input("peoplerelations-rating-3"),
            'peoplerelations_memo'                  => $request -> input("peoplerelations-memo"),
            'ownership_rating_1'                    => $request -> input("ownership-rating-1"),
            'ownership_rating_2'                    => $request -> input("ownership-rating-2"),
            'ownership_memo'                        => $request -> input("ownership-memo"),
            'jobattitude_rating_1'                  => $request -> input("jobattitude-rating-1"),
            'jobattitude_memo'                      => $request -> input("jobattitude-memo"),
            'improvement_rating_1'                  => $request -> input("improvement-rating-1"),
            'improvement_memo'                      => $request -> input("improvement-memo"),
            'safety_rating_1'                       => $request -> input("safety-rating-1"),
            'safety_memo'                           => $request -> input("safety-memo"),
            'organize_rating_1'                     => $request -> input("organize-rating-1"),
            'organize_rating_2'                     => $request -> input("organize-rating-2"),
            'organize_rating_3'                     => $request -> input("organize-rating-3"),
            'workethics_rating_1'                   => $request -> input("workethics-rating-1"),
            'leadership_communication_rating_1'     => $request -> input("leadership-communication-rating-1"),
            'personaldev_rating_1'                  => $request -> input("personaldev-rating-1"),
            'personaldev_rating_2'                  => $request -> input("personaldev-rating-2"),
            'leadership_memo'                       => $request -> input("leadership-memo"),
            'overall_rating'                        => $request -> input("overall-rating"),
            'overall_memo'                          => $request -> input("overall-memo"),
            'employee_sig'                          => $request -> input("employee-sig"),
            'employee_sig_date'                     => $request -> input("employee-sig-date"),
            'employee_memo'                         => $request -> input("employee-memo"),
            'supervisor_sig'                        => $request -> input("supervisor-sig"),
            'supervisor_sig_date'                   => $request -> input("supervisor-sig-date"),
            'supervisor_memo'                       => $request -> input("supervisor-memo"),
            'average_rating'                        => $request -> input("average-rating"),
        ];
        
        if(DB::table('public.appraisal')->insert($fields)) {
            return json_encode('y');
        } else { return json_encode('n'); };
    }

    public function editAppraisalData(Request $request) {   
        $id = $request -> input("id");
        $fields = [
            'employee'                              => $request -> input("employee"),
            'employee_number'                       => $request -> input("employee-number"),
            'employment_date'                       => $request -> input("employment-date"),
            'job_title'                             => $request -> input("job-title"),
            'evaluation_period'                     => $request -> input("evaluation-period"),
            'appraisal_date'                        => $request -> input("appraisal-date"),
            'supervisor'                            => $request -> input("supervisor"),
            'job_resp1'                             => $request -> input("job-resp1"),
            'job_resp2'                             => $request -> input("job-resp2"),
            'job_resp3'                             => $request -> input("job-resp3"),
            'job_resp4'                             => $request -> input("job-resp4"),
            'job_resp5'                             => $request -> input("job-resp5"),
            'attendance_rating_1'                   => $request -> input("attendance-rating-1"),
            'attendance_memo'                       => $request -> input("attendance-memo"),
            'punctuality_rating_1'                  => $request -> input("punctuality-rating-1"),
            'punctuality_rating_2'                  => $request -> input("punctuality-rating-2"),
            'punctuality_memo'                      => $request -> input("punctuality-memo"),
            'productivity_rating_1'                 => $request -> input("productivity-rating-1"),
            'productivity_rating_2'                 => $request -> input("productivity-rating-2"),
            'productivity_rating_3'                 => $request -> input("productivity-rating-3"),
            'productivity_rating_4'                 => $request -> input("productivity-rating-4"),
            'productivity_memo'                     => $request -> input("productivity-memo"),
            'qualitywork_rating_1'                  => $request -> input("qualitywork-rating-1"),
            'qualitywork_memo'                      => $request -> input("qualitywork-memo"),
            'teamplayer_rating_1'                   => $request -> input("teamplayer-rating-1"),
            'teamplayer_rating_2'                   => $request -> input("teamplayer-rating-2"),
            'teamplayer_rating_3'                   => $request -> input("teamplayer-rating-3"),
            'teamplayer_rating_4'                   => $request -> input("teamplayer-rating-4"),
            'teamplayer_memo'                       => $request -> input("teamplayer-memo"),
            'communication_rating_1'                => $request -> input("communication-rating-1"),
            'communication_rating_2'                => $request -> input("communication-rating-2"),
            'communication_memo'                    => $request -> input("communication-memo"),
            'peoplerelations_rating_1'              => $request -> input("peoplerelations-rating-1"),
            'peoplerelations_rating_2'              => $request -> input("peoplerelations-rating-2"),
            'peoplerelations_rating_3'              => $request -> input("peoplerelations-rating-3"),
            'peoplerelations_memo'                  => $request -> input("peoplerelations-memo"),
            'ownership_rating_1'                    => $request -> input("ownership-rating-1"),
            'ownership_rating_2'                    => $request -> input("ownership-rating-2"),
            'ownership_memo'                        => $request -> input("ownership-memo"),
            'jobattitude_rating_1'                  => $request -> input("jobattitude-rating-1"),
            'jobattitude_memo'                      => $request -> input("jobattitude-memo"),
            'improvement_rating_1'                  => $request -> input("improvement-rating-1"),
            'improvement_memo'                      => $request -> input("improvement-memo"),
            'safety_rating_1'                       => $request -> input("safety-rating-1"),
            'safety_memo'                           => $request -> input("safety-memo"),
            'organize_rating_1'                     => $request -> input("organize-rating-1"),
            'organize_rating_2'                     => $request -> input("organize-rating-2"),
            'organize_rating_3'                     => $request -> input("organize-rating-3"),
            'workethics_rating_1'                   => $request -> input("workethics-rating-1"),
            'leadership_communication_rating_1'     => $request -> input("leadership-communication-rating-1"),
            'personaldev_rating_1'                  => $request -> input("personaldev-rating-1"),
            'personaldev_rating_2'                  => $request -> input("personaldev-rating-2"),
            'leadership_memo'                       => $request -> input("leadership-memo"),
            'overall_rating'                        => $request -> input("overall-rating"),
            'overall_memo'                          => $request -> input("overall-memo"),
            'employee_sig'                          => $request -> input("employee-sig"),
            'employee_sig_date'                     => $request -> input("employee-sig-date"),
            'employee_memo'                         => $request -> input("employee-memo"),
            'supervisor_sig'                        => $request -> input("supervisor-sig"),
            'supervisor_sig_date'                   => $request -> input("supervisor-sig-date"),
            'supervisor_memo'                       => $request -> input("supervisor-memo"),
            'average_rating'                        => $request -> input("average-rating"),
        ];
        
        if(DB::table('public.appraisal')->where('id', $id)->update($fields)) {
            return json_encode('y');
        } else { return json_encode('n'); };
    }

    public function sendAppraisalEmail(Request $request) {      
        $employee = $request -> input("employee");
        $supervisor = $request -> input("supervisor");
        $appraisalData = $request->input("myform");

        $data = ['name' => 'Mr. Danny Ku', 'employee' => $employee, 'supervisor' => $supervisor];

        # Decode the Base64 string, making sure that it contains only valid characters
        $appPDF = str_replace('data:application/pdf;base64,', '', $appraisalData);
        $appraisalPDF = base64_decode($appPDF, true);

        # Write the PDF contents to a local file
        file_put_contents(public_path('files/appraisal.pdf'), $appraisalPDF);

        Mail::send('mail.email', $data, function($message) use($employee) {
            $message->to('ryanarmstrong@westracbelize.com', 'Director')->subject("{$employee}'s Appraisal");
            $message->attach(public_path('files/appraisal.pdf'));
            // $message->attachData(file_put_contents('appraisal.pdf', $appraisalData), 'Appraisal.pdf', ['mime' => 'application/pdf']);
            $message->from('credit@westracbelize.com', 'Westrac Ltd IT Department');
        });

        // echo '<script>alert("Welcome to Geeks for Geeks")</script>';

        return true;
    }

    public function getAllAppraisalData(Request $request) {
        $appData = DB::select("SELECT e.department, a.* FROM public.appraisal a JOIN public.employees e ON a.employee = e.employee ORDER BY id DESC");
        return json_encode($appData);
    }

    public function getAppraisalData(Request $request) {
        $arg = [
            'id' => trim($request->id)
        ];

        $appData = DB::select("SELECT * FROM public.appraisal WHERE id = :id ORDER BY id ASC", $arg);
        return json_encode($appData);
    }

    public function getAllEmployeeData(Request $request) {
        $appData = DB::select("
            SELECT * 
            FROM public.employees 
            WHERE is_active = true
            AND (
                (
                EXTRACT(MONTH FROM employment_date) = EXTRACT(MONTH FROM CURRENT_DATE)
                AND EXTRACT(YEAR FROM employment_date) < EXTRACT(YEAR FROM CURRENT_DATE)
                )
                OR (
                EXTRACT(MONTH FROM employment_date) = EXTRACT(MONTH FROM CURRENT_DATE - INTERVAL '3 months')
                AND EXTRACT(YEAR FROM employment_date) = EXTRACT(YEAR FROM CURRENT_DATE - INTERVAL '3 months')
                )
            )
            ORDER BY id ASC;
        ");
        return json_encode($appData);
    }

    public function getEmployeeData(Request $request) {
        $arg = [
            'id' => trim($request->id)
        ];

        $appData = DB::select("SELECT * FROM public.employees WHERE id = :id AND is_active = true ORDER BY id ASC", $arg);
        return json_encode($appData);
    }

    public function getSupervisorData(Request $request) {
        $arg = [
            'sup' => trim($request->sup)
        ];

        $appData = DB::select("
            SELECT e.department, a.*
            FROM public.appraisal a
            JOIN public.employees e ON a.employee = e.employee
            WHERE  
                (
                    (
                        (SELECT is_manager FROM public.employees WHERE employee = :sup LIMIT 1) = false 
                        AND e.supervisor = :sup
                    )
                    OR
                    (
                        (SELECT is_manager FROM public.employees WHERE employee = :sup LIMIT 1) = true 
                        AND e.department = (
                            SELECT department
                            FROM public.employees 
                            WHERE employee = :sup
                            LIMIT 1
                        )
                    )
                )
            ORDER BY a.id DESC
        ", $arg);
        return json_encode($appData);
    }

    public function sendAppEmail(Request $request) {     
        $link = $request -> input("link");
        $employee = $request -> input("employee");
        $supervisor = $request -> input("supervisor");
        $sup_email = $request -> input("sup_email");

        $data = ['link' => $link, 'employee' => $employee, 'supervisor' => $supervisor];

        Mail::send('mail.email', $data, function($message) use($employee, $sup_email) {
            $message->to('ryanarmstrong@westracbelize.com', 'Supervisor')->subject("{$employee}'s Appraisal Due");
            $message->from('ryanarmstrong@westracbelize.com', 'Westrac Ltd HR Department');
        });

        return json_encode('y');
    }

    public function addEmployee(Request $request) {
        $fields = [
            'employee'                 => $request -> input("employee"),
            'employee_number'          => $request -> input("employee-number"),
            'supervisor'               => $request -> input("supervisor"),
            'employment_date'          => $request -> input("employment-date"),
            'job_title'                => $request -> input("job-title"),
            'department'               => $request -> input("department"),
            'supervisor_email'         => $request -> input("supervisor-email"),
            'is_sup'                   => $request -> input("is-sup"),
            'is_manager'               => $request -> input("is-manager"),
        ];
        
        if(DB::table('public.employees')->insert($fields)) {
            return json_encode('y');
        } else { return json_encode('n'); };
    }

    public function editEmployee(Request $request) {
        $id = $request -> input("id");
        $fields = [
            'employee'                 => $request -> input("employee"),
            'employee_number'          => $request -> input("employee-number"),
            'supervisor'               => $request -> input("supervisor"),
            'employment_date'          => $request -> input("employment-date"),
            'job_title'                => $request -> input("job-title"),
            'department'               => $request -> input("department"),
            'supervisor_email'         => $request -> input("supervisor-email"),
            'is_sup'                   => $request -> input("is-sup"),
            'is_manager'               => $request -> input("is-manager"),
            'is_active'                => $request -> input("is-active"),
        ];
        
        if(DB::table('public.employees')->where('id', $id)->update($fields)) {
            return json_encode('y');
        } else { return json_encode('n'); };
    }

    public function getAllEmployees(Request $request) {
        $appData = DB::select("SELECT * FROM public.employees WHERE is_active = true ORDER BY employee ASC");
        return json_encode($appData);
    }
}

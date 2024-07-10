@extends('hrms.layouts.base')

<style>
    .panel-heading {
        margin-top: -30px;
    }
    #printBtn {
        float: right;
        margin-bottom: 10px;
    }
    .cursor-pointer {
        cursor: pointer;
    }
    h3 {
        color: black !important;
    }
    h5 {
        font-weight: bold !important;
    }
    table tbody tr td {
        padding: 10px;
    }
    table thead {
        background: yellow;
        border: 1px solid black;
    }
    .select-primary {
        height: 30px;
        font-size: 12px;
        cursor: pointer;
    }
    #marital_status, #insurance, #ssb, #ferry, select {
        -webkit-appearance: auto !important;
    }
    #alert-message {
        float: right;
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999 !important;
    }
</style>

@section('content')
    <div class="content">
        <section id="content" class="table-layout animated fadeIn">
            <div class="chute-affix">
                <!-- -------------- Emp Print Form -------------- -->
                
                <!--{!! Form::open(['url' => route('print-employee-cv', ['id' => $emp->id]), 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) !!}-->
                <!--    <button type="submit" class="btn btn-success" id="printBtn"><i class="fas fa-print"></i> Print CV</button>-->
                <!--{!! Form::close() !!}-->
                
                {!! Form::open(['url' => route('edit-employee-cv', ['id' => $emp->id]), 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) !!}
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-success">
                                <div class="panel">
                                    @if ($message = Session::get('success'))
                                        <div id="alert-message" class="alert alert-success alert-block">
                                            <button type="button" class="close" onclick="closeAlert()" style="color: black;">&ensp; &times;</button>
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @elseif ($message = Session::get('error'))
                                        <div id="alert-message" class="alert alert-danger alert-block">
                                            <button type="button" class="close" onclick="closeAlert()" style="color: black;">&ensp; &times;</button>
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @endif
                                    <script>
                                        function closeAlert() {
                                            var alertElement = document.getElementById('alert-message');
                                            if (alertElement) {
                                                alertElement.style.display = 'none';
                                            }
                                        }
                                    </script>

                                    <div class="panel-heading">
                                        <h1 class="text-center" style="color:black">Q-First Group of Companies</h1>
                                        <h3 class="text-center">Employee Resume</h3>
                                    </div>
                                    <div class="row">
                                        <!-- Personal Info -->
                                        <table border="1" class="table">
                                            <thead>
                                                <tr class="text-center">
                                                    <td colspan="5"><h5>Personal Information</h5></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td width="20%">Name</td>
                                                    <td width="20%"><input type="text" name="name" value="@if($emp->name){{$emp->name}}@endif" class="form-control" placeholder="Enter Name..."></td>
                                                    <td width="20%">Employee ID No:</td>
                                                    <td width="20%"><input type="text" name="employee_id" value="{{$emp->employee_id}}" class="form-control" placeholder="Employee ID No..."></td>
                                                    <td rowspan="9" width="20%" class="text-center">
                                                        <img src="@if($emp->cv_photo) {{ URL::asset($emp->cv_photo) }} @else {{ URL::asset('public/userimages/user.png') }} @endif" width="150px" height="150px" id="previewImage">
                                                        <input type="file" class="form-control cursor-pointer" name="cv_photo" value="@if($emp->cv_photo){{ $emp->cv_photo }}@endif" id="cv_photo" onchange="previewFile()" accept="image/*")>
                                                        @if($emp->cv_photo)
                                                            <p class="text-primary">{{ $emp->cv_photo }}</p>
                                                            <button type="button" class="btn-sm btn-danger" id="removePhotoBtn">Remove Photo</button>
                                                        @endif
                                                        <input type="hidden" name="remove_photo" id="remove_photo" value="false">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>NRC</td>
                                                    <td><input type="text" name="nrc_passport" value="@if($emp->nrc_passport){{ $emp->nrc_passport }}@endif" class="form-control" placeholder="Enter NRC..."></td>
                                                    <td>Manpower Req ID:</td>
                                                    <td><input type="text" name="manpower_request_id" value="{{ $emp->manpower_request_id }}" class="form-control" placeholder="Manpower Req ID..."></td>
                                                </tr>
                                                <tr>
                                                    <td>Date of Birth</td>
                                                    <td><input type="date" name="date_of_birth" value="{{ \Carbon\Carbon::parse($emp->date_of_birth)->format('Y-m-d') }}" class="form-control"></td>
                                                    <td>Position</td>
                                                    <td><input type="text" name="position" value="@if($emp->position){{ $emp->position }}@endif" class="form-control" placeholder="Enter Position..."></td>
                                                </tr>
                                                <tr>
                                                    <td>Father's Name</td>
                                                    <td><input type="text" name="father_name" value="@if($emp->father_name){{ $emp->father_name }}@endif" class="form-control" placeholder="Enter Father's Name..."></td>
                                                    <td>Department</td>
                                                    <td><input type="text" name="department" value="@if($emp->department){{ $emp->department }}@endif" class="form-control" placeholder="Enter Department..."></td>
                                                </tr>
                                                <tr>
                                                    <td>Mother's Name</td>
                                                    <td><input type="text" name="mother_name" value="@if($emp->mother_name){{ $emp->mother_name }}@endif" class="form-control" placeholder="Enter Mother's Name"></td>
                                                    <td>Company</td>
                                                    <td><input type="text" name="company" value="@if($emp->company){{ $emp->company }}@endif" class="form-control" placeholder="Enter Company..."></td>
                                                </tr>
                                                <tr>
                                                    <td>Marital Status</td>
                                                    <td>
                                                        <select class="select-primary form-control" name="marital_status" id="marital_status">
                                                            <option value="">Select One</option>
                                                            <option value="Single" @if($emp->marital_status == 'Single') selected @endif>Single</option>
                                                            <option value="Married" @if($emp->marital_status == 'Married') selected @endif>Married</option>
                                                        </select>
                                                    </td>
                                                    <td>Salary Benefit</td>
                                                    <td><input type="text" name="salary_benefit" value="@if($emp->benefit){{ $emp->benefit }}@endif" class="form-control" placeholder="Enter Salary Benefit..."></td>
                                                </tr>
                                                <tr>
                                                    <td>Blood Type</td>
                                                    <td><input type="text" name="blood_type" value="@if($emp->blood_type){{ $emp->blood_type }}@endif" class="form-control" placeholder="Enter Blood Type..."></td>
                                                    <td>Insurance</td>
                                                    <td>
                                                        <select class="form-control select-primary" name="insurance" id="insurance">
                                                            <option value="">Select One</option>
                                                            <option value="Yes" @if($emp->insurance == 'Yes') selected @endif>Yes</option>
                                                            <option value="No" @if($emp->insurance == 'No') selected @endif>No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Height & Weight</td>
                                                    <td><input type="text" name="height_weight" value="@if($emp->height_weight){{ $emp->height_weight }}@endif" class="form-control" placeholder="Enter Height & Weight"></td>
                                                    <td>SSB</td>
                                                    <td>
                                                        <select class="form-control select-primary" name="ssb" id="ssb">
                                                            <option value="">Select One</option>
                                                            <option value="Yes" @if($emp->ssb == 'Yes') selected @endif>Yes</option>
                                                            <option value="No" @if($emp->ssb == 'No') selected @endif>No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Phone Number</td>
                                                    <td><input type="text" name="phone" value="@if($emp->phone){{ $emp->phone }}@endif" class="form-control" placeholder="Enter Phone Number..."></td>
                                                    <td>Ferry</td>
                                                    <td>
                                                        <select class="form-control select-primary" name="ferry" id="ferry">
                                                            <option value="">Select One</option>
                                                            <option value="Yes" @if($emp->ferry == 'Yes') selected @endif>Yes</option>
                                                            <option value="No" @if($emp->ferry == 'No') selected @endif>No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        Address (current)
                                                        <input type="text" name="current_address" value="@if($emp->residential_address){{ $emp->residential_address }}@endif" class="form-control" placeholder="Enter Current Address...">
                                                    </td>
                                                    <td colspan="3">    
                                                        Address (permanent)
                                                        <input type="text" name="permanent_address" value="@if($emp->principle_address){{ $emp->principle_address }}@endif" class="form-control" placeholder="Enter Permanent Address...">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        
                                        <!-- Personal Education -->
                                        <table border="1" class="table" id="eduTable">
                                            <thead>
                                                <tr class="text-center">
                                                    <td colspan="6" style="border: 1px;">
                                                        <h5>Personal Education Background</h5>
                                                    </td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td width="15%">School</td>
                                                    <td width="13%">Duration</td>
                                                    <td width="15%">Pass/Cont</td>
                                                    <td width="25%">Degree/Certificate</td>
                                                    <td width="30%">Remark</td>
                                                    <td width="2%">Action</td>
                                                </tr>
                                                @if(!empty($eduSchools))
                                                    @foreach($eduSchools as $index => $school)
                                                        <tr>
                                                            <td><input type="text" name="edu_school[]" class="form-control" value="{{ $school }}" placeholder="Enter School..."></td>
                                                            <td><input type="text" name="edu_duration[]" class="form-control" value="{{ $eduDurations[$index] ?? '' }}" placeholder="Enter Duration..."></td>
                                                            <td><input type="text" name="edu_pass_cont[]" class="form-control" value="{{ $eduPassConts[$index] ?? '' }}"></td>
                                                            <td><input type="text" name="edu_degree[]" class="form-control" value="{{ $eduDegrees[$index] ?? '' }}" placeholder="Enter Degree/Certificate..."></td>
                                                            <td><input type="text" name="edu_remark[]" class="form-control" value="{{ $eduRemarks[$index] ?? '' }}" placeholder="Enter Remark..."></td>
                                                            @if($index === 0)
                                                                <td><button type="button" class="btn btn-primary" id="addEduBtn"><i class="fas fa-plus"></i></button></td>
                                                            @else
                                                                <td><button type="button" class="btn btn-danger removeRow"><i class="fas fa-trash-alt"></i></button></td>
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td><input type="text" name="edu_school[]" class="form-control" placeholder="Enter School..."></td>
                                                        <td><input type="text" name="edu_duration[]" class="form-control" placeholder="Enter Duration..."></td>
                                                        <td><input type="text" name="edu_pass_cont[]" class="form-control"></td>
                                                        <td><input type="text" name="edu_degree[]" class="form-control" placeholder="Enter Degree/Certificate..."></td>
                                                        <td><input type="text" name="edu_remark[]" class="form-control" placeholder="Enter Remark..."></td>
                                                        <td><button type="button" class="btn btn-primary" id="addEduBtn"><i class="fas fa-plus"></i></button></td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                        
                                        <!-- Working Experience -->
                                        <table border="1" class="table" id="expTable">
                                            <thead>
                                                <tr class="text-center">
                                                    <td colspan="7" style="border: 1px;"><h5>Working Experience</h5></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td width="20%">Company</td>
                                                    <td width="10%">Duration</td>
                                                    <td width="10%">Position</td>
                                                    <td width="10%">Salary</td>
                                                    <td width="20%">Brief JD</td>
                                                    <td width="28%">Remark</td>
                                                    <td width="2%">Action</td>
                                                </tr>
                                                @if(!empty($expCompanies))
                                                    @foreach($expCompanies as $index => $company)
                                                        <tr>
                                                            <td><input type="text" name="exp_company[]" value="{{ $company }}" class="form-control" placeholder="Enter Company Name..."></td>
                                                            <td><input type="text" name="exp_duration[]" value="{{ $expDurations[$index] ?? '' }}" class="form-control" placeholder="......."></td>
                                                            <td><input type="text" name="exp_position[]" value="{{ $expPositions[$index] ?? '' }}" class="form-control" placeholder="......."></td>
                                                            <td><input type="text" name="exp_salary[]" value="{{ $expSalaries[$index] ?? '' }}" class="form-control" placeholder="......."></td>
                                                            <td><input type="text" name="exp_brief_jd[]" value="{{ $expBriefJDs[$index] ?? '' }}" class="form-control" placeholder="Enter Brief JD..."></td>
                                                            <td><input type="text" name="exp_remark[]" value="{{ $expRemarks[$index] ?? '' }}" class="form-control" placeholder="Enter Remark..."></td>
                                                            @if($index === 0)
                                                                <td><button type="button" class="btn btn-primary" id="addExpBtn"><i class="fas fa-plus"></i></button></td>
                                                            @else
                                                                <td><button type="button" class="btn btn-danger removeRow"><i class="fas fa-trash-alt"></i></button></td>
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td><input type="text" name="exp_company[]" class="form-control" placeholder="Enter Company Name..."></td>
                                                        <td><input type="text" name="exp_duration[]" class="form-control" placeholder="......."></td>
                                                        <td><input type="text" name="exp_position[]" class="form-control" placeholder="......."></td>
                                                        <td><input type="text" name="exp_salary[]" class="form-control" placeholder="......."></td>
                                                        <td><input type="text" name="exp_brief_jd[]" class="form-control" placeholder="Enter Brief JD..."></td>
                                                        <td><input type="text" name="exp_remark[]" class="form-control" placeholder="Enter Remark..."></td>
                                                        <td><button type="button" class="btn btn-primary" id="addExpBtn"><i class="fas fa-plus"></i></button></td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                        
                                        <!-- Other Skills (Language, Computer, Prof) -->
                                        <table border="1" class="table">
                                            <thead>
                                                <tr class="text-center">
                                                    <td colspan="2" style="border: 1px;"><h5>Other Skills (Language, Computer, Prof)</h5></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Language</td>
                                                    <td><input type="text" name="language_skill" value="@if($emp->language_skill){{ $emp->language_skill }}@endif" class="form-control" placeholder="Enter here..."></td>
                                                </tr>
                                                <tr>
                                                    <td>Computer</td>
                                                    <td><input type="text" name="computer_skill" value="@if($emp->computer_skill){{ $emp->computer_skill }}@endif" class="form-control" placeholder="Enter here..."></td>
                                                </tr>
                                                <tr>
                                                    <td>Other Skills</td>
                                                    <td><input type="text" name="other_skill" value="@if($emp->other_skill){{ $emp->other_skill }}@endif" class="form-control" placeholder="Enter here..."></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        
                                        <!-- Training at Work -->
                                        <table border="1" class="table" id="trainingTable">
                                            <thead>
                                                <tr class="text-center">
                                                    <td colspan="10" style="border: 1px;"><h5>Training at Work</h5></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td width="15%">Subject</td>
                                                    <td width="10%">Duration</td>
                                                    <td width="16%">Degree/Certificate</td>
                                                    <td>Amount</th>
                                                    <td width="9%">P/NP</td>
                                                    <td width="9%">C/NC</td>
                                                    <td width="9%">SD/CDP</td>
                                                    <td width="9%">O/CS</td>
                                                    <td width="9%">Int/Ext</td>
                                                    <td width="2%">Action</td>
                                                </tr>
                                                @if(!empty($trainSubjects))
                                                    @foreach($trainSubjects as $index => $subject)
                                                        <tr>
                                                            <td><input type="text" name="train_subject[]" value={{ $subject }} class="form-control" placeholder="Enter Subject..."></td>
                                                            <td><input type="text" name="train_duration[]" value="{{ $trainDurations[$index] ?? '' }}" class="form-control" placeholder="Enter here..."></td>
                                                            <td><input type="text" name="train_degree[]" value="{{ $trainDegrees[$index] ?? '' }}" class="form-control" placeholder="Enter here..."></td>
                                                            <td><input type="number" name="train_amount[]" value="{{ $trainAmounts[$index] ?? '' }}" class="form-control" min="0" placeholder="0"></td>
                                                            <td>
                                                                <select name="train_p_np[]" class="form-control" id="train_p_np">
                                                                    <option value="">Select</option>
                                                                    <option value="P" @if($trainPNPs[$index] === 'P') selected @endif>Pass</option>
                                                                    <option value="NP" @if($trainPNPs[$index] === 'NP') selected @endif>Not Pass</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="train_c_nc[]" class="form-control" id="train_c_nc">
                                                                    <option value="">Select</option>
                                                                    <option value="C" @if($trainCNCs[$index] === 'C') selected @endif>Contract</option>
                                                                    <option value="NC" @if($trainCNCs[$index] === 'NC') selected @endif>Not Contract &emsp;</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="train_sd_cdp[]" class="form-control" id="train_sd_cdp">
                                                                    <option value="">Select</option>
                                                                    <option value="SD" @if($trainSDCDPs[$index] === 'SD') selected @endif>Self Development</option>
                                                                    <option value="CDP" @if($trainSDCDPs[$index] === 'CDP') selected @endif>Company's Development Plan &emsp;</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="train_o_cs[]" class="form-control" id="train_o_cs">
                                                                    <option value="">Select</option>
                                                                    <option value="O" @if($trainOCSs[$index] === 'O') selected @endif>Own</option>
                                                                    <option value="CS" @if($trainOCSs[$index] === 'CS') selected @endif>Company's Sponsor &emsp;</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="train_int_ext[]" class="form-control" id="train_int_ext">
                                                                    <option value="">Select</option>
                                                                    <option value="Int" @if($trainIntExts[$index] === 'Int') selected @endif>Internal</option>
                                                                    <option value="Ext" @if($trainIntExts[$index] === 'Ext') selected @endif>External</option>
                                                                </select>
                                                            </td>
                                                            @if($index === 0)
                                                                <td><button type="button" class="btn btn-primary" id="addTrainingBtn"><i class="fas fa-plus"></i></button></td>
                                                            @else
                                                                <td><button type="button" class="btn btn-danger removeRow"><i class="fas fa-trash-alt"></i></button></td>
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td><input type="text" name="train_subject[]" class="form-control" placeholder="Enter Subject..."></td>
                                                        <td><input type="text" name="train_duration[]" class="form-control" placeholder="Enter here..."></td>
                                                        <td><input type="text" name="train_degree[]" class="form-control" placeholder="Enter here..."></td>
                                                        <td><input type="number" name="train_amount[]" class="form-control" min="0" placeholder="0"></td>
                                                        <td>
                                                            <select name="train_p_np[]" class="form-control" id="train_p_np">
                                                                <option value="">Select</option>
                                                                <option value="P">Pass</option>
                                                                <option value="NP">Not Pass</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select name="train_c_nc[]" class="form-control" id="train_c_nc">
                                                                <option value="">Select</option>
                                                                <option value="C">Contract</option>
                                                                <option value="NC">Not Contract &emsp;</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select name="train_sd_cdp[]" class="form-control" id="train_sd_cdp">
                                                                <option value="">Select</option>
                                                                <option value="SD">Self Development</option>
                                                                <option value="CDP">Company's Development Plan &emsp;</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select name="train_o_cs[]" class="form-control" id="train_o_cs">
                                                                <option value="">Select</option>
                                                                <option value="O">Own</option>
                                                                <option value="CS">Company's Sponsor &emsp;</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select name="train_int_ext[]" class="form-control" id="train_int_ext">
                                                                <option value="">Select</option>
                                                                <option value="Int">Internal</option>
                                                                <option value="Ext">External</option>
                                                            </select>
                                                        </td>
                                                        <td><button type="button" class="btn btn-primary" id="addTrainingBtn"><i class="fas fa-plus"></i></button></td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                        
                                        <!-- Employment Status Changes -->
                                        <table border="1" class="table" id="statusTable">
                                            <thead>
                                                <tr class="text-center">
                                                    <td colspan="7" style="border: 1px;"><h5>Employment Status Changes</h5></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td width="10%">Effective Date</td>
                                                    <td width="20%">Reason of Change</td>
                                                    <td width="10%">From</td>
                                                    <td width="10%">To</td>
                                                    <td>Other Change</td>
                                                    <td>Remark</td>
                                                    <td>Action</td>
                                                </tr>
                                                    @if(!empty($stsEffectiveDates))
                                                        @foreach($stsEffectiveDates as $index => $effectiveDate)
                                                            <tr>
                                                                <td><input type="date" name="sts_effective_date[]" value="{{ $effectiveDate }}" class="form-control"></td>
                                                                <td><input type="text" name="sts_reason_of_change[]" value="{{ $stsReasonOfChanges[$index] ?? '' }}" class="form-control" placeholder="Enter Reason of Change..."></td>
                                                                <td><input type="date" name="sts_from_date[]" value="{{ $stsFromDates[$index] ?? '' }}" class="form-control"></td>
                                                                <td><input type="date" name="sts_to_date[]" value="{{ $stsToDates[$index] ?? '' }}" class="form-control"></td>
                                                                <td><input type="text" name="sts_other_change[]" value="{{ $stsOtherChanges[$index] ?? '' }}" class="form-control" placeholder="Enter Other Change..."></td>
                                                                <td><input type="text" name="sts_remark[]" value="{{ $stsRemarks[$index] ?? '' }}" class="form-control" placeholder="Enter Remark..."></td>
                                                                @if($index === 0)
                                                                    <td><button type="button" class="btn btn-primary" id="addStatusBtn"><i class="fas fa-plus"></i></button></td>
                                                                @else
                                                                    <td><button type="button" class="btn btn-danger removeRow"><i class="fas fa-trash-alt"></i></button></td>
                                                                @endif
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td><input type="date" name="sts_effective_date[]" class="form-control"></td>
                                                            <td><input type="text" name="sts_reason_of_change[]" class="form-control" placeholder="Enter Reason of Change..."></td>
                                                            <td><input type="date" name="sts_from_date[]" class="form-control"></td>
                                                            <td><input type="date" name="sts_to_date[]" class="form-control"></td>
                                                            <td><input type="text" name="sts_other_change[]" class="form-control" placeholder="Enter Other Change..."></td>
                                                            <td><input type="text" name="sts_remark[]" class="form-control" placeholder="Enter Remark..."></td>
                                                            <td><button type="button" class="btn btn-primary" id="addStatusBtn"><i class="fas fa-plus"></i></button></td>
                                                        </tr>
                                                    @endif
                                            </tbody>
                                        </table>
                                        
                                        <!-- Warning/Disciplinary Action -->
                                        <table border="1" class="table" id="warningTable">
                                            <thead>
                                                <tr class="text-center">
                                                    <td colspan="5" style="border: 1px;"><h5>Warning/Disciplinary Action</h5></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td width="10%">Date</td>
                                                    <td width="47%">Incident Record</td>
                                                    <td width="17.5%">Status</td>
                                                    <td>Remark</td>
                                                    <td width="2%">Action</td>
                                                </tr>
                                                @if(!empty($actionDates))
                                                    @foreach($actionDates as $index => $actDate)
                                                        <tr>
                                                            <td><input type="date" name="action_date[]" value="{{ $actDate }}" class="form-control"></td>
                                                            <td><input type="text" name="action_incident_record[]" value="{{ $actionIncidentRecords[$index] ?? '' }}" class="form-control" placeholder="Enter Incident Record..."></td>
                                                            <td><input type="text" name="action_status[]" value="{{ $actionStatus[$index] ?? '' }}" class="form-control" placeholder="Enter Status..."></td>
                                                            <td><input type="text" name="action_remark[]" value="{{ $actionRemarks[$index] ?? '' }}" class="form-control" placeholder="Enter Remark..."></td>
                                                            @if($index === 0)
                                                                <td><button type="button" class="btn btn-primary" id="addWarningBtn"><i class="fas fa-plus"></i></button></td>
                                                            @else
                                                                <td><button type="button" class="btn btn-danger removeRow"><i class="fas fa-trash-alt"></i></button></td>
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td><input type="date" name="action_date[]" class="form-control"></td>
                                                        <td><input type="text" name="action_incident_record[]" class="form-control" placeholder="Enter Incident Record..."></td>
                                                        <td><input type="text" name="action_status[]" class="form-control" placeholder="Enter Status..."></td>
                                                        <td><input type="text" name="action_remark[]" class="form-control" placeholder="Enter Remark..."></td>
                                                        <td><button type="button" class="btn btn-primary" id="addWarningBtn"><i class="fas fa-plus"></i></button></td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                        
                                        <!-- Loan Application -->
                                        <table border="1" class="table" id="loanTable">
                                            <thead>
                                                <tr class="text-center">
                                                    <td colspan="5" style="border: 1px;"><h5>Loan Application</h5></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td width="10%">Date</td>
                                                    <td width="47%">Reason</td>
                                                    <td width="17.5%">Amount</td>
                                                    <td>Remark</td>
                                                    <td width="2%">Action</td>
                                                </tr>
                                                @if(!empty($loanDates))
                                                    @foreach($loanDates as $index => $loanDate)
                                                        <tr>
                                                            <td><input type="date" name="loan_date[]" value="{{ $loanDate }}" class="form-control"></td>
                                                            <td><input type="text" name="loan_reason[]" value="{{ $loanReasons[$index] ?? '' }}" class="form-control" placeholder="Enter Reason for Loan..."></td>
                                                            <td><input type="number" name="loan_amount[]" value="{{ $loanAmounts[$index] ?? '' }}" class="form-control" min="0" placeholder="0"></td>
                                                            <td><input type="text" name="loan_remark[]" value="{{ $loanRemarks[$index] ?? '' }}" class="form-control" placeholder="Enter Remark..."></td>
                                                            @if($index === 0)
                                                                <td><button type="button" class="btn btn-primary" id="addLoanBtn"><i class="fas fa-plus"></i></button></td>
                                                            @else
                                                                <td><button type="button" class="btn btn-danger removeRow"><i class="fas fa-trash-alt"></i></button></td>
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td><input type="date" name="loan_date[]" class="form-control"></td>
                                                        <td><input type="text" name="loan_reason[]" class="form-control" placeholder="Enter Reason for Loan..."></td>
                                                        <td><input type="number" name="loan_amount[]" class="form-control" min="0" placeholder="0"></td>
                                                        <td><input type="text" name="loan_remark[]" class="form-control" placeholder="Enter Remark..."></td>
                                                        <td><button type="button" class="btn btn-primary" id="addLoanBtn"><i class="fas fa-plus"></i></button></td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                        
                                        <!-- Supply Items -->
                                        <table border="1" class="table" id="supplyTable">
                                            <thead>
                                                <tr class="text-center">
                                                    <td colspan="7" style="border: 1px;"><h5>Supply Items</h5></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Items</td>
                                                    <td>Status</td>
                                                    <td>Date</td>
                                                    <td>No</td>
                                                    <td>Amount</td>
                                                    <td>Remark</td>
                                                    <td>Action</td>
                                                </tr>
                                                @if(!empty($supplyItems))
                                                    @foreach($supplyItems as $index => $item)
                                                        <tr>
                                                            <td><input type="text" name="supply_items[]" value="{{ $item }}" class="form-control" placeholder="Enter Item..."></td>
                                                            <td width="100px">
                                                                <select name="supply_status[]" class="select-primary" >
                                                                    <option value="">Select One</option>
                                                                    <option value="Yes" @if($supplyStatus[$index] === 'Yes') selected @endif>Yes</option>
                                                                    <option value="No" @if($supplyStatus[$index] === 'No') selected @endif>No</option>
                                                                </select>
                                                            </td>
                                                            <td><input type="date" name="supply_date[]" value="{{ $supplyDates[$index] ?? '' }}" class="form-control"></td>
                                                            <td><input type="number" name="supply_number[]" value="{{ $supplyNumbers[$index] ?? '' }}" min="0" class="form-control" placeholder="0"></td>
                                                            <td><input type="number" name="supply_amount[]" value="{{ $supplyAmounts[$index] ?? '' }}" class="form-control" placeholder="0"></td>
                                                            <td><input type="text" name="supply_remark[]" value="{{ $supplyRemarks[$index] ?? '' }}" class="form-control" placeholder="Enter Remark..."></td>
                                                            @if($index === 0)
                                                                <td><button type="button" class="btn btn-primary float-right" id="addSupBtn"><i class="fas fa-plus"></i></button></td>
                                                            @else
                                                                <td><button type="button" class="btn btn-danger removeRow"><i class="fas fa-trash-alt"></i></button></td>
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td><input type="text" name="supply_items[]" class="form-control" value="Uniform" placeholder="Enter Item..."></td>
                                                        <td width="100px">
                                                            <select name="supply_status[]" class="select-primary" >
                                                                <option value="">Select One</option>
                                                                <option value="Yes">Yes</option>
                                                                <option value="No">No</option>
                                                            </select>
                                                        </td>
                                                        <td><input type="date" name="supply_date[]" class="form-control"></td>
                                                        <td><input type="number" name="supply_number[]" min="0" class="form-control" placeholder="0"></td>
                                                        <td><input type="number" name="supply_amount[]" class="form-control" placeholder="0"></td>
                                                        <td><input type="text" name="supply_remark[]" class="form-control" placeholder="Enter Remark..."></td>
                                                        <td><button type="button" class="btn btn-primary float-right" id="addSupBtn"><i class="fas fa-plus"></i></button></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" name="supply_items[]" class="form-control" value="ID Card" placeholder="Enter Item..."></td>
                                                        <td>
                                                            <select name="supply_status[]" class="select-primary">
                                                                <option value="">Select One</option>
                                                                <option value="Yes">Yes</option>
                                                                <option value="No">No</option>
                                                            </select>
                                                        </td>
                                                        <td><input type="date" name="supply_date[]" class="form-control"></td>
                                                        <td><input type="number" name="supply_number[]" min="0" class="form-control" placeholder="0"></td>
                                                        <td><input type="number" name="supply_amount[]" class="form-control" placeholder="0"></td>
                                                        <td><input type="text" name="supply_remark[]" class="form-control" placeholder="Enter Remark..."></td>
                                                        <td><button type="button" class="btn btn-danger removeRow"><i class="fas fa-trash-alt"></i></button></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" name="supply_items[]" class="form-control" value="Com/Laptop" placeholder="Enter Item..."></td>
                                                        <td>
                                                            <select class="select-primary" name="supply_status[]">
                                                                <option value="">Select One</option>
                                                                <option value="Yes">Yes</option>
                                                                <option value="No">No</option>
                                                            </select>
                                                        </td>
                                                        <td><input type="date" name="supply_date[]" class="form-control"></td>
                                                        <td><input type="number" name="supply_number[]" min="0" class="form-control" placeholder="0"></td>
                                                        <td><input type="number" name="supply_amount[]" class="form-control" placeholder="0"></td>
                                                        <td><input type="text" name="supply_remark[]" class="form-control" placeholder="Enter Remark..."></td>
                                                        <td><button type="button" class="btn btn-danger removeRow"><i class="fas fa-trash-alt"></i></button></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" name="supply_items[]" class="form-control" value="Laptop Bag" placeholder="Enter Item..."></td>
                                                        <td>
                                                            <select class="select-primary" name="supply_status[]">
                                                                <option value="">Select One</option>
                                                                <option value="Yes">Yes</option>
                                                                <option value="No">No</option>
                                                            </select>
                                                        </td>
                                                        <td><input type="date" name="supply_date[]" class="form-control"></td>
                                                        <td><input type="number" name="supply_number[]" min="0" class="form-control" placeholder="0"></td>
                                                        <td><input type="number" name="supply_amount[]" class="form-control" placeholder="0"></td>
                                                        <td><input type="text" name="supply_remark[]" class="form-control" placeholder="Enter Remark..."></td>
                                                        <td><button type="button" class="btn btn-danger removeRow"><i class="fas fa-trash-alt"></i></button></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" name="supply_items[]" class="form-control" value="Mouse" placeholder="Enter Item..."></td>
                                                        <td>
                                                            <select class="select-primary" name="supply_status[]">
                                                                <option value="">Select One</option>
                                                                <option value="Yes">Yes</option>
                                                                <option value="No">No</option>
                                                            </select>
                                                        </td>
                                                        <td><input type="date" name="supply_date[]" class="form-control"></td>
                                                        <td><input type="number" name="supply_number[]" min="0" class="form-control" placeholder="0"></td>
                                                        <td><input type="number" name="supply_amount[]" class="form-control" placeholder="0"></td>
                                                        <td><input type="text" name="supply_remark[]" class="form-control" placeholder="Enter Remark..."></td>
                                                        <td><button type="button" class="btn btn-danger removeRow"><i class="fas fa-trash-alt"></i></button></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" name="supply_items[]" class="form-control" value="Sim Card" placeholder="Enter Item..."></td>
                                                        <td>
                                                            <select class="select-primary" name="supply_status[]">
                                                                <option value="">Select One</option>
                                                                <option value="Yes">Yes</option>
                                                                <option value="No">No</option>
                                                            </select>
                                                        </td>
                                                        <td><input type="date" name="supply_date[]" class="form-control"></td>
                                                        <td><input type="number" name="supply_number[]" min="0" class="form-control" placeholder="0"></td>
                                                        <td><input type="number" name="supply_amount[]" class="form-control" placeholder="0"></td>
                                                        <td><input type="text" name="supply_remark[]" class="form-control" placeholder="Enter Remark..."></td>
                                                        <td><button type="button" class="btn btn-danger removeRow"><i class="fas fa-trash-alt"></i></button></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" name="supply_items[]" class="form-control" value="Phone" placeholder="Enter Item..."></td>
                                                        <td>
                                                            <select class="select-primary" name="supply_status[]">
                                                                <option value="">Select One</option>
                                                                <option value="Yes">Yes</option>
                                                                <option value="No">No</option>
                                                            </select>
                                                        </td>
                                                        <td><input type="date" name="supply_date[]" class="form-control"></td>
                                                        <td><input type="number" name="supply_number[]" min="0" class="form-control" placeholder="0"></td>
                                                        <td><input type="number" name="supply_amount[]" class="form-control" placeholder="0"></td>
                                                        <td><input type="text" name="supply_remark[]" class="form-control" placeholder="Enter Remark..."></td>
                                                        <td><button type="button" class="btn btn-danger removeRow"><i class="fas fa-trash-alt"></i></button></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" name="supply_items[]" class="form-control" value="Safety Shoe" placeholder="Enter Item..."></td>
                                                        <td>
                                                            <select class="select-primary" name="supply_status[]">
                                                                <option value="">Select One</option>
                                                                <option value="Yes">Yes</option>
                                                                <option value="No">No</option>
                                                            </select>
                                                        </td>
                                                        <td><input type="date" name="supply_date[]" class="form-control"></td>
                                                        <td><input type="number" name="supply_number[]" min="0" class="form-control" placeholder="0"></td>
                                                        <td><input type="number" name="supply_amount[]" class="form-control" placeholder="0"></td>
                                                        <td><input type="text" name="supply_remark[]" class="form-control" placeholder="Enter Remark..."></td>
                                                        <td><button type="button" class="btn btn-danger removeRow"><i class="fas fa-trash-alt"></i></button></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" name="supply_items[]" class="form-control" value="Safety Hat" placeholder="Enter Item..."></td>
                                                        <td>
                                                            <select class="select-primary" name="supply_status[]">
                                                                <option value="">Select One</option>
                                                                <option value="Yes">Yes</option>
                                                                <option value="No">No</option>
                                                            </select>
                                                        </td>
                                                        <td><input type="date" name="supply_date[]" class="form-control"></td>
                                                        <td><input type="number" name="supply_number[]" min="0" class="form-control" placeholder="0"></td>
                                                        <td><input type="number" name="supply_amount[]" class="form-control" placeholder="0"></td>
                                                        <td><input type="text" name="supply_remark[]" class="form-control" placeholder="Enter Remark..."></td>
                                                        <td><button type="button" class="btn btn-danger removeRow"><i class="fas fa-trash-alt"></i></button></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" name="supply_items[]" class="form-control" value="Safety Tool" placeholder="Enter Item..."></td>
                                                        <td>
                                                            <select class="select-primary" name="supply_status[]">
                                                                <option value="">Select One</option>
                                                                <option value="Yes">Yes</option>
                                                                <option value="No">No</option>
                                                            </select>
                                                        </td>
                                                        <td><input type="date" name="supply_date[]" class="form-control"></td>
                                                        <td><input type="number" name="supply_number[]" min="0" class="form-control" placeholder="0"></td>
                                                        <td><input type="number" name="supply_amount[]" class="form-control" placeholder="0"></td>
                                                        <td><input type="text" name="supply_remark[]" class="form-control" placeholder="Enter Remark..."></td>
                                                        <td><button type="button" class="btn btn-danger removeRow"><i class="fas fa-trash-alt"></i></button></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" name="supply_items[]" class="form-control" value="Safety Toolbox" placeholder="Enter Item..."></td>
                                                        <td>
                                                            <select class="select-primary" name="supply_status[]">
                                                                <option value="">Select One</option>
                                                                <option value="Yes">Yes</option>
                                                                <option value="No">No</option>
                                                            </select>
                                                        </td>
                                                        <td><input type="date" name="supply_date[]" class="form-control"></td>
                                                        <td><input type="number" name="supply_number[]" min="0" class="form-control" placeholder="0"></td>
                                                        <td><input type="number" name="supply_amount[]" class="form-control" placeholder="0"></td>
                                                        <td><input type="text" name="supply_remark[]" class="form-control" placeholder="Enter Remark..."></td>
                                                        <td><button type="button" class="btn btn-danger removeRow"><i class="fas fa-trash-alt"></i></button></td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                        
                                        <!-- Other Remark -->
                                        <label>Other Remark</label>
                                        <div>
                                            <textarea class="form-control" name="other_remark" rows="7" placeholder="Enter Other Remark...">@if($emp->other_remark){{ $emp->other_remark }}@endif</textarea>
                                        </div>
                                        
                                        <div class="text-center" style="margin-top: 30px;">
                                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Employee CV</button>
                                            <button type="button" class="btn btn-success" id="printBtn" data-id="{{$emp->id}}"><i class="fas fa-print"></i> Print CV</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </section>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // preview image on card
            function previewFile() {
                var preview = $('#previewImage');
                var file = $('#cv_photo').prop('files')[0];
                var reader = new FileReader();

                reader.onloadend = function() {
                    preview.attr('src', reader.result);
                }

                if (file) {
                    reader.readAsDataURL(file);
                } else {
                    preview.attr('src', 'public/userimages/user_white.jpg');
                }
            }
            $('#cv_photo').on('change', function() {
                previewFile(); 
            });
            
            // remove photo
            document.getElementById('removePhotoBtn').addEventListener('click', function(event) {
                event.preventDefault();
                const preview = document.getElementById('previewImage');
                const fileInput = document.getElementById('cv_photo');
        
                // Set the hidden input value to true
                document.getElementById('remove_photo').value = "true";
                
                // Reset the file input by creating a new input element and replacing the old one
                const newFileInput = fileInput.cloneNode();
                fileInput.parentNode.replaceChild(newFileInput, fileInput);
        
                // Update the preview to the default image
                const defaultPhotoPath = "{{ URL::asset('public/userimages/user.png') }}";
                preview.src = defaultPhotoPath;
        
                // Reattach the event listener to the new input element
                newFileInput.addEventListener('change', previewFile);
            });
                                                    
            // add rows to table
            $(document).on('click', '#addEduBtn', function() {
                var newRow = $('<tr>');
                var cols = '';
                
                cols += '<td><input type="text" name="edu_school[]" class="form-control" placeholder="Enter School..."></td>';
                cols += '<td><input type="text" name="edu_duration[]" class="form-control" placeholder="Enter Duration..."></td>';
                cols += '<td><input type="text" name="edu_pass_cont[]" class="form-control"></td>';
                cols += '<td><input type="text" name="edu_degree[]" class="form-control" placeholder="Enter Degree/Certificate..."></td>';
                cols += '<td><input type="text" name="edu_remark[]" class="form-control" name="personal_edu_remark" placeholder="Enter Remark..."></td>';
                cols += '<td><button type="button" class="btn btn-danger removeRow"><i class="fas fa-trash-alt"></i></button></td>';

                newRow.append(cols);
                $('#eduTable tbody').append(newRow);
            });
            
            $(document).on('click', '#addExpBtn', function() {
                var newRow = $('<tr>');
                var cols = '';
                
                cols += '<td><input type="text" name="exp_company[]" class="form-control" placeholder="Enter Company Name..."></td>';
                cols += '<td><input type="text" name="exp_duration[]" class="form-control" placeholder="......."></td>';
                cols += '<td><input type="text" name="exp_position[]" class="form-control" placeholder="......."></td>';
                cols += '<td><input type="text" name="exp_salary[]" class="form-control" placeholder="......."></td>';
                cols += '<td><input type="text" name="exp_brief_jd[]" class="form-control" placeholder="Enter Brief JD..."></td>';
                cols += '<td><input type="text" name="exp_remark[]" class="form-control" placeholder="Enter Remark..."></td>';
                cols += '<td><button type="button" class="btn btn-danger removeRow"><i class="fas fa-trash-alt"></i></button></td>';

                newRow.append(cols);
                $('#expTable tbody').append(newRow);
            });
                                                    
            $(document).on('click', '#addTrainingBtn', function() {
                var newRow = $('<tr>');
                var cols = '';
                
                cols += '<td><input type="text" name="train_subject[]" class="form-control" placeholder="Enter Subject..."></td>';
                cols += '<td><input type="text" name="train_duration[]" class="form-control" placeholder="Enter here..."></td>';
                cols += '<td><input type="text" name="train_degree[]" class="form-control" placeholder="Enter here..."></td>';
                cols += '<td><input type="number" name="train_amount[]" class="form-control" min="0" placeholder="0"></td>';
                cols += '<td><select class="form-control" name="train_p_np[]" id="train_p_np"><option value="">Select</option><option value="P">Pass</option><option value="NP">Not Pass</option></select></td>';
                cols += '<td><select class="form-control" name="train_c_nc[]" id="train_c_nc"><option value="">Select</option><option value="C">Contract</option><option value="NC">Not Contract &emsp;</option></select></td>';
                cols += '<td><select class="form-control" name="train_sd_cdp[]" id="train_sd_cdp"><option value="">Select</option><option value="SD">Self Development</option><option value="CDP">Company\'s Development Plan &emsp;</option></select></td>';
                cols += '<td><select class="form-control" name="train_o_cs[]" id="train_o_cs"><option value="">Select</option><option value="O">Own</option><option value="CS">Company\'s Sponsor &emsp;</option></select></td>';
                cols += '<td><select class="form-control" name="train_int_ext[]" id="train_int_ext"><option value="">Select</option><option value="Int">Internal</option><option value="Ext">External</option></select></td>';
                cols += '<td><button type="button" class="btn btn-danger removeRow"><i class="fas fa-trash-alt"></i></button></td>';

                newRow.append(cols);
                $('#trainingTable tbody').append(newRow);
            });
            
            $(document).on('click', '#addStatusBtn', function() {
                var newRow = $('<tr>');
                var cols = '';
                
                cols += '<td><input type="date" name="sts_effective_date[]" class="form-control"></td>';
                cols += '<td><input type="text" name="sts_reason_of_change[]" class="form-control" placeholder="Enter Reason of Change..."></td>';
                cols += '<td><input type="date" name="sts_from_date[]" class="form-control"></td>';
                cols += '<td><input type="date" name="sts_to_date[]" class="form-control"></td>';
                cols += '<td><input type="text" name="sts_other_change[]" class="form-control" placeholder="Enter Other Change..."></td>';
                cols += '<td><input type="text" name="emp_sts_remark[]" class="form-control" placeholder="Enter Remark..."></td>';
                cols += '<td><button type="button" class="btn btn-danger removeRow"><i class="fas fa-trash-alt"></i></button></td>';

                newRow.append(cols);
                $('#statusTable tbody').append(newRow);
            });
            
            $(document).on('click', '#addWarningBtn', function() {
                var newRow = $('<tr>');
                var cols = '';

                cols += '<td><input type="date"  name="action_date[]" class="form-control"></td>';
                cols += '<td><input type="text"  name="action_incident_record[]" class="form-control" placeholder="Enter Incident Record..."></td>';
                cols += '<td><input type="text"  name="action_status[]" class="form-control" placeholder="Enter Status..."></td>';
                cols += '<td><input type="text"  name="action_remark[]" class="form-control" placeholder="Enter Remark..."></td>';
                cols += '<td><button type="button" class="btn btn-danger removeRow"><i class="fas fa-trash-alt"></i></button></td>';

                newRow.append(cols);
                $('#warningTable tbody').append(newRow);
            });
            
            $(document).on('click', '#addLoanBtn', function() {
                var newRow = $('<tr>');
                var cols = '';
                
                cols += '<td><input type="date" name="loan_date[]" class="form-control"></td>';
                cols += '<td><input type="text" name="loan_reason[]" class="form-control" placeholder="Enter Reason for Loan..."></td>';
                cols += '<td><input type="number" name="loan_amount[]" class="form-control" min="0" placeholder="0"></td>';
                cols += '<td><input type="text" name="loan_remark[]" class="form-control" placeholder="Enter Remark..."></td>';
                cols += '<td><button type="button" class="btn btn-danger removeRow"><i class="fas fa-trash-alt"></i></button></td>';

                newRow.append(cols);
                $('#loanTable tbody').append(newRow);
            });
            
            $(document).on('click', '#addSupBtn', function() {
                var newRow = $('<tr>');
                var cols = '';
                
                cols += '<td><input type="text" name="supply_items[]" class="form-control" placeholder="Enter Item..."></td>';
                cols += '<td><select class="select-primary" name="supply_status[]"><option value="">Select One</option><option value="Yes">Yes</option><option value="No">No</option></select></td>';
                cols += '<td><input type="date" name="supply_date[]" class="form-control"></td>';
                cols += '<td><input type="number" name="supply_number[]" min="0" class="form-control" placeholder="0"></td>';
                cols += '<td><input type="number" name="supply_amount[]" class="form-control" placeholder="0"></td>';
                cols += '<td><input type="text" name="supply_remark[]" class="form-control" placeholder="Enter Remark..."></td>';
                cols += '<td><button type="button" class="btn btn-danger removeRow"><i class="fas fa-trash-alt"></i></button></td>';

                newRow.append(cols);
                $('#supplyTable tbody').append(newRow);
            });
            
            // remove added rows
            $(document).on('click', '.removeRow', function() {
                $(this).closest('tr').remove();
            });
        });
        
        // print CV
        document.getElementById('printBtn').addEventListener('click', function() {
            var id = this.getAttribute('data-id');
            var printUrl = '{{ route('print', ['id' => ':id']) }}'.replace(':id', id);
            var printWindow = window.open(printUrl, '_target');
            printWindow.addEventListener('load', function() {
                printWindow.print();
            });
        });
    </script>
    
    // <script>
    //     setTimeout(function() {
    //         $('#alert-message').fadeOut('slow');
    //     }, 3000); // 3 seconds
    // </script>
@endsection



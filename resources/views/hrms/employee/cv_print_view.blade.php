<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV - {{ $emp->name }}</title>
</head>

<style>
    .panel-heading {
        margin-top: -30px;
    }
    #image {
        width: 150px;
        height: 150px;
        margin-left: 14px;
    }
    h3 {
        color: black !important;
    }
    h5 {
        margin: auto;
        font-size: 18px;
        font-weight: bold !important;
    }
    table tbody tr td {
        padding: 10px;
    }
    table thead {
        background: yellow;
        border: 1px solid black;
    }
</style>

<body>
    <div class="container">
        <!-- Heading -->
        <div class="panel-heading">
            <h1 class="text-center" style="color:black">Q-First Group of Companies</h1>
            <h3 class="text-center">Employee Resume</h3>
        </div>
    
        <div class="row">
            <!-- Personal Info -->
            <table border="1" class="table" width="100%">
                <thead>
                    <tr class="text-center">
                        <td colspan="5"><h5>Personal Information</h5></td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td width="36%">Name: {{ $emp->name }}</td>
                        <td width="36%">Employee ID No: {{ $emp->employee_id }}</td>
                        <td rowspan="3" class="text-center">
                            <img src="@if($emp->cv_photo) {{ URL::asset($emp->cv_photo) }} @else {{ URL::asset('public/userimages/user.png') }} @endif" id="image">
                        </td>
                    </tr>
                    <tr>
                        <td width="20%">NRC: {{ $emp->nrc_passport }}</td>
                        <td width="20%">Manpower Req ID: {{ $emp->manpower_request_id }}</td>
                    </tr>
                    <tr>
                        <td>Date of Birth: {{ \Carbon\Carbon::parse($emp->date_of_birth)->format('d-m-Y') }}</td>
                        <td>Position: {{ $emp->position }}</td>
                    </tr>
                    <tr>
                        <td>Father's Name: {{ $emp->father_name }}</td>
                        <td>Mother's Name: {{ $emp->mother_name }}</td>
                        <td>Department: {{ $emp->department }}</td>
                    </tr>
                    <tr>
                        <td>Company: {{ $emp->company }}</td>
                        <td>Marital Status: {{ $emp->marital_status }}</td>
                        <td>Salary Benefit: {{ $emp->benefit }}</td>
                    </tr>
                    <tr>
                        <td>Blood Type: {{ $emp->blood_type }}</td>
                        <td>Height & Weight: {{ $emp->height_weight }}</td>
                        <td>Insurance: {{ $emp->insurance }}</td>
                    </tr>
                    <tr>
                        <td>SSB: {{ $emp->ssb }}</td>
                        <td>Phone Number: {{ $emp->phone }}</td>
                        <td>Ferry: {{ $emp->ferry }}</td>
                    </tr>
                    <tr>
                        <td>
                            Address (current)
                            {{ $emp->residential_address }}
                        </td>
                        <td colspan="2">    
                            Address (permanent)
                            {{ $emp->principle_address }}
                        </td>
                    </tr>
                </tbody>
            </table>
                                            
            <!-- Personal Education -->
            <table border="1" class="table" id="eduTable" width="100%">
                <thead>
                    <tr class="text-center">
                        <td colspan="6" style="border: 1px;">
                            <h5>Personal Education Background</h5>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td width="20%">School</td>
                        <td width="15%">Duration</td>
                        <td width="15%">Pass/Cont</td>
                        <td width="20%">Degree/Certificate</td>
                        <td width="50%">Remark</td>
                    </tr>
                    @if(!empty($eduSchools))
                        @foreach($eduSchools as $index => $school)
                            <tr>
                                <td>{{ $school }}</td>
                                <td>{{ $eduDurations[$index] ?? '' }}</td>
                                <td>{{ $eduPassConts[$index] ?? '' }}</td>
                                <td>{{ $eduDegrees[$index] ?? '' }}</td>
                                <td>{{ $eduRemarks[$index] ?? '' }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            
            <!-- Working Experience -->
            <table border="1" class="table" id="expTable" width="100%">
                <thead>
                    <tr class="text-center">
                        <td colspan="7" style="border: 1px;"><h5>Working Experience</h5></td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td width="20%">Company</td>
                        <td width="15%">Duration</td>
                        <td width="15%">Position</td>
                        <td width="15%">Salary</td>
                        <td width="20%">Brief JD</td>
                        <td width="30%">Remark</td>
                    </tr>
                    @if(!empty($expCompanies))
                        @foreach($expCompanies as $index => $company)
                            <tr>
                                <td>{{ $company }}</td>
                                <td>{{ $expDurations[$index] ?? '' }}</td>
                                <td>{{ $expPositions[$index] ?? '' }}</td>
                                <td>{{ $expSalaries[$index] ?? '' }}</td>
                                <td>{{ $expBriefJDs[$index] ?? '' }}</td>
                                <td>{{ $expRemarks[$index] ?? '' }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            
            <!-- Other Skills (Language, Computer, Prof) -->
            <table border="1" class="table" width="100%">
                <thead>
                    <tr class="text-center">
                        <td colspan="2" style="border: 1px;"><h5>Other Skills (Language, Computer, Prof)</h5></td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td width="20%">Language</td>
                        <td width="45%">{{ $emp->language_skill }}</td>
                    </tr>
                    <tr>
                        <td>Computer</td>
                        <td>{{ $emp->computer_skill }}</td>
                    </tr>
                    <tr>
                        <td>Other Skills</td>
                        <td>{{ $emp->other_skill }}</td>
                    </tr>
                </tbody>
            </table>
            
            <!-- Training at Work -->
            <table border="1" class="table" id="trainingTable" width="100%">
                <thead>
                    <tr class="text-center">
                        <td colspan="10" style="border: 1px;"><h5>Training at Work</h5></td>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($trainSubjects))
                        @foreach($trainSubjects as $index => $subject)
                            @php
                                $subIndex = $index + 1;
                            @endphp
                    
                            @if($index % 2 == 0)
                                <tr>
                            @endif
                    
                            <td width="50%">
                                No. {{ $subIndex }}<br>
                                Subject: {{ $subject }}<br>
                                Duration: {{ $trainDurations[$index] ?? '' }}<br>
                                Degree/Certificate: {{ $trainDegrees[$index] ?? '' }}<br>
                                Amount: {{ $trainAmounts[$index] ?? '' }}<br>
                                P/NP: @if($trainPNPs[$index] === 'P') Pass @elseif($trainPNPs[$index] === 'NP') Not Pass @endif <br>
                                C/NC: @if($trainCNCs[$index] === 'C') Contract @elseif($trainCNCs[$index] === 'C') Not Contract @endif <br>
                                SD/CDP: @if($trainSDCDPs[$index] === 'SD') Self Development @elseif($trainSDCDPs[$index] === 'CDP') Company's Development Plan @endif <br>
                                O/CS: @if($trainOCSs[$index] === 'O') Own @elseif($trainOCSs[$index] === 'CS') Company's Sponsor @endif <br>
                                Int/Ext: @if($trainIntExts[$index] === 'Int') Internal @elseif($trainIntExts[$index] === 'Ext') Not External @endif
                            </td>
                    
                            @if(($index + 1) % 2 == 0 || $index == count($trainSubjects) - 1)
                                </tr>
                            @endif
                        @endforeach
                    @endif
                </tbody>
            </table>
        
            <!-- Employment Status Changes -->
            <table border="1" class="table" id="statusTable" width="100%">
                <thead>
                    <tr class="text-center">
                        <td colspan="7" style="border: 1px;"><h5>Employment Status Changes</h5></td>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($stsEffectiveDates))
                        @foreach($stsEffectiveDates as $index => $effectiveDate)
                            @php
                                $stsIndex = $index + 1;
                            @endphp
                    
                            @if($index % 2 == 0)
                                <tr>
                            @endif
                    
                            <td width="50%">
                                No. {{ $stsIndex }}
                                Effective Date: {{ $effectiveDate}}<br>
                                Reason of Change: {{ $stsReasonOfChanges[$index] ?? '' }}<br>
                                From: {{ $stsFromDates[$index] ?? '' }}<br>
                                To: {{ $stsToDates[$index] ?? '' }}<br>
                                Change: {{ $stsOtherChanges[$index] ?? '' }} <br>
                                Remark: {{ $stsRemarks[$index] ?? '' }}
                            </td>
                    
                            @if(($index + 1) % 2 == 0 || $index == count($trainSubjects) - 1)
                                </tr>
                            @endif
                        @endforeach
                    @endif
                </tbody>
            </table>
            
            <!-- Warning/Disciplinary Action -->
            <table border="1" class="table" id="warningTable" width="100%">
                <thead>
                    <tr class="text-center">
                        <td colspan="5" style="border: 1px;"><h5>Warning/Disciplinary Action</h5></td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td width="15%">Date</td>
                        <td width="40%">Incident Record</td>
                        <td width="15%">Status</td>
                        <td>Remark</td>
                    </tr>
                    @if(!empty($actionDates))
                        @foreach($actionDates as $index => $actDate)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($actDate)->format('d-m-Y') }}</td>
                                <td>{{ $actionIncidentRecords[$index] ?? '' }}</td>
                                <td>{{ $actionStatus[$index] ?? '' }}</td>
                                <td>{{ $actionRemarks[$index] ?? '' }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
                                        
            <!-- Loan Application -->
            <table border="1" class="table" id="loanTable" width="100%">
                <thead>
                    <tr class="text-center">
                        <td colspan="5" style="border: 1px;"><h5>Loan Application</h5></td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td width="15%">Date</td>
                        <td width="40%">Reason</td>
                        <td width="15%">Amount</td>
                        <td>Remark</td>
                    </tr>
                    @if(!empty($loanDates))
                        @foreach($loanDates as $index => $loanDate)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($loanDate)->format('d-m-Y') }}</td>
                                <td>{{ $loanReasons[$index] ?? '' }}</td>
                                <td>{{ $loanAmounts[$index] ?? '' }}</td>
                                <td>{{ $loanRemarks[$index] ?? '' }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
                                        
            <!-- Supply Items -->
            <table border="1" class="table" id="supplyTable" width="100%">
                <thead>
                    <tr class="text-center">
                        <td colspan="7" style="border: 1px;"><h5>Supply Items</h5></td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td width="20%">Items</td>
                        <td width="6.4%">Status</td>
                        <td width="15%">Date</td>
                        <td width="10%">No</td>
                        <td width="15%">Amount</td>
                        <td>Remark</td>
                    </tr>
                    @if(!empty($supplyItems))
                        @foreach($supplyItems as $index => $item)
                            <tr>
                                <td>{{ $item }}</td>
                                <td>{{ $supplyStatus[$index] ?? '' }}</td>
                                <td>{{ \Carbon\Carbon::parse($supplyDates[$index])->format('d-m-Y') ?? '' }}</td>
                                <td>{{ $supplyNumbers[$index] ?? '' }}</td>
                                <td>{{ $supplyAmounts[$index] ?? '' }}</td>
                                <td>{{ $supplyRemarks[$index] ?? '' }}</td>
                            </tr>
                        @endforeach
                    @endif
                    <thead>
                        <tr class="text-center">
                            <td colspan="7" style="border: 1px;"><h5>Other Remark</h5></td>
                        </tr>
                    </thead>
                    <tr>
                        <td colspan="6">
                            {{ $emp->other_remark }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
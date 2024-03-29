@extends('layouts.user')

@section('title', $voice_evaluation->name ?? 'New Evaluation')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <p>
                <strong>Opps Something went wrong</strong>
            </p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="back-area mb-3">
        <a href="{{ route('voice-audits.qa-pending-sale-sheet', $voice_evaluation->id) }}?search=1&campaign_id={{ $campaign_id }}&record_id={{ $record_id }}&from_date={{ $from_date }}&to_date={{ $to_date }}"
           class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left mr-2"></i> Go Back</a>
    </div>

    <form action="{{ route('voice-audits.store') }}" method="post" autocomplete="off">
        @csrf
        <div class="timer-area" style="float: right;">
            <div class="timer" id="timer" style="font-size: 18px;"></div>
            <input type="hidden" name="evaluation_time" class="timer" id="evaluation_time">
        </div>
        <input type="hidden" name="voice_evaluation_id" value="{{ $voice_evaluation->id }}" required>
        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
        <div class="search-area">
            <div class="row">

                <div class="col-md-6">
                    <h4 class="mb-0">New {{ $voice_evaluation->name ?? 'Evaluation' }}</h4>
                </div>

            </div>
        </div>

        <!-- Default box -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Information (Step 1 of 3)</h3>

            </div>
            <div class="card-body">

                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Record ID <span>*</span>
                            </label>

                            @if (@$record)
                                <input type="hidden" class="form-control" name="record_id"
                                       value="{{ @$record->record_id }}" required>
                                <input type="text" class="form-control" name="" value="{{ @$record->record_id }}"
                                       disabled>
                            @else
                                <p style="color: red">Record ID not Found</p>
                                <input type="text" class="form-control" name="record_id"
                                       @if (isset($_GET['record_id'])) value="{{ $_GET['record_id'] }}" @endif
                                       placeholder="Enter Record ID" required>
                            @endif

                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Campaign Name</label>
                            @if (@$record)
                                <input type="hidden" class="form-control" name="campaign_id"
                                       value="{{ @$record->campaign->id }}" id="campaign_list" required>
                                <input type="text" class="form-control" id="campaign" name=""
                                       value="{{ @$record->campaign->name ?? '' }}" disabled>
                            @else
                                <p style="color: red">Campaign Not Found</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Project</label>
                            @if (@$record->project)
                                <input type="hidden" class="form-control" name="project_id"
                                       value="{{ @$record->project->id ?? '' }}" required>
                                <input type="text" class="form-control" value="{{ @$record->project->name ?? '' }}"
                                       disabled>
                            @else
                                <p style="color: red">Project Not Found</p>
                            @endif

                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Call Date <span>*</span>
                            </label>

                            @if (@$record->created_at)
                                <input type="hidden" class="form-control" name="call_date"
                                       value="{{ date('Y-m-d', strtotime(@$record->created_at)) ?? '' }}" required>
                                <input type="text" class="form-control" name=""
                                       value="{{ date('d-m-Y', strtotime(@$record->created_at)) ?? '' }}" disabled>
                            @else
                                <input type="text" class="form-control datetimepicker-input datepicker" name="call_date"
                                       data-toggle="datetimepicker" data-target=".datepicker" required>
                            @endif

                        </div>
                        @error('call_date')
                        <div class="validate-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">HRMS ID</label>

                            @if (@$record->agent_user)
                                <input type="text" class="form-control" name=""
                                       value="{{ @$record->agent_user->HRMSID ?? '' }}" disabled>
                            @else
                                <p style="color: red">Agent Not Found</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Agent Name <span>*</span>
                            </label>

                            @if (@$record->agent_user)
                                <input type="hidden" class="form-control" name="associate_id"
                                       value="{{ @$record->agent_user->HRMSID ?? '' }}" required>
                                <input type="text" class="form-control" name=""
                                       value="{{ @$record->agent_user->name ?? '' }}" disabled>
                            @else
                                <p style="color: red">Agent Not Found</p>
                            @endif

                        </div>
                        @error('associate_id')
                        <div class="validate-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Reporting To<span>*</span>
                            </label>
                            <input type="hidden" class="form-control" name="team_lead_id"
                                   value="{{ @$record->agent_user->reporting_to_id ?? 0 }}" required>
                            <input type="text" class="form-control" name=""
                                   value="{{ @$reporting_to->name }}" disabled>
                        </div>
                        @error('associate_id')
                        <div class="validate-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Address<span>*</span>
                            </label>
                            <input type="text" class="form-control" name=""
                                   value="{{ @$record->address.' '.@$record->zip_code.' '.@$record->city.' '.@$record->state }}" disabled>
                        </div>
                        @error('associate_id')
                        <div class="validate-error">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

            </div>

        </div>
        <!-- /.card -->

        <!-- Default box -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Data Points (Step 2 of 3)</h3>
            </div>

            <div class="card-body">
                @php $points = 0; @endphp
                @if (count($categories) > 0)
                    @foreach ($categories as $category)
                        @php
                            $categoryTotal = 0;
                        @endphp
                        <div class="category">
                            <div class="title">
                                <div class="row">
                                    <div class="col-md-11">
                                        <h4>{{ $category->name }}</h4>
                                    </div>
                                    <div class="col-md-1">
                                        @foreach ($category->datapoints as $item)
                                            @php
                                                $categoryTotal = $item->score + $categoryTotal;
                                            @endphp
                                        @endforeach
                                        <h6>Total Score: {{ $categoryTotal }}</h6>
                                    </div>
                                </div>
                            </div>
                            @if (count($category->datapoints) > 0)
                                <div class="data-points">
                                    <table class="table table-hover">
                                        @foreach ($category->datapoints as $item)
                                            @php $points = $points + $item->score; @endphp
                                            <tr>
                                                <td width="15%">{{ $item->name }}</td>
                                                <td width="70%">{{ $item->question }}</td>
                                                <td class="radios">
                                                    <label class="radio-inline qrating">
                                                        <input type="radio" required class="radio yes" Checked
                                                               value="{{ $item->score }}" name="answer-{{ $item->id }}">Yes
                                                    </label>
                                                    <label class="radio-inline qrating">
                                                        <input type="radio" required class="radio no" value="0"
                                                               name="answer-{{ $item->id }}">No
                                                    </label>
                                                    <label class="radio-inline qrating">
                                                        <input type="radio" class="radio" value="Na-{{ $item->score }}"
                                                               name="answer-{{ $item->id }}">N/A
                                                    </label>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            @else
                                <h5 class="text-center">No data points found!</h5>
                            @endif

                        </div>
                    @endforeach
                @else
                    <h4 class="text-center">No records found</h4>
                @endif

            </div>

        </div>
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Evaluation (Step 3 of 3)</h3>
            </div>
            <div class="card-body">

                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Score <span>*</span>
                            </label>
                            <input type="text" name="percentage" id="percentage" value="{{ $points }}"
                                   class="form-control percentage" readonly>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Customer Name <span>*</span>
                            </label>

                            @if (@$record->first_name && $record->last_name)
                                <input type="hidden" class="form-control" name="customer_name"
                                       value="{{ @$record->first_name }} {{ @$record->last_name }}" required>
                                <input type="text" name="" class="form-control"
                                       value="{{ @$record->first_name }} {{ @$record->last_name }}" disabled>
                            @else
                                <input type="text" name="customer_name" class="form-control"
                                       placeholder="Enter Customer Name" required>
                            @endif


                        </div>
                        @error('customer_name')
                        <div class="validate-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Customer Phone <span>*</span>
                            </label>

                            @if (@$record->phone)
                                <input type="hidden" class="form-control" name="customer_phone"
                                       value="{{ @$record->phone }}" required>
                                <input type="text" name="" class="form-control" value="{{ @$record->phone }}"
                                       disabled>
                            @else
                                <input type="text" name="customer_phone" class="form-control"
                                       placeholder="Enter Customer Phone" required>
                            @endif
                        </div>
                        @error('customer_phone')
                        <div class="validate-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Recording Duration <span>*</span>
                            </label>
                            <input type="text" name="recording_duration" placeholder="HH:MM:SS" id="recording_duration"
                                   class="form-control" required>
                        </div>
                        @error('recording_duration')
                        <div class="validate-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Recording Link</label>
                            <input type="text" name="recording_link" id="recording_link" class="form-control">
                        </div>
                        @error('recording_link')
                        <div class="validate-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Notes <span>*</span>
                            </label>
                            <textarea name="notes" id="notes" rows="3" class="form-control" required></textarea>
                        </div>
                        @error('notes')
                        <div class="validate-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Client Outcome <span>*</span>
                            </label>
                            <select name="outcome" id="outcome" class="form-control select2" required>
                                <option value="">Select Option</option>
                                <option value="accepted">Billable</option>
                                <option value="rejected">Non Billable</option>
                            </select>
                        </div>
                        @error('outcome')
                        <div class="validate-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Agent Outcome <span>*</span>
                            </label>
                            <select name="agent_outcome" id="agent_outcome" class="form-control select2" required>
                                <option value="">Select Option</option>
                                <option value="accepted">Accepted</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                        {{-- @error('outcome')
                                                                                            <div class="validate-error">{{ $message }}</div>
                        @enderror --}}
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Call Type <span>*</span>
                            </label>
                            <select name="call_type" id="call_type" class="form-control select2" required>
                                <option value="">Select Option</option>
                                <option value="general">General</option>
                                <option value="sales">Sales</option>
                            </select>
                        </div>
                        {{-- @error('outcome')
                                                                                        <div class="validate-error">{{ $message }}</div>
                        @enderror --}}
                    </div>

                    <div class="col-md-6">
                        <div class="custom-control custom-switch custom-switch-md mt-3">
                            <input type="checkbox" value="1" name="review_priority"
                                   class="custom-control-input review" id="customSwitch1">
                            <label class="custom-control-label" for="customSwitch1">Send Critical Alert / Fatal</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="custom-control custom-switch custom-switch-md mt-3">
                            <input type="checkbox" value="" name="status"
                                   class="custom-control-input status" id="customSwitch2">
                            <label class="custom-control-label" for="customSwitch2">No Recording Found</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            <!-- /.card-footer-->

        </div>
        <!-- /.card -->
    </form>

@endsection
@section('scriptfiles')
    <script type='text/javascript' src="{{ asset('assets/plugins/timer/timer.jquery.min.js') }}"></script>
    <script type='text/javascript' src="{{ asset('assets/js/jquery.idle.js') }}"></script>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $(".qrating input").click(function percentage() {
                let percentage = 0;
                let total = {{ $points }};
                var na = 0;
                var checkedButtons = $("input:radio:checked")
                checkedButtons.each(function (chkdButton) {
                    if ($(this).val().indexOf("Na") >= 0) {
                        var na_value = $(this).val().split("Na-").pop()
                        na = na + parseInt(na_value);
                    } else {
                        percentage = parseInt(percentage) + parseInt($(this).val());
                    }

                });
                total = total - na;
                resultPercentage = (percentage / total) * 100;
                if (isNaN(resultPercentage)) {
                    $(".percentage").val(100);
                } else {
                    $(".percentage").val(Math.round(resultPercentage));
                }
            });
        });
        $(function () {
            //start a timer
            var timer = $('.timer');
            timer.timer({
                format: '%H:%M:%S'
            });
            $('.datepicker').datetimepicker({
                format: 'L',
                format: 'DD-MM-YYYY',
                keepInvalid: false
            });
            $('#agent').on('change', function () {
                var user_id = this.value;
                if (user_id != "") {
                    $.ajax({
                        url: `{{ route('main') }}/get-user-detail/${user_id}`,
                        type: 'GET',
                        dataType: 'json', // added data type
                        success: function (res) {
                            $("#reporting_id").val(res.reporting_id);
                            $("#reporting").val(res.reporting_to);
                        }
                    });
                }
            });
            $("#recording_duration").inputmask({
                mask: '99:99:99',
                placeholder: ' ',
                showMaskOnHover: false,
                showMaskOnFocus: false,
                onBeforePaste: function (pastedValue, opts) {
                    var processedValue = pastedValue;
                    //do something with it
                    return processedValue;
                }
            });
            $(document).ready(function() {
                $('#customSwitch2').click(function() {
                    if ($(this).is(':checked')) {
                        $('.no').prop('checked', true);
                        $('.status').val('no recording found').trigger('change');
                        $('#percentage').val(0);
                        $('#recording_duration').val('00:00:00');
                        $('#recording_link').val('N/A');
                        $('#notes').val('No Recording');
                        $('#outcome').val('rejected').trigger('change');
                        $('#agent_outcome').val('rejected').trigger('change');
                        $('#call_type').val('general').trigger('change');
                    } else {
                        $('.yes').prop('checked', true);
                        $('.status').val('evaluated').trigger('change');
                        $('#percentage').val(100);
                        $('#recording_duration').val('');
                        $('#recording_link').val('');
                        $('#notes').val('');
                        $('#outcome').val('').trigger('change');
                        $('#agent_outcome').val('').trigger('change');
                        $('#call_type').val('').trigger('change');
                    }
                });
            });
        });
    </script>

@endsection

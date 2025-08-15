<header>
    <style href={{ URL::asset('/css/style.css') }}></style>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-input.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</header>


<main>

    <div id="loadingOverlay"
        class="loading d-none w-100 h-100 d-flex justify-content-center align-items-center opacity-25 position-fixed top-0 end-0 bg-dark"
        style="pointer-events: all; z-index: 9999;">
        <div class="spinner-border text-white" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <span class="error"></span>
    <span class="success"></span>



    <div class="container">
        <div class="row bill_header border-bottom py-2">
            <div class=" col-md-12">
                <div class="d-flex justify-content-between align-content-center">
                    <div class="h4">
                        Bill Detail
                    </div>
                    <div class="col-3">
                        <div class="input-group">
                            <select class="form-select inline-select text-white text-uppercase" aria-label=""
                                id="status" disabled>
                                @foreach ($states as $state)
                                    <option value={{ $state }} @selected($bill['status'] == $state)>
                                        {{ $state }}</option>
                                @endforeach
                            </select>
                            <span class="input-group-text input-afterfix d-none">
                                <i class="fas fa-edit"></i>
                            </span>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="bill_content">
            <input type="hidden" name="id" id="id" value="{{ $bill['id'] }}">

            <div class="row mt-4">
                <div class="col-md-6 col-12 mt-2">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">Account Number</span>
                        <select class="form-select inline-select" aria-label="" id="account_number" disabled>
                            @foreach ($accountNumbers as $accountNumber)
                                <option value={{ $accountNumber }} @selected($bill['account_number'] == $accountNumber)>
                                    {{ $accountNumber }}</option>
                            @endforeach
                        </select>
                        <span class="input-group-text input-afterfix d-none">
                            <i class="fas fa-edit"></i>
                        </span>
                    </div>

                </div>
                <div class="col-md-6 col-12 mt-2">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">Order At</span>
                        <input type="date" class="form-control inline-date" name="ordered_at" id="ordered_at"
                            value="{{ \Carbon\Carbon::parse($bill['ordered_at'])->format('Y-m-d') }}" disabled>
                        <span class="input-group-text input-afterfix d-none">
                            <i class="fas fa-edit"></i>
                        </span>
                    </div>

                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-6 col-12 mt-2">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">Bill ID</span>
                        <input type="text" class="form-control inline-input" name="bill_id" id="bill_id"
                            value={{ $bill['bill_id'] }} disabled>
                        <span class="input-group-text input-afterfix d-none">
                            <i class="fas fa-edit"></i>
                        </span>
                    </div>
                </div>
                <div class="col-md-6 col-12 mt-2">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">Amount</span>
                        <input type="number" class="form-control inline-input" name="amount" id="amount"
                            value={{ $bill['amount'] }} disabled>
                        <span class="input-group-text input-afterfix d-none">
                            <i class="fas fa-edit"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-6 col-12 mt-2">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">Service</span>
                        <select class="form-select inline-select" aria-label="" id="service" disabled>
                            @foreach ($services as $service)
                                <option value="{{ $service }}" @selected($bill['service'] == $service)>
                                    {{ $service }}</option>
                            @endforeach
                        </select>
                        <span class="input-group-text input-afterfix d-none">
                            <i class="fas fa-edit"></i>
                        </span>
                    </div>

                </div>
                <div class="col-md-6 col-12 mt-2">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">Category</span>
                        <select class="form-select inline-select" aria-label="" id="category" disabled>
                            @foreach ($categories as $category)
                                <option value="{{ $category }}" @selected($bill['category'] == $category)>
                                    {{ $category }}</option>
                            @endforeach
                        </select>
                        <span class="input-group-text input-afterfix d-none">
                            <i class="fas fa-edit"></i>
                        </span>
                    </div>

                </div>
            </div>

            <div class="input-group form-floating mt-4">
                <textarea class="form-control inline-input" placeholder="Leave a comment here" id="comment" style="height: 100px"
                    disabled>{{ $bill['comment'] }}</textarea>
                <label for="comment">Comments</label>
                <span class="input-group-text input-afterfix d-none">
                    <i class="fas fa-edit"></i>
                </span>
            </div>

        </div>



    </div>

</main>

{{-- toast --}}
<button type="button" class="btn btn-primary d-none" id="liveToastBtn"></button>

<div class="toast-container position-fixed end-0 top-0 p-5">

    <div id="liveToast" class="toast align-items-center bg-success" role="alert" aria-live="assertive"
        aria-atomic="true" data-bs-delay="2000">
        <div class="d-flex">
            <div class="toast-body text-white">
                Hello, world! This is a toast message.
            </div>
            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                aria-label="Close"></button>
        </div>
    </div>
</div>


<script>
    var allowSave = true;
    // Lưu giá trị cũ khi trang load
    saveCurrentValue();

    $(document).on('click', '.input-group', function(e) {
        $(this).find('.input-afterfix').addClass('d-none')
        $(this).find('.inline-input, .inline-select, .inline-date').attr('disabled', null).focus();
    })

    $(document).on('mouseover', '.input-group', function(e) {
        if ($(this).find('.inline-input, .inline-select, .inline-date').prop('disabled')) {
            $(this).find('.input-afterfix').removeClass('d-none')
        }
    })
    $(document).on('mouseout', '.input-group', function(e) {
        $(this).find('.input-afterfix').addClass('d-none')
    })


    // unfocus -> save data
    $(document).on('keydown', '.inline-input', function(e) {
        if (e.key === 'Enter') {
            this.blur();
        }
    });

    // khi blur
    $(document).on('blur', '.inline-input', function() {
        const $e = $(this);
        $e.prop('disabled', true);
        save($e);
    });

    $(document).on('change blur', '.inline-select, .inline-date', function() {
        const $e = $(this);
        $e.prop('disabled', true);
        save($e);
    });

    // ajax update data
    function save($e) {

        const oldValue = String($e.data('oldValue') ?? '');
        const newValue = $.trim($e.val());
        if (newValue === oldValue) {
            return;
        }
        // $('#loadingOverlay').removeClass('d-none');
        if (!allowSave) {
            $e.val(oldValue);
            setTimeout(
                () => {
                    $('.error').text('')
                },
                2000
            )
            return;
        }
        const id = $('#id').val();
        let data = {};
        data[$e.attr('id')] = newValue;
        data['_token'] = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: '{{ route('bill.update', ['bill' => 'ID']) }}'.replace('ID', id),
            type: 'PATCH',
            data: data,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    showToast(response.message)
                } else {
                    showToast(response.message, 'bg-danger')
                }
            },
            error: function(xhr, status, error) {
                console.log('Error:', xhr.responseText);
                $('.error').text(xhr.responseText);
            },
        });
        $('#loadingOverlay').addClass('d-none');

        saveCurrentValue();
    }


    // Kiểm tra bill_id
    $('#bill_id').on('keyup change', function() {
        var billId = $(this).val();
        var excludeId = $('input[name="id"]').val() || '';
        if (billId.length === 0) {
            $('.error').text('');
            return;
        }
        $.ajax({
            url: '{{ route('bill.check') }}',
            type: 'POST',
            dataType: 'json',
            data: {
                bill_id: billId,
                exclude_id: excludeId,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (!response.success) {
                    $('.error').text(response.message);
                    allowSave = false;
                } else {
                    $('.error').text('');
                    allowSave = true;
                }
            },
            error: function() {
                console.log('Error checking bill ID');
            }
        });
    });

    function showToast(message, bgClass = 'bg-success', delay = 2000) {
        const $toast = $('#liveToast');
        $toast.removeClass('bg-success bg-danger bg-warning bg-info bg-primary bg-secondary bg-dark');
        $toast.addClass(bgClass + ' text-white');
        $toast.find('.toast-body').text(message);
        new bootstrap.Toast($toast[0], {
            delay
        }).show();
    }


    // Lưu giá trị cũ
    function saveCurrentValue() {
        $('.inline-input, .inline-select, .inline-date').each(function() {
            $(this).data('oldValue', $(this).val());
        });
    }


    const statusClasses = {
        'pending': 'bg-warning text-dark',
        'complete': 'bg-success text-white',
        'refund': 'bg-danger text-white',
        'processing': 'bg-info text-dark'
    };

    $('#status').on('change', function() {
        const $e = $(this);
        $e.removeClass().addClass('form-select inline-select text-uppercase');
        const val = $e.val();
        if (statusClasses[val]) {
            $e.addClass(statusClasses[val]);
        }
    }).trigger('change');
</script>

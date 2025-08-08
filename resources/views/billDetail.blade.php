<header>
    <style href={{ URL::asset('/css/style.css') }}></style>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
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
                        <div class="">
                            <select class="form-select inline-select text-white text-uppercase" aria-label=""
                                id="status">
                                @foreach ($states as $state)
                                    <option value={{ $state }} @selected($bill['status'] == $state)>
                                        {{ $state }}</option>
                                @endforeach
                            </select>
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
                        <select class="form-select inline-select" aria-label="" id="account_number">
                            @foreach ($accountNumbers as $accountNumber)
                                <option value={{ $accountNumber }} @selected($bill['account_number'] == $accountNumber)>
                                    {{ $accountNumber }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="col-md-6 col-12 mt-2">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">Order At</span>
                        <input type="date" class="form-control inline-date" name="ordered_at" id="ordered_at"
                            value="{{ \Carbon\Carbon::parse($bill['ordered_at'])->format('Y-m-d') }}">
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-6 col-12 mt-2">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">Bill ID</span>
                        <input type="text" class="form-control inline-input" name="bill_id" id="bill_id"
                            value={{ $bill['bill_id'] }}>
                    </div>
                </div>
                <div class="col-md-6 col-12 mt-2">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">Amount</span>
                        <input type="text" class="form-control inline-input" name="amount" id="amount"
                            value={{ $bill['amount'] }}>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-6 col-12 mt-2">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">Service</span>
                        <select class="form-select inline-select" aria-label="" id="service">
                            @foreach ($services as $service)
                                <option value="{{ $service }}" @selected($bill['service'] == $service)>
                                    {{ $service }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="col-md-6 col-12 mt-2">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">Categorie</span>
                        <select class="form-select inline-select" aria-label="" id="category">
                            @foreach ($categories as $category)
                                <option value="{{ $category }}" @selected($bill['category'] == $category)>
                                    {{ $category }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
            </div>

            <div class="form-floating mt-4">
                <textarea class="form-control inline-input" placeholder="Leave a comment here" id="comment" style="height: 100px">{{ $bill['comment'] }}</textarea>
                <label for="comment">Comments</label>
            </div>

        </div>



    </div>

</main>


<script>
    // Lưu giá trị cũ khi trang load
    $('.inline-input, .inline-select , .inline-date').each(function() {
        $(this).data('oldValue', $(this).val());
    });


    // $(document).on('keydown', '.inline-date', function(e) {
    //     if (e.key === 'Enter') {
    //         this.blur();
    //     }
    // });


    // Enter -> blur (để kích hoạt lưu)
    $(document).on('keydown', '.inline-input', function(e) {
        if (e.key === 'Enter') {
            this.blur();
        }
    });

    $(document).on('change', '.inline-date', function() {
        const $e = $(this);
        save($e);
    });

    // khi blur
    $(document).on('blur', '.inline-input', function() {
        const $e = $(this);
        save($e);
    });

    $(document).on('change', '.inline-select', function() {
        const $e = $(this);
        save($e);
    });

    function save($e) {
        const oldValue = String($e.data('oldValue') ?? '');
        const newValue = $.trim($e.val());
        if (newValue === oldValue) {
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
                    alert(response.message)

                } else {
                    alert(response.message)
                }
            },
            error: function(xhr, status, error) {
                console.log('Error:', xhr.responseText);
                $('.error').text(xhr.responseText);
            },
        });
    }


    const statusClasses = {
        'pending': 'bg-warning text-dark',
        'complete': 'bg-success text-white',
        'refund': 'bg-danger text-white',
        'processing': 'bg-info text-dark'
    };

    $('#status').on('change', function() {
        const $sel = $(this);
        $sel.removeClass().addClass('form-select inline-select text-uppercase');
        const val = $sel.val();
        if (statusClasses[val]) {
            $sel.addClass(statusClasses[val]);
        }
    }).trigger('change');
</script>

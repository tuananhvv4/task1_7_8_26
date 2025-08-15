<?php

?>

@if ($archived)
    <h2>Archived Items</h2>
@else
    <h2>Bill List</h2>
@endif


<header>
    <style href={{ URL::asset('/css/style.css') }}></style>
    <link rel="stylesheet" href="{{ asset('css/popover.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-input.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</header>

<span class="error"></span>
<span class="success"></span>




<div class="action">

    <?php if ($archived == 1): ?>
    <a href="?archived=0" class="btn btn-secondary btn-sm">View bill list</a>
    <?php else: ?>
    <a href="?archived=1" class="btn btn-secondary btn-sm">View archived bills</a>
    <?php endif; ?>

    <?php if ($archived == 1): ?>
    <a href="javascript:void(0)" id="unArchive" class="btn btn-primary btn-sm">Unarchive</a>
    <?php else: ?>
    <a href="<?= route('bill.create') ?>" class="btn btn-primary btn-sm">Add New Bill</a>
    <a href="javascript:void(0)" id="archive" class="btn btn-primary btn-sm">Archive</a>
    <?php endif; ?>
    <button class="btn btn-success btn-sm" id="btnOpenModal">Mass Update</button>
</div>



<?php if (!empty($bills)): ?>
<div>
    <table id="myTable" class="table row-border compact hover" style="width:100%">
        <thead class="table-light">
            <tr>
                <!-- 8 col -->
                <th> <input type="checkbox" id="selectAll"> </th>
                <th>Account Number</th>
                <th>Bill ID</th>
                <th>Service</th>
                <th>Amount</th>
                <th>Payment Status</th>
                <th>Category</th>
                <th>Action</th>
            </tr>
            <tr class="filter">
                <th></th>
                <th>
                    <div class="input-group input-group-table mb-3 position-relative">
                        <input type="text" class="form-control input-filter" placeholder=""
                            aria-label="Example text with button addon" aria-describedby="button-addon1"
                            data-field="account_number">

                        <button class="btn button-filter" type="button" id="button-addon1" data-field="account_number">
                            <i class="bi bi-funnel-fill"></i>
                        </button>

                        <!-- Popover Filter (ẩn mặc định) -->
                        <div class="filter-popover d-none" data-field="account_number">
                            <div class="popover-title p-1">Account Number Filter</div>
                            <div class="popover-list" data-field="account_number">
                                <label class="d-flex p-1"><input type="checkbox"
                                        class="form-check-input checkbox-filter me-2 check-all-filter"
                                        data-field="account_number" checked>
                                    (Select
                                    All)</label>


                            </div>
                            <div class="popover-actions px-2 py-1 d-flex justify-content-between align-items-center">
                                <button class="btn btn-outline-secondary btn-sm applyFilter"
                                    data-field="account_number">Apply</button>
                                <button class="btn btn-outline-secondary btn-sm clearFilter"
                                    data-field="account_number">Clear Filter</button>
                            </div>
                        </div>
                    </div>

                </th>
                <th>
                    <div class="input-group input-group-table mb-3 position-relative">

                        <input type="text" class="form-control input-filter" placeholder=""
                            aria-label="Example text with button addon" aria-describedby="button-addon2"
                            data-field="bill_id">
                        <button class="btn button-filter" type="button" id="button-addon2" data-field="bill_id"><i
                                class="bi bi-funnel-fill"></i></button>

                        <div class="filter-popover d-none" data-field="bill_id">
                            <div class="popover-title p-1">Bill ID Filter</div>
                            <div class="popover-list" data-field="bill_id">
                                <label class="d-flex p-1"><input type="checkbox"
                                        class="form-check-input checkbox-filter me-2 check-all-filter"
                                        data-field="bill_id" checked>
                                    (Select
                                    All)</label>

                            </div>
                            <div class="popover-actions px-2 py-1 d-flex justify-content-between align-items-center">
                                <button class="btn btn-outline-secondary btn-sm applyFilter"
                                    data-field="bill_id">Apply</button>
                                <button class="btn btn-outline-secondary btn-sm clearFilter" data-field="bill_id">Clear
                                    Filter</button>
                            </div>
                        </div>
                    </div>
                </th>
                <th>
                    <div class="input-group input-group-table mb-3">

                        <input type="text" class="form-control input-filter" placeholder=""
                            aria-label="Example text with button addon" aria-describedby="button-addon3"
                            data-field="service">
                        <button class="btn" type="button" id="button-addon3"><i
                                class="bi bi-funnel-fill"></i></button>
                    </div>
                </th>
                <th>
                    <div class="input-group input-group-table mb-3">

                        <input type="text" class="form-control input-filter" placeholder=""
                            aria-label="Example text with button addon" aria-describedby="button-addon4"
                            data-field="amount">
                        <button class="btn" type="button" id="button-addon4"><i
                                class="bi bi-funnel-fill"></i></button>
                    </div>
                </th>
                <th>
                    <div class="input-group input-group-table mb-3">

                        <input type="text" class="form-control input-filter" placeholder=""
                            aria-label="Example text with button addon" aria-describedby="button-addon5"
                            data-field="status">
                        <button class="btn" type="button" id="button-addon5"><i
                                class="bi bi-funnel-fill"></i></button>
                    </div>
                </th>
                <th>
                    <div class="input-group input-group-table mb-3">

                        <input type="text" class="form-control input-filter" placeholder=""
                            aria-label="Example text with button addon" aria-describedby="button-addon6"
                            data-field="category">
                        <button class="btn" type="button" id="button-addon6"><i
                                class="bi bi-funnel-fill"></i></button>
                    </div>
                </th>
                <th></th>
            </tr>

        </thead>
        {{-- <tbody>
            <?php foreach ($bills as $row): ?>

            <tr>
                <td> <input type="checkbox" class="itemCheckbox" id="<?= $row['id'] ?>"></td>
                <td><span class="text-data w-100 d-block" data-id="{{ $row['id'] }}"
                        data-field="account_number"><?= $row['account_number'] ?></span>
                    <select class="inline-select form-select d-none" data-id={{ $row['id'] }}
                        data-field="account_number" id="{{ 'account_number' . $row['id'] }}">
                        @foreach ($accountNumbers as $accountNumber)
                            <option value="{{ $accountNumber }}" @selected($row['account_number'] == $accountNumber)>
                                {{ $accountNumber }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <span class="text-data w-100 d-block" data-id="{{ $row['id'] }}"
                        data-field="bill_id"><?= $row['bill_id'] ?></span>
                    <input type="text" class="form-control inline-input d-none" aria-describedby="basic-addon1"
                        data-id={{ $row['id'] }} data-field="bill_id" id="{{ 'bill_id' . $row['id'] }}"
                        value="{{ $row['bill_id'] }}">
                </td>
                <td><span class="text-data w-100 d-block" data-id="{{ $row['id'] }}"
                        data-field="service"><?= $row['service'] ?></span>
                    <select class="inline-select form-select d-none" data-id={{ $row['id'] }} data-field="service"
                        id="{{ 'service' . $row['id'] }}">
                        @foreach ($services as $service)
                            <option value="{{ $service }}" @selected($row['service'] == $service)>
                                {{ $service }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <span class="text-data w-100 d-block" data-id="{{ $row['id'] }}"
                        data-field="amount"><?= $row['amount'] ?></span>
                    <input type="number" class="form-control inline-input d-none" aria-describedby="basic-addon1"
                        data-id={{ $row['id'] }} data-field="amount" id="{{ 'amount' . $row['id'] }}"
                        value="{{ $row['amount'] }}">
                </td>
                <td>
                    <span class="text-data w-100 d-block" data-id="{{ $row['id'] }}"
                        data-field="status"><?= $row['status'] ?></span>
                    <select class="inline-select form-select d-none" data-id={{ $row['id'] }} data-field="status"
                        id="{{ 'status' . $row['id'] }}">
                        @foreach ($states as $state)
                            <option value={{ $state }} @selected($row['status'] == $state)>
                                {{ $state }}</option>
                        @endforeach
                    </select>
                </td>
                <td><span class="text-data w-100 d-block" data-id="{{ $row['id'] }}"
                        data-field="category"><?= $row['category'] ?></span>
                    <select class="inline-select form-select d-none" data-id={{ $row['id'] }} data-field="category"
                        id="{{ 'category' . $row['id'] }}">
                        @foreach ($categories as $category)
                            <option value={{ $category }} @selected($row['category'] == $category)>
                                {{ $category }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <a href="{{ route('bill.show', ['bill' => $row['id']]) }}"
                        class="btn btn-sm btn-secondary">Detail</a>
                    <a id="edit" class=" btn btn-sm btn-primary"
                        href="{{ route('bill.edit', ['bill' => $row['id']]) }}">Edit</a>

                    <a href="javascript:void(0);" class="delete-btn btn btn-sm btn-danger"
                        data-id="{{ $row['id'] }}">Delete</a>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody> --}}

    </table>


</div>
<?php else: ?>
<p>No bills found!</p>
<?php endif; ?>

{{-- Mass update modal --}}
<div class="modal" tabindex="-1" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Mass Update</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalBody">
                <p>Select Field To Update For Selected Bill</p>
                <div class="update-content">

                    <div class="row ">
                        <div class="col-12 mt-4">
                            <div class="input-group">
                                <div class="input-group-text mx-1">
                                    <input class="check-input-update mt-0" type="checkbox" value=""
                                        aria-label="Checkbox for following text input" data-field="account_number">
                                </div>
                                <span class="input-group-text" id="basic-addon1">Account Number</span>
                                <select class="form-select" aria-label="" id="account_number">
                                    <option value=""></option>
                                    @foreach ($accountNumbers as $accountNumber)
                                        <option value={{ $accountNumber }}>
                                            {{ $accountNumber }}</option>
                                    @endforeach
                                </select>
                                <span class="input-group-text input-afterfix d-none">
                                    <i class="fas fa-edit"></i>
                                </span>
                            </div>

                        </div>
                        <div class="col-12 mt-4">
                            <div class="input-group">
                                <div class="input-group-text mx-1">
                                    <input class="check-input-update mt-0" type="checkbox" value=""
                                        aria-label="Checkbox for following text input" data-field="ordered_at">
                                </div>
                                <span class="input-group-text" id="basic-addon1">Order At</span>
                                <input type="date" class="form-control" name="ordered_at" id="ordered_at">
                                <span class="input-group-text input-afterfix d-none">
                                    <i class="fas fa-edit"></i>
                                </span>
                            </div>

                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-12 mt-4">
                            <div class="input-group">
                                <div class="input-group-text mx-1">
                                    <input class="check-input-update mt-0" type="checkbox" value=""
                                        aria-label="Checkbox for following text input" data-field="amount">
                                </div>
                                <span class="input-group-text" id="basic-addon1">Amount</span>
                                <input type="number" class="form-control" name="amount" id="amount">
                                <span class="input-group-text input-afterfix d-none">
                                    <i class="fas fa-edit"></i>
                                </span>
                            </div>
                        </div>

                        <div class="col-12 mt-4">
                            <div class="input-group">
                                <div class="input-group-text mx-1">
                                    <input class="check-input-update mt-0" type="checkbox" value=""
                                        aria-label="Checkbox for following text input" data-field="status">
                                </div>
                                <span class="input-group-text" id="basic-addon1">Status</span>
                                <select class="form-select" aria-label="" id="status">
                                    <option value=""></option>
                                    @foreach ($states as $state)
                                        <option>
                                            {{ $state }}</option>
                                    @endforeach
                                </select>
                                <span class="input-group-text input-afterfix d-none">
                                    <i class="fas fa-edit"></i>
                                </span>
                            </div>

                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-12 mt-4">
                            <div class="input-group">
                                <div class="input-group-text mx-1">
                                    <input class="check-input-update mt-0" type="checkbox" value=""
                                        aria-label="Checkbox for following text input" data-field="service">
                                </div>
                                <span class="input-group-text" id="basic-addon1">Service</span>
                                <select class="form-select" aria-label="" id="service">
                                    <option value=""></option>
                                    @foreach ($services as $service)
                                        <option>
                                            {{ $service }}</option>
                                    @endforeach
                                </select>
                                <span class="input-group-text input-afterfix d-none">
                                    <i class="fas fa-edit"></i>
                                </span>
                            </div>

                        </div>
                        <div class="col-12 mt-4">
                            <div class="input-group">
                                <div class="input-group-text mx-1">
                                    <input class="check-input-update mt-0" type="checkbox" value=""
                                        aria-label="Checkbox for following text input" data-field="category">
                                </div>
                                <span class="input-group-text" id="basic-addon1">Category</span>
                                <select class="form-select" aria-label="" id="category">
                                    <option value=""></option>
                                    @foreach ($categories as $category)
                                        <option>
                                            {{ $category }}</option>
                                    @endforeach
                                </select>
                                <span class="input-group-text input-afterfix d-none">
                                    <i class="fas fa-edit"></i>
                                </span>
                            </div>

                        </div>
                    </div>

                    <div class="input-group mt-4">
                        <div class="input-group-text mx-1">
                            <input class="check-input-update mt-0" type="checkbox" value=""
                                aria-label="Checkbox for following text input" data-field="comment">
                        </div>
                        <div class="form-floating flex-grow-1">
                            <textarea class="form-control" placeholder="Leave a comment here" id="comment" style="height: 100px"></textarea>
                            <label for="comment">Comment</label>
                        </div>
                        <span class="input-group-text input-afterfix d-none">
                            <i class="fas fa-edit"></i>
                        </span>
                    </div>


                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="massUpdateBtn">Update</button>
            </div>
        </div>
    </div>
</div>


{{-- toast --}}
<button type="button" class="btn btn-primary d-none" id="liveToastBtn"></button>

<div class="toast-container position-fixed end-0 top-0 p-5">

    <div id="liveToast" class="toast align-items-center bg-success" role="alert" aria-live="assertive"
        aria-atomic="true" data-bs-delay="2000">
        <div class="d-flex">
            <div class="toast-body text-white">
                toast message.
            </div>
            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                aria-label="Close"></button>
        </div>
    </div>
</div>

{{-- <button type="button" class="btn btn-danger" data-bs-toggle="popover" title="Button Popover Heading"
    data-bs-content="Button Popover Content here">
    Open Popover - Click Me
</button>

<script>
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
    var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl)
    })
</script> --}}




<script></script>


<script>
    // khởi tạo biến toàn cục lấy từ php
    window.inlineOptionMap = {
        account_number: @json($accountNumbers),
        service: @json($services),
        category: @json($categories),
        status: @json($states),
    };
</script>


<script>
    function buildSelect(field, currentValue, id) {
        const options = (window.inlineOptionMap?.[field] ?? []);
        const htmlOpts = options.map(opt => {
            const selected = (String(opt) === String(currentValue)) ? 'selected' : '';
            return `<option value="${opt}" ${selected}>${opt}</option>`;
        }).join('');
        return `<select class="inline-select form-select" data-id="${id}" data-field="${field}" data-type="select">${htmlOpts}</select>`;
    }

    function buildInput(field, currentValue, id, type) {
        return `<input class="inline-input form-control" data-id="${id}" data-field="${field}" data-type="${type}" type="${type}" value="${currentValue}">`;
    }

    function buildEditor($span) {
        const id = $span.data('id');
        const field = $span.data('field');
        const inputType = $span.data('type').toLowerCase();
        const value = $span.text().trim();

        if (inputType === 'select') {
            return buildSelect(field, value, id);
        }
        if (inputType === 'number') {
            return buildInput(field, value, id, 'number');
        }
        // default text
        return buildInput(field, value, id, 'text');
    }

    $(document).on('click', '.text-data', function() {
        const $span = $(this);
        $span.addClass('d-none')
        var $input = $(buildEditor($span))
        $span.after($input)
        $input.focus()
    })
</script>


<script>
    var allowSave = true;
    // chờ load xong thì lưu giá trị ban đầu của input
    $(document).ready(function() {
        setTimeout(function() {
            saveCurrentValue();
        }, 1000)
    })

    // Enter -> blur 
    $(document).on('keydown', '.inline-input', function(e) {
        if (e.key === 'Enter') {
            this.blur();
        }
    });

    // khi blur
    $(document).on('blur', '.inline-input', function() {

        const $e = $(this);
        const oldValue = String($e.prev().data('oldValue') ?? '');
        const newValue = $.trim($e.val());
        console.log(oldValue + " -  " + newValue)
        save($e, oldValue, newValue);

    });

    $(document).on('change blur', '.inline-select', function() {
        const $e = $(this);
        const oldValue = String($e.prev().data('oldValue') ?? '');

        const newValue = $.trim($e.val());
        console.log(oldValue + " -  " + newValue)
        save($e, oldValue, newValue);

    });

    // thực hiện update dữ liệu
    function save($e, oldValue, newValue) {

        var id = $e.data('id');
        $(`span[data-id=${id}]`).removeClass('d-none')
        $e.addClass('d-none');
        if (newValue === oldValue || newValue == "") {
            return;
        }

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

        let data = {};
        data[$e.data('field')] = newValue;
        data['_token'] = $('meta[name="csrf-token"]').attr('content');
        $(`span[data-id=${id}][data-field=${$e.data('field')}]`).text(newValue);

        $.ajax({
            url: '{{ route('bill.update', ['bill' => 'ID']) }}'.replace('ID', id),
            type: 'PATCH',
            data: data,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    console.log('ok')
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
        saveCurrentValue()
    }

    // Kiểm tra bill_id
    $(document).on('keyup change', 'input[data-field="bill_id"].inline-input', function() {
        var billId = $(this).val();
        var excludeId = $(this).data('id') || '';
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
        console.log("saved")
        $('.text-data').each(function() {
            $(this).data('oldValue', $(this).text());
        });
    }
</script>


<script>
    $(document).ready(function() {
        var table = $('#myTable').DataTable({
            lengthMenu: [2, 5, 10, 25, 50, 100, 1000],
            columnDefs: [{
                    orderable: false,
                    targets: [0]

                },
                {
                    className: 'dt-center',
                    targets: '_all'
                },
            ],
            targets: 'no-sort',
            bSort: false,
            order: [],
            processing: true,
            // serverSide: true,
            ajax: {
                url: "{{ route('bill.filter') }}",
                method: "POST",
                data: function(d) {
                    d.ids = filterIds;
                    d._token = $('meta[name="csrf-token"]').attr('content');
                    d.account_number = $('.input-filter[data-field="account_number"]').val();
                    d.bill_id = $('.input-filter[data-field="bill_id"]').val();
                    d.service = $('.input-filter[data-field="service"]').val();
                    d.amount = $('.input-filter[data-field="amount"]').val();
                    d.status = $('.input-filter[data-field="status"]').val();
                    d.category = $('.input-filter[data-field="category"]').val();
                    return d;
                },

                dataSrc: "data"
            },
            columns: [{
                    data: null,
                    render: function(data, type, row) {
                        return `<input type="checkbox" class="itemCheckbox" data-id="${row.id ?? ''}">`;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `<span class="text-data w-100 d-block" data-id="${row['id']}"
                        data-field="account_number" data-type="select">${row['account_number']}</span>`;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `<span class="text-data w-100 d-block" data-id="${row['id']}"
                        data-field="bill_id" data-type="text">${row['bill_id']}</span>`;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `<span class="text-data w-100 d-block" data-id="${row['id']}"
                        data-field="service" data-type="select">${row['service']}</span>`;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `<span class="text-data w-100 d-block" data-id="${row['id']}"
                        data-field="amount" data-type="number">${row['amount']}</span>`;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `<span class="text-data w-100 d-block" data-id="${row['id']}"
                        data-field="status" data-type="select">${row['status']}</span>`;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `<span class="text-data w-100 d-block" data-id="${row['id']}"
                        data-field="category" data-type="select">${row['category']}</span>`;
                    }
                },
                {
                    data: null,
                    searchable: false,
                    render: function(data, type, row) {
                        const id = row.id ?? '';
                        return `
          <a href="${`{{ route('bill.show', ['bill' => '___ID___']) }}`.replace('___ID___', id)}" class="btn btn-sm btn-secondary">Detail</a>
          <a href="${`{{ route('bill.edit', ['bill' => '___ID___']) }}`.replace('___ID___', id)}" class="btn btn-sm btn-primary">Edit</a>
          <a href="javascript:void(0);" class="delete-btn btn btn-sm btn-danger" data-id="${id}">Delete</a>
        `;
                    }
                }
            ],

        });
        // load dữ liệu vào popover khi bảng làm mới
        table.on('xhr.dt', function(e, settings, json, xhr) {

            $('.popover-list').each(function() {
                const field = $(this).data('field');
                const listContainer = $(this);
                listContainer.find('label:not(:first)')
                    .remove(); // Xoá các checkbox cũ trừ dòng Select All

                // Lặp qua json.data để tạo checkbox
                json.data.forEach(item => {
                    const checkbox = `
            <label class="d-flex p-1 fw-normal">
                <input type="checkbox" class="form-check-input checkbox-filter me-2" data-id="${item.id}" data-field="${field}" value="${item[field]}" checked>
                ${item[field]}
            </label>`;
                    listContainer.append(checkbox);
                });
            });

        });
        // danh sách id được lọc
        var filterIds = [];

        // xác định bảng filter khi click vào nút lọc
        $(document).on('click', '.button-filter', function() {
            const field = $(this).data('field');
            console.log(field);
            // Mở đóng popover tương ứng với nút được click
            $(this).closest('.input-group').find('.filter-popover').toggleClass('d-none');
            // đóng popover khác nếu có
            $('.filter-popover').not($(this).closest('.input-group').find('.filter-popover')).addClass(
                'd-none');
        })

        // ẩn bảng filter khi click ra ngoài
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.input-group').length) {
                $('.filter-popover').addClass('d-none');
            }
        });

        // nút check all filter
        $('.check-all-filter').on('change', function() {
            console.log('click all')
            const $field = $(this).data('field');
            $('.popover-list').find('input.checkbox-filter[data-field="' + $field + '"]').not(
                '.check-all-filter').prop(
                'checked', this.checked);
        });

        //select item trong filter
        $(document).on('change', '.checkbox-filter:not(.check-all-filter)', function() {
            const $list = $(this).closest('.popover-list');
            const field = $(this).data('field');

            // Tất cả item trong list (loại bỏ check-all )
            const $items = $list.find('input.checkbox-filter:not(.check-all-filter)');
            const total = $items.length;
            const checked = $items.filter(':checked').length;

            const allChecked = total > 0 && checked === total;

            const $checkAll = $('input.check-all-filter[data-field="' + field + '"]');
            $checkAll.prop('checked', allChecked);
        });


        // Apply filter
        $('.applyFilter').on('click', function() {
            const field = $(this).data('field');
            filterIds = [];
            const $popover = $(this).closest('.filter-popover');
            const $selectAll = $popover.find('input.check-all-filter[data-field="' + field + '"]');
            $popover.find('input.checkbox-filter[data-field="' + field + '"]').not(".check-all-filter")
                .each(function() {
                    if ($(this).prop('checked')) {
                        filterIds.push($(this).data('id'));
                    }
                })

            console.log(filterIds);
            // reset input check all
            $selectAll.prop('checked', true);
            reloadTable()

        });

        // Clear filter
        $('.clearFilter').on('click', function() {
            const field = $(this).data('field');
            const $popover = $(this).closest('.filter-popover');
            const $selectAll = $popover.find('input.check-all-filter[data-field="' + field + '"]');
            // reset input check all
            $selectAll.prop('checked', true);
            filterIds = [];
            reloadTable()
        });


        // reload bảng khi filter thay đổi
        $('.input-filter').keyup(function() {
            reloadTable()
        })

        function reloadTable() {
            table.ajax.reload();
        }

        // lưu trữ
        $("#archive").click(function() {
            var ids = [];
            table.$('.itemCheckbox:checked').each(function() {
                ids.push(this.id);
            });
            if (ids.length === 0) {
                alert("No bills selected!");
                return;
            }
            if (!confirm("Archive the selected bills?")) {
                return;
            }
            $.ajax({
                url: "{{ route('bill.archive') }}",
                type: "POST",
                data: {
                    ids: ids,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response) {
                    if (response.success) {
                        // console.log(response);
                        alert("Bill archived successfully!");
                        location.reload();
                    } else {
                        $('.error').text(response.message);
                    }
                },
                error: function() {
                    alert("Something went wrong while archiving.");
                }
            });
        });
        // hủy lưu trữ
        $("#unArchive").click(function() {
            var ids = [];
            table.$('.itemCheckbox:checked').each(function() {
                ids.push(this.id);
            });
            if (ids.length === 0) {
                alert("Chưa chọn hóa đơn nào!");
                return;
            }
            if (!confirm("Hủy lưu trữ các hóa đơn đã chọn?")) {
                return;
            }
            $.ajax({
                url: "{{ route('bill.archive') }}",
                type: "POST",
                data: {
                    ids: ids,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response) {
                    if (response.success) {
                        alert("Bill unArchived successfully!");
                        location.reload();
                    } else {
                        $('.error').text(response.message);
                    }
                },
                error: function() {
                    alert("Something went wrong while unarchiving.");
                }
            });
        });

        // check all
        $("#selectAll").on("change", function() {
            var checked = $(this).prop("checked");

            // table.cells(null, 0).every(function() {
            //     var cell = this.node();
            //     $(cell)
            //         .find(".itemCheckbox")
            //         .prop("checked", checked);
            // });

            table.rows({
                search: 'applied'
            }).every(function() {
                // Lấy ô ở cột 0 của từng hàng ( hàm cell() truyền vào hàng và cột cần xác định )
                // node() lấy DOM element của element đã chọn
                var cell = table.cell(this, 0).node();
                $(cell).find(".itemCheckbox").prop("checked", checked);
            });

        });

        $(document).on("change", ".itemCheckbox", function() {
            var countSelected = table
                .rows(function(idx, data, node) {
                    return $(node).find(".itemCheckbox").prop("checked");
                })
                .count();

            $("#selectAll").prop("checked", table.rows().count() === countSelected);
        });
        // xóa bill
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            if (!confirm('Confirm delete?')) {
                return;
            }
            $.ajax({
                url: "{{ route('bill.destroy', '') }}/" + id,
                type: "DELETE",
                dataType: 'json',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        location.reload();
                    } else {
                        $('.error').text(response.message);
                    }
                },
                error: function() {
                    $('.error').text('Something went wrong while deleting.');
                }
            });
        });

        $(document).on('click', '#btnOpenModal', function() {
            // Pass bill id into modal
            var ids = [];
            table.$('.itemCheckbox:checked').each(function() {
                ids.push(this.id);
            });
            if (ids.length === 0) {
                alert("No bills selected!");
                return;
            }
            // Open modal
            const modalElement = document.getElementById('myModal');
            const modal = new bootstrap.Modal(modalElement);
            modal.show();
        });

        // mass update
        $(document).on('click', '#massUpdateBtn', function() {
            // Pass bill id 
            var ids = [];
            table.$('.itemCheckbox:checked').each(function() {
                ids.push(this.id);
            });
            if (ids.length === 0) {
                alert("No bills selected!");
                return;
            }

            let dataField = {};
            dataField['ids'] = ids;
            dataField['_token'] = $('meta[name="csrf-token"]').attr('content');

            console.log(dataField)

            $(".check-input-update").each(function() {
                if ($(this).prop('checked')) {
                    var field = $(this).data('field');
                    dataField[field] = $(`#${field}`).val();
                }
            })

            $.ajax({
                url: '{{ route('bill.massupdate') }}',
                type: 'PATCH',
                data: dataField,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        alert(response.message)
                        location.reload();
                    } else {
                        alert(response.message)
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Error:', xhr.responseText);
                    $('.error').text(xhr.responseText);
                },
            });

        });
    });
</script>

@extends('dashboard.master')
@section('title')
    مدرسة ليرن | صفحة الرئيسية للمعلمين
@stop
@section('content')
    <main class="page-content">


        <div class="modal fade" id="import-modal" tabindex="-1" aria-labelledby="stagesModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="stagesModalLabel">اضافة مادة جديدة</h5>
                        <button type="button" class="btn-close ms-0" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                    </div>
                    <form method="post" action="{{ route('dash.student.import') }}" enctype="multipart/form-data"
                        id="importForm">
                        <div class="modal-body">
                            <div class="container">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="mb-4 form-group">
                                    <label> ملف الاكسل </label>
                                    <input name="excel" type="file" class="form-control">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer mb-3">
                            <button class="btn btn-outline-success col-12" type="submit">اضافة</button>
                            <button type="button" class="btn btn-outline-secondary col-12 mb-3"
                                data-bs-dismiss="modal">إغلاق</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- add modal --}}
        <div class="modal fade" id="add-modal" tabindex="-1" aria-labelledby="stagesModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="stagesModalLabel">اضافة مادة جديدة</h5>
                        <button type="button" class="btn-close ms-0" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                    </div>
                    <form method="post" action="{{ route('dash.student.add') }}" enctype="multipart/form-data"
                        id="add-form" class="add-form">
                        <div class="modal-body">

                            <div class="container">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <div class="mb-4 form-group">
                                    <label>اسم الطالب الاول</label>
                                    <input name="first_name" class="form-control" placeholder="اسم اطالب الاول">
                                    <div class="invalid-feedback"></div>
                                </div>

                                <div class="mb-4 form-group">
                                    <label>اسم الطالب الاخير</label>
                                    <input name="last_name" class="form-control" placeholder="اسم الطالب الاخير">
                                    <div class="invalid-feedback"></div>
                                </div>

                                <div class="mb-4 form-group">
                                    <label>البريد الالكتروني</label>
                                    <input name="email" class="form-control" placeholder=" البريد الالكتروني">
                                    <div class="invalid-feedback"></div>
                                </div>

                                <div class="mb-4 form-group">
                                    <label>تاريخ الميلاد</label>
                                    <input name="date_of_birth" type="date" class="form-control">
                                    <div class="invalid-feedback"></div>
                                </div>

                                <div class="mb-4 form-group">
                                    <label>الجنس</label>
                                    <select name="gender" class="form-control">
                                        <option selected disabled> اختر الجنس</option>
                                        <option value="m">ذكر</option>
                                        <option value="fm">أنثى</option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>

                                <div class="mb-4 form-group">
                                    <label>اسم ولي الامر </label>
                                    <input name="parent_name" class="form-control" placeholder="اسم  ولي الامر">
                                    <div class="invalid-feedback"></div>
                                </div>

                                <div class="mb-4 form-group">
                                    <label>رقم جوال ولي الامر </label>
                                    <input name="parent_phone" class="form-control" placeholder="رقم جوال ولي الامر ">
                                    <div class="invalid-feedback"></div>
                                </div>

                                <div class="mb-4 form-group">
                                    <label>المرحلة الدراسية</label>
                                    <select name="grade" class="form-control">
                                        <option selected disabled> اختر المرحلة الدراسية</option>
                                        @foreach ($grades as $g)
                                            <option value="{{ $g->id }}">{{ $g->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>


                                <div class="mb-4 form-group">
                                    <label>الشعبة الدراسية</label>
                                    <select name="section" class="form-control">
                                        <option selected disabled> اختر الشعبة الدراسية</option>
                                        @foreach ($sections as $s)
                                            <option value="{{ $s->id }}">{{ $s->name }} الشعبة</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer mb-3">
                            <button class="btn btn-outline-success col-12" type="submit">اضافة</button>
                            <button type="button" class="btn btn-outline-secondary col-12 mb-3"
                                data-bs-dismiss="modal">إغلاق</button>
                        </div>
                    </form>
                </div>


            </div>
        </div>
        {{-- ///////////////////////////////////////// --}}


        {{-- update modal --}}
        <div class="modal fade" id="update-modal" tabindex="-1" aria-labelledby="stagesModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="stagesModalLabel">تعديل المعلم </h5>
                        <button type="button" class="btn-close ms-0" data-bs-dismiss="modal"
                            aria-label="إغلاق"></button>
                    </div>
                    <form method="post" action="{{ route('dash.teacher.update') }}" id="update-form"
                        class="update-form">
                        <div class="modal-body">

                            <div class="container">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="id" id="id">
                                <div class="mb-4 form-group">
                                    <label>الاسم الكامل</label>
                                    <input name="name" id="name" class="form-control"
                                        placeholder="الاسم الكامل">
                                </div>
                                <div class="mb-4 form-group">
                                    <label> البريد الالكتروني</label>
                                    <input name="email" id="email" type="email" class="form-control"
                                        placeholder="البريد الالكتروني">
                                    <div class="invalid-feedback"></div>

                                </div>
                                <div class="mb-4 form-group">
                                    <label>رقم الهاتف</label>
                                    <input name="phone" id="phone" class="form-control" placeholder="رقم الهاتف">
                                    <div class="invalid-feedback"></div>

                                </div>
                                <div class="mb-4 form-group">
                                    <label>التخصص الجامعي</label>
                                    <input name="spec" id="spec" class="form-control"
                                        placeholder="التخصص الجامعي">
                                    <div class="invalid-feedback"></div>

                                </div>
                                <div class="mb-4 form-group">
                                    <label>المؤهل العلمي</label>
                                    <select name="qual" id="qual" class="form-control">
                                        <option selected disabled>اخترالمؤهل العلمي</option>
                                        <option value="d">دبلوم </option>
                                        <option value="b"> بكلوريوس</option>
                                        <option value="m">ماجستير </option>
                                        <option value="dr"> دكتوراه</option>
                                    </select>
                                    <div class="invalid-feedback"></div>

                                </div>
                                <div class="mb-4 form-group">
                                    <label>الجنس</label>
                                    <select name="gender" id="gender" class="form-control">
                                        <option selected disabled>اختر الجنس</option>
                                        <option value="m">ذكر </option>
                                        <option value="fm">انثى</option>
                                    </select>
                                    <div class="invalid-feedback"></div>

                                </div>
                                <div class="mb-4 form-group">
                                    <label>الحالة</label>
                                    <select name="status" id="status" class="form-control">
                                        <option selected disabled>اختر الحالة</option>
                                        <option value="active">مفعل </option>
                                        <option value="inactive">معطل</option>
                                    </select>
                                    <div class="invalid-feedback"></div>

                                </div>
                                <div class="mb-4 form-group">
                                    <label>تاريخ التعيين</label>
                                    <input name="hire_date" id="hire_date" type="date" class="form-control">
                                    <div class="invalid-feedback"></div>

                                </div>

                                <div class="mb-4 form-group">
                                    <label>تاريخ الميلاد</label>
                                    <input name="date_of_birth" id="date_of_birth" type="date" class="form-control">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer mb-3">
                            <button class="btn btn-outline-info col-12" type="submit">تعديل</button>
                            <button type="button" class="btn btn-outline-secondary col-12 mb-3"
                                data-bs-dismiss="modal">إغلاق</button>
                        </div>
                    </form>
                </div>


            </div>
        </div>


        <div class="row">
            <div class="col-12 col-lg-12 col-xl-12 d-flex">
                <div class="card radius-10 w-100">
                    <div class="card-header bg-transparent">
                        <div class="row g-3 align-items-center">
                            <div class="col">
                                <h5 class="mb-0">جميع المواد الدراسية</h5>
                            </div>
                            <div class="col">
                                <div class="d-flex align-items-center justify-content-end gap-3 cursor-pointer">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <button class="btn btn-primary col-12 btn-add mb-2" data-bs-toggle="modal"
                            data-bs-target="#add-modal">
                            اضافة طالب جديد
                        </button>

                        <button class="btn btn-primary col-12 btn-add mb-2" data-bs-toggle="modal"
                            data-bs-target="#import-modal">
                            اضافة عبر الاكسل
                        </button>

                        <button href="{{ route('dash.student.export') }}" class="btn btn-primary col-12 mb-2" id="exportBtn">
                            تصدير اكسل
                        </button>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-12 col-lg-12 col-xl-12 d-flex">
                <div class="card radius-10 w-100">
                    <div class="card-header bg-transparent">
                        <div class="row g-3 align-items-center">
                            <div class="col">
                                <h5 class="mb-0">جميع المواد</h5>
                            </div>
                            <div class="col">
                                <div class="d-flex align-items-center justify-content-end gap-3 cursor-pointer">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>الاسم الاول</th>
                                        <th>الاسم الاخير</th>
                                        <th>البريد الالكتروني</th>
                                        <th>الجنس</th>
                                        <th>تاريخ الميلاد</th>
                                        <th>اسم ولي الامر</th>
                                        <th>رقم جوال ولي الامر</th>
                                        <th>الصف</th>
                                        <th>الشعبة</th>
                                        <th>العمليات</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
@stop
@section('js')
    <script>
        /*





                                */
        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,

            ajax: {
                url: "{{ route('dash.student.getdata') }}"
            },

            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                },

                {
                    data: 'first_name',
                    name: 'first_name',
                    title: 'الاسم الاول',
                    orderable: true,
                    searchable: true,
                },

                {
                    data: 'last_name',
                    name: 'last_name',
                    title: 'الاسم الاخير',
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'email',
                    name: 'email',
                    title: 'البريد الاكتروني',
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'gender',
                    name: 'gender',
                    title: 'الجنس',
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'date_of_birth',
                    name: 'date_of_birth',
                    title: 'تاريخ الميلاد',
                    orderable: false,
                    searchable: false,
                },

                {
                    data: 'parent_name',
                    name: 'parent_name',
                    title: 'اسم ولي الامر',
                    orderable: false,
                    searchable: false,
                },

                {
                    data: 'parent_phone',
                    name: 'parent_phone',
                    title: 'رقم جوال ولي الامر',
                    orderable: false,
                    searchable: false,
                },

                {
                    data: 'grade',
                    name: 'grade',
                    title: 'الصف',
                    orderable: false,
                    searchable: false,
                },
                {
                    data: 'section',
                    name: 'section',
                    title: 'الشعبة',
                    orderable: false,
                    searchable: false,
                },
                {
                    data: 'action',
                    name: 'action',
                    title: 'العمليات',
                    orderable: false,
                    searchable: false,
                },

            ],

            language: {
                url: "{{ asset('datatable_custom/i18n/ar.json') }}",
            }
        });




        $(document).ready(function() {
            $(document).on('click', '.update_btn', function(e) {
                e.preventDefault();
                var button = $(this);
                var name = button.data('name');
                var email = button.data('email');
                var phone = button.data('phone');
                var qual = button.data('qual');
                var spec = button.data('spec');
                var gender = button.data('gender');
                var status = button.data('status');
                var date_of_birth = button.data('date-of-birth');
                var hire_date = button.data('hire-date');
                var id = button.data('id');

                $('#name').val(name);
                $('#email').val(email);
                $('#phone').val(phone);
                $('#gender').val(gender);
                $('#qual').val(qual);
                $('#spec').val(spec);
                $('#status').val(status);
                $('#date_of_birth').val(date_of_birth);
                $('#hire_date').val(hire_date);
                $('#id').val(id);
            });
        });

        $('#importForm').on('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: '{{ route('dash.student.import') }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    toastr.success(response.success);
                    $('#import-modal').modal('hide');
                    $('#importForm').trigger('reset');
                    table.draw();
                },
                error: function(e) {

                    toastr.error('حدث خطأ أثناء رفع الملف.');

                }
            });
        });


        $('#exportBtn').on('click', function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route('dash.student.export') }}',
                method: 'GET',
                success: function(response) {
                    toastr.success(response.success);
                    table.draw();
                    // window.location.href = response.file_url;
                    $('<iframe>', {
                src: response.file_url,
                style: 'display:none;'
            }).appendTo('body');
                },
                error: function() {
                    toastr.error('حدث خطأ أثناء تصدير الملف.');
                }
            });
        });




        $(document).ready(function() {
            $(document).on('click', '.active-btn', function(e) {
                e.preventDefault();
                var button = $(this);
                var id = button.data('id');
                var url = button.data('url');
                swal({
                    title: "هل أنت متأكد من العملية ؟",
                    text: "سيتم تفعيل العنصر المعطل .",
                    icon: "warning",
                    buttons: {
                        cancel: {
                            text: "إلغاء",
                            value: null,
                            visible: true,
                            className: "custom-cancel-btn",
                            closeModal: true,
                        },
                        confirm: {
                            text: "احذف",
                            value: true,
                            visible: true,
                            className: "custom-confirm-btn",
                            closeModal: true,
                        },
                    },
                    dangerMode: false,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: url,
                            type: "post",
                            data: {
                                id: id,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(res) {
                                toastr.success(res.success)
                                table.draw();
                            },
                        });
                    } else {
                        toastr.error('تم الغاء عملية التفعيل')
                    }
                });
            })
        });
    </script>




@stop

@extends('dashboard.master')
@section('title')
    مدرسة ليرن | صفحة الرئيسية للمعلمين
@stop
@section('content')
    <main class="page-content">

        {{-- add modal --}}
        <div class="modal fade" id="add-modal" tabindex="-1" aria-labelledby="stagesModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="stagesModalLabel">اضافة معلم جديد</h5>
                        <button type="button" class="btn-close ms-0" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                    </div>
                    <form method="post" action="{{ route('dash.teacher.add') }}" id="add-form" class="add-form">
                        <div class="modal-body">

                            <div class="container">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="mb-4 form-group">
                                    <label>الاسم الكامل</label>
                                    <input name="name" class="form-control" placeholder="الاسم الكامل">
                                    <div class="invalid-feedback"></div>

                                </div>
                                <div class="mb-4 form-group">
                                    <label> البريد الالكتروني</label>
                                    <input name="email" type="email" class="form-control"
                                        placeholder="البريد الالكتروني">
                                    <div class="invalid-feedback"></div>


                                </div>
                                <div class="mb-4 form-group">
                                    <label>رقم الهاتف</label>
                                    <input name="phone" class="form-control" placeholder="رقم الهاتف">
                                    <div class="invalid-feedback"></div>

                                </div>
                                <div class="mb-4 form-group">
                                    <label>التخصص الجامعي</label>
                                    <input name="spec" class="form-control" placeholder="التخصص الجامعي">
                                    <div class="invalid-feedback"></div>

                                </div>
                                <div class="mb-4 form-group">
                                    <label>المؤهل العلمي</label>
                                    <select name="qual" class="form-control">
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
                                    <select name="gender" class="form-control">
                                        <option selected disabled>اختر الجنس</option>
                                        <option value="m">ذكر </option>
                                        <option value="fm">انثى</option>
                                    </select>
                                    <div class="invalid-feedback"></div>

                                </div>
                                <div class="mb-4 form-group">
                                    <label>تاريخ التعيين</label>
                                    <input name="hire_date" type="date" class="form-control">
                                    <div class="invalid-feedback"></div>

                                </div>

                                <div class="mb-4 form-group">
                                    <label>تاريخ الميلاد</label>
                                    <input name="date_of_birth" type="date" class="form-control">
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
                        <button type="button" class="btn-close ms-0" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                    </div>
                    <form method="post" action="{{ route('dash.teacher.update') }}" id="update-form" class="update-form">
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
                                <h5 class="mb-0"> التصفية</h5>
                            </div>
                            <div class="col">
                                <div class="d-flex align-items-center justify-content-end gap-3 cursor-pointer">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4 mb-3">
                                <input type="text" id="search-name" class="form-control search-input" placeholder="اسم المعلم ">
                            </div>
                            <div class="col-md-4 mb-3">
                                <input type="email" id="search-email" class="form-control search-input"
                                    placeholder="البريد الإلكتروني">
                            </div>
                            <div class="col-md-4 mb-3">
                                <input type="text" id="search-phone" class="form-control  search-input" placeholder="رقم الجوال">
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2 mb-3">
                            <button type="submit" id="search-btn" class="btn btn-outline-success col-6">بحث</button>
                            <button type="reset" id="clear-btn" class="btn btn-outline-secondary col-6 ">تنظيف</button>
                        </div>

                        <button class="btn btn-outline-primary col-12 btn-add" data-bs-toggle="modal"
                            data-bs-target="#add-modal">
                            اضافة معلم
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
                                <h5 class="mb-0">جميع المعلمين</h5>
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
                                        <th>الاسم</th>
                                        <th>البريد الالكتروني</th>
                                        <th>رقم الهاتف</th>
                                        <th>تاريخ الميلاد </th>
                                        <th>تاريخ التعيين</th>
                                        <th>الجنس</th>
                                        <th>التخصص الجامعي</th>
                                        <th>المؤهل العلمي</th>
                                        <th>الحالة</th>
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
        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,

            ajax: {
                url: "{{ route('dash.teacher.getdata') }}",
                data: function(n) {
                    n.name = $('#search-name').val();
                    n.email = $('#search-email').val();
                    n.phone = $('#search-phone').val();
                }
            },

            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                },

                {
                    data: 'name',
                    name: 'name',
                    title: 'الاسم',
                    orderable: true,
                    searchable: true,
                },

                {
                    data: 'email',
                    name: 'email',
                    title: 'البريد الالكتروني',
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'phone',
                    name: 'phone',
                    title: 'رقم الهاتف',
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'date_of_birth',
                    name: 'date_of_birth',
                    title: 'تاريخ الميلاد',
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'hire_date',
                    name: 'hire_date',
                    title: 'تاريخ التعيين',
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
                    data: 'spec',
                    name: 'spec',
                    title: 'التخصص الجامعي',
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'qual',
                    name: 'qual',
                    title: 'المؤهل العلمي',
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'status',
                    name: 'status',
                    title: 'الحالة',
                    orderable: true,
                    searchable: true,
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

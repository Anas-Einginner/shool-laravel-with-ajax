@extends('dashboard.master')
@section('title')
    مدرسة ليرن | صفحة الرئيسية للمحاضرات
@stop
@section('content')
    <main class="page-content">

        {{-- add modal --}}
        <div class="modal fade" id="add-modal" tabindex="-1" aria-labelledby="stagesModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="stagesModalLabel">اضافة محاضرة جديد</h5>
                        <button type="button" class="btn-close ms-0" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                    </div>
                    <form method="post" action="{{ route('dash.teacher.lecture.add') }}" id="add-form" class="add-form">
                        <div class="modal-body">

                            <div class="container">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <div class="mb-4 form-group">
                                    <label> عنوان المحاضرة</label>
                                    <input name="title" class="form-control" placeholder="عنوان المحاضرة">
                                    <div class="invalid-feedback"></div>

                                </div>
                                <div class="mb-4 form-group">
                                    <label>وصف الحاضرة</label>
                                    <input name="desc" type="text" class="form-control" placeholder="وصف الحاضرة">
                                    <div class="invalid-feedback"></div>


                                </div>

                                <div class="mb-4 form-group">
                                    <label>رابط الماحضرة</label>
                                    <input name="link" type="url" class="form-control" placeholder="رابط المحاضرة">
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
                    <form method="post" action="{{ route('dash.teacher.lecture.update') }}" id="update-form" class="update-form">
                        <div class="modal-body">

                            <div class="container">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="id" id="id">
                                <div class="mb-4 form-group">
                                    <label> عنوان المحاضرة</label>
                                    <input name="title" id="title" class="form-control" placeholder="عنوان المحاضرة">
                                    <div class="invalid-feedback"></div>

                                </div>
                                <div class="mb-4 form-group">
                                    <label>وصف الحاضرة</label>
                                    <input name="desc" id="desc" type="text" class="form-control"
                                        placeholder="وصف الحاضرة">
                                    <div class="invalid-feedback"></div>


                                </div>

                                <div class="mb-4 form-group">
                                    <label>رابط الماحضرة</label>
                                    <input name="link" id="link" type="url" class="form-control"
                                        placeholder="رابط المحاضرة">
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
                            <div class="col-md-6 mb-3">
                                <input type="text" id="search-title" class="form-control search-input"
                                    placeholder="العنوان">
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="text" id="search-desc" class="form-control search-input"
                                    placeholder="الوصف">
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2 mb-3">
                            <button type="submit" id="search-btn" class="btn btn-outline-success col-6">بحث</button>
                            <button type="reset" id="clear-btn" class="btn btn-outline-secondary col-6 ">تنظيف</button>
                        </div>

                        <button class="btn btn-outline-primary col-12 btn-add" data-bs-toggle="modal"
                            data-bs-target="#add-modal">
                            اضافة محاضرة
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
                                <h5 class="mb-0">جميع المحاضرات</h5>
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
                                        <th>العنوان</th>
                                        <th>الوصف</th>
                                        <th>رابط المحاضرة</th>
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
                url: "{{ route('dash.teacher.lecture.getdata') }}",
                data: function(n) {
                    n.title = $('#search-title').val();
                    n.desc = $('#search-desc').val();
                }
            },

            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                },

                {
                    data: 'title',
                    name: 'title',
                    title: 'العنوان',
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'desc',
                    name: 'desc',
                    title: 'الوصف',
                    orderable: true,
                    searchable: true,
                },

                {
                    data: 'link',
                    name: 'link',
                    title: 'رابط المحاضرة',
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
                 var title = button.data('title');
                 var desc = button.data('desc');
                 var link = button.data('link');
                 var id = button.data('id');

                 $('#title').val(title);
                 $('#desc').val(desc);
                 $('#link').val(link);
                 $('#id').val(id);
             });
         });
    </script>




@stop

@extends('dashboard.master')
@section('title')
    مدرسة ليرن | صفحة الرئيسية للمعلمين
@stop
@section('content')
    <main class="page-content">

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
                                        <th>عنوان</th>
                                        <th>المدة</th>
                                        <th>بداية الاختبار</th>
                                        <th>نهاية الاختبار</th>
                                        <th>العلامة النهائية</th>
                                        <th>عدد الاسئلة</th>
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
                url: "{{ route('dash.teacher.quizz.getdata') }}",
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
                    data: 'title',
                    name: 'title',
                    title: 'العنوان',
                    orderable: true,
                    searchable: true,
                },

                {
                    data: 'time',
                    name: 'time',
                    title: 'المدة',
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'start',
                    name: 'start',
                    title: 'بداية الاختبار',
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'end',
                    name: 'end',
                    title: 'نهاية الاختبار',
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'score',
                    name: 'score',
                    title: 'العلامة النهائية',
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'count_q',
                    name: 'count_q',
                    title: 'عدد الاسئلة',
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




    </script>




@stop

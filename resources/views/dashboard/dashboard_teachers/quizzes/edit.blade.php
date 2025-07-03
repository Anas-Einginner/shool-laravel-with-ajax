@extends('dashboard.master')
@section('title')
    تعديل الاختبار
@stop

@section('content')
<main class="page-content">
    <div class="row">
        <div class="col-12 col-lg-12 col-xl-12 d-flex">
            <div class="card radius-10 w-100">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0">تعديل الاختبار: {{ $quizz->title }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('dash.teacher.quizz.update', $quizz->id) }}" method="POST" id="quiz-form">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">عنوان الاختبار</label>
                            <input type="text" class="form-control" name="title" value="{{ $quizz->title }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">مدة الاختبار (دقائق)</label>
                                <input type="number" class="form-control" name="duration" value="{{ $quizz->time }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">تاريخ البدء</label>
                                <input type="datetime-local" class="form-control" name="start_time" value="{{ \Carbon\Carbon::parse($quizz->start)->format('Y-m-d\TH:i') }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">تاريخ الانتهاء</label>
                                <input type="datetime-local" class="form-control" name="end_time" value="{{ \Carbon\Carbon::parse($quizz->end)->format('Y-m-d\TH:i') }}" required>
                            </div>
                        </div>

                        <hr>

                        <div id="questions-container">
                            @foreach ($quizz->questions as $qIndex => $question)
                                <div class="card question-card" id="question-{{ $qIndex }}">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5>السؤال رقم {{ $qIndex + 1 }}</h5>
                                    </div>

                                    <input type="hidden" name="questions[{{ $qIndex }}][id]" value="{{ $question->id }}">

                                    <div class="mb-3">
                                        <label class="form-label">📝 نص السؤال</label>
                                        <input type="text" class="form-control" name="questions[{{ $qIndex }}][text]" value="{{ $question->text }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">📂 نوع السؤال</label>
                                        <select class="form-select question-type" name="questions[{{ $qIndex }}][type]" data-index="{{ $qIndex }}" required>
                                            <option value="msq" {{ $question->type === 'msq' ? 'selected' : '' }}>اختيار من متعدد</option>
                                            <option value="tf" {{ $question->type === 'tf' ? 'selected' : '' }}>صح أو خطأ</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">🎯 عدد العلامات</label>
                                        <input type="number" class="form-control" name="questions[{{ $qIndex }}][grade]" value="{{ $question->grade }}" required>
                                    </div>

                                    <div class="options-box {{ $question->type === 'msq' ? '' : 'd-none' }}" id="options-{{ $qIndex }}">
                                        <label class="form-label">📋 الخيارات</label>
                                        @foreach ($question->options as $oIndex => $option)
                                            <input type="text" class="form-control mb-2" name="questions[{{ $qIndex }}][options][]" value="{{ $option->text }}" required>
                                        @endforeach

                                        <label class="form-label mt-2">✅ رقم الإجابة الصحيحة</label>
                                        <input type="number" class="form-control correct-option" name="questions[{{ $qIndex }}][correct_option]" value="{{ $question->correctAnswer && $question->correctAnswer->option_id ? ($question->options->search(fn($opt) => $opt->id === $question->correctAnswer->option_id) + 1) : '' }}">
                                    </div>

                                    <div class="true-false-box {{ $question->type === 'tf' ? '' : 'd-none' }}" id="true-false-{{ $qIndex }}">
                                        <label class="form-label">✅ الإجابة الصحيحة</label>
                                        <select class="form-select" name="questions[{{ $qIndex }}][correct_tf]">
                                            <option value="">-- اختر --</option>
                                            <option value="1" {{ $question->correctAnswer && $question->correctAnswer->correct_value == 1 ? 'selected' : '' }}>✔️ صح</option>
                                            <option value="0" {{ $question->correctAnswer && $question->correctAnswer->correct_value == 0 ? 'selected' : '' }}>❌ خطأ</option>
                                        </select>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button type="button" class="btn btn-outline-primary col-12 mt-3" id="add-question-btn">➕ إضافة سؤال</button>

                        <hr>

                        <button type="submit" class="btn btn-success col-12">💾 حفظ التعديلات</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('js')
<script>
    let questionIndex = {{ count($quizz->questions) }};

    function getQuestionHTML(index) {
        return `
        <div class="card question-card" id="question-${index}">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5>السؤال رقم ${index + 1}</h5>
                <button type="button" class="btn btn-danger btn-sm remove-question" data-index="${index}">✖ حذف</button>
            </div>

            <div class="mb-3">
                <label class="form-label">📝 نص السؤال</label>
                <input type="text" class="form-control" name="questions[${index}][text]" required>
            </div>

            <div class="mb-3">
                <label class="form-label">📂 نوع السؤال</label>
                <select class="form-select question-type" name="questions[${index}][type]" data-index="${index}" required>
                    <option value="">-- اختر نوع السؤال --</option>
                    <option value="msq">اختيار من متعدد</option>
                    <option value="tf">صح أو خطأ</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">🎯 عدد العلامات</label>
                <input type="number" class="form-control" name="questions[${index}][grade]" min="1" value="1" required>
            </div>

            <div class="options-box d-none" id="options-${index}">
                <label class="form-label">📋 الخيارات</label>
                <input type="text" class="form-control mb-2" name="questions[${index}][options][]" placeholder="الخيار 1">
                <input type="text" class="form-control mb-2" name="questions[${index}][options][]" placeholder="الخيار 2">
                <input type="text" class="form-control mb-2" name="questions[${index}][options][]" placeholder="الخيار 3">
                <input type="text" class="form-control mb-2" name="questions[${index}][options][]" placeholder="الخيار 4">

                <label class="form-label mt-2">✅ رقم الإجابة الصحيحة</label>
                <input type="number" class="form-control correct-option" name="questions[${index}][correct_option]" min="1" max="4">
            </div>

            <div class="true-false-box d-none mt-3" id="true-false-${index}">
                <label class="form-label">✅ الإجابة الصحيحة</label>
                <select class="form-select" name="questions[${index}][correct_tf]">
                    <option value="">-- اختر --</option>
                    <option value="1">✔️ صح</option>
                    <option value="0">❌ خطأ</option>
                </select>
            </div>
        </div>`;
    }

    $(document).ready(function () {
        $('#add-question-btn').click(function () {
            $('#questions-container').append(getQuestionHTML(questionIndex));
            questionIndex++;
        });

        $(document).on('change', '.question-type', function () {
            let index = $(this).data('index');
            let type = $(this).val();

            $(`#options-${index}`).addClass('d-none');
            $(`#true-false-${index}`).addClass('d-none');

            if (type === 'msq') {
                $(`#options-${index}`).removeClass('d-none');
            } else if (type === 'tf') {
                $(`#true-false-${index}`).removeClass('d-none');
            }
        });

        $(document).on('click', '.remove-question', function () {
            let index = $(this).data('index');
            $(`#question-${index}`).remove();
        });
    });
</script>
@endsection

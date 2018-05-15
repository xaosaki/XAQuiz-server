@foreach ($answers as $answer)
    <div class="form-group">
        <input type="checkbox" class="form-trigger" id="answer_{{$answer->id}}" name="answer[]" value="{{$answer->id}}"
                @foreach($quiz_answers as $quiz_answer)
                    @if($quiz_answer['answer_id'] === $answer->id) checked @endif
                @endforeach

                @if($is_completed)
                    disabled
                @endif
        >
        <label for="answer_{{$answer->id}}">{{ $answer->text }}</label>
    </div>
@endforeach
@if (count($errors) > 0 || session()->has('message_error'))
    <div class="errors alert alert-danger">
        <div>
            <h4>Ошибка!</h4>
            <ul>
                @if (session()->has('message_error'))
                    <li>{!! nl2br(session()->pull('message_error')) !!}</li>
                @endif
                @if (count($errors) > 0)
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
@elseif (session()->has('message_success'))
    <div class="alert alert-success">
        <p>{!! nl2br(session()->pull('message_success')) !!}</p>
    </div>
@endif
<script>
    setTimeout(function() {
        $('.alert').addClass('hide');
    }, 10000);
</script>
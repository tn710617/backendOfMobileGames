@if(count($errors))
    <div class="alert alert-danger col-12" style="margin: 0 auto;">
        <ul>
            @foreach($errors->all() as $error)
                <li>
                    {{ $error }}
                </li>
            @endforeach
        </ul>
    </div>
@endif


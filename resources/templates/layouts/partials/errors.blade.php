<div>
    @foreach($errors->all() as $error)
                        <div class="alert alert-danger" role="alert">
                                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                            <span class="sr-only">Error:</span>
                            <strong>{{ $error }}</strong>
                        </div>
    @endforeach
</div>
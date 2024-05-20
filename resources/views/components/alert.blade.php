@if (session()->has('sucess'))
<div class="alert alert-success">
    {{ session('sucess') }}

</div>
@endif
<!-- add -->

@if (session()->has('Updated'))
<div class="alert alert-success">
    {{ session('Updated') }}

</div>
@endif <!-- edit -->

@if (session()->has('info'))
<div class="alert alert-success">
    {{ session('info') }}

</div>
@endif
<!-- alredy token -->
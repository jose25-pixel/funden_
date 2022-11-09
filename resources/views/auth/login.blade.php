@extends('auth.contenido')

@section('login')
<style>
  body{
    background-color:#c7bb98; 
  }
</style>
<div class="row justify-content-center ">
      <div class="col-md-8  ">
        <div class="card-group mb-0  ">
          <div class="card p-4  "style="border-radius:5px 0px 0px 5px;background-color:#F8F8FF">
          <form class="form-horizontal was-validate" method="POST" action="{{route('login')}}">
            {{ csrf_field() }}
            <div class="card-body">
              <h1>Acceder</h1>
              <p class="text-muted">Control de acceso al sistema</p>
              <div class="form-group mb-3 {{ $errors->has('usuario' ? 'is-invalid' : '')}}">
                <span class="input-group-addon"><i class="icon-user"></i></span>
                <input type="text" value="{{old('usuario')}}" name="usuario" id="usuario" class="form-control" placeholder="Usuario">
                {!!$errors->first('usuario'.'<span class="invalid-feedback">:message</span>')!!}
            </div>
              <div class="form-group mb-4 {{ $errors->has('password' ? 'is-invalid' : '')}}">
                <span class="input-group-addon"><i class="icon-lock"></i></span>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                {!!$errors->first('password'.'<span class="invalid-feedback">:message</span>')!!}
              </div>
              <div class="row">
                <div class="col-6 center">
                  <button type="submit" class="btn btn-dark px-4">Acceder</button>
                </div>
              </div>
            </div>
          </form>
          </div>
          <div class="card text-secondary bg-dark py-5 d-md-down-none" style="width:44%;border-radius:0px 5px 5px 0px;">
            <div class="card-body text-center">
              <div>
                <h2>Fundación para el Desarrollo Latinoaméricano</h2>
                <p>Distribución,donación y venta de medicamentos a comunidades.</p>
              </div>
              <div class="imagen">
              <img src="img/logo_fundel.png" alt="" style="width: 170px;">
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>

@endsection
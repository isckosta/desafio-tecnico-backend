@extends('layouts.default')

@section('conteudo')
<br>
<div class="col-8 m-auto">
  <form name="formCard" id="formCard" method="POST" action="{{url('categorias/listar')}}">
    {!! csrf_field() !!}
    <fieldset>
      <legend> Categorias - Cadastrar</legend>
      <div class="form-group">
        <label for="Name" class="form-label mt-4">Nome</label>
        <input type="text" id="name" name="name" class="form-control" placeholder="Digite o nome da categoria" value="" required>
      </div>
      <div class="form-group">
        <label for="description" class="form-label mt-4">Descrição</label>
        <textarea class="form-control" id="description" name="description" rows="3" value="">
                </textarea>
      </div>
    </fieldset>
    <div class="d-grid gap-2">
      <br>
      <button class="btn btn-primary btn-lg">Cadastrar</button>
    </div>
  </form>
</div>
@stop
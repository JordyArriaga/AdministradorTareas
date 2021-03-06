@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row ">
        <div class="col-md-8">
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
            @if(session()->has('warning'))
                <div class="alert alert-warning">
                    {{ session()->get('warning') }}
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nueva tarea</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <!---->
                <form method="POST" action="{{ route('NuevaTarea') }}" >
                    @csrf
                    @method('POST')
                    {{ csrf_field() }}
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label class="col-form-label col-form-label-lg">Nombre<span style="color:red">*</span></label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" name="nombre" class="form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }} form-control-lg" autocomplete="off" placeholder="Ingresa el nombre de la tarea">
                            @if ($errors->has('nombre'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('nombre') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label  class="col-form-label col-form-label-lg">Descripción<span style="color:red">*</span></label> 
                        </div>
                        <div class="col-sm-9">
                            <textarea class="form-control{{ $errors->has('descripcion') ? ' is-invalid' : '' }} form-control-lg" name="descripcion"></textarea>
                            @if ($errors->has('descripcion'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('descripcion') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Tarea</button>
                    </div>   
                </div>    
                </form>
                <!---->
            </div>
          </div>
        </div>
        <div class="col-sm-4">
            <div class="card text-black bg-info mb-3" style="max-width: 18rem;">
                <div class="card-header">Tareas por hacer</div>
                <div class="card-body">
                    <div class="card border-black mb-3" style="max-width: 18rem;">
                         @php
                            $bandera = 0;
                        @endphp
                        @if($tareas != null)
                            @foreach($tareas as $tarea)
                                @if($tarea->Estado == 0)
                                    @php
                                        $bandera = 1;
                                    @endphp
                                    <div class="card-header">
                                        {{$tarea->Nombre}}
                                    </div>
                                    
                                    <div class="card-body text-black">
                                        <h5 class="card-title">{{$tarea->Descripcion}}</h5>
                                        <center><div class="row">
                                            <form method="POST" action="{{ route('EmpezarTarea', $tarea->id) }}" >
                                                @csrf
                                                @method('PUT')
                                                {{ csrf_field() }}
                                                <button class="btn btn-success btn-sm" title="Empezar">
                                                    <i class="fas fa-trash">Empezar</i>
                                                </button>
                                            </form>
                                            <label> . </label>
                                            <form style="display: inline;" action="{{route('EliminarTarea', $tarea->id)}}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro de eliminar la tarea seleccionada?')"  title="Eliminar">
                                                    <i class="fas fa-trash">Eliminar</i>
                                                </button>
                                            </form>
                                            
                                        </div></center>
                                    </div>
                                @endif
                            @endforeach
                        @else
                            <div class="card-header">Aun no agregas tareas</div>
                            @php
                                $bandera = 1;
                            @endphp
                            <div class="card-body text-black">
                                <h5 class="card-title"> <center> Haz clic en el botón para agregar una tarea </center> </h5>
                            </div>
                        @endif
                        @if($bandera == 0)
                            <div class="card-header">No tienes tareas nuevas</div>
                            <div class="card-body text-black">
                                <h5 class="card-text"> <center> Haz clic en el botón para agregar una tarea </center> </h5>
                            </div>
                        @endif
                    </div>
                    <div class="">
                        <button type="button" class="btn btn-outline-dark" data-toggle="modal" data-target="#exampleModal">Nueva tarea</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-4"> 
            <div class="card text-black bg-warning mb-3" style="max-width: 18rem;">
                <div class="card-header">Tareas en proceso</div>
                <div class="card-body">
                    <div class="card border-warning mb-3" style="max-width: 18rem;">
                        @php
                            $bandera = 0;
                        @endphp
                        @if($tareas != null)
                            @foreach($tareas as $tarea)
                                @if($tarea->Estado == 1)
                                    @php
                                        $bandera = 1;
                                    @endphp
                                    <div class="card-header">{{$tarea->Nombre}}</div>
                                    <div class="card-body text-black">
                                        <h5 class="card-title">{{$tarea->Descripcion}}</h5>
                                        <form method="POST" action="{{ route('EmpezarTarea', $tarea->id) }}" >
                                            @csrf
                                            @method('PUT')
                                            {{ csrf_field() }}
                                            <button class="btn btn-success btn-sm" title="Empezar">
                                                <i class="fas fa-trash">Completar</i>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                        @if($bandera == 0)
                            <div class="card-header">Aun no empiezas una tarea</div>
                            <div class="card-body text-back">
                                <h5 class="card-title" > <center> Haz clic en el botón empezar de una tarea por hacer </center> </h5>
                            </div>
                        @endif
                    </div>
                </div>
            </div>    
        </div>
        <div class="col-sm-4">
            <div class="card text-black bg-success mb-3" style="max-width: 18rem;">
                <div class="card-header">Tareas realizadas</div>
                <div class="card-body">
                    <div class="card border-success mb-3" style="max-width: 18rem;">
                        @php
                            $bandera = 0;
                        @endphp
                        @if($tareas != null)
                            @foreach($tareas as $tarea)
                                @if($tarea->Estado == 2)
                                    @php
                                        $bandera = 1;
                                    @endphp
                                    <div class="card-header">{{$tarea->Nombre}}</div>
                                    <div class="card-body text-black">
                                        <h5 class="card-title">{{$tarea->Descripcion}}</h5>
                                        <form style="display: inline;" action="{{route('EliminarTarea', $tarea->id)}}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-info btn-sm" title="Ocultar">
                                                    <i class="fas fa-trash">Ocultar</i>
                                                </button>
                                            </form>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                        @if($bandera == 0)
                            <div class="card-header">Aun no terminas ninguna tarea</div>
                            <div class="card-body text-back">
                                <h5 class="card-title" > <center> Termina algunas tarea en proceso y se veran aquí </center> </h5>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

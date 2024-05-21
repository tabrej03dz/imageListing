@extends('backend.layout.root', ['title' => 'Website Visits'])

@section('content')
    <div class="row justify-content-between my-2">
        <div class="col-md-3">
            <h6 class="m-0 font-weight-bold text-primary">Visits </h6>
        </div>
        <div class="col-md-4">
            <form action="{{route('visits')}}" method="get"
                  class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                @csrf
                <div class="input-group">
                    <input type="date" name="date" class="form-control bg-light border-1 small" placeholder="Search for..."
                           aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>

            <li class="nav-item dropdown no-arrow d-sm-none">
                <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-search fa-fw"></i>
                </a>
                <!-- Dropdown - Messages -->
                <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                     aria-labelledby="searchDropdown">
                    <form action="{{route('visits')}}" method="get" class="form-inline mr-auto w-100 navbar-search">
                        @csrf
                        <div class="input-group">
                            <input type="date" name="date" class="form-control bg-light border-0 small"
                                   placeholder="Search for..." aria-label="Search"
                                   aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>
        </div>
        <div class="col-md-1">
            <a href="{{route('visits')}}" class="btn btn-primary p-1">Reset</a>
        </div>
        <div class="col-md-2">
        <a href="{{route('clearVisits')}}" class="btn btn-danger" onclick="
            confirm('Are you sure to clear records older than three days');
        ">Clear Records</a>

        </div>

    </div>
    <table class="table table-bordered" >
        <thead>
        <tr>
            <th class="p-1">#</th>
            <th class="p-1">IP Address</th>
            <th class="p-1">User Agent</th>
            <th class="p-1">Full URL</th>
            <th class="p-1">Time</th>
        </tr>
        </thead>
        <tbody>
        @foreach($visits as $visit)

            <tr class="small">
                <td class="p-1">{{$loop->iteration}}</td>
               <td class="p-1">{{$visit->ip_address}}</td>
               <td class="p-1">{{$visit->user_agent}}</td>
               <td class="p-1">{{$visit->url}}</td>
                <td class="p-1">{{$visit->created_at->format('d-m-Y H:i:s')}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

@extends('layouts.master')


@section('content')
<div class="container">
    <div class="row">
        <form action="" method="POST" class="col-lg-8 offset-2 p-5 my-5 border bg-white" enctype="multipart/form-data" style="border-radius: 10px;">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <h1>Education</h1>
                </div>
            </div>

            @for ($i = 0; $i < 4; $i++)
                
            <div class="row my-3">

                <div class="col-lg-4">
                    <input type="text" name="qualification" placeholder="Qualification" class="form-control" />
                </div>

                <div class="col-lg-4">
                    <input type="text" class="form-control" name="school" placeholder="School" />
                </div>

                <div class="col-lg-2">
                    <input type="date" class="form-control" name="start_date" placeholder="Start Date" />
                </div>

                <div class="col-lg-2">
                    <input type="date" class="form-control" name="end_date" placeholder="Start Date" />
                </div>
              
            </div>
            @endfor

        </form>
    </div>
   </div>
@endsection

<!-- resources/views/employee.blade.php -->

@extends('layouts.app')

@section('title', 'Home')

@section('content')

    @if(session()->has('success'))
        <div class="container alert-container">
            <div class="alert alert-success" role="alert">
                <strong>Success!</strong> Data successfully saved!
            </div>
        </div>
    @endif
     <!-- ----------------- SECTION-IMPORT-EMPLOYEES-HTML-START ----------------- -->

     <section class="import-employees-section">
        <div class="container">
            <div class="import-employees-container">
                <div class="container">
                    <form class="form" action="/" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="file-upload-wrapper" data-text="Select your file!">
                            <input name="employees" type="file" class="file-upload-field" value="">
                            <input class="submit" type="submit" value="Upload">
                        </div>
                    </form>
                  </div>
            </div>

            @if ($errors->any())
                <div class="container alert-container">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">
                                <strong>Error!</strong>
                                {{ $error }}
                            </div>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </section>

    <!-- ----------------- SECTION-IMPORT-EMPLOYEES-HTML-END ----------------- -->


    <section class="table-section">
        @if (count($employees))
            <h1>Employees list</h1>
            <div class="d_flex j_cnt__center check-matches">
                <a href="/matches">Check Matches</a>
            </div>

            <div class="table-container">
                <div class="tbl-header">
                    <table cellpadding="0" cellspacing="0" border="0">
                        <thead>
                            <tr>
                                <th class="small">Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Division</th>
                                <th>Age</th>
                                <th>Timezone</th>
                                <th>Recomendation</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="tbl-content">
                    <table cellpadding="0" cellspacing="0" border="0">
                        <tbody>
                            @foreach ($employees as $employee)
                                <tr>
                                    <td class="small">{{ $employee['id'] }}</td>
                                    <td>{{ $employee['name'] }}</td>
                                    <td>{{ $employee['email'] }}</td>
                                    <td>{{ $employee['division'] }}</td>
                                    <td>{{ $employee['age'] }}</td>
                                    <td>{{ $employee['timezone'] }}</td>
                                    <td class="recomend">
                                        <a href="/employee/{{$employee['id']}}/recomend" class="check-recomend">Check</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="pagination d_flex j_cnt__center">
                {{ $employees->links() }}
            </div>
        @else
            <h1>Employees list is empty</h1>
        @endif
    </section>

@endsection

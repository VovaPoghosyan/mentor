<!-- resources/views/employee.blade.php -->

@extends('layouts.app')

@section('title', 'Home')

@section('content')

    <section class="table-section">
        <h1>Recomendations for {{ $employee->name }}</h1>

        <div class="table-container">
            <div class="tbl-header">
                <table cellpadding="0" cellspacing="0" border="0">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Division</th>
                            <th>Age</th>
                            <th>Timezone</th>
                            <th>Percent</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="tbl-content">
                <table cellpadding="0" cellspacing="0" border="0">
                    <tbody>
                        @foreach ($recomendations as $employee)
                            <tr>
                                <td>{{ $employee['id'] }}</td>
                                <td>{{ $employee['name'] }}</td>
                                <td>{{ $employee['email'] }}</td>
                                <td>{{ $employee['division'] }}</td>
                                <td>{{ $employee['age'] }}</td>
                                <td>{{ $employee['timezone'] }}</td>
                                <td>{{ $employee['percent'] }} %</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

@endsection

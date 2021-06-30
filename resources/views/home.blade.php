@extends('layouts.master')

@section('title', 'Home')

@section('content')
<div class="container my-5 py-5">
    <table class="table table-bordered">
        <tbody>
            <tr class="text-center">
                <td>
                    <a href="{{ url('/sentences/admin@email.com') }}">Display data</a>
                </td>
                <td>
                    <a href="{{ url('/admin/login') }}">Edit data</a>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection

@extends('layouts.master')

@section('title', 'Sentences')

@section('content')
<div class="container my-5 py-5">
    <table class="table table-bordered">
        <tbody>
            @for ($i = 0; $i < $total_row; $i++)
            <tr>
                @for ($j = 0; $j < $total_column; $j++)
                @if($sentences[$i][$j] != false)
                <td class="text-center" style="{{ $sentences[$i][$j]->text_color != '' ? 'color:'.$sentences[$i][$j]->text_color.';' : '' }}{{ $sentences[$i][$j]->background_color != '' ? 'background-color:'.$sentences[$i][$j]->background_color.';' : '' }}">
                    {{$sentences[$i][$j]->value}}
                </td>
                @else
                <td class="text-center">

                </td>
                @endif
                @endfor
            </tr>
            @endfor
        </tbody>
    </table>
</div>
@endsection

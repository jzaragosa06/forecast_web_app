@extends('layouts.base')

@section('title', 'Public Files')

@section('page-title', 'Publicly Shared Time Series')


@section('content')
    <form action="{{ route('public-files.upload') }}" method="post" enctype="multipart/form-data">
        @csrf
        Title: <input type="text" name="title" id="">
        File: <input type="file" name="file" id="" accept=".csv, .xls, .xlsx">
        frequency: <select name="freq" id="">
            <option value="D">Daily</option>
            <option value="W">Weekly</option>
            <option value="M">Monthly</option>
            <option value="Q">Quarterly</option>
            <option value="Y">Yearly</option>
        </select>
        Description
        <textarea name="description" id="" cols="30" rows="10"></textarea>
        topics (comma separated): <input type="text" name="topics" id="">
        thumbnail: <input type="file" name="thumbnail" id="" accept=".jpg, .jpeg, .png">
        <button type="submit">Upload</button>

    </form>
@endsection


@section('scripts')

@endsection
